<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Services extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('catalogservice_model');
		$this->load->model('services_model');
		$this->load->library('frontpagination');

		// Load setup
		$this->setPage = $this->setup_model->get_setup(['sort_catalog_service', 'sort_services', 'pagination_catalog_service', 'limit_catalog_service']);
	}
	function catalog()
	{
		$slug = $this->uri->rsegment(3);
		$catalog = $this->catalogservice_model->get_info_rule(['url' => $slug, 'status' => 1]);
		if (!$catalog) {
			redirect();
		}
		$this->data['catalog'] = $catalog;
		// DATA
		if (_catalogservice_parent_child == 0) {
			$this->_getDataChild($catalog, $this->setPage);
		} else {
			$this->_getDataParentChild($catalog, $this->setPage);
		}
		// SEO
		$this->data['url'] = base_url(_cdv . '/' . $catalog->url);
		$this->data['title'] = val_seo($catalog->title, $catalog->name);
		$this->data['description'] = val_seo($catalog->description, $catalog->name);
		$this->data['keywords'] = val_seo($catalog->keyword, $catalog->name);
		$this->data['image_seo'] = val_img_seo($catalog->image_seo, $catalog->image_link);
		// BREADCRUMB
		$this->mybreadcrumb->add('Trang chủ', base_url());
		if ($catalog->parent_id != 0) {
			$parent = $this->catalog_model->get_info($catalog->parent_id);
			$this->mybreadcrumb->add($parent->name, base_url(_cdv . '/' . $parent->url));
		}
		$this->mybreadcrumb->add($catalog->name, base_url(_cdv . '/' . $catalog->url));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/services/catalog';
		$this->load->view('site/layout', $this->data);
	}
	function view()
	{
		$slug = $this->uri->rsegment(3);
		$post = $this->services_model->get_info_rule(['url' => $slug, 'status' => 1]);
		if (!$post) {
			redirect();
		}
		$this->data['post'] = $post;
		$catalog = $this->catalogservice_model->get_info($post->catalog_id);

		// Lấy sản phẩm cùng loại
		$input = [];
		$input['select'] = 'name, url, image_link as img';
		$input['where'] = ['status' => 1, 'timer <=' => now(), 'catalog_id' => $post->catalog_id, 'id !=' => $post->id];
		$input['order_by'] = ['id' => 'RANDOM'];
		$input['limit'] = [3, 0];
		$this->data['rely'] = $this->services_model->get_list($input);

		// Seo ======================================================
		$this->data['url'] = base_url(_dv . '/' . $post->url);
		$this->data['title'] = val_seo($post->title, $post->name);
		$this->data['description'] = val_seo($post->description, $post->name);
		$this->data['keywords'] = val_seo($post->keyword, $post->name);
		$this->data['image_seo'] = val_img_seo($post->image_seo, $post->image_link);
		// Breadcrumb
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add($catalog->name, base_url(_cdv . '/' . $catalog->url));
		$this->mybreadcrumb->add($post->name, base_url(_dv . '/' . $post->url));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/services/view';
		$this->load->view('site/layout', $this->data);
	}
	private function _getDataParentChild($catalog, $setPage)
	{ // Hiển thị 2 layout
		if (count($this->catalogservice_model->menucon($catalog->id)) > 0) {
			$catalog_subs = $this->catalogservice_model->get_sub_one($catalog, check_sort($setPage->sort_catalog_service));
			if ($catalog_subs) {
				$data_parent_child = [];
				foreach ($catalog_subs as $sub_id) {
					$sub = $this->catalogservice_model->get_info($sub_id);
					$sub_child = $this->catalogservice_model->get_sub_full($sub, check_sort($setPage->sort_catalog_service));
					$input = [];
					$input['select'] = 'services.name, services.url, services.image_link as img';
					$input['join'] = [
						'services_catalogservice' => ['services_catalogservice.service_id = services.id']
					];
					$input['where'] = ['services.status' => 1, 'services.timer <=' => now()];
					$input['where_in'] = ['services_catalogservice.catalog_id', $sub_child];
					$input['group_by'] = 'services.id';
					$input['order_by'] = [
						check_sort($setPage->sort_services, 'services')[0] => check_sort($setPage->sort_services, 'services')[1],
						'services.id' => 'desc'
					];
					$input['limit'] = [$setPage->limit_catalog_service, 0];
					$list_data = $this->services_model->get_list($input);
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
		$catalog_subs = $this->catalogservice_model->get_sub_full($catalog, check_sort($setPage->sort_catalog_service));
		$input = [];
		$input['select'] = 'services.name, services.url, services.image_link as img';
		$input['join'] = [
			'services_catalogservice' => ['services_catalogservice.service_id = services.id']
		];
		$input['where'] = ['services.status' => 1, 'services.timer <=' => now()];
		$input['where_in'] = ['services_catalogservice.catalog_id', $catalog_subs];
		$input['group_by'] = 'services.id';
		$input['order_by'] = [
			check_sort($setPage->sort_services, 'services')[0] => check_sort($setPage->sort_services, 'services')[1],
			'services.id' => 'desc'
		];
		// Pagination
		$config = $this->frontpagination->config($this->services_model->get_total($input), base_url(_cdv . '/' . $catalog->url), $setPage->pagination_catalog_service, $_GET, base_url(_cdv . '/' . $catalog->url), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['data_child'] = $this->services_model->get_list($input);
	}
}
