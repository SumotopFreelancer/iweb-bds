<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Quản lý đơn hàng</h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li class="active">Đơn hàng</li>
  </ol>
</section>
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Danh sách</h3> (<?= $total_rows ?>)
    </div>
    <?php $this->load->view('admin/message', $this->data); ?>
    <div class="msg"></div>
    <div class="box-body table-responsive no-padding mailbox-messages">
      <table class="table table-hover">
        <form method="GET" action="<?= admin_url('order') ?>">
          <tr>
            <th style="width: 30%">
              <div class="input-group">
                <span class="input-group-addon">Mã</span>
                <input name="id" value="<?= $this->input->get('id') ?>" type="text" class="form-control">
              </div>
            </th>
            <th style="width: 30%">
              <div class="input-group">
                <span class="input-group-addon">Tên</span>
                <input name="user_name" value="<?= $this->input->get('user_name') ?>" type="text" class="form-control">
              </div>
            </th>
            <th style="width: 30%">
              <div class="form-group">
                <select name="status" class="form-control select2" style="width: 100%;">
                  <option value="-1" <?= ($this->input->get('status') == -1) ? 'selected' : '' ?>>Chọn tình trạng</option>
                  <option value="1" <?= ($this->input->get('status') == 1) ? 'selected' : '' ?>>Đang xử lý</option>
                  <option value="2" <?= ($this->input->get('status') == 2) ? 'selected' : '' ?>>Giao hàng thành công</option>
                  <option value="3" <?= ($this->input->get('status') == 3) ? 'selected' : '' ?>>Hủy đơn hàng</option>
                </select>
              </div>
            </th>
            <th class="pull-right">
              <button title="Lọc" class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
              <a href="<?= admin_url('order') ?>" title="Làm mới" class="btn btn-default" type="submit"><i class="fa fa-refresh"></i></a>
            </th>
          </tr>
        </form>
      </table>
      <table class="table table-hover cus_text_mid">
        <tr class="btn-default">
          <th class="cus_td_50">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
          </th>
          <th style="width: 75px" class="text-center">Mã số</th>
          <th style="width: 80px">Ngày tạo</th>
          <th>Thông tin</th>
          <th>Tổng tiền</th>
          <th class="text-center">Trạng thái</th>
          <th class="b-active">Hành động</th>
        </tr>
        <?php foreach ($list as $row) : ?>
          <tr class='row_<?= $row->id ?>'>
            <td class="text-center"><input type="checkbox" name="id[]" value="<?= $row->id; ?>"></td>
            <td>#<?= str_pad($row->id, 6, '0', STR_PAD_LEFT) ?></td>
            <td><?= get_date_admin($row->created) ?></td>
            <td>
              <p><b>Họ và tên: </b><?= $row->user_name; ?></p>
              <p><b>Điện thoại: </b><?= $row->user_phone; ?></p>
              <p><b>Địa chỉ: </b><?= $row->user_address; ?></p>
            </td>
            <td><b><?= number_format($row->amount); ?>đ</b></td>
            <td class="text-center">
              <?php if ($row->status == 1) : ?>
                <span class="label label-warning"><i class="fa fa-spinner"></i> Đang xử lý</span>
              <?php endif ?>
              <?php if ($row->status == 2) : ?><span class="label label-success"><i class="fa fa-check"></i> Giao hàng thành công</span><?php endif ?>
              <?php if ($row->status == 3) : ?><span class="label label-danger"><i class="fa fa-times"></i> Hủy đơn hàng</span><?php endif ?>
            </td>
            <td class="b-active">
              <a href="<?= admin_url('order/edit/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-warning" title="Chỉnh sửa"><i class="fa fa-edit fa-fw"></i></a>
              <a href="<?= admin_url('order/delete/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="box-footer clearfix">
      <button type="button" class="btn btn-sm btn-danger btn_del_all" url="<?= admin_url('order/del_all') ?>">Xóa hết</button>
      <?= $phantrang ?>
    </div>
  </div>
</section>