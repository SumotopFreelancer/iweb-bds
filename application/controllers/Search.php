<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('frontpagination');
		$this->load->model('catalog_model');
		$this->load->model('products_model');
		// Load setup
		$this->setPage = $this->setup_model->get_setup(['sort_products', 'pagination_catalog']);
	}
	function index()
	{
		$input = [];
		$total = 0;
		if ($this->input->get('txtSearch') || $this->input->get('price_id') || $this->input->get('area_id') || $this->input->get('direction_id') || $this->input->get('district_id') || $this->input->get('ward_id')) {
			if ($this->input->get('txtSearch')) {
				$input['like'] = ['products.name' => $this->input->get('txtSearch')];
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
			$input['select'] = 'products.name, products.url, catalog.url as catUrl, products.image_link as img, products.proStock, products.proNew, district.name as districtName, ward.name as wardName, products.area_ratio, direction.name as directionName, products.bedroom, products.bathroom, products.price, products.address';
			$input['join'] = [
				'catalog' => ['products.catalog_id = catalog.id', 'left'],
				'district' => ['products.district_id = district.id', 'left'],
				'ward' => ['products.ward_id = ward.id', 'left'],
				'direction' => ['products.direction_id = direction.id', 'left']
			];
			$input['where']['products.status'] = 1;
			$input['where']['products.timer <='] = now();
			$input['group_by'] = 'products.id';
			$total = $this->products_model->get_total($input);
			// Pagination
			$config = $this->frontpagination->config($this->products_model->get_total($input), base_url('tim-kiem'), $this->setPage->pagination_catalog, $_GET, base_url('tim-kiem'), 2);
			$this->pagination->initialize($config);
			$segment = intval($this->uri->segment(2)) == 0 ? 0 : ($this->uri->segment(2) * $config['per_page']) - $config['per_page'];
			$this->data['phantrang'] = $this->pagination->create_links();
			$input['order_by'] = [
				check_sort($this->setPage->sort_products, 'products')[0] => check_sort($this->setPage->sort_products, 'products')[1],
				'products.id' => 'desc'
			];
			$input['limit'] = [$config['per_page'], $segment];
			// Data
			$this->data['list'] = $this->products_model->get_list($input);
		}
		$this->data['total'] = $total;
		// SEO =================================================
		$this->data['url'] = base_url('tim-kiem');
		$this->data['title'] = val_seo('', 'Kết quả tìm kiếm: ' . $this->input->get('txtSearch'));
		$this->data['description'] = val_seo('', 'Kết quả tìm kiếm: ' . $this->input->get('txtSearch'));
		$this->data['keywords'] = val_seo('', 'Kết quả tìm kiếm: ' . $this->input->get('txtSearch'));
		// Breadcrumb =========================================
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add('Tìm kiếm', base_url('tim-kiem'));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/search/index';
		$this->load->view('site/layout', $this->data);
	}
}
