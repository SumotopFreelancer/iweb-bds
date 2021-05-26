<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Ward extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('district_model');
		$this->load->model('ward_model');
		$this->load->model('products_model');

		// Quận
		$input = [];
		$input['order_by'] = ['sort_order' => 'asc'];
		$this->data['districts'] = $this->district_model->get_list($input);
	}
	function index()
	{
		// Pagination
		$config = $this->adminpagination->config($this->ward_model->get_total(), admin_url('ward'), 30, $_GET, admin_url('ward'), 3);
		$this->pagination->initialize($config);
		$segment = intval($this->uri->segment(3)) == 0 ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input = [];
		$input['select'] = 'ward.id, ward.name, ward.sidebar, district.name as districtName';
		$input['join'] = [
			'district' => ['district.id = ward.district_id']
		];
		$input['limit'] = [$config['per_page'], $segment];
		$input['order_by'] = ['ward.sort_order' => 'asc'];
		$this->data['list'] = $this->ward_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/ward/index';
		$this->load->view('admin/main', $this->data);
	}
	function add()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			$this->form_validation->set_rules('district_id', 'Quận', 'required');
			if ($this->form_validation->run()) {
				$data = [
					'name' => trim($this->input->post('name', TRUE)),
					'district_id' => $this->input->post('district_id', TRUE),
					'sidebar' => $this->input->post('sidebar'),
					'sort_order' => intval($this->input->post('sort_order'))
				];
				if ($this->ward_model->create($data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				redirect(admin_url('ward'));
			}
		}
		$this->data['temp'] = 'admin/ward/add';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
	function edit()
	{
		$id = intval($this->uri->rsegment('3'));
		$info = $this->ward_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('ward'));
		}
		$this->data['info'] = $info;

		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			$this->form_validation->set_rules('district_id', 'Quận', 'required');
			if ($this->form_validation->run()) {
				$data = [
					'name' => trim($this->input->post('name', TRUE)),
					'district_id' => $this->input->post('district_id', TRUE),
					'sidebar' => $this->input->post('sidebar'),
					'sort_order' => intval($this->input->post('sort_order'))
				];
				if ($this->ward_model->update($id, $data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
				if ($this->input->post('cus_btn_save') == 'Lưu lại') {
					redirect(admin_url('ward/edit/' . $id));
				} else {
					redirect(admin_url('ward'));
				}
			}
		}
		$this->data['temp'] = 'admin/ward/edit';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
	// Xóa
	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		redirect(admin_url('ward'));
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
		$info = $this->ward_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('ward'));
			}
		}
		if ($this->ward_model->delete($id)) {
			$this->products_model->update_rule(['ward_id' => $id], ['ward_id' => 0]);
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
		$this->db->cache_delete_all();
	}
	function sidebar()
	{
		$id = intval($this->input->post('id'));
		$info = $this->ward_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('ward'));
		}
		if ($info->sidebar == 1) {
			$data = ['sidebar' => 0];
			$this->ward_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->sidebar == 0) {
			$data = ['sidebar' => 1];
			$this->ward_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
	}
}
