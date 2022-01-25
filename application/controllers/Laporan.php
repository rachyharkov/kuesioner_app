<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
        $this->load->model('Kuesioner_model');
        $this->load->library('template');
    }

	public function index()
	{
        $user_id = $this->session->userdata('userid');
		$data = array(
			'list_kuesioner' => $this->Kuesioner_model->get_all_by_createdby($user_id),
			'menu' => 'Laporan',
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
		);
		$this->template->load('admin/laporan/v_wrapper',$data);
	}
}