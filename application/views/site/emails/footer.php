<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>Khách hàng đăng ký nhận ưu đãi</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
	<table width="500px">
		<tr>
			<td>Họ và tên: </td>
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
	</table>
</body>

</html>