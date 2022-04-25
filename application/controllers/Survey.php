<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_app_model');
        $this->load->model('Kuesioner_model');
		$this->load->model('Formindividu_model');
        $this->load->model('Jawaban_model');
    }

	public function index()
	{
		$id_kuesioner = $this->input->get('id');

		$getdata = $this->Kuesioner_model->get_by_id(decrypt_url($id_kuesioner));

		$datakuesioner = $getdata ? $getdata : false;

		$judul_kuesioner = $datakuesioner ? $datakuesioner->judul_kuesioner : false;
		$choices_structural = $datakuesioner ? $datakuesioner->choices_structural : false;
		$theme = $datakuesioner ? $datakuesioner->theme : false;
		$exception = $datakuesioner ? $datakuesioner->choices_structural : false;

		$data = array(
			'id_kuesioner' => $id_kuesioner,
			'judul_kuesioner' => $judul_kuesioner,
			'choices_structural' => $choices_structural,
			'theme' => $theme,
			'exception' => $exception,
			'classnyak' => $this
		);

		$this->load->view('visitor/wrapper', $data);
	}

	public function get_kuesioner()
	{
		$id = decrypt_url($this->input->get('id'));

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

				$arr = array(
					'status' => 'success',
					'html' => $this->load->view('error_kuesionerdeactivate', $data, TRUE)
				);

				echo json_encode($arr);
			} else {

				$exception = $this->input->get('sel');
				$list_diskusi = $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id);
				
				if($exception != 'skip'){
					$list_diskusi = $this->Kuesioner_model->get_all_diskusi_by_kuesioner_exception($id, $exception);
				}

				$data = array(
					'list_diskusi' => $list_diskusi,
					'data_kuesioner' => $this->Kuesioner_model->get_by_id($id),
					'data_formindividu' => $this->Formindividu_model->get_by_id($getdatakuesioner->id_formindividu)
				);

				$arr = array(
					'status' => 'success',
					'html' => $this->load->view('visitor/kuesioner_form', $data, TRUE)
				);

				echo json_encode($arr);
	
			}
		}

	}

	public function save()
	{
		$id_kuesioner = $this->input->post('id_kuesioner');

		$jawaban = [];

		$data_kuesioner = $this->Kuesioner_model->get_by_id($id_kuesioner);

		$datasoal = $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id_kuesioner);

		$data_formindividu = $this->Formindividu_model->get_by_id($data_kuesioner->id_formindividu);

		$jumlah = count($datasoal);

		for ($i=0; $i < $jumlah ; $i++) { 
			$jawabantemp = array(
				'id_kuesioner' => $id_kuesioner,
				'id_diskusi' => $datasoal[$i]->id,
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
			// add $value['prefix'] to $datadiriresponden
			$datadiriresponden[$value['prefix']] = $this->input->post($value['prefix'], true);
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