<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('products_model');
		$this->data['styleCart'] = '<link rel="stylesheet" href="' . public_url("dist/styles/cart.css") . '">';
	}
	function index()
	{
		$this->data['cart'] = $this->cart->contents();
		// SEO =================================================
		$this->data['url'] = base_url('gio-hang');
		$this->data['title'] = val_seo('', 'Giỏ hàng');
		$this->data['description'] = val_seo('', 'Giỏ hàng');
		$this->data['keywords'] = val_seo('', 'Giỏ hàng');
		// Breadcrumb
		$this->mybreadcrumb->add('Trang chủ', base_url());
		$this->mybreadcrumb->add('Giỏ hàng', base_url('gio-hang'));
		$this->data['breadcrumb'] = $this->mybreadcrumb->render();
		// View
		$this->data['temp'] = 'site/cart/index';
		$this->load->view('site/layout', $this->data);
	}
	// CART AJAX
	function addajax()
	{
		$result = [
			'status' => -1,
			'messenger' => 'Truy cập không cho phép'
		];
		if ($this->input->post()) {
			$id = $this->input->post('id');
			$product = $this->products_model->get_info($id, 'name, url, image_link as img, price, discount');
			if (!$product) {
				$result = [
					'status' => 99,
					'messenger' => 'Không tìm thấy sản phẩm'
				];
			} else {
				$qty = intval($this->input->post('qty')) > 0 ? intval($this->input->post('qty')) : 1;
				$price = $product->price;
				if ($product->price > 0 && $product->discount > 0 && $product->price > $product->discount) {
					$price = $product->discount;
				}
				$data = [
					'id' => $id,
					'qty' => $qty,
					'name' => $product->name,
					'url' => $product->url,
					'img' => $product->img,
					'price' => $price,
					'discount' => $product->discount,
					'price_goc' => $product->price,
				];
				$this->cart->insert($data);
				$tonghoadon = 0;
				foreach ($this->cart->contents() as $row) {
					$tonghoadon += $row['subtotal'];
				}
				$result = [
					'status' => 1,
					'messenger' => 'Thêm vào giỏ hàng thành công',
					'qty' => $this->cart->total_items()
				];
			}
		}
		echo json_encode($result);
	}
	function updateajax()
	{
		$result = [
			'status' => -1,
			'messenger' => 'Truy cập không cho phép'
		];
		if ($this->input->post()) {
			$this->db->cache_delete_all();
			$proid = $this->input->post('proid');
			$product = $this->products_model->get_info($proid);
			if (!$product) {
				$result = [
					'status' => 99,
					'messenger' => 'Không tìm thấy sản phẩm'
				];
			} else {
				$qty = (intval($this->input->post('qty')) > 0) ? intval($this->input->post('qty')) : 1;
				$rowid = $this->input->post('rowid');
				foreach ($this->cart->contents() as $row) {
					$data = [
						'rowid' => $rowid,
						'qty' => $qty
					];
					$this->cart->update($data);
				}
				$tonghoadon = 0;
				$subtotal = 0;
				foreach ($this->cart->contents() as $row) {
					$tonghoadon += $row['subtotal'];
					if ($row['rowid'] == $rowid) {
						$subtotal = $row['subtotal'];
					}
				}
				$result = [
					'status' => 1,
					'messenger' => 'Chỉnh sửa số lượng thành công',
					'qty' => $this->cart->total_items(),
					'sl' => $qty,
					'subtotal' => number_format($subtotal),
					'total' => number_format($tonghoadon)
				];
			}
		}
		echo json_encode($result);
	}
	function deleteajax()
	{
		$result = [
			'status' => -1,
			'messenger' => 'Truy cập không cho phép'
		];
		if ($this->input->post()) {
			$this->db->cache_delete_all();
			$rowid = $this->input->post('rowid');
			foreach ($this->cart->contents() as $row) {
				$data = [
					'rowid' => $rowid,
					'qty' => 0
				];
				$this->cart->update($data);
			}
			$tonghoadon = 0;
			foreach ($this->cart->contents() as $row) {
				$tonghoadon += $row['subtotal'];
			}
			$result = [
				'status' => 1,
				'messenger' => 'Xóa sản phẩm trong giỏ hàng thành công',
				'qty' => $this->cart->total_items(),
				'total' => number_format($tonghoadon)
			];
		}
		echo json_encode($result);
	}
}
