<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ekspedisi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Ekspedisi_model',
            'master_kategori_barang/Master_kategori_barang_model',
            'master_barang/Master_barang_model',
            'master_jenis_barang/Master_jenis_barang_model',
            'transaksi_admin/Transaksi_admin_model',
            'home/Home_model',
            'admin_menu/Admin_menu_model',
            'log/Log_model',
        ]);
        $this->load->library(['user_agent','form_validation','datenumberconverter','upload_custom']);
        if (!$this->session->userdata('logged_in') || !in_array($this->session->userdata('user_group'), $this->Admin_menu_model->cek_akses_menu('ekspedisi'))) {
            redirect(base_url().'auth', 'refresh');
        }
    }

    public function index()
    {
        $menu = $this->Admin_menu_model->get_list_menu_mobile_admin();
        $title = 'Ekspedisi';
        if ($this->session->userdata('user_group') == '0002' || $this->session->userdata('user_group') == '0003' || $this->session->userdata('user_group') == '0004') {
            $menu = $this->Admin_menu_model->get_list_menu_mobile();
            $title = 'Home';
        }
       
        $data = [
            'title'=>$title,
            'base_url' =>base_url(),
            'menu'=>$menu,
            'kategori'=>$this->Master_kategori_barang_model->get_list_master_kategori_barang_active(),
            'barang'=>$this->Master_barang_model->get_list_master_barang_active(),
            'jenis_barang'=>$this->Master_jenis_barang_model->get_list_master_jenis_barang_active(),
            'css'=>'<link href="'.base_url().'assets/css/pages/ekspedisi.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/ekspedisi.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('ekspedisi/ekspedisi_view', $data);
        $this->load->view('home/template/footer-mobile');
        $this->load->view('home/template/footer', $data);
        
    }

   

    public function get_list_order_ready_delivery()
    {
        
        // $typeTerm = 'all';
        // $searchTerm = '';
        
        $date_start = $this->input->get('date_start', true);
        $date_end = $this->input->get('date_end', true);
        $status_order = $this->input->get('status_order', true);
        $list = $this->Ekspedisi_model->get_list_order_ready_delivery($date_start, $date_end, $status_order);
        $html = '';
        
        foreach ($list as $list) {
            $data_bind = '
                data-trans_id="'.$list->trans_id.'" 
                data-order_id="'.$list->order_id.'" 
                data-userid="'.$list->userid.'" 
                data-nama_lengkap="'.$list->nama_lengkap.'" 
                data-detailid="'.$list->detailid.'" 
                data-kategori_id="'.$list->kategori_id.'" 
                data-kategori_desc="'.$list->kategori_desc.'" 
                data-kode_barang="'.$list->kode_barang.'" 
                data-nama_barang="'.$list->nama_barang.'" 
                data-kode_jenis_barang="'.$list->kode_jenis_barang.'" 
                data-nama_jenis_barang="'.$list->nama_jenis_barang.'" 
                data-harga="'.$list->harga.'" 
                data-qty="'.$list->qty.'" 
                data-harga_total="'.$list->harga_total.'" 
                data-qty_order="'.$list->qty_order.'" 
                data-status="'.$list->status.'" 
                data-status_order="'.$list->status_order.'" 
                data-status_order_desc="'.$list->status_order_desc.'" 
                data-createdDate="'.$list->createdDate.'" 
                data-createdDatePacking="'.$list->createdDatePacking.'" 
                data-createdStatusPacking="'.$list->createdStatusPacking.'" 
                data-createdByPengiriman="'.$list->createdByPengiriman.'" 
                data-createdDatePengiriman="'.$list->createdDatePengiriman.'" 
                data-createdStatusPengiriman="'.$list->createdStatusPengiriman.'" 
                data-createdByLunas="'.$list->createdByLunas.'" 
                data-createdDateLunas="'.$list->createdDateLunas.'" 
                data-createdStatusLunas="'.$list->createdStatusLunas.'" 
                data-createdDateDone="'.$list->createdDateDone.'" 
                data-createdStatusDone="'.$list->createdStatusDone.'"  
                data-createdDateCancel="'.$list->createdDateCancel.'"  
                data-createdStatusCancel="'.$list->createdStatusCancel.'"  
                data-createCancelNote="'.$list->createCancelNote.'"  
                data-kurir_id="'.$list->kurir_id.'"  
                data-nama_kurir="'.$list->nama_kurir.'"  
                data-photo="'.$list->photo.'"  
                data-path_photo="'.base_url('upload/master_barang/'.$list->photo).'"  
                data-alamat_kirim="'.$list->alamat_kirim.'"  
               
            ';

            
            if (!$list == null) {

                $str =$list->nama_jenis_barang;
                $pjng_nama = strlen($str);
                $nama_jenis_barang = substr($str,0,30);
                if ($pjng_nama > 28) {
                    $nama_jenis_barang = substr($str,0,28) . "...";
                }
                $photo = $list->photo == '' ? '<img src="'.base_url().'assets/media/users/blank2.png" alt="photo">' : '<img src="'.base_url().'upload/master_barang/'.$list->photo.'" alt="photo">';
                $btn_action = '';
                $class_st_order = '';

                if ($list->status_order != 'done') {
                    if ($list->status_order == 'checkout') {
                        $btn_action .='
                            <a href="javascript:void(0);" class="packing_record btn btn-sm btn-clean btn-light-warning btn-icon" title="Packing"  
                            '.$data_bind.'
                            ><i class="fas fa-box"></i></a> 
                        ';
                    }
                    if ($list->status_order == 'packing') {
                        $btn_action .='
                            <a href="javascript:void(0);" class="pengiriman_record btn btn-sm btn-clean btn-light-info btn-icon" title="Kirim"  
                            '.$data_bind.'
                            ><i class="fas fa-shipping-fast"></i></a> 
                        ';
                    }
                    if ($list->status_order == 'pengiriman') {
                        $btn_action .='
                            <a href="javascript:void(0);" class="lunas_record btn btn-sm btn-clean btn-light-warning btn-icon" title="Lunas"  
                            '.$data_bind.'
                            ><i class="fas fa-money-check-alt"></i></a> 
                        ';
                    }
                    if ($list->status_order == 'lunas') {
                        $btn_action .='
                            <a href="javascript:void(0);" class="done_record btn btn-sm btn-clean btn-light-primary btn-icon" title="Selesai"  
                            '.$data_bind.'
                            ><i class="fas fa-check"></i></a> 
                        ';
                    }
                    if ($list->status_order != 'cancel') {
                        $btn_action .='
                            <a href="javascript:void(0);" class="cancel_record btn btn-sm btn-clean btn-light-danger btn-icon" title="Cancel"  
                            '.$data_bind.'
                            ><i class="fas fa-times"></i></a> 
                        ';
                    }
                }
                if ($list->status_order == 'done') {
                    $class_st_order = 'label-light-primary';
                }
                if ($list->status_order == 'checkout') {
                   $class_st_order = 'label-light-success';
                }
                if ($list->status_order == 'packing') {
                   $class_st_order = 'label-light-warning';
                }
                if ($list->status_order == 'pengiriman') {
                   $class_st_order = 'label-light-info';
                }
                if ($list->status_order == 'lunas') {
                   $class_st_order = 'label-light-warning';
                }
                if ($list->status_order == 'cancel') {
                   $class_st_order = 'label-light-danger';
                }

                $html .= '
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                        <div class="card card-custom card-stretch">
                            <div class="card-body p-5 detail_record" '.$data_bind.'>
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="label label-lg font-weight-bold '.$class_st_order.' label-inline">'.$list->status_order_desc.'</span>
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
                                        <div class="flex-shrink-0 ml-25 ml-lg-15 mt-15">
                                            '.$btn_action.'
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

    public function kirim()
    {
        $order_id = $this->input->post('order_id');
     
        $data = [
            'createdDatePengiriman' => date('Y-m-d H:i:s'),
            'createdByPengiriman' => $this->session->userdata('userid'),
            'createdStatusPengiriman' => 'y',
            'status_order' => 'pengiriman',
        ];
        $this->Transaksi_admin_model->update($data, 'order_id', $order_id);
        $this->Log_model->create(
            'transaksi_admin/kirim',
            '#data:' . json_encode($order_id)
        );
        $this->Home_model->output_json(['status' => true]);
    }
    public function lunas()
    {
        $order_id = $this->input->post('order_id');
     
        $data = [
            'createdDateLunas' => date('Y-m-d H:i:s'),
            'createdByLunas' => $this->session->userdata('userid'),
            'createdStatusLunas' => 'y',
            'status_order' => 'lunas',
        ];
        $this->Transaksi_admin_model->update($data, 'order_id', $order_id);
        $this->Log_model->create(
            'transaksi_admin/lunas',
            '#data:' . json_encode($order_id)
        );
        $this->Home_model->output_json(['status' => true]);
    }
    public function done()
    {
        $order_id = $this->input->post('order_id');
        $kode_jenis_barang = $this->input->post('kode_jenis_barang');
        $qty = $this->input->post('qty');
        $qty_order = $this->input->post('qty_order');
        
     
        $data = [
            'createdDateDone' => date('Y-m-d H:i:s'),
            'createdByDone' => $this->session->userdata('userid'),
            'createdStatusDone' => 'y',
            'status_order' => 'done',
        ];
        $this->Transaksi_admin_model->update($data, 'order_id', $order_id);
        $this->Log_model->create(
            'transaksi_admin/done',
            '#data:' . json_encode($order_id)
        );

        // $data_update = [
        //     'qty' => $qty-$qty_order,
        // ];

        // $this->Master_jenis_barang_model->update($data_update, 'kode_jenis_barang', $kode_jenis_barang);

        $this->Home_model->output_json(['status' => true]);
    }

    public function cancel()
    {
        $order_id = $this->input->post('order_id');
     
        $data = [
            'createdDateCancel' => date('Y-m-d H:i:s'),
            'createdByCancel' => $this->session->userdata('userid'),
            'createdStatusCancel' => 'y',
            'status_order' => 'cancel',
        ];
        $this->Transaksi_admin_model->update($data, 'order_id', $order_id);
        $this->Log_model->create(
            'transaksi_admin/cancel',
            '#data:' . json_encode($order_id)
        );
        $this->Home_model->output_json(['status' => true]);
    }
    
}