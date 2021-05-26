<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Tags
    <a href="<?= admin_url('tags/add') ?>" class="btn btn-success btn-flat">
      <i class="fa fa-plus-circle"></i> Thêm mới
    </a>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li class="active">Tags</li>
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
      <table class="table table-hover cus_text_mid">
        <tr class="btn-default">
          <th class="cus_td_50">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
          </th>
          <th class="cus_td_50">STT</th>
          <th>Tên</th>
          <th>Ngày tạo</th>
          <th class="b-active">Hành động</th>
        </tr>
        <?php foreach ($list as $key => $row) : ?>
          <tr class='row_<?= $row->id ?>'>
            <td class="text-center"><input type="checkbox" name="id[]" value="<?= $row->id; ?>"></td>
            <td class="cus_td_50"><?= $key + 1 ?></td>
            <td>
              <a class="text-black line-1" target="_blank" href="<?= site_url(_tags . '/' . $row->url) ?>"><?= $row->name ?></a>
            </td>
            <td><?= get_date_admin($row->created) ?></td>
            <td class="b-active">
              <a href="<?= admin_url('tags/edit/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-warning" title="Chỉnh sửa"><i class="fa fa-edit fa-fw"></i></a>
              <a href="<?= admin_url('tags/delete/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="box-footer clearfix">
      <button type="button" class="btn btn-sm btn-danger btn_del_all" url="<?= admin_url('tags/del_all') ?>">Xóa hết</button>
      <?= $phantrang ?>
    </div>
  </div>
</section>