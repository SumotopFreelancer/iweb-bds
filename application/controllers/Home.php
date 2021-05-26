<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('catalog_model');
		$this->load->model('products_model');
		// Load setup
		$this->setPage = $this->setup_model->get_setup(['seo', 'homeProduct', 'sort_products', 'sort_catalog']);
	}

	function index()
	{
		// Home Product
		$input = [];
		$input['select'] = 'products.name, products.url, products.image_link as img, products.proNew, products.proStock, catalog.url as catUrl';
		$input['join'] = [
			'catalog' => ['catalog.id = products.catalog_id']
		];
		$input['where'] = ['products.status' => 1, 'products.highlight' => 1, 'products.timer <=' => now()];
		$input['order_by'] = [
			check_sort($this->setPage->sort_products, 'products')[0] => check_sort($this->setPage->sort_products, 'products')[1],
			'products.id' => 'desc'
		];
		$input['limit'] = [10, 0];
		$this->data['homeProducts'] = $this->products_model->get_list($input);
		$this->data['homeProduct'] = $this->setPage->homeProduct;
		// Home Product By Catalog
		$input = [];
		$input['select'] = 'id, name, url, parent_id';
		$input['where'] = ['status' => 1, 'home' => 1];
		$input['order_by'] = [
			check_sort($this->setPage->sort_catalog)[0] => check_sort($this->setPage->sort_catalog)[1],
			'id' => 'desc'
		];
		$listCatalog = $this->catalog_model->get_list($input);
		if (!empty($listCatalog)) {
			$homeProductByCatalog = [];
			foreach ($listCatalog as $key => $row) {
				if ($this->_getDataChild($row, $this->setPage)) {
					$homeProductByCatalog[$key]['name'] = $row->name;
					$homeProductByCatalog[$key]['url'] = $row->url;
					$homeProductByCatalog[$key]['products'] = $this->_getDataChild($row, $this->setPage);
				}
			}
			$this->data['homeProductByCatalog'] = $homeProductByCatalog;
		}
		// SEO =================================================
		$this->data['url'] = base_url();
		$this->data['title'] = val_seo(isJson($this->setPage->seo)->title, 'Trang chủ');
		$this->data['description'] = val_seo(isJson($this->setPage->seo)->description, 'Trang chủ');
		$this->data['keywords'] = val_seo(isJson($this->setPage->seo)->keyword, 'Trang chủ');
		$this->data['image_seo'] = val_img_seo(isJson($this->setPage->seo)->image_link, '');
		// VIEW
		$this->data['temp'] = 'site/home/index';
		$this->load->view('site/layout', $this->data);
	}
	private function _getDataChild($catalog, $setPage)
	{
		$input = [];
		$catalog_subs = $this->catalog_model->get_sub_full($catalog, check_sort($setPage->sort_catalog));
		$input['select'] = 'products.name, products.url, catalog.url as catUrl, products.image_link as img, products.proStock, products.proNew, district.name as districtName, ward.name as wardName, products.area_ratio, direction.name as directionName, products.bedroom, products.bathroom, products.price';
		$input['join'] = [
			'products_catalog' => ['products.id = products_catalog.product_id', 'left'],
			'catalog' => ['products.catalog_id = catalog.id', 'left'],
			'district' => ['products.district_id = district.id', 'left'],
			'ward' => ['products.ward_id = ward.id', 'left'],
			'direction' => ['products.direction_id = direction.id', 'left']
		];
		$input['where'] = ['products.status' => 1, 'products.home' => 1, 'products.timer <=' => now()];
		$input['where_in'] = ['products_catalog.catalog_id', $catalog_subs];
		$input['group_by'] = 'products.id';
		$input['order_by'] = [
			check_sort($this->setPage->sort_products, 'products')[0] => check_sort($this->setPage->sort_products, 'products')[1],
			'products.id' => 'desc'
		];
		$input['limit'] = [10, 0];
		return $this->products_model->get_list($input);
	}
}
