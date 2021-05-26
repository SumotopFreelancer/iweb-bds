<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('contact_model');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('captcha');
		$this->form_validation->set_error_delimiters('', '');
		$message = $this->session->flashdata('message');
		$this->data['message'] = $message;
		// Load setup
		$this->setPage = $this->setup_model->get_setup(['seo_contact', 'map', 'content_contact', 'company', 'emailnhan']);
	}
	public function index()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Họ và tên', 'required');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'required|numeric');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
			$this->form_validation->set_rules('captcha', 'Captcha', 'callback_validation_captcha');
			// khi nhap lieu chinh xac
			if ($this->form_validation->run()) {
				$data = [
					'name' => $this->input->post('name', TRUE),
					'phone' => $this->input->post('phone', TRUE),
					'email' => $this->input->post('email', TRUE),
					'address' => $this->input->post('address', TRUE),
					'content' => $this->input->post('content', TRUE),
					'created' => now()
				];
				$noidung = $this->load->view('site/emails/contact', $data, TRUE);

				$this->email->initialize(config_send_mail());
				$this->email->from($this->input->post('email', TRUE), isJson($this->setPage->company)->tenquocte);
				$this->email->to($this->setPage->emailnhan);
				$this->email->subject(isJson($this->setPage->company)->tenquocte);
				$this->email->message($noidung);

				if ($this->contact_model->create($data)) {
					if ($this->email->send()) {
						$this->session->set_flashdata('message', '<div class="alert alert-success"><strong>' . isJson($this->setPage->content_contact)->success . '</strong></div>');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger"><strong>Failed to send, try again later</strong></div>');
				}
				redirect(base_url('lien-he'));
			}
		}
		// Data
		$this->data['contact'] = (object) [
			'map' => $this->setPage->map,
			'title' => isJson($this->setPage->content_contact)->title,
			'info' => isJson($this->setPage->content_contact)->info
		];
		// SEO =================================================
		$this->data['url'] = base_url('lien-he');
		$this->data['title'] = val_seo(isJson($this->setPage->seo_contact)->title, 'Liên hệ');
		$this->data['description'] = val_seo(isJson($this->setPage->seo_contact)->description, 'Liên hệ');
		$this->data['keywords'] = val_seo(isJson($this->setPage->seo_contact)->keyword, 'Liên hệ');
		$this->data['image_seo'] = val_img_seo(isJson($this->setPage->seo_contact)->image_link, '');
		// Breadcrumb =========================================
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add(isJson($this->setPage->content_contact)->title, base_url('lien-he'));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();

		$vals = [
			'img_path' => './uploads/captcha/',
			'img_url' => base_url('uploads/captcha/'),
			'img_width' => 180,
			'img_height' => 40,
			'expiration' => 0,
			'word_length' => 6,
			'font_size' => 25,
			'pool' => '0123456789',
			'img_id' => 'Imageid',
		];
		$captcha = create_captcha($vals);
		$this->session->set_userdata('captcha', $captcha);

		$this->data['temp'] = 'site/contact/index';
		$this->load->view('site/layout', $this->data);
	}
	function validation_captcha()
	{
		$post_captcha = $this->input->post('captcha');
		$sess_captcha = $this->session->userdata('captcha');
		$word_captcha = $sess_captcha['word'];
		if ($post_captcha == $word_captcha) {
			return true;
		}
		$this->form_validation->set_message(__FUNCTION__, 'Mã xác nhận không chính xác');
		return false;
	}
	function contact_phone()
	{
		$result = [
			'status' => -1,
			'messenger' => 'Truy cập không cho phép'
		];
		if ($this->input->post()) {
			$this->load->model('contactphone_model');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'required|numeric');
			if ($this->form_validation->run() == FALSE) {
				$this->form_validation->set_error_delimiters('<div class="alert alert-danger py-1 text-xs mb-1">', '</div>');
				$result = [
					'status' => 0,
					'messenger' => 'Không tìm thấy dữ liệu!',
					'error' => validation_errors()
				];
			} else {
				$data = [
					'phone' => $this->input->post('phone', TRUE),
					'created' => now()
				];
				$noidung = $this->load->view('site/emails/phone', $data, TRUE);
				$this->email->initialize(config_send_mail());
				$this->email->from(base_url(), isJson($this->setPage->company)->tenquocte);
				$this->email->to($this->setPage->emailnhan);
				$this->email->subject(isJson($this->setPage->company)->tenquocte);
				$this->email->message($noidung);
				$this->contactphone_model->create($data);
				$this->email->send();
				$result = [
					'status' => 1,
					'messenger' => '<div class="alert alert-success py-1 text-xs mb-15 text-center"><i class="fas fa-check mr-2"></i>Gửi thông tin thành công</div>'
				];
			}
		}
		echo json_encode($result);
	}
	function contact_email()
	{
		$result = [
			'status' => -1,
			'messenger' => 'Truy cập không cho phép'
		];
		$this->load->model('contactemail_model');
		if ($this->input->post()) {
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			if ($this->form_validation->run() == FALSE) {
				$this->form_validation->set_error_delimiters('<div class="result text-danger">', '</div>');
				$result = [
					'status' => 0,
					'messenger' => 'Không tìm thấy dữ liệu!',
					'error' => validation_errors()
				];
			} else {
				$data = [
					'email' => $this->input->post('email', TRUE),
					'created' => now()
				];
				$noidung = $this->load->view('site/emails/email', $data, TRUE);
				$this->email->initialize(config_send_mail());
				$this->email->from($this->input->post('email', TRUE), isJson($this->setPage->company)->tenquocte);
				$this->email->to($this->setPage->emailnhan);
				$this->email->subject(isJson($this->setPage->company)->tenquocte);
				$this->email->message($noidung);
				$this->contactemail_model->create($data);
				$this->email->send();
				$result = [
					'status' => 1,
					'messenger' => '<div class="result text-success">Gửi thông tin thành công</div>'
				];
			}
		}
		echo json_encode($result);
	}
	function contact_view()
	{
		$result = [
			'status' => -1,
			'messenger' => 'Truy cập không cho phép'
		];
		$this->load->model('contactview_model');
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Họ và tên', 'required');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'required');
			if ($this->form_validation->run() == FALSE) {
				$this->form_validation->set_error_delimiters('<div class="result text-danger">', '</div>');
				$result = [
					'status' => 0,
					'messenger' => 'Không tìm thấy dữ liệu!',
					'error' => validation_errors()
				];
			} else {
				$data = [
					'name' => $this->input->post('name', TRUE),
					'phone' => $this->input->post('phone', TRUE),
					'link' => $this->input->post('link', TRUE),
					'created' => now()
				];
				$noidung = $this->load->view('site/emails/contactview', $data, TRUE);
				$this->email->initialize(config_send_mail());
				$this->email->from(base_url(), isJson($this->setPage->company)->tenquocte);
				$this->email->to($this->setPage->emailnhan);
				$this->email->subject(isJson($this->setPage->company)->tenquocte);
				$this->email->message($noidung);
				$this->contactview_model->create($data);
				$this->email->send();
				$result = [
					'status' => 1,
					'messenger' => '<div class="result text-success">' . $this->sidebarReg->success . '</div>'
				];
			}
		}
		echo json_encode($result);
	}
	function contact_footer()
	{
		redirect();
		$this->load->model('contactfooter_model');
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Họ và tên', 'required');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'required|numeric');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
			if ($this->form_validation->run() == FALSE) {
				$errors = $this->form_validation->error_array();
				echo json_encode($errors);
			} else {
				$data = [
					'name' => $this->input->post('name', TRUE),
					'phone' => $this->input->post('phone', TRUE),
					'email' => $this->input->post('email', TRUE),
					'link' => $this->input->post('link', TRUE),
					'created' => now()
				];
				$noidung = $this->load->view('site/emails/footer', $data, TRUE);
				$this->email->initialize(config_send_mail());
				$this->email->from("WEBSITE", isJson($this->setPage->company)->tenquocte);
				$this->email->to($this->setPage->emailnhan);
				$this->email->subject(isJson($this->setPage->company)->tenquocte);
				$this->email->message($noidung);
				$this->contactfooter_model->create($data);
				$this->email->send();
				echo 1;
			}
		}
	}
}
