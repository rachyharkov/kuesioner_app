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

    
}