<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_app_model');
        $this->load->model('Kuesioner_model');
        $this->load->model('Direktorat_model');
		$this->load->model('Formindividu_model');
        $this->load->model('Jawaban_model');
    }

	public function index()
	{
		$id_kuesioner = $this->input->get('id');

		$data = array(
			'id_kuesioner' => decrypt_url($id_kuesioner),
			'classnyak' => $this
		);

		$this->load->view('visitor/wrapper', $data);
	}

	public function get_kuesioner($id)
	{
		$list_diskusi = $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id);

		if (!$list_diskusi) {
			$this->load->view('error_404');
		} else {
			$getdatakuesioner = $this->Kuesioner_model->get_by_id($id);
			// detect status of kuesioner
			$status = $getdatakuesioner->status;
			if($status == 0) {
				$data = array(
					'judul_kuesioner' => $getdatakuesioner->judul_kuesioner,
				);
				$this->load->view('error_kuesionerdeactivate', $data);
			} else {
				$data = array(
					'direktorat' => $this->Direktorat_model->get_all(),
					'list_diskusi' => $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id),
					'data_kuesioner' => $this->Kuesioner_model->get_by_id($id),
					'data_formindividu' => $this->Formindividu_model->get_by_id($getdatakuesioner->id_formindividu)
				);
	
				$this->load->view('visitor/kuesioner_form',$data);
			}
		}

	}

	public function save()
	{
		$id_kuesioner = $this->input->post('id_kuesioner');

		$jawaban = [];

		$datasoal = $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id_kuesioner);

		$data_kuesioner = $this->Kuesioner_model->get_by_id($id_kuesioner);

		$data_formindividu = $this->Formindividu_model->get_by_id($data_kuesioner->id_formindividu);

		$jumlah = count($datasoal);

		for ($i=1; $i <= $jumlah ; $i++) { 
			$jawabantemp = array(
				'id_kuesioner' => $id_kuesioner,
				'id_diskusi' => $this->input->post('soal'.$i.'id'),
			);

			$kategori_respon = json_decode($data_kuesioner->kategori_respon, TRUE);

			foreach ($kategori_respon as $key => $value) {
				$kategorirespwithanswer = [
					$value['nama'] => $this->input->post('disc'.$i.'_col'.$key)
				];

				$jawabantemp = array_merge($jawabantemp, $kategorirespwithanswer);
			}

			$jawaban[] = $jawabantemp;
		}
		// echo "<pre>";
		// print_r($jawaban);
		// echo "</pre>";

		// $jawaban = '';

		$dataformindividu = json_decode($data_formindividu->design_form, true);

		$datadiriresponden = array();

		foreach ($dataformindividu as $key => $value) {
			// add $value['elementname'] to $datadiriresponden
			$datadiriresponden[$value['elementname']] = $this->input->post($value['elementname'], true);
		}

		$datanya = array(
			'data_diri' => json_encode($datadiriresponden),
			'jawaban' => json_encode($jawaban)
		);

		$this->Jawaban_model->insert($datanya);
		
		echo "<div class='container' style='padding: 14vh 0; display: block;scroll-snap-align: start;'>
				<div class='card' style='width: 100%;'>
				  <div class='card-body'>
				  	<div style='width: 100%;
		text-align: center;
		margin: 2vh 0;'>
				  		<img src='".base_url().'assets/images/logo_perusahaan.png'."' height='50' style='margin: auto;'>
				  	</div>
				  	<h4>".$data_kuesioner->judul_kuesioner."</h4>
				  	<p>Terima kasih telah mengisi kuesioner.</p>
				  </div>
				</div>
			</div>";

	}

}