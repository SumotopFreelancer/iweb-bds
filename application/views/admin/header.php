<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<header class="main-header">
  <a href="<?= admin_url() ?>" class="logo">
    <span class="logo-mini"><img src="<?= public_url(_imgWebsiteShort) ?>"></span>
    <span class="logo-lg"><img src="<?= public_url(_imgWebsite) ?>"></span>
  </a>
  <nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"><span class="sr-only">MENU</span></a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li><a href="<?= base_url() ?>" target="_blank"><i class="fa fa-hand-o-right"></i> Website</a></li>
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?= public_url('admin/img/user2-160x160.jpg') ?>" class="user-image">
            <span class="hidden-xs"><?= $userinfo->name; ?></span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="<?= public_url('admin/img/user2-160x160.jpg') ?>" class="img-circle">
              <p><?= $userinfo->name; ?>
                <small>Thành viên từ: <?= get_date_admin($userinfo->created) ?></small>
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?= admin_url('admin/edit/' . $userinfo->id) ?>" class="btn btn-default btn-flat">Tài khoản</a>
              </div>
              <div class="pull-right">
                <a href="<?= admin_url('home/logout') ?>" class="btn btn-default btn-flat">Đăng xuất</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>