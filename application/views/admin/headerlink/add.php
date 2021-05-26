<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Liên kết tùy chỉnh Header
    <a href="<?= admin_url('headerlink/add') ?>" class="btn btn-success btn-flat">
      <i class="fa fa-plus-circle"></i> Thêm mới
    </a>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li><a href="<?= admin_url('headerlink') ?>">Liên kết tùy chỉnh Header</a></li>
    <li class="active">Thêm mới</li>
  </ol>
</section>
<section class="content">
  <form action="" method="POST" id="form">
    <div class="row">
      <div class="col-md-8">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Nội dung</h3>
          </div>
          <div class="box-body">
            <div class="form-group">
              <label>Tên <span class="label label-danger">(Bắt buộc) <?= form_error('name') ?></span></label>
              <input type="text" name="name" value="<?= set_value('name') ?>" class="form-control" placeholder="Nhập tên">
            </div>
            <div class="form-group">
              <label>Liên kết</label>
              <input type="text" name="link" value="<?= set_value('link') ?>" class="form-control" placeholder="http://">
            </div>
            <div class="form-group">
              <label>Icon</label>
              <input type="text" name="icon" value="<?= set_value('icon') ?>" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Thông tin thêm </h3>
          </div>
          <div class="box-body">
            <div class="form-group">
              <label>Thứ tự</label>
              <input type="number" name="sort_order" value="<?= set_value('sort_order') ?>" class="form-control" placeholder="0">
              <span class="cHelp"><?= _help_sort ?></span>
            </div>
          </div>
          <div class="box-footer clearfix">
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>