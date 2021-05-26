<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deletecache extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		$link = './application/cache/cachedata';
		remove_directory($link, TRUE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">XÓA CACHE THÀNH CÔNG</div>');
		redirect(admin_url());
	}
}
