<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
	<h1>Quản trị viên
		<a href="<?= admin_url('admin/add') ?>" class="btn btn-success btn-flat">
			<i class="fa fa-plus-circle"></i> Thêm mới
		</a>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
		<li><a href="<?= admin_url('admin') ?>">Danh sách</a></li>
		<li class="active">Thêm mới</li>
	</ol>
</section>
<section class="content">
	<form action="" method="POST" id="form">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Nội dung</h3>
			</div>
			<?php $this->load->view('admin/message', $this->data); ?>
			<div class="box-body">
				<div class="col-md-6">
					<div class="form-group">
						<label>Tên đăng nhập <span class="label label-danger">(Bắt buộc) <?= form_error('username') ?></span></label>
						<input type="text" name="username" value="<?= $info->username ?>" class="form-control" placeholder="Nhập tên đăng nhập">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Tên hiển thị <span class="label label-danger">(Bắt buộc) <?= form_error('name') ?></span></label>
						<input type="text" name="name" value="<?= htmlentities($info->name) ?>" class="form-control" placeholder="Nhập tên">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Mật khẩu <span class="label label-danger">(Bắt buộc) <?= form_error('password') ?></span></label>
						<input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Nhập lại mật khẩu <span class="label label-danger">(Bắt buộc) <?= form_error('re_password') ?></span></label>
						<input type="password" name="re_password" class="form-control" placeholder="Nhập lại mật khẩu">
					</div>
				</div>
				<?php if ($info->type != $admin_root->type && $info->id != $userinfo->id) : ?>
					<div class="col-md-6">
						<div class="form-group">
							<label>Quyền</label>
							<select name="admin_group_id" class="form-control select2" style="width: 100%;">
								<?php if (isset($admingroup) && $admingroup) : ?>
									<?php foreach ($admingroup as $row) : ?>
										<option value="<?= $row->id ?>" <?= $row->id == $info->admin_group_id ? 'selected' : '' ?>><?= $row->name ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div class="box-footer clearfix">
				<button type="submit" value="Lưu & thoát" name="cus_btn_save" class="btn btn-danger"><i class="fa fa-external-link"></i> Lưu & thoát</button>
				<button type="submit" value="Lưu lại" name="cus_btn_save" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
			</div>
		</div>
	</form>
</section>