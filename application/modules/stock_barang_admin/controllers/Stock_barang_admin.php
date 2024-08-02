<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stock_barang_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Stock_barang_admin_model',
            'home/Home_model',
            'order/Order_model',
            'master_kategori_barang/Master_kategori_barang_model',
            'master_jenis_barang/Master_jenis_barang_model',
            'master_barang/Master_barang_model',
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
            'title'=>'Stock Barang Admin',
            'kategori'=>$this->Master_kategori_barang_model->get_list_master_kategori_barang_active(),
            'barang'=>$this->Master_barang_model->get_list_master_barang_active(),
            'jenis_barang'=>$this->Master_jenis_barang_model->get_list_master_jenis_barang_active(),
            'css'=>'<link href="'.base_url().'assets/css/pages/stock_barang_admin.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/stock_barang_admin.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('stock_barang_admin/stock_barang_admin_view', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    public function stock_barang_admin_list()
    {
        $list = $this->Stock_barang_admin_model->get_datatables();
        $data = array();
        $no = 0;
        
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
                data-nama_penyetok="'.$list->nama_penyetok.'"  
                data-status="'.$list->status.'"  
                data-approveDate="'.$list->approveDate.'"  
                data-approveBy="'.$list->approveBy.'"  
                data-kategori_desc="'.$list->kategori_desc.'"  
                data-nama_barang="'.$list->nama_barang.'"  
                data-status_barang="'.$list->status_barang.'"  
                data-status_barang_desc="'.$list->status_barang_desc.'"  
                data-photo="'.$list->photo.'"  
                data-approvedate="'.$list->approveDate.'"  
                data-approveby="'.$list->approveBy.'"  
                data-approvestatus="'.$list->approveStatus.'"  
                data-soldoutdate="'.$list->soldoutDate.'"  
                data-soldoutby="'.$list->soldoutBy.'"  
                data-soldoutstatus="'.$list->soldoutStatus.'"  
                data-deleteddate="'.$list->deletedDate.'"  
                data-deletedby="'.$list->deletedBy.'"  
                data-deletedstatus="'.$list->deletedStatus.'"  
                data-path_photo="'.base_url('upload/stock_barang/'.$list->photo).'"  
            ';

            $icon = $list->status == 'y' ? 'la la-close' : 'la la-check';
            $btn = $list->status == 'y' ? 'btn-light-danger' : 'btn-light-success';


            $select = '';
         
            $select .='
                <a href="javascript:void(0);" class="edit_record btn btn-xs btn-clean btn-light-info btn-icon" 
                '.$data_bind.'
                ><i class="la la-edit"></i></a> 
            ';
            $select .='
                <a href="javascript:void(0);" class="approve_record btn btn-xs btn-clean btn-light-success btn-icon" 
                '.$data_bind.'
                ><i class="la la-check"></i></a> 
            ';
            if ($list->status_barang == 'approve') {
                $select .='
                    <a href="javascript:void(0);" class="soldout_record btn btn-xs btn-clean btn-light-warning btn-icon" 
                    '.$data_bind.'
                    ><i class="la la-eye-slash"></i></a> 
                ';
            }
            $select .='
                <a href="javascript:void(0);" class="cancel_record btn btn-xs btn-clean btn-light-danger btn-icon" 
                '.$data_bind.'
                ><i class="la la-close"></i></a> 
            ';
            // $select .='
            //     <div class="dropdown dropdown-inline" id="button-action">
            //         <a href="#" class="btn btn-light-primary font-weight-bold" data-toggle="dropdown" aria-expanded="false">
            //             <i class="la la-gear"></i>
            //         </a>
            //         <div class="dropdown-menu dropdown-menu-md py-5" id="button-action-sub">
            //             <ul class="navi navi-hover">
            //                 <li class="navi-item">
            //                     <a href="javascript:void(0);" class="edit_record btn btn-xs btn-clean btn-light-info btn-icon" '.$data_bind.'>
            //                         <span class="navi-icon"><i class="la la-edit text-info"></i></span>
            //                         <span class="navi-text">Edit</span>
            //                     </a>
            //                 </li>
            //                 <li class="navi-item">
            //                     <a href="javascript:void(0);" class="approve_record btn btn-xs btn-clean btn-light-success btn-icon" '.$data_bind.'>
            //                         <span class="navi-icon"><i class="la la-check text-success"></i></span>
            //                         <span class="navi-text">Approve</span>
            //                     </a>
            //                 </li>
            //                 <li class="navi-item">
            //                     <a href="javascript:void(0);" class="soldout_record btn btn-xs btn-clean btn-light-warning btn-icon" '.$data_bind.'>
            //                         <span class="navi-icon"><i class="la la-eye-slash text-warning"></i></span>
            //                         <span class="navi-text">Habis</span>
            //                     </a>
            //                 </li>
            //             </ul>
            //         </div>
            //     </div>
            // ';
            
            // $s = $list->createdDate;
            // $createdDate = date('y-m-d', strtotime($s));
           
            $photo_bukti_barang = $list->photo_bukti_barang == '' ? '<img src="'.base_url().'assets/media/users/blank.png" alt="photo">' : '<img src="'.base_url().'upload/stock_barang/'.$list->photo_bukti_barang.'" alt="photo">';
            
            ++$no;
            $data[] = array(
                'no' => $no,
                'stock_id' => $list->stock_id,
                'createdDate' => $this->datenumberconverter->tgl_indo($this->datenumberconverter->DateTimeToDate($list->createdDate)),
                'nama_lengkap' => $list->nama_penyetok,
                'no_hp' => $list->no_hp,
                // 'nama_barang' => $list->nama_barang,
                'nama_jenis_barang' => $list->nama_jenis_barang,
                'photo_bukti_barang' => '<div class="align-items-center">
                                                <div class="symbol symbol-80 flex-shrink-0">
                                                    '.$photo_bukti_barang.'
                                                </div>
                                            </div>',
                'qty' => $list->qty,
                'harga' => $this->datenumberconverter->formatRupiah($list->harga),
                'status_barang' => $list->status_barang,
                'action' => $select
            );
            
            // $data[] = $row;
        }

        $output = array(
                'recordsTotal' => $this->Stock_barang_admin_model->count_all(),
                'recordsFiltered' => $this->Stock_barang_admin_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
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

    public function approve()
    {
        $stock_id = $this->input->post('stock_id');
        $data = [
            'approveDate' => date('Y-m-d H:i:s'),
            'approveBy' => $this->session->userdata('userid'),
            'approveStatus' => 'y',
            'status_barang' => 'approve',
        ];
        $this->Stock_barang_admin_model->update($data, 'stock_id', $stock_id);
        $this->Log_model->create(
            'stock_barang_admin/approve/' . $stock_id
        );
        $this->Home_model->output_json(['status' => true]);
    }
    
    public function sold_out()
    {
        $stock_id = $this->input->post('stock_id');
        $data = [
            'soldoutDate' => date('Y-m-d H:i:s'),
            'soldoutBy' => $this->session->userdata('userid'),
            'soldoutStatus' => 'y',
            'status_barang' => 'sold_out',
        ];
        $this->Stock_barang_admin_model->update($data, 'stock_id', $stock_id);
        $this->Log_model->create(
            'stock_barang_admin/sold_out/' . $stock_id
        );
        $this->Home_model->output_json(['status' => true]);
    }
    
    public function cancel()
    {
        $stock_id = $this->input->post('stock_id');
        $data = [
            'deletedDate' => date('Y-m-d H:i:s'),
            'deletedBy' => $this->session->userdata('userid'),
            'deletedStatus' => 'y',
            'status_barang' => 'cancel',
        ];
        $this->Stock_barang_admin_model->update($data, 'stock_id', $stock_id);
        $this->Log_model->create(
            'stock_barang_admin/sold_out/' . $stock_id
        );
        $this->Home_model->output_json(['status' => true]);
    }
    
    public function get_detail_jenis_barang($kode_jenis_barang)
    {
        $data = $this->Stock_barang_admin_model->get_detail_jenis_barang($kode_jenis_barang);
        echo json_encode($data);
    }

    public function get_jenis_barang_by_barang($kode_barang)
    {
        $data = $this->Stock_barang_admin_model->get_jenis_barang_by_barang($kode_barang);
        echo json_encode($data);
    }
}