<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Transaksi_admin_model',
            'Transaksi_detail_admin_model',
            'home/Home_model',
            'order/Order_model',
            'master_kategori_barang/Master_kategori_barang_model',
            'master_jenis_barang/Master_jenis_barang_model',
            'master_barang/Master_barang_model',
            'admin_user/Admin_user_model',
            'admin_menu/Admin_menu_model',
            'stock_barang/Stock_barang_model',
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
            'title'=>'Transaksi Admin',
            'trans'=> $this->Transaksi_admin_model->get_list_transaksi_header_active(),
            'kurir'=> $this->Admin_user_model->get_list_kurir2(),
            'stock'=> $this->Stock_barang_model->get_list_stock_aprove(),
            'css'=>'<link href="'.base_url().'assets/css/pages/transaksi_admin.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/transaksi_admin.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('transaksi_admin/transaksi_admin_view', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    public function transaksi_admin_list()
    {
        $list = $this->Transaksi_admin_model->get_datatables();
        $data = array();
        $no = 0;
        
        foreach ($list as $list) {
            $data_bind = '
                data-trans_id="'.$list->trans_id.'" 
                data-userid="'.$list->userid.'" 
                data-nama_lengkap="'.$list->nama_lengkap.'" 
                data-no_hp="'.$list->no_hp.'" 
                data-pasar_id="'.$list->pasar_id.'" 
                data-pasar_desc="'.$list->pasar_desc.'" 
                data-tgl_checkout="'.$list->tgl_checkout.'" 
                data-total="'.$list->total.'" 
                data-total_format="'.$this->datenumberconverter->IdnNumberFormat($list->total).'" 
                data-total_batal="'.$list->total_batal.'" 
                data-total_batal_format="'.$this->datenumberconverter->IdnNumberFormat($list->total_batal).'" 
                data-ongkir="'.$list->ongkir.'" 
                data-ongkir_format="'.$this->datenumberconverter->IdnNumberFormat($list->ongkir).'" 
                data-biaya_penanganan="'.$list->biaya_penanganan.'" 
                data-biaya_penanganan_format="'.$this->datenumberconverter->IdnNumberFormat($list->biaya_penanganan).'" 
                data-grand_total="'.$list->grand_total.'" 
                data-grand_total_format="'.$this->datenumberconverter->IdnNumberFormat($list->grand_total).'" 
                data-alamat_kirim="'.$list->alamat_kirim.'"  
                data-tipe_pembayaran="'.$list->tipe_pembayaran.'"  
                data-bukti_pembayaran="'.$list->bukti_pembayaran.'" 
                data-status_transaksi="'.$list->status_transaksi.'" 
                data-status_transaksi2="'.ucfirst($list->status_transaksi).'" 
                data-status="'.$list->status.'" 
                data-createdDate="'.$list->createdDate.'" 
                data-banyak_checkout="'.$list->banyak_checkout.'" 
                data-banyak_packing="'.$list->banyak_packing.'" 
                data-banyak_pengiriman="'.$list->banyak_pengiriman.'" 
                data-banyak_lunas="'.$list->banyak_lunas.'" 
                data-banyak_done="'.$list->banyak_done.'" 
                data-banyak_cancel="'.$list->banyak_cancel.'" 
            ';


            $select = '';
         
            $select .='
                <a href="javascript:void(0);" class="detail_record btn btn-clean btn-light-info btn-icon" 
                '.$data_bind.'
                ><i class="la la-eye"></i></a> 
            ';
            
            ++$no;
            $data[] = array(
                'no' => $no,
                'trans_id' => $list->trans_id,
                'nama_lengkap' => $list->nama_lengkap,
                'tgl_checkout' => $this->datenumberconverter->tgl_indo($list->tgl_checkout),
                'total' => $this->datenumberconverter->formatRupiah($list->total),
                'total_batal' => $this->datenumberconverter->formatRupiah($list->total_batal),
                'grand_total' => $this->datenumberconverter->formatRupiah($list->grand_total),
                'progress' => '<i class="fas fa-shopping-basket text-success" title="Checkout"></i> : '.$list->banyak_checkout.'<br> <i class="fas fa-box" title="Packing" style="color: #e9be43;"></i> : '.$list->banyak_packing.'<br> <i class="fas fa-shipping-fast text-info" title="Kirim"></i> : '.$list->banyak_pengiriman.'<br> <i class="fas fa-money-check-alt text-warning" title="Lunas"></i> : '.$list->banyak_lunas.'<br> <i class="fas fa-check-square icon-lg text-primary" title="Selesai"></i> : '.$list->banyak_done.'<br> <i class="fas fa-window-close icon-lg text-danger" title="Cancel"></i> : '.$list->banyak_cancel,
                'alamat_kirim' => $list->alamat_kirim,
                'status_transaksi' => $list->status_transaksi,
                'action' => $select
            );
            
            // $data[] = $row;
        }

        $output = array(
                'recordsTotal' => $this->Transaksi_admin_model->count_all(),
                'recordsFiltered' => $this->Transaksi_admin_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function transaksi_detail_admin_list()
    {
        $list = $this->Transaksi_detail_admin_model->get_datatables();
        $data = array();
        $no = 0;
        
        foreach ($list as $list) {
            $data_bind = '
                data-trans_id="'.$list->trans_id.'" 
                data-order_id="'.$list->order_id.'" 
                data-stock_id="'.$list->stock_id.'" 
                data-qty_stock="'.$list->qty_stock.'" 
                data-qty_stock_format="'.$this->datenumberconverter->IdnNumberFormat($list->qty_stock).'" 
                data-nama_pemasok="'.$list->nama_pemasok.'" 
                data-userid="'.$list->userid.'" 
                data-nama_lengkap="'.$list->nama_lengkap.'" 
                data-detailid="'.$list->detailid.'" 
                data-kategori_id="'.$list->kategori_id.'" 
                data-kategori_desc="'.$list->kategori_desc.'" 
                data-kode_barang="'.$list->kode_barang.'" 
                data-nama_barang="'.$list->nama_barang.'" 
                data-kode_jenis_barang="'.$list->kode_jenis_barang.'" 
                data-nama_jenis_barang="'.$list->nama_jenis_barang.'" 
                data-harga_format="'.$this->datenumberconverter->formatRupiah($list->harga).'" 
                data-harga="'.$list->harga.'" 
                data-qty="'.$list->qty.'" 
                data-qty_format="'.$this->datenumberconverter->IdnNumberFormat($list->qty).'" 
                data-harga_total="'.$list->harga_total.'" 
                data-harga_total_format="'.$this->datenumberconverter->formatRupiah($list->harga_total).'" 
                data-qty_order="'.$list->qty_order.'" 
                data-qty_order_format="'.$this->datenumberconverter->IdnNumberFormat($list->qty_order).'" 
                data-status="'.$list->status.'" 
                data-status_order="'.$list->status_order.'" 
                data-createddate="'.$list->createdDate.'" 
                data-createddatepacking="'.$list->createdDatePacking.'" 
                data-createdstatuspacking="'.$list->createdStatusPacking.'" 
                data-createdbypengiriman="'.$list->createdByPengiriman.'" 
                data-createddatepengiriman="'.$list->createdDatePengiriman.'" 
                data-createdstatuspengiriman="'.$list->createdStatusPengiriman.'" 
                data-createdbylunas="'.$list->createdByLunas.'" 
                data-createddatelunas="'.$list->createdDateLunas.'" 
                data-createdstatuslunas="'.$list->createdStatusLunas.'" 
                data-createddatedone="'.$list->createdDateDone.'" 
                data-createdstatusdone="'.$list->createdStatusDone.'" 
                data-createddatecancel="'.$list->createdDateCancel.'" 
                data-createdstatuscancel="'.$list->createdStatusCancel.'" 
                data-createcancelnote="'.$list->createCancelNote.'" 
                data-kurir_id="'.$list->kurir_id.'" 
                data-nama_kurir="'.$list->nama_kurir.'" 
                 
            ';


            $btn_action = '';
            $btn_kurir = '';
            $btn_stock = '';
            
            if ($list->kurir_id != null || $list->kurir_id != '') {
                $btn_kurir .='
                    <label>'.$list->nama_kurir.'</label> <br>
                    <a href="javascript:void(0);" class="set_kurir_record btn btn-xs btn-outline-info btn-icon" title="Pilih Kurir" 
                    '.$data_bind.'
                    ><i class="fas fa-user-cog"></i>
                    </a> 
                ';
            } else {
                $btn_kurir .='
                    <a href="javascript:void(0);" class="set_kurir_record btn btn-xs btn-outline-info btn-icon" title="Pilih Kurir" 
                    '.$data_bind.'
                    ><i class="fas fa-user-cog"></i>
                    </a> 
                ';
            }

            if ($list->stock_id != null || $list->stock_id != '') {
                $btn_stock .='
                    <label>'.$list->nama_pemasok.' - '.$this->datenumberconverter->IdnNumberFormat($list->qty_stock).'</label> <br>
                    <a href="javascript:void(0);" class="set_stock_record btn btn-xs btn-outline-info btn-icon" title="Pilih Stock" 
                    '.$data_bind.'
                    ><i class="fas fa-boxes"></i>
                    </a> 
                ';
            } else {
                $btn_stock .='
                    <a href="javascript:void(0);" class="set_stock_record btn btn-xs btn-outline-info btn-icon" title="Pilih Stock" 
                    '.$data_bind.'
                    ><i class="fas fa-boxes"></i>
                    </a> 
                ';
            }
            

            if ($list->status_order != 'done') {
                if ($list->status_order == 'checkout') {
                    $btn_action .='
                        <a href="javascript:void(0);" class="packing_record btn btn-xs btn-clean btn-light-warning btn-icon" title="Packing"  
                        '.$data_bind.'
                        ><i class="fas fa-box"></i></a> 
                    ';
                }
                if ($list->status_order == 'packing') {
                    $btn_action .='
                        <a href="javascript:void(0);" class="pengiriman_record btn btn-xs btn-clean btn-light-info btn-icon" title="Kirim"  
                        '.$data_bind.'
                        ><i class="fas fa-shipping-fast"></i></a> 
                    ';
                }
                if ($list->status_order == 'pengiriman') {
                    $btn_action .='
                        <a href="javascript:void(0);" class="lunas_record btn btn-xs btn-clean btn-light-warning btn-icon" title="Lunas"  
                        '.$data_bind.'
                        ><i class="fas fa-money-check-alt"></i></a> 
                    ';
                }
                if ($list->status_order == 'lunas') {
                    $btn_action .='
                        <a href="javascript:void(0);" class="done_record btn btn-xs btn-clean btn-light-primary btn-icon" title="Selesai"  
                        '.$data_bind.'
                        ><i class="fas fa-check"></i></a> 
                    ';
                }
                if ($list->status_order != 'cancel') {
                    $btn_action .='
                        <a href="javascript:void(0);" class="cancel_record btn btn-xs btn-clean btn-light-danger btn-icon" title="Cancel"  
                        '.$data_bind.'
                        ><i class="fas fa-times"></i></a> 
                    ';
                }
            }
            
            ++$no;
            $data[] = array(
                'no' => $no,
                'order_id' => $list->order_id,
                'nama_jenis_barang' => $list->nama_jenis_barang,
                'harga_total' => $this->datenumberconverter->formatRupiah($list->harga_total),
                'qty_order' => $this->datenumberconverter->IdnNumberFormat($list->qty_order),
                'status_order' => $list->status_order,
                'stock' => $btn_stock,
                'kurir' => $btn_kurir,
                'action' => $btn_action
            );
            
            // $data[] = $row;
        }

        $output = array(
                'recordsTotal' => $this->Transaksi_detail_admin_model->count_all(),
                'recordsFiltered' => $this->Transaksi_detail_admin_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function save_stock()
    {
        // $this->form_validation->set_rules('photo', str_replace(':', '', 'Photo'), 'required|trim');
        $this->form_validation->set_rules('stock_id', str_replace(':', '', 'Kurir'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');

        
        $trans_id = $this->input->post('trans_id');
        $order_id = $this->input->post('order_id');
        $stock_id = $this->input->post('stock_id');
        $array = explode("_",$stock_id);
        

        if ($this->form_validation->run() === true) {
            $data = [
                'stock_id' => $array[0],
            ];
            
            $this->Transaksi_admin_model->update($data, 'order_id', $order_id);
            $this->Log_model->create(
                'transaksi_admin/save_stock',
                '#data:' . json_encode($data),
                
            );
            $this->Home_model->output_json(['status' => true, 'msg' => 'edit user berhasil...']);
            // echo json_encode($data);
        } else {
            $invalid = [
                'stock_id' => form_error('stock_id'),
            ];
            $data = [
                'status' => false,
                'invalid' => $invalid,
            ];
            $this->Home_model->output_json($data);
            // echo json_encode($data);
        }
    }

    public function save_kurir()
    {
        // $this->form_validation->set_rules('photo', str_replace(':', '', 'Photo'), 'required|trim');
        $this->form_validation->set_rules('kurir_id', str_replace(':', '', 'Kurir'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');

        
        $order_id = $this->input->post('order_id');
        $kurir_id = $this->input->post('kurir_id');

        if ($this->form_validation->run() === true) {
            $data = [
                'kurir_id' => $kurir_id,
            ];

            $this->Transaksi_admin_model->update($data, 'order_id', $order_id);
            $this->Log_model->create(
                'transaksi_admin/save_kurir',
                '#data:' . json_encode($data)
            );
            $this->Home_model->output_json(['status' => true, 'msg' => 'edit user berhasil...']);
            // echo json_encode($data);
        } else {
            $invalid = [
                'kurir_id' => form_error('kurir_id'),
            ];
            $data = [
                'status' => false,
                'invalid' => $invalid,
            ];
            $this->Home_model->output_json($data);
            // echo json_encode($data);
        }
    }

    public function packing()
    {
        $order_id = $this->input->post('order_id');
        $stock_id = $this->input->post('stock_id');
        $qty_order = $this->input->post('qty_order');
        $array = explode("_",$stock_id);
        $qty = intval($array[1]) - $qty_order;
     
        $data = [
            'createdDatePacking' => date('Y-m-d H:i:s'),
            'createdDateByPacking' => $this->session->userdata('userid'),
            'createdStatusPacking' => 'y',
            'status_order' => 'packing',
        ];
        $data_update = [
            'qty' => $qty,
        ];
        $this->Transaksi_admin_model->update($data, 'order_id', $order_id);
        $this->Stock_barang_model->update($data_update, 'stock_id', $array[0]);
        $this->Log_model->create(
            'transaksi_admin/packing',
            '#data:' . json_encode($order_id),
            '#data_update:' . json_encode($data_update)
        );
        $this->Home_model->output_json(['status' => true]);
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
        $trans_id = $this->input->post('trans_id');
        $kode_jenis_barang = $this->input->post('kode_jenis_barang');
        $qty = $this->input->post('qty');
        $qty_order = $this->input->post('qty_order');
        
        $cek_total_order_done_by_tran = $this->Transaksi_admin_model->cek_total_order_done_by_tran($trans_id);
        
     
        $data = [
            'createdDateDone' => date('Y-m-d H:i:s'),
            'createdByDone' => $this->session->userdata('userid'),
            'createdStatusDone' => 'y',
            'status_order' => 'done',
        ];
        $update = $this->Transaksi_admin_model->update($data, 'order_id', $order_id);
        $this->Log_model->create(
            'transaksi_admin/done',
            '#data:' . json_encode($order_id)
        );

       

        if ($cek_total_order_done_by_tran != 0){
            $data_transfer = [
                'status_transaksii' => 'done',
            ];
            $tes = $this->Transaksi_detail_admin_model->update($data_transfer, 'trans_id', $trans_id);
            echo json_encode($tes);
            $this->Home_model->output_json(['status' => true,'status_transaksi' => 'done']);
        } 
        $this->Home_model->output_json(['status' => true]);
      

    }

    public function cancel()
    {
        $order_id = $this->input->post('order_id');
        $stock_id = $this->input->post('stock_id');
        $qty_order = $this->input->post('qty_order');
        $array = explode("_",$stock_id);
        $qty = intval($array[1]) + $qty_order;
     
        $data = [
            'createdDateCancel' => date('Y-m-d H:i:s'),
            'createdByCancel' => $this->session->userdata('userid'),
            'createdStatusCancel' => 'y',
            'status_order' => 'cancel',
        ];
        $data_update = [
            'qty' => $qty,
        ];
        
        $this->Transaksi_admin_model->update($data, 'order_id', $order_id);
        $this->Stock_barang_model->update($data_update, 'stock_id', $array[0]);
        $this->Log_model->create(
            'transaksi_admin/cancel',
            '#data:' . json_encode($order_id)
        );
        $this->Home_model->output_json(['status' => true]);
    }
    
    
    
    
    public function get_list_transaksi_header_active()
    {
        $data = $this->Transaksi_admin_model->get_list_transaksi_header_active();
        echo json_encode($data);
    }
    public function get_list_stock($kode_jenis_barang)
    {
        $data = $this->Transaksi_detail_admin_model->get_list_stock($kode_jenis_barang);
        echo json_encode($data);
    }

}