<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Services extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('services_model');
		$this->load->model('catalogservice_model');
		$this->load->model('servicescatalogservice_model');
		$this->load->model('menu_model');

		// Load danh mục cha
		$input = [];
		$input['where'] = ['parent_id' => 0];
		$input['order_by'] = [check_sort($this->setadmin->sort_catalog_service)[0] => check_sort($this->setadmin->sort_catalog_service)[1]];
		$this->data['catalog'] = $this->catalogservice_model->get_list($input);

		// Load dịch vụ
		$input = [];
		$this->data['services'] = $this->services_model->get_list($input);
	}
	function index()
	{
		// Data
		$input = [];
		if ($this->input->get()) {
			if ($this->input->get('name')) {
				$input['like'] = ['name' => $this->input->get('name', TRUE)];
			}
			if ($this->input->get('catalog_id')) {
				$catalog_id = $this->input->get('catalog_id');
				$catalog = $this->catalogservice_model->get_info($catalog_id);
				if ($catalog) {
					$catalog_subs = $this->catalogservice_model->get_sub_full_admin($catalog, check_sort($this->setadmin->sort_catalog_service));
					if ($catalog_subs) {
						$input['where_in'] = ['catalog_id', $catalog_subs];
					}
				}
			}
		}
		// Pagination
		$config = $this->adminpagination->config($this->services_model->get_total($input), admin_url('services'), 20, $_GET, admin_url('services'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();

		$input['limit'] = [$config['per_page'], $segment];
		$input['order_by'] = [
			check_sort($this->setadmin->sort_services)[0] => check_sort($this->setadmin->sort_services)[1],
			'id' => 'desc'
		];
		$this->data['list'] = $this->services_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/services/index';
		$this->load->view('admin/main', $this->data);
	}
	function add()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('catalog_ids[]', 'Danh mục', 'required');
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_add(chuyenurl($this->input->post('url', TRUE)), $name, 'services_model');
				$catalog_id = main_catalog($this->input->post('catalog_id'), $this->input->post('catalog_ids'));
				$data = [
					'catalog_id' => $catalog_id,
					'name' => $name,
					'url' => $url,
					'intro' => $this->input->post('intro'),
					'content' => $this->input->post('content'),
					'image_link' => $this->input->post('image_link'),
					'image_seo' => $this->input->post('image_seo'),
					'image_list' => merge($this->input->post('gallery'), $this->input->post('altGallery')),
					'title' => $this->input->post('title', TRUE),
					'description' => $this->input->post('description', TRUE),
					'keyword' => $this->input->post('keyword', TRUE),
					'created' => now(),
					'updated' => now(),
					'status' => $this->input->post('status'),
					'home' => $this->input->post('home'),
					'sort_order' => intval($this->input->post('sort_order')),
					'timer' => convert_time_admin($this->input->post('timer'))
				];
				if ($this->services_model->create($data)) {
					$insert_id = $this->db->insert_id();
					// Thêm catalog
					$this->createCatalogid($insert_id, $this->input->post('catalog_ids'));
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				$this->load->helper('xml');
				sitemapUpdate();
				$this->db->cache_delete_all();
				redirect(admin_url('services'));
			}
		}
		$this->data['temp'] = 'admin/services/add';
		$this->load->view('admin/main', $this->data);
	}
	function edit()
	{
		$id = intval($this->uri->rsegment('3'));
		$info = $this->services_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('services'));
		}
		$this->data['info'] = $info;
		$this->data['catalog_ids'] = $this->servicescatalogservice_model->get_list_catalog_by_service_id($id);
		if ($this->input->post()) {
			$this->form_validation->set_rules('catalog_ids[]', 'Danh mục', 'required');
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_edit(chuyenurl($this->input->post('url', TRUE)), $name, 'services_model', $id);
				$catalog_id = main_catalog($this->input->post('catalog_id'), $this->input->post('catalog_ids'));
				$data = [
					'catalog_id' => $catalog_id,
					'name' => $name,
					'url' => $url,
					'intro' => $this->input->post('intro'),
					'content' => $this->input->post('content'),
					'image_link' => $this->input->post('image_link'),
					'image_seo' => $this->input->post('image_seo'),
					'image_list' => merge($this->input->post('gallery'), $this->input->post('altGallery')),
					'title' => $this->input->post('title', TRUE),
					'description' => $this->input->post('description', TRUE),
					'keyword' => $this->input->post('keyword', TRUE),
					'updated' => now(),
					'status' => $this->input->post('status'),
					'home' => $this->input->post('home'),
					'sort_order' => intval($this->input->post('sort_order')),
					'timer' => convert_time_admin($this->input->post('timer'))
				];
				if ($this->services_model->update($id, $data)) {
					// Sửa catalog
					$this->createCatalogid($id, $this->input->post('catalog_ids'), 'edit');
					// Sửa menu
					$this->menu_model->updateMenu($id, 'services', $url);
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
				$this->load->helper('xml');
				sitemapUpdate();
				$this->db->cache_delete_all();
				if ($this->input->post('cus_btn_save') == 'Lưu lại') {
					redirect(admin_url('services/edit/' . $id));
				} else {
					redirect(admin_url('services'));
				}
			}
		}
		$this->data['temp'] = 'admin/services/edit';
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
		redirect(admin_url('services'));
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
		$info = $this->services_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('services'));
			}
		}
		if ($this->services_model->delete($id)) {
			// Xóa catalog_id trong bảng services_catalogservice
			$where = ['service_id' => $id];
			$this->servicescatalogservice_model->del_rule($where);
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
	}
	function status()
	{
		$id = intval($this->input->post('id'));
		$info = $this->services_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('services'));
		}
		if ($info->status == 1) {
			$data = ['status' => 0];
			$this->services_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->status == 0) {
			$data = ['status' => 1];
			$this->services_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
	function home()
	{
		$id = intval($this->input->post('id'));
		$info = $this->services_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('services'));
		}
		if ($info->home == 1) {
			$data = ['home' => 0];
			$this->services_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->home == 0) {
			$data = ['home' => 1];
			$this->services_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
	function createCatalogid($id, $catalog_ids = [], $action = 'add')
	{
		if ($action == 'edit') {
			$where = ['service_id' => $id];
			$this->servicescatalogservice_model->del_rule($where);
		}
		foreach ($catalog_ids as $catalog_id) {
			$data = [
				'service_id' => $id,
				'catalog_id' => $catalog_id,
			];
			$this->servicescatalogservice_model->create($data);
		}
	}
}
