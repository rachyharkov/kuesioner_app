 <?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Laporan_model extends CI_Model {

	public function count_total_respond($id_kuesioner)
	{
		$this->db->like('jawaban','"id_kuesioner":"'.$id_kuesioner.'"');
		return $this->db->get('tbl_jawaban')->num_rows();
	}
	
	public function count_total_rows_by_date($id_kuesioner, $date)
	{
		$this->db->like('jawaban','"id_kuesioner":"'.$id_kuesioner.'"');
		$this->db->like('tanggal',$date);
		return $this->db->get('tbl_jawaban')->num_rows();
	}

	public function get_all_rows_by_id_kuesioner($id_kuesioner)
	{
		$this->db->like('jawaban','"id_kuesioner":"'.$id_kuesioner.'"');
		return $this->db->get('tbl_jawaban')->result();
	}

	public function get_all_jawaban_by_id_diskusi($id_kuesioner)
	{
		$this->db->like('jawaban','"id_diskusi":"'.$id_kuesioner.'"');
		return $this->db->get('tbl_jawaban')->result();
	}

	public function count_incoming_respon_month($month)
	{
		$q = "SELECT COUNT(*) as 'total' FROM `tbl_jawaban` WHERE month(tanggal) = '".$month."';";
		return $this->db->query($q)->row();
	}

	public function count_incoming_respon_by_hours_today($hours)
	{
		$q = "SELECT COUNT(*) as 'total' FROM `tbl_jawaban` WHERE hour(tanggal) = '".$hours."' AND day(tanggal) = day(now());";
		return $this->db->query($q)->row();
	}
}