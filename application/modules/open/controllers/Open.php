<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Open extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model([
            'Open_model',
            'wilayah_kabupaten/Wilayah_kabupaten_model',
            'wilayah_kecamatan/Wilayah_kecamatan_model',
            'master_pasar/Master_pasar_model',
        ]);
       
    }

    public function index()
    {
        $data = [];

      echo json_encode('open');
    }

    public function get_kab_kot_by_propid($id)
    {
        $data = $this->Wilayah_kabupaten_model->get_kab_kot_by_propid($id);
        echo json_encode($data);
    }
    public function get_kecamatan_by_kabid($id)
    {
        $data = $this->Wilayah_kecamatan_model->get_kecamatan_by_kabid($id);
        echo json_encode($data);
    }
    public function get_pasar_by_kecid($id)
    {
        $data = $this->Master_pasar_model->get_pasar_by_kecid($id);
        echo json_encode($data);
    }
    public function get_kecamatan_by_id_row($id)
    {
        $data = $this->Wilayah_kecamatan_model->get_kecamatan_by_id_row($id);
        echo json_encode($data->kodepos);
    }


    
    
}