<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Images extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		redirect();
		$this->load->model('catalogimage_model');
		$this->load->model('images_model');
		$this->load->library('frontpagination');

		// Load setup
		$this->setPage = $this->setup_model->get_setup(['sort_catalog_image', 'sort_images', 'pagination_catalog_image', 'limit_catalog_image']);
	}
	function catalog()
	{
		$slug = $this->uri->rsegment(3);
		$catalog = $this->catalogimage_model->get_info_rule(['url' => $slug, 'status' => 1]);
		if (!$catalog) {
			redirect();
		}
		$this->data['catalog'] = $catalog;
		// DATA
		if (_catalogimage_parent_child == 0) {
			$this->_getDataChild($catalog, $this->setPage);
		} else {
			$this->_getDataParentChild($catalog, $this->setPage);
		}
		// SEO
		$this->data['url'] = base_url(_cim . '/' . $catalog->url);
		$this->data['title'] = val_seo($catalog->title, $catalog->name);
		$this->data['description'] = val_seo($catalog->description, $catalog->name);
		$this->data['keywords'] = val_seo($catalog->keyword, $catalog->name);
		$this->data['image_seo'] = val_img_seo($catalog->image_seo, $catalog->image_link);
		// BREADCRUMB
		$this->mybreadcrumb->add('Trang chủ', base_url());
		if ($catalog->parent_id != 0) {
			$parent = $this->catalogimage_model->get_info($catalog->parent_id);
			$this->mybreadcrumb->add($parent->name, base_url(_cim . '/' . $parent->url));
		}
		$this->mybreadcrumb->add($catalog->name, base_url(_cim . '/' . $catalog->url));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/images/catalog';
		$this->load->view('site/layout', $this->data);
	}
	function view()
	{
		$slug = $this->uri->rsegment(3);
		$post = $this->images_model->get_info_rule(['url' => $slug, 'status' => 1]);
		if (!$post) {
			redirect();
		}
		$this->data['post'] = $post;
		$catalog = $this->catalogimage_model->get_info($post->catalog_id);
		// Seo ======================================================
		$this->data['url'] = base_url(_im . '/' . $post->url);
		$this->data['title'] = val_seo($post->title, $post->name);
		$this->data['description'] = val_seo($post->description, $post->name);
		$this->data['keywords'] = val_seo($post->keyword, $post->name);
		$this->data['image_seo'] = val_img_seo($post->image_seo, $post->image_link);
		// Breadcrumb
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add($catalog->name, base_url(_cim . '/' . $catalog->url));
		$this->mybreadcrumb->add($post->name, base_url(_im . '/' . $post->url));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/images/view';
		$this->load->view('site/layout', $this->data);
	}
	private function _getDataParentChild($catalog, $setPage)
	{ // Hiển thị 2 layout
		if (count($this->catalogimage_model->menucon($catalog->id)) > 0) {
			$catalog_subs = $this->catalogimage_model->get_sub_one($catalog, check_sort($setPage->sort_catalog_image));
			if ($catalog_subs) {
				$data_parent_child = [];
				foreach ($catalog_subs as $sub_id) {
					$sub = $this->catalogimage_model->get_info($sub_id);
					$sub_child = $this->catalogimage_model->get_sub_full($sub, check_sort($setPage->sort_catalog_image));
					$input = [];
					$input['select'] = 'images.id, images.name, images.url, images.intro, images.image_link, images.created, images.updated, images.timer, images.catalog_id, images.status, images.sort_order, images.author, images.view';
					$input['join'] = [
						'images_catalogimage' => ['images_catalogimage.image_id = images.id']
					];
					$input['where'] = ['status' => 1, 'timer <=' => now()];
					$input['where_in'] = ['images_catalogimage.catalog_id', $sub_child];
					$input['group_by'] = 'images.id';
					$input['order_by'] = [
						check_sort($setPage->sort_images, 'images')[0] => check_sort($setPage->sort_images, 'images')[1],
						'images.id' => 'desc'
					];
					$input['limit'] = [$setPage->limit_catalog_image, 0];
					$list_data = $this->images_model->get_list($input);
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
		$catalog_subs = $this->catalogimage_model->get_sub_full($catalog, check_sort($setPage->sort_catalog_image));
		$input['select'] = 'images.id, images.name, images.url, images.intro, images.image_link, images.created, images.updated, images.timer, images.catalog_id, images.status, images.sort_order, images.view';
		$input['join'] = [
			'images_catalogimage' => ['images_catalogimage.image_id = images.id']
		];
		$input['where'] = ['status' => 1, 'timer <=' => now()];
		$input['where_in'] = ['images_catalogimage.catalog_id', $catalog_subs];
		$input['group_by'] = 'images.id';
		$input['order_by'] = [
			check_sort($setPage->sort_images, 'images')[0] => check_sort($setPage->sort_images, 'images')[1],
			'images.id' => 'desc'
		];
		// Pagination
		$config = $this->frontpagination->config($this->images_model->get_total($input), base_url(_cim . '/' . $catalog->url), $setPage->pagination_catalog_image, $_GET, base_url(_cim . '/' . $catalog->url), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['data_child'] = $this->images_model->get_list($input);
	}
}
