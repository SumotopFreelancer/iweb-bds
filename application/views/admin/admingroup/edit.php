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
    <li class="active">Chỉnh sửa</li>
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
        <div class="col-md-8">
          <div class="form-group">
            <label>Tên <span class="label label-danger">(Bắt buộc) <?= form_error('name') ?></span></label>
            <input type="text" name="name" value="<?= htmlentities($info->name) ?>" class="form-control" placeholder="Nhập tên">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Thứ tự</label>
            <input type="number" class="form-control" name="sort_order" placeholder="STT" value="<?= $info->sort_order ?>">
          </div>
        </div>
        <div class="check_cus add-nhomquyen">
          <div class="col-lg-12">
            <div class="form-group">
              <label>Chọn nhóm quyền <span class="label label-danger">(Bắt buộc) <?= form_error('quyen[]') ?></span></label>
            </div>
          </div>
          <?php foreach ($list_quyen as $controller => $actions) : ?>
            <?php
            $item_quyen = [];
            if (isset($info->permissions->{$controller})) {
              $item_quyen = $info->permissions->{$controller};
            }
            ?>
            <div class="col-lg-12 col-md-12 parentcheck">
              <button type="button" class="btn btn-default btn-sm checkbox-add checkbcu">
                <i class="fa <?= (isset($info->permissions->{$controller})) ? 'fa-check-square' : 'fa-square-o' ?>"></i>
              </button><?= convert_name_quyen($controller) ?>
              <div class="item-quyen">
                <?php foreach ($actions as $item) : ?>
                  <input type="checkbox" class="checkbcu" name="quyen[<?= $controller ?>][]" value="<?= $item ?>" <?= in_array($item, $item_quyen) ? 'checked' : '' ?>><span class="name_quyen"><?= convert_name_quyen($item) ?></span>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="box-footer clearfix">
        <button type="submit" value="Lưu & thoát" name="cus_btn_save" class="btn btn-danger"><i class="fa fa-external-link"></i> Lưu & thoát</button>
        <button type="submit" value="Lưu lại" name="cus_btn_save" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
      </div>
    </div>
  </form>
</section>