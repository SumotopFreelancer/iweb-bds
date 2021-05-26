<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Cài đặt Mạng xã hội</h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li class="active">Cài đặt Mạng xã hội</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form">
        <?php $this->load->view('admin/message', $this->data); ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Mạng xã hội</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group hidden">
                    <label>Facebook</label>
                    <input type="text" name="facebook" value="<?= isJson($setadmin->social)->facebook ?>" class="form-control" placeholder="Nhập link fanpage">
                </div>
                <div class="form-group">
                    <label>ID Facebook</label>
                    <input type="text" name="id_facebook" value="<?= isJson($setadmin->social)->id_facebook ?>" class="form-control" placeholder="Nhập ID fanpage">
                </div>
                <div class="form-group">
                    <label>Zalo</label>
                    <input type="text" name="zalo" value="<?= isJson($setadmin->social)->zalo ?>" class="form-control" placeholder="Nhập số điện thoại">
                </div>
                <div class="form-group hidden">
                    <label>Youtube</label>
                    <input type="text" name="youtube" value="<?= isJson($setadmin->social)->youtube ?>" class="form-control" placeholder="Nhập link youtube">
                </div>
                <div class="form-group hidden">
                    <label>Instagram</label>
                    <input type="text" name="instagram" value="<?= isJson($setadmin->social)->instagram ?>" class="form-control" placeholder="Nhập link instagram">
                </div>
                <div class="form-group hidden">
                    <label>Twitter</label>
                    <input type="text" name="twitter" value="<?= isJson($setadmin->social)->twitter ?>" class="form-control" placeholder="Nhập link twitter">
                </div>
                <div class="form-group hidden">
                    <label>Skype</label>
                    <input type="text" name="skype" value="<?= isJson($setadmin->social)->skype ?>" class="form-control" placeholder="Nhập link skype">
                </div>
                <div class="form-group hidden">
                    <label>Linkedin</label>
                    <input type="text" name="linkedin" value="<?= isJson($setadmin->social)->linkedin ?>" class="form-control" placeholder="Nhập link linkedin">
                </div>
            </div>
            <div class="box-footer clearfix">
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
            </div>
        </div>
    </form>
</section>