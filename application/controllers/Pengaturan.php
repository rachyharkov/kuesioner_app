<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
        $this->load->library('template');
    }

	public function index()
	{
		$data = array(
			'menu' => 'Pengaturan',
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
		);
		$this->template->load('admin/pengaturan/pengaturan_list',$data);
	}
}