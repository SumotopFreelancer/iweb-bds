<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contactemail extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('contactemail_model');
	}
	function index()
	{
		// Data
		$input = [];
		if ($this->input->get()) {
			if ($this->input->get('email')) {
				$input['like'] = ['email' => $this->input->get('email', TRUE)];
			}
		}
		// Pagination
		$config = $this->adminpagination->config($this->contactemail_model->get_total($input), admin_url('contactemail'), 10, $_GET, admin_url('contactemail'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input['limit'] = [$config['per_page'], $segment];
		$input['order_by'] = ['id' => 'desc'];
		$this->data['list'] = $this->contactemail_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/contactemail/index';
		$this->load->view('admin/main', $this->data);
	}
	// Xóa
	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		redirect(admin_url('contactemail'));
		$this->db->cache_delete_all();
	}
	// Xóa nhiều
	function del_all()
	{
		$ids = $this->input->post('ids');
		foreach ($ids as $id) {
			$this->_del($id);
		}
		$this->db->cache_delete_all();
	}
	private function _del($id, $ajax = TRUE)
	{
		$info = $this->contactemail_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('contactemail'));
			}
		}
		if ($this->contactemail_model->delete($id)) {
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
		$this->db->cache_delete_all();
	}
}
