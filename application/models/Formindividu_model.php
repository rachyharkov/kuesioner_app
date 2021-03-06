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

    function delete($id)
    {
        // update status value where id_formindividu is $id
        $this->db->where('id_formindividu', $id);
        $this->db->update('tbl_formindividu', array('status_form' => 0));
    }

    // get all
    function get_all()
    {
        $this->db->where('status_form', 1);
        $this->db->order_by('id_formindividu', 'ASC');
        return $this->db->get('tbl_formindividu')->result();
    }
}