<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Setting_app_model');
        $this->load->model('Akun_model');
        $this->load->library('template');
    }

	public function index()
	{
        $user_id = $this->session->userdata('userid');
		$data = array(
			'menu' => 'Akun',
			'sett_apps' =>$this->Setting_app_model->get_by_id(1),
		);
		$this->template->load('admin/akun/akun_form',$data);
	}

	public function update_password()
	{
		$user_id = $this->session->userdata('userid');
		$data = array(
			'old_password' => $this->input->post('inputoldPassword'),
			'new_password' => $this->input->post('inputnewPassword'),
			'confirm_new_password' => $this->input->post('inputconfirmnewPassword'),
		);

		// check if old password is correct
		$check_old_password = $this->Akun_model->check_old_password($user_id,$data['old_password']);

		if($check_old_password) {
			// check if new password is same as old password
			if($data['new_password'] == $data['old_password']) {
				$message = 'Password baru tidak boleh sama dengan password lama';
				$status = 'wrong_confirm';
			} else {
				// check if new password is same as confirm new password
				if($data['new_password'] == $data['confirm_new_password']) {
					$anu = array(
						'password' => $data['new_password']
					);
					$this->Akun_model->update_password($anu,$user_id);
					$message = 'Password berhasil diubah';
					$status = 'success';
				} else {
					$message = 'Password baru dan konfirmasi password tidak sama';
					$status = 'wrong_confirm';
				}
			}
		} else {
			$message = 'Password lama tidak sesuai';
			$status = 'wrong_old';
		}

		$response = array(
			'status' => $status,
			'message' => $message,
		);

		echo json_encode($response);
	}
	
}