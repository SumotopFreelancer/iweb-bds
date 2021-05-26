<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Catalog extends My_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('catalog_model');
		$this->load->model('products_model');
		$this->load->model('menu_model');

		// Load danh mục cha
		$input = [];
		$input['where'] = ['parent_id' => 0];
		$input['order_by'] = [check_sort($this->setadmin->sort_catalog)[0] => check_sort($this->setadmin->sort_catalog)[1]];
		$catalog = $this->catalog_model->get_list($input);
		$this->data['catalog'] = $catalog;
	}
	function index()
	{
		$this->data['total_rows'] = $this->catalog_model->get_total();
		// Load view
		$this->data['temp'] = 'admin/catalog/index';
		$this->load->view('admin/main', $this->data);
	}
	function add()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_add(chuyenurl($this->input->post('url', TRUE)), $name, 'catalog_model');
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
					// 'image_thumb' => resize_image($this->input->post('image_link')),
					'image_seo' => $this->input->post('image_seo'),
					'sort_order' => intval($this->input->post('sort_order')),
					'created' => now(),
					'updated' => now()
				];
				if ($this->catalog_model->create($data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				$this->load->helper('xml');
				sitemapUpdate();
				$this->db->cache_delete_all();
				redirect(admin_url('catalog'));
			}
		}
		$this->data['temp'] = 'admin/catalog/add';
		$this->load->view('admin/main', $this->data);
	}
	function edit()
	{
		$id = intval($this->uri->rsegment('3'));
		$info = $this->catalog_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('catalog'));
		}
		$this->data['info'] = $info;
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_edit(chuyenurl($this->input->post('url', TRUE)), $name, 'catalog_model', $id);
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
					// 'image_thumb' => check_thumb($this->input->post('image_link'), $info->image_link, $info->image_thumb),
					'image_seo' => $this->input->post('image_seo'),
					'sort_order' => intval($this->input->post('sort_order')),
					'updated' => now()
				];
				// pre($data);
				if ($this->catalog_model->update($id, $data)) {
					$where = ['id_type' => $id, 'type' => 'catalog'];
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
					redirect(admin_url('catalog/edit/' . $id));
				} else {
					redirect(admin_url('catalog'));
				}
			}
		}
		$this->data['temp'] = 'admin/catalog/edit';
		$this->load->view('admin/main', $this->data);
	}
	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
		redirect(admin_url('catalog'));
	}
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
		$info = $this->catalog_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('catalog'));
			}
		}
		// kiem tra danh muc có danh muc con hay k;
		if (count($this->catalog_model->menucon_admin($info->id)) > 0) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Danh mục <b>"' . $info->name . '"</b> có danh mục con. Bạn cần xóa danh mục con trước</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Danh mục <b>"' . $info->name . '"</b> có danh mục con. Bạn cần xóa danh mục con trước</div>');
				redirect(admin_url('catalog'));
			}
		}
		// kiem tra danh muc có san pham hay khong
		$product = $this->products_model->get_info_rule(['catalog_id' => $id], 'id');
		if ($product) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Danh mục <b>"' . $info->name . '"</b> có chứa sản phẩm. Bạn cần xóa sản phẩm trước</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Danh mục <b>"' . $info->name . '"</b> có chứa sản phẩm. Bạn cần xóa sản phẩm trước</div>');
				redirect(admin_url('catalog'));
			}
		}
		if ($this->catalog_model->delete($id)) {
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
	}
	function status()
	{
		$id = intval($this->input->post('id'));
		$info = $this->catalog_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('catalog'));
		}
		if ($info->status == 1) {
			$data = ['status' => 0];
			$this->catalog_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->status == 0) {
			$data = ['status' => 1];
			$this->catalog_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
	function home()
	{
		$id = intval($this->input->post('id'));
		$info = $this->catalog_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('catalog'));
		}
		if ($info->home == 1) {
			$data = ['home' => 0];
			$this->catalog_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->home == 0) {
			$data = ['home' => 1];
			$this->catalog_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
}
