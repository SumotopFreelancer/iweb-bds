<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image"><img src="<?= public_url('admin/img/user2-160x160.jpg') ?>" class="img-circle"></div>
      <div class="pull-left info">
        <p><?= $userinfo->name; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <?php if ($userinfo->type != $admin_root->type) : ?>
      <?php $this->load->view('admin/menuleftadmin'); ?>
    <?php else : ?>
      <?php $this->load->view('admin/menuleftroot'); ?>
    <?php endif; ?>
  </section>
</aside>