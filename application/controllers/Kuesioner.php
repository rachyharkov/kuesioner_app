<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Kuesioner extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
        $this->load->model('Kuesioner_model');
        $this->load->model('Diskusi_model');
        $this->load->model('Jawaban_model');
        $this->load->model('Direktorat_model');
        $this->load->library('Template');
    }

	public function index()
	{
		$user_id = $this->session->userdata('userid');
		$data = array(
			'list_kuesioner' => $this->Kuesioner_model->get_all_by_createdby($user_id),
			'menu' => 'Kuesioner',
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
		);
		$this->template->load('admin/kuesioner/kuesioner_list', $data);
	}

	public function create()
	{
		$data = array(
			'aksi' => 'Buat',
			'menu' => 'Kuesioner',
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
		);
		$this->template->load('admin/kuesioner/kuesioner_form', $data);
	}

	public function create_action()
	{
		$judul_kuesioner = $this->input->post('judul_kuesioner');
		$deskripsi_kuesioner = $this->input->post('deskripsi_kuesioner');
		
		$dimensi = $this->input->post('dimensi');

		$kategori_respon = $this->input->post('kategori_respon');

		$dimensi_temp = [];

		$kategori_respon_temp = [];

		for ($i=0; $i < count($dimensi); $i++) {
			$indikatordimensi = $this->input->post('indikator_dimensi_row'.$i);

			$indikatordimensi_temp = [];

			for ($y=0; $y < count($indikatordimensi); $y++) { 
				$indikatordimensi_temp[] = $indikatordimensi[$y];
			}


			$dimensinyak = array(
				'name' => $dimensi[$i],
				'indikator' => $indikatordimensi_temp
			);
			$dimensi_temp[] = $dimensinyak;
		}

		for ($i=0; $i < count($kategori_respon); $i++) {
			$pilihan_kategori_respon = $this->input->post('pilihan_kategori_responrow'.$i);

			$pilihan_kategori_respon_temp = [];

			for ($y=0; $y < count($pilihan_kategori_respon); $y++) { 
				$pilihan_kategori_respon_temp[] = $pilihan_kategori_respon[$y];
			}

			$kategoripilihanyak = array(
				'nama' => $kategori_respon[$i],
				'respon_list' => $pilihan_kategori_respon_temp
			);
			$kategori_respon_temp[] = $kategoripilihanyak;
		}

		$datanya = array(
			'judul_kuesioner' => $judul_kuesioner,
			'deskripsi_kuesioner' => $deskripsi_kuesioner,
			'dimensi' => json_encode($dimensi_temp),
			'kategori_respon' => json_encode($kategori_respon_temp),
			'created_by' => $this->session->userdata('userid'),
			'created_at' => date('Y-m-d H:i:s'),
			'status' => 0
		);

		$this->Kuesioner_model->insert($datanya);
		$e = array(
			'response' => 'ok'
		);
		echo json_encode($e);
	}

	public function create_kuesioner_full()
	{
		$judul_kuesioner = $this->input->post('judul_kuesioner');
		$deskripsi_kuesioner = $this->input->post('deskripsi_kuesioner');
		
		$dimensi = $this->input->post('dimensi');

		$datadiskusi = json_decode($this->input->post('diskusilist'), true);

		$kategori_respon = $this->input->post('kategori_respon');

		$kategori_respon_temp = [];		

		for ($i=0; $i < count($kategori_respon); $i++) {
			$pilihan_kategori_respon = $this->input->post('pilihan_kategori_responrow'.$i);

			$pilihan_kategori_respon_temp = [];

			for ($y=0; $y < count($pilihan_kategori_respon); $y++) { 
				$pilihan_kategori_respon_temp[] = $pilihan_kategori_respon[$y];
			}

			$kategoripilihanyak = array(
				'nama' => $kategori_respon[$i],
				'respon_list' => $pilihan_kategori_respon_temp
			);
			$kategori_respon_temp[] = $kategoripilihanyak;
		}

		$datanya = array(
			'judul_kuesioner' => $judul_kuesioner,
			'deskripsi_kuesioner' => $deskripsi_kuesioner,
			'dimensi' => $dimensi,
			'kategori_respon' => json_encode($kategori_respon_temp),
			'created_by' => $this->session->userdata('userid'),
			'created_at' => date('Y-m-d H:i:s'),
			'status' => 0
		);

		// print_r($datanya);



		$this->Kuesioner_model->insert($datanya);

		// get last inserted id
		$last_id = $this->db->insert_id();

		foreach($datadiskusi as $value){
			$datadiskusinyak = array(
				'id_kuesioner' => $last_id,
				'urutan' => $value['urutan'],
				'dimensi' => $value['dimensi'],
				'indikator' => $value['indikator'],
				'isi_diskusi' => $value['diskusi']
			);
			$this->Diskusi_model->insert($datadiskusinyak);
		}
		$e = array(
			'response' => 'ok'
		);
		echo json_encode($e);
	}

	public function success()
	{
		$doing = $this->input->get('thing');
		$operation = $this->input->get('operation');

		if ($operation == 'add') {
			$this->session->set_flashdata('success', $doing.' berhasil ditambahkan');
		}

		if ($operation == 'update') {
			$this->session->set_flashdata('success', $doing.' berhasil diupdate');
		}

		if ($operation == 'delete') {
			$this->session->set_flashdata('success', $doing.' berhasil dihapus');
		}

		redirect(site_url('kuesioner'));
	}

	public function export($id_kuesioner)
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', "DATA RESPONDEN"); // Set kolom A1 dengan tulisan "DATA SISWA"
		$sheet->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai F1
		$sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
		$sheet->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1

		$sheet->mergeCells('A2:A3');
		$sheet->mergeCells('B2:B3');
		$sheet->mergeCells('C2:C3');
		$sheet->mergeCells('D2:D3');
		$sheet->mergeCells('E2:E3');
		$sheet->mergeCells('F2:F3');
		$sheet->mergeCells('G2:G3');
		$sheet->mergeCells('H2:H3');


		// Buat header tabel nya pada baris ke 3
		$sheet->setCellValue('A2', "No");
		$sheet->setCellValue('B2', "Email");
		$sheet->setCellValue('C2', "Direktorat");
		$sheet->setCellValue('D2', "Nama karyawan");
		$sheet->setCellValue('E2', "Unit Kerja");
		$sheet->setCellValue('F2', "Job Grade");
		$sheet->setCellValue('G2', "Status Karyawan");
		$sheet->setCellValue('H2', "Nama Jabatan");
		
		$ld = $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id_kuesioner);

		$kategoriresponbykuesioner = json_decode($this->Kuesioner_model->get_by_id($id_kuesioner)->kategori_respon, TRUE);

		$jumlahkategorirespon = count($kategoriresponbykuesioner);

		$col = 9;
		foreach ($ld as $key => $value) {
			$sheet->setCellValueByColumnAndRow($col, 2, $value->isi_diskusi);

			foreach ($kategoriresponbykuesioner as $key => $krbk) {
				$sheet->setCellValueByColumnAndRow($col++, 3, $krbk['nama']);
			}
		}

		$sheet->getRowDimension('1')->setRowHeight(20);
		$sheet->getRowDimension('2')->setRowHeight(20);
		$sheet->getRowDimension('3')->setRowHeight(20);

		$list_jawaban = $this->Jawaban_model->get_by_kuesioner($id_kuesioner);

		$no = 1;
		$row = 4;
		foreach ($list_jawaban as $value) {
			$sheet->setCellValue('A' . $row, $no);
		    $sheet->setCellValue('B' . $row, $value->email);
		    $sheet->setCellValue('C' . $row, $this->Direktorat_model->get_by_id($value->direktorat)->nama_direktorat);
		    $sheet->setCellValue('D' . $row, $value->nama_karyawan);
		    $sheet->setCellValue('E' . $row, $value->unit_kerja);
		    $sheet->setCellValue('F' . $row, $value->job_grade);
		    $sheet->setCellValue('G' . $row, $value->status_karyawan);
		    $sheet->setCellValue('H' . $row, $value->nama_jabatan);

		    $anujawaban = json_decode($value->jawaban, true);
			
			$cul = 9;
			foreach ($anujawaban as $aj) {

				foreach ($kategoriresponbykuesioner as $kr) {
					$sheet->setCellValueByColumnAndRow($cul++, $row, $aj[$kr['nama']]);
				}
			}

		    // $culsec = 10;
		    // foreach ($anujawaban as $key => $value) {
		    // 	$sheet->setCellValueByColumnAndRow($culsec++, $row, $value['harapan']);
		    // 	$culsec++;
		    // }


		    $sheet->getRowDimension($row)->setRowHeight(20); // Set height tiap row

		    $no++; // Tambah 1 setiap kali looping
		    $row++; // Tambah 1 setiap kali looping
		}

		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A

		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

		// Set judul file excel nya sheetnya
		$sheet->setTitle("Responden");

		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Data Responden.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		ob_end_clean();
		ob_start();
		$writer->save('php://output');
	}

	public function delete($id_kuesioner)
	{
		$cek = $this->Kuesioner_model->get_by_id($id_kuesioner);

		if ($cek) {

			$cekdiskusiygudahdibuat = $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id_kuesioner);
			if ($cekdiskusiygudahdibuat) {
				$this->Diskusi_model->delete_all_by_kuesioner($id_kuesioner);
			}

			$this->Kuesioner_model->delete($id_kuesioner);
			$this->session->set_flashdata('success', 'Kuesioner berhasil dihapus');
			redirect(site_url('kuesioner'));
		} else {
			$this->session->set_flashdata('failed', 'Gagal Menghapus Kuesioner');
			redirect(site_url('kuesioner'));
		}
	}

	public function edit($id_kuesioner)
	{
		$data_kuesioner = $this->Kuesioner_model->get_by_id($id_kuesioner);

		$data = array(
			'list_diskusi' => $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id_kuesioner),
			'data_kuesioner' => $data_kuesioner,
			'aksi' => 'Kelola',
			'menu' => 'Kuesioner',
			'action' => site_url('kuesioner/update_action'),
			'classnyak' => $this,
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
		);

		$this->template->load('admin/kuesioner/kuesioner_read', $data);
	}

	public function auto_save()
	{
		$id_kuesioner = $this->input->post('id_kuesioner');
		$urutan = $this->input->post('urutan');
		$action = $this->input->post('action');
		$id_diskusi = $this->input->post('id_diskusi');

		$message = '';

		if ($id_diskusi) {
			if ($action == 'delete') {
				$message = 'hapus diskusi berhasil';
			}

			if ($action == 'update') {
				$dimensi = $this->input->post('dimensi');
				$indikator = $this->input->post('indikator');
				$isi_diskusi = $this->input->post('isi_diskusi');

				$datatoupdate = array(
					'urutan' => $urutan,
					'dimensi' => $dimensi,
					'indikator' => $indikator,
					'isi_diskusi' => $isi_diskusi
				);

				$this->Diskusi_model->update($id_diskusi, $datatoupdate);
				$message = 'update diskusi berhasil';
			}
		} else {
			if ($action == 'add') {
				$datatoinsert = array(
					'id_kuesioner' => $id_kuesioner,
					'urutan' => $urutan,
					'dimensi' => '',
					'indikator' => '',
					'isi_diskusi' => ''
				);

				$this->Diskusi_model->insert($datatoinsert);

				$id_diskusi = $this->db->insert_id();

				$message = 'tambah diskusi berhasil';
			}
		}

		$arr = array(
			'response' => 'ok',
			'message' => $message,
			'id_diskusi' => $id_diskusi
		);

		echo json_encode($arr);
	}

	public function update_manual()
	{
		$id_kuesioner = $this->input->post('id_kuesioner');
		$judul_kuesioner = $this->input->post('judul_kuesioner');
		$deskripsi_kuesioner = $this->input->post('deskripsi_kuesioner');

		$datatoupdate = array(
			'judul_kuesioner' => $judul_kuesioner,
			'deskripsi_kuesioner' => $deskripsi_kuesioner
		);

		$this->Kuesioner_model->update($id_kuesioner, $datatoupdate);

		$arr = array(
			'response' => 'ok',
		);

		echo json_encode($arr);
	}

	public function get_indikator($ik = NULL, $d = NULL, $indikator = NULL)
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
			echo $deee == $indikator ? '<option value="'.$deee.'" selected>'.$deee.'</option>' : '<option value="'.$deee.'">'.$deee.'</option>';
		}
	}

	public function update_status()
	{
		$id_kuesioner = $this->input->post('id');
		$status = $this->input->post('status');

		$datatoupdate = array(
			'status' => $status
		);

		$this->Kuesioner_model->update($id_kuesioner, $datatoupdate);

		$arr = array(
			'response' => 'ok',
		);

		echo json_encode($arr);
	}
}