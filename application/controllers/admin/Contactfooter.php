<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contactfooter extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		redirect();
		$this->load->model('contactfooter_model');
	}
	function index()
	{
		// Data
		$input = [];
		if ($this->input->get()) {
			if ($this->input->get('name')) {
				$input['like'] = ['name' => $this->input->get('name', TRUE)];
			}
			$data_from = convert_time_admin($this->input->get('date_from'));
			$data_to = convert_time_admin($this->input->get('date_to'));
			$input['where'] = ['created >=' => $data_from, 'created <=' => $data_to];
		}
		// Pagination
		$config = $this->adminpagination->config($this->contactfooter_model->get_total($input), admin_url('contactfooter'), 10, $_GET, admin_url('contactfooter'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input['limit'] = [$config['per_page'], $segment];
		$input['order_by'] = ['id' => 'desc'];
		$this->data['list'] = $this->contactfooter_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/contactfooter/index';
		$this->load->view('admin/main', $this->data);
	}
	// Xóa
	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		redirect(admin_url('contactfooter'));
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
		$info = $this->contactfooter_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('contactfooter'));
			}
		}
		if ($this->contactfooter_model->delete($id)) {
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
		$this->db->cache_delete_all();
	}
}
