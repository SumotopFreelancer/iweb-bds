<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Cài đặt Script</h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li class="active">Cài đặt Script</li>
  </ol>
</section>
<section class="content">
  <form action="" method="POST" id="form">
    <?php $this->load->view('admin/message', $this->data); ?>
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Script</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <div class="form-group">
          <label>Script Head <a class="cTool" title="<?= _help_script_head ?>"></a></label>
          <textarea name="script_head" rows="20" class="form-control"><?= $setadmin->script_head ?></textarea>
        </div>
        <div class="form-group">
          <label>Script Body <a class="cTool" title="<?= _help_script_body ?>"></a></label>
          <textarea name="script_body" rows="20" class="form-control"><?= $setadmin->script_body ?></textarea>
        </div>
        <div class="form-group">
          <label>Script Footer <a class="cTool" title="<?= _help_script_footer ?>"></a></label>
          <textarea name="script_footer" rows="20" class="form-control"><?= $setadmin->script_footer ?></textarea>
        </div>
      </div>
      <div class="box-footer clearfix">
        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
      </div>
    </div>
  </form>
</section>