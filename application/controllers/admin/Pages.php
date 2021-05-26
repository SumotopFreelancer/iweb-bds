<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pages extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('pages_model');
		$this->load->model('menu_model');
	}
	function index()
	{
		// Pagination
		$config = $this->adminpagination->config($this->pages_model->get_total(), admin_url('pages'), 10, $_GET, admin_url('pages'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input = [];
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['list'] = $this->pages_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/pages/index';
		$this->load->view('admin/main', $this->data);
	}
	function add()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_add(chuyenurl($this->input->post('url', TRUE)), $name, 'pages_model');

				$data = [
					'name' => $name,
					'url' => $url,
					'intro' => $this->input->post('intro'),
					'content' => $this->input->post('content'),

					'title' => $this->input->post('title', TRUE),
					'description' => $this->input->post('description', TRUE),
					'keyword' => $this->input->post('keyword', TRUE),
					'image_link' => $this->input->post('image_link'),
					'image_seo' => $this->input->post('image_seo'),

					'created' => now(),
					'updated' => now(),
					'status' => $this->input->post('status'),
					'type' => $this->input->post('type'),
					'sort_order' => intval($this->input->post('sort_order'))
				];
				if ($this->pages_model->create($data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				$this->load->helper('xml');
				sitemapUpdate();
				$this->db->cache_delete_all();
				redirect(admin_url('pages'));
			}
		}
		// Load view
		$this->data['temp'] = 'admin/pages/add';
		$this->load->view('admin/main', $this->data);
	}
	function edit()
	{
		$id = intval($this->uri->rsegment('3'));
		$info = $this->pages_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('pages'));
		}
		$this->data['info'] = $info;
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			// khi nhap lieu chinh xac
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_edit(chuyenurl($this->input->post('url', TRUE)), $name, 'pages_model', $id);
				$data = [
					'name' => $name,
					'url' => $url,
					'intro' => $this->input->post('intro'),
					'content' => $this->input->post('content'),

					'title' => $this->input->post('title', TRUE),
					'description' => $this->input->post('description', TRUE),
					'keyword' => $this->input->post('keyword', TRUE),
					'image_link' => $this->input->post('image_link'),
					'image_seo' => $this->input->post('image_seo'),

					'updated' => now(),
					'status' => $this->input->post('status'),
					'type' => $this->input->post('type'),
					'sort_order' => intval($this->input->post('sort_order'))
				];
				if ($this->pages_model->update($id, $data)) {
					// Sửa trong bảng menu
					$where = ['id_type' => $id, 'type' => 'pages'];
					if ($this->menu_model->check_exists($where)) {
						$datamenu = [
							'url' => $url,
						];
						$this->menu_model->update_rule($where, $datamenu);
					}
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
				$this->load->helper('xml');
				sitemapUpdate();
				$this->db->cache_delete_all();
				if ($this->input->post('cus_btn_save') == 'Lưu lại') {
					redirect(admin_url('pages/edit/' . $id));
				} else {
					redirect(admin_url('pages'));
				}
			}
		}
		$this->data['temp'] = 'admin/pages/edit';
		$this->load->view('admin/main', $this->data);
	}
	// Xóa
	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
		redirect(admin_url('pages'));
	}
	// Xóa nhiều
	function del_all()
	{
		$ids = $this->input->post('ids');
		foreach ($ids as $id) {
			$this->_del($id);
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
	private function _del($id, $ajax = TRUE)
	{
		$info = $this->pages_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('pages'));
			}
		}
		if ($this->pages_model->delete($id)) {
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
	}

	function status()
	{
		$id = intval($this->input->post('id'));
		$info = $this->pages_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('pages'));
		}
		if ($info->status == 1) {
			$data = ['status' => 0];
			$this->pages_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->status == 0) {
			$data = ['status' => 1];
			$this->pages_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
}
