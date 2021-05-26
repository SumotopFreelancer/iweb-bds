<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pagehome extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		if ($this->input->post()) {
			$data = [
				'homeProduct' => $this->input->post('homeProduct', TRUE),
				'seo' => json_encode([
					'title' => $this->input->post('title_seo', TRUE),
					'description' => $this->input->post('description_seo', TRUE),
					'keyword' => $this->input->post('keyword_seo', TRUE),
					'image_link' => $this->input->post('image_link_seo')
				])
			];
			foreach ($data as $key => $row) {
				if ($this->setup_model->update_rule(['col' => $key], ['value' => $row])) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
			}
			redirect(admin_url('pagehome'));
		}
		$this->data['temp'] = 'admin/pagehome/index';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
}
