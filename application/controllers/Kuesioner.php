<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
        $this->load->model('Jawaban_model');
        $this->load->model('Direktorat_model');
    }

	public function index()
	{
		$id_kuesioner = $this->input->get('id');

		echo $id_kuesioner;
	}

	public function get_all_kuesioner()
	{
		$user_id = $this->session->userdata('userid');
		$data = array(
			'list_kuesioner' => $this->Kuesioner_model->get_all_by_createdby($user_id)
		);

		$this->load->view('admin/kuesioner/list',$data);
	}

	public function create()
	{
		$this->load->view('admin/kuesioner/form');
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
			'created_by' => $this->session->userdata('userid')
		);

		$this->Kuesioner_model->insert($datanya);
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
		$sheet->setCellValue('A2', "No"); // Set kolom A3 dengan tulisan "NO"
		$sheet->setCellValue('B2', "Email"); // Set kolom B3 dengan tulisan "NIS"
		$sheet->setCellValue('C2', "Direktorat"); // Set kolom C3 dengan tulisan "NAMA"
		$sheet->setCellValue('D2', "Nama karyawan"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('E2', "Unit Kerja"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('F2', "Job Grade"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('G2', "Status Karyawan"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		$sheet->setCellValue('H2', "Nama Jabatan"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
		
		$ld = $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id_kuesioner);

		$col = 9;
		foreach ($ld as $key => $value) {
			$sheet->setCellValueByColumnAndRow($col, 2, $value->detail_diskusi); // Set kolom E3 dengan tulisan
			$sheet->setCellValueByColumnAndRow($col++, 2, $value->detail_diskusi); // Set kolom E3 dengan tulisan
			$sheet->setCellValueByColumnAndRow($col--, 3, 'Harapan'); // Set kolom E3 dengan tulisan "TELEPON"
			$sheet->setCellValueByColumnAndRow($col++, 3, 'Pengalaman'); // Set kolom E3 dengan tulisan "TELEPON"
			$col++;
		}

		
		// $sheet->setCellValue('F3', "ALAMAT"); // Set kolom F3 dengan tulisan "ALAMAT"

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		// $sheet->getStyle('A3')->applyFromArray($style_col);
		// $sheet->getStyle('B3')->applyFromArray($style_col);
		// $sheet->getStyle('C3')->applyFromArray($style_col);
		// $sheet->getStyle('D3')->applyFromArray($style_col);
		// $sheet->getStyle('E3')->applyFromArray($style_col);
		// $sheet->getStyle('F3')->applyFromArray($style_col);

		// Set height baris ke 1, 2 dan 3
		$sheet->getRowDimension('1')->setRowHeight(20);
		$sheet->getRowDimension('2')->setRowHeight(20);
		$sheet->getRowDimension('3')->setRowHeight(20);

		// Buat query untuk menampilkan semua data siswa
		$list_jawaban = $this->Jawaban_model->get_by_kuesioner($id_kuesioner);

		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$row = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
		foreach ($list_jawaban as $value) {
			$sheet->setCellValue('A' . $row, $no);
		    $sheet->setCellValue('B' . $row, $value->email);
		    $sheet->setCellValue('C' . $row, $this->Direktorat_model->get_by_id($value->nama_direktorat)->direktorat);
		    $sheet->setCellValue('D' . $row, $value->nama_karyawan);
		    $sheet->setCellValue('E' . $row, $value->unit_kerja);
		    $sheet->setCellValue('F' . $row, $value->job_grade);
		    $sheet->setCellValue('G' . $row, $value->status_karyawan);
		    $sheet->setCellValue('H' . $row, $value->nama_jabatan);

		    $anujawaban = json_decode($value->jawaban, true);
		    $cul = 9;
		    foreach ($anujawaban as $key => $value) {
		    	$sheet->setCellValueByColumnAndRow($cul++, $row, $value['pengalaman']);
		    	$cul++;
		    }

		    $culsec = 10;
		    foreach ($anujawaban as $key => $value) {
		    	$sheet->setCellValueByColumnAndRow($culsec++, $row, $value['harapan']);
		    	$culsec++;
		    }


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
}