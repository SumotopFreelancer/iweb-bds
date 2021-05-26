<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Products extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('catalognew_model');
		$this->load->model('catalog_model');
		$this->load->model('products_model');
		$this->load->model('tagsproduct_model');
		$this->load->model('tagsproductproducts_model');
		$this->load->library('frontpagination');

		// Load setup
		$this->setPage = $this->setup_model->get_setup(['sort_catalog', 'sort_products', 'pagination_catalog', 'limit_catalog']);
	}
	function catalog()
	{
		$slug = $this->uri->rsegment(3);
		$catalog = $this->catalog_model->get_info_rule(['url' => $slug, 'status' => 1]);
		if (!$catalog) {
			redirect();
		}
		$this->data['catalog'] = $catalog;
		// DATA
		if (_catalog_parent_child == 0) {
			$this->_getDataChild($catalog, $this->setPage);
		} else {
			$this->_getDataParentChild($catalog, $this->setPage);
		}
		// SEO
		$this->data['url'] = base_url($catalog->url);
		$this->data['title'] = val_seo($catalog->title, $catalog->name);
		$this->data['description'] = val_seo($catalog->description, $catalog->name);
		$this->data['keywords'] = val_seo($catalog->keyword, $catalog->name);
		$this->data['image_seo'] = val_img_seo($catalog->image_seo, $catalog->image_link);
		// BREADCRUMB
		$this->mybreadcrumb->add('Trang chủ', base_url());
		if ($catalog->parent_id != 0) {
			$parent = $this->catalog_model->get_info($catalog->parent_id);
			$this->mybreadcrumb->add($parent->name, base_url($parent->url));
		}
		$this->mybreadcrumb->add($catalog->name, base_url($catalog->url));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/products/catalog';
		$this->load->view('site/layout', $this->data);
	}
	function view()
	{
		$slug = $this->uri->rsegment(3);
		$slugcatalog = $this->uri->segment(1);
		$product = $this->products_model->get_info_rule(['url' => $slug, 'status' => 1]);
		$catalogurl = $this->catalog_model->get_info($product->catalog_id)->url;
		if (!$product) {
			redirect();
		}
		if ($slugcatalog != $catalogurl) {
			redirect();
		}
		$this->data['product'] = $product;
		if ($this->direction_model->get_info($product->direction_id)) {
			$this->data['directionName'] = $this->direction_model->get_info($product->direction_id)->name;
		}
		$this->data['image_list'] = isJson($product->image_list);
		$catalog = $this->catalog_model->get_info($product->catalog_id);
		$this->data['catalog'] = $catalog;

		// Lấy sản phẩm cùng loại
		$input = [];
		$input['select'] = 'products.name, products.url, catalog.url as catUrl, products.image_link as img, products.proStock, products.proNew, district.name as districtName, ward.name as wardName, products.area_ratio, direction.name as directionName, products.bedroom, products.bathroom, products.price, products.address';
		$input['join'] = [
			'catalog' => ['products.catalog_id = catalog.id', 'left'],
			'district' => ['products.district_id = district.id', 'left'],
			'ward' => ['products.ward_id = ward.id', 'left'],
			'direction' => ['products.direction_id = direction.id', 'left']
		];
		$input['where'] = ['products.status' => 1, 'products.timer <=' => now(), 'products.catalog_id' => $product->catalog_id, 'products.id !=' => $product->id];
		$input['order_by'] = ['products.id' => 'RANDOM'];
		$input['limit'] = [4, 0];
		$this->data['rely'] = $this->products_model->get_list($input);

		// //Tag
		// $this->data['tags'] = $this->tagsproduct_model->get_list_tag_by_product_id($product->id);

		// Seo ======================================================
		$this->data['url'] = base_url($catalog->url . '/' . $product->url);
		$this->data['title'] = val_seo($product->title, $product->name);
		$this->data['description'] = val_seo($product->description, $product->name);
		$this->data['keywords'] = val_seo($product->keyword, $product->name);
		$this->data['image_seo'] = val_img_seo($product->image_seo, $product->image_link);
		// Breadcrumb
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add($catalog->name, base_url($catalog->url));
		$this->mybreadcrumb->add($product->name, base_url($catalog->url . '/' . $product->url));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/products/view';
		$this->load->view('site/layout', $this->data);
	}
	public function tags()
	{
		$url = $this->uri->rsegment(3);
		$where = ['url' => $url];
		$tag = $this->tagsproduct_model->get_info_rule($where);
		if (!$tag) {
			redirect();
		}
		$this->data['tag'] = $tag;
		// List Tag
		$input = [];
		$input['select'] = 'products.name, products.url, products.intro, products.image_link as img';
		$input['join'] = [
			'tagsproduct_products' => ['tagsproduct_products.product_id = products.id']
		];
		$input['where'] = ['products.status' => 1, 'products.timer <=' => now(), 'tagsproduct_products.tag_id' => $tag->id];
		$input['group_by'] = 'products.id';
		$input['order_by'] = [
			check_sort($this->setPage->sort_products, 'products')[0] => check_sort($this->setPage->sort_products, 'products')[1],
			'products.id' => 'desc'
		];
		// Pagination
		$config = $this->frontpagination->config($this->products_model->get_total($input), base_url(_tagsproduct . '/' . $tag->url), $this->setPage->pagination_catalog, $_GET, base_url(_tagsproduct . '/' . $tag->url), 3);
		$this->pagination->initialize($config);
		$segment = intval($this->uri->segment(3)) == 0 ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['list'] = $this->products_model->get_list($input);
		// Seo ====================================
		$this->data['url'] = base_url(_tagsproduct . '/' . $tag->url);
		$this->data['title'] = val_seo($tag->title, $tag->name);
		$this->data['description'] = val_seo($tag->description, $tag->name);
		$this->data['keywords'] = val_seo($tag->keyword, $tag->name);
		$this->data['image_seo'] = val_img_seo($tag->image_seo, $tag->image_link);
		// Breadcrumb
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add('Tags', base_url());
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/products/tags';
		$this->load->view('site/layout', $this->data);
	}
	private function _getDataParentChild($catalog, $setPage)
	{ // Hiển thị 2 layout
		if (count($this->catalog_model->menucon($catalog->id)) > 0) {
			$catalog_subs = $this->catalog_model->get_sub_one($catalog, check_sort($setPage->sort_catalog));
			if ($catalog_subs) {
				$data_parent_child = [];
				foreach ($catalog_subs as $sub_id) {
					$sub = $this->catalog_model->get_info($sub_id);
					$sub_child = $this->catalog_model->get_sub_full($sub, check_sort($setPage->sort_catalog));
					$input = [];
					$input['select'] = 'products.name, products.url, products.image_link as img';
					$input['join'] = [
						'products_catalog' => ['products_catalog.product_id = products.id']
					];
					$input['where'] = ['products.status' => 1, 'products.timer <=' => now()];
					$input['where_in'] = ['products_catalog.catalog_id', $sub_child];
					$input['group_by'] = 'products.id';
					$input['order_by'] = [
						check_sort($setPage->sort_products, 'products')[0] => check_sort($setPage->sort_products, 'products')[1],
						'products.id' => 'desc'
					];
					$input['limit'] = [$setPage->limit_catalog, 0];
					$list_data = $this->products_model->get_list($input);
					if ($list_data) {
						$data_parent_child[$sub_id] = $list_data;
					}
				}
				if ($data_parent_child) {
					$this->data['data_parent_child'] = $data_parent_child;
				}
			}
		} else {
			$this->_getDataChild($catalog, $setPage);
		}
	}
	private function _getDataChild($catalog, $setPage)
	{ // Hiển thị 1 layout
		$input = [];
		$catalog_subs = $this->catalog_model->get_sub_full($catalog, check_sort($setPage->sort_catalog));
		if ($this->input->get('txtSearch') || $this->input->get('price_id') || $this->input->get('area_id') || $this->input->get('direction_id') || $this->input->get('district_id') || $this->input->get('ward_id')) {
			if ($this->input->get('txtSearch')) {
				$input['like'] = ['products.name' => $this->input->get('txtSearch')];
			}
			if ($this->input->get('price_id') && $this->input->get('price_id') > 0) {
				$price = $this->price_model->get_info($this->input->get('price_id'));
				if (!empty($price)) {
					$input['where']['products.price >'] = $price->price_from;
					$input['where']['products.price <='] = $price->price_to;
				}
			}
			if ($this->input->get('area_id') && $this->input->get('area_id') > 0) {
				$area = $this->area_model->get_info($this->input->get('area_id'));
				if (!empty($area)) {
					$input['where']['products.area >'] = $area->area_from;
					if ($area->area_to > 0) {
						$input['where']['products.area <='] = $area->area_to;
					}
				}
			}
			if ($this->input->get('direction_id') && $this->input->get('direction_id') > 0) {
				$input['where']['products.direction_id'] = $this->input->get('direction_id');
			}
			if ($this->input->get('district_id') && $this->input->get('district_id') > 0) {
				$input['where']['products.district_id'] = $this->input->get('district_id');
			}
			if ($this->input->get('ward_id') && $this->input->get('ward_id') > 0) {
				$input['where']['products.ward_id'] = $this->input->get('ward_id');
			}
		}
		$input['select'] = 'products.name, products.url, catalog.url as catUrl, products.image_link as img, products.proStock, products.proNew, district.name as districtName, ward.name as wardName, products.area_ratio, direction.name as directionName, products.bedroom, products.bathroom, products.price, products.address';
		$input['join'] = [
			'products_catalog' => ['products.id = products_catalog.product_id', 'left'],
			'catalog' => ['products.catalog_id = catalog.id', 'left'],
			'catalog' => ['products.catalog_id = catalog.id', 'left'],
			'district' => ['products.district_id = district.id', 'left'],
			'ward' => ['products.ward_id = ward.id', 'left'],
			'direction' => ['products.direction_id = direction.id', 'left']
		];
		$input['where']['products.status'] = 1;
		$input['where']['products.timer <='] = now();
		$input['where_in'] = ['products_catalog.catalog_id', $catalog_subs];
		$input['group_by'] = 'products.id';
		$input['order_by'] = [
			check_sort($setPage->sort_products, 'products')[0] => check_sort($setPage->sort_products, 'products')[1],
			'products.id' => 'desc'
		];
		// Pagination
		$config = $this->frontpagination->config($this->products_model->get_total($input), base_url($catalog->url), $setPage->pagination_catalog, $_GET, base_url($catalog->url), 2);
		$this->pagination->initialize($config);
		$segment = intval($this->uri->segment(2)) == 0 ? 0 : ($this->uri->segment(2) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['data_child'] = $this->products_model->get_list($input);
	}
}
