<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kuesioner_model extends CI_Model {
    public function get_all_by_createdby($createdby)
    {
        $this->db->select('*');
        $this->db->where('created_by', $createdby);
        // return $this->db->get('tbl_kuesioner',$number,$offset)->result();
        return $this->db->get('tbl_kuesioner')->result();
    }

    function jumlah_kuesioner(){
		return $this->db->get('tbl_kuesioner')->num_rows();
	}

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('tbl_kuesioner');
        return $this->db->get()->result_array();
    }

    public function get_all_diskusi_by_kuesioner($id_kuesioner)
    {
        $this->db->select('*')->from('tbl_diskusi')->where('id_kuesioner',$id_kuesioner);
        $this->db->order_by('urutan','ASC');

        return $this->db->get()->result();
    }

    public function get_all_diskusi_by_kuesioner_exception($id, $exception)
    {
        // get all diskusi by kuesioner id and exception=$exception and exception = ''

        $q = "SELECT * FROM `tbl_diskusi` WHERE id_kuesioner = $id AND (exception = '' OR exception = '$exception') ORDER BY urutan ASC;";

        return $this->db->query($q)->result();
    }

    public function get_by_id($id_kuesioner)
    {
        $this->db->where('id_kuesioner', $id_kuesioner);
        return $this->db->get('tbl_kuesioner')->row();
    }

    function insert($data)
    {
        $this->db->insert('tbl_kuesioner', $data);
    }

    function delete($id_kuesioner)
    {
        $this->db->where('id_kuesioner', $id_kuesioner);
        $this->db->delete('tbl_kuesioner');
    }

    // update data
    function update($id, $data)
    {
        $this->db->where('id_kuesioner', $id);
        $this->db->update('tbl_kuesioner', $data);
    }
}