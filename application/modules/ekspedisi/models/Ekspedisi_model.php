<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ekspedisi_model extends CI_Model
{
    public $table = 'transaksi_header';
    public $table2 = 'transaksi_detail';

    // public function get_list_order_ready_delivery()
    public function get_list_order_ready_delivery($date_start = true, $date_end = true, $status_order = true)
    // public function get_list_order_ready_delivery($date_start = true, $date_end = true, $status_order = true)
    { 
        // if ($date_start === true && $date_end === true) {
            $this->db->where('a.createdDatePacking >=', $date_start);
            $this->db->where('a.createdDatePacking <=', date('Y-m-d', strtotime( $date_end . " +1 days")));
        // }
        // if ($status_order === true) {
            $this->db->where('a.status_order', $status_order);
        // }
      
       

        if ($this->session->userdata('user_group') == '0004') {
            $this->db->where('a.kurir_id', $this->session->userdata('userid'));
        }
        // $this->db->where('a.kurir_id', 'U00009');


        $this->db->select('a.stock_id,
                            a.trans_id,
                            a.order_id,
                            a.userid,
                            i.qty AS qty_stock,
                            j.nama_lengkap as nama_pemasok,
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
        $this->db->join('stock_barang i', 'i.stock_id = a.stock_id', 'LEFT');
        $this->db->join('admin_user j', 'j.userid=g.userid', 'LEFT');
       
        
        $this->db->where('a.createdStatusPacking', 'y');
        
        $this->db->order_by('a.createdDatePacking', 'ASC');
        
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