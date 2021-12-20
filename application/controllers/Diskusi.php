<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Diskusi extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
        $this->load->model('Kuesioner_model');
        $this->load->model('Jawaban_model');
        $this->load->model('Direktorat_model');
    }

	public function index()
	{
		echo 'hah';
	}

	public function get_all_diskusi_by_kuesioner($id_kuesioner)
	{
		$list_diskusi = $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id_kuesioner);
		$data_kuesioner = $this->Kuesioner_model->get_by_id($id_kuesioner);

		$data = array(
			'list_diskusi' => $list_diskusi,
			'data_kuesioner' => $data_kuesioner
		);

		$this->load->view('admin/kuesioner/diskusi', $data);
	}

	public function get_indikator()
	{
		$id_kuesioner = $this->input->post('id_kuesioner');
		$dimensi = $this->input->post('dimensi');

		$data_kuesioner = $this->Kuesioner_model->get_by_id($id_kuesioner);

		$dataindikator = [];

		$processfindingdataindikator = json_decode($data_kuesioner->dimensi, true);

		foreach ($processfindingdataindikator as $s) {
			if ($s['name'] == $dimensi) {
				foreach ($s['indikator'] as $yaik) {
					$dataindikator[] = $yaik;
				}
			}
		}

		foreach ($dataindikator as $deee) {
			echo '<option value="'.$deee.'">'.$deee.'</option>';
		}
	}
}