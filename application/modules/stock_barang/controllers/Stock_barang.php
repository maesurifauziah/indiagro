<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Stock_barang_model',
            'master_kategori_barang/Master_kategori_barang_model',
            'master_barang/Master_barang_model',
            'master_jenis_barang/Master_jenis_barang_model',
            'home/Home_model',
            'admin_menu/Admin_menu_model',
            'log/Log_model',
        ]);
        $this->load->library(['user_agent','form_validation','datenumberconverter','upload_custom']);
        if (!$this->session->userdata('logged_in') || !in_array($this->session->userdata('user_group'), $this->Admin_menu_model->cek_akses_menu('stock_barang'))) {
            redirect(base_url().'auth', 'refresh');
        }
    }

    public function index()
    {
        $menu = $this->Admin_menu_model->get_list_menu_mobile_admin();
        $title = 'Stock Barang';
        if ($this->session->userdata('user_group') == '0002' || $this->session->userdata('user_group') == '0003' || $this->session->userdata('user_group') == '0004') {
            $menu = $this->Admin_menu_model->get_list_menu_mobile();
            $title = 'Home';
        }
        $data = [
            'title'=>$title,
            'kategori'=>$this->Master_kategori_barang_model->get_list_master_kategori_barang_active(),
            'barang'=>$this->Master_barang_model->get_list_master_barang_active(),
            'jenis_barang'=>$this->Master_jenis_barang_model->get_list_master_jenis_barang_active(),
            'base_url' =>base_url(),
            'menu'=>$menu,
            'css'=>'<link href="'.base_url().'assets/css/pages/stock_barang.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/stock_barang.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('stock_barang/stock_barang_view', $data);
        $this->load->view('home/template/footer-mobile');
        $this->load->view('home/template/footer', $data);
        
    }

    public function get_list_barang()
    {
        
        // $typeTerm = 'all';
        // $searchTerm = '';
        
        $typeTerm = $this->input->get('typeTerm', true);
        $typeTerm2 = $this->input->get('typeTerm2', true);
        $typeTerm3 = $this->input->get('typeTerm3', true);
        $searchTerm = $this->input->get('searchTerm', true);
        $list = $this->Stock_barang_model->get_list_barang($typeTerm, $typeTerm2, $typeTerm3, $searchTerm);
        $html = '';
        
        foreach ($list as $list) {
            $data_bind = '
                data-stock_id="'.$list->stock_id.'" 
                data-kategori_id="'.$list->kategori_id.'" 
                data-kode_barang="'.$list->kode_barang.'" 
                data-kode_jenis_barang="'.$list->kode_jenis_barang.'" 
                data-nama_jenis_barang="'.$list->nama_jenis_barang.'"  
                data-harga="'.$list->harga.'" 
                data-harga_format="'.$this->datenumberconverter->IdnNumberFormat($list->harga).'" 
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
                data-path_photo="'.base_url('upload/stock_barang/'.$list->photo).'"  
            ';

            $button_penjual = '<a href="javascript:void(0);" class="edit_barang btn btn-block btn-square btn-sm btn-light-info font-weight-bolder text-uppercase py-4" '.$data_bind.'>Edit</a>';
            $button = '';
            $label_status_barang = '';
            
            if (!$list == null) {

                $str =$list->nama_jenis_barang;
                $pjng_nama = strlen($str);
                $nama_jenis_barang = substr($str,0,30);
                if ($pjng_nama > 28) {
                    $nama_jenis_barang = substr($str,0,28) . "...";
                }
                $photo = $list->photo == '' ? '<img src="'.base_url().'assets/media/users/blank2.png" alt="photo">' : '<img src="'.base_url().'upload/master_barang/'.$list->photo.'" alt="photo">';
                // $label_status_barang = ''; = $list->status_barang == 'draft' ? '<img src="'.base_url().'assets/media/users/blank2.png" alt="photo">' : '<img src="'.base_url().'upload/master_barang/'.$list->photo.'" alt="photo">';

                if ($list->status_barang == 'draft') {
                    $label_status_barang = '';
                } 
                if ($list->status_barang == 'approve') {
                    $label_status_barang = 'label-light-primary';
                } 
                if ($list->status_barang == 'sold_out') {
                    $label_status_barang = 'label-light-success';
                } 
                if ($list->status_barang == 'cancel') {
                    $label_status_barang = 'label-light-danger';
                }
                $html .= '
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-custom gutter-b card-stretch">
                            <div class="card-body p-5 edit_barang" '.$data_bind.'>
                                <div class="mb-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-dark-75 font-weight-bolder mr-2"></span>
                                        <span class="font-weight-bolder label '.$label_status_barang.' label-inline">'.$list->status_barang_desc.'</span>
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
                                <div class="mb-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-dark-75 font-weight-bolder mr-2"></span>
                                        <span class="text-muted">'.$this->datenumberconverter->tgl_indo($this->datenumberconverter->DateTimeToDate($list->createdDate)).'</span>
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

    public function save()
    {
        // $this->form_validation->set_rules('photo', str_replace(':', '', 'Photo'), 'required|trim');
        $this->form_validation->set_rules('kategori_id', str_replace(':', '', 'Kategori'), 'required|trim');
        $this->form_validation->set_rules('kode_barang', str_replace(':', '', 'Barang'), 'required|trim');
        $this->form_validation->set_rules('kode_jenis_barang', str_replace(':', '', 'Jenis Barang'), 'required|trim');
        $this->form_validation->set_rules('harga', str_replace(':', '', 'Harga Per Kg'), 'required|trim');
        $this->form_validation->set_rules('qty', str_replace(':', '', 'Qty (Kg)'), 'required|trim');
        $this->form_validation->set_rules('keterangan', str_replace(':', '', 'No HP'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');

        $type = $this->input->post('type');
        
        $kode=$this->Stock_barang_model->generateIDStock();
        
        $stock_id = $type == 'add' ? $kode : $this->input->post('stock_id');
        $userid = $this->input->post('userid');
        $kategori_id = $this->input->post('kategori_id');
        $kode_barang = $this->input->post('kode_barang');
        $kode_jenis_barang = $this->input->post('kode_jenis_barang');
        $harga = str_replace(".","",$this->input->post('harga'));
        $qty = str_replace(".","",$this->input->post('qty'));
        $keterangan = $this->input->post('keterangan');
        $photo_name = $this->input->post('photo_name');
        

        if ($type == 'add') {

            $data = [
                'stock_id' => $stock_id,
                'kategori_id' => $kategori_id,
                'kode_barang' => $kode_barang,
                'kode_jenis_barang' => $kode_jenis_barang,
                'harga' => $harga,
                'qty' => $qty,
                'keterangan' => $keterangan,
                'createdDate' => date('Y-m-d H:i:s'),
                'userid' => $this->session->userdata('userid'),
                'status' => 'y',
                'status_barang' => 'draft'
            ];
            $photo = $_FILES["photo_bukti_barang"]["tmp_name"];
            if (isset($photo)) {
                $filename = $_FILES["photo_bukti_barang"]["name"];
                if (!empty($filename)) {
                    $extension_file = pathinfo($filename, PATHINFO_EXTENSION);
                    $zip = $this->upload_custom->folder_photo2('stock_barang', "photo_bukti_barang");
                    move_uploaded_file($photo, $zip['folderpath'] . $stock_id.'.'.$extension_file);
                    $data['photo_bukti_barang'] = str_replace("/", "", $stock_id . "." . $extension_file);
                    $this->Home_model->output_json(['status' => true, 'msg' => 'success upload...']);
                    // echo json_encode($data);
                } else {
                    $data['photo_bukti_barang'] = '';
                }
            }


            if ($this->form_validation->run() === true) {
            
                $this->Stock_barang_model->create($data);
                $this->Log_model->create(
                    'stock_barang/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'tambah user berhasil...']);
                // echo json_encode($data);
            } else {
                $invalid = [
                    'kategori_id' => form_error('kategori_id'),
                    'kode_barang' => form_error('kode_barang'),
                    'kode_jenis_barang' => form_error('kode_jenis_barang'),
                    'nama_jenis_barang' => form_error('nama_jenis_barang'),
                    'harga' => form_error('harga'),
                    'qty' => form_error('qty'),
                    'keterangan' => form_error('keterangan'),
                ];
                $data = [
                    'status' => false,
                    'invalid' => $invalid,
                ];
                $this->Home_model->output_json($data);
                // echo json_encode($data);
            }
        } 
        else if ($type == 'edit') {
            
            if ($this->form_validation->run() === true) {
                $data = [
                    'stock_id' => $stock_id,
                    'kategori_id' => $kategori_id,
                    'kode_barang' => $kode_barang,
                    'kode_jenis_barang' => $kode_jenis_barang,
                    'harga' => $harga,
                    'qty' => $qty,
                    'keterangan' => $keterangan,
                ];
                $photo = $_FILES["photo_bukti_barang"]["tmp_name"];
                if (isset($photo)) {
                    $filename = $_FILES["photo_bukti_barang"]["name"];
                    if (!empty($filename)) {
                        $extension_file = pathinfo($filename, PATHINFO_EXTENSION);
                        $zip = $this->upload_custom->folder_photo2('stock_barang', "photo_bukti_barang");
                        move_uploaded_file($photo, $zip['folderpath'] . $stock_id.'.'.$extension_file);
                        $data['photo_bukti_barang'] = str_replace("/", "", $stock_id . "." . $extension_file);
                        $this->Home_model->output_json(['status' => true, 'msg' => 'success upload...']);
                        // echo json_encode($data);
                    } else {
                        $data['photo_bukti_barang'] = $photo_name;
                    }
                }

                $this->Stock_barang_model->update($data, 'stock_id', $stock_id);
                $this->Log_model->create(
                    'stock_barang/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'edit user berhasil...']);
                // echo json_encode($data);
            } else {
                $invalid = [
                    'kategori_id' => form_error('kategori_id'),
                    'kode_barang' => form_error('kode_barang'),
                    'kode_jenis_barang' => form_error('kode_jenis_barang'),
                    'harga' => form_error('harga'),
                    'qty' => form_error('qty'),
                    'keterangan' => form_error('keterangan'),
                ];
                $data = [
                    'status' => false,
                    'invalid' => $invalid,
                ];
                $this->Home_model->output_json($data);
                // echo json_encode($data);
            }
        }
                // echo json_encode($data);
    }
    
}