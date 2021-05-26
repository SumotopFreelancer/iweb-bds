<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Khách hàng đặt hàng tại <?= base_url() ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
	<table width="500px" style="width: 500px; margin: auto; border-collapse: collapse; border: 1px solid #ddd; color: #000">
		<tr>
			<td colspan="3" style="padding: 0 15px; line-height: 1.8">
				<h2 style="color: #000; margin-bottom: 5px;">THÔNG TIN ĐƠN HÀNG</h2>
				<div style="color: #000"><b style="color: #000">Khách hàng:</b> <?= $user_name ?></div>
				<div style="color: #000"><b style="color: #000">Số điện thoại:</b> <?= $user_phone ?></div>
				<div style="color: #000"><b style="color: #000">Email:</b> <?= $user_email ?></div>
				<div style="color: #000"><b style="color: #000">Địa chỉ:</b> <?= $user_address ?></div>
				<div style="color: #000"><b style="color: #000">Ngày đặt:</b> <?= get_date_admin(now()) ?></div>
				<?php if ($other_name || $other_phone || $other_email || $other_address) : ?>
					<h2 style="color: #000; margin-bottom: 5px;">THÔNG TIN NHẬN HÀNG</h2>
					<?php if ($other_name) : ?>
						<div style="color: #000"><b style="color: #000">Người nhận:</b> <?= $other_name ?></div>
					<?php endif; ?>
					<?php if ($other_phone) : ?>
						<div style="color: #000"><b style="color: #000">Số điện thoại:</b> <?= $other_phone ?></div>
					<?php endif; ?>
					<?php if ($other_email) : ?>
						<div style="color: #000"><b style="color: #000">Email:</b> <?= $other_email ?></div>
					<?php endif; ?>
					<?php if ($other_address) : ?>
						<div style="color: #000"><b style="color: #000">Địa chỉ:</b> <?= $other_address ?></div>
					<?php endif; ?>
				<?php endif; ?>
				<?php if ($company_name || $company_email || $company_address || $company_mst) : ?>
					<h2 style="color: #000; margin-bottom: 5px;">THÔNG TIN XUẤT HÓA ĐƠN</h2>
					<?php if ($company_name) : ?>
						<div style="color: #000"><b style="color: #000">Công ty:</b> <?= $company_name ?></div>
					<?php endif; ?>
					<?php if ($company_email) : ?>
						<div style="color: #000"><b style="color: #000">Email:</b> <?= $company_email ?></div>
					<?php endif; ?>
					<?php if ($company_address) : ?>
						<div style="color: #000"><b style="color: #000">Địa chỉ:</b> <?= $company_address ?></div>
					<?php endif; ?>
					<?php if ($company_mst) : ?>
						<div style="color: #000"><b style="color: #000">Mã số thuế:</b> <?= $company_mst ?></div>
					<?php endif; ?>
				<?php endif; ?>
				<?php if ($payment) : ?>
					<h2 style="color: #000; margin-bottom: 5px;">PHƯƠNG THỨC THANH TOÁN</h2>
					<div style="color: #000"><b style="color: #000"><?= $payment ?></b></div>
				<?php endif; ?>
				<?php if ($message) : ?>
					<h2 style="color: #000; margin-bottom: 5px;">GHI CHÚ</h2>
					<div style="color: #000"><?= $message ?></div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td colspan="3"><br /></td>
		</tr>
		<tr>
			<td colspan="3" style="text-align: center; border: 1px solid #ddd;">
				<h2 style="color: #000">SẢN PHẨM ĐÃ ĐẶT</h2>
			</td>
		</tr>
		<?php
		$cart = $this->cart->contents();
		$tonghoadon = 0;
		?>
		<?php if (isset($cart) && $cart) : ?>
			<?php foreach ($cart as $row) : ?>
				<?php $tonghoadon += $row['subtotal']; ?>
				<tr>
					<td style="border: 1px solid #ddd; padding: 5px">
						<div><a href="<?= base_url($row['url']) ?>"><?= $row['name'] ?></a></div>
					</td>
					<td style="border: 1px solid #ddd; padding: 5px; width: 30px; text-align: center;">
						<?= $row['qty'] ?>
					</td>
					<td style="border: 1px solid #ddd; padding: 5px; width: 90px; text-align: right;">
						<?= number_format($row['subtotal']) ?> <b><?= _unit ?></b>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		<tr>
			<td colspan="3" style="border:1px solid #ddd;padding:5px; text-align: right;">
				<h3 style="margin: 5px 0"><small>Tổng hóa đơn: </small><?= number_format($tonghoadon) ?><b><?= _unit ?></b></h3>
			</td>
		</tr>
	</table>
</body>

</html>