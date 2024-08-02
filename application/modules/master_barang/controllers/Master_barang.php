<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Master_barang_model',
            'home/Home_model',
            'order/Order_model',
            'master_kategori_barang/Master_kategori_barang_model',
            'admin_menu/Admin_menu_model',
            'log/Log_model',
        ]);
        $this->load->library(['form_validation','datenumberconverter']);
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url().'auth', 'refresh');
        }
    }

    public function index()
    {
        $data = [
            'title'=>'Master Barang',
            'kategori'=>$this->Master_kategori_barang_model->get_list_master_kategori_barang_active(),
            'css'=>'<link href="'.base_url().'assets/css/pages/master_barang.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/master_barang.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('master_barang/master_barang_view', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    public function master_barang_list()
    {
        $list = $this->Master_barang_model->get_datatables();
        $data = array();
        $no = 0;
        
        foreach ($list as $list) {
            $data_bind = '
                data-kode_barang="'.$list->kode_barang.'" 
                data-nama_barang="'.$list->nama_barang.'" 
                data-kategori_id="'.$list->kategori_id.'"  
                data-createdDate="'.$list->createdDate.'"  
                data-status="'.$list->status.'"  
                data-kategori_desc="'.$list->kategori_desc.'"  
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
                'kategori_desc' => $list->kategori_desc,
                'kode_barang' => $list->kode_barang,
                'nama_barang' => $list->nama_barang,
                'status' => $list->status,
                'action' => $select
            );
            
            // $data[] = $row;
        }

        $output = array(
                'recordsTotal' => $this->Master_barang_model->count_all(),
                'recordsFiltered' => $this->Master_barang_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function save()
    {
        $this->form_validation->set_rules('nama_barang', str_replace(':', '', 'Nama Barang'), 'required|trim');
        $this->form_validation->set_rules('kategori_id', str_replace(':', '', 'Kategori'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');
        
        $type = $this->input->post('type');

        $kode=$this->Master_barang_model->generateIDBarang();

        $kode_barang = $type == 'add' ? $kode : $this->input->post('kode_barang');
        $nama_barang = $this->input->post('nama_barang');
        $kategori_id = $this->input->post('kategori_id');

        $data = [
            'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'kategori_id' => $kategori_id,
        ];

        if ($type == 'edit') {
            $this->form_validation->set_rules('kode_barang', str_replace(':', '', 'ID'), 'required|trim');
        }

        if ($this->form_validation->run() === true) {
            if ($type == 'add') {
                $data['createdDate'] = date('Y-m-d H:i:s');
                $data['status'] = 'y';
                $this->Master_barang_model->create($data);
                $this->Log_model->create(
                    'master_barang/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'tambah group berhasil...']);
            } 
            else if ($type == 'edit') {
                $this->Master_barang_model->update($data, 'kode_barang', $kode_barang);
                $this->Log_model->create(
                    'master_barang/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'edit group berhasil...']);

            }
        } else {
            $invalid = [
                'kode_barang' => form_error('kode_barang'),
                'nama_barang' => form_error('nama_barang'),
                'kategori_id' => form_error('kategori_id'),
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
        $this->Master_barang_model->update($data, 'kode_barang', $id);
        $this->Log_model->create(
            'master_barang/status/' . $id,
            'status:' . $status
        );
        $this->Home_model->output_json(['status' => true]);
    }
    
    public function get_detail_jenis_barang($kode_barang)
    {
        $data = $this->Master_barang_model->get_detail_jenis_barang($kode_barang);
        echo json_encode($data);
    }

    public function get_barang_by_kategori($kategori_id)
    {
        $data = $this->Master_barang_model->get_barang_by_kategori($kategori_id);
        echo json_encode($data);
    }
}