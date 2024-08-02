<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Order_model',
            'master_kategori_barang/Master_kategori_barang_model',
            'master_barang/Master_barang_model',
            'master_jenis_barang/Master_jenis_barang_model',
            'admin_menu/Admin_menu_model',
            'home/Home_model',
            'log/Log_model',
        ]);
        $this->load->library(['user_agent','form_validation','datenumberconverter','upload_custom']);
        if (!$this->session->userdata('logged_in') || !in_array($this->session->userdata('user_group'), $this->Admin_menu_model->cek_akses_menu('order'))) {
            redirect(base_url().'auth', 'refresh');
        }
    }

    public function index()
    {
        $menu = $this->Admin_menu_model->get_list_menu_mobile_admin();
        $title = 'Order';
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
            'css'=>'<link href="'.base_url().'assets/css/pages/order.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/order.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('order/order_view', $data);
        $this->load->view('home/template/footer-mobile');
        $this->load->view('home/template/footer', $data);
        
    }

    public function get_list_barang()
    {
        
        // $typeTerm = 'all';
        // $searchTerm = '';
        
        $typeTerm = $this->input->get('typeTerm', true);
        $typeTerm2 = $this->input->get('typeTerm2', true);
        $searchTerm = $this->input->get('searchTerm', true);
        $list = $this->Order_model->get_list_barang($typeTerm, $typeTerm2, $searchTerm);
        $html = '';
        
        foreach ($list as $list) {
            $data_bind = '
                data-stock_id="'.$list->stock_id.'" 
                data-kategori_id="'.$list->kategori_id.'" 
                data-kode_barang="'.$list->kode_barang.'" 
                data-kode_jenis_barang="'.$list->kode_jenis_barang.'" 
                data-nama_jenis_barang="'.$list->nama_jenis_barang.'"  
                data-harga="'.$list->harga.'" 
                data-harga_format="'.$this->datenumberconverter->formatRupiah($list->harga).'" 
                data-qty="'.$list->qty.'" 
                data-qty_format="'.$this->datenumberconverter->IdnNumberFormat($list->qty).'" 
                data-photo_bukti_barang="'.$list->photo_bukti_barang.'"  
                data-keterangan="'.$list->keterangan.'"  
                data-createdDate="'.$list->createdDate.'"  
                data-userid="'.$list->userid.'"  
                data-status="'.$list->status.'"  
                data-approveDate="'.$list->approveDate.'"  
                data-approveBy="'.$list->approveBy.'"  
                data-kategori_desc="'.$list->kategori_desc.'"  
                data-nama_barang="'.$list->nama_barang.'"  
                data-status_barang="'.$list->status_barang.'"  
                data-status_barang_desc="'.$list->status_barang_desc.'"  
                data-photo="'.$list->photo.'"  
                data-path_photo="'.base_url('upload/master_barang/'.$list->photo).'"  
            ';

            
            if (!$list == null) {

                $str =$list->nama_jenis_barang;
                $pjng_nama = strlen($str);
                $nama_jenis_barang = substr($str,0,30);
                if ($pjng_nama > 28) {
                    $nama_jenis_barang = substr($str,0,28) . "...";
                }
                $photo = $list->photo == '' ? '<img src="'.base_url().'assets/media/users/blank2.png" alt="photo">' : '<img src="'.base_url().'upload/master_barang/'.$list->photo.'" alt="photo">';

                $html .= '
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-4">
                        <div class="card card-custom card-stretch">
                            <div class="card-body p-5 add_to_cart" '.$data_bind.'>
                                <div class="mb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-dark-75 font-weight-bolder mr-2"></span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                            <div class="symbol symbol-75">
                                                '.$photo .'
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <span class="text-muted font-weight-bold">'.$list->kategori_desc.'</span>
                                            <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h5 mb-0">'.$nama_jenis_barang.'</a>
                                            <a href="#" class="text-primary font-weight-bold text-hover-primary">'.$this->datenumberconverter->formatRupiah($list->harga).' / Kg</a>
                                            <a href="#" class="text-success text-hover-succes"> '.$this->datenumberconverter->IdnNumberFormat($list->qty).' Kg</a>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-dark-75 font-weight-bolder mr-2"></span>
                                            </div>
                                        </div>
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

    public function save_to_cart()
    {
        // $this->form_validation->set_rules('photo', str_replace(':', '', 'Photo'), 'required|trim');
        $this->form_validation->set_rules('qty_order', str_replace(':', '', 'Kuantiti'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');

        $order_id=$this->Order_model->generateIDOrder();
     
        $userid = $this->input->post('userid');
        $kategori_id = $this->input->post('kategori_id');
        $kode_barang = $this->input->post('kode_barang');
        $kode_jenis_barang = $this->input->post('kode_jenis_barang');
        $harga = str_replace(".","",$this->input->post('harga'));
        $qty = str_replace(".","",$this->input->post('qty'));        
        // $harga_total = str_replace(".","",$this->input->post('harga_total'));
        $qty_order = str_replace(".","",$this->input->post('qty_order'));        
        $harga_total = $qty_order * $harga;

        // O20220623U0001001
        $data = [
            'order_id' => $order_id,
            'userid' => $this->session->userdata('userid'),
            'kategori_id' => $kategori_id,
            'kode_barang' => $kode_barang,
            'kode_jenis_barang' => $kode_jenis_barang,
            'harga' => $harga,
            'qty' => $qty,
            'harga_total' => $harga_total,
            'qty_order' => $qty_order,
            'tanggal' => date('Y-m-d'),
            'createdDate' => date('Y-m-d H:i:s'),
            'status' => 'y',
            'status_order' => 'draft'
        ];

        if ($this->form_validation->run() === true) {
        
            $this->Order_model->create($data);
            $this->Log_model->create(
                'Order/save'
                // 'type:' . $type . '#data:' . json_encode($data)
            );
            $this->Home_model->output_json(['status' => true, 'msg' => 'tambah user berhasil...']);
            // echo json_encode($data);
        } else {
            $invalid = [
                'qty_order' => form_error('qty_order'),
            ];
            $data = [
                'status' => false,
                'invalid' => $invalid,
            ];
            $this->Home_model->output_json($data);
            // echo json_encode($data);
        }
                // echo json_encode($data);
    }

    public function get_list_order(){
        $data = $this->Order_model->get_list_order();
        echo json_encode($data);
    }
    
}