 <?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kuesioner_model extends CI_Model {
    public function get_all_by_createdby($createdby)
    {
        $this->db->select('*');
        $this->db->from('tbl_kuesioner');
        $this->db->where('created_by', $createdby);
        return $this->db->get()->result();
    }

    public function get_all_diskusi_by_kuesioner($id_kuesioner)
    {
        $this->db->select('*')->from('tbl_diskusi')->where('id_kuesioner',$id_kuesioner);
        $this->db->order_by('urutan','ASC');

        return $this->db->get()->result();
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
}