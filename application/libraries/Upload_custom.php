<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_custom {

    public function upload_img($folder, $filename, $img)
    {
        if (!is_dir('upload')) {
            mkdir('upload', 0777, true);
        }
        if (!is_dir('upload/img')) {
            mkdir('upload/img', 0777, true);
        }
        if (!is_dir('upload/img/'.$folder)) {
            mkdir('upload/img/'.$folder, 0777, true);
        }
        $path='upload/img/'.$folder.'/';
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $path.$filename.'.png';
        file_put_contents($file, $data);
        return $file;
    }

    public function upload_file_img($folder, $filename)
    {
        $this->load->library('upload');
        if (!is_dir('upload')) {
            mkdir('upload', 0777, true);
        }
        if (!is_dir('upload/img')) {
            mkdir('upload/img', 0777, true);
        }
        if (!is_dir('upload/img/'.$folder)) {
            mkdir('upload/img/'.$folder, 0777, true);
        }
        $config['upload_path'] = 'upload/img';
        $config['allowed_types'] = 'jpg|jpeg|png|ico|bmp';
        // $config['max_size']	= '2048';
        $config['overwrite'] = true;
        //$filename= $_FILES["file_excel"]["name"];
        $config['file_name'] = $filename;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('file_image')) {
            $res = array('status' => true, 'file' => $this->upload->data(), 'error' => '');
            return $res;
        } else {
            $res = array('status' => false, 'file' => '', 'error' => $this->upload->display_errors());
            return $res;
        }
    }

    public function upload_file_excel($filename)
    {
        $this->load->library('upload');
        if (!is_dir('upload')) {
            mkdir('upload', 0777, true);
        }
        if (!is_dir('upload/excel')) {
            mkdir('upload/excel', 0777, true);
        }
        $config['upload_path'] = 'upload/excel';
        $config['allowed_types'] = 'xls|xlsx';
        // $config['max_size']	= '2048';
        $config['overwrite'] = true;
        //   $filename= $_FILES["file_excel"]["name"];
        $config['file_name'] = $filename;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('file_excel')) {
            $res = array('status' => true, 'file' => $this->upload->data(), 'error' => '');
            return $res;
        } else {
            $res = array('status' => false, 'file' => '', 'error' => $this->upload->display_errors());
            return $res;
        }
    }

    public function folder_photo($folder)
    {
        $photo = $_FILES["photo"]["tmp_name"];
        $filename = $_FILES["photo"]["name"];

        //upload
        if (!is_dir('upload')) {
            mkdir('./upload', 0777, true);
        }

        if (!is_dir('./upload/' . $folder)) {
            mkdir('./upload/' . $folder, 0777, true);
        }
       
        //folderpath
        $folderpath = './upload/' . $folder . '/';


        $data = [
            'filename'=>$filename,
            'folderpath'=>$folderpath,
        ];
        return $data;
    }

    public function folder_photo2($folder,$nama_inputan)
    {
        $photo = $_FILES[$nama_inputan]["tmp_name"];
        $filename = $_FILES[$nama_inputan]["name"];

        //upload
        if (!is_dir('upload')) {
            mkdir('./upload', 0777, true);
        }

        if (!is_dir('./upload/' . $folder)) {
            mkdir('./upload/' . $folder, 0777, true);
        }
       
        //folderpath
        $folderpath = './upload/' . $folder . '/';


        $data = [
            'filename'=>$filename,
            'folderpath'=>$folderpath,
        ];
        return $data;
    }
}