<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
	<title><?= $infosetting->tencongty ?></title>
	<meta charset="utf-8">
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style type="text/css">
		.rboder td {
			border-top: 0px !important;
		}
	</style>
</head>

<body>
	<header>
		<div class="container" style="background: rgba(233, 30, 99, 0.11);">
			<table class="table rboder">
				<tbody>
					<tr>
						<td>
							<p><span style="font-weight:bold;"><?= $infosetting->tencongty ?></span></p>
						</td>
					</tr>
					<tr>
						<td>
							<p>Địa chỉ: <span style="font-weight:bold;"><?= $infosetting->diachi ?></span></p>
						</td>
					</tr>
					<?php if ($infosetting->mst) : ?>
						<tr>
							<td>
								<p>Mã số thuế: <span style="font-weight:bold;"><?= $infosetting->mst ?></span></p>
							</td>
						</tr>
					<?php endif; ?>
					<tr>
						<td>
							<p>Hotline: <span style="font-weight:bold;"><?= $infosetting->sdt ?></span></p>
						</td>
					</tr>
					<tr>
						<td>
							<p>Email: <span style="font-weight:bold;"><?= $infosetting->email ?></span></p>
						</td>
					</tr>
					<tr>
						<td>
							<p>Website: <span style="font-weight:bold;"><?= $infosetting->website ?></span></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</header>
	<hr>
	<div class="container" style="background: rgba(233, 30, 99, 0.11);">
		<div class="row">
			<h2 class="text-center">HÓA ĐƠN BÁN HÀNG</h2>
		</div>
		<table class="table rboder hoadon">
			<tbody>
				<tr>
					<td>
						<p style="padding-bottom: 15px; font-weight: bold;">THÔNG TIN KHÁCH HÀNG</p>
						<p>Khách hàng: <span style="font-weight:bold;"><?= $donhang->user_name ?></span></p>
						<p>Email khách hàng: <span style="font-weight:bold;"><?= $donhang->user_email ?></span></p>
						<p>Số điện thoại: <span style="font-weight:bold;"><?= $donhang->user_phone ?></span></p>
						<p>Địa chỉ: <span style="font-weight:bold;"><?= $donhang->user_diachi ?></span></p>
						<p style="padding-top: 15px !important;">Hình thức thanh toán: <span style="font-weight:bold;">COD</span></p>
						<p>Ngày đặt hàng: <span style="font-weight:bold;"><?= get_date($donhang->created) ?></span></p>
						<p>Ngày lập hóa đơn: <span style="font-weight:bold;"><?= get_date(now()) ?></span></p>
					</td>
					<?php if ($donhang->other_name || $donhang->other_email || $donhang->other_phone || $donhang->other_diachi) : ?>
						<td>
							<p style="padding-bottom: 15px; font-weight: bold;">THÔNG TIN NGƯỜI NHẬN HÀNG</p>
							<?php if ($donhang->other_name) : ?>
								<p>Người nhận: <span style="font-weight:bold;"><?= $donhang->other_name ?></span></p>
							<?php endif; ?>
							<?php if ($donhang->other_email) : ?>
								<p>Email người nhận: <span style="font-weight:bold;"><?= $donhang->other_email ?></span></p>
							<?php endif; ?>
							<?php if ($donhang->other_phone) : ?>
								<p>Số điện thoại người nhận: <span style="font-weight:bold;"><?= $donhang->other_phone ?></span></p>
							<?php endif; ?>
							<?php if ($donhang->other_diachi) : ?>
								<p>Địa chỉ người nhận: <span style="font-weight:bold;"><?= $donhang->other_diachi ?></span></p>
							<?php endif; ?>
						</td>
					<?php endif; ?>
				</tr>
			</tbody>
		</table>
		<div class="col-lg-12">
			<?php if ($donhang->message) : ?>
				<p>Lưu ý: <span style="color:red;"><?= $donhang->message ?></span></p>
			<?php endif ?>
		</div>
		<table class="table">
			<thead>
				<tr>
					<th>Hình ảnh</th>
					<th>Tên sản phẩm</th>
					<th>Đơn giá</th>
					<th>Số lượng</th>
					<th style="text-align: right;">Tổng tiền</th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($chitietdonhang) & $chitietdonhang) : ?>
					<?php foreach ($chitietdonhang as $row) : ?>
						<?php if ($this->product_model->get_info($row->product_id)) : ?>
							<tr>
								<td style="width: 80px"><img style="width: 80px; padding-right: 10px;" src="<?= base_url('uploads/images/products-images/' . $this->product_model->get_info($row->product_id)->image_link) ?>"></td>
								<td><?= $this->product_model->get_info($row->product_id)->name ?></td>
								<?php
								$gia = $this->product_model->get_info($row->product_id)->price;
								$discount = $this->product_model->get_info($row->product_id)->discount;
								?>
								<td>
									<p>
										<?php if ($gia == 0) : ?>
											<span style="font-size:14px ;color: red; font-weight: 600">Liên hệ</span>
										<?php elseif ($discount == 0) : ?>
											<span style="font-size:14px ;color: red; font-weight: 600"><?= number_format($gia) ?>đ</span>
										<?php else : ?>
											<?php
											$giamgia = $gia - $discount;
											?>
											<span style="font-size:14px ;color: red; font-weight: 600"><?= number_format($giamgia) ?>đ</span>
											<span style="color: #777;margin-left: 20px ;text-decoration: line-through;"><?= number_format($gia) ?>đ</span>
										<?php endif; ?>
									</p>
								</td>
								<td>
									<p><?= $row->qty; ?></p>
								</td>
								<td style="text-align: right;">
									<p><?= number_format($row->amount); ?>đ</p>
								</td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
				<tr>
					<td><button class="btn btn-success" onclick="this.style.display ='none';window.print()">In Hóa Đơn</button></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align: right;">
						<p>Tổng hóa đơn: <span style="font-weight:bold;"><?= number_format($donhang->amount) ?></span> đ</p>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
<style type="text/css">
	.hoadon tr td {
		padding: 0 10px !important;
	}
</style>

</html>