<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Transaksi_model',
            'master_kategori_barang/Master_kategori_barang_model',
            'master_barang/Master_barang_model',
            'master_jenis_barang/Master_jenis_barang_model',
            'home/Home_model',
            'admin_menu/Admin_menu_model',
            'log/Log_model',
        ]);
        $this->load->library(['user_agent','form_validation','datenumberconverter','upload_custom']);
        if (!$this->session->userdata('logged_in') || !in_array($this->session->userdata('user_group'), $this->Admin_menu_model->cek_akses_menu('transaksi'))) {
            redirect(base_url().'auth', 'refresh');
        }
    }

    public function index()
    {
        $menu = $this->Admin_menu_model->get_list_menu_mobile_admin();
        if ($this->session->userdata('user_group') == '0002' || $this->session->userdata('user_group') == '0003' || $this->session->userdata('user_group') == '0004') {
            $menu = $this->Admin_menu_model->get_list_menu_mobile();
        } 

        $data = [
            'title'=>'Transaksi',
            'base_url' =>base_url(),
            'menu'=>$menu,
            'kategori'=>$this->Master_kategori_barang_model->get_list_master_kategori_barang_active(),
            'barang'=>$this->Master_barang_model->get_list_master_barang_active(),
            'jenis_barang'=>$this->Master_jenis_barang_model->get_list_master_jenis_barang_active(),
            'css'=>'<link href="'.base_url().'assets/css/pages/transaksi.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/transaksi.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('transaksi/transaksi_view', $data);
        $this->load->view('home/template/footer-mobile');
        $this->load->view('home/template/footer', $data);
        
    }

    public function get_list_order_checkout()
    {
        
        $list = $this->Transaksi_model->get_list_order_checkout();
        $html = '';
        
        foreach ($list as $list) {
                      
            if (!$list == null) {

                $str =$list->nama_jenis_barang;
                $pjng_nama = strlen($str);
                $nama_jenis_barang = substr($str,0,30);
                if ($pjng_nama > 28) {
                    $nama_jenis_barang = substr($str,0,28) . "...";
                }
                $photo = $list->photo == '' ? '<img src="'.base_url().'assets/media/users/blank2.png" alt="photo">' : '<img src="'.base_url().'upload/master_barang/'.$list->photo.'" alt="photo">';
                $class_st_order = '';
                
                

                $html .= '
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                        <div class="card card-custom card-stretch">
                            <div class="card-body p-5" >
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="label label-lg font-weight-bold abel-light-secondary label-inline">'.$list->status_order_desc.'</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="d-flex align-items-middle">
                                        <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                            <div class="symbol symbol-75">
                                                '.$photo .'
                                            </div>
                                        </div>                                        
                                        <div class="d-flex flex-column">
                                            <span class="text-muted font-weight-bold">'.$list->kategori_desc.'</span>
                                            <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h5 mb-0">'.$nama_jenis_barang.'</a>
                                            <a href="#" class="text-success text-hover-succes"> '.$this->datenumberconverter->IdnNumberFormat($list->qty_order).' Kg</a>
                                            <a href="#" class="text-primary font-weight-bold text-hover-primary">'.$this->datenumberconverter->formatRupiah($list->harga_total).'</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="separator separator-dashed mt-3 mb-3"></div>
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fas fa-user text-success"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->nama_lengkap.'
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fa fa-map-marker-alt text-danger"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->alamat_kirim.' 
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['html' => $html]);
    }
    public function get_list_order_packing()
    {
        
        $list = $this->Transaksi_model->get_list_order_packing();
        $html = '';
        
        foreach ($list as $list) {
                      
            if (!$list == null) {

                $str =$list->nama_jenis_barang;
                $pjng_nama = strlen($str);
                $nama_jenis_barang = substr($str,0,30);
                if ($pjng_nama > 28) {
                    $nama_jenis_barang = substr($str,0,28) . "...";
                }
                $photo = $list->photo == '' ? '<img src="'.base_url().'assets/media/users/blank2.png" alt="photo">' : '<img src="'.base_url().'upload/master_barang/'.$list->photo.'" alt="photo">';
                $class_st_order = '';
                
                

                $html .= '
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                        <div class="card card-custom card-stretch">
                            <div class="card-body p-5" >
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="label label-lg font-weight-bold abel-light-warning label-inline">'.$list->status_order_desc.'</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="d-flex align-items-middle">
                                        <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                            <div class="symbol symbol-75">
                                                '.$photo .'
                                            </div>
                                        </div>                                        
                                        <div class="d-flex flex-column">
                                            <span class="text-muted font-weight-bold">'.$list->kategori_desc.'</span>
                                            <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h5 mb-0">'.$nama_jenis_barang.'</a>
                                            <a href="#" class="text-success text-hover-succes"> '.$this->datenumberconverter->IdnNumberFormat($list->qty_order).' Kg</a>
                                            <a href="#" class="text-primary font-weight-bold text-hover-primary">'.$this->datenumberconverter->formatRupiah($list->harga_total).'</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="separator separator-dashed mt-3 mb-3"></div>
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fas fa-user text-success"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->nama_lengkap.'
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fa fa-map-marker-alt text-danger"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->alamat_kirim.' 
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['html' => $html]);
    }
    public function get_list_order_pengiriman()
    {
        
        $list = $this->Transaksi_model->get_list_order_pengiriman();
        $html = '';
        
        foreach ($list as $list) {
                      
            if (!$list == null) {

                $str =$list->nama_jenis_barang;
                $pjng_nama = strlen($str);
                $nama_jenis_barang = substr($str,0,30);
                if ($pjng_nama > 28) {
                    $nama_jenis_barang = substr($str,0,28) . "...";
                }
                $photo = $list->photo == '' ? '<img src="'.base_url().'assets/media/users/blank2.png" alt="photo">' : '<img src="'.base_url().'upload/master_barang/'.$list->photo.'" alt="photo">';
                $class_st_order = '';
                
                

                $html .= '
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                        <div class="card card-custom card-stretch">
                            <div class="card-body p-5" >
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="label label-lg font-weight-bold label-light-info label-inline">'.$list->status_order_desc.'</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="d-flex align-items-middle">
                                        <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                            <div class="symbol symbol-75">
                                                '.$photo .'
                                            </div>
                                        </div>                                        
                                        <div class="d-flex flex-column">
                                            <span class="text-muted font-weight-bold">'.$list->kategori_desc.'</span>
                                            <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h5 mb-0">'.$nama_jenis_barang.'</a>
                                            <a href="#" class="text-success text-hover-succes"> '.$this->datenumberconverter->IdnNumberFormat($list->qty_order).' Kg</a>
                                            <a href="#" class="text-primary font-weight-bold text-hover-primary">'.$this->datenumberconverter->formatRupiah($list->harga_total).'</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="separator separator-dashed mt-3 mb-3"></div>
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fas fa-user text-success"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->nama_lengkap.'
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fa fa-map-marker-alt text-danger"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->alamat_kirim.' 
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['html' => $html]);
    }
    public function get_list_order_lunas()
    {
        
        $list = $this->Transaksi_model->get_list_order_lunas();
        $html = '';
        
        foreach ($list as $list) {
                      
            if (!$list == null) {

                $str =$list->nama_jenis_barang;
                $pjng_nama = strlen($str);
                $nama_jenis_barang = substr($str,0,30);
                if ($pjng_nama > 28) {
                    $nama_jenis_barang = substr($str,0,28) . "...";
                }
                $photo = $list->photo == '' ? '<img src="'.base_url().'assets/media/users/blank2.png" alt="photo">' : '<img src="'.base_url().'upload/master_barang/'.$list->photo.'" alt="photo">';
                $class_st_order = '';
                
                

                $html .= '
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                        <div class="card card-custom card-stretch">
                            <div class="card-body p-5" >
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="label label-lg font-weight-bold label-light-warning label-inline">'.$list->status_order_desc.'</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="d-flex align-items-middle">
                                        <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                            <div class="symbol symbol-75">
                                                '.$photo .'
                                            </div>
                                        </div>                                        
                                        <div class="d-flex flex-column">
                                            <span class="text-muted font-weight-bold">'.$list->kategori_desc.'</span>
                                            <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h5 mb-0">'.$nama_jenis_barang.'</a>
                                            <a href="#" class="text-success text-hover-succes"> '.$this->datenumberconverter->IdnNumberFormat($list->qty_order).' Kg</a>
                                            <a href="#" class="text-primary font-weight-bold text-hover-primary">'.$this->datenumberconverter->formatRupiah($list->harga_total).'</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="separator separator-dashed mt-3 mb-3"></div>
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fas fa-user text-success"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->nama_lengkap.'
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fa fa-map-marker-alt text-danger"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->alamat_kirim.' 
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['html' => $html]);
    }
    public function get_list_order_done()
    {
        
        $list = $this->Transaksi_model->get_list_order_done();
        $html = '';
        
        foreach ($list as $list) {
                      
            if (!$list == null) {

                $str =$list->nama_jenis_barang;
                $pjng_nama = strlen($str);
                $nama_jenis_barang = substr($str,0,30);
                if ($pjng_nama > 28) {
                    $nama_jenis_barang = substr($str,0,28) . "...";
                }
                $photo = $list->photo == '' ? '<img src="'.base_url().'assets/media/users/blank2.png" alt="photo">' : '<img src="'.base_url().'upload/master_barang/'.$list->photo.'" alt="photo">';
                $class_st_order = '';
                
                

                $html .= '
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                        <div class="card card-custom card-stretch">
                            <div class="card-body p-5" >
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="label label-lg font-weight-bold label-light-primary label-inline">'.$list->status_order_desc.'</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="d-flex align-items-middle">
                                        <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                            <div class="symbol symbol-75">
                                                '.$photo .'
                                            </div>
                                        </div>                                        
                                        <div class="d-flex flex-column">
                                            <span class="text-muted font-weight-bold">'.$list->kategori_desc.'</span>
                                            <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h5 mb-0">'.$nama_jenis_barang.'</a>
                                            <a href="#" class="text-success text-hover-succes"> '.$this->datenumberconverter->IdnNumberFormat($list->qty_order).' Kg</a>
                                            <a href="#" class="text-primary font-weight-bold text-hover-primary">'.$this->datenumberconverter->formatRupiah($list->harga_total).'</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="separator separator-dashed mt-3 mb-3"></div>
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fas fa-user text-success"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->nama_lengkap.'
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fa fa-map-marker-alt text-danger"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->alamat_kirim.' 
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['html' => $html]);
    }
    public function get_list_order_cancel()
    {
        
        $list = $this->Transaksi_model->get_list_order_cancel();
        $html = '';
        
        foreach ($list as $list) {
                      
            if (!$list == null) {

                $str =$list->nama_jenis_barang;
                $pjng_nama = strlen($str);
                $nama_jenis_barang = substr($str,0,30);
                if ($pjng_nama > 28) {
                    $nama_jenis_barang = substr($str,0,28) . "...";
                }
                $photo = $list->photo == '' ? '<img src="'.base_url().'assets/media/users/blank2.png" alt="photo">' : '<img src="'.base_url().'upload/master_barang/'.$list->photo.'" alt="photo">';
                $class_st_order = '';
                
                

                $html .= '
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                        <div class="card card-custom card-stretch">
                            <div class="card-body p-5" >
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="label label-lg font-weight-bold label-light-danger label-inline">'.$list->status_order_desc.'</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="d-flex align-items-middle">
                                        <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                            <div class="symbol symbol-75">
                                                '.$photo .'
                                            </div>
                                        </div>                                        
                                        <div class="d-flex flex-column">
                                            <span class="text-muted font-weight-bold">'.$list->kategori_desc.'</span>
                                            <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h5 mb-0">'.$nama_jenis_barang.'</a>
                                            <a href="#" class="text-success text-hover-succes"> '.$this->datenumberconverter->IdnNumberFormat($list->qty_order).' Kg</a>
                                            <a href="#" class="text-primary font-weight-bold text-hover-primary">'.$this->datenumberconverter->formatRupiah($list->harga_total).'</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <div class="separator separator-dashed mt-3 mb-3"></div>
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fas fa-user text-success"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->nama_lengkap.'
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-0">
                                    <div class="d-flex justify-content-left align-items-middle">
                                        <i class="fa fa-map-marker-alt text-danger"></i> 
                                        <span class="text-dark-75 pl-2"> 
                                            '.$list->alamat_kirim.' 
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['html' => $html]);
    }


}