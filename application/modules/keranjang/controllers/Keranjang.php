<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keranjang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Keranjang_model',
            'order/Order_model',
            'home/Home_model',
            'admin_menu/Admin_menu_model',
            'log/Log_model',
        ]);
        $this->load->library(['form_validation']);
        if (!$this->session->userdata('logged_in') || !in_array($this->session->userdata('user_group'), $this->Admin_menu_model->cek_akses_menu('keranjang'))) {
            redirect(base_url().'auth', 'refresh');
        }
        
        // if (!$this->session->userdata('logged_in')) {
        //     redirect(base_url().'auth', 'refresh');
        // }
    }

    public function index()
    {
        $menu = $this->Admin_menu_model->get_list_menu_mobile_admin();
        if ($this->session->userdata('user_group') == '0002' || $this->session->userdata('user_group') == '0003' || $this->session->userdata('user_group') == '0004') {
            $menu = $this->Admin_menu_model->get_list_menu_mobile();
        }
        $data = [
            'title'=>'Keranjang',
            'base_url' =>base_url(),
            'menu'=>$menu,
            'css'=>'<link href="'.base_url().'assets/css/pages/keranjang.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/keranjang.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('keranjang/keranjang_view', $data);
        $this->load->view('home/template/footer-mobile', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    public function get_list_order(){
        $data = $this->Order_model->get_list_order();
        echo json_encode($data);
    }

    
    // public function checkout()
    public function checkout()
    {
        $this->form_validation->set_rules('alamat_kirim', str_replace(':', '', 'Alamat Kirim'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');

        // header 
        $trans_id = $this->Keranjang_model->generateIDTransaksi();
        $total_harga_order_value = $this->input->post('total_harga_order_value');
        $alamat_kirim = $this->input->post('alamat_kirim');
        
        // Detail
        $data_ceklis = $this->input->post('data_ceklis');
        $order_id = $this->input->post('order_id');
        $userid = $this->input->post('userid');
        $kategori_id = $this->input->post('kategori_id');
        $kode_barang = $this->input->post('kode_barang');
        $kode_jenis_barang = $this->input->post('kode_jenis_barang');
        $harga = $this->input->post('harga');
        $qty = $this->input->post('qty');
        $harga_total = $this->input->post('harga_total');
        $qty_order = $this->input->post('qty_order');
        $photo = $this->input->post('photo');
        $nama_jenis_barang = $this->input->post('nama_jenis_barang');

        $detail = [];

        $nomor_detail = 0;
        foreach ($data_ceklis as $key => $val) {
            // $where_update = array(
            //     'order_id' => $order_id[$key],
            // );
            $data_update = [
                'status_order' => 'checkout',
            ];

            $this->Order_model->update($data_update, 'order_id', $order_id[$key]);
            $nomor_detail = $nomor_detail+1;
            $detail [] = array(
                'trans_id' => $trans_id,
                'order_id' => $order_id[$key],
                'userid' => $userid[$key],
                'detailid' => $nomor_detail,
                'kategori_id' => $kategori_id[$key],
                'kode_barang' => $kode_barang[$key],
                'kode_jenis_barang' => $kode_jenis_barang[$key],
                'harga' => $harga[$key],
                'qty' => $qty[$key],
                'harga_total' => $harga_total[$key],
                'qty_order' => $qty_order[$key],
                'status_order' => 'checkout',
                'createdDate' => date('Y-m-d H:i:s'),
            );
        }
        
        $header = [
            'trans_id' => $trans_id,
            'userid' => $this->session->userdata('userid'),
            'tgl_checkout' => date('Y-m-d H:i:s'),
            'total' => 0,
            'total_batal' => 0,
            // 'ongkir' => 0,
            // 'biaya_penanganan' => 0,
            'grand_total' => $total_harga_order_value,
            'alamat_kirim' => $alamat_kirim,
            'status_transaksi' => 'draft',
            'createdDate' => date('Y-m-d H:i:s'),
        ];

        if ($this->form_validation->run() === true) {
        
            $this->Keranjang_model->create_hd($header, $detail);
            $this->Log_model->create(
                'keranjang/checkout',
                'trans_id: '.$trans_id. ' userid: '.$this->session->userdata('userid'). ' user_group: '.$this->session->userdata('user_group')
            );
            $this->Home_model->output_json(['status' => true, 'msg' => 'Data Berhasil disimpan...']);
              
            // echo json_encode($detail);
        } else {
            $invalid = [
                'alamat_kirim' => form_error('alamat_kirim'),
            ];
            $data = [
                'status' => false,
                'invalid' => $invalid,
            ];
            $this->Home_model->output_json($data);
            // echo json_encode($data);
        }
    }

    public function cancel()
    {
        $order_id = $this->input->post('order_id');
        $data = [
            'status_order' => 'cancel',
        ];
        $this->Order_model->update($data, 'order_id', $order_id);
        $this->Log_model->create(
            'keranjang/cancel/' . $order_id

        );
        $this->Home_model->output_json(['status' => true]);
    }
}