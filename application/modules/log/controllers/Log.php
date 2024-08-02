<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Log_model',
            'admin_menu/Admin_menu_model',
            'home/Home_model',
        ]);
        $this->load->library(['form_validation']);
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url().'auth', 'refresh');
        }
    }

    public function index()
    {
        $data = [
            'title'=>'Log Activity',
            'css'=>'',
            'script'=>'<script src="'.base_url().'assets/js/pages/log.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('log/log_view', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    public function log_list()
    {
        $list = $this->Log_model->get_datatables();
        $data = array();
        $no = 0;
        
        foreach ($list as $list) {
            
            ++$no;
            $data[] = array(
                'no' => $no,
                'uid' => $list->uid,
                'controller' => $list->controller,
                'ip_address' => $list->ip_address,
                'desc' => $list->desc,
                'db_error' => $list->db_error,
                'timestamp' => $list->timestamp,
            );
            
            // $data[] = $row;
        }

        $output = array(
                'recordsTotal' => $this->Log_model->count_all(),
                'recordsFiltered' => $this->Log_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}