<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Wilayah_kecamatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Wilayah_kecamatan_model',
            'wilayah_kabupaten/Wilayah_kabupaten_model',
            'admin_menu/Admin_menu_model',
            'log/Log_model',
            'home/Home_model',
        ));
        $this->load->library(array(
            'form_validation',
        ));
        if (!$this->session->userdata('logged_in')) {
        	redirect('login', 'refresh');
        }
    }

    public function index()
    {
        // if (!$this->session->userdata('barang')) {
        //     return;
        // }
        $data = [
            'title'=>'Wilayah Kecamatan',
            'kabupaten_kota'=>$this->Wilayah_kabupaten_model->get_list_kab_kot_aktif(),
            'css'=>'<link href="'.base_url().'assets/css/pages/wilayah_kecamatan.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/wilayah_kecamatan.js"></script>',
            // 'css'=>'',
            // 'script'=>'',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('wilayah_kecamatan_view', $data);
        $this->load->view('home/template/footer', $data);
    }

    public function wilayah_kecamatan_list()
    {
        // if (!$this->session->userdata('barang')) {
        //     return;
        // }
        $list = $this->Wilayah_kecamatan_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $list) {

            $data_bind = '
                data-kecid="'.$list->kecid.'" 
                data-kecamatan="'.$list->kecamatan.'" 
                data-kabid="'.$list->kabid.'" 
                data-kabupaten_kota="'.$list->kabupaten_kota.'" 
                data-kodepos="'.$list->kodepos.'" 
                data-status="'.$list->status.'" 
            ';
            

            $icon = $list->status == '1' ? 'la la-close' : 'la la-check';
            $btn = $list->status == '1' ? 'btn-light-danger' : 'btn-light-success';


            $select = '';
            $select .='
                <a href="javascript:void(0);" class="non_active_record btn btn-sm btn-clean '.$btn.' btn-icon" 
                '.$data_bind.'
                ><i class="'.$icon.'"></i></a> 
        
                <a href="javascript:void(0);" class="edit_record btn btn-sm btn-clean btn-light-info btn-icon" 
                '.$data_bind.'
                ><i class="la la-edit"></i></a> 
            ';

            ++$no;
            $data[] = array(
                'no' => $no,
                'kecid' => $list->kecid,
                'kecamatan' => $list->kecamatan,
                'kabupaten_kota' => $list->kabupaten_kota,
                'kodepos' => $list->kodepos,
                'status' => $list->status,
                'action' => $select
            );
        }

        $output = array(
                        'draw' => $_POST['draw'],
                        'recordsTotal' => $this->Wilayah_kecamatan_model->count_all(),
                        'recordsFiltered' => $this->Wilayah_kecamatan_model->count_filtered(),
                        'data' => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    function save()
    {
        $this->form_validation->set_rules('kabid', str_replace(':', '', 'Nama Kota/Kabupaten'), 'required|trim');
        $this->form_validation->set_rules('kecamatan', str_replace(':', '', 'Nama Kecamatan'), 'required|trim');
        $this->form_validation->set_rules('kodepos', str_replace(':', '', 'Kode Pos'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');
        
        $type = $this->input->post('type');

        $kode=$this->Wilayah_kecamatan_model->generateIDKecamatan();

        $kecid = $type == 'add' ? $kode : $this->input->post('kecid');
        $kabid = $this->input->post('kabid');
        $kecamatan = $this->input->post('kecamatan');
        $kodepos = $this->input->post('kodepos');

        $data = [
            'kecid' => $kecid,
            'kabid' => $kabid,
            'kecamatan' => $kecamatan,
            'kodepos' => $kodepos,
        ];

        if ($type == 'edit') {
            $this->form_validation->set_rules('kabid', str_replace(':', '', 'ID'), 'required|trim');
        }

        if ($this->form_validation->run() === true) {
            if ($type == 'add') {
                $data['status'] = '1';
                $this->Wilayah_kecamatan_model->create($data);
                $this->Log_model->create(
                    'wilayah_kecamatan/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'tambah group berhasil...']);
                // echo json_encode($data);
            } 
            else if ($type == 'edit') {
                $this->Wilayah_kecamatan_model->update($data, 'kecid', $kecid);
                $this->Log_model->create(
                    'wilayah_kecamatan/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'edit group berhasil...']);

            }
        } else {
            $invalid = [
                'kecid' => form_error('kecid'),
                'kabid' => form_error('kabid'),
                'kecamatan' => form_error('kecamatan'),
                'kodepos' => form_error('kodepos'),
            ];
            $data = [
                'status' => false,
                'invalid' => $invalid,
            ];
            $this->Home_model->output_json($data);
        }
    }
    
    public function status($id)
    {
        $status = $this->input->post('status') == '1' ? '0' : '1';
        $data = [
            'status' => $status,
        ];
        $this->Wilayah_kecamatan_model->update($data, 'kecid', $id);
        $this->Log_model->create(
            'wilayah_kecamatan/status/' . $id,
            'status:' . $status
        );
        $this->Home_model->output_json(['status' => true]);
    }

    public function get_list_kecamatan_aktif()
    {
        $data = $this->Wilayah_kecamatan_model->get_list_kecamatan_aktif();
        echo json_encode($data);
    }

    public function get_kecamatan_by_id($id)
    {
        $data = $this->Wilayah_kecamatan_model->get_kecamatan_by_id($id);
        echo json_encode($data);
    }

    public function get_kecamatan_by_kabid($id)
    {
        $data = $this->Wilayah_kecamatan_model->get_kecamatan_by_kabid($id);
        echo json_encode($data);
    }
}
