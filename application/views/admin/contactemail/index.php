<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Khách hàng đăng ký email</h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li class="active">Khách hàng đăng ký email</li>
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
        <form method="GET" action="<?= admin_url('contactemail') ?>">
          <tr>
            <th style="width: 30%">
              <div class="input-group">
                <span class="input-group-addon">Tên</span>
                <input name="email" value="<?= $this->input->get('email') ?>" type="text" class="form-control">
              </div>
            </th>
            <th class="pull-right">
              <button title="Lọc" class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
              <a href="<?= admin_url('contactemail') ?>" title="Làm mới" class="btn btn-default" type="submit"><i class="fa fa-refresh"></i></a>
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
          <th>Email</th>
          <th>Ngày tạo</th>
          <th class="b-active">Hành động</th>
        </tr>
        <?php foreach ($list as $key => $row) : ?>
          <tr class='row_<?= $row->id ?>'>
            <td class="text-center"><input type="checkbox" name="id[]" value="<?= $row->id; ?>"></td>
            <td class="cus_td_50"><?= $key + 1 ?></td>
            <td><?= $row->email ?></td>
            <td><?= get_date_admin($row->created) ?></td>
            <td class="b-active">
              <a href="<?= admin_url('contactemail/delete/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="box-footer clearfix">
      <button type="button" class="btn btn-sm btn-danger btn_del_all" url="<?= admin_url('contactemail/del_all') ?>">Xóa hết</button>
      <?= $phantrang ?>
    </div>
  </div>
</section>