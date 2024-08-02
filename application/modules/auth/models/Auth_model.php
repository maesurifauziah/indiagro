<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Auth_model extends CI_Model
{

    public function output_json($data, $encode = true)
    {
        if ($encode) {
            $data = json_encode($data);
        }

        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function update($where, $data)
    {
        $this->db->update('admin_user', $data, $where);

        return true;
    }

    public function login($username, $password)
    {
        $this->db->where('a.user_name', $username);
        $this->db->where('a.password', md5(sha1(crc32($password))));
        $this->db->where('a.aktif', 'y');
        $this->db->select('
                            a.uid,
                            a.photo,
                            a.userid,
                            a.user_name,
                            a.nama_lengkap,
                            a.password,
                            a.tgl_insert,
                            a.tgl_last_login,
                            a.user_insert,
                            a.user_group,
                            a.aktif,
                            a.pasar_id,
                            a.propid,
                            a.kabid,
                            a.kecid,
                            a.kodepos,
                            a.alamat,
                            a.no_hp
                        ');
        $this->db->from('admin_user a');

        return $this->db->get()->row();
    }

    public function update_user_token($userid, $token)
    {
        $result = FALSE;
        if ($userid != "") {
            $data = array(
                'token'=> $token,
                'tgl_last_login'=> date('Y-m-d H:i:s'),
            );
            $this->db->where('userid', $userid);
            $this->db->update('admin_user', $data);
            $result = TRUE;
        }

        return $result;
    }

    public function logout()
    {
        $data = array(
            'uid',
            'photo',
            'userid',
            'user_name',
            'nama_lengkap',
            'user_name',
            'alamat',
            'pasar_id',
            'propid',
            'kabid',
            'kecid',
            'kodepos',
            'no_hp',
            'logged_in',
        );
        $this->session->unset_userdata($data);
    }

    public function generateIDUser()
    {
        $code = "U";

        $sql = 'SELECT MAX(RIGHT(userid,5)) as id
				  FROM admin_user
                  WHERE LEFT(userid,1)="'.$code.'"
                  ORDER BY userid DESC';

        $result = $this->db->query($sql)->row();
        $id_last = $result->id;
        $id_new = $id_last+1;
        
        if ($id_new<10) {
            $id = $code."0000".$id_new;
        } elseif (($id_new>=10)&&($id_new<=99)) {
            $id = $code."000".$id_new;
        } elseif (($id_new>=100)&&($id_new<=999)) {
            $id = $code."00".$id_new;
        } elseif (($id_new>=1000)&&($id_new<=9999)) {
            $id = $code."0".$id_new;
        } elseif (($id_new>=10000)&&($id_new<=99999)) {
            $id = $code.$id_new;
        }

        $generateID = $id;

        return $generateID;
    }
}
