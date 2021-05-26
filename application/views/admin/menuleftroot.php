<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="header"><a href="<?= admin_url() ?>">BẢNG ĐIỀU KHIỂN</a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-cogs"></i><span>Trang chủ</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?= admin_url('header') ?>">Header</a></li>
            <li><a href="<?= admin_url('menu') ?>">Menu</a></li>
            <li><a href="<?= admin_url('pagehome') ?>">Cấu hình trang chủ</a></li>
            <li><a href="<?= admin_url('footer') ?>">Footer</a></li>
        </ul>
    </li>
    <li><a href="<?= admin_url('pages') ?>"><i class="fa fa-file-text"></i><span>Trang</span></a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-th-large"></i><span>Quản lý dự án</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?= admin_url('products') ?>">Dự án</a></li>
            <li><a href="<?= admin_url('catalog') ?>">Loại dự án</a></li>
            <li><a href="<?= admin_url('district') ?>">Quận</a></li>
            <li><a href="<?= admin_url('ward') ?>">Phường</a></li>
            <li><a href="<?= admin_url('area') ?>">Diện tích</a></li>
            <li><a href="<?= admin_url('direction') ?>">Hướng</a></li>
            <li><a href="<?= admin_url('price') ?>">Khoảng giá</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-newspaper-o"></i><span>Quản lý bài viết</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?= admin_url('news') ?>">Bài viết</a></li>
            <li><a href="<?= admin_url('catalognew') ?>">Danh mục</a></li>
            <li><a href="<?= admin_url('tags') ?>">Tags</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#"><i class="fa fa-commenting-o"></i><span>Khách hàng</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?= admin_url('contact') ?>">KH trang liên hệ</a></li>
            <li><a href="<?= admin_url('contactemail') ?>">KH đăng ký nhận tin</a></li>
            <li><a href="<?= admin_url('contactphone') ?>">KH yêu cầu gọi lại</a></li>
            <li><a href="<?= admin_url('contactview') ?>">KH đăng ký xem nhà</a></li>
        </ul>
    </li>
    <li><a href="<?= admin_url('pagecontact') ?>"><i class="fa fa-file-text"></i><span>Trang liên hệ</span></a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-cogs"></i><span>Cấu hình website</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?= admin_url('sidebar') ?>">Sidebar</a></li>
            <li><a href="<?= admin_url('social') ?>">Mạng xã hội</a></li>
            <li><a href="<?= admin_url('script') ?>">Script</a></li>
            <li><a href="<?= admin_url('infowebsite') ?>">Thông tin chung</a></li>
            <li><a href="<?= admin_url('deletecache') ?>">Xóa Cache</a></li>
        </ul>
    </li>
    <li><a target="_blank" href="<?= public_url('admin/plugins/ckfinder/ckfinder.html') ?>"><i class="fa fa-folder"></i> <span>Quản lý Media</span></a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-object-group"></i><span>Quản lý tài khoản</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li class="treeview">
                <a href="#"><i class="fa fa-users"></i> Quản trị
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?= admin_url('admin') ?>"><i class="fa fa-user-secret"></i> Quản trị viên</a></li>
                    <li><a href="<?= admin_url('admingroup') ?>"><i class="fa fa-user-circle"></i> Nhóm quản trị</a></li>
                </ul>
            </li>
        </ul>
    </li>
</ul>