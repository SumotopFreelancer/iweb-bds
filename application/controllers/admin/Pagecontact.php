<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pagecontact extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	// chinh sua 
	function index()
	{
		if ($this->input->post()) {
			$data = [
				'content_contact' => json_encode([
					'title' => $this->input->post('title_content_contact'),
					'info' => $this->input->post('info_content_contact'),
					'success' => $this->input->post('success_content_contact')
				]),
				'seo_contact' => json_encode([
					'title' => $this->input->post('title_seo', TRUE),
					'description' => $this->input->post('description_seo', TRUE),
					'keyword' => $this->input->post('keyword_seo', TRUE),
					'image_link' => $this->input->post('image_link')
				]),
			];
			foreach ($data as $key => $row) {
				if ($this->setup_model->update_rule(['col' => $key], ['value' => $row])) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
			}
			redirect(admin_url('pagecontact'));
		}
		$this->data['temp'] = 'admin/pagecontact/index';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
}
