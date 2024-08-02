<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Keranjang_model extends CI_Model
{
    public $table = 'transaksi_header';
    public $table2 = 'transaksi_detail';

    public function __construct()
    {
        parent::__construct();
    }
    

    public function create($data, $batch = false)
    {
        if ($batch === false) {
            $insert = $this->db->insert($this->table, $data);
        } else {
            $insert = $this->db->insert_batch($this->table, $data);
        }
        return $insert;
    }

    public function create_hd($header, $detail)
    {
        $this->db->insert($this->table, $header);
        $this->db->insert_batch($this->table2, $detail);
        return TRUE;
    }

    public function update($data, $pk, $id = null, $batch = false)
    {
        if ($id === null) {
            $update = $this->db->update($this->table, $data);
        }
        if ($batch === false) {
            $update = $this->db->update($this->table, $data, array($pk => $id));
        } else {
            $update = $this->db->update_batch($this->table, $data, $pk);
        }
        return $update;
    }

    public function generateIDTransaksi()
    {
        $date  = date("Ym");
        $code = "TR".$date;
        $sql = 'SELECT MAX(RIGHT(trans_id,6)) as id
				  FROM transaksi_header
                  WHERE LEFT(trans_id,8) = "'.$code.'"           
                  ORDER BY trans_id DESC';

        $result = $this->db->query($sql)->row();
        $id_last = $result->id;
        $id_new = $id_last+1;
        
        if ($id_new<10) {
            $id = $code."00000".$id_new;
        } elseif (($id_new>=10)&&($id_new<=99)) {
            $id = $code."0000".$id_new;
        } elseif (($id_new>=100)&&($id_new<=999)) {
            $id = $code."000".$id_new;
        } elseif (($id_new>=1000)&&($id_new<=9999)) {
            $id = $code."00".$id_new;
        } elseif (($id_new>=10000)&&($id_new<=99999)) {
            $id = $code."0".$id_new;
        } elseif (($id_new>=100000)&&($id_new<=999999)) {
            $id = $code.$id_new;
        }

        $generateID = $id;

        return $generateID;
    }

}
