<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Backup extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
        $this->load->model('Akun_model');
        $this->load->model('Kuesioner_model');
        $this->load->model('Backup_model');
        $this->load->model('Formindividu_model');
        $this->load->library('template');
    }

    public function index()
    {
        $user_id = $this->session->userdata('userid');

        // get action queryurl
        $action = $this->input->get('action');

        $data = array(
            'menu' => 'Backup',
            'action' => $action,
            'sett_apps' => $this->Setting_app_model->get_by_id(1),
            'form_individu' => $this->Formindividu_model->get_all(),
        );
        $this->template->load('admin/backup/v_wrapper', $data);
    }

    public function export()
    {
        $type = $this->input->get('type_export');

        if ($type == "0") {
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

    public function export_excel($data)
    {
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
        $filename = 'data-' . date('Ymd') . '.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');

        // return as url string of exported excel file
        $writer->save('php://output');
    }

    public function import_template()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

        // merge cell A2:A3
        $spreadsheet->getActiveSheet()->mergeCells('A2:A3');
        $spreadsheet->getActiveSheet()->mergeCells('B2:B3');
        $spreadsheet->getActiveSheet()->mergeCells('C2:C3');
        $spreadsheet->getActiveSheet()->mergeCells('D2:D3');
        $spreadsheet->getActiveSheet()->mergeCells('E2:E3');
        // set cell value

        $sheet->setCellValue('A1', 'KUESIONER');
        $sheet->setCellValue('B1', chiperencrypt('Kuesioner'));

        $sheet->setCellValue('A2', 'Dimensi');
        $sheet->setCellValue('B2', 'Indikator');
        $sheet->setCellValue('C2', 'No');
        $sheet->setCellValue('D2', 'Diskusi');
        $sheet->setCellValue('E2', 'Filter');

        // set row 2 as bold
        $spreadsheet->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);

        // set text align of column A
        $spreadsheet->getActiveSheet()->getStyle('A2:A3')->getAlignment()->setHorizontal(
            \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        );

        // set column width
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(7);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(36);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(36);

        $spreadsheet->getActiveSheet()->getStyle('A')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('B')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('C')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('D')->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('E')->getAlignment()->setWrapText(true);

        // loop until 10 rows and fill with text
        for ($i = 3; $i <= 10; $i++) {
            $sheet->setCellValue('A' . $i, 'Nama Dimensi ' . $i);
            $sheet->setCellValue('B' . $i, 'Nama Indikator Dimensi ' . $i);
            $sheet->setCellValue('C' . $i, $i - 2);
            $sheet->setCellValue('D' . $i, 'Isi Diskusi ' . $i);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="importkuesionertemplate.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function import()
    {
        $file = $_FILES['file']['tmp_name'];
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        $datany = array();

        $dimensinamelist = [];

        $diskusilist = [];

        // get cell B1

        $cellA1 = $spreadsheet->getActiveSheet()->getCell('A1')->getValue();

        if ($cellA1 === 'KUESIONER') {
            $cellB1 = $spreadsheet->getActiveSheet()->getCell('B1')->getValue();

            $decrypt = chiperdecrypt($cellB1);

            if ($decrypt == 'Kuesioner') {
                foreach ($sheetData as $key => $value) {
                    if ($key > 2) {

                        if ($value['A']) {

                            $dimens = trim($value['A']);

                            if (!in_array($dimens, $dimensinamelist)) {
                                // push to array
                                array_push($dimensinamelist, $dimens);
                            }
                        }
                    }
                }

                foreach ($sheetData as $key => $value) {
                    if ($key > 3) {
                        if($value['A'] || $value['B'] || $value['C'] || $value['D']){

                            $diskusilist[] = array(
                                'urutan' => trim($value['C']),
                                'dimensi' => trim($value['A']),
                                'indikator' => trim($value['B']),
                                'diskusi' => trim($value['D']),
                                'exception' => trim($value['E']),
                            );
                        }

                    }
                }


                foreach ($dimensinamelist as $key => $value) {
                    $temp = array(
                        'name' => trim($value),
                        'indikator' => []
                    );

                    $indikator = [];

                    foreach ($sheetData as $key => $valueowo) {
                        if ($key > 2) {

                            $dimns = trim($valueowo['A']);

                            if ($value == $dimns) {
                                if (!in_array($valueowo['B'], $indikator)) {
                                    // push to array
                                    array_push($indikator, trim($valueowo['B']));
                                }
                            }
                        }
                    }

                    $temp['indikator'] = $indikator;

                    $datany[] = $temp;
                }

                // echo '<pre>';
                // echo json_encode($datany);
                // echo '</pre>';

                // $this->Akun_model->insert_batch($data);

                $exceptiondata = [
                    'status' => 0,
                    'value' => []
                ];

                foreach ($diskusilist as $key => $value) {
                    // if $value['exception'] is not empty, stop this foreach and set $exceptiondata['status'] to 1
                    if ($value['exception']) {
                        $exceptiondata['status'] = 1;
                        break;
                    }
                }

                if($exceptiondata['status'] == 1){
                    foreach ($diskusilist as $key => $value) {
                        if ($value['exception']) {
                            // check if exception is already in $exceptiondata['value']
                            if (!in_array($value['exception'], $exceptiondata['value'])) {
                                // push to array
                                array_push($exceptiondata['value'], $value['exception']);
                            }
                        }
                    }
                }

                $arr = array(
                    'response' => 'ok',
                    'jenis' => 'Kuesioner',
                    'message' => 'Verified',
                    'datakuesioner' => json_encode($datany),
                    'datadiskusi' => json_encode($diskusilist),
                    'verify' => array(
                        'dimensi' => 'ok',
                        'indikator' => 'ok',
                        'diskusi' => 'ok',
                        'urutan' => 'ok',
                        'exception' => $exceptiondata
                    )
                );
                echo json_encode($arr);
            } else {
                $arr = array(
                    'response' => 'error',
                    'jenis' => 'Kuesioner',
                    'message' => 'File yang anda upload bukan template kuesioner yang sah',
                );
                echo json_encode($arr);
            }
        } else {
            $arr = array(
                'response' => 'error',
                'jenis' => 'Unknown',
                'message' => 'File yang anda upload bukan file yang sah',
            );
            echo json_encode($arr);
        }
    }

    public function get_list_backupdata()
    {

        $type = $this->input->post('type');

        $data = [];

        $typedata = '';
        $message = '';

        if($type == 0) 
        {
            $typedata = 'Kuesioner';
            $message = 'Silahkan pilih kuesioner yang ingin di export';
            $data = $this->Backup_model->list_kuesioner();
        }

        if($type == 1) {
            $typedata = 'Respons';
            $message = 'Silahkan pilih kuesioner yang ingin di export responnya';
            $data = $this->Backup_model->list_diskusi();
        }

        if($type == 2) {
            $typedata = 'Form Individu';
            $message = 'Silahkan pilih Form identitas yang ingin di export';
            $data = $this->Backup_model->list_formindividu();
        }

        $datapass = array(
            'type' => $type,
            'typedata' => $typedata,
            'dataList' => $data,
            'jenisDatalowercase' => strtolower(str_replace(' ', '_', $typedata)),
            'jenisData' => $typedata,
            'messageny' => $message
        );

        $jsondata = array(
            'response' => 'ok',
            'message' => 'Success',
            'type' => $type,
            'html' => $this->load->view('admin/backup/list_data', $datapass, true),
        );

        echo json_encode($jsondata);
    }
}
