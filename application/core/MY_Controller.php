<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
	public $data = []; // Biến $data gửi sang view
	function __construct()
	{
		parent::__construct();
		$controller = $this->uri->segment(1);
		switch ($controller) {
			case 'admin': {
					$this->load->library('adminpagination');
					$this->load->model('setup_model');
					$this->load->library('form_validation');
					$this->load->helper('form');
					$this->load->helper('admin');
					$this->form_validation->set_error_delimiters('', '');
					$this->data['message'] = $this->session->flashdata('message');

					$setadmin = $this->setup_model->get_setup();
					if ($setadmin) {
						$this->setadmin = $setadmin;
						$this->data['setadmin'] = $setadmin;
					}

					//xu ly trang admin
					$this->_check_login();
					$admin_root = $this->config->item('admin_root');
					$this->data['admin_root'] = $admin_root;
					$this->admin_root = $admin_root;
					if ($this->session->has_userdata('admin') && $this->session->userdata('admin')) {
						$this->userinfo = $this->session->userdata('admin');
						$this->data['userinfo'] = $this->userinfo;
						$quyen_admin = json_decode($this->userinfo->quyen);
						$this->data['quyen_admin'] = $quyen_admin;
					}
					break;
				}
			default: {
					// 100MB xóa cache
					$link = './application/cache/cachedata';
					if (folderSize($link) >= 107374182) {
						remove_directory($link, TRUE);
					}
					// Library
					// $this->load->library('cart');
					$this->load->library('mybreadcrumb');
					// $this->load->library('visit');
					// $this->visit->add(); // Thêm visit vào database
					// $this->visit->update_delete(); // Update và xóa khi vượt quá 1000
					// $this->visit->total();
					// $this->visit->today();
					// $this->visit->yesterday();
					// $this->visit->week();
					// $this->visit->month();
					// $this->visit->online();

					// Model
					$this->load->model('setup_model');
					$this->load->model('menu_model');
					$this->load->model('ward_model');
					$this->load->model('products_model');
					$this->load->model('catalog_model');
					$this->load->model('price_model');
					$this->load->model('area_model');
					$this->load->model('direction_model');
					$this->load->model('district_model');
					// Setting
					$this->data['setAll'] = $this->setup_model->get_setup(['logo', 'favico', 'script_head', 'script_body', 'script_footer', 'footer1', 'footer2', 'footer3', 'copyright', 'social', 'check_css', 'sidebarReg', 'sidebarProduct', 'sidebarBank', 'sidebarNew', 'phone', 'bannerHeader', 'slogan', 'email', 'sort_catalog']);
					// // Load total cart, content cart
					// $this->data['total_items'] = $this->cart->total_items();
					// $this->data['cart_ajax'] = $this->cart->contents();
					// Load Menu default
					$this->data['menuDefault'] = $this->menu_model->get_menu();

					// SEARCH
					// Catalog
					$input = [];
					$input['select'] = 'id, name, url';
					$input['order_by'] = [
						check_sort($this->data['setAll']->sort_catalog)[0] => check_sort($this->data['setAll']->sort_catalog)[1]
					];
					$this->data['cateSearch'] = $this->catalog_model->get_list($input);
					// Price
					$input = [];
					$input['select'] = 'id, price_from, price_to';
					$input['order_by'] = [
						'sort_order' => 'asc'
					];
					$this->data['priceSearch'] = $this->price_model->get_list($input);
					// Ares
					$input = [];
					$input['select'] = 'id, area_from, area_to';
					$input['order_by'] = [
						'sort_order' => 'asc'
					];
					$this->data['areaSearch'] = $this->area_model->get_list($input);
					// Direction
					$input = [];
					$input['select'] = 'id, name';
					$input['order_by'] = [
						'sort_order' => 'asc'
					];
					$this->data['directionSearch'] = $this->direction_model->get_list($input);
					// District
					$input = [];
					$input['select'] = 'id, name';
					$input['order_by'] = [
						'sort_order' => 'asc'
					];
					$this->data['districtSearch'] = $this->district_model->get_list($input);

					// Sidebar
					// Form
					$this->sidebarReg = isJson($this->data['setAll']->sidebarReg);
					$this->data['sidebarReg'] = $this->sidebarReg;
					// Ward
					$input = [];
					$input['select'] = 'ward.id, ward.name, district.id as districtId';
					$input['join'] = [
						'district' => ['ward.district_id = district.id', 'left']
					];
					$input['where'] = ['ward.sidebar' => 1];
					$input['order_by'] = [
						'ward.sort_order' => 'asc'
					];
					$ward = $this->ward_model->get_list($input);
					if (!empty($ward)) {
						$sidebarProducts = [];
						foreach ($ward as $key => $row) {
							$input = [];
							$input['where'] = ['ward_id' => $row->id];
							$total = $this->products_model->get_total($input);
							$sidebarProducts[$key]['id'] = $row->id;
							$sidebarProducts[$key]['districtId'] = $row->districtId;
							$sidebarProducts[$key]['name'] = $row->name;
							$sidebarProducts[$key]['total'] = $total;
						}
						if (!empty($sidebarProducts)) {
							$this->data['sidebarProducts'] = $sidebarProducts;
							$this->data['sidebarProduct'] = isJson($this->data['setAll']->sidebarProduct);
						}
					}

					// Bank
					$this->data['sidebarBank'] = isJson($this->data['setAll']->sidebarBank);
					// News
					$this->data['sidebarNews'] = sidebarNew();
					$this->data['sidebarNew'] = isJson($this->data['setAll']->sidebarNew);
				}
		}
	}

	/* Kiểm tra trạng thái đăng nhập của admin*/
	private function _check_login()
	{
		// lấy controller và action trên url và cho về chữ không in hoa
		$controller = strtolower($this->uri->rsegment(1));
		$action = strtolower($this->uri->rsegment(2));

		$admin_custom = $this->session->userdata('admin');
		$admin_root = $this->config->item('admin_root');
		// nếu chua có session admin và truy vào url cấp 1 controller khác login
		if (!$admin_custom && $controller != 'login') {
			redirect(admin_url('login'));
		}
		if ($admin_custom && $controller == 'login') {
			redirect(admin_url('home'));
		} elseif (!in_array($controller, ['login', 'home'])) {
			if ($admin_custom->type != $admin_root->type) {
				// kiem tra quyen
				$quyen_admin = json_decode($admin_custom->quyen);
				$check = true;
				if (!isset($quyen_admin->{$controller})) {
					$check = false;
				}
				$quyen_action = $quyen_admin->{$controller};
				if (!in_array($action, $quyen_action)) {
					$check = false;
				}
				if ($check == false) {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Bạn không đủ quyền hạn cho phép!</div>');
					redirect(admin_url('home'));
				}
			}
		}
	}
}
