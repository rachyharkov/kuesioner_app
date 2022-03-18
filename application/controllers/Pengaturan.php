<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
		$this->load->model('Formindividu_model');
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

	// form individu

	public function form_individu()
	{
		$data = array(
			'menu' => 'Form Individu',
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
			'list_formindividu' => $this->Formindividu_model->get_all(),
		);
		$this->template->load('admin/pengaturan/form_individu/list',$data);
	}

	public function form_individu_editor()
	{
		$this->load->view('admin/pengaturan/form_individu/form');
	}

	// end of form individu
}