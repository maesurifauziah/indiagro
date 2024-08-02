<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Order_model extends CI_Model
{
    public $table = 'order_summary';

    public function get_list_barang($typeTerm, $typeTerm2, $searchTerm)
    { 
        if ($typeTerm == 'all') {
        } else {
            $this->db->where('a.kategori_id', $typeTerm);
        }

        if ($typeTerm2 == 'all') {
        } else {
            $this->db->where('a.kode_barang', $typeTerm2);
        }

        if (!$searchTerm == '') {
            $this->db->like('c.nama_barang', $searchTerm);
        }

        $this->db->select('
            a.stock_id,
            a.kategori_id,
            a.kode_barang,
            a.kode_jenis_barang,
            d.nama_jenis_barang,
            a.harga,
            SUM( a.qty ) AS qty,
            a.photo_bukti_barang,
            a.keterangan,
            a.createdDate,
            a.userid,
            e.nama_lengkap,
            a.status,
            a.approveDate,
            a.approveBy,
            b.kategori_desc,
            c.nama_barang,
            a.status_barang,
            (
            CASE
                    
                    WHEN ( a.status_barang = "draft" ) THEN
                    "Draft" 
                    WHEN ( a.status_barang = "approve" ) THEN
                    "Approve" 
                    WHEN ( a.status_barang = "sold_out" ) THEN
                    "Habis" 
                    WHEN ( a.status_barang = "cancel" ) THEN
                    "Batal" 
                END 
            ) AS status_barang_desc,
            d.photo 
        
        ');
        $this->db->from('stock_barang a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id', 'LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->join('admin_user e', 'e.userid=a.userid');
        $this->db->where('a.status','y');
        // $this->db->where('a.userid', $this->session->userdata('userid'));
        $this->db->where('a.approveStatus', 'y');
        $this->db->where('a.status_barang', 'approve');
        $this->db->where('a.status', 'y');
        $this->db->group_by('
            a.kategori_id,
		    a.kode_barang,
		    a.kode_jenis_barang
        ');
        $this->db->order_by('c.nama_barang', 'ASC');
        
        return $this->db->get()->result();
    }
    
    public function get_list_barang_top3($searchTerm)
    { 
        $sql = "SELECT * 
                FROM order_id 
                WHERE nama_barang LIKE '%".$searchTerm."%'
                    AND status = 'y'
                ORDER BY nama_barang ASC
                LIMIT 0,3";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_list_barang_aktif_by_id($kode_barang)
    { 
        $this->db->select('*');
        $this->db->from('order_id');
        $this->db->where('kode_barang', $kode_barang);
        return $this->db->get()->result();
    }

    public function generateIDOrder()
    {
        $date  = date("Ymd");
        $userid = $this->session->userdata('userid');
        $code = "O".$date.$userid;
        $sql = 'SELECT MAX(RIGHT(order_id,3)) as id
				  FROM order_summary
                  WHERE LEFT(order_id,15) = "'.$code.'"           
                  ORDER BY order_id DESC';

        $result = $this->db->query($sql)->row();
        $id_last = $result->id;
        $id_new = $id_last+1;
        
        if ($id_new<10) {
            $id = $code."00".$id_new;
        } elseif (($id_new>=10)&&($id_new<=99)) {
            $id = $code."0".$id_new;
        } elseif (($id_new>=100)&&($id_new<=999)) {
            $id = $code.$id_new;
        }

        $generateID = $id;

        return $generateID;
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

    // list yang muncul di keranjang sebelum di checkout
    public function get_list_order()
    { 
        $this->db->select('a.*, b.nama_jenis_barang, b.photo');
        $this->db->from('order_summary a');
        $this->db->join('master_jenis_barang b', 'b.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->where('a.userid', $this->session->userdata('userid'));
        $this->db->where('a.status_order', 'draft');
        $this->db->where('a.status', 'y');
        return $this->db->get()->result();
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
}