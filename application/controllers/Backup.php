<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Backup extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
        $this->load->model('Akun_model');
        $this->load->model('Kuesioner_model');
        $this->load->library('template');
    }

	public function index()
	{
        $user_id = $this->session->userdata('userid');
		$data = array(
			'menu' => 'Backup',
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
		);
		$this->template->load('admin/backup/v_wrapper',$data);
	}

    public function export()
    {
        $type = $this->input->get('type_export');

        if($type == "0"){
            $selectdata = $this->Kuesioner_model->get_all();
            $file = $this->export_excel($selectdata);
            $arr = array(
                'response' => 'ok',
                'redirect' => $file,
            );
            echo json_encode($arr);
        } else {
            $arr = array(
                'response' => 'ok',
                'message' => 'Not Available yet',
            );

            echo json_encode($arr);
        }
    }

    public function export_excel($data){
        // get list of keys from array $data
        $keys = array_keys($data[0]);
        // create a new spreadsheet object
        $spreadsheet = new Spreadsheet();
        // set default font
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        // set default font size
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        // create a new worksheet
        $sheet = $spreadsheet->getActiveSheet();
        // set first row as the header row
        $sheet->fromArray($keys, NULL, 'A1');
        // download
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'data-'.date('Ymd').'.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        
        // return as url string of exported excel file
        $writer->save('php://output');
    }

	
}