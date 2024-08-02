<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tes2 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Tes2_model',
            'home/Home_model',
            'log/Log_model',
        ]);
        $this->load->library(['form_validation']);
      
    }

    public function index()
    {
        $data = [
            'title'=>'Group User',
            'css'=>'<link href="'.base_url().'assets/css/pages/tes.css" rel="stylesheet" type="text/css" />',
            'script'=>'<script src="'.base_url().'assets/js/pages/tes.js"></script>',
        ];

        $this->load->view('home/template/head', $data);
        $this->load->view('tes2/tes_view', $data);
        $this->load->view('home/template/footer', $data);
        
    }

    
    function save()
    {
        $kode=$this->Tes2_model->generateIDUser();
        $userid = $kode;

        $photo = $_FILES["photo"]["tmp_name"];
        if (isset($photo)) {
            $filename = $_FILES["photo"]["name"];
            $extension_file = pathinfo($filename, PATHINFO_EXTENSION);

            $zip = $this->Tes2_model->folder_photo('admin_user');
            move_uploaded_file($photo, $zip['folderpath'] . $userid.'.'.$extension_file);
            $data['photo'] = str_replace("/", "", $userid . "." . $extension_file);
            $this->Home_model->output_json(['status' => true, 'msg' => 'success upload...']);
            // echo json_encode($data);
        }

    }

}