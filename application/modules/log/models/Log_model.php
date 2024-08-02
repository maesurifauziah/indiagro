<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Log_model extends CI_Model
{
    public $table = 'argo_indo_log';
    public $column_order = array(null,
                                'a.uid',
                                'a.controller',
                                'a.ip_address',
                                'a.desc',
                                'a.db_error',
                                'a.timestamp',
                                null,
                            ); //set column field database for datatable orderable

                            public $column_search = array(
                                'a.uid',
                                'a.controller',
                                'a.ip_address',
                                'a.desc',
                                'a.db_error',
                                'a.timestamp',
                                ); //set column field database for datatable searchable
    public $order = array('a.id' => 'ASC'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //add custom filter here
        if ($this->input->get('date_start', true) && $this->input->get('date_end', true)) {
            $this->db->where('DATE(a.timestamp)>=', $this->input->get('date_start', true));
            $this->db->where('DATE(a.timestamp)<=', $this->input->get('date_end', true));
        }

        $this->db->select('
                    a.id,  
                    a.uid,
                    a.controller,  
                    a.ip_address,
                    a.desc,  
                    a.db_error,
                    a.timestamp
        ');
        $this->db->from($this->table.' a');
        $this->db->order_by('a.id', 'DESC');
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
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('aid', $id);

        return $this->db->get($this->table)->row();
    }

    public function save($header)
    {
        $this->db->insert($this->table, $header);
        return TRUE;
    }

    public function create($controller='', $desc='', $uid=false)
    {
        $db_error='';
        // $error = $this->db->error();
        // if ($error['code'] != '00000' && $error['message'] != '') {
        //     $db_error=json_encode($error);
        // }
        $data = [
            'uid' => $this->session->userdata('uid') == '' ? '1' : '1',
            'controller' => $controller,
            'ip_address' => $this->input->ip_address(),
            'desc' => $desc,
            'db_error' => $db_error,
            'timestamp' => date('Y-m-d H:i:s'),
        ];
        return $this->db->insert($this->table, $data);
    }
}
