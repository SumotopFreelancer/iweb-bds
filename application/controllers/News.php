<?php
defined('BASEPATH') or exit('No direct script access allowed');
class News extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
		$this->load->model('catalognew_model');
		$this->load->model('tags_model');
		$this->load->model('tagsnews_model');
		$this->load->library('frontpagination');

		// Load setup
		$this->setPage = $this->setup_model->get_setup(['sort_catalog_new', 'sort_news', 'pagination_catalog_new', 'limit_catalog_new']);
	}
	public function catalog()
	{
		$slug = $this->uri->rsegment(3);
		$catalog = $this->catalognew_model->get_info_rule(['url' => $slug, 'status' => 1]);
		if (!$catalog) {
			redirect();
		}
		$this->data['catalog'] = $catalog;
		// Data
		if (_catalognew_parent_child == 0) {
			$this->_getDataChild($catalog, $this->setPage);
		} else {
			$this->_getDataParentChild($catalog, $this->setPage);
		}
		// Seo ====================================
		$this->data['url'] = base_url(_cblog . '/' . $catalog->url);
		$this->data['title'] = val_seo($catalog->title, $catalog->name);
		$this->data['description'] = val_seo($catalog->description, $catalog->name);
		$this->data['keywords'] = val_seo($catalog->keyword, $catalog->name);
		$this->data['image_seo'] = val_img_seo($catalog->image_seo, $catalog->image_link);
		// Breadcrumb
		$this->mybreadcrumb->add('Trang chủ', base_url());
		if ($catalog->parent_id != 0) {
			$parent = $this->catalognew_model->get_info($catalog->parent_id);
			$this->mybreadcrumb->add($parent->name, base_url(_cblog . '/' . $parent->url));
		}
		$this->mybreadcrumb->add($catalog->name, base_url(_cblog . '/' . $catalog->url));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/news/catalog';
		$this->load->view('site/layout', $this->data);
	}
	function view()
	{
		$slug = $this->uri->rsegment(3);
		$post = $this->news_model->get_info_rule(['url' => $slug, 'status' => 1]);
		if (!$post) {
			redirect();
		}
		$this->data['post'] = $post;
		$catalog = $this->catalognew_model->get_info($post->catalog_id);
		$this->data['catalog'] = $catalog;
		//Tag
		$this->data['tags'] = $this->tags_model->get_list_tag_by_new_id($post->id);

		// // Tin cùng danh mục dưới chân bài viết
		// $catalog_subs = $this->catalognew_model->get_sub_full($catalog, check_sort($this->setPage->sort_catalog_new));
		// if($catalog_subs){
		// 	$input = [];
		// 	$input['where'] = ['news.status' => 1, 'news.id !=' => $post->id, 'news.timer <=' => now()];
		// 	$input['limit'] = [5, 0];
		// $input['order_by'] = [
		// 	check_sort($this->setPage->sort_news, 'news'),
		// 	'news.id' => 'desc'
		// ];
		// 	$this->data['post_rely'] = $this->news_model->get_list($input);
		// }

		// Prev
		$input = [];
		$input['where'] = ['status' => 1, 'id !=' => $post->id, 'timer <=' => now(), 'catalog_id' => $post->catalog_id, 'timer <=' => $post->timer, 'id <' => $post->id];
		$input['order_by'] = [
			'timer' => 'desc',
			'id' => 'desc'
		];
		$this->data['post_prev'] = $this->news_model->get_row($input);
		// Next
		$input = [];
		$input['where'] = ['status' => 1, 'id !=' => $post->id, 'timer <=' => now(), 'catalog_id' => $post->catalog_id, 'timer >=' => $post->timer, 'id >' => $post->id];
		$input['order_by'] = [
			'timer' => 'asc',
			'id' => 'asc'
		];
		$this->data['post_next'] = $this->news_model->get_row($input);
		// Update view
		$viewupdate = $post->view + 1;
		$dataupdate = ['view' => $viewupdate];
		$this->news_model->update($post->id, $dataupdate);
		// Seo ======================================================
		$this->data['url'] = base_url($catalog->url . '/' . $post->url);
		$this->data['title'] = val_seo($post->title, $post->name);
		$this->data['description'] = val_seo($post->description, $post->name);
		$this->data['keywords'] = val_seo($post->keyword, $post->name);
		$this->data['image_seo'] = val_img_seo($post->image_seo, $post->image_link);
		// Breadcrumb
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add($catalog->name, base_url(_cblog . '/' . $catalog->url));
		$this->mybreadcrumb->add($post->name, base_url(_blog . '/' . $post->url));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/news/view';
		$this->load->view('site/layout', $this->data);
	}
	public function tags()
	{
		$url = $this->uri->rsegment(3);
		$tag = $this->tags_model->get_info_rule(['url' => $url]);
		if (!$tag) {
			redirect();
		}
		$this->data['tag'] = $tag;
		// List Tag
		$input = [];
		$input['select'] = 'news.name, news.url, news.intro, news.image_link as img, catalog_new.url as urlCat';
		$input['join'] = [
			'tags_news' => ['tags_news.new_id = news.id'],
			'catalog_new' => ['catalog_new.id = news.catalog_id']
		];
		$input['where'] = ['news.status' => 1, 'news.timer <=' => now(), 'tags_news.tag_id' => $tag->id];
		$input['group_by'] = 'news.id';
		$input['order_by'] = [
			check_sort($this->setPage->sort_news, 'news')[0] => check_sort($this->setPage->sort_news, 'news')[1],
			'news.id' => 'desc'
		];
		// Pagination
		$config = $this->frontpagination->config($this->news_model->get_total($input), base_url(_tags . '/' . $tag->url), $this->setPage->pagination_catalog_new, $_GET, base_url(_tags . '/' . $tag->url), 3);
		$this->pagination->initialize($config);
		$segment = intval($this->uri->segment(3)) == 0 ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['list'] = $this->news_model->get_list($input);
		// Seo ====================================
		$this->data['url'] = base_url(_tags . '/' . $tag->url);
		$this->data['title'] = val_seo($tag->title, $tag->name);
		$this->data['description'] = val_seo($tag->description, $tag->name);
		$this->data['keywords'] = val_seo($tag->keyword, $tag->name);
		$this->data['image_seo'] = val_img_seo($tag->image_seo, $tag->image_link);
		// Breadcrumb
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add('Tags ' . $tag->name, base_url(_tags . '/' . $tag->url));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/news/tags';
		$this->load->view('site/layout', $this->data);
	}
	private function _getDataParentChild($catalog, $setPage)
	{ // Hiển thị 2 layout
		if (count($this->catalognew_model->menucon($catalog->id)) > 0) {
			$catalog_subs = $this->catalognew_model->get_sub_one($catalog, check_sort($setPage->sort_catalog_new));
			if ($catalog_subs) {
				$data_parent_child = [];
				foreach ($catalog_subs as $sub_id) {
					$sub = $this->catalognew_model->get_info($sub_id);
					$sub_child = $this->catalognew_model->get_sub_full($sub, check_sort($setPage->sort_catalog_new));
					$input = [];
					$input['select'] = 'news.id, news.name, news.url, news.intro, news.image_link, news.created, news.updated, news.timer, news.catalog_id, news.status, news.sort_order, news.author, news.view';
					$input['join'] = [
						'news_catalognew' => ['news_catalognew.new_id = news.id']
					];
					$input['where'] = ['status' => 1, 'timer <=' => now()];
					$input['where_in'] = ['news_catalognew.catalog_id', $sub_child];
					$input['group_by'] = 'news.id';
					$input['order_by'] = [
						check_sort($setPage->sort_news, 'news')[0] => check_sort($setPage->sort_news, 'news')[1],
						'news.id' => 'desc'
					];
					$input['limit'] = [$setPage->limit_catalog_new, 0];
					$list_data = $this->news_model->get_list($input);
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
		$catalog_subs = $this->catalognew_model->get_sub_full($catalog, check_sort($setPage->sort_catalog_new));
		$input['select'] = 'news.id, news.name, news.url, news.intro, news.image_link as img, catalog_new.url as urlCat';
		$input['join'] = [
			'news_catalognew' => ['news_catalognew.new_id = news.id'],
			'catalog_new' => ['catalog_new.id = news.catalog_id']
		];
		$input['where'] = ['news.status' => 1, 'news.timer <=' => now()];
		$input['where_in'] = ['news_catalognew.catalog_id', $catalog_subs];
		$input['group_by'] = 'news.id';
		$input['order_by'] = [
			check_sort($setPage->sort_news, 'news')[0] => check_sort($setPage->sort_news, 'news')[1],
			'news.id' => 'desc'
		];
		// Pagination
		$config = $this->frontpagination->config($this->news_model->get_total($input), base_url(_cblog . '/' . $catalog->url), $setPage->pagination_catalog_new, $_GET, base_url(_cblog . '/' . $catalog->url), 2);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(2)) == 0) ? 0 : ($this->uri->segment(2) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['data_child'] = $this->news_model->get_list($input);
	}
}
