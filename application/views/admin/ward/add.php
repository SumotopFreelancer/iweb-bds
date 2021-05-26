<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Phường
    <a href="<?= admin_url('ward/add') ?>" class="btn btn-success btn-flat">
      <i class="fa fa-plus-circle"></i> Thêm mới
    </a>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li><a href="<?= admin_url('ward') ?>">Phường</a></li>
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
          <div class="col-md-3">
            <div class="form-group">
              <label>Tên <span class="label label-danger">(Bắt buộc) <?= form_error('name') ?></span></label>
              <input type="text" name="name" value="<?= set_value('name') ?>" class="form-control" placeholder="Nhập tên">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Quận <span class="label label-danger">(Bắt buộc) <?= form_error('district_id') ?></span></label>
              <select name="district_id" class="form-control select2" style="width: 100%;">
                <option value="">Chọn quận</option>
                <?php if (!empty($districts)) : ?>
                  <?php foreach ($districts as $row) : ?>
                    <option <?= set_select('district_id', $row->id) ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Sidebar</label>
              <select class="form-control" name="sidebar">
                <option value="0" <?= set_select('sidebar', 0) ?>>Không</option>
                <option value="1" <?= set_select('sidebar', 1) ?>>Có</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
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