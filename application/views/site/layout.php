<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="vi">

<head>
	<?php $this->load->view('site/head', $this->data) ?>
	<?= $setAll->script_head ?>
</head>

<body>
	<?= $setAll->script_body ?>
	<div class="wrapper">
		<?php $this->load->view('site/header', $this->data) ?>
		<?php $this->load->view($temp, $this->data) ?>
		<?php $this->load->view('site/footer', $this->data) ?>
		<?php $this->load->view('site/script') ?>
	</div>
	<?= $setAll->script_footer ?>
</body>

</html>