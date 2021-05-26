<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
		$this->load->model('admingroup_model');

		$this->data['admingroup'] = $this->admingroup_model->get_list();
	}

	function index()
	{
		if ($this->userinfo->type != $this->admin_root->type) {
			redirect('admin');
		}
		// Pagination
		$config = $this->adminpagination->config($this->admin_model->get_total(), admin_url('admin'), 10, $_GET, admin_url('admin'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input = [];
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['list'] = $this->admin_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/admin/index';
		$this->load->view('admin/main', $this->data);
	}

	// Check user name tồn tại hay chưa
	function check_admin()
	{
		$action = $this->uri->rsegment(2);
		$username = $this->input->post('username');
		$where = ['username' => $username];
		// kiem tra xem tai khoan da ton tai hay chua
		$check = true;
		if ($action == 'edit') {
			$info = $this->data['info'];
			if ($info->username == $username) {
				$check = false;
			}
		}
		if ($check && ($this->admin_model->check_exists($where) || $username == $this->admin_root->username)) {
			$this->form_validation->set_message(__FUNCTION__, 'Tài khoản đã tồn tại');
			return false;
		}
		return true;
	}
	//Thêm mới quản trị viên
	function add()
	{
		if ($this->userinfo->type != $this->admin_root->type) {
			redirect('admin');
		}
		// neu co du lieu post lên thì kiem tra
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên hiển thị', 'trim|required|min_length[4]');
			$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|min_length[6]|max_length[32]|callback_check_admin');
			$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|min_length[6]|max_length[32]');
			$this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'trim|matches[password]');
			// khi nhap lieu chinh xac
			if ($this->form_validation->run()) {
				$data = [
					'name' => $this->input->post('name', TRUE),
					'username' => $this->input->post('username', TRUE),
					'password' => md5($this->input->post('password')),
					'admin_group_id' => intval($this->input->post('admin_group_id')),
					'created' => now(),
					'last_login' => now(),
					'type' => 'custom'
				];
				if ($this->admin_model->create($data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Thêm thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không thêm được. Thử lại sau</div>');
				}
				redirect(admin_url('admin'));
			}
		}
		$this->data['temp'] = 'admin/admin/add';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
	// Chỉnh sửa thông tin quản trị viên
	function edit()
	{
		// lấy id cần chỉnh sửa phân đoạn thứ 3 của uri
		$id = intval($this->uri->rsegment('3'));
		$info = $this->admin_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('admin'));
		}
		if ($this->userinfo->id != $info->id && $this->userinfo->type != $this->admin_root->type) {
			redirect('admin');
		}
		$this->data['info'] = $info;
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Tên hiển thị', 'trim|required|min_length[4]');
			$this->form_validation->set_rules('username', 'Tên đăng nhập', 'trim|required|min_length[6]|max_length[32]|callback_check_admin');
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', 'Mật khẩu', 'trim|required|min_length[6]|max_length[32]');
				$this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'trim|matches[password]');
			}
			// khi nhap lieu chinh xac
			if ($this->form_validation->run()) {
				$data = [
					'name' => $this->input->post('name', TRUE),
					'last_login' => now(),
				];
				if ($this->input->post('password')) {
					$data['username'] = $this->input->post('username', TRUE);
					$data['password'] = md5($this->input->post('password'));
				}
				if ($this->input->post('admin_group_id')) {
					$data['admin_group_id'] = intval($this->input->post('admin_group_id'));
				}
				if ($this->admin_model->update($id, $data)) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được. Thử lại sau</div>');
				}
				if ($this->input->post('cus_btn_save') == 'Lưu lại') {
					redirect(admin_url('admin/edit/' . $id));
				} else {
					redirect(admin_url('admin'));
				}
			}
		}
		$this->data['temp'] = 'admin/admin/edit';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		redirect(admin_url('admin'));
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
		$info = $this->admin_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('admin'));
			}
		}
		if ($info->type != $this->admin_root->type) {
			if ($this->admin_model->delete($id)) {
				echo '<span class="id_delete hidden">' . $id . '</span>';
			}
		}
		$this->db->cache_delete_all();
	}
}
