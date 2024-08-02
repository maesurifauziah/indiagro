<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Admin_user_model',
            'home/Home_model',
            'admin_group_user/Admin_group_user_model',
            'wilayah_provinsi/Wilayah_provinsi_model',
            'wilayah_kabupaten/Wilayah_kabupaten_model',
            'wilayah_kecamatan/Wilayah_kecamatan_model',
            'master_pasar/Master_pasar_model',
            'admin_menu/Admin_menu_model',
            'log/Log_model',
        ]);
        $this->load->library(['form_validation','upload_custom']);
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url().'auth', 'refresh');
        }
    }

    public function index()
    {
        $data = [
            'title'=>'Users',
            'css'=>'<link href="'.base_url().'assets/css/pages/admin_user.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/admin_user.js"></script>',
            'group_user'=>$this->Admin_group_user_model->get_list_group_user(),
            'provinsi'=>$this->Wilayah_provinsi_model->get_list_provinsi_aktif(),
            'kabupaten_kota'=>$this->Wilayah_kabupaten_model->get_list_kab_kot_aktif(),
            'kecamatan'=>$this->Wilayah_kecamatan_model->get_list_kecamatan_aktif(),
            'pasar'=>$this->Master_pasar_model->get_list_master_pasar_active(),
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('admin_user/admin_user_view', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    public function admin_user_list()
    {
        $list = $this->Admin_user_model->get_datatables();
        $data = array();
        $no = 0;
        
        foreach ($list as $list) {
            $data_bind = '
                        data-userid="'.$list->userid.'" 
                        data-photo="'.$list->photo.'" 
                        data-user_name="'.$list->user_name.'" 
                        data-nama_lengkap="'.$list->nama_lengkap.'" 
                        data-tgl_insert="'.$list->tgl_insert.'" 
                        data-tgl_last_login="'.$list->tgl_last_login.'" 
                        data-user_insert="'.$list->user_insert.'" 
                        data-user_group="'.$list->user_group.'"  
                        data-aktif="'.$list->aktif.'"  
                        data-pasar_id="'.$list->pasar_id.'"  
                        data-pasar_desc="'.$list->pasar_desc.'"  
                        data-propid="'.$list->propid.'"  
                        data-propinsi_desc="'.$list->propinsi_desc.'"  
                        data-kabid="'.$list->kabid.'"  
                        data-kabupaten_kota="'.$list->kabupaten_kota.'"  
                        data-kecid="'.$list->kecid.'"  
                        data-kecamatan="'.$list->kecamatan.'"  
                        data-kodepos="'.$list->kodepos.'"  
                        data-alamat="'.$list->alamat.'"  
                        data-no_hp="'.$list->no_hp.'"  
                        data-group_name="'.$list->group_name.'"  
            ';

            $icon = $list->aktif == 'y' ? 'la la-close' : 'la la-check';
            $btn = $list->aktif == 'y' ? 'btn-light-danger' : 'btn-light-success';
            $photo = $list->photo == '' ? '<img src="'.base_url().'assets/media/users/blank.png" alt="photo">' : '<img src="'.base_url().'upload/admin_user/'.$list->photo.'" alt="photo">';


            $select = '';
            $select .='
                <a href="javascript:void(0);" class="non_active_record btn btn-xs btn-clean '.$btn.' btn-icon" 
                '.$data_bind.'
                ><i class="'.$icon.'"></i></a> 
        
                <a href="javascript:void(0);" class="edit_record btn btn-xs btn-clean btn-light-info btn-icon" 
                '.$data_bind.'
                ><i class="la la-edit"></i></a> 
            ';
            
            ++$no;
            $data[] = array(
                'no' => $no,
                // 'photo' => $list->photo,
                'photo' => '<div class="align-items-center">
                                <div class="symbol symbol-80 flex-shrink-0">
                                    '.$photo.'
                                </div>
                            </div>',
                'userid' => $list->userid,
                'user_name' => $list->user_name,
                'nama_lengkap' => $list->nama_lengkap,
                'group_name' => $list->group_name,
                'alamat' => $list->alamat,
                'propinsi_desc' => $list->propinsi_desc,
                'kabupaten_kota' => $list->kabupaten_kota,
                'kecamatan' => $list->kecamatan,
                'kodepos' => $list->kodepos,
                'pasar_desc' => $list->pasar_desc,
                'no_hp' => $list->no_hp,
                'aktif' => $list->aktif,
                'action' => $this->session->userdata('user_group') == '0005' || $this->session->userdata('user_group') == '0001' ? $select : '',
                
            );
            
            // $data[] = $row;
        }

        $output = array(
                'recordsTotal' => $this->Admin_user_model->count_all(),
                'recordsFiltered' => $this->Admin_user_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function save()
    {
        // $this->form_validation->set_rules('photo', str_replace(':', '', 'Photo'), 'required|trim');
        $this->form_validation->set_rules('nama_lengkap', str_replace(':', '', 'Nama'), 'required|trim');
        $this->form_validation->set_rules('user_name', str_replace(':', '', 'Nama Pengguna'), 'required|trim');
        $this->form_validation->set_rules('user_group', str_replace(':', '', 'Group User'), 'required|trim');
        $this->form_validation->set_rules('propid', str_replace(':', '', 'Provinsi'), 'required|trim');
        $this->form_validation->set_rules('kabid', str_replace(':', '', 'Kabupaten/Kota'), 'required|trim');
        $this->form_validation->set_rules('kecid', str_replace(':', '', 'Kecamatan'), 'required|trim');
        if ($this->input->post('user_group') == '0003') {
            $this->form_validation->set_rules('pasar_id', str_replace(':', '', 'Pasar'), 'required|trim');
        }
        $this->form_validation->set_rules('kodepos', str_replace(':', '', 'Kode Pos'), 'required|trim');
        $this->form_validation->set_rules('no_hp', str_replace(':', '', 'No HP'), 'required|trim');
        $this->form_validation->set_rules('alamat', str_replace(':', '', 'Alamat'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');

        $type = $this->input->post('type');
        
        $kode=$this->Admin_user_model->generateIDUser();
        
        $userid = $type == 'add' ? $kode : $this->input->post('userid');
        $nama_lengkap = $this->input->post('nama_lengkap');
        $user_name = $this->input->post('user_name');
        $password = $this->input->post('password');
        $user_group = $this->input->post('user_group');
        $propid = $this->input->post('propid');
        $kabid = $this->input->post('kabid');
        $kecid = $this->input->post('kecid');
        $kodepos = $this->input->post('kodepos');
        $pasar_id = $user_group == '0003' ? $this->input->post('pasar_id') : '';
        $no_hp = $this->input->post('no_hp');
        $alamat = $this->input->post('alamat');
        $photo_nama = $this->input->post('photo_nama');

        
        if ($type == 'add') {
            $data = [
                'userid' => $userid,
                'nama_lengkap' => $nama_lengkap,
                'user_name' => $user_name,
                'password' => md5(sha1(crc32($password))),
                'user_group' => $user_group,
                'propid' => $propid,
                'kabid' => $kabid,
                'kecid' => $kecid,
                // 'pasar_id' => $pasar_id,
                'kodepos' => $kodepos,
                'no_hp' => $no_hp,
                'alamat' => $alamat,
                'user_insert' => $this->session->userdata('userid'),
                'tgl_insert' => date('Y-m-d H:i:s'),
                'aktif' => 'y'
            ];
            
            $photo = $_FILES["photo"]["tmp_name"];
            if (isset($photo)) {
                $filename = $_FILES["photo"]["name"];
                if (!empty($filename)) {
                    $extension_file = pathinfo($filename, PATHINFO_EXTENSION);
                    $zip = $this->upload_custom->folder_photo('admin_user');
                    move_uploaded_file($photo, $zip['folderpath'] . $userid.'.'.$extension_file);
                    $data['photo'] = str_replace("/", "", $userid . "." . $extension_file);
                    $this->Home_model->output_json(['status' => true, 'msg' => 'success upload...']);
                    // echo json_encode($data);
                } else {
                    $data['photo'] = '';
                }
            }
            if ($this->input->post('user_group') == '0003') {
                $data['pasar_id'] =  $pasar_id;
            }


            $this->form_validation->set_rules('password', str_replace(':', '', 'Password required'), 'required|trim');
            if ($this->form_validation->run() === true) {
            
                $this->Admin_user_model->create($data);
                $this->Log_model->create(
                    'admin_user/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'tambah user berhasil...']);
                // echo json_encode($data);
            } else {
                $invalid = [
                    'user_name' => form_error('user_name'),
                    'user_group' => form_error('user_group'),
                    'propid' => form_error('propid'),
                    'kabid' => form_error('kabid'),
                    'kecid' => form_error('kecid'),
                    // 'pasar_id' => form_error('pasar_id'),
                    'kodepos' => form_error('kodepos'),
                    'no_hp' => form_error('no_hp'),
                    'alamat' => form_error('alamat'),
                ];
                if ($this->input->post('user_group') == '0003') {
                    $invalid['pasar_id'] =  form_error('pasar_id');
                }
                $data = [
                    'status' => false,
                    'invalid' => $invalid,
                ];
                $this->Home_model->output_json($data);
                // echo json_encode($data);
            }
        } 
        else if ($type == 'edit') {
        //     $this->form_validation->set_rules('uid', str_replace(':', '', 'Uid required'), 'required|trim');
            $data = [
                'userid' => $userid,
                'nama_lengkap' => $nama_lengkap,
                'user_name' => $user_name,
                'user_group' => $user_group,
                'propid' => $propid,
                'kabid' => $kabid,
                'kecid' => $kecid,
                // 'pasar_id' => $pasar_id,
                'kodepos' => $kodepos,
                'no_hp' => $no_hp,
                'alamat' => $alamat,
                // 'sphoto' => $photo_nama,
            ];
            
            $photo = $_FILES["photo"]["tmp_name"];
            if (isset($photo)) {
                $filename = $_FILES["photo"]["name"];
                if (!empty($filename)) {
                    $extension_file = pathinfo($filename, PATHINFO_EXTENSION);
                    $zip = $this->upload_custom->folder_photo('admin_user');
                    move_uploaded_file($photo, $zip['folderpath'] . $userid.'.'.$extension_file);
                    $data['photo'] = str_replace("/", "", $userid . "." . $extension_file);
                    $this->Home_model->output_json(['status' => true, 'msg' => 'success upload...']);
                    // echo json_encode($data);
                } else {
                    $data['photo'] = $photo_nama;
                }
            }
            if ($this->input->post('user_group') == '0003') {
                $data['pasar_id'] =  $pasar_id;
            }
            
            if ($this->form_validation->run() === true) {
                $this->Admin_user_model->update($data, 'userid', $userid);
                
                $this->Log_model->create(
                    'admin_user/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'edit user berhasil...']);
                // echo json_encode($data);
            } else {
                $invalid = [
                    'user_name' => form_error('user_name'),
                    'user_group' => form_error('user_group'),
                    'propid' => form_error('propid'),
                    'kabid' => form_error('kabid'),
                    'kecid' => form_error('kecid'),
                    // 'pasar_id' => form_error('pasar_id'),
                    'kodepos' => form_error('kodepos'),
                    'no_hp' => form_error('no_hp'),
                    'alamat' => form_error('alamat'),
                ];
                if ($this->input->post('user_group') == '0003') {
                    $invalid['pasar_id'] =  form_error('pasar_id');
                }
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

    public function aktif($id)
    {
        $aktif = $this->input->post('aktif') == 'y' ? 'n' : 'y';
        $data = [
            'aktif' => $aktif,
        ];
        $this->Admin_user_model->update($data, 'userid', $id);
        $this->Log_model->create(
            'admin_user/aktif/' . $id,
            'aktif:' . $aktif
        );
        $this->Home_model->output_json(['status' => true]);
    }

    public function get_list_kurir()
    {
        $searchTerm = $this->input->post('searchTerm', true);
        $data = $this->Admin_user_model->get_list_kurir($searchTerm);
        $datasource = [];
        
        foreach($data as $data){
            $datasource [] = array(
                'id'=>$data->userid,
                'text'=>$data->nama_lengkap,
            );
        }
        echo json_encode($datasource);
    }

    public function get_list_kurir2()
    {
        $data = $this->Admin_user_model->get_list_kurir2();
        echo json_encode($data);
    }
}