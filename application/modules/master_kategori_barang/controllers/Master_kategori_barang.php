<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_kategori_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Master_kategori_barang_model',
            'home/Home_model',
            'admin_menu/Admin_menu_model',
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
            'title'=>'Master Kategori Barang',
            'css'=>'<link href="'.base_url().'assets/css/pages/master_kategori_barang.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/master_kategori_barang.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('master_kategori_barang/master_kategori_barang_view', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    public function master_kategori_barang_list()
    {
        $list = $this->Master_kategori_barang_model->get_datatables();
        $data = array();
        $no = 0;
        
        foreach ($list as $list) {
            $data_bind = '
                data-kategori_id="'.$list->kategori_id.'" 
                data-kategori_desc="'.$list->kategori_desc.'" 
                data-urutan="'.$list->urutan.'"  
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
                'kategori_id' => $list->kategori_id,
                'kategori_desc' => $list->kategori_desc,
                'urutan' => $list->urutan,
                'status' => $list->status,
                'action' => $select
            );
            
            // $data[] = $row;
        }

        $output = array(
                'recordsTotal' => $this->Master_kategori_barang_model->count_all(),
                'recordsFiltered' => $this->Master_kategori_barang_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function save()
    {
        $this->form_validation->set_rules('kategori_desc', str_replace(':', '', 'Kategori'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');
        
        $type = $this->input->post('type');

        $kode=$this->Master_kategori_barang_model->generateIKategori();

        $kategori_id = $type == 'add' ? $this->Master_kategori_barang_model->generateIKategori() : $this->input->post('kategori_id');
        $kategori_desc = $this->input->post('kategori_desc');
        $urutan = $this->input->post('urutan');

        $data = [
            'kategori_id' => $kategori_id,
            'kategori_desc' => $kategori_desc,
            'urutan' => $urutan,
        ];

        if ($type == 'edit') {
            $this->form_validation->set_rules('kategori_id', str_replace(':', '', 'ID'), 'required|trim');
        }

        if ($this->form_validation->run() === true) {
            if ($type == 'add') {
                $data['status'] = 'y';
                $this->Master_kategori_barang_model->create($data);
                $this->Log_model->create(
                    'master_kategori_barang/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'tambah group berhasil...']);
            } 
            else if ($type == 'edit') {
                $this->Master_kategori_barang_model->update($data, 'kategori_id', $kategori_id);
                $this->Log_model->create(
                    'master_kategori_barang/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'edit group berhasil...']);

            }
        } else {
            $invalid = [
                'kategori_id' => form_error('kategori_id'),
                'kategori_desc' => form_error('kategori_desc'),
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
        $this->Master_kategori_barang_model->update($data, 'kategori_id', $id);
        $this->Log_model->create(
            'master_kategori_barang/status/' . $id,
            'status:' . $status
        );
        $this->Home_model->output_json(['status' => true]);
    }
}