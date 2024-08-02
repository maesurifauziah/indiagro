<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';

class V1 extends REST_Controller
{

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model([
            'V1_model',
        ]);
    }

    public function isValidJSON($str)
    {
        json_decode($str);
        return json_last_error() == JSON_ERROR_NONE;
    }

    public function index_get()
    {
        $this->response([
            'status' => true,
            'msg' => 'connect get',
        ], 200);
    }
    
    function login_post() {
        $res = $this->V1_model->login($this->post('user_name'), $this->post('password'));
        if ($res) {
            // $token = $this->V1_model->update_token($res);
            $this->response([
                'error' => false,
                'message' => 'OK',
                'loginResult' => [
                    'userid' => $res->userid,
                    'photo' => base_url()."upload/admin_user/".$res->photo,
                    'user_name' => $res->user_name,
                    'nama_lengkap' => $res->nama_lengkap,
                    'user_group' => $res->user_group,
                    'pasar_id' => $res->pasar_id,
                    'propid' => $res->propid,
                    'kabid' => $res->kabid,
                    'kecid' => $res->kecid,
                    'kodepos' => $res->kodepos,
                    'alamat' => $res->alamat,
                    'no_hp' => $res->no_hp,
                ],
            ], 200);
        } else {
            $this->response([
                'error' => true,
                'message' => 'Username / Password Incorrect',
            ], 200);
        }
    }


    // function list_order_get() {
    //     $data = $this->V1_model->get_list_order();
    //     // $this->response($data, 200);
    //     $this->response([
    //         'error' => false,
    //         'message' => 'get list order success',
    //         'listOrder' => $data,
    //     ], 200);
    // }

    // function list_barang_get() {
    //     $data = $this->V1_model->get_list_barang_by_id($this->get('stock_id'));
        
    //     $id = $this->get('stock_id');
    //     if ($id == '') {
    //         $data = $this->V1_model->get_list_barang();
    //     } else {
    //         $data = $this->V1_model->get_list_barang_by_id($id);
    //     }
    //     $this->response([
    //         'error' => false,
    //         'message' => 'get list barang success',
    //         'listBarang' => $data,
    //     ], 200);
    // }
    
    function list_order_get() {
      $id = $this->get('order_id');
        if ($id == '') {
            $data = $this->V1_model->get_list_order();
            $this->response([
                'error' => false,
                'message' => 'get list order success',
                'listOrder' => $data,
            ], 200);
        } else {
            $data = $this->V1_model->get_list_order_by_id($id);
            $this->response([
                'error' => false,
                'message' => 'get list order success',
                'order' => $data,
            ], 200);
        }
    }

    function list_barang_get() {
      $id = $this->get('stock_id');
        if ($id == '') {
            $data = $this->V1_model->get_list_barang();
            $this->response([
                'error' => false,
                'message' => 'get list barang success',
                'listBarang' => $data,
            ], 200);
        } else {
            $data = $this->V1_model->get_list_barang_by_id($id);
            $this->response([
                'error' => false,
                'message' => 'get list barang success',
                'barang' => $data,
            ], 200);
        }
        
    }

}
