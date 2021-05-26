<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Order extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('transaction_model');
		$this->load->model('order_model');
		$this->load->model('products_model');
	}
	function index()
	{
		$input = [];
		if ($this->input->get()) {
			if ($this->input->get('id')) {
				$input['where']['id'] = $this->input->get('id', TRUE);
			}
			if ($this->input->get('status') && $this->input->get('status') > 0) {
				$input['where']['status'] = $this->input->get('status');
			}
			if ($this->input->get('user_name')) {
				$input['like'] = ['user_name' => $this->input->get('user_name', TRUE)];
			}
		}
		// Pagination
		$config = $this->adminpagination->config($this->transaction_model->get_total($input), admin_url('order'), 20, $_GET, admin_url('order'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['list'] = $this->transaction_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];
		// Load view
		$this->data['temp'] = 'admin/order/index';
		$this->load->view('admin/main', $this->data);
	}
	function edit()
	{
		$id = intval($this->uri->rsegment('3'));
		$info = $this->transaction_model->get_info($id);
		if (!$info) {
			$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
			redirect(admin_url('order'));
		}
		$this->data['info'] = $info;

		// Detail order
		$input = [];
		$input['where'] = ['transaction_id' => $id];
		$this->data['orderdetail'] = $this->order_model->get_list($input);

		$this->data['temp'] = 'admin/order/edit';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
	function updatestatus()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('status', 'Trạng thái', 'required');
			$this->form_validation->set_rules('note_admin', 'Ghi chú', 'required');
			if ($this->form_validation->run() == FALSE) {
				$errors = $this->form_validation->error_array();
				echo json_encode($errors);
			} else {
				$status = $this->input->post('status');
				$id = $this->input->post('id');
				$data = [
					'status' => $status,
					'note_admin' => $this->input->post('note_admin', TRUE),
					'updated' => now()
				];
				// Add database
				$this->transaction_model->update($id, $data);
				$transaction = $this->transaction_model->get_info($id);
				// Send email
				if ($status == 2) { // Success
					$noidung = $this->load->view('admin/order/email/success', $transaction, TRUE);
					$this->email->initialize(config_send_mail());
					$this->email->from('Website', isJson($this->setadmin->company)->tenquocte);
					$this->email->to($transaction->user_email);
					$this->email->subject(isJson($this->setadmin->company)->tenquocte);
					$this->email->message($noidung);
					$this->email->send();
				}
				if ($status == 3) { // Cancel
					$noidung = $this->load->view('admin/order/email/cancel', $transaction, TRUE);
					$this->email->initialize(config_send_mail());
					$this->email->from('Website', isJson($this->setadmin->company)->tenquocte);
					$this->email->to($transaction->user_email);
					$this->email->subject(isJson($this->setadmin->company)->tenquocte);
					$this->email->message($noidung);
					$this->email->send();
				}
				echo 1;
			}
		}
	}
	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		redirect(admin_url('order'));
	}
	// xoa nhieu san pham
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
		$info = $this->transaction_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('order'));
			}
		}
		if ($this->transaction_model->delete($id)) {
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
		$input = [];
		$input['where'] = ['transaction_id' => $id];
		$order = $this->order_model->get_list($input);
		if ($order) {
			foreach ($order as $row) {
				$this->order_model->delete($row->id);
			}
		}

		$this->db->cache_delete_all();
	}
}
