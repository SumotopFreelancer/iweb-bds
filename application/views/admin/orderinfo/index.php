<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Cài đặt thêm</h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li class="active">Cài đặt thêm</li>
  </ol>
</section>
<section class="content">
  <form action="" method="POST" id="form">
    <?php $this->load->view('admin/message', $this->data); ?>
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Nội dung</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label>Email nhận đơn hàng <span class="label label-danger">(Bắt buộc) Nhập 1 hoặc nhiều email</span></label>
          <input type="text" name="emailorder" value="<?= $setadmin->emailorder ?>" class="form-control" placeholder="exam1@gmail.com, exam2@gmail.com">
          <span class="cHelp"><?= _help_emailorder ?></span>
        </div>
        <div class="form-group">
          <label>Ngân hàng <a class="cTool" title="<?= _help_nganhang ?>"></a></label>
          <textarea name="nganhang" class="editor"><?= $setadmin->nganhang ?></textarea>
        </div>
        <div class="form-group">
          <label>Thông báo đặt hàng thành công</label>
          <textarea name="cartdone" class="editor"><?= $setadmin->cartdone ?></textarea>
        </div>
      </div>
      <div class="box-footer clearfix">
        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
      </div>
    </div>
  </form>
</section>