<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Admin_menu_model',
            'home/Home_model',
            'log/Log_model',
        ]);
        $this->load->library(['form_validation']);
      
    }

    public function index()
    {
        $data = [
            'title'=>'Group User',
            'css'=>'<link href="'.base_url().'assets/css/pages/tes.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/tes.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('tes2/tes_view', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    
    public function cek_akses_menu($url){
        $data = $this->Admin_menu_model->cek_akses_menu($url);
        if (!in_array($this->session->userdata('user_group'), $data)) {
            echo "tidak punya akses";
        }
    }    

    public function cek_menu($user_group, $menu_id){
        $data = $this->Admin_menu_model->cek_menu($user_group, $menu_id);
        echo json_encode($data);
    }    

}