<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
	<h1>Thống kê truy cập</h1>
	<ol class="breadcrumb">
		<li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
		<li class="active">Thống kê truy cập</li>
	</ol>
</section>
<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Tổng truy cập <small>Thực tế</small></h3> (<?= $total_rows ?>)
		</div>
		<?php $this->load->view('admin/message', $this->data); ?>
		<div class="msg"></div>
		<div class="box-body table-responsive no-padding mailbox-messages">
			<table class="table table-hover cus_text_mid">
				<tr class="btn-default">
					<th class="cus_td_50">
						<button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
					</th>
					<th class="cus_td_50">STT</th>
					<th>Ngày truy cập</th>
					<th>IP Address</th>
					<th>Quốc gia <button href="javascript:;" id="update_country" class="btn btn-sm btn-social-icon btn-primary" title="Cập nhật quốc gia"><i class="fa fa-retweet fa-fw"></i></button></th>
					<th class="b-active">Hành động</th>
				</tr>
				<?php foreach ($list as $key => $row) : ?>
					<tr class='row_<?= $row->id ?>'>
						<td class="text-center"><input type="checkbox" name="id[]" value="<?= $row->id; ?>"></td>
						<td class="cus_td_50"><?= $key + 1 ?></td>
						<td><?= get_date_admin($row->last_activity) ?></td>
						<td><?= $row->ip_address ?></td>
						<td><?= $row->country_name ? '<span class="label label-success">' . $row->country_name . '<span>' : '<span class="label label-warning">Không xác định<span>' ?></td>
						<td class="b-active">
							<a href="<?= admin_url('visit/delete/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<div class="box-footer clearfix">
			<button type="button" class="btn btn-sm btn-danger btn_del_all" url="<?= admin_url('visit/del_all') ?>">Xóa hết</button>
			<?= $phantrang ?>
		</div>
	</div>>
</section>
<section class="content">
	<form action="" method="POST" id="form">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Thống kê ảo</h3>
			</div>
			<div class="box-body">
				<div class="col-md-20">
					<div class="form-group">
						<label>Online</label>
						<input type="number" name="online" value="<?= isJson($setadmin->visit)->online ?>" class="form-control">
					</div>
				</div>
				<div class="col-md-20">
					<div class="form-group">
						<label>Ngày</label>
						<input type="number" name="day" value="<?= isJson($setadmin->visit)->day ?>" class="form-control">
					</div>
				</div>
				<div class="col-md-20">
					<div class="form-group">
						<label>Tuần</label>
						<input type="number" name="week" value="<?= isJson($setadmin->visit)->week ?>" class="form-control">
					</div>
				</div>
				<div class="col-md-20">
					<div class="form-group">
						<label>Tháng</label>
						<input type="number" name="month" value="<?= isJson($setadmin->visit)->month ?>" class="form-control">
					</div>
				</div>
				<div class="col-md-20">
					<div class="form-group">
						<label>Tổng</label>
						<input type="number" name="total" value="<?= isJson($setadmin->visit)->total ?>" class="form-control">
					</div>
				</div>
			</div>
			<div class="box-footer clearfix">
				<button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
			</div>
		</div>
	</form>
</section>
<script type="text/javascript">
	$("#update_country").click(function() {
		$.ajax({
			type: "post",
			url: "<?= admin_url('visit/get_list_country_by_ip') ?>",
			beforeSend: function() {
				$('#update_country').attr("disabled", true);
				$('#update_country').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>');
			},
			data: {},
			success: function(data) {
				location.reload();
			}
		});
	});
</script>