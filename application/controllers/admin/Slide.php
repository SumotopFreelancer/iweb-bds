<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Slide extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('slide_model');
	}

	function index()
	{
		// Pagination
		$config = $this->adminpagination->config($this->slide_model->get_total(), admin_url('slide'), 10, $_GET, admin_url('slide'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input = [];
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['list'] = $this->slide_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/slide/index';
		$this->load->view('admin/main', $this->data);
	}
	function add()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$data = [
					'name' => $this->input->post('name', TRUE),
					'link' => $this->input->post('link', TRUE),
					'intro' => $this->input->post('intro'),
					'image_link' => $this->input->post('image_link'),
					'image_link_mobile' => $this->input->post('image_link_mobile'),
					'sort_order' => intval($this->input->post('sort_order')),
					'status' => $this->input->post('status'),
					'created' => now(),
					'updated' => now()
				];
				if ($this->slide_model->create($data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				redirect(admin_url('slide'));
			}
		}
		$this->data['temp'] = 'admin/slide/add';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
	function edit()
	{
		$id = intval($this->uri->rsegment('3'));
		$info = $this->slide_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('slide'));
		}
		$this->data['info'] = $info;
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$data = [
					'name' => $this->input->post('name', TRUE),
					'link' => $this->input->post('link', TRUE),
					'intro' => $this->input->post('intro'),
					'image_link' => $this->input->post('image_link'),
					'image_link_mobile' => $this->input->post('image_link_mobile'),
					'sort_order' => intval($this->input->post('sort_order')),
					'status' => $this->input->post('status'),
					'updated' => now()
				];
				if ($this->slide_model->update($id, $data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
				if ($this->input->post('cus_btn_save') == 'Lưu lại') {
					redirect(admin_url('slide/edit/' . $id));
				} else {
					redirect(admin_url('slide'));
				}
			}
		}
		$this->data['temp'] = 'admin/slide/edit';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
	// Xóa
	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		redirect(admin_url('slide'));
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
		$info = $this->slide_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('slide'));
			}
		}
		if ($this->slide_model->delete($id)) {
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
		$this->db->cache_delete_all();
	}
	function status()
	{
		$id = intval($this->input->post('id'));
		$info = $this->slide_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('slide'));
		}
		if ($info->status == 1) {
			$data = ['status' => 0];
			$this->slide_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->status == 0) {
			$data = ['status' => 1];
			$this->slide_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->db->cache_delete_all();
	}
}
