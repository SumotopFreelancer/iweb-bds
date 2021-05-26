<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Social extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		if ($this->input->post()) {
			$data = [
				'social' => json_encode([
					'facebook' => $this->input->post('facebook', TRUE),
					'id_facebook' => $this->input->post('id_facebook', TRUE),
					'youtube' => $this->input->post('youtube', TRUE),
					'zalo' => $this->input->post('zalo', TRUE),
					'skype' => $this->input->post('skype', TRUE),
					'linkedin' => $this->input->post('linkedin', TRUE),
					'twitter' => $this->input->post('twitter', TRUE),
					'instagram' => $this->input->post('instagram', TRUE)
				]),
			];
			foreach ($data as $key => $row) {
				if ($this->setup_model->update_rule(['col' => $key], ['value' => $row])) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
			}
			redirect(admin_url('social'));
		}
		$this->data['temp'] = 'admin/social/index';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
}
