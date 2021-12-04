<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Survey extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_app_model');
        $this->load->model('Kuesioner_model');
        $this->load->model('Asal_perusahaan_model');
        $this->load->model('Jawaban_model');
    }

	public function index()
	{
		$id_kuesioner = $this->input->get('id');

		$data = array(
			'id_kuesioner' => $id_kuesioner,
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
			$data = array(
				'asal_perusahaan' => $this->Asal_perusahaan_model->get_all(),
				'list_diskusi' => $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id),
				'data_kuesioner' => $this->Kuesioner_model->get_by_id($id)
			);

			$this->load->view('visitor/kuesioner_form',$data);
		}

	}

	public function save()
	{
		$id_kuesioner = $this->input->post('id_kuesioner');
		$email = $this->input->post('email');
		$asal_perusahaan = $this->input->post('asal_perusahaan');
		$nama_karyawan = $this->input->post('nama_karyawan');

		$jawaban = [];

		$datasoal = $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id_kuesioner);

		$data_kuesioner = $this->Kuesioner_model->get_by_id($id_kuesioner);

		$jumlah = count($datasoal);

		for ($i=1; $i <= $jumlah ; $i++) { 
			$jawaban[] = array(
				'id_kuesioner' => $id_kuesioner,
				'id_diskusi' => $this->input->post('soal'.$i.'id'),
				'pengalaman' => $this->input->post('disc'.$i.'_col1'),
				'harapan' => $this->input->post('disc'.$i.'_col2')
			);
		}

		// $jawaban = '';
		$datanya = array(
			'email' => $email,
			'asal_perusahaan' => $asal_perusahaan,
			'nama_karyawan' => $nama_karyawan,
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