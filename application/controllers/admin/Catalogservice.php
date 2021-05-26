<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Catalogservice extends My_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('catalogservice_model');
		$this->load->model('services_model');
		$this->load->model('menu_model');

		// Load danh mục cha
		$input = [];
		$input['where'] = ['parent_id' => 0];
		$input['order_by'] = [check_sort($this->setadmin->sort_catalog_service)[0] => check_sort($this->setadmin->sort_catalog_service)[1]];
		$this->data['catalog'] = $this->catalogservice_model->get_list($input);
	}
	function index()
	{
		$this->data['total_rows'] = $this->catalogservice_model->get_total();
		// Load view
		$this->data['temp'] = 'admin/catalogservice/index';
		$this->load->view('admin/main', $this->data);
	}
	function add()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_add(chuyenurl($this->input->post('url', TRUE)), $name, 'catalogservice_model');
				$data = [
					'name' => $name,
					'url' => $url,
					'intro' => $this->input->post('intro'),
					'title' => $this->input->post('title', TRUE),
					'description' => $this->input->post('description', TRUE),
					'keyword' => $this->input->post('keyword', TRUE),
					'parent_id' => $this->input->post('parent_id'),
					'status' => $this->input->post('status'),
					'home' => $this->input->post('home'),
					'image_link' => $this->input->post('image_link'),
					'image_seo' => $this->input->post('image_seo'),
					'sort_order' => intval($this->input->post('sort_order')),
					'created' => now(),
					'updated' => now()
				];
				if ($this->catalogservice_model->create($data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				$this->load->helper('xml');
				sitemapUpdate();
				$this->db->cache_delete_all();
				redirect(admin_url('catalogservice'));
			}
		}
		$this->data['temp'] = 'admin/catalogservice/add';
		$this->load->view('admin/main', $this->data);
	}
	function edit()
	{
		$id = intval($this->uri->rsegment('3'));
		$info = $this->catalogservice_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('catalogservice'));
		}
		$this->data['info'] = $info;
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_edit(chuyenurl($this->input->post('url', TRUE)), $name, 'catalogservice_model', $id);
				$data = [
					'name' => $name,
					'url' => $url,
					'intro' => $this->input->post('intro'),
					'title' => $this->input->post('title', TRUE),
					'description' => $this->input->post('description', TRUE),
					'keyword' => $this->input->post('keyword', TRUE),
					'parent_id' => $this->input->post('parent_id'),
					'status' => $this->input->post('status'),
					'home' => $this->input->post('home'),
					'image_link' => $this->input->post('image_link'),
					'image_seo' => $this->input->post('image_seo'),
					'sort_order' => intval($this->input->post('sort_order')),
					'updated' => now()
				];
				if ($this->catalogservice_model->update($id, $data)) {
					// Sửa trong bảng menu
					$where = ['id_type' => $id, 'type' => 'catalogservice'];
					if ($this->menu_model->check_exists($where)) {
						$datamenu = [
							'url' => $url,
						];
						$this->menu_model->update_rule($where, $datamenu);
					}
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được. Thử lại sau</div>');
				}
				$this->load->helper('xml');
				sitemapUpdate();
				$this->db->cache_delete_all();
				if ($this->input->post('cus_btn_save') == 'Lưu lại') {
					redirect(admin_url('catalogservice/edit/' . $id));
				} else {
					redirect(admin_url('catalogservice'));
				}
			}
		}
		$this->data['temp'] = 'admin/catalogservice/edit';
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
		redirect(admin_url('catalogservice'));
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
		$info = $this->catalogservice_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('catalogservice'));
			}
		}
		// kiem tra danh muc có danh muc con hay k;
		if (count($this->catalogservice_model->menucon_admin($info->id)) > 0) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Danh mục <b>"' . $info->name . '"</b> có danh mục con. Bạn cần xóa danh mục con trước</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Danh mục <b>"' . $info->name . '"</b> có danh mục con. Bạn cần xóa danh mục con trước</div>');
				redirect(admin_url('catalogservice'));
			}
		}
		// kiem tra danh muc có bài viết hay khong
		$service = $this->services_model->get_info_rule(['catalog_id' => $id], 'id');
		if ($service) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Danh mục <b>"' . $info->name . '"</b> có chứa bài viết. Bạn cần xóa bài viết trước</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Danh mục <b>"' . $info->name . '"</b> có chứa bài viết. Bạn cần xóa bài viết trước</div>');
				redirect(admin_url('catalogservice'));
			}
		}
		if ($this->catalogservice_model->delete($id)) {
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
	}
	function status()
	{
		$id = intval($this->input->post('id'));
		$info = $this->catalogservice_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('catalogservice'));
		}
		if ($info->status == 1) {
			$data = ['status' => 0];
			$this->catalogservice_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->status == 0) {
			$data = ['status' => 1];
			$this->catalogservice_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
	function home()
	{
		$id = intval($this->input->post('id'));
		$info = $this->catalogservice_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('catalogservice'));
		}
		if ($info->home == 1) {
			$data = ['home' => 0];
			$this->catalogservice_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->home == 0) {
			$data = ['home' => 1];
			$this->catalogservice_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
}
