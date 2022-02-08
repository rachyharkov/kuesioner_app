<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
        $this->load->model('Akun_model');
        $this->load->library('template');
    }

	public function index()
	{
        $user_id = $this->session->userdata('userid');
		$data = array(
			'menu' => 'Akun',
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
		);
		$this->template->load('admin/akun/akun_form',$data);
	}

	
}