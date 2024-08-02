<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Wilayah_provinsi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Wilayah_provinsi_model',
            'log/Log_model',
            'home/Home_model',
            'admin_menu/Admin_menu_model',
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
            'title'=>'Wilayah Provinsi',
            'css'=>'<link href="'.base_url().'assets/css/pages/wilayah_provinsi.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/wilayah_provinsi.js"></script>',
            // 'css'=>'',
            // 'script'=>'',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('wilayah_provinsi_view', $data);
        $this->load->view('home/template/footer', $data);
    }

    public function wilayah_provinsi_list()
    {
        $list = $this->Wilayah_provinsi_model->get_datatables();
        $data = array();
        $no = 0;
        
        foreach ($list as $list) {
            $data_bind = '
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
                'propid' => $list->propid,
                'propinsi_desc' => $list->propinsi_desc,
                'status' => $list->status,
                'action' => $select
            );
            
            // $data[] = $row;
        }

        $output = array(
                'recordsTotal' => $this->Wilayah_provinsi_model->count_all(),
                'recordsFiltered' => $this->Wilayah_provinsi_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function save()
    {
        $this->form_validation->set_rules('propinsi_desc', str_replace(':', '', 'Nama Provinsi'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');
        
        $type = $this->input->post('type');

        $kode=$this->Wilayah_provinsi_model->generateIDProvinsi();

        $propid = $type == 'add' ? $kode : $this->input->post('propid');
        $propinsi_desc = $this->input->post('propinsi_desc');

        $data = [
            'propid' => $propid,
            'propinsi_desc' => $propinsi_desc,
        ];

        if ($type == 'edit') {
            $this->form_validation->set_rules('propid', str_replace(':', '', 'ID'), 'required|trim');
        }

        if ($this->form_validation->run() === true) {
            if ($type == 'add') {
                $data['status'] = '1';
                $this->Wilayah_provinsi_model->create($data);
                $this->Log_model->create(
                    'admin_group_user/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'tambah group berhasil...']);
                // echo json_encode($data);
            } 
            else if ($type == 'edit') {
                $this->Wilayah_provinsi_model->update($data, 'propid', $propid);
                $this->Log_model->create(
                    'admin_group_user/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'edit group berhasil...']);

            }
        } else {
            $invalid = [
                'propid' => form_error('propid'),
                'propinsi_desc' => form_error('propinsi_desc'),
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
        $this->Wilayah_provinsi_model->update($data, 'propid', $id);
        $this->Log_model->create(
            'wilayah_provisi/status/' . $id,
            'status:' . $status
        );
        $this->Home_model->output_json(['status' => true]);
    }

    public function get_list_provinsi_aktif()
    {
        $data = $this->Wilayah_provinsi_model->get_list_provinsi_aktif();
        echo json_encode($data);
    }

    public function get_provinsi_by_id($id)
    {
        $data = $this->Wilayah_provinsi_model->get_provinsi_by_id($id);
        echo json_encode($data);
    }

    public function tes()
    {
        $kode=$this->Wilayah_provinsi_model->generateIDProvinsi();
        echo json_encode($kode);
    }
}
