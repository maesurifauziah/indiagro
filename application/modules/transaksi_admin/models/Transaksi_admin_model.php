<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Transaksi_admin_model extends CI_Model
{
    public $table = 'transaksi_header';
    public $table2 = 'transaksi_detail';
    public $column_order = array(null,
                                'a.createdDate',
                                'a.userid',
                                'b.nama_lengkap',
                                'c.nama_barang',
                                null,
                                null,
                                'dnama_jenis_barang',
                                'a.status',
                                'a.qty',
                                'a.harga',
                                'a.status',
                                null,
                            ); //set column field database for datatable orderable

                            public $column_search = array(
                                'a.createdDate',
                                'a.userid',
                                'b.nama_lengkap',
                                'c.nama_barang',
                                'a.status',
                                ); //set column field database for datatable searchable
    public $order = array('createdDate' => 'ASC'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //add custom filter here
        if ($this->input->get('status_transaksi', true)) {
            $this->db->where('a.status_transaksi', $this->input->get('status_transaksi', true));
        } else {
            $this->db->where('a.status_transaksi', 'draft');
        }


        if ($this->input->get('trans_id', true) != 'all') {
            $this->db->where('a.trans_id', $this->input->get('trans_id', true));
        }

        if ($this->input->get('date_start', true) && $this->input->get('date_end', true)) {
            $this->db->where('a.tgl_checkout >=', $this->input->get('date_start', true));
            $this->db->where('a.tgl_checkout <=', $this->input->get('date_end', true));
        }
        

        $this->db->select('
                        a.trans_id,
                        a.userid,
                        b.nama_lengkap,
                        b.no_hp,
                        b.pasar_id,
                        c.pasar_desc,
                        a.tgl_checkout,
                        a.total,
                        a.total_batal,
                        a.ongkir,
                        a.biaya_penanganan,
                        a.grand_total,
                        a.alamat_kirim,
                        a.tipe_pembayaran,
                        a.bukti_pembayaran,
                        a.status_transaksi,
                        a.status,
                        a.createdDate,
                        (SELECT COUNT(trans_id) FROM transaksi_detail WHERE trans_id = a.trans_id AND status_order = "checkout" AND status = "y") AS banyak_checkout,
    (SELECT COUNT(trans_id) FROM transaksi_detail WHERE trans_id = a.trans_id AND status_order = "packing" AND createdStatusPacking = "y") AS banyak_packing,
    (SELECT COUNT(trans_id) FROM transaksi_detail WHERE trans_id = a.trans_id AND status_order = "pengiriman" AND createdStatusPengiriman = "y") AS banyak_pengiriman,
    (SELECT COUNT(trans_id) FROM transaksi_detail WHERE trans_id = a.trans_id AND status_order = "lunas" AND createdStatusLunas = "y") AS banyak_lunas,
    (SELECT COUNT(trans_id) FROM transaksi_detail WHERE trans_id = a.trans_id AND status_order = "done" AND createdStatusDone = "y") AS banyak_done,
    (SELECT COUNT(trans_id) FROM transaksi_detail WHERE trans_id = a.trans_id AND status_order = "cancel" AND createdStatusCancel = "y") AS banyak_cancel
                       
        ');
        $this->db->from($this->table.' a');
        $this->db->join('admin_user b', 'b.userid=a.userid', 'LEFT');
        $this->db->join('master_pasar c', 'c.pasar_id=b.pasar_id', 'LEFT');
        $this->db->where('a.status','y');
        $this->db->order_by('a.createdDate', 'ASC');
        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) { //last loop
                    $this->db->group_end();
                } //close bracket
            }
            ++$i;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        // $this->db->where('status', '1');

        return $this->db->count_all_results();
    }

    public function get_all()
    {
        $this->db->order_by('kode_barang', $this->order);
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('kode_barang', $id);

        return $this->db->get($this->table)->row();
    }

    public function save($header)
    {
        $this->db->insert($this->table, $header);
        return TRUE;
    }

    // public function update($where, $header)
    // {
    //     $this->db->update($this->table, $header, $where);
    //     return TRUE;
    // }

    public function update_batch($where, $data)
    {
        $this->db->update_batch($this->table, $data, $where);

        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('kode_barang', $id);
        $this->db->delete($this->table);
    }
    function delete($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function get_list_transaksi_header_active()
    { 
        $this->db->select('*');
        $this->db->from('transaksi_header');
        $this->db->where('status', 'y');
        // $this->db->order_by('trans_id', 'ASC');
        return $this->db->get()->result();
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

    public function update($data, $pk, $id = null, $batch = false)
    {
        if ($id === null) {
            $update = $this->db->update($this->table2, $data);
        }
        if ($batch === false) {
            $update = $this->db->update($this->table2, $data, array($pk => $id));
        } else {
            $update = $this->db->update_batch($this->table2, $data, $pk);
        }
        return $update;
    }

    public function get_detail_jenis_barang($kode_jenis_barang)
    { 
        $this->db->select('*');
        $this->db->from('master_jenis_barang');
        $this->db->where('status', 'y');
        $this->db->where('kode_jenis_barang', $kode_jenis_barang);
        $this->db->order_by('kode_barang', 'ASC');
        return $this->db->get()->row();
    }

    public function get_jenis_barang_by_barang($kode_barang)
    { 
        $this->db->select('*');
        $this->db->from('master_jenis_barang');
        $this->db->where('status', 'y');
        $this->db->where('kode_barang', $kode_barang);
        $this->db->order_by('kode_barang', 'ASC');
        return $this->db->get()->result();
    }

    public function cek_total_order_done_by_tran($trans_id){
        $query = "SELECT IF
                    ((
                        SELECT
                            COUNT( order_id )
                        FROM
                            transaksi_detail 
                        WHERE
                            trans_id = '".$trans_id."' 
                            )=(
                        SELECT
                            COUNT( order_id )
                        FROM
                            transaksi_detail 
                        WHERE
                            trans_id = '".$trans_id."' 
                            AND status_order = 'done' 
                            AND createdStatusDone = 'y' 
                            ),
                        1,
                    0 
                    ) AS banyak_order";
        $result = $this->db->query($query)->row(); 
        return $result->banyak_order;
    }
}



