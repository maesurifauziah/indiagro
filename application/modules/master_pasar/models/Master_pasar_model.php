<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Master_pasar_model extends CI_Model
{
    public $table = 'master_pasar';
    public $column_order = array(null,
                                'a.pasar_id',
                                'a.pasar_desc',
                                'b.kecamatan',
                                'a.status',
                                null,
                            ); //set column field database for datatable orderable

                            public $column_search = array(
                                'a.pasar_id',
                                'a.pasar_desc',	
                                'b.kecamatan',
                                ); //set column field database for datatable searchable
    public $order = array('pasar_id' => 'ASC'); // default order

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
        

        $this->db->select('
                        a.pasar_id,
                        a.pasar_desc,
                        a.propid,
                        b.propinsi_desc,
                        a.kabid,
                        c.kabupaten_kota,
                        a.kecid,
                        d.kecamatan,
						a.status,
        ');
        $this->db->from($this->table.' a');
        $this->db->join('wilayah_propinsi b', 'b.propid=a.propid');
        $this->db->join('wilayah_kota_kab c', 'c.propid=a.propid AND c.kabid=a.kabid');
        $this->db->join('wilayah_kecamatan d', 'd.kabid = a.kabid AND d.kecid = a.kecid');
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
        $this->db->order_by('pasar_id', $this->order);
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('pasar_id', $id);

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
        $this->db->where('pasar_id', $id);
        $this->db->delete($this->table);
    }
    function delete($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function generateIDPasar()
    {
        $code = "PS";

        $sql = 'SELECT MAX(RIGHT(pasar_id,5)) as id
				  FROM master_pasar
                  WHERE LEFT(pasar_id,2)="'.$code.'"
                  ORDER BY pasar_id DESC';

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

    public function get_list_master_pasar_active()
    { 
        $this->db->select('*');
        $this->db->from('master_pasar');
        $this->db->where('status', 'y');
        return $this->db->get()->result();
    }

    public function get_pasar_by_kecid($id)
    {
        $this->db->select('a.*');
        $this->db->from('master_pasar a');
        $this->db->where('a.kecid', $id);
        $this->db->where('a.status', 'y');

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
