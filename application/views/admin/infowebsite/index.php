<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Cài đặt chung</h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li class="active">Cài đặt chung</li>
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
                    <label>Email hệ thống <span class="label label-danger">(Bắt buộc) Nhập 1 hoặc nhiều email</span></label>
                    <input type="text" name="emailnhan" value="<?= $setadmin->emailnhan ?>" class="form-control" placeholder="exam1@gmail.com, exam2@gmail.com">
                    <span class="cHelp"><?= _help_emailnhan ?></span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên công ty</label>
                            <input type="text" name="tenquocte_company" value="<?= htmlentities(isJson($setadmin->company)->tenquocte) ?>" class="form-control" placeholder="Nhập tên công ty">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên gọi tắt</label>
                            <input type="text" name="tengoitat_company" value="<?= htmlentities(isJson($setadmin->company)->tengoitat) ?>" class="form-control" placeholder="Nhập tên gọi tắt">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="address1_address" value="<?= isJson($setadmin->address)->address1 ?>" class="form-control" placeholder="Nhập địa chỉ">
                        </div>
                    </div>
                    <div class="col-md-6 hidden">
                        <div class="form-group">
                            <label>Địa chỉ 2</label>
                            <input type="text" name="address2_address" value="<?= isJson($setadmin->address)->address2 ?>" class="form-control" placeholder="Nhập địa chỉ 2">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Số điện thoại 1</label>
                            <input type="text" name="phone1_phone" value="<?= isJson($setadmin->phone)->phone1 ?>" class="form-control" placeholder="Nhập số điện thoại">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Số điện thoại 2</label>
                            <input type="text" name="phone2_phone" value="<?= isJson($setadmin->phone)->phone2 ?>" class="form-control" placeholder="Nhập số điện thoại">
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" value="<?= $setadmin->email ?>" class="form-control" placeholder="Nhập email">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Website</label>
                            <input type="text" name="website" value="<?= $setadmin->website ?>" class="form-control" placeholder="Nhập website">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Bản đồ</label>
                    <textarea name="map" rows="3" class="form-control"><?= $setadmin->map ?></textarea>
                </div>
            </div>
            <div class="box-footer clearfix">
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
            </div>
        </div>
    </form>
</section>