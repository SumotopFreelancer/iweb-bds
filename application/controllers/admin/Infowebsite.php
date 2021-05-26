<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Infowebsite extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	function index()
	{
		if ($this->input->post()) {
			$data = [
				'company' => json_encode([
					'tenquocte' => $this->input->post('tenquocte_company', TRUE),
					'tengoitat' => $this->input->post('tengoitat_company', TRUE)
				]),
				'address' => json_encode([
					'address1' => $this->input->post('address1_address', TRUE),
					'address2' => $this->input->post('address2_address', TRUE)
				]),
				'phone' => json_encode([
					'phone1' => $this->input->post('phone1_phone', TRUE),
					'phone2' => $this->input->post('phone2_phone', TRUE)
				]),
				'email' => $this->input->post('email', TRUE),
				'website' => $this->input->post('website', TRUE),
				'map' => $this->input->post('map'),
				'emailnhan' => $this->input->post('emailnhan', TRUE)
			];
			foreach ($data as $key => $row) {
				if ($this->setup_model->update_rule(['col' => $key], ['value' => $row])) {
					$this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
				} else {
					$this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
				}
			}
			redirect(admin_url('infowebsite'));
		}
		$this->data['temp'] = 'admin/infowebsite/index';
		$this->load->view('admin/main', $this->data);
		$this->db->cache_delete_all();
	}
}
