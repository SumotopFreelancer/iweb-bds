<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tags extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('tags_model');
		$this->load->model('tagsnews_model');
	}
	function index()
	{
		// Pagination
		$config = $this->adminpagination->config($this->tags_model->get_total(), admin_url('tags'), 40, $_GET, admin_url('tags'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input = [];
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['list'] = $this->tags_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/tags/index';
		$this->load->view('admin/main', $this->data);
	}
	function check_tags_name()
	{
		$action = $this->uri->rsegment(2);
		$name = mb_strtolower($this->input->post('name'));
		// Kiểm tra tên tags đã tồn tại chưa
		$check = true;
		if ($action == 'edit') {
			$info = $this->data['info'];
			if ($info->name == $name) {
				$check = false;
			}
		}
		if ($check && $this->tags_model->check_name_tags($name)) {
			$this->form_validation->set_message(__FUNCTION__, 'Tags tên này đã tồn tại');
			return false;
		}
		return true;
	}
	function add()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required|callback_check_tags_name');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = chuyenurl($this->input->post('url', TRUE));
				if ($url == '') {
					$url = chuyenurl($name);
				}
				$where = ['url' => $url];
				if ($this->tags_model->check_exists($where)) {
					$input = [];
					$input['where'] = ['name' => $name];
					$num = $this->tags_model->get_total($input);
					$url = $url . '-' . $num;
				}
				$data = [
					'name' => mb_strtolower($name),
					'url' => $url,

					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),
					'keyword' => $this->input->post('keyword'),
					'image_link' => $this->input->post('image_link'),
					'image_seo' => $this->input->post('image_seo'),

					'created' => now(),
					'sort_order' => intval($this->input->post('sort_order'))
				];
				if ($this->tags_model->create($data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				$this->load->helper('xml');
				sitemapUpdate();
				$this->db->cache_delete_all();
				redirect(admin_url('tags'));
			}
		}
		// Load view
		$this->data['temp'] = 'admin/tags/add';
		$this->load->view('admin/main', $this->data);
	}

	function edit()
	{
		$id = intval($this->uri->rsegment('3'));
		$info = $this->tags_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('tags'));
		}
		$this->data['info'] = $info;

		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên', 'required|callback_check_tags_name');
			if ($this->form_validation->run()) {
				$name = trim($this->input->post('name', TRUE));
				$url = chuyenurl($this->input->post('url', TRUE));
				if ($url == '') {
					$url = chuyenurl($name);
				}
				$where = ['url' => $url];
				if ($this->tags_model->check_exists($where)) {
					$info_tags = $this->tags_model->get_info_rule($where);
					if ($info_tags->id != $id) {
						$input = [];
						$input['where'] = ['name' => $name];
						$num = $this->tags_model->get_total($input);
						$url = $url . '-' . $num;
					}
				}
				$data = [
					'name' => mb_strtolower($name),
					'url' => $url,

					'title' => $this->input->post('title'),
					'description' => $this->input->post('description'),
					'keyword' => $this->input->post('keyword'),
					'image_link' => $this->input->post('image_link'),
					'image_seo' => $this->input->post('image_seo'),

					'sort_order' => intval($this->input->post('sort_order'))
				];
				if ($this->tags_model->update($id, $data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
				$this->load->helper('xml');
				sitemapUpdate();
				$this->db->cache_delete_all();
				if ($this->input->post('cus_btn_save') == 'Lưu lại') {
					redirect(admin_url('tags/edit/' . $id));
				} else {
					redirect(admin_url('tags'));
				}
			}
		}
		$this->data['temp'] = 'admin/tags/edit';
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
		redirect(admin_url('tags'));
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
		$info = $this->tags_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('tags'));
			}
		}
		if ($this->tags_model->delete($id)) {
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
		// xóa Tag
		$input = [];
		$input = ['tag_id' => $id];
		$this->tagsnews_model->del_rule($input);
	}
}
