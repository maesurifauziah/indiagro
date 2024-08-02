<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Wilayah_kabupaten extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Wilayah_kabupaten_model',
            'wilayah_provinsi/Wilayah_provinsi_model',
            'log/Log_model',
            'admin_menu/Admin_menu_model',
            'home/Home_model',
        ));
        $this->load->library(array(
            'form_validation',
        ));
        if (!$this->session->userdata('logged_in')) {
        	redirect('auth', 'refresh');
        }
    }

    public function index()
    {
      
        $data = [
            'title'=>'Wilayah Kabupaten',
            'provinsi'=>$this->Wilayah_provinsi_model->get_list_provinsi_aktif(),
            'css'=>'<link href="'.base_url().'assets/css/pages/wilayah_kabupaten.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/wilayah_kabupaten.js"></script>',
            // 'css'=>'',
            // 'script'=>'',
        ];
        $this->load->view('home/template/head', $data);
        $this->load->view('wilayah_kabupaten_view', $data);
        $this->load->view('home/template/footer', $data);
    }

    public function wilayah_kabupaten_list()
    {
        $list = $this->Wilayah_kabupaten_model->get_datatables();
        $data = array();
        $no = 0;
        foreach ($list as $list) {
           
            $data_bind = '
                data-kabid="'.$list->kabid.'" 
                data-tipe_kab_kota="'.$list->tipe_kab_kota.'" 
                data-kabupaten_kota="'.$list->kabupaten_kota.'" 
                data-propid="'.$list->propid.'" 
                data-propinsi_desc="'.$list->propinsi_desc.'" 
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
                'kabid' => $list->kabid,
                'tipe_kab_kota' => $list->tipe_kab_kota == '1' ? 'KABUPATEN' : 'KOTA',
                'kabupaten_kota' => $list->kabupaten_kota,
                'propinsi_desc' => $list->propinsi_desc,
                'status' => $list->status,
                'action' => $select
            );
        }

        $output = array(
                        'draw' => $_POST['draw'],
                        'recordsTotal' => $this->Wilayah_kabupaten_model->count_all(),
                        'recordsFiltered' => $this->Wilayah_kabupaten_model->count_filtered(),
                        'data' => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    function save()
    {
        $this->form_validation->set_rules('tipe_kab_kota', str_replace(':', '', 'Tipe'), 'required|trim');
        $this->form_validation->set_rules('kabupaten_kota', str_replace(':', '', 'Nama Kota/Kabupaten'), 'required|trim');
        $this->form_validation->set_rules('propid', str_replace(':', '', 'Provinsi'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');
        
        $type = $this->input->post('type');

        $kode=$this->Wilayah_kabupaten_model->generateIDKabupaten();

        $kabid = $type == 'add' ? $kode : $this->input->post('kabid');
        $tipe_kab_kota = $this->input->post('tipe_kab_kota') == 'kabupaten' ? '1' : '0';
        $kabupaten_kota = $this->input->post('kabupaten_kota');
        $propid = $this->input->post('propid');

        $data = [
            'kabid' => $kabid,
            'tipe_kab_kota' => $tipe_kab_kota,
            'kabupaten_kota' => $kabupaten_kota,
            'propid' => $propid,
        ];

        if ($type == 'edit') {
            $this->form_validation->set_rules('kabid', str_replace(':', '', 'ID'), 'required|trim');
        }

        if ($this->form_validation->run() === true) {
            if ($type == 'add') {
                $data['status'] = '1';
                $this->Wilayah_kabupaten_model->create($data);
                $this->Log_model->create(
                    'wilayah_kabupaten/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'tambah group berhasil...']);
                // echo json_encode($data);
            } 
            else if ($type == 'edit') {
                $this->Wilayah_kabupaten_model->update($data, 'kabid', $kabid);
                $this->Log_model->create(
                    'wilayah_kabupaten/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'edit group berhasil...']);

            }
        } else {
            $invalid = [
                'kabid' => form_error('kabid'),
                'tipe_kab_kota' => form_error('tipe_kab_kota'),
                'kabupaten_kota' => form_error('kabupaten_kota'),
                'propid' => form_error('propid'),
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
        $this->Wilayah_kabupaten_model->update($data, 'kabid', $id);
        $this->Log_model->create(
            'wilayah_labupaten/status/' . $id,
            'status:' . $status
        );
        $this->Home_model->output_json(['status' => true]);
    }

    public function get_list_kab_kot_aktif()
    {
        $data = $this->Wilayah_kabupaten_model->get_list_kab_kot_aktif();
        echo json_encode($data);
    }

    public function get_kab_kot_by_propid($id)
    {
        $data = $this->Wilayah_kabupaten_model->get_kab_kot_by_propid($id);
        echo json_encode($data);
    }
}
