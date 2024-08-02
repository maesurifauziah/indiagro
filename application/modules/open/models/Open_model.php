<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Open_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_provinsi_by_id($id)
    {
        $this->db->select(
            'a.propid,
            a.propinsi_desc,
            a.status'
        );
        $this->db->from('wilayah_propinsi a');
        $this->db->where('a.propid', $id);
        $this->db->where('a.status', '1');

        return $this->db->get()->result();
    }
}
