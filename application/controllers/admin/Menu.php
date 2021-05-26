<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends My_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('menu_model');
		$this->load->model('pages_model');
		$this->load->model('catalognew_model');
		$this->load->model('news_model');
		$this->load->model('catalog_model');
		$this->load->model('products_model');
		$this->load->model('catalogservice_model');
		$this->load->model('services_model');

		//Load Trang
		$this->pages = $this->pages_model->get_list();
		$this->data['pages'] = $this->pages;

		//Load danh mục bài viết
		$input = [];
		$input['where'] = ['parent_id' => 0];
		$input['order_by'] = [check_sort($this->setadmin->sort_catalog_new)[0] => check_sort($this->setadmin->sort_catalog_new)[1]];
		$this->catalognew = $this->catalognew_model->get_list($input);
		$this->data['catalognew'] = $this->catalognew;
		//Load bài viết
		$input = [];
		$input['order_by'] = [check_sort($this->setadmin->sort_news)[0] => check_sort($this->setadmin->sort_news)[1]];
		$this->news = $this->news_model->get_list();
		$this->data['news'] = $this->news;

		//Load danh mục sản phẩm
		$input = [];
		$input['where'] = ['parent_id' => 0];
		$input['order_by'] = [check_sort($this->setadmin->sort_catalog)[0] => check_sort($this->setadmin->sort_catalog)[1]];
		$this->catalog = $this->catalog_model->get_list($input);
		$this->data['catalog'] = $this->catalog;
		//Load sản phẩm
		$input = [];
		$input['order_by'] = [check_sort($this->setadmin->sort_products)[0] => check_sort($this->setadmin->sort_products)[1]];
		$this->products = $this->products_model->get_list();
		$this->data['products'] = $this->products;

		//Load danh mục dịch vụ
		$input = [];
		$input['where'] = ['parent_id' => 0];
		$input['order_by'] = [check_sort($this->setadmin->sort_catalog_service)[0] => check_sort($this->setadmin->sort_catalog_service)[1]];
		$this->catalogservice = $this->catalogservice_model->get_list($input);
		$this->data['catalogservice'] = $this->catalogservice;
		//Load dịch vụ
		$input = [];
		$input['order_by'] = [check_sort($this->setadmin->sort_services)[0] => check_sort($this->setadmin->sort_services)[1]];
		$this->services = $this->services_model->get_list();
		$this->data['services'] = $this->services;

		// Menu
		$this->data['menu'] = $this->menu_model->get_menu_admin();
	}

	function index()
	{
		// Load view
		$this->data['temp'] = 'admin/menu/index';
		$this->load->view('admin/main', $this->data);
	}
	function validationadd()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run() == FALSE) {
				$errors = $this->form_validation->error_array();
				echo json_encode($errors);
			} else {
				echo 1;
			}
		}
	}
	function add()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$data = [
					'name' => $this->input->post('name', TRUE),
					'url' => $this->input->post('url', TRUE),
					'type' => $this->input->post('type'),
					'id_type' => intval($this->input->post('id_type')),
					'parent_id' => intval($this->input->post('parent_id')),
					'sort_order' => intval($this->input->post('sort_order')),
					'status' => $this->input->post('status'),
					'created' => now()
				];
				if ($this->menu_model->create($data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				redirect(admin_url('menu'));
			}
		}
		$this->data['temp'] = 'admin/menu/add';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}

	function edit()
	{
		if ($this->input->post()) {
			$id = $this->input->post('id');
			$info = $this->menu_model->get_info($id);
			if (!$info) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
			} else {
				$data = [
					'name' => $this->input->post('name', TRUE),
					'parent_id' => $this->input->post('parent_id'),
					'status' => $this->input->post('status'),
					'sort_order' => intval($this->input->post('sort_order'))
				];
				if ($this->input->post('url')) {
					$data['url'] = $this->input->post('url');
				}
				if ($this->menu_model->update($id, $data)) {
					echo '<div class="callout callout-success">Chỉnh sửa thành công</div>';
				} else {
					echo '<div class="callout callout-danger">Không chỉnh sửa được. Thử lại sau</div>';
				}
			}
		}
		$this->db->cache_delete_all();
	}

	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		redirect(admin_url('menu'));
		$this->db->cache_delete_all();
	}

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
		$info = $this->menu_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('menu'));
			}
		}
		// kiem tra menu có menu con hay khong;
		if (count($this->menu_model->menucon_admin($info->id)) > 0) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Menu <b>"' . $info->name . '"</b> có menu con. Bạn cần xóa menu con trước</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Menu <b>"' . $info->name . '"</b> có menu con. Bạn cần xóa menu con trước</div>');
				redirect(admin_url('menu'));
			}
		}
		if ($this->menu_model->delete($id)) {
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
		$this->db->cache_delete_all();
	}

	function status()
	{
		$id = intval($this->input->post('id'));
		$info = $this->menu_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('menu'));
		}
		if ($info->status == 1) {
			$data = ['status' => 0];
			$this->menu_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->status == 0) {
			$data = ['status' => 1];
			$this->menu_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->db->cache_delete_all();
	}

	function load_type_menu()
	{
		$type = $this->input->post('type');
		if ($type == 'outlink') {
			$type_hidden = '<input type="url" name="url" class="form-control" placeholder="http://"><input type="hidden" name="type" value="outlink" >';
			$response = [
				'type_hide' => $type_hidden,
				'label' => 'Liên kết',
				'loai' => 'outlink'
			];
			echo json_encode($response);
		}
		if ($type == 'pages') {
			$html = '';
			foreach ($this->pages as $row) {
				$html .= '<option data-url="' . $row->url . '" value="' . $row->id . '">' . $row->name . '</option>';
			}
			$type_hidden = '<input id="data_url" type="hidden" name="url"><input type="hidden" name="type" value="pages">';
			$response = [
				'html' => $html,
				'type_hide' => $type_hidden,
				'label' => 'Chọn trang',
				'loai' => 'inlink'
			];
			echo json_encode($response);
		}
		if ($type == 'news') {
			$html = '';
			foreach ($this->news as $row) {
				$html .= '<option data-url="' . $row->url . '" value="' . $row->id . '">' . $row->name . '</option>';
			}
			$type_hidden = '<input id="data_url" type="hidden" name="url"><input type="hidden" name="type" value="news">';
			$response = [
				'html' => $html,
				'type_hide' => $type_hidden,
				'label' => 'Chọn bài viết',
				'loai' => 'inlink'
			];
			echo json_encode($response);
		}
		if ($type == 'services') {
			$html = '';
			foreach ($this->services as $row) {
				$html .= '<option data-url="' . $row->url . '" value="' . $row->id . '">' . $row->name . '</option>';
			}
			$type_hidden = '<input id="data_url" type="hidden" name="url"><input type="hidden" name="type" value="services">';
			$response = [
				'html' => $html,
				'type_hide' => $type_hidden,
				'label' => 'Chọn dịch vụ',
				'loai' => 'inlink'
			];
			echo json_encode($response);
		}
		if ($type == 'products') {
			$html = '';
			foreach ($this->products as $row) {
				$html .= '<option data-url="' . $row->url . '" value="' . $row->id . '">' . $row->name . '</option>';
			}
			$type_hidden = '<input id="data_url" type="hidden" name="url"><input type="hidden" name="type" value="products">';
			$response = [
				'html' => $html,
				'type_hide' => $type_hidden,
				'label' => 'Chọn dự án',
				'loai' => 'inlink'
			];
			echo json_encode($response);
		}
		if ($type == 'catalognew') {
			$html = '';
			foreach ($this->catalognew as $row) {
				$html .= '<option data-url="' . $row->url . '" value="' . $row->id . '">' . $row->name . '</option>';
				if (count($this->catalognew_model->menucon_admin($row->id)) > 0) {
					foreach ($this->catalognew_model->menucon_admin($row->id, check_sort($this->setadmin->sort_catalog_new)) as $cap2) {
						$html .= '<option data-url="' . $cap2->url . '" value="' . $cap2->id . '">--|' . $cap2->name . '</option>';
						if (count($this->catalognew_model->menucon_admin($cap2->id)) > 0) {
							foreach ($this->catalognew_model->menucon_admin($cap2->id, check_sort($this->setadmin->sort_catalog_new)) as $cap3) {
								$html .= '<option data-url="' . $cap3->url . '" value="' . $cap3->id . '">--|--|' . $cap3->name . '</option>';
								if (count($this->catalognew_model->menucon_admin($cap3->id)) > 0) {
									foreach ($this->catalognew_model->menucon_admin($cap3->id, check_sort($this->setadmin->sort_catalog_new)) as $cap4) {
										$html .= '<option data-url="' . $cap4->url . '" value="' . $cap4->id . '">--|--|--|' . $cap4->name . '</option>';
									}
								}
							}
						}
					}
				}
			}
			$type_hidden = '<input id="data_url" type="hidden" name="url"><input type="hidden" name="type" value="catalognew">';
			$response = [
				'html' => $html,
				'type_hide' => $type_hidden,
				'label' => 'Chọn danh mục bài viết',
				'loai' => 'inlink'
			];
			echo json_encode($response);
		}
		if ($type == 'catalogservice') {
			$html = '';
			foreach ($this->catalogservice as $row) {
				$html .= '<option data-url="' . $row->url . '" value="' . $row->id . '">' . $row->name . '</option>';
				if (count($this->catalogservice_model->menucon_admin($row->id)) > 0) {
					foreach ($this->catalogservice_model->menucon_admin($row->id, check_sort($this->setadmin->sort_catalog_service)) as $cap2) {
						$html .= '<option data-url="' . $cap2->url . '" value="' . $cap2->id . '">--|' . $cap2->name . '</option>';
						if (count($this->catalogservice_model->menucon_admin($cap2->id)) > 0) {
							foreach ($this->catalogservice_model->menucon_admin($cap2->id, check_sort($this->setadmin->sort_catalog_service)) as $cap3) {
								$html .= '<option data-url="' . $cap3->url . '" value="' . $cap3->id . '">--|--|' . $cap3->name . '</option>';
								if (count($this->catalogservice_model->menucon_admin($cap3->id)) > 0) {
									foreach ($this->catalogservice_model->menucon_admin($cap3->id, check_sort($this->setadmin->sort_catalog_service)) as $cap4) {
										$html .= '<option data-url="' . $cap4->url . '" value="' . $cap4->id . '">--|--|--|' . $cap4->name . '</option>';
									}
								}
							}
						}
					}
				}
			}
			$type_hidden = '<input id="data_url" type="hidden" name="url"><input type="hidden" name="type" value="catalogservice">';
			$response = [
				'html' => $html,
				'type_hide' => $type_hidden,
				'label' => 'Chọn danh mục dịch vụ',
				'loai' => 'inlink'
			];
			echo json_encode($response);
		}
		if ($type == 'catalog') {
			$html = '';
			foreach ($this->catalog as $row) {
				$html .= '<option data-url="' . $row->url . '" value="' . $row->id . '">' . $row->name . '</option>';
				if (count($this->catalog_model->menucon_admin($row->id)) > 0) {
					foreach ($this->catalog_model->menucon_admin($row->id, check_sort($this->setadmin->sort_catalog)) as $cap2) {
						$html .= '<option data-url="' . $cap2->url . '" value="' . $cap2->id . '">--|' . $cap2->name . '</option>';
						if (count($this->catalog_model->menucon_admin($cap2->id)) > 0) {
							foreach ($this->catalog_model->menucon_admin($cap2->id, check_sort($this->setadmin->sort_catalog)) as $cap3) {
								$html .= '<option data-url="' . $cap3->url . '" value="' . $cap3->id . '">--|--|' . $cap3->name . '</option>';
								if (count($this->catalog_model->menucon_admin($cap3->id)) > 0) {
									foreach ($this->catalog_model->menucon_admin($cap3->id, check_sort($this->setadmin->sort_catalog)) as $cap4) {
										$html .= '<option data-url="' . $cap4->url . '" value="' . $cap4->id . '">--|--|--|' . $cap4->name . '</option>';
									}
								}
							}
						}
					}
				}
			}
			$type_hidden = '<input id="data_url" type="hidden" name="url"><input type="hidden" name="type" value="catalog">';
			$response = [
				'html' => $html,
				'type_hide' => $type_hidden,
				'label' => 'Chọn loại dự án',
				'loai' => 'inlink'
			];
			echo json_encode($response);
		}
	}
}
