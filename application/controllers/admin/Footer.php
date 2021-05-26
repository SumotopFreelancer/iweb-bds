<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Footer extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
		//Load bài viết
		$this->news = $this->news_model->get_list();
		$this->data['news'] = $this->news;
	}
	function index()
	{
		if ($this->input->post()) {
			$data = [
				'footer1' => json_encode([
					'title' => $this->input->post('title_footer1', TRUE),
					'content' => $this->input->post('content_footer1')
				]),
				'footer2' => json_encode([
					'title' => $this->input->post('title_footer2', TRUE),
					'content' => $this->input->post('content_footer2')
				]),
				'footer3' => json_encode([
					'title' => $this->input->post('title_footer3', TRUE),
					'content' => $this->input->post('content_footer3')
				]),
				'footer4' => json_encode([
					'title' => $this->input->post('title_footer4', TRUE),
					'content' => $this->input->post('content_footer4')
				])
			];
			foreach ($data as $key => $row) {
				if ($this->setup_model->update_rule(['col' => $key], ['value' => $row])) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
			}
			redirect(admin_url('footer'));
		}
		$this->data['temp'] = 'admin/footer/index';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
}
