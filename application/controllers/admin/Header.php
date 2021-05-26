<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Header extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		if ($this->input->post()) {
			$data = [
				'favico' => $this->input->post('favico'),
				'logo' => json_encode([
					'name' => $this->input->post('name', TRUE),
					'image_link' => $this->input->post('image_link')
				]),
				'bannerHeader' => $this->input->post('bannerHeader'),
				'slogan' => $this->input->post('slogan', TRUE)
			];
			foreach ($data as $key => $row) {
				if ($this->setup_model->update_rule(['col' => $key], ['value' => $row])) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
			}
			redirect(admin_url('header'));
		}
		$this->data['temp'] = 'admin/header/index';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
}
