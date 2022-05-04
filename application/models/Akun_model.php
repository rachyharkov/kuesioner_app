<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Akun_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

    function update_password($data,$id_user)
    {
        $this->db->where('id_user',$id_user);
        $this->db->update('tbl_user',$data);
        return true;
    }

    function check_old_password($id_user,$old_password)
    {
        $this->db->where('id_user',$id_user);
        $this->db->where('password',$old_password);
        $query = $this->db->get('tbl_user');
        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}