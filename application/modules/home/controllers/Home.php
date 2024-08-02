<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Home_model',
            'admin_menu/Admin_menu_model',
        ]);
        $this->load->library(['user_agent','datenumberconverter']);
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url().'auth', 'refresh');
        }
    }

    public function index()
    {
         $menu = $this->Admin_menu_model->get_list_menu_mobile_admin();
        if ($this->session->userdata('user_group') == '0002') {
            redirect(base_url().'stock_barang', 'refresh');
            $menu = $this->Admin_menu_model->get_list_menu_mobile();
        }
        if ($this->session->userdata('user_group') == '0003') {
            redirect(base_url().'order', 'refresh');
            $menu = $this->Admin_menu_model->get_list_menu_mobile();
        }
        if ($this->session->userdata('user_group') == '0004') {
            redirect(base_url().'ekspedisi', 'refresh');
            $menu = $this->Admin_menu_model->get_list_menu_mobile();
        }

        $data = [
            'title'=>'Home',
            'base_url' =>base_url(),
            'menu'=>$menu,
            'total_penjualan'=>$this->datenumberconverter->formatRupiah3($this->Home_model->get_total_penjualan()),
            'total_barang'=>$this->Home_model->get_total_barang(),
            'total_pelanggan'=>$this->Home_model->get_total_pelanggan(),
            'total_pemasok'=>$this->Home_model->get_total_pemasok(),
            'css'=>'<link href="'.base_url().'assets/css/pages/home.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/home.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('home/home_view', $data);
        $this->load->view('home/template/footer-mobile');
        $this->load->view('home/template/footer', $data);
        
    }

    public function get_penjualan_perbulan(){
        $list = $this->Home_model->get_penjualan_perbulan();
        foreach ($list as $list) {
            $data[] = array(
                "x" => $list->bulan_desc,
                "y" => $list->grand_total,
            );
        }
        echo json_encode($data);
    }
    
}