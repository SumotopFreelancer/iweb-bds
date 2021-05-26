<?php
defined('BASEPATH') or exit('No direct script access allowed');
class News extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('news_model');
		$this->load->model('catalognew_model');
		$this->load->model('newscatalognew_model');
		$this->load->model('menu_model');
		$this->load->model('tags_model');
		$this->load->model('tagsnews_model');

		// Load danh mục cha
		$input = [];
		$input['where'] = ['parent_id' => 0];
		$input['order_by'] = [check_sort($this->setadmin->sort_catalog_new)[0] => check_sort($this->setadmin->sort_catalog_new)[1]];
		$this->data['catalog'] = $this->catalognew_model->get_list($input);
	}
	function index()
	{
		$input = [];
		$input['select'] = 'news.id, news.name, news.url, news.image_link, news.timer, news.status,  news.home, news.sidebar, news.view, catalog_new.name as catalogName';
		$input['join'] = [
			'catalog_new' => ['catalog_new.id = news.catalog_id']
		];
		if ($this->input->get()) {
			if ($this->input->get('name')) {
				$input['like'] = ['news.name' => $this->input->get('name', TRUE)];
			}
			if ($this->input->get('catalog_id')) {
				$catalog_id = $this->input->get('catalog_id');
				$catalog = $this->catalognew_model->get_info($catalog_id);
				if ($catalog) {
					$catalog_subs = $this->catalognew_model->get_sub_full_admin($catalog, check_sort($this->setadmin->sort_catalog_new));
					if ($catalog_subs) {
						$input['where_in'] = ['news.catalog_id', $catalog_subs];
					}
				}
			}
		}
		// Pagination
		$config = $this->adminpagination->config($this->news_model->get_total($input), admin_url('news'), 30, $_GET, admin_url('news'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();

		$input['limit'] = [$config['per_page'], $segment];
		$input['order_by'] = [
			check_sort($this->setadmin->sort_news, 'news')[0] => check_sort($this->setadmin->sort_news, 'news')[1],
			'news.id' => 'desc'
		];
		$this->data['list'] = $this->news_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/news/index';
		$this->load->view('admin/main', $this->data);
	}
	function add()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('catalog_ids[]', 'Danh mục', 'required');
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_add(chuyenurl($this->input->post('url', TRUE)), $name, 'news_model');
				$catalog_id = main_catalog($this->input->post('catalog_id'), $this->input->post('catalog_ids'));
				$data = [
					'catalog_id' => $catalog_id,
					'name' => $name,
					'url' => $url,
					'intro' => $this->input->post('intro'),
					'content' => $this->input->post('content'),
					'image_link' => $this->input->post('image_link'),
					'image_seo' => $this->input->post('image_seo'),
					'title' => $this->input->post('title', TRUE),
					'description' => $this->input->post('description', TRUE),
					'keyword' => $this->input->post('keyword', TRUE),
					'created' => now(),
					'updated' => now(),
					'status' => $this->input->post('status'),
					'home' => $this->input->post('home'),
					'sidebar' => $this->input->post('sidebar'),
					'layout' => $this->input->post('layout'),
					'author' => $this->input->post('author', TRUE),
					'sort_order' => intval($this->input->post('sort_order')),
					'timer' => convert_time_admin($this->input->post('timer'))
				];
				// Check tag
				$this->checkTag($this->input->post('listtagpost'));
				if ($this->news_model->create($data)) {
					$insert_id = $this->db->insert_id();
					// Thêm catalog
					$this->createCatalogid($insert_id, $this->input->post('catalog_ids'));
					// Thêm tags
					$this->createTag($insert_id, $this->input->post('listtagpost'));
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				$this->load->helper('xml');
				sitemapUpdate();
				$this->db->cache_delete_all();
				redirect(admin_url('news'));
			}
		}
		$this->data['temp'] = 'admin/news/add';
		$this->load->view('admin/main', $this->data);
	}
	function edit()
	{
		$id = intval($this->uri->rsegment('3'));
		$info = $this->news_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('news'));
		}
		$this->data['info'] = $info;
		$this->data['catalog_ids'] = $this->newscatalognew_model->get_list_catalog_by_new_id($id);
		$this->data['listtags'] = $this->tags_model->get_list_tag_by_new_id($id);

		if ($this->input->post()) {
			$this->form_validation->set_rules('catalog_ids[]', 'Danh mục', 'required');
			$this->form_validation->set_rules('name', 'Tên', 'required');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = get_url_edit(chuyenurl($this->input->post('url', TRUE)), $name, 'news_model', $id);
				$catalog_id = main_catalog($this->input->post('catalog_id'), $this->input->post('catalog_ids'));
				$data = [
					'catalog_id' => $catalog_id,
					'name' => $name,
					'url' => $url,
					'intro' => $this->input->post('intro'),
					'content' => $this->input->post('content'),
					'image_link' => $this->input->post('image_link'),
					'image_seo' => $this->input->post('image_seo'),
					'title' => $this->input->post('title', TRUE),
					'description' => $this->input->post('description', TRUE),
					'keyword' => $this->input->post('keyword', TRUE),
					'updated' => now(),
					'status' => $this->input->post('status'),
					'home' => $this->input->post('home'),
					'sidebar' => $this->input->post('sidebar'),
					'layout' => $this->input->post('layout'),
					'author' => $this->input->post('author', TRUE),
					'sort_order' => intval($this->input->post('sort_order')),
					'timer' => convert_time_admin($this->input->post('timer'))
				];
				// Check tag
				$this->checkTag($this->input->post('listtagpost'));
				if ($this->news_model->update($id, $data)) {
					// Sửa catalog
					$this->createCatalogid($id, $this->input->post('catalog_ids'), 'edit');
					// Sửa tag
					$this->createTag($id, $this->input->post('listtagpost'), 'edit');
					// Sửa menu
					$this->menu_model->updateMenu($id, 'news', $url);
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
				$this->load->helper('xml');
				sitemapUpdate();
				$this->db->cache_delete_all();
				if ($this->input->post('cus_btn_save') == 'Lưu lại') {
					redirect(admin_url('news/edit/' . $id));
				} else {
					redirect(admin_url('news'));
				}
			}
		}
		$this->data['temp'] = 'admin/news/edit';
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
		redirect(admin_url('news'));
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
		$info = $this->news_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('news'));
			}
		}
		if ($this->news_model->delete($id)) {
			// Xóa new_id trong bảng new_catalognew
			$this->newscatalognew_model->del_rule(['new_id' => $id]);
			// Xóa new_id trong bảng tagsnews
			$this->tagsnews_model->del_rule(['new_id' => $id]);
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
	}
	function status()
	{
		$id = intval($this->input->post('id'));
		$info = $this->news_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('news'));
		}
		if ($info->status == 1) {
			$data = ['status' => 0];
			$this->news_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->status == 0) {
			$data = ['status' => 1];
			$this->news_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
	function home()
	{
		$id = intval($this->input->post('id'));
		$info = $this->news_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('news'));
		}
		if ($info->home == 1) {
			$data = ['home' => 0];
			$this->news_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->home == 0) {
			$data = ['home' => 1];
			$this->news_model->update($id, $data);
			echo '<i class="fa fa-check-circle-o"></i>';
		}
		$this->load->helper('xml');
		sitemapUpdate();
		$this->db->cache_delete_all();
	}
	function sidebar()
	{
		$id = intval($this->input->post('id'));
		$info = $this->news_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('news'));
		}
		if ($info->sidebar == 1) {
			$data = ['sidebar' => 0];
			$this->news_model->update($id, $data);
			echo '<i class="fa fa-times-circle-o"></i>';
		}
		if ($info->sidebar == 0) {
			$data = ['sidebar' => 1];
			$this->news_model->update($id, $data);
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
		$input['order'] = ['sort_order', 'desc'];
		$ketqua = $this->tags_model->get_list($input);
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
				if (!$this->tags_model->check_name_tags($row)) { // Nếu tên tags này chưa có
					$url = chuyenurl($row);
					$where = ['url' => $url];
					if ($this->tags_model->check_exists($where)) { // Nếu như url này đã tồn tại
						$input = [];
						$input['where'] = ['name' => mb_strtolower($row)];
						$num = $this->tags_model->get_total($input);
						$url = $url . '-' . $num;
					}
					$data = [
						'name' => mb_strtolower($row),
						'url' => $url,
						'created' => now()
					];
					$this->tags_model->create($data);
				}
			}
		}
	}
	function createTag($id, $stringTag = '', $action = 'add')
	{
		if ($action == 'edit') {
			$where = ['new_id' => $id];
			$this->tagsnews_model->del_rule($where);
		}
		if (!empty($stringTag)) {
			$tags = explode(',', $stringTag);
			foreach ($tags as $row) {
				$tag_id = $this->tags_model->get_info_tags($row)->id;
				$input = [];
				$input['where'] = ['new_id' => $id, 'tag_id' => $tag_id];
				if ($this->tagsnews_model->get_total_tags($input) <= 0) {
					$data = [
						'new_id' => $id,
						'tag_id' => $tag_id,
					];
					$this->tagsnews_model->create($data);
				}
			}
		}
	}
	function createCatalogid($id, $catalog_ids = [], $action = 'add')
	{
		if ($action == 'edit') {
			$where = ['new_id' => $id];
			$this->newscatalognew_model->del_rule($where);
		}
		foreach ($catalog_ids as $catalog_id) {
			$data = [
				'new_id' => $id,
				'catalog_id' => $catalog_id,
			];
			$this->newscatalognew_model->create($data);
		}
	}
}
