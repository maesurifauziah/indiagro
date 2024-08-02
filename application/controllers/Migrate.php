<?php

class Migrate extends CI_Controller
{

    public function index()
    {
        $this->load->library('migration');
        $data = [];
        $version = $this->input->get('version');
        if ($version){
            if ($this->migration->version($version) === FALSE)
            {
                $data = [
                    'status' => FALSE,
                    'message' => $this->migration->error_string(),
                ];
            }else{
                $data = [
                    'status' => TRUE,
                    'message' => 'migrate success...',
                ];
            }    
        }else{
            $data = [
                'status' => FALSE,
                'message' => 'version empty!!!',
            ];
        }
        echo json_encode($data);
    }

}