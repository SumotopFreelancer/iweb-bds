<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Khoảng giá
    <a href="<?= admin_url('price/add') ?>" class="btn btn-success btn-flat">
      <i class="fa fa-plus-circle"></i> Thêm mới
    </a>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li><a href="<?= admin_url('price') ?>">Khoảng giá</a></li>
    <li class="active">Thêm mới</li>
  </ol>
</section>
<section class="content">
  <form action="" method="POST" id="form">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Nội dung</h3>
      </div>
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label>Từ (tỷ) <span class="label label-danger">(Bắt buộc) <?= form_error('price_from') ?></span></label>
              <input type="text" name="price_from" value="<?= set_value('price_from') ?>" class="form-control" placeholder="0" data-format_price>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Đến (tỷ) <span class="label label-danger">(Bắt buộc) <?= form_error('price_to') ?></span></label>
              <input type="text" name="price_to" value="<?= set_value('price_to') ?>" class="form-control" placeholder="0" data-format_price>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Thứ tự</label>
              <input type="number" name="sort_order" value="<?= set_value('sort_order') ?>" class="form-control" placeholder="0">
              <span class="cHelp"><?= _help_sort ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="box-footer clearfix">
        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
      </div>
    </div>
  </form>
</section>