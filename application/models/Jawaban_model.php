 <?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jawaban_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

    function insert($data)
    {
        $this->db->insert('tbl_jawaban', $data);
    }

    function get_by_kuesioner($id_kuesioner)
    {

    	$like = '"id_kuesioner":"'.$id_kuesioner.'"';

    	$this->db->like('jawaban',$like);
    	return $this->db->get('tbl_jawaban')->result();
    }

}