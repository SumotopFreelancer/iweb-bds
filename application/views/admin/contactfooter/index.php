<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Khách hàng đặt dịch vụ</h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li class="active">Khách hàng đặt dịch vụ</li>
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
        <form method="GET" action="<?= admin_url('contactfooter') ?>">
          <tr>
            <th style="width: 30%">
              <div class="input-group">
                <span class="input-group-addon">Tên</span>
                <input name="name" value="<?= $this->input->get('name') ?>" type="text" class="form-control">
              </div>
            </th>
            <th style="width: 30%">
              <div class="input-group">
                <div class="input-group-addon">Từ</div>
                <input type="text" class="form-control cus_timer" name="date_from" value="<?= $this->input->get('date_from') ?>">
              </div>
            </th>
            <th style="width: 30%">
              <div class="input-group">
                <div class="input-group-addon">Đến</div>
                <input type="text" class="form-control cus_timer" name="date_to" value="<?= $this->input->get('date_to') ?>">
              </div>
            </th>
            <th class="pull-right">
              <button title="Lọc" class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
              <a href="<?= admin_url('contactfooter') ?>" title="Làm mới" class="btn btn-default" type="submit"><i class="fa fa-refresh"></i></a>
            </th>
          </tr>
        </form>
      </table>
      <table class="table table-hover cus_text_mid">
        <tr class="btn-default">
          <th class="cus_td_50">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
          </th>
          <th class="cus_td_50">STT</th>
          <th>Thông tin khách hàng</th>
          <th>Ngày tạo</th>
          <th class="b-active">Hành động</th>
        </tr>
        <?php foreach ($list as $key => $row) : ?>
          <tr class='row_<?= $row->id ?>'>
            <td class="text-center"><input type="checkbox" name="id[]" value="<?= $row->id; ?>"></td>
            <td class="cus_td_50"><?= $key + 1 ?></td>
            <td>
              <p><b>Họ & tên: </b><?= $row->name ?></p>
              <p><b>Số điện thoại: </b><?= $row->phone ?></p>
              <p><b>Email: </b><?= $row->email ?></p>
              <p><b>Link: </b><?= $row->link ?></p>
            </td>
            <td><?= get_date_admin($row->created) ?></td>
            <td class="b-active">
              <a href="<?= admin_url('contactfooter/delete/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="box-footer clearfix">
      <button type="button" class="btn btn-sm btn-danger btn_del_all" url="<?= admin_url('contactfooter/del_all') ?>">Xóa hết</button>
      <?= $phantrang ?>
    </div>
  </div>
</section>