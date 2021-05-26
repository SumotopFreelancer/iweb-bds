<?php
defined('BASEPATH') or exit('No direct script access allowed');
class District extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('district_model');
		$this->load->model('ward_model');
		$this->load->model('products_model');
	}
	function index()
	{
		// Pagination
		$config = $this->adminpagination->config($this->district_model->get_total(), admin_url('district'), 30, $_GET, admin_url('district'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input = [];
		$input['limit'] = [$config['per_page'], $segment];
		$input['order_by'] = ['sort_order' => 'asc'];
		$this->data['list'] = $this->district_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/district/index';
		$this->load->view('admin/main', $this->data);
	}
	function add()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$data = [
					'name' => trim($this->input->post('name', TRUE)),
					'sort_order' => intval($this->input->post('sort_order'))
				];
				if ($this->district_model->create($data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				redirect(admin_url('district'));
			}
		}
		$this->data['temp'] = 'admin/district/add';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
	function edit()
	{
		$id = intval($this->uri->rsegment('3'));
		$info = $this->district_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('district'));
		}
		$this->data['info'] = $info;

		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$data = [
					'name' => trim($this->input->post('name', TRUE)),
					'sort_order' => intval($this->input->post('sort_order'))
				];
				if ($this->district_model->update($id, $data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
				if ($this->input->post('cus_btn_save') == 'Lưu lại') {
					redirect(admin_url('district/edit/' . $id));
				} else {
					redirect(admin_url('district'));
				}
			}
		}
		$this->data['temp'] = 'admin/district/edit';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
	// Xóa
	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		redirect(admin_url('district'));
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
		$info = $this->district_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('district'));
			}
		}
		if ($this->district_model->delete($id)) {
			$this->ward_model->del_rule(['district_id' => $id]);
			$this->products_model->update_rule(['district_id' => $id], ['district_id' => 0, 'ward_id' => 0]);
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
		$this->db->cache_delete_all();
	}
}
