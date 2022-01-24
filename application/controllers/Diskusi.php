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
        $this->load->model('Diskusi_model');
    }

	public function index()
	{
		echo 'hah';
	}

	public function get_all_diskusi_by_kuesioner($id_kuesioner)
	{
		$data_kuesioner = $this->Kuesioner_model->get_by_id($id_kuesioner);

		$data = array(
			'list_diskusi' => $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id_kuesioner),
			'data_kuesioner' => $data_kuesioner,
			'classnyak' => $this
		);

		$this->load->view('admin/kuesioner/diskusi', $data);
	}

	public function get_indikator($ik = NULL, $d = NULL)
	{

		$id_kuesioner = $this->input->post('id_kuesioner');
		$dimensi = $this->input->post('dimensi');
		if ($ik || $d) {
			$id_kuesioner = $ik;
			$dimensi = $d;
		}

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
		echo '<option>- pilih indikator -</option>';
		foreach ($dataindikator as $deee) {
			echo '<option value="'.$deee.'">'.$deee.'</option>';
		}
	}

	public function delete_diskusi()
	{
		$id_diskusi = $this->input->post('id_diskusi', TRUE);

		$this->Diskusi_model->delete($id_diskusi);

		$arr = array(
			'response' => 'ok'
		);

		echo json_encode($arr);
	}

	public function update_diskusi()
	{
		$id_kuesioner = $this->input->post('id_kuesioner', TRUE);
		$barisdiskusi = $this->input->post('barisdiskusi', true);

		$id_diskusi = $this->input->post('id_diskusi', TRUE);

		$cekdiskusiygudahdibuat = $this->Diskusi_model->get_alldiskusi_by_id_kuesioner($id_kuesioner);

		if ($cekdiskusiygudahdibuat) {
			// code...
		} else {
			$datadiskusi = [];

			
		}

		// $datadiskusi = [];

		// $getdatafromdb = $this->Diskusi_model->

		
		$datatoupdate = array(
			'urutan' => $i,
			'dimensi' => $this->input->post('dimensidiskusi'.$i),
			'indikator' => $this->input->post('indikatordiskusi'.$i),
			'isi_diskusi' => $this->input->post('isidiskusi'.$i)
		);

		$this->Diskusi_model->update($id_diskusi, $datatoupdate);


		// for ($i=1; $i <= count($barisdiskusi); $i++) { 
		// 	$id_diskusi = $this->input->post('id_diskusi'.$i, TRUE);

		// 	$cek = $this->Kuesioner_model->get_by_id($id_kuesioner);

		// 	if ($id_diskusi) {
				
		// 		$datatoupdate = array(
		// 			'urutan' => $i,
		// 			'dimensi' => $this->input->post('dimensidiskusi'.$i),
		// 			'indikator' => $this->input->post('indikatordiskusi'.$i),
		// 			'isi_diskusi' => $this->input->post('isidiskusi'.$i)
		// 		);

		// 		$this->Diskusi_model->update($id_diskusi, $datatoupdate);

		// 		$status = 'ok';
		// 	} else {
		// 		$status = 'no';
		// 	}
		// 	// $datadiskusi[] = $datatoinsert;
		// }

		$json = array(
			'status' => $status
		);

		echo json_encode($json);
	}

	public function save_all_diskusi()
	{
		$arrayofdiskusi = $this->input->post('jsonString');

		$arrayofdiskusitemp = json_decode($arrayofdiskusi);

		foreach ($arrayofdiskusitemp as $key => $value) {
			$datatoupdate = array(
				'urutan' => $value->urutan,
				'dimensi' => $value->dimensi,
				'indikator' => $value->indikator,
				'isi_diskusi' => $value->isi_diskusi
			);
			$this->Diskusi_model->update($value->id_diskusi, $datatoupdate);
		}

		// print_r($arrayofdiskusitemp);
	}
}