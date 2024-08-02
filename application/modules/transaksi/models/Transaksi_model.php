<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Transaksi_model extends CI_Model
{
    public $table = 'transaksi_header';
    public $table2 = 'transaksi_detail';
    
    public function get_list_order_checkout()
    { 
        $this->db->select('
                            a.trans_id,
                            a.order_id,
                            a.userid,
                            e.nama_lengkap,
                            a.detailid,
                            a.kategori_id,
                            b.kategori_desc,
                            a.kode_barang,
                            c.nama_barang,
                            a.kode_jenis_barang,
                            d.nama_jenis_barang,
                            d.photo,
                            a.harga,
                            a.qty,
                            a.harga_total,
                            a.qty_order,
                            a.status,
                            a.status_order,
                            (
                                CASE
                                        
                                        WHEN ( a.status_order = "checkout" ) THEN
                                        "Checkout" 
                                        WHEN ( a.status_order = "lunas" ) THEN
                                        "Lunas" 
                                        WHEN ( a.status_order = "packing" ) THEN
                                        "Dikemas" 
                                        WHEN ( a.status_order = "pengiriman" ) THEN
                                        "Dikirim" 
                                        WHEN ( a.status_order = "done" ) THEN
                                        "Selesai" 
                                        WHEN ( a.status_order = "cancel" ) THEN
                                        "Batal" 
                                    END 
                            ) AS status_order_desc,
                            a.createdDate,
                            a.createdDatePacking,
                            a.createdStatusPacking,
                            a.createdByPengiriman,
                            a.createdDatePengiriman,
                            a.createdStatusPengiriman,
                            a.createdByLunas,
                            a.createdDateLunas,
                            a.createdStatusLunas,
                            a.createdDateDone,
                            a.createdStatusDone,
                            a.createdDateCancel,
                            a.createdStatusCancel,
                            a.createCancelNote,
                            a.kurir_id,
                            f.nama_lengkap as nama_kurir,
                            g.alamat_kirim
        ');
        $this->db->from($this->table2.' a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id', 'LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->join('admin_user e', 'e.userid=a.userid', 'LEFT');
        $this->db->join('admin_user f', 'f.userid=a.kurir_id', 'LEFT');
        $this->db->join($this->table.' g', 'g.trans_id=a.trans_id', 'LEFT');
        $this->db->where('a.userid', $this->session->userdata('userid'));
        $this->db->where('a.status_order', 'checkout');
        // $this->db->where('a.createdStatusPacking', 'n');
        // $this->db->where('a.createdStatusPengiriman', 'n');
        // $this->db->where('a.createdStatusLunas', 'n');
        // $this->db->where('a.createdStatusDone', 'n');
        // $this->db->where('a.createdStatusCancel', 'n');
        
        $this->db->order_by('a.createdDate', 'ASC');
        
        return $this->db->get()->result();
    }
    
    public function get_list_order_packing()
    { 
        $this->db->select('
                            a.trans_id,
                            a.order_id,
                            a.userid,
                            e.nama_lengkap,
                            a.detailid,
                            a.kategori_id,
                            b.kategori_desc,
                            a.kode_barang,
                            c.nama_barang,
                            a.kode_jenis_barang,
                            d.nama_jenis_barang,
                            d.photo,
                            a.harga,
                            a.qty,
                            a.harga_total,
                            a.qty_order,
                            a.status,
                            a.status_order,
                            (
                                CASE
                                        
                                        WHEN ( a.status_order = "checkout" ) THEN
                                        "Checkout" 
                                        WHEN ( a.status_order = "lunas" ) THEN
                                        "Lunas" 
                                        WHEN ( a.status_order = "packing" ) THEN
                                        "Dikemas" 
                                        WHEN ( a.status_order = "pengiriman" ) THEN
                                        "Dikirim" 
                                        WHEN ( a.status_order = "done" ) THEN
                                        "Selesai" 
                                        WHEN ( a.status_order = "cancel" ) THEN
                                        "Batal" 
                                    END 
                            ) AS status_order_desc,
                            a.createdDate,
                            a.createdDatePacking,
                            a.createdStatusPacking,
                            a.createdByPengiriman,
                            a.createdDatePengiriman,
                            a.createdStatusPengiriman,
                            a.createdByLunas,
                            a.createdDateLunas,
                            a.createdStatusLunas,
                            a.createdDateDone,
                            a.createdStatusDone,
                            a.createdDateCancel,
                            a.createdStatusCancel,
                            a.createCancelNote,
                            a.kurir_id,
                            f.nama_lengkap as nama_kurir,
                            g.alamat_kirim
        ');
        $this->db->from($this->table2.' a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id', 'LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->join('admin_user e', 'e.userid=a.userid', 'LEFT');
        $this->db->join('admin_user f', 'f.userid=a.kurir_id', 'LEFT');
        $this->db->join($this->table.' g', 'g.trans_id=a.trans_id', 'LEFT');
        $this->db->where('a.userid', $this->session->userdata('userid'));
        $this->db->where('a.status_order', 'packing');
        // $this->db->where('a.createdStatusPacking', 'y');
        // $this->db->where('a.createdStatusPengiriman', 'n');
        // $this->db->where('a.createdStatusLunas', 'n');
        // $this->db->where('a.createdStatusDone', 'n');
        // $this->db->where('a.createdStatusCancel', 'n');
        
        $this->db->order_by('a.createdDate', 'ASC');
        
        return $this->db->get()->result();
    }
    
    public function get_list_order_pengiriman()
    { 
        $this->db->select('
                            a.trans_id,
                            a.order_id,
                            a.userid,
                            e.nama_lengkap,
                            a.detailid,
                            a.kategori_id,
                            b.kategori_desc,
                            a.kode_barang,
                            c.nama_barang,
                            a.kode_jenis_barang,
                            d.nama_jenis_barang,
                            d.photo,
                            a.harga,
                            a.qty,
                            a.harga_total,
                            a.qty_order,
                            a.status,
                            a.status_order,
                            (
                                CASE
                                        
                                        WHEN ( a.status_order = "checkout" ) THEN
                                        "Checkout" 
                                        WHEN ( a.status_order = "lunas" ) THEN
                                        "Lunas" 
                                        WHEN ( a.status_order = "packing" ) THEN
                                        "Dikemas" 
                                        WHEN ( a.status_order = "pengiriman" ) THEN
                                        "Dikirim" 
                                        WHEN ( a.status_order = "done" ) THEN
                                        "Selesai" 
                                        WHEN ( a.status_order = "cancel" ) THEN
                                        "Batal" 
                                    END 
                            ) AS status_order_desc,
                            a.createdDate,
                            a.createdDatePacking,
                            a.createdStatusPacking,
                            a.createdByPengiriman,
                            a.createdDatePengiriman,
                            a.createdStatusPengiriman,
                            a.createdByLunas,
                            a.createdDateLunas,
                            a.createdStatusLunas,
                            a.createdDateDone,
                            a.createdStatusDone,
                            a.createdDateCancel,
                            a.createdStatusCancel,
                            a.createCancelNote,
                            a.kurir_id,
                            f.nama_lengkap as nama_kurir,
                            g.alamat_kirim
        ');
        $this->db->from($this->table2.' a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id', 'LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->join('admin_user e', 'e.userid=a.userid', 'LEFT');
        $this->db->join('admin_user f', 'f.userid=a.kurir_id', 'LEFT');
        $this->db->join($this->table.' g', 'g.trans_id=a.trans_id', 'LEFT');
        $this->db->where('a.userid', $this->session->userdata('userid'));
        $this->db->where('a.status_order', 'pengiriman');
        // $this->db->where('a.createdStatusPacking', 'y');
        // $this->db->where('a.createdStatusPengiriman', 'y');
        // $this->db->where('a.createdStatusLunas', 'n');
        // $this->db->where('a.createdStatusDone', 'n');
        // $this->db->where('a.createdStatusCancel', 'n');
        
        $this->db->order_by('a.createdDate', 'ASC');
        
        return $this->db->get()->result();
    }
    
    public function get_list_order_lunas()
    { 
        $this->db->select('
                            a.trans_id,
                            a.order_id,
                            a.userid,
                            e.nama_lengkap,
                            a.detailid,
                            a.kategori_id,
                            b.kategori_desc,
                            a.kode_barang,
                            c.nama_barang,
                            a.kode_jenis_barang,
                            d.nama_jenis_barang,
                            d.photo,
                            a.harga,
                            a.qty,
                            a.harga_total,
                            a.qty_order,
                            a.status,
                            a.status_order,
                            (
                                CASE
                                        
                                        WHEN ( a.status_order = "checkout" ) THEN
                                        "Checkout" 
                                        WHEN ( a.status_order = "lunas" ) THEN
                                        "Lunas" 
                                        WHEN ( a.status_order = "packing" ) THEN
                                        "Dikemas" 
                                        WHEN ( a.status_order = "pengiriman" ) THEN
                                        "Dikirim" 
                                        WHEN ( a.status_order = "done" ) THEN
                                        "Selesai" 
                                        WHEN ( a.status_order = "cancel" ) THEN
                                        "Batal" 
                                    END 
                            ) AS status_order_desc,
                            a.createdDate,
                            a.createdDatePacking,
                            a.createdStatusPacking,
                            a.createdByPengiriman,
                            a.createdDatePengiriman,
                            a.createdStatusPengiriman,
                            a.createdByLunas,
                            a.createdDateLunas,
                            a.createdStatusLunas,
                            a.createdDateDone,
                            a.createdStatusDone,
                            a.createdDateCancel,
                            a.createdStatusCancel,
                            a.createCancelNote,
                            a.kurir_id,
                            f.nama_lengkap as nama_kurir,
                            g.alamat_kirim
        ');
        $this->db->from($this->table2.' a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id', 'LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->join('admin_user e', 'e.userid=a.userid', 'LEFT');
        $this->db->join('admin_user f', 'f.userid=a.kurir_id', 'LEFT');
        $this->db->join($this->table.' g', 'g.trans_id=a.trans_id', 'LEFT');
        $this->db->where('a.userid', $this->session->userdata('userid'));
        $this->db->where('a.status_order', 'lunas');
        // $this->db->where('a.createdStatusPacking', 'y');
        // $this->db->where('a.createdStatusPengiriman', 'y');
        // $this->db->where('a.createdStatusLunas', 'y');
        // $this->db->where('a.createdStatusDone', 'n');
        // $this->db->where('a.createdStatusCancel', 'n');
        
        $this->db->order_by('a.createdDate', 'ASC');
        
        return $this->db->get()->result();
    }
    
    public function get_list_order_done()
    { 
        $this->db->select('
                            a.trans_id,
                            a.order_id,
                            a.userid,
                            e.nama_lengkap,
                            a.detailid,
                            a.kategori_id,
                            b.kategori_desc,
                            a.kode_barang,
                            c.nama_barang,
                            a.kode_jenis_barang,
                            d.nama_jenis_barang,
                            d.photo,
                            a.harga,
                            a.qty,
                            a.harga_total,
                            a.qty_order,
                            a.status,
                            a.status_order,
                            (
                                CASE
                                        
                                        WHEN ( a.status_order = "checkout" ) THEN
                                        "Checkout" 
                                        WHEN ( a.status_order = "lunas" ) THEN
                                        "Lunas" 
                                        WHEN ( a.status_order = "packing" ) THEN
                                        "Dikemas" 
                                        WHEN ( a.status_order = "pengiriman" ) THEN
                                        "Dikirim" 
                                        WHEN ( a.status_order = "done" ) THEN
                                        "Selesai" 
                                        WHEN ( a.status_order = "cancel" ) THEN
                                        "Batal" 
                                    END 
                            ) AS status_order_desc,
                            a.createdDate,
                            a.createdDatePacking,
                            a.createdStatusPacking,
                            a.createdByPengiriman,
                            a.createdDatePengiriman,
                            a.createdStatusPengiriman,
                            a.createdByLunas,
                            a.createdDateLunas,
                            a.createdStatusLunas,
                            a.createdDateDone,
                            a.createdStatusDone,
                            a.createdDateCancel,
                            a.createdStatusCancel,
                            a.createCancelNote,
                            a.kurir_id,
                            f.nama_lengkap as nama_kurir,
                            g.alamat_kirim
        ');
        $this->db->from($this->table2.' a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id', 'LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->join('admin_user e', 'e.userid=a.userid', 'LEFT');
        $this->db->join('admin_user f', 'f.userid=a.kurir_id', 'LEFT');
        $this->db->join($this->table.' g', 'g.trans_id=a.trans_id', 'LEFT');
        $this->db->where('a.userid', $this->session->userdata('userid'));
        $this->db->where('a.status_order', 'done');
        // $this->db->where('a.createdStatusPacking', 'y');
        // $this->db->where('a.createdStatusPengiriman', 'y');
        // $this->db->where('a.createdStatusLunas', 'y');
        // $this->db->where('a.createdStatusDone', 'y');
        // $this->db->where('a.createdStatusCancel', 'n');
        
        $this->db->order_by('a.createdDate', 'ASC');
        
        return $this->db->get()->result();
    }

    public function get_list_order_cancel()
    { 
        $this->db->select('
                            a.trans_id,
                            a.order_id,
                            a.userid,
                            e.nama_lengkap,
                            a.detailid,
                            a.kategori_id,
                            b.kategori_desc,
                            a.kode_barang,
                            c.nama_barang,
                            a.kode_jenis_barang,
                            d.nama_jenis_barang,
                            d.photo,
                            a.harga,
                            a.qty,
                            a.harga_total,
                            a.qty_order,
                            a.status,
                            a.status_order,
                            (
                                CASE
                                        
                                        WHEN ( a.status_order = "checkout" ) THEN
                                        "Checkout" 
                                        WHEN ( a.status_order = "lunas" ) THEN
                                        "Lunas" 
                                        WHEN ( a.status_order = "packing" ) THEN
                                        "Dikemas" 
                                        WHEN ( a.status_order = "pengiriman" ) THEN
                                        "Dikirim" 
                                        WHEN ( a.status_order = "done" ) THEN
                                        "Selesai" 
                                        WHEN ( a.status_order = "cancel" ) THEN
                                        "Batal" 
                                    END 
                            ) AS status_order_desc,
                            a.createdDate,
                            a.createdDatePacking,
                            a.createdStatusPacking,
                            a.createdByPengiriman,
                            a.createdDatePengiriman,
                            a.createdStatusPengiriman,
                            a.createdByLunas,
                            a.createdDateLunas,
                            a.createdStatusLunas,
                            a.createdDateDone,
                            a.createdStatusDone,
                            a.createdDateCancel,
                            a.createdStatusCancel,
                            a.createCancelNote,
                            a.kurir_id,
                            f.nama_lengkap as nama_kurir,
                            g.alamat_kirim
        ');
        $this->db->from($this->table2.' a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id', 'LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->join('admin_user e', 'e.userid=a.userid', 'LEFT');
        $this->db->join('admin_user f', 'f.userid=a.kurir_id', 'LEFT');
        $this->db->join($this->table.' g', 'g.trans_id=a.trans_id', 'LEFT');
        $this->db->where('a.userid', $this->session->userdata('userid'));
        $this->db->where('a.status_order', 'cancel');
        // $this->db->where('a.createdStatusCancel', 'y');
        
        $this->db->order_by('a.createdDate', 'ASC');
        
        return $this->db->get()->result();
    }

    

   
}