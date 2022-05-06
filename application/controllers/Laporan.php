<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
        $this->load->model('Kuesioner_model');
        $this->load->model('Laporan_model');
        $this->load->library('template');
		$this->load->library('report_processor');
    }

	public function index()
	{
        $user_id = $this->session->userdata('userid');
		$data = array(
			'list_kuesioner' => $this->Kuesioner_model->get_all_by_createdby($user_id),
			'menu' => 'Laporan',
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
		);
		$this->template->load('admin/laporan/v_wrapper',$data);
	}

	public function detail_kuesioner($id_kuesioner)
	{
		$data_kuesioner = $this->Kuesioner_model->get_by_id($id_kuesioner);

		$data = array(
			'id_kuesioner' => $id_kuesioner,
			'total_responden' => $this->Laporan_model->count_total_respond($id_kuesioner),
			'todays_responden' => $this->Laporan_model->count_total_rows_by_date($id_kuesioner, date('Y-m-d')),
			'list_diskusi_jawaban' => $this->Laporan_model->get_all_rows_by_id_kuesioner($id_kuesioner),
			'list_diskusi' => $this->Kuesioner_model->get_all_diskusi_by_kuesioner($id_kuesioner),
			'data_kuesioner' => $data_kuesioner,
		);

		$arr = array(
			'response' => 'ok',
			'page' => $this->load->view('admin/laporan/insight_detail', $data, TRUE)
		);

		echo json_encode($arr);
	}

	function fetch_detail_responden_individual() {
		$id_kuesioner = $this->input->post('id_kuesioner');
		$urutan = $this->input->post('urutan') - 1;

		$total_responden = $this->Laporan_model->count_total_respond($id_kuesioner);

		$data = $this->db->like('jawaban','"id_kuesioner":"'.$id_kuesioner.'"')->get('tbl_jawaban', 1, $urutan)->row();
		
		$datadiri = json_decode($data->data_diri, TRUE);

		$datajawaban = json_decode($data->jawaban, TRUE);

		$choices = json_decode($this->Kuesioner_model->get_by_id($id_kuesioner)->kategori_respon, TRUE);

		$data_kuesioner = $this->Kuesioner_model->get_by_id($id_kuesioner);
		$str ='';

		if($data_kuesioner->auto_feedback_detection == '1') {
			$str .= '
				<div class="alert alert-success" role="alert">
					Respon ini memiliki feedback (cek pada bagian paling bawah)
				</div>
			';
		}

		$str .= '
		<div id="printJS-form">';

		

		foreach ($datadiri as $key => $value) {

			// split $key string by _ then join it with space with uppercase each word
			$p = ucwords(implode(' ', explode('_', $key)));
			
			$str.= '
			<div class="form-group">
				<label for="input'.$key.'">'.$p.'</label>
				<input type="text" disabled class="form-control disabled" id="input'.$key.'" placeholder="ingput" value="'.$value.'">
			</div>
			';	
		}

		foreach ($datajawaban as $key => $value) {

			$pertanyaan = $this->db->where('id', $value['id_diskusi'])->get('tbl_diskusi')->row();
	
			$str .= '
			<form>
				<div class="card">
					<div class="card-body">
						<p>'.$pertanyaan->isi_diskusi.'</p>
						
						<div class="container-fluid" style="display: flex;flex-direction: row; justify-content: space-evenly;">';

						foreach ($choices as $keykr => $kr) {
							$str .= "
							<div>
								<span style='width: 100%;text-align: center;display: block;font-size: 12px;font-weight: bold;'>".$kr['nama']."</span>

								<div class='form-check form-check-radio'>";
									
								$urutan = 0;

								foreach ($kr['respon_list'] as $key => $rp) {

									$owo = '';

									// echo $rp;
									// echo $value[$kr['nama']];

									if($rp == $value[$kr['nama']]) {
										$owo = 'checked';
									}
								
									$str .=	"
											<label for='disc".$urutan."_col".$keykr."_".$key."' class='form-check-label'>
												<input class='form-check-input preview-answer' type='radio' ".$owo." value='".$rp."' name='disc".$urutan."_col".$keykr."' id='disc".$urutan."_col".$keykr."_".$key."' disabled>
												".$rp."
												<span class='form-check-sign'></span>
											</label>";

									$urutan++;
								}
							$str .= "
								</div>
							</div>";
						}
			$str.= '
						</div>
					</div>
				</div>
			</form>
			';
		}

		if($data_kuesioner->auto_feedback_detection == '1') {
			$feedback = $data->feedback;

			if($feedback == 'N/A') {
				$feedback = 'Tidak ada';
			} else {
				
				$fb = json_decode($feedback, TRUE);

				foreach ($fb as $key => $value) {
					$str.= '
					<div class="card">
						<div class="card-body">
							<p>'.$key.' Feedback</p>
							<textarea class="form-control" rows="3" style="width: 100%;">'.$value.'</textarea>
						</div>
					</div>';
				}

			}
		}

		$str .= '</div>';
		
		$arr = array(
			'response' => 'ok',
			'page' => $str,
			'have_feedback' => $data_kuesioner->auto_feedback_detection,
			'total_resp' => $total_responden
		);
		
		echo json_encode($arr);
	}
}