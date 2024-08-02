<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class V1_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function login($username, $password)
    {
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
        $this->db->where('a.user_name', $username);
        $this->db->where('a.password', md5(sha1(crc32($password))));

        return $this->db->get()->row();
    }

    public function get_list_order()
    { 
        $this->db->select('a.*, b.nama_jenis_barang, b.photo');
        $this->db->from('order_summary a');
        $this->db->join('master_jenis_barang b', 'b.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        // $this->db->where('a.userid', $this->session->userdata('userid'));
        // $this->db->where('a.status_order', 'draft');
        $this->db->where('a.status', 'y');
        return $this->db->get()->result();
    }

    public function get_list_order_by_id($order_id)
    { 
        $this->db->select('a.*, b.nama_jenis_barang, b.photo');
        $this->db->from('order_summary a');
        $this->db->join('master_jenis_barang b', 'b.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        // $this->db->where('a.userid', $this->session->userdata('userid'));
        // $this->db->where('a.status_order', 'draft');
        $this->db->where('a.order_id', $order_id);
        $this->db->where('a.status', 'y');
        return $this->db->get()->row();
    }

    public function get_list_barang()
    { 
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
            CONCAT("'.base_url().'", "upload/master_barang/", d.photo) AS photo
        
        ');
        $this->db->from('stock_barang a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id', 'LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->join('admin_user e', 'e.userid=a.userid');
        $this->db->where('a.status','y');
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

    public function get_list_barang_by_id($stock_id)
    { 
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
            CONCAT("'.base_url().'", "upload/master_barang/", d.photo) AS photo
        
        ');
        $this->db->from('stock_barang a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id', 'LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->join('admin_user e', 'e.userid=a.userid');
        $this->db->where('a.stock_id',$stock_id);
        $this->db->where('a.status','y');
        $this->db->where('a.approveStatus', 'y');
        $this->db->where('a.status_barang', 'approve');
        $this->db->where('a.status', 'y');
        $this->db->group_by('
            a.kategori_id,
		    a.kode_barang,
		    a.kode_jenis_barang
        ');
        $this->db->order_by('c.nama_barang', 'ASC');
        
        return $this->db->get()->row();
    }

   

}
