<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Nhóm quyền
    <a href="<?= admin_url('admingroup/add') ?>" class="btn btn-success btn-flat">
      <i class="fa fa-plus-circle"></i> Thêm mới
    </a>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li><a href="<?= admin_url('admingroup') ?>">Danh sách</a></li>
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
        <div class="col-md-8">
          <div class="form-group">
            <label>Tên <span class="label label-danger">(Bắt buộc) <?= form_error('name') ?></span></label>
            <input type="text" name="name" value="<?= set_value('name') ?>" class="form-control" placeholder="Nhập tên">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Thứ tự</label>
            <input type="number" class="form-control" name="sort_order" placeholder="STT" value="<?= set_value('sort_order') ?>">
          </div>
        </div>
        <div class="check_cus add-nhomquyen">
          <div class="col-lg-12">
            <div class="form-group">
              <label>Chọn nhóm quyền <span class="label label-danger">(Bắt buộc) <?= form_error('quyen[]') ?></span></label>
            </div>
          </div>
          <?php foreach ($list_quyen as $controller => $actions) : ?>
            <div class="col-lg-12 col-md-12 parentcheck">
              <button type="button" class="btn btn-default btn-sm checkbox-add checkbcu"><i class="fa fa-square-o"></i></button><b><?= convert_name_quyen($controller) ?></b>
              <div class="item-quyen">
                <?php foreach ($actions as $item) : ?>
                  <input type="checkbox" class="checkbcu" name="quyen[<?= $controller ?>][]" value="<?= $item ?>"><span class="name_quyen"><?= convert_name_quyen($item) ?></span>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="box-footer clearfix">
        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
      </div>
    </div>
  </form>
</section>