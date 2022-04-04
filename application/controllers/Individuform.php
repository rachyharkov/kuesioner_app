<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Individuform extends CI_Controller {

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
        echo 'p';
	}

    public function preview_form($id)
    {
        $data = array(
            'dataformindividu' => $this->Formindividu_model->get_by_id($id)
        );

        $this->load->view('admin/pengaturan/form_individu/preview_form', $data);
    }

}