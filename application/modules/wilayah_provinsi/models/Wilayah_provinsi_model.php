<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Wilayah_provinsi_model extends CI_Model
{
    public $table = 'wilayah_propinsi';
    public $column_order = array(null,
                                'a.propid',
                                'a.propinsi_desc',
                                'a.status',
                            ); //set column field database for datatable orderable

    public $column_search = array('a.propid', 'a.propinsi_desc'); //set column field database for datatable searchable
    public $order = array('propid' => 'ASC'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //add custom filter here
        if ($this->input->get('status', true) == 'y') {
            $this->db->where('a.status', '1');
        } 
        if ($this->input->get('status', true) == 'n') {
            $this->db->where('a.status', '0');
        } 
        // else {
        //     $this->db->where('a.status', '1');
        // }

        if ($this->input->get('propinsi_desc', true)) {
            $this->db->like('a.propinsi_desc', $this->input->get('propinsi_desc', true));
        } 

        $this->db->select(
                           'a.propid,
                            a.propinsi_desc,
                            a.status'
        );
        $this->db->from('wilayah_propinsi a');
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
        $this->db->order_by('propid', $this->order);
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('propid', $id);

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
        $this->db->where('propid', $id);
        $this->db->delete($this->table);
    }
    function delete($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function generateIDProvinsi()
    {
        $code = "P";
        $sql = 'SELECT MAX(RIGHT(propid,2)) as propid
				  FROM wilayah_propinsi
                  WHERE LEFT(propid,1)="'.$code.'"
                  ORDER BY propid DESC';

        $result = $this->db->query($sql)->row();
        $id_last = $result->propid;
        $id_new = $id_last+1;

        $generateID = '';
        
        if ($id_new<10) {
            $generateID = $code."0".$id_new;
            return $generateID;
        } 
        elseif (($id_new>=10)&&($id_new<=99)) {
            $generateID = $code.$id_new;
            return $generateID;
        }

    }


    public function get_list_provinsi_aktif()
    {
        $this->db->select(
            'a.propid,
            a.propinsi_desc,
            a.status'
        );
        $this->db->from('wilayah_propinsi a');
        $this->db->where('a.status', '1');

        return $this->db->get()->result();
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
}
