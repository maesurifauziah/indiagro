<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Auth_model',
            'admin_group_user/Admin_group_user_model',
            'admin_user/Admin_user_model',
            'wilayah_provinsi/Wilayah_provinsi_model',
            'wilayah_kabupaten/Wilayah_kabupaten_model',
            'wilayah_kecamatan/Wilayah_kecamatan_model',
            'master_pasar/Master_pasar_model',
            'log/Log_model'
        ));
        $this->load->library(['form_validation']);
        
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect(base_url(), 'refresh');
        }

        $data = [
            // sign in
            'title' => 'Login',
            'group_user'=>$this->Admin_group_user_model->get_list_group_user_seller_buyer(),
            'provinsi'=>$this->Wilayah_provinsi_model->get_list_provinsi_aktif(),
            'kabupaten_kota'=>$this->Wilayah_kabupaten_model->get_list_kab_kot_aktif(),
            'kecamatan'=>$this->Wilayah_kecamatan_model->get_list_kecamatan_aktif(),
            'pasar'=>$this->Master_pasar_model->get_list_master_pasar_active(),
            'username' => [
                'name' => 'username',
                'id' => 'username',
                'type' => 'text',
                'placeholder' => 'Username',
                'autofocus' => 'autofocus',
                'class' => 'form-control h-auto form-control-solid py-4 px-8',
                'autocomplete' => 'off',
            ],
            'password' => [
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'placeholder' => 'Password',
                'class' => 'form-control h-auto form-control-solid py-4 px-8',
            ],
            'message' => (validation_errors()) ? validation_errors() : $this->session->flashdata('message'),
            'message' => '',

            // sign up
            'nama_lengkap' => [
                'name' => 'nama_lengkap',
                'id' => 'nama_lengkap',
                'type' => 'text',
                'placeholder' => 'Nama Lengkap',
                'class' => 'form-control form-control-sm h-auto form-control-solid py-4 px-8',
            ],
            'user_name' => [
                'name' => 'user_name',
                'id' => 'user_name',
                'type' => 'text',
                'placeholder' => 'Nama Pengguna',
                'class' => 'form-control form-control-sm h-auto form-control-solid py-4 px-8',
            ],
            'password_reg' => [
                'name' => 'password_reg',
                'id' => 'password_reg',
                'type' => 'password',
                'placeholder' => 'Password',
                'class' => 'form-control form-control-sm h-auto form-control-solid py-4 px-8',
            ],
            'user_group' => [
                'name' => 'user_group',
                'id' => 'user_group',
                'type' => 'hidden',
                'placeholder' => 'Group User',
                'value' => '',
                'readonly' => 'readonly',
                'class' => 'form-control form-control-sm h-auto form-control-solid py-4 px-8',
            ],
           
            'no_hp' => [
                'name' => 'no_hp',
                'id' => 'no_hp',
                'type' => 'number',
                'placeholder' => 'No HP',
                'class' => 'form-control form-control-sm h-auto form-control-solid py-4 px-8',
            ],
            'kodepos' => [
                'name' => 'kodepos',
                'id' => 'kodepos',
                'type' => 'number',
                'placeholder' => 'Kode Pos',
                'class' => 'form-control form-control-sm h-auto form-control-solid py-4 px-8',
            ],
            'alamat' => [
                'name' => 'alamat',
                'id' => 'alamat',
                'type' => 'text',
                'placeholder' => 'Alamat',
                'rows' => '2',
                'cols' => '40',
                'class' => 'form-control form-control-sm h-auto form-control-solid py-4 px-8',
            ],
        ];
        $this->load->view('auth/auth_view', $data);
    }

    public function login()
    {
        $this->form_validation->set_rules('username', str_replace(':', '', 'Username required'), 'required|trim');
        $this->form_validation->set_rules('password', str_replace(':', '', 'Password required'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        if ($this->form_validation->run() === true) {
            $user = $this->Auth_model->login($username, $password);
            $token = md5(sha1(crc32($user->userid.$user->uid.$user->user_name.date('Y-m-d H:i:s'))));
            if ($user) {
                $data = array(
                    'uid' => trim($user->uid),
                    'photo' => trim($user->photo),
                    'userid' => trim($user->userid),
                    'user_name' => trim($user->user_name),
                    'nama_lengkap' => trim($user->nama_lengkap),
                    'user_group' => trim($user->user_group),
                    'pasar_id' => trim($user->pasar_id),
                    'propid' => trim($user->propid),
                    'kabid' => trim($user->kabid),
                    'kecid' => trim($user->kecid),
                    'kodepos' => trim($user->kodepos),
                    'alamat' => trim($user->alamat),
                    'no_hp' => trim($user->no_hp),
                    'logged_in' => true,
                );
                $this->session->set_userdata($data);
                $this->Auth_model->update_user_token($user->userid, $token);
                $this->Log_model->create(
                    'auth/login',
                    'auth user login'
                );
                $this->Auth_model->output_json(['status' => true, 'msg' => 'berhasil login...']);
                // redirect(base_url());
            } else {
                $invalid = [
                    'username' => form_error('username'),
                    'password' => form_error('password'),
                ];
                $data = [
                    'status' => false,
                    'invalid' => $invalid,
                    'failed' => 'User ID / Password Invalid!!!',
                ];
                $this->Auth_model->output_json($data);
            }
        } 
        else {
            $invalid = [
                'username' => form_error('username'),
                'password' => form_error('password'),
            ];
            $data = [
                'status' => false,
                'invalid' => $invalid,
            ];
            $this->Auth_model->output_json($data);
        }
    }

    public function register()
    {
        $this->form_validation->set_rules('nama_lengkap', str_replace(':', '', 'Nama'), 'required|trim');
        $this->form_validation->set_rules('user_name', str_replace(':', '', 'Nama Pengguna'), 'required|trim');
        $this->form_validation->set_rules('password_reg', str_replace(':', '', 'Password'), 'required|trim');
        $this->form_validation->set_rules('user_group', str_replace(':', '', 'User Group'), 'required|trim');
        $this->form_validation->set_rules('propid', str_replace(':', '', 'Provinsi'), 'required|trim');
        $this->form_validation->set_rules('kabid', str_replace(':', '', 'Kabupaten/Kota'), 'required|trim');
        $this->form_validation->set_rules('kecid', str_replace(':', '', 'Kecamatan'), 'required|trim');
        $this->form_validation->set_rules('pasar_id', str_replace(':', '', 'Pasar'), 'required|trim');
        $this->form_validation->set_rules('kodepos', str_replace(':', '', 'Kode Pos'), 'required|trim');
        $this->form_validation->set_rules('no_hp', str_replace(':', '', 'No HP'), 'required|trim');
        $this->form_validation->set_rules('alamat', str_replace(':', '', 'Alamat'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');

        $kode=$this->Auth_model->generateIDUser();
        
        $userid = $kode;
        $nama_lengkap = $this->input->post('nama_lengkap');
        $user_name = $this->input->post('user_name');
        $password = $this->input->post('password_reg');
        $user_group = $this->input->post('user_group');
        $propid = $this->input->post('propid');
        $kabid = $this->input->post('kabid');
        $kecid = $this->input->post('kecid');
        $kodepos = $this->input->post('kodepos');
        $pasar_id = $user_group == '0003' ? $this->input->post('pasar_id') : '';
        $no_hp = $this->input->post('no_hp');
        $alamat = $this->input->post('alamat');
        
        $data = [
            'userid' => $userid,
            'nama_lengkap' => $nama_lengkap,
            'user_name' => $user_name,
            'password' => md5(sha1(crc32($password))),
            'user_group' => $user_group,
            'propid' => $propid,
            'kabid' => $kabid,
            'kecid' => $kecid,
            'pasar_id' => $pasar_id,
            'kodepos' => $kodepos,
            'no_hp' => $no_hp,
            'alamat' => $alamat,
            'user_insert' => $userid,
            'tgl_insert' => date('Y-m-d H:i:s'),
            'aktif' => 'y'
        ];
        $this->Admin_user_model->create($data);
        $this->Log_model->create(
            'auth/login',
            'auth user login'
        );
        $this->Auth_model->output_json(['status' => true, 'msg' => 'berhasil login...']);

        // echo json_encode($data);
        
    }

    // public function change_password()
    // {
    //     $this->form_validation->set_rules('username1', str_replace(':', '', 'Username required'), 'required|trim');
    //     $this->form_validation->set_rules('password1', str_replace(':', '', 'Password required'), 'required|trim');
    //     $this->form_validation->set_message('required', '{field} is required');

    //     $username1 = $this->input->post('username1');
    //     $password1 = $this->input->post('password1');
    //     $password2 = $this->input->post('password2');
    //     $password3 = $this->input->post('password3');
    //     $status = [
    //         'status' => false,
    //         'msg' => 'password lama salah / tidak sama!!!',
    //     ];

    //     if ($this->form_validation->run() === true) {
    //         $user = $this->Auth_model->login($username1, $password1);
    //         if ($user) {
    //             if (md5(sha1(crc32($password1))) == $user->password &&
    //                 $password2 != '' && 
    //                 $password2 == $password3) {
    //                 $where = [
    //                     'uid' => $user->uid
    //                 ];
    //                 $data = [
    //                     'password' => md5(sha1(crc32($password2))),
    //                 ];
    //                 $this->Auth_model->update($where, $data);
    //                 $this->Log_model->create(
    //                     'users/change_password',
    //                     'uid:' . $user->uid.'#user_id:' . $user->user_id.'#username:' . $user->user_name
    //                 );
    //                 $status = [
    //                     'status' => true,
    //                     'msg' => 'berhasil ubah password!!!',
    //                 ];
    //                 $this->Auth_model->logout();
    //             }
    //         }
    //     } 
    //     $this->Auth_model->output_json($status);
    // }

    public function logout()
    {
        $this->Log_model->create(
            'auth/logout',
            'auth user logout',
            false
        );
        $this->Auth_model->logout();
        redirect(base_url('auth'), 'refresh');
    }

    public function tes()
    {
        $list = $this->Admin_group_user_model->get_list_group_user();
        
        echo json_encode($list);
    }

    // public function save()
    // {
    //     $this->form_validation->set_rules('photo', str_replace(':', '', 'Photo'), 'required|trim');
    //     $this->form_validation->set_rules('nama_lengkap', str_replace(':', '', 'Nama'), 'required|trim');
    //     $this->form_validation->set_rules('user_name', str_replace(':', '', 'Nama Pengguna'), 'required|trim');
    //     $this->form_validation->set_rules('user_group', str_replace(':', '', 'Group User'), 'required|trim');
    //     $this->form_validation->set_rules('daerah', str_replace(':', '', 'Daerah'), 'required|trim');
    //     $this->form_validation->set_rules('no_hp', str_replace(':', '', 'No HP'), 'required|trim');
    //     $this->form_validation->set_rules('alamat', str_replace(':', '', 'Alamat'), 'required|trim');
    //     $this->form_validation->set_message('required', '{field} is required');

    //     $type = $this->input->post('type');
        
    //     $kode=$this->Admin_user_model->generateIDUser();
        
    //     $userid = $type == 'add' ? $kode : $this->input->post('userid');
    //     $nama_lengkap = $this->input->post('nama_lengkap');
    //     $user_name = $this->input->post('user_name');
    //     $password = $this->input->post('password');
    //     $user_group = $this->input->post('user_group');
    //     $daerah = $this->input->post('daerah');
    //     $no_hp = $this->input->post('no_hp');
    //     $alamat = $this->input->post('alamat');

    //     $data = [
    //         'userid' => $userid,
    //         'nama_lengkap' => $nama_lengkap,
    //         'user_name' => $user_name,
    //         'password' => md5(sha1(crc32($password))),
    //         'user_group' => $user_group,
    //         'daerah' => $daerah,
    //         'no_hp' => $no_hp,
    //         'alamat' => $alamat,
    //         'user_insert' => $this->session->userdata('userid'),
    //         'tgl_insert' => date('Y-m-d H:i:s'),
    //         'aktif' => 'y'
    //     ];
        
    //     if ($type == 'add') {
    //         $this->form_validation->set_rules('password', str_replace(':', '', 'Password required'), 'required|trim');
    //         if ($this->form_validation->run() === true) {
            
    //             $this->Admin_user_model->create($data);
    //             $this->Log_model->create(
    //                 'admin_user/save',
    //                 'type:' . $type . '#data:' . json_encode($data)
    //             );
    //             $this->Home_model->output_json(['status' => true, 'msg' => 'tambah user berhasil...']);
    //             // echo json_encode($data);
    //         } else {
    //             $invalid = [
    //                 'nama_lengkap' => form_error('nama_lengkap'),
    //                 'user_name' => form_error('user_name'),
    //                 'password' => form_error('password'),
    //                 'user_group' => form_error('user_group'),
    //                 'daerah' => form_error('daerah'),
    //                 'no_hp' => form_error('no_hp'),
    //                 'alamat' => form_error('alamat'),
    //             ];
    //             $data = [
    //                 'status' => false,
    //                 'invalid' => $invalid,
    //             ];
    //             $this->Home_model->output_json($data);
    //             // echo json_encode($data);
    //         }
    //     } 
        
    // }
}