<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Diskusi_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

    function insert($data)
    {
        $this->db->insert('tbl_diskusi', $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_diskusi', $data);
    }

    function get_by_id($id_diskusi)
    {
        $this->db->where('id', $id_diskusi);
        return $this->db->get('tbl_diskusi')->row();
    }

    function delete($id_diskusi)
    {
        $this->db->where('id', $id_diskusi);
        $this->db->delete('tbl_diskusi');
    }

    function delete_all_by_kuesioner($id_kuesioner)
    {
        $this->db->where('id_kuesioner', $id_kuesioner);
        $this->db->delete('tbl_diskusi');
    }

    function get_alldiskusi_by_id_kuesioner($id_kuesioner) {
        $this->db->where('id_kuesioner', $id_kuesioner);
        return $this->db->get('tbl_diskusi')->row();
    }
}