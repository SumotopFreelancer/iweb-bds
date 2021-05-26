<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('admin/head'); ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<?php $this->load->view('admin/header'); ?>
		<?php $this->load->view('admin/menuleft'); ?>
		<div class="content-wrapper">
			<?php $this->load->view($temp, $this->data); ?>
		</div>
		<?php $this->load->view('admin/footer'); ?>
		<div class="control-sidebar-bg"></div>
	</div>
	<?php $this->load->view('admin/script'); ?>
</body>

</html>