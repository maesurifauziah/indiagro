<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_pasar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Master_pasar_model',
            'wilayah_provinsi/Wilayah_provinsi_model',
            'wilayah_kabupaten/Wilayah_kabupaten_model',
            'wilayah_kecamatan/Wilayah_kecamatan_model',
            'admin_menu/Admin_menu_model',
            'home/Home_model',
            'log/Log_model',
        ]);
        $this->load->library(['form_validation']);
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url().'auth', 'refresh');
        }
    }

    public function index()
    {
        $data = [
            'title'=>'Master Pasar',
            'provinsi'=>$this->Wilayah_provinsi_model->get_list_provinsi_aktif(),
            'kabupaten_kota'=>$this->Wilayah_kabupaten_model->get_list_kab_kot_aktif(),
            'kecamatan'=>$this->Wilayah_kecamatan_model->get_list_kecamatan_aktif(),
            'css'=>'<link href="'.base_url().'assets/css/pages/master_pasar.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/master_pasar.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('master_pasar/master_pasar_view', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    public function master_pasar_list()
    {
        $list = $this->Master_pasar_model->get_datatables();
        $data = array();
        $no = 0;
        
        foreach ($list as $list) {
            $data_bind = '
                data-pasar_id="'.$list->pasar_id.'" 
                data-pasar_desc="'.$list->pasar_desc.'" 
                data-propid="'.$list->propid.'"  
                data-propinsi_desc="'.$list->propinsi_desc.'"  
                data-kabid="'.$list->kabid.'"  
                data-kabupaten_kota="'.$list->kabupaten_kota.'"  
                data-kecid="'.$list->kecid.'"  
                data-kecamatan="'.$list->kecamatan.'"  
                data-status="'.$list->status.'"  
            ';

            $icon = $list->status == 'y' ? 'la la-close' : 'la la-check';
            $btn = $list->status == 'y' ? 'btn-light-danger' : 'btn-light-success';


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
                'pasar_id' => $list->pasar_id,
                'pasar_desc' => $list->pasar_desc,
                'propinsi_desc' => $list->propinsi_desc,
                'kabupaten_kota' => $list->kabupaten_kota,
                'kecamatan' => $list->kecamatan,
                'status' => $list->status,
                'action' => $select
            );
            
            // $data[] = $row;
        }

        $output = array(
                'recordsTotal' => $this->Master_pasar_model->count_all(),
                'recordsFiltered' => $this->Master_pasar_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function save()
    {
        $this->form_validation->set_rules('pasar_desc', str_replace(':', '', 'Nama Pasar'), 'required|trim');
        $this->form_validation->set_rules('propid', str_replace(':', '', 'Provinsi'), 'required|trim');
        $this->form_validation->set_rules('kabid', str_replace(':', '', 'Kabupaten/Kota'), 'required|trim');
        $this->form_validation->set_rules('kecid', str_replace(':', '', 'Kecamatan'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');
        
        $type = $this->input->post('type');

        $kode=$this->Master_pasar_model->generateIDPasar();

        $pasar_id = $type == 'add' ? $kode : $this->input->post('pasar_id');
        $pasar_desc = $this->input->post('pasar_desc');
        $propid = $this->input->post('propid');
        $kabid = $this->input->post('kabid');
        $kecid = $this->input->post('kecid');

        $data = [
            'pasar_id' => $pasar_id,
            'pasar_desc' => $pasar_desc,
            'propid' => $propid,
            'kabid' => $kabid,
            'kecid' => $kecid,
        ];

        if ($type == 'edit') {
            $this->form_validation->set_rules('pasar_id', str_replace(':', '', 'ID'), 'required|trim');
        }

        if ($this->form_validation->run() === true) {
            if ($type == 'add') {
                $data['status'] = 'y';
                $this->Master_pasar_model->create($data);
                $this->Log_model->create(
                    'master_pasar/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'tambah group berhasil...']);
            } 
            else if ($type == 'edit') {
                $this->Master_pasar_model->update($data, 'pasar_id', $pasar_id);
                $this->Log_model->create(
                    'master_pasar/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'edit group berhasil...']);

            }
        } else {
            $invalid = [
                'pasar_id' => form_error('pasar_id'),
                'propid' => form_error('propid'),
                'kabid' => form_error('kabid'),
                'kecid' => form_error('kecid'),
                'pasar_desc' => form_error('pasar_desc'),
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
        $status = $this->input->post('status') == 'y' ? 'n' : 'y';
        $data = [
            'status' => $status,
        ];
        $this->Master_pasar_model->update($data, 'pasar_id', $id);
        $this->Log_model->create(
            'master_pasar/status/' . $id,
            'status:' . $status
        );
        $this->Home_model->output_json(['status' => true]);
    }

    public function get_list_master_pasar_active()
    {
        $data = $this->Master_pasar_model->get_list_master_pasar_active();
        echo json_encode($data);
    }

    public function get_pasar_by_kecid($id)
    {
        $data = $this->Master_pasar_model->get_pasar_by_kecid($id);
        echo json_encode($data);
    }

    
    
}