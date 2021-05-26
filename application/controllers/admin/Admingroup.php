<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminGroup extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admingroup_model');
		$this->load->model('admin_model');
		// Load file config/quyen.php
		$this->config->load('quyen', true);
		$list_quyen = $this->config->item('quyen');
		$this->data['list_quyen'] = $list_quyen;
	}

	function index()
	{
		// Pagination
		$config = $this->adminpagination->config($this->admingroup_model->get_total(), admin_url('admingroup'), 10, $_GET, admin_url('admingroup'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input = [];
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['list'] = $this->admingroup_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/admingroup/index';
		$this->load->view('admin/main', $this->data);
	}
	// Thêm mới
	function add()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên nhóm quyền', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('quyen[]', 'Nhóm quyền', 'trim|required');
			// khi nhap lieu chinh xac
			if ($this->form_validation->run()) {
				$ajax = [
					'ajax' => ['slug']
				];
				$data = [
					'name' => $this->input->post('name', TRUE),
					'permissions' => json_encode(array_merge($this->input->post('quyen'), $ajax)),
					'sort_order' => intval($this->input->post('sort_order')),
					'created' => now()
				];
				if ($this->admingroup_model->create($data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				redirect(admin_url('admingroup'));
			}
		}
		$this->data['temp'] = 'admin/admingroup/add';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
	// Chỉnh sửa
	function edit()
	{
		$id = intval($this->uri->rsegment(3));
		$info = $this->admingroup_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('admingroup'));
		}
		$info->permissions = json_decode($info->permissions);
		$this->data['info'] = $info;

		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên nhóm quyền', 'trim|required|min_length[5]');
			$this->form_validation->set_rules('quyen[]', 'Nhóm quyền', 'trim|required');
			// khi nhap lieu chinh xac
			if ($this->form_validation->run()) {
				$ajax = [
					'ajax' => ['slug']
				];
				$data = [
					'name' => $this->input->post('name', TRUE),
					'permissions' => json_encode(array_merge($this->input->post('quyen'), $ajax)),
					'sort_order' => intval($this->input->post('sort_order')),
				];
				if ($this->admingroup_model->update($id, $data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được. Thử lại sau</div>');
				}
				if ($this->input->post('cus_btn_save') == 'Lưu lại') {
					redirect(admin_url('admingroup/edit/' . $id));
				} else {
					redirect(admin_url('admingroup'));
				}
			}
		}

		$this->data['temp'] = 'admin/admingroup/edit';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}

	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		redirect(admin_url('admingroup'));
		$this->db->cache_delete_all();
	}
	function del_all()
	{
		$ids = $this->input->post('ids');
		foreach ($ids as $id) {
			$this->_del($id);
		}
		$this->db->cache_delete_all();
	}
	private function _del($id, $ajax = TRUE)
	{
		$info = $this->admingroup_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('admingroup'));
			}
		}
		// kiem tra cò đang ở bảng admin khác không
		$admin = $this->admin_model->get_info_rule(['admin_group_id' => $id], 'id');
		if ($admin) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Nhóm quyền <b>"' . $info->name . '"</b> đang có Admin sử dụng. Bạn cần xóa Admin trước</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Nhóm quyền <b>"' . $info->name . '"</b> đang có Admin sử dụng. Bạn cần xóa Admin trước</div>');
				redirect(admin_url('admingroup'));
			}
		}
		if ($this->admingroup_model->delete($id)) {
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
		$this->db->cache_delete_all();
	}
}
