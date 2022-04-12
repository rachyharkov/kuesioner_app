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
		$data = $this->db->like('jawaban','"id_kuesioner":"'.$id_kuesioner.'"')->get('tbl_jawaban', 1, $urutan)->row()->jawaban;
		
		$datajawaban = json_decode($data, TRUE);

		$choices = json_decode($this->Kuesioner_model->get_by_id($id_kuesioner)->kategori_respon, TRUE);

		$str = '
		<div style="display: flex; flex-direction: column">';


		foreach ($datajawaban as $key => $value) {

			$pertanyaan = $this->db->where('id', $value['id_kuesioner'])->get('tbl_diskusi')->row();

			$str .= '
				<div class="card">
					<div class="card-body">
						<p>'.$pertanyaan->isi_diskusi.'</p>
						
						<div class="container-fluid" style="display: flex;
flex-direction: row;
justify-content: space-evenly;">';

						foreach ($choices as $keykr => $kr) {
							$str .= "
							<div>
								<span style='width: 100%;text-align: center;display: block;font-size: 12px;font-weight: bold;'>".$kr['nama']."</span>
								<div style='display: flex; flex-direction: column;'>";
									
									foreach ($kr['respon_list'] as $key => $rp) {

										$owo = '';

										if($rp == $datajawaban[$kr]) {
											$owo = 'checked';
										}
									
										$str .=	"<label for='disc".$value->urutan."_col".$keykr."_".$key."' class='radio'>
													<input type='radio' ".$owo." value='".$rp."' name='disc".$value->urutan."_col".$keykr."' id='disc".$value->urutan."_col".$keykr."_".$key."' class='hidden choicenya disc".$value->urutan."_col".$keykr."' />
													<span class='label'></span>".$rp."
												</label>";
									}
							$str .= "
								</div>
							</div>";
						}
						
			$str.= '
						</div>
					</div>
				</div>
			';
		}

		$str .= '</div>';
		
		echo $str;
	}
}