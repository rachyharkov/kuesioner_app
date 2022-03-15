<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Formindividu_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

    function insert($data)
    {
        $this->db->insert('tbl_formindividu', $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_formindividu', $data);
    }

    function get_by_id($id)
    {
        $this->db->where('id_formindividu', $id);
        return $this->db->get('tbl_formindividu')->row();
    }

    function delete($id_diskusi)
    {
        $this->db->where('id', $id_diskusi);
        $this->db->delete('tbl_formindividu');
    }
}