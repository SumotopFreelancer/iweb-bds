<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Order extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('products_model');
		$this->load->model('transaction_model');
		$this->load->model('order_model');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->data['message'] = $this->session->flashdata('message');
		$this->form_validation->set_error_delimiters('', '');
		$this->data['styleCart'] = '<link rel="stylesheet" href="' . public_url("dist/styles/cart.css") . '">';
		// Load setup
		$this->setPage = $this->setup_model->get_setup(['nganhang', 'cartdone', 'company', 'emailorder']);
	}
	function checkout()
	{
		$cart = $this->cart->contents();
		$this->data['cart'] = $cart;
		if ($this->cart->total_items() <= 0) {
			redirect('cart');
		}
		$tonghoadon = 0;
		foreach ($cart as $row) {
			$tonghoadon += $row['subtotal'];
		}
		if ($this->input->post()) {
			$this->form_validation->set_rules('name', 'Họ và tên', 'required');
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
			$this->form_validation->set_rules('phone', 'Số điện thoại', 'required|numeric');
			$this->form_validation->set_rules('address', 'Địa chỉ', 'required');
			if ($this->form_validation->run()) {
				$user_name = $this->input->post('name', TRUE);
				$user_email = $this->input->post('email', TRUE);
				$user_phone = $this->input->post('phone', TRUE);
				$user_address = $this->input->post('address', TRUE);
				$payment = $this->input->post('payment', TRUE);

				$other_name = $this->input->post('other_name', TRUE);
				$other_email = $this->input->post('other_email', TRUE);
				$other_phone = $this->input->post('other_phone', TRUE);
				$other_address = $this->input->post('other_address', TRUE);

				$company_name = $this->input->post('company_name', TRUE);
				$company_email = $this->input->post('company_email', TRUE);
				$company_address = $this->input->post('company_address', TRUE);
				$company_mst = $this->input->post('company_mst', TRUE);

				$message = $this->input->post('message', TRUE);

				$data = [
					'user_name' => $user_name,
					'user_email' => $user_email,
					'user_phone' => $user_phone,
					'user_address' => $user_address,
					'other_name' => $other_name,
					'other_email' => $other_email,
					'other_phone' => $other_phone,
					'other_address' => $other_address,
					'company_name' => $company_name,
					'company_email' => $company_email,
					'company_address' => $company_address,
					'company_mst' => $company_mst,
					'payment' => $payment,
					'message' => $message,
					'status' => 1,
					'amount' => $tonghoadon,
					'created' => now(),
				];
				$this->session->set_userdata($data);
				$noidung = $this->load->view('site/emails/order', $data, TRUE);
				// Gui mail cho Hệ thống
				$this->email->initialize(config_send_mail());
				$this->email->from(base_url(), isJson($this->setPage->company)->tenquocte);
				$this->email->to($this->setPage->emailorder);
				$this->email->subject(isJson($this->setPage->company)->tenquocte);
				$this->email->message($noidung);
				$this->email->send();
				// Thêm đơn hàng vào data
				$this->transaction_model->create($data);
				$transaction_id = $this->db->insert_id();
				foreach ($cart as $row) {
					$data = [
						'transaction_id' => $transaction_id,
						'product_id' => $row['id'],
						'product_name' => $row['name'],
						'price' => $row['price'],
						'qty' => $row['qty'],
						'amount' => $row['subtotal']
					];
					$this->order_model->create($data);
				}
				// // Gửi email cho khách hàng
				// $this->email->initialize(config_send_mail());
				// $this->email->from(base_url(), isJson($this->setPage->company)->tenquocte);
				// $this->email->to($user_email);
				// $this->email->subject(isJson($this->setPage->company)->tenquocte);
				// $this->email->message($tongnoidung);
				// $this->email->send();
				redirect(base_url('dat-hang-thanh-cong'));
			}
		}
		// SEO =================================================
		$this->data['url'] = base_url('thong-tin-thanh-toan');
		$this->data['title'] = val_seo('', 'Thông tin thanh toán');
		$this->data['description'] = val_seo('', 'Thông tin thanh toán');
		$this->data['keywords'] = val_seo('', 'Thông tin thanh toán');
		// Breadcrumb
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add('Giỏ hàng', base_url('gio-hang'));
		$this->mybreadcrumb->add('Thông tin thanh toán', base_url('thong-tin-thanh-toan'));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/order/checkout';
		$this->load->view('site/layout', $this->data);
	}
	function cartdone()
	{
		$thongtindone = [
			'user_name' => $this->session->userdata("user_name"),
			'user_email' => $this->session->userdata("user_email"),
			'user_phone' => $this->session->userdata("user_phone"),
			'user_address' => $this->session->userdata("user_address"),
			'other_name' => $this->session->userdata("other_name"),
			'other_email' => $this->session->userdata("other_email"),
			'other_phone' => $this->session->userdata("other_phone"),
			'other_address' => $this->session->userdata("other_address"),
			'company_name' => $this->session->userdata("company_name"),
			'company_email' => $this->session->userdata("company_email"),
			'company_address' => $this->session->userdata("company_address"),
			'company_mst' => $this->session->userdata("company_mst"),
			'payment' => $this->session->userdata("payment"),
			'message' => $this->session->userdata("message"),
			'created' => $this->session->userdata("created"),
		];
		$this->data['done'] = $thongtindone;
		// SEO =================================================
		$this->data['url'] = base_url('dat-hang-thanh-cong');
		$this->data['title'] = val_seo('', 'Đặt hàng thành công');
		$this->data['description'] = val_seo('', 'Đặt hàng thành công');
		$this->data['keywords'] = val_seo('', 'Đặt hàng thành công');
		// Breadcrumb
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add('Đặt hàng thành công', base_url('dat-hang-thanh-cong'));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// Cart
		$cart = $this->cart->contents();
		$this->data['cart'] = $cart;
		if ($this->cart->total_items() <= 0) {
			redirect(base_url('cart'));
		}
		$this->cart->destroy();
		// View
		$this->data['temp'] = 'site/order/cartdone';
		$this->load->view('site/layout', $this->data);
	}
}
