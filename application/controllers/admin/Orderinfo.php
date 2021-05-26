<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Orderinfo extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		if ($this->input->post()) {
			$data = [
				'nganhang' => $this->input->post('nganhang'),
				'cartdone' => $this->input->post('cartdone'),
				'emailorder' => $this->input->post('emailorder', TRUE)
			];
			foreach ($data as $key => $row) {
				if ($this->setup_model->update_rule(['col' => $key], ['value' => $row])) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
			}
			redirect(admin_url('orderinfo'));
		}
		$this->data['temp'] = 'admin/orderinfo/index';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
}
