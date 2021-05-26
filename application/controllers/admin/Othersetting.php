<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Othersetting extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		if ($this->userinfo->type == 'root' && $this->userinfo->id == -1) {
			if ($this->input->post()) {
				write_file('./public/dist/styles/overadd.css', $this->input->post('css'));
				$data = [
					'sort_catalog' => $this->input->post('sort_catalog', TRUE),
					'sort_catalog_new' => $this->input->post('sort_catalog_new', TRUE),
					'sort_catalog_image' => $this->input->post('sort_catalog_image', TRUE),
					'sort_catalog_service' => $this->input->post('sort_catalog_service', TRUE),
					'sort_products' => $this->input->post('sort_products', TRUE),
					'sort_news' => $this->input->post('sort_news', TRUE),
					'sort_images' => $this->input->post('sort_images', TRUE),
					'sort_services' => $this->input->post('sort_services', TRUE),
					'pagination_catalog' => $this->input->post('pagination_catalog', TRUE),
					'pagination_catalog_new' => $this->input->post('pagination_catalog_new', TRUE),
					'pagination_catalog_image' => $this->input->post('pagination_catalog_image', TRUE),
					'pagination_catalog_service' => $this->input->post('pagination_catalog_service', TRUE),
					'limit_catalog' => $this->input->post('limit_catalog', TRUE),
					'limit_catalog_new' => $this->input->post('limit_catalog_new', TRUE),
					'limit_catalog_image' => $this->input->post('limit_catalog_image', TRUE),
					'limit_catalog_service' => $this->input->post('limit_catalog_service', TRUE),
					'check_css' => $this->input->post('check_css', TRUE),
					'copyright' => $this->input->post('copyright')
				];
				foreach ($data as $key => $row) {
					if ($this->setup_model->update_rule(['col' => $key], ['value' => $row])) {
						$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
					} else {
						$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
					}
				}
				redirect(admin_url('othersetting'));
			}
			$this->data['css'] = read_file('./public/dist/styles/overadd.css');
			$this->data['temp'] = 'admin/othersetting/index';
			$this->load->view('admin/main', $this->data);
			$this->db->cache_delete_all();
		} else {
			redirect(admin_url());
		}
	}
}
