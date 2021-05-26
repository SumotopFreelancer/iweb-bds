<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pages extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('pages_model');
	}
	function view()
	{
		$slug = $this->uri->rsegment(3);
		$page = $this->pages_model->get_info_rule(['url' => $slug, 'status' => 1]);
		if (!$page) {
			redirect();
		}
		$this->data['page'] = $page;
		// Seo ======================================================
		$this->data['url'] = base_url(_pg . '/' . $page->url);
		$this->data['title'] = val_seo($page->title, $page->name);
		$this->data['description'] = val_seo($page->description, $page->name);
		$this->data['keywords'] = val_seo($page->keyword, $page->name);
		$this->data['image_seo'] = val_img_seo($page->image_seo, $page->image_link);
		// Breadcrumb
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add($page->name, base_url(_pg . '/' . $page->url));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/pages/index';
		$this->load->view('site/layout', $this->data);
	}
}
