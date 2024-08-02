<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_jenis_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Master_jenis_barang_model',
            'home/Home_model',
            'order/Order_model',
            'master_kategori_barang/Master_kategori_barang_model',
            'master_barang/Master_barang_model',
            'admin_menu/Admin_menu_model',
            'log/Log_model',
        ]);
        $this->load->library(['form_validation','datenumberconverter','upload_custom']);
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url().'auth', 'refresh');
        }
    }

    public function index()
    {
        $data = [
            'title'=>'Master Jenis Barang',
            'kategori'=>$this->Master_kategori_barang_model->get_list_master_kategori_barang_active(),
            'barang'=>$this->Master_barang_model->get_list_master_barang_active(),
            'css'=>'<link href="'.base_url().'assets/css/pages/master_jenis_barang.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/master_jenis_barang.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('master_jenis_barang/master_jenis_barang_view', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    public function master_jenis_barang_list()
    {
        $list = $this->Master_jenis_barang_model->get_datatables();
        $data = array();
        $no = 0;
        
        foreach ($list as $list) {
            $data_bind = '
                data-kode_jenis_barang="'.$list->kode_jenis_barang.'" 
                data-nama_jenis_barang="'.$list->nama_jenis_barang.'" 
                data-kode_barang="'.$list->kode_barang.'"  
                data-kategori_id="'.$list->kategori_id.'"  
                data-harga="'.$list->harga.'"  
                data-harga-format="'.$this->datenumberconverter->IdnNumberFormat($list->harga).'"  
                data-createdDate="'.$list->createdDate.'"  
                data-status="'.$list->status.'"  
                data-nama_barang="'.$list->nama_barang.'"  
                data-photo="'.$list->photo.'"  
                data-kategori_desc="'.$list->kategori_desc.'"  
            ';

            $icon = $list->status == 'y' ? 'la la-close' : 'la la-check';
            $btn = $list->status == 'y' ? 'btn-light-danger' : 'btn-light-success';
            $photo = $list->photo == '' ? '<img src="'.base_url().'assets/media/users/blank.png" alt="photo">' : '<img src="'.base_url().'upload/master_barang/'.$list->photo.'" alt="photo">';



            $select = '';
            $select .='
                <a href="javascript:void(0);" class="non_active_record btn btn-sm btn-clean '.$btn.' btn-icon" 
                '.$data_bind.'
                ><i class="'.$icon.'"></i></a> 
        
                <a href="javascript:void(0);" class="edit_record btn btn-sm btn-clean btn-light-info btn-icon" 
                '.$data_bind.'
                ><i class="la la-edit"></i></a> 
            ';
            
            ++$no;
            $data[] = array(
                'no' => $no,
                'photo' => '<div class="align-items-center">
                                <div class="symbol symbol-80 flex-shrink-0">
                                    '.$photo.'
                                </div>
                            </div>',
                'kategori_desc' => $list->kategori_desc,
                'nama_barang' => $list->nama_barang,
                'nama_jenis_barang' => $list->nama_jenis_barang,
                'harga' => $this->datenumberconverter->formatRupiah($list->harga),
                'status' => $list->status,
                'action' => $select
            );
            
            // $data[] = $row;
        }

        $output = array(
                'recordsTotal' => $this->Master_jenis_barang_model->count_all(),
                'recordsFiltered' => $this->Master_jenis_barang_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function save()
    {
        $this->form_validation->set_rules('nama_jenis_barang', str_replace(':', '', 'Jenis Barang'), 'required|trim');
        $this->form_validation->set_rules('kategori_id', str_replace(':', '', 'Kategori'), 'required|trim');
        $this->form_validation->set_rules('kode_barang', str_replace(':', '', 'Barang'), 'required|trim');
        $this->form_validation->set_rules('harga', str_replace(':', '', 'Harga'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');

        $type = $this->input->post('type');
        
        $kode=$this->Master_jenis_barang_model->generateIDJenisBarang();
        
        $kode_jenis_barang = $kode;
        $nama_jenis_barang = $this->input->post('nama_jenis_barang');
        $kategori_id = $this->input->post('kategori_id');
        $kode_barang = $this->input->post('kode_barang');
        $harga = str_replace(".","",$this->input->post('harga'));
        $photo_nama = $this->input->post('photo_nama');

        
        if ($type == 'add') {
            $data = [
                'kode_jenis_barang' => $kode_jenis_barang,
                'nama_jenis_barang' => $nama_jenis_barang,
                'kategori_id' => $kategori_id,
                'kode_barang' => $kode_barang,
                'harga' => $harga,
                'createdDate' => date('Y-m-d H:i:s'),
                'status' => 'y',
            ];
            
            $photo = $_FILES["photo"]["tmp_name"];
            if (isset($photo)) {
                $filename = $_FILES["photo"]["name"];
                if (!empty($filename)) {
                    $extension_file = pathinfo($filename, PATHINFO_EXTENSION);
                    $zip = $this->upload_custom->folder_photo('master_barang');
                    move_uploaded_file($photo, $zip['folderpath'] . $kode_jenis_barang.'.'.$extension_file);
                    $data['photo'] = str_replace("/", "", $kode_jenis_barang . "." . $extension_file);
                    $this->Home_model->output_json(['status' => true, 'msg' => 'success upload...']);
                } else {
                    $data['photo'] = '';
                }
            }

            if ($this->form_validation->run() === true) {
            
                $this->Master_jenis_barang_model->create($data);
                $this->Log_model->create(
                    'master_jenis_barang/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'tambah user berhasil...']);
            } else {
                $invalid = [
                    'kode_jenis_barang' => form_error('kode_jenis_barang'),
                    'nama_jenis_barang' => form_error('nama_jenis_barang'),
                    'kategori_id' => form_error('kategori_id'),
                    'kode_barang' => form_error('kode_barang'),
                    'harga' => form_error('harga'),
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
            $data = [
                    // 'kode_jenis_barang' => $kode_jenis_barang,
                    'nama_jenis_barang' => $nama_jenis_barang,
                    'kategori_id' => $kategori_id,
                    'kode_barang' => $kode_barang,
                    'harga' => $harga,
                ];
            
            $photo = $_FILES["photo"]["tmp_name"];
            if (isset($photo)) {
                $filename = $_FILES["photo"]["name"];
                if (!empty($filename)) {
                    $extension_file = pathinfo($filename, PATHINFO_EXTENSION);
                    $zip = $this->upload_custom->folder_photo('master_barang');
                    move_uploaded_file($photo, $zip['folderpath'] . $this->input->post('kode_jenis_barang').'.'.$extension_file);
                    $data['photo'] = str_replace("/", "", $this->input->post('kode_jenis_barang') . "." . $extension_file);
                    $this->Home_model->output_json(['status' => true, 'msg' => 'success upload...']);
                } else {
                    $data['photo'] = $photo_nama;
                }
            }
            
            if ($this->form_validation->run() === true) {
                $this->Master_jenis_barang_model->update($data, 'kode_jenis_barang',  $this->input->post('kode_jenis_barang'));
                $this->Log_model->create(
                    'admin_user/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'edit user berhasil...']);
            } else {
                $invalid = [
                    'kode_jenis_barang' => form_error('kode_jenis_barang'),
                    'nama_jenis_barang' => form_error('nama_jenis_barang'),
                    'kategori_id' => form_error('kategori_id'),
                    'kode_barang' => form_error('kode_barang'),
                    'harga' => form_error('harga'),
                ];
               
                $data = [
                    'status' => false,
                    'invalid' => $invalid,
                ];
                $this->Home_model->output_json($data);
            }
        }
    }
    
    // function save()
    // {
    //     $this->form_validation->set_rules('nama_jenis_barang', str_replace(':', '', 'Jenis Barang'), 'required|trim');
    //     $this->form_validation->set_rules('kategori_id', str_replace(':', '', 'Kategori'), 'required|trim');
    //     $this->form_validation->set_rules('kode_barang', str_replace(':', '', 'Barang'), 'required|trim');
    //     $this->form_validation->set_rules('harga', str_replace(':', '', 'Harga'), 'required|trim');
    //     $this->form_validation->set_message('required', '{field} is required');
        
    //     $type = $this->input->post('type');

    //     $kode=$this->Master_jenis_barang_model->generateIDJenisBarang();

    //     $kode_jenis_barang = $kode;
    //     $nama_jenis_barang = $this->input->post('nama_jenis_barang');
    //     $kategori_id = $this->input->post('kategori_id');
    //     $kode_barang = $this->input->post('kode_barang');
    //     $harga = str_replace(".","",$this->input->post('harga'));
    //     $photo_nama = $this->input->post('photo_nama');
        

    //     if ($type == 'edit') {
    //         $this->form_validation->set_rules('kode_jenis_barang', str_replace(':', '', 'ID'), 'required|trim');
    //     }

    //     if ($this->form_validation->run() === true) {
    //         if ($type == 'add') {
    //             $data = [
    //                 'kode_jenis_barang' => $kode_jenis_barang,
    //                 'nama_jenis_barang' => $nama_jenis_barang,
    //                 'kategori_id' => $kategori_id,
    //                 'kode_barang' => $kode_barang,
    //                 'harga' => $harga,
    //                 'createdDate' => date('Y-m-d H:i:s'),
    //                 'status' => 'y',
    //             ];
    //             $photo = $_FILES["photo"]["tmp_name"];
    //             if (isset($photo)) {
    //                 $filename = $_FILES["photo"]["name"];
    //                 if (!empty($filename)) {
    //                     $extension_file = pathinfo($filename, PATHINFO_EXTENSION);
    //                     $zip = $this->upload_custom->folder_photo2('master_barang', "photo");
    //                     move_uploaded_file($photo, $zip['folderpath'] . $kode_jenis_barang.'.'.$extension_file);
    //                     $data['photo'] = str_replace("/", "", $kode_jenis_barang . "." . $extension_file);
    //                     $this->Home_model->output_json(['status' => true, 'msg' => 'success upload...']);
    //                     // echo json_encode($data);
    //                 } else {
    //                     $data['photo'] = '';
    //                 }
    //             }
    //             $this->Master_jenis_barang_model->create($data);
    //             $this->Log_model->create(
    //                 'master_jenis_barang/save',
    //                 'type:' . $type . '#data:' . json_encode($data)
    //             );
    //             $this->Home_model->output_json(['status' => true, 'msg' => 'tambah group berhasil...']);
    //             // echo json_encode($data);
    //         } 
    //         else if ($type == 'edit') {
    //             $data = [
    //                 // 'kode_jenis_barang' => $kode_jenis_barang,
    //                 'nama_jenis_barang' => $nama_jenis_barang,
    //                 'kategori_id' => $kategori_id,
    //                 'kode_barang' => $kode_barang,
    //                 'harga' => $harga,
    //             ];
    //             $photo = $_FILES["photo"]["tmp_name"];
    //             if (isset($photo)) {
    //                 $filename = $_FILES["photo"]["name"];
    //                 if (!empty($filename)) {
    //                     $extension_file = pathinfo($filename, PATHINFO_EXTENSION);
    //                     $zip = $this->upload_custom->folder_photo2('master_barang', "photo");
    //                     move_uploaded_file($photo, $zip['folderpath'] .  $this->input->post('kode_jenis_barang').'.'.$extension_file);
    //                     $data['photo'] = str_replace("/", "",  $this->input->post('kode_jenis_barang') . "." . $extension_file);
    //                     $this->Home_model->output_json(['status' => true, 'msg' => 'success upload...']);
    //                     // echo json_encode($data);
    //                 } else {
    //                     $data['photo'] = $photo_nama;
    //                 }
    //             }
    //             $this->Master_jenis_barang_model->update($data, 'kode_jenis_barang',  $this->input->post('kode_jenis_barang'));
    //             // $this->Order_model->update(array('harga'=>$harga), 'kode_jenis_barang', $kode_jenis_barang);
    //             $this->Log_model->create(
    //                 'master_jenis_barang/save',
    //                 'type:' . $type . '#data:' . json_encode($data)
    //             );
    //             $this->Home_model->output_json(['status' => true, 'msg' => 'edit group berhasil...']);
    //             // echo json_encode($data);

    //         }
    //     } else {
    //         $invalid = [
    //             'kode_jenis_barang' => form_error('kode_jenis_barang'),
    //             'nama_jenis_barang' => form_error('nama_jenis_barang'),
    //             'kategori_id' => form_error('kategori_id'),
    //             'kode_barang' => form_error('kode_barang'),
    //             'harga' => form_error('harga'),
    //         ];
    //         $data = [
    //             'status' => false,
    //             'invalid' => $invalid,
    //         ];
    //         $this->Home_model->output_json($data);
    //         // echo json_encode($data);
    //     }
    // }

    public function status($id)
    {
        $status = $this->input->post('status') == 'y' ? 'n' : 'y';
        $data = [
            'status' => $status,
        ];
        $this->Master_jenis_barang_model->update($data, 'kode_jenis_barang', $id);
        $this->Log_model->create(
            'master_jenis_barang/status/' . $id,
            'status:' . $status
        );
        $this->Home_model->output_json(['status' => true]);
    }
    
    public function get_detail_jenis_barang($kode_jenis_barang)
    {
        $data = $this->Master_jenis_barang_model->get_detail_jenis_barang($kode_jenis_barang);
        echo json_encode($data);
    }

    public function get_jenis_barang_by_barang($kode_barang)
    {
        $data = $this->Master_jenis_barang_model->get_jenis_barang_by_barang($kode_barang);
        echo json_encode($data);
    }
}