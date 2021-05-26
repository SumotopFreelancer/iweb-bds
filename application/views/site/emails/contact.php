<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Khách hàng gửi liên hệ</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
	<table width="500px">
		<tr>
			<td colspan="2"><?= base_url() ?></td>
		</tr>
		<tr>
			<td width="100px">Họ và tên: </td>
			<td><?= $name ?></td>
		</tr>
		<tr>
			<td>Điện thoại: </td>
			<td><?= $phone ?></td>
		</tr>
		<tr>
			<td>Email: </td>
			<td><?= $email ?></td>
		</tr>
		<tr>
			<td>Ghi chú: </td>
			<td><?= $content ?></td>
		</tr>
	</table>
</body>

</html>