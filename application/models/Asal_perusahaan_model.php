 <?php defined('BASEPATH') OR exit('No direct script access allowed');

class Asal_perusahaan_model extends CI_Model {

	function __construct()
    {
        parent::__construct();
    }

    function get_all()
    {
        $this->db->order_by('id', 'ASC');
        return $this->db->get('tbl_asal_perusahaan')->result();
    }

    function get_by_id($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tbl_asal_perusahaan')->row();
    }

}