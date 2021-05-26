<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Visit extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		redirect();
		$this->load->model('visit_model');
		// lấy nội dung message
		$message = $this->session->flashdata('message');
		$this->data['message'] = $message;
	}
	// Danh sach 
	function index()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('online', 'Số người online', 'trim|numeric');
			$this->form_validation->set_rules('day', 'Số người truy cập trong ngày', 'trim|numeric');
			$this->form_validation->set_rules('week', 'Số người truy cập trong tuần', 'trim|numeric');
			$this->form_validation->set_rules('month', 'Số người truy cập trong tháng', 'trim|numeric');
			$this->form_validation->set_rules('total', 'Tổng truy cập', 'trim|numeric');
			// khi nhap lieu chinh xac
			if ($this->form_validation->run()) {
				$data = [
					'visit' => json_encode([
						'online' => $this->input->post('online'),
						'day' => $this->input->post('day'),
						'week' => $this->input->post('week'),
						'month' => $this->input->post('month'),
						'total' => $this->input->post('total')
					])
				];
				foreach ($data as $key => $row) {
					if ($this->setup_model->update_rule(['col' => $key], ['value' => $row])) {
						$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
					} else {
						$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
					}
				}
				redirect(admin_url('visit'));
			}
		}
		// Pagination
		$config = $this->adminpagination->config($this->visit_model->get_total(), admin_url('visit'), 20, $_GET, admin_url('visit'), 3);
		$this->pagination->initialize($config);
		$segment = (intval($this->uri->segment(3)) == 0) ? 0 : ($this->uri->segment(3) * $config['per_page']) - $config['per_page'];
		$this->data['phantrang'] = $this->pagination->create_links();
		// Data
		$input = [];
		$input['limit'] = [$config['per_page'], $segment];
		$this->data['list'] = $this->visit_model->get_list($input);
		$this->data['total_rows'] = $config['total_rows'];

		$this->data['temp'] = 'admin/visit/index';
		$this->load->view('admin/main', $this->data);
	}

	// Xóa
	function delete()
	{
		$id = intval($this->uri->rsegment('3'));
		$this->_del($id, FALSE);
		$this->session->set_flashdata('message', '<div class="callout callout-success">Xóa thành công</div>');
		redirect(admin_url('visit'));
		$this->db->cache_delete_all();
	}
	// Xóa nhiều
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
		$info = $this->visit_model->get_info($id);
		if (!$info) {
			if ($ajax) {
				echo '<div class="callout callout-danger">Không tồn tại</div>';
				return FALSE;
			} else {
				$this->session->set_flashdata('message', '<div class="callout callout-danger">Không tồn tại</div>');
				redirect(admin_url('visit'));
			}
		}
		if ($this->visit_model->delete($id)) {
			echo '<span class="id_delete hidden">' . $id . '</span>';
		}
		$this->db->cache_delete_all();
	}
	/*------------------------- THỐNG KÊ TRUY CẬP -------------------------	*/
	// $result = json_decode(file_get_contents('http://ip-api.io/json/'.$_SERVER['REMOTE_ADDR']));
	// pre($result);

	// $json = file_get_contents('https://geoip-db.com/json');
	// $data = json_decode($json);
	// print $data->country_code . '<br>';
	// print $data->country_name . '<br>';
	// print $data->state . '<br>';
	// print $data->city . '<br>';
	// print $data->postal . '<br>';
	// print $data->latitude . '<br>';
	// print $data->longitude . '<br>';
	// print $data->IPv4 . '<br>';

	function get_list_country_by_ip()
	{
		$input = [];
		$input['where'] = ['country_name' => ''];
		$listIp = $this->visit_model->get_list($input);
		foreach ($listIp as $row) {
			$infoIp = $this->_get_country_by_ip($row->ip_address);
			$data = ['country_name' => $infoIp->city . ' - ' . $infoIp->country_name];
			if ($infoIp->city != 'Not found' && $infoIp->country_name != 'Not found') {
				$this->visit_model->update($row->id, $data);
			}
		}
	}
	function _get_country_by_ip($IP = 0)
	{
		$json = file_get_contents('https://geoip-db.com/json/b79ee800-367c-11e9-b4fb-6fd4ad33c695/' . $IP);
		return json_decode($json);
	}
}
