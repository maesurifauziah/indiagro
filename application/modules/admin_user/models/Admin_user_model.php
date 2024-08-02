<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin_user_model extends CI_Model
{
    public $table = 'admin_user';
    public $column_order = array(null,
                                null,
                                null,
                                'a.userid',
                                'a.user_name',
                                'a.nama_lengkap',
                                'b.group_name',
                                'a.alamat',
                                'c.propinsi_desc',
                                'd.kabupaten_kota',
                                'e.kecamatan',
                                'a.kodepos',
                                'f.pasar_desc',
                                'a.no_hp',
                                'a.aktif',
                                 null,
            );//set column field database for datatable orderable

            public $column_search = array(
                'a.userid',
                'a.user_name',
                'a.nama_lengkap',
                // 'a.tgl_insert',
                // 'a.tgl_last_login',
                'a.user_insert',
                'a.user_group',
                'a.aktif',
                'a.alamat',
                'a.no_hp',
                'b.group_name'
                );//set column field database for datatable searchable
                public $order = array('userid' => 'ASC');// default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //add custom filter here
        if ($this->input->get('nama_lengkap', true)) {
            $this->db->like('a.nama_lengkap', $this->input->get('nama_lengkap', true));
        } 

        if ($this->input->get('status', true)) {
            $this->db->where('a.aktif', $this->input->get('status', true));
        } else {
            $this->db->where('a.aktif', 'y');
        }
        

        $this->db->select('DISTINCT (a.userid) as userid,
                        a.photo,
                        a.user_name,
                        a.nama_lengkap,
                        a.tgl_insert,
                        a.tgl_last_login,
                        a.user_insert,
                        a.user_group,
                        a.aktif,
                        a.pasar_id,
                        f.pasar_desc,
                        a.propid,
                        c.propinsi_desc,
                        a.kabid,
                        d.kabupaten_kota,
                        a.kecid,
                        e.kecamatan,
                        a.kodepos,
                        a.alamat,
                        a.no_hp,
                        b.group_name,
        ');
        $this->db->from($this->table.' a');
        $this->db->join('admin_group_user b','a.user_group=b.user_group');
        $this->db->join('wilayah_propinsi c', 'c.propid=a.propid', 'LEFT');
        $this->db->join('wilayah_kota_kab d', 'd.propid=a.propid AND d.kabid=a.kabid', 'LEFT');
        $this->db->join('wilayah_kecamatan e', 'e.kabid = a.kabid AND e.kecid = a.kecid', 'LEFT');
        $this->db->join('master_pasar f', 'f.pasar_id= a.pasar_id', 'LEFT');
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
        $this->db->where('aid', $id);
        $this->db->delete($this->table);
    }
    function delete($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function generateIDUser()
    {
        $code = "U";

        $sql = 'SELECT MAX(RIGHT(userid,5)) as id
				  FROM admin_user
                  WHERE LEFT(userid,1)="'.$code.'"
                  ORDER BY userid DESC';

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

    public function get_list_group_user()
    { 
        $this->db->select('*');
        $this->db->from('admin_group_user');
        $this->db->where('aktif', 'y');
        return $this->db->get()->result();
    }

    public function get_list_kurir($searchTerm = true)
    { 
        if ($searchTerm === true) {
            $this->db->like('nama_lengkap', $searchTerm);
        }
        $this->db->select('userid,nama_lengkap');
        $this->db->from('admin_user');
        $this->db->where('user_group', '0004');
        $this->db->where('aktif', 'y');
        return $this->db->get()->result();
    }

    public function get_list_kurir2()
    { 
        $this->db->select('userid,nama_lengkap');
        $this->db->from('admin_user');
        $this->db->where('user_group', '0004');
        $this->db->where('aktif', 'y');
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

    public function upload_file($filename)
    {
        $this->load->library('upload');
        if (!is_dir('upload')) {
            mkdir('upload', 0777, true);
        }
        if (!is_dir('upload/admin_user')) {
            mkdir('upload/admin_user', 0777, true);
        }
        $config['upload_path'] = 'upload/admin_user';
        $config['allowed_types'] = '*';
        $config['max_size']    = '1024';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('photo')) {
            $res = array('status' => true, 'file' => $this->upload->data(), 'error' => '');
            return $res;
        } else {
            $res = array('status' => false, 'file' => '', 'error' => $this->upload->display_errors());
            return $res;
        }
    }
}
