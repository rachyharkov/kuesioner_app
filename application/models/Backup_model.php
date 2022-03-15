<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

    function list_kuesioner()
    {
        return $this->db->select('id_kuesioner,judul_kuesioner')->get('tbl_kuesioner')->result();
    }

    // update data
    function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_diskusi', $data);
    }
}