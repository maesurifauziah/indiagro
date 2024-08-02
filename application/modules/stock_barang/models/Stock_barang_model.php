<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Stock_barang_model extends CI_Model
{
    public $table = 'stock_barang';
        public $column_order = array(null,
        'a.kode_barang',  
        null,
        'a.nama_barang',
        null,
        null,  
        null,
        null,
    ); //set column field database for datatable orderable

    public $column_search = array(
        'a.kode_barang',  
        'a.nama_barang',
        ); //set column field database for datatable searchable
    public $order = array('nama_barang' => 'ASC'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //add custom filter here
        if ($this->input->get('status', true)) {
            $this->db->where('a.status', $this->input->get('status', true));
        } else {
            $this->db->where('a.status', 'y');
        }
        if ($this->input->get('kategori_id', true) != 'all') {
            $this->db->where('a.kategori_id', $this->input->get('kategori_id', true));
        }

        $this->db->select('
                        a.stock_id,
                        a.kategori_id,
                        a.kode_barang,
                        a.kode_jenis_barang,
                        a.nama_jenis_barang,
                        a.harga,
                        a.qty,
                        a.photo_bukti_barang,
                        a.keterangan,
                        a.createdDate,
                        a.userid,
                        a.status,
                        a.approveDate,
                        a.approveBy,
                        b.kategori_desc,
                        c.nama_barang,
                        a.status_barang,
                        d.photo,
                    
        ');
        $this->db->from($this->table.' a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id','LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
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
        $this->db->order_by('aid', $this->order);
        // $this->db->where('status', '1');

        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('aid', $id);

        return $this->db->get($this->table)->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    function import_template($column, $values)
    {
        $onupdate = [];
        foreach($column as $list){
            $onupdate [] = $list."=VALUES(".$list.")";
        }
        $onupdate [] = 'status="y"';
        $sql  = " INSERT INTO ".$this->table." (".implode(', ',$column).") ";
        $sql .= " VALUES ".$values." ";
        $sql .= " ON DUPLICATE KEY UPDATE ".implode(', ',$onupdate).";";
        
        return $this->db->query($sql);
    }

    // public function update($where, $data)
    // {
    //     $this->db->update($this->table, $data, $where);

    //     return $this->db->affected_rows();
    // }

    public function update_batch($where, $data)
    {
        $this->db->update_batch($this->table, $data, $where);

        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('aid', $id);
        $this->db->delete($this->table);
    }
    function delete($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function get_list_barang($typeTerm, $typeTerm2, $typeTerm3, $searchTerm)
    { 
        if ($typeTerm == 'all') {
        } else {
            $this->db->where('a.kategori_id', $typeTerm);
        }

        if ($typeTerm2 == 'all') {
        } else {
            $this->db->where('a.kode_barang', $typeTerm2);
        }

        if ($typeTerm3 == 'all') {
        } else {
            $this->db->where('a.status_barang', $typeTerm3);
        }

        if (!$searchTerm == '') {
            $this->db->like('c.nama_barang', $searchTerm);
        }
        // $i = 0;

        // $column_search2 = array(
        //     'a.nama_barang',
        // );

        // foreach ($column_search2 as $item) { // loop column
        //     if ($searchTerm) { // if datatable send POST for search
        //         if ($i === 0) { // first loop
        //             $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
        //             $this->db->like($item, $searchTerm);
        //         } else {
        //             $this->db->or_like($item, $searchTerm);
        //         }

        //         if (count($column_search2) - 1 == $i) { //last loop
        //             $this->db->group_end();
        //         } //close bracket
        //     }
        //     ++$i;
        // }

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
                    e.nama_lengkap,
                    a.status,
                    a.approveDate,
                    a.approveBy,
                    b.kategori_desc,
                    c.nama_barang,
                    a.status_barang,
                    (CASE WHEN (a.status_barang="draft") THEN "Draft"
                        WHEN (a.status_barang="approve") THEN "Approve" 
                        WHEN (a.status_barang="sold_out") THEN "Habis" 
                        WHEN (a.status_barang="cancel") THEN "Batal" 
                    END) as status_barang_desc,
                    d.photo,
        
        ');
        $this->db->from('stock_barang a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id', 'LEFT');
        $this->db->join('master_barang c', 'c.kode_barang=a.kode_barang','LEFT');
        $this->db->join('master_jenis_barang d', 'd.kode_jenis_barang=a.kode_jenis_barang','LEFT');
        $this->db->join('admin_user e', 'e.userid=a.userid');
        $this->db->where('a.status','y');
        $this->db->where('a.userid', $this->session->userdata('userid'));
        // $this->db->like('a.nama_barang', $searchTerm);
        $this->db->order_by('c.nama_barang', 'ASC');
        
        return $this->db->get()->result();
    }
    
    public function get_list_barang_top3($searchTerm)
    { 
        $sql = "SELECT * 
                FROM stock_barang 
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
        $this->db->from('stock_barang');
        $this->db->where('kode_barang', $kode_barang);
        return $this->db->get()->result();
    }

    public function get_all_stock_barang()
    { 
        $this->db->select('*');
        $this->db->from('stock_barang');
        return $this->db->get()->result();
    }

    public function generateIDStock()
    {
        $code = "ST";

        $sql = 'SELECT MAX(RIGHT(stock_id,6)) as id
				  FROM stock_barang
                  WHERE LEFT(stock_id,2)="'.$code.'"
                  ORDER BY stock_id DESC';

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

    public function get_list_stock_aprove()
    { 
        $this->db->select('*');
        $this->db->from('stock_barang');
        $this->db->where('`status_barang` ', 'approve');
        return $this->db->get()->result();
    }
}