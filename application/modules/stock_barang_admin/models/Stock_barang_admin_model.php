<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Stock_barang_admin_model extends CI_Model
{
    public $table = 'stock_barang';
    public $column_order = array(null,
                                'a.createdDate',
                                'a.userid',
                                'e.nama_lengkap',
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
                                'e.nama_lengkap',
                                'c.nama_barang',
                                'a.status',
                                ); //set column field database for datatable searchable
    public $order = array('createdDate' => 'DESC'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //add custom filter here
        if ($this->input->get('status_barang', true)) {
            $this->db->where('a.status_barang', $this->input->get('status_barang', true));
        } else {
            $this->db->where('a.status_barang', 'draft');
        }

        if ($this->input->get('barang', true) != 'all') {
            $this->db->where('a.kode_barang', $this->input->get('barang', true));
        }

        if ($this->input->get('kategori', true) != 'all') {
            $this->db->where('a.kategori_id', $this->input->get('kategori', true));
        }

        if ($this->input->get('date_start', true) && $this->input->get('date_end', true)) {
            $this->db->where('a.createdDate >=', $this->input->get('date_start', true));
            $this->db->where('a.createdDate <=', date('Y-m-d', strtotime( $this->input->get('date_end', true) . " +1 days")));
        }
        

        $this->db->select('
                        a.stock_id,
                        a.kategori_id,
                        a.kode_barang,
                        a.kode_jenis_barang,
                        d.nama_jenis_barang,
                        a.harga,
                        a.qty,
                        a.photo_bukti_barang,
                        a.keterangan,
                        a.createdDate,
                        a.userid,
                        e.nama_lengkap as nama_penyetok,
                        e.no_hp,
                        a.status,
                        a.approveDate,
                        a.approveBy,
                        b.kategori_desc,
                        c.nama_barang,
                        a.approveDate,
                        a.approveBy,
                        a.approveStatus,
                        a.soldoutDate,
                        a.soldoutBy,
                        a.soldoutStatus,
                        a.deletedDate,
                        a.deletedBy,
                        a.deletedStatus,
                        a.status_barang,
                        (CASE WHEN (a.status_barang="draft") THEN "Draft"
                            WHEN (a.status_barang="approve") THEN "Approve" 
                            WHEN (a.status_barang="sold_out") THEN "Habis" 
                            WHEN (a.status_barang="cancel") THEN "Batal" 
                        END) as status_barang_desc,
                        d.photo,
        ');
        $this->db->from($this->table.' a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id', 'LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->join('admin_user e', 'e.userid=a.userid');
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

    public function get_list_master_jenis_barang_active()
    { 
        $this->db->select('*');
        $this->db->from('master_jenis_barang');
        $this->db->where('status', 'y');
        $this->db->order_by('kode_jenis_barang', 'ASC');
        return $this->db->get()->result();
    }

    public function generateIDJenisBarang()
    {
        $code = "JB";

        $sql = 'SELECT MAX(RIGHT(kode_jenis_barang,5)) as id
				  FROM master_jenis_barang
                  WHERE LEFT(kode_jenis_barang,2)="'.$code.'"
                  ORDER BY kode_jenis_barang DESC';

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
            $update = $this->db->update($this->table, $data);
        }
        if ($batch === false) {
            $update = $this->db->update($this->table, $data, array($pk => $id));
        } else {
            $update = $this->db->update_batch($this->table, $data, $pk);
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
}



