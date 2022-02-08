<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
        $this->load->model('Kuesioner_model');
		$this->load->model('Laporan_model');
        $this->load->library('template');
    }

	public function index()
	{
        $user_id = $this->session->userdata('userid');

		// ngitung total month to month
		$total_respon_month_to_month = [];
		for ($i=01; $i <= 12; $i++) { 
			$tot = $this->Laporan_model->count_incoming_respon_month($i)->total;
			array_push($total_respon_month_to_month, $tot);
		}

		// get hour now
		$hour_now = date('H');
		// hour now minus 8 hours
		$hour_now_minus_8 = $hour_now - 8;

		// loop from hour_now to $hour_now_minus_8
		$total_respon_by_hours_today = [];
		$list_last_8_hours = [];
		for ($i=$hour_now_minus_8; $i <= $hour_now; $i++) { 
			$tot = $this->Laporan_model->count_incoming_respon_by_hours_today($i)->total;
			array_push($total_respon_by_hours_today, $tot);

			$keadaan = '';
			if ($i > 05 && $i < 10) {
				$keadaan = 'P';
			} elseif ($i >= 10 && $i < 15) {
				$keadaan = 'S';
			} elseif ($i < 18) {
				$keadaan = 'S';
			} else {
				$keadaan = 'M';
			}

			array_push($list_last_8_hours, $i.$keadaan);
		}

		// date now to last 8 hours then loop
		// $date_now = date('Y-m-d H:i:s');
		// $date_last_8_hours = date('Y-m-d H:i:s', strtotime('-8 hours', strtotime($date_now)));

		
		$data = array(
			'list_kuesioner' => $this->Kuesioner_model->get_all_by_createdby($user_id),
			'menu' => 'Dashboard',
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
			'total_respon_month_to_month' => json_encode($total_respon_month_to_month),
			'total_respon_by_hours_today' => json_encode($total_respon_by_hours_today),
			'list_last_8_hours' => json_encode($list_last_8_hours)
		);
		$this->template->load('admin/v_dashboard',$data);
	}

}