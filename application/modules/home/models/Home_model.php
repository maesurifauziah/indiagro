<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home_model extends CI_Model
{
    public function output_json($data, $encode = true)
    {
        if ($encode) {
            $data = json_encode($data);
        }

        $this->output->set_content_type('application/json')->set_output($data);
    }
    
    // Query Total Penjualan
    // SELECT IFNULL(0,SUM(grand_total))as total FROM transaksi_header WHERE createdDate=NOW() AND status='y' AND status_transaksi = 'done'
    public function get_total_penjualan(){
        $query = "SELECT IFNULL(SUM(grand_total),0) as total FROM transaksi_header WHERE LEFT(createdDate,10) = '".date('Y-m-d')."' AND status='y' AND status_transaksi = 'done'";
        $result = $this->db->query($query)->row(); 
        return $result->total;
    }


    // Query Total Barang
    // SELECT COUNT(kode_jenis_barang) AS total_barang FROM master_jenis_barang WHERE status = 'y'
    public function get_total_barang(){
        $query = "SELECT COUNT(kode_jenis_barang) AS total_barang FROM master_jenis_barang WHERE status = 'y'";
        $result = $this->db->query($query)->row(); 
        return $result->total_barang;
    }
    
    // Query Total Pelanggan 
    // SELECT COUNT(userid) AS total_pelanggan FROM admin_user WHERE user_group = '0003' AND aktif = 'y'
    public function get_total_pelanggan(){
        $query = "SELECT COUNT(userid) AS total_pelanggan FROM admin_user WHERE user_group = '0003' AND aktif = 'y'";
        $result = $this->db->query($query)->row(); 
        return $result->total_pelanggan;
    }
    
    // Query Total Pemasok 
    // SELECT COUNT(userid) AS total_pemasok FROM admin_user WHERE user_group = '0002' AND aktif = 'y'
    public function get_total_pemasok(){
        $query = "SELECT COUNT(userid) AS total_pemasok FROM admin_user WHERE user_group = '0002' AND aktif = 'y'";
        $result = $this->db->query($query)->row(); 
        return $result->total_pemasok;
    }
    
    // Query Total Pemasok
    public function get_penjualan_perbulan(){
        $query = "SELECT
                    a.id_bulan,
                    a.bulan_desc, 
                    IFNULL(SUM(b.grand_total),0) AS grand_total	
                 FROM
                    tabel_bulan a
                 LEFT JOIN transaksi_header b ON MONTH(b.tgl_checkout) = a.id_bulan AND YEAR(b.tgl_checkout) = '".date('Y')."' AND b.status_transaksi = 'done'
                 GROUP BY a.id_bulan
                ";
        $result = $this->db->query($query)->result(); 
        return $result;
    }
}
