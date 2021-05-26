<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Script extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		if ($this->input->post()) {
			$data = [
				'script_head' => $this->input->post('script_head'),
				'script_body' => $this->input->post('script_body'),
				'script_footer' => $this->input->post('script_footer'),
			];
			foreach ($data as $key => $row) {
				if ($this->setup_model->update_rule(['col' => $key], ['value' => $row])) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
			}
			redirect(admin_url('script'));
		}
		$this->data['temp'] = 'admin/script/index';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
}
