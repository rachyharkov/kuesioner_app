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
		$data = array(
			'menu' => 'Form Individu Editor',
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
		);
		$this->template->load('admin/pengaturan/form_individu/form', $data);
	}

	public function fetch_individuform_editor()
	{
		$this->load->view('admin/pengaturan/form_individu/form_editor', TRUE);
	}

	public function save_form_individu()
	{
		$form_name = $this->input->post('form_name');
		$form_design = $this->input->post('form_design');

		if ($form_name == '') {
			
			$arr = array(
				'status' => 'error',
				'message' => 'Nama form tidak boleh kosong',
			);

			return print_r(json_encode($arr));
		}
		
		if($form_design == null || $form_design == '[]'){
			$arr = array(
				'status' => 'error',
				'message' => 'Design form tidak boleh kosong',
			);

			return print_r(json_encode($arr));
		}
		
		if($form_name && $form_design) {
			$data = array(
				'nama_form' => $form_name,
				'design_form' => $form_design,
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => $this->session->userdata('nama'),
				'status_form' => 1,
			);
			$this->Formindividu_model->insert($data);
			$arr = array(
				'status' => 'success',
				'id_form' => $this->db->insert_id(),
				'message' => 'Data berhasil disimpan',
			);

			return print_r(json_encode($arr));
		}
	}

	// end of form individu
}