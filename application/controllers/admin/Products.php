<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Products extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('products_model');
		$this->load->model('catalog_model');
		$this->load->model('productscatalog_model');
		$this->load->model('menu_model');
		$this->load->model('tagsproduct_model');
		$this->load->model('tagsproductproducts_model');
		$this->load->model('district_model');
		$this->load->model('ward_model');
		$this->load->model('direction_model');
		$this->load->model('price_model');
		$this->load->model('area_model');

		// Loại dự án
		$input = [];
		$input['where'] = ['parent_id' => 0];
		$input['order_by'] = [check_sort($this->setadmin->sort_catalog)[0] => check_sort($this->setadmin->sort_catalog)[1]];
		$this->data['catalog'] = $this->catalog_model->get_list($input);
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
		$input['order_by'] = [
			'sort_order' => 'asc',
			'id' => 'desc'
		];
		$this->data['directions'] = $this->direction_model->get_list($input);
		// District
		$input = [];
		$input['order_by'] = [
			'sort_order' => 'asc',
			'id' => 'desc'
		];
		$this->data['districts'] = $this->district_model->get_list($input);
	}
	function index()
	{
		$input = [];
		$input['select'] = 'products.id, products.name, products.url, products.image_link as avatar, products.price, products.timer, products.status, products.highlight, products.home, catalog.name as catalogName, catalog.url as catalogUrl';
		$input['join'] = [
			'catalog' => ['catalog.id = products.catalog_id']
		];
		if ($this->input->get()) {
			if ($this->input->get('name') && $this->input->get('name') != '') {
				$input['like'] = ['products.name' => $this->input->get('name', TRUE)];
			}
			if ($this->input->get('catalog_id') && intval($this->input->get('catalog_id')) > 0) {
				$catalog_id = $this->input->get('catalog_id');
				$catalog = $this->catalog_model->get_info($catalog_id);
				if ($catalog) {
					$catalog_subs = $this->catalog_model->get_sub_full_admin($catalog, check_sort($this->setadmin->sort_catalog));
					if ($catalog_subs) {
						$input['where_in'] = ['products.catalog_id', $catalog_subs];
					}
				}
			}
			if ($this->input->get('price_id') && intval($this->input->get('price_id')) > 0) {
				$price = $this->price_model->get_info($this->input->get('price_id'));
				if (!empty($price)) {
					$input['where']['products.price >'] = $price->price_from;
					$input['where']['products.price <='] = $price->price_to;
				}
			}
			if ($this->input->get('area_id') && intval($this->input->get('area_id')) > 0) {
				$area = $this->area_model->get_info($this->input->get('area_id'));
				if (!empty($area)) {
					$input['where']['products.area >'] = $area->area_from;
					if ($area->area_to > 0) {
						$input['where']['products.area <='] = $area->area_to;
					}
				}
			}
			if ($this->input->get('direction_id') && intval($this->input->get('direction_id')) > 0) {
				$input['where']['products.direction_id'] = $this->input->get('direction_id');
			}
			if ($this->input->get('district_id') && intval($this->input->get('district_id')) > 0) {
				$input['where']['products.district_id'] = $this->input->get('district_id');
			}
			if ($this->input->get('ward_id') && intval($this->input->get('ward_id')) > 0) {
				$input['where']['products.ward_id'] = $this->input->get('ward_id');
			}
		}
		// Pagination
		$config = $this->adminpagination->config($this->products_model->get_total($input), admin_url('products'), 20, $_GET, admin_url('products'), 3);
		$this->pagination->initialize($config);
		$segment = intval($this->uri->segment(3)) == 0 ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		$input['limit'] = [$config['per_page'], $segment];
		$input['order_by'] = [
			check_sort($this->setadmin->sort_products, 'products')[0] => check_sort($this->setadmin->sort_products, 'products')[1],
			'products.id' => 'desc'
		];
		$this->data['list'] = $this->products_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/products/index';
		$this->load->view('admin/main', $this->data);
	}
	function ajax_get_ward()
	{
		$result = [
			'status' => -1,
			'message' => 'Truy cập không cho phép'
		];
		if ($this->input->post()) {
			$district_id = $this->input->post('district_id');
			$ward_id = $this->input->post('ward_id');
			$input = [];
			$input['where'] = ['district_id' => $district_id];
			$input['order_by'] = ['sort_order' => 'asc'];
			$wards = $this->ward_model->get_list($input);
			$html = '<option value="">Chọn phường</option>';
			if (!empty($wards)) {
				foreach ($wards as $row) {
					$selected = !empty($ward_id) && $ward_id == $row->id ? ' selected' : '';
					$html .= '<option' . $selected . ' value="' . $row->id . '">' . $row->name . '</option>';
				}
				$result = [
					'status' => 1,
					'html' => $html
				];
			} else {
				$result = [
					'status' => 0,
					'html' => $html,
					'message' => 'Không tìm thấy dữ liệu'
				];
			}
		}
		echo json_encode($result);
	}
	function ajax_add()
	{
		$result = [
			'status' => -1,
			'message' => 'Truy cập không cho phép'
		];
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			$this->form_validation->set_rules('district_id', 'Quận', 'required');
			$this->form_validation->set_rules('ward_id', 'Phường', 'required');
			$this->form_validation->set_rules('address', 'Địa chỉ', 'required');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'required');
			$this->form_validation->set_rules('catalog_ids[]', 'Loại dự án', 'required');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_add(chuyenurl($this->input->post('url', TRUE)), $name, 'products_model');
				$catalog_id = main_catalog($this->input->post('catalog_id'), $this->input->post('catalog_ids'));
				$data = [
					'name' => $name,
					'url' => $url,
					'district_id' => $this->input->post('district_id', TRUE),
					'ward_id' => $this->input->post('ward_id', TRUE),
					'address' => $this->input->post('address', TRUE),
					'phone' => $this->input->post('phone', TRUE),
					'price' => $this->input->post('price', TRUE),
					'direction_id' => $this->input->post('direction_id', TRUE),
					'area' => $this->input->post('area', TRUE),
					'bedroom' => $this->input->post('bedroom', TRUE),
					'bathroom' => $this->input->post('bathroom', TRUE),
					'area_ratio' => $this->input->post('area_ratio', TRUE),
					'highlight' => $this->input->post('highlight', TRUE),
					'proNew' => $this->input->post('proNew', TRUE),
					'proStock' => $this->input->post('proStock', TRUE),
					'priceType' => $this->input->post('priceType', TRUE),
					'content' => $this->input->post('content'),
					'title' => $this->input->post('title', TRUE),
					'description' => $this->input->post('description', TRUE),
					'keyword' => $this->input->post('keyword', TRUE),
					'image_link' => $this->input->post('image_link', TRUE),
					'image_seo' => $this->input->post('image_seo'),
					'image_list' => merge($this->input->post('gallery'), $this->input->post('galleryAlt')),
					'created' => now(),
					'updated' => now(),
					'timer' => convert_time_admin($this->input->post('timer')),
					'catalog_id' => $catalog_id,
					'status' => $this->input->post('status'),
					'home' => $this->input->post('home'),
					'sort_order' => $this->input->post('sort_order')
				];
				// Check tag
				$this->checkTag($this->input->post('listtagpost'));
				if ($this->products_model->create($data)) {
					$insert_id = $this->db->insert_id();
					// Thêm catalog
					$this->createCatalogid($insert_id, $this->input->post('catalog_ids'));
					// Thêm tags
					$this->createTag($insert_id, $this->input->post('listtagpost'));
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
					// SiteMap
					$this->load->helper('xml');
					sitemapUpdate();
					// Result
					$result = [
						'status' => 1,
						'redirect' => admin_url('products')
					];
				} else {
					// Result
					$result = [
						'status' => 2,
						'message' => '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>'
					];
				}
			} else {
				$result = [
					'status' => 0,
					'errors' => $this->form_validation->error_array()
				];
			}
		}
		echo json_encode($result);
	}
	function add()
	{
		$this->data['temp'] = 'admin/products/add';
		$this->load->view('admin/main', $this->data);
	}
	function ajax_edit()
	{
		$result = [
			'status' => -1,
			'message' => 'Truy cập không cho phép'
		];
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required');
			$this->form_validation->set_rules('district_id', 'Quận', 'required');
			$this->form_validation->set_rules('ward_id', 'Phường', 'required');
			$this->form_validation->set_rules('address', 'Địa chỉ', 'required');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'required');
			$this->form_validation->set_rules('catalog_ids[]', 'Loại dự án', 'required');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_edit(chuyenurl($this->input->post('url', TRUE)), $name, 'products_model', $this->input->post('id'));
				$catalog_id = main_catalog($this->input->post('catalog_id'), $this->input->post('catalog_ids'));
				$data = [
					'name' => $name,
					'url' => $url,
					'district_id' => $this->input->post('district_id', TRUE),
					'ward_id' => $this->input->post('ward_id', TRUE),
					'address' => $this->input->post('address', TRUE),
					'phone' => $this->input->post('phone', TRUE),
					'price' => $this->input->post('price', TRUE),
					'direction_id' => $this->input->post('direction_id', TRUE),
					'area' => $this->input->post('area', TRUE),
					'bedroom' => $this->input->post('bedroom', TRUE),
					'bathroom' => $this->input->post('bathroom', TRUE),
					'area_ratio' => $this->input->post('area_ratio', TRUE),
					'highlight' => $this->input->post('highlight', TRUE),
					'proNew' => $this->input->post('proNew', TRUE),
					'proStock' => $this->input->post('proStock', TRUE),
					'priceType' => $this->input->post('priceType', TRUE),
					'content' => $this->input->post('content'),
					'title' => $this->input->post('title', TRUE),
					'description' => $this->input->post('description', TRUE),
					'keyword' => $this->input->post('keyword', TRUE),
					'image_link' => $this->input->post('image_link', TRUE),
					'image_seo' => $this->input->post('image_seo'),
					'image_list' => merge($this->input->post('gallery'), $this->input->post('galleryAlt')),
					'updated' => now(),
					'timer' => convert_time_admin($this->input->post('timer')),
					'catalog_id' => $catalog_id,
					'status' => $this->input->post('status'),
					'home' => $this->input->post('home'),
					'sort_order' => $this->input->post('sort_order')
				];
				// Check tag
				$this->checkTag($this->input->post('listtagpost'));
				if ($this->products_model->update($this->input->post('id'), $data)) {
					// Sửa catalog
					$this->createCatalogid($this->input->post('id'), $this->input->post('catalog_ids'), 'edit');
					// Sửa tag
					$this->createTag($this->input->post('id'), $this->input->post('listtagpost'), 'edit');
					// Sửa menu
					$this->menu_model->updateMenu($this->input->post('id'), 'products', $url);
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
					// SiteMap
					$this->load->helper('xml');
					sitemapUpdate();
					// Result
					$result = [
						'status' => 1,
						'redirect' => admin_url('products'),
						'reload' => admin_url('products/edit/' . $this->input->post('id'))
					];
				} else {
					// Result
					$result = [
						'status' => 2,
						'message' => '<div class="callout callout-danger">Không chỉnh sửa được. Thử lại sau</div>'
					];
				}
			} else {
				$result = [
					'status' => 0,
					'errors' => $this->form_validation->error_array()
				];
			}
		}
		echo json_encode($result);
	}
	function edit()
	{
		$id = intval($this->uri->rsegment('3'));
		$info = $this->products_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('products'));
		}
		$this->data['info'] = $info;
		$this->data['catalog_ids'] = $this->productscatalog_model->get_list_catalog_by_product_id($id);
		$this->data['listtags'] = $this->tagsproduct_model->get_list_tag_by_product_id($id);
		$input = [];
		$input['where'] = ['district_id' => $info->district_id];
		$input['order_by'] = ['sort_order' => 'asc'];
		$this->data['wards'] = $this->ward_model->get_list($input);
		// View
		$this->data['temp'] = 'admin/products/edit';
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
		redirect(admin_url('products'));
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
		$info = $this->products_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('products'));
			}
		}
		if ($this->products_model->delete($id)) {
			// Xóa product_id trong bảng products_catalog
			$this->productscatalog_model->del_rule(['product_id' => $id]);
			// Xóa product_id trong bảng tagsproduct
			$this->tagsproductproducts_model->del_rule(['product_id' => $id]);
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
	}
	function status()
	{
		$id = intval($this->input->post('id'));
		$info = $this->products_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('products'));
		}
		if ($info->status == 1) {
			$data = ['status' => 0];
			$this->products_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->status == 0) {
			$data = ['status' => 1];
			$this->products_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
	function home()
	{
		$id = intval($this->input->post('id'));
		$info = $this->products_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('products'));
		}
		if ($info->home == 1) {
			$data = ['home' => 0];
			$this->products_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->home == 0) {
			$data = ['home' => 1];
			$this->products_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
	function highlight()
	{
		$id = intval($this->input->post('id'));
		$info = $this->products_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('products'));
		}
		if ($info->highlight == 1) {
			$data = ['highlight' => 0];
			$this->products_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->highlight == 0) {
			$data = ['highlight' => 1];
			$this->products_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
	public function autocomplete()
	{
		$search_data = $this->input->post('search_data', TRUE);
		$input = [];
		$input['like'] = ['name' => $search_data];
		$input['order_by'] = ['sort_order' => 'desc'];
		$ketqua = $this->tagsproduct_model->get_list($input);
		$html = '';
		if (!empty($ketqua)) {
			$html .= "<ul>";
			foreach ($ketqua as $row) {
				$html .= '<li onclick="addtag(this)" class="litag">' . $row->name . '</li>';
			}
			$html .= "</ul>";
		}
		echo $html;
	}
	function checkTag($stringTag = '')
	{
		if (!empty($stringTag)) {
			$tags = explode(',', $stringTag);
			foreach ($tags as $row) {
				if (!$this->tagsproduct_model->check_name_tags($row)) { // Nếu tên tags này chưa có
					$url = chuyenurl($row);
					$where = ['url' => $url];
					if ($this->tagsproduct_model->check_exists($where)) { // Nếu như url này đã tồn tại
						$input = [];
						$input['where'] = ['name' => mb_strtolower($row)];
						$num = $this->tagsproduct_model->get_total($input);
						$url = $url . '-' . $num;
					}
					$data = [
						'name' => mb_strtolower($row),
						'url' => $url,
						'created' => now(),
					];
					$this->tagsproduct_model->create($data);
				}
			}
		}
	}
	function createTag($id, $stringTag = '', $action = 'add')
	{
		if ($action == 'edit') {
			$where = ['product_id' => $id];
			$this->tagsproductproducts_model->del_rule($where);
		}
		if (!empty($stringTag)) {
			$tags = explode(',', $stringTag);
			foreach ($tags as $row) {
				$tag_id = $this->tagsproduct_model->get_info_tags($row)->id;
				$input = [];
				$input['where'] = ['product_id' => $id, 'tag_id' => $tag_id];
				if ($this->tagsproductproducts_model->get_total_tags($input) <= 0) {
					$data = [
						'product_id' => $id,
						'tag_id' => $tag_id,
					];
					$this->tagsproductproducts_model->create($data);
				}
			}
		}
	}
	function createCatalogid($id, $catalog_ids = [], $action = 'add')
	{
		if ($action == 'edit') {
			$where = ['product_id' => $id];
			$this->productscatalog_model->del_rule($where);
		}
		foreach ($catalog_ids as $catalog_id) {
			$data = [
				'product_id' => $id,
				'catalog_id' => $catalog_id,
			];
			$this->productscatalog_model->create($data);
		}
	}
}
