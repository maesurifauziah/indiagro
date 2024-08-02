<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_group_user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Admin_group_user_model',
            'home/Home_model',
            'admin_menu/Admin_menu_model',
            'log/Log_model',
        ]);
        $this->load->library(['form_validation']);
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url().'auth', 'refresh');
        }
    }

    public function index()
    {
        $data = [
            'title'=>'Group User',
            'css'=>'<link href="'.base_url().'assets/css/pages/admin_group_user.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/admin_group_user.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('admin_group_user/admin_group_user_view', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    
    public function admin_group_user_list()
    {
        $list = $this->Admin_group_user_model->get_datatables();
        $data = array();
        $no = 0;
        
        foreach ($list as $list) {
            $data_bind = '
                data-user_group="'.$list->user_group.'" 
                data-group_name="'.$list->group_name.'" 
                data-aktif="'.$list->aktif.'"  
            ';

            $icon = $list->aktif == 'y' ? 'la la-close' : 'la la-check';
            $btn = $list->aktif == 'y' ? 'btn-light-danger' : 'btn-light-success';


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
                'user_group' => $list->user_group,
                'group_name' => $list->group_name,
                'aktif' => $list->aktif,
                'action' => $select
            );
            
            // $data[] = $row;
        }

        $output = array(
                'recordsTotal' => $this->Admin_group_user_model->count_all(),
                'recordsFiltered' => $this->Admin_group_user_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function save()
    {
        $this->form_validation->set_rules('group_name', str_replace(':', '', 'Nama'), 'required|trim');
        $this->form_validation->set_message('required', '{field} is required');
        
        $type = $this->input->post('type');

        $kode=$this->Admin_group_user_model->generateIDUserGroup();

        $user_group = $type == 'add' ? $this->Admin_group_user_model->generateIDUserGroup() : $this->input->post('user_group');
        $group_name = $this->input->post('group_name');

        $data = [
            'user_group' => $user_group,
            'group_name' => $group_name,
        ];

        if ($type == 'edit') {
            $this->form_validation->set_rules('user_group', str_replace(':', '', 'ID'), 'required|trim');
        }

        if ($this->form_validation->run() === true) {
            if ($type == 'add') {
                $data['createdDate'] = date('Y-m-d H:i:s');
                $data['aktif'] = 'y';
                $this->Admin_group_user_model->create($data);
                $this->Log_model->create(
                    'admin_group_user/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'tambah group berhasil...']);
            } 
            else if ($type == 'edit') {
                $data['modifiedDate'] = date('Y-m-d H:i:s');
                $this->Admin_group_user_model->update($data, 'user_group', $user_group);
                $this->Log_model->create(
                    'admin_group_user/save',
                    'type:' . $type . '#data:' . json_encode($data)
                );
                $this->Home_model->output_json(['status' => true, 'msg' => 'edit group berhasil...']);

            }
        } else {
            $invalid = [
                'user_group' => form_error('user_group'),
                'group_name' => form_error('group_name'),
            ];
            $data = [
                'status' => false,
                'invalid' => $invalid,
            ];
            $this->Home_model->output_json($data);
        }
    }

    public function aktif($id)
    {
        $aktif = $this->input->post('aktif') == 'y' ? 'n' : 'y';
        $data = [
            'aktif' => $aktif,
        ];
        $this->Admin_group_user_model->update($data, 'user_group', $id);
        $this->Log_model->create(
            'admin_group_user/aktif/' . $id,
            'aktif:' . $aktif
        );
        $this->Home_model->output_json(['status' => true]);
    }
}