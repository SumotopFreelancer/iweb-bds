<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Cài đặt Header</h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li class="active">Cài đặt Header</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form">
        <?php $this->load->view('admin/message', $this->data); ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Header</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Banner</label>
                    <div class="tongimg">
                        <?php if ($setadmin->bannerHeader) : ?>
                            <div class="image_avata" onclick="openCKfinder(this)">
                                <div class="show_img"><img class="img" src="<?= $setadmin->bannerHeader ?>"></div>
                                <input type="hidden" name="bannerHeader" value="<?= $setadmin->bannerHeader ?>" class="cus_ckfinder image_link">
                            </div>
                            <span class="cus_delete_img" title="Xóa" onclick="deleteOneImg(this)"><i class="fa fa-times fa-fw"></i></span>
                        <?php else : ?>
                            <div class="image_avata" onclick="openCKfinder(this)">
                                <div class="show_img"><b>Chọn ảnh</b></div>
                                <input type="hidden" class="cus_ckfinder image_link" name="bannerHeader">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Slogan</label>
                    <input type="text" name="slogan" value="<?= htmlentities($setadmin->slogan) ?>" class="form-control" placeholder="Nhập slogan">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Logo</label>
                            <div class="tongimg">
                                <?php if (isJson($setadmin->logo)->image_link) : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><img class="img" src="<?= isJson($setadmin->logo)->image_link ?>"></div>
                                        <input type="hidden" name="image_link" value="<?= isJson($setadmin->logo)->image_link ?>" class="cus_ckfinder image_link">
                                    </div>
                                    <span class="cus_delete_img" title="Xóa" onclick="deleteOneImg(this)"><i class="fa fa-times fa-fw"></i></span>
                                <?php else : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><b>Chọn ảnh</b></div>
                                        <input type="hidden" class="cus_ckfinder image_link" name="image_link">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tên Logo</label>
                            <input type="text" name="name" value="<?= isJson($setadmin->logo)->name ?>" class="form-control" placeholder="Nhập tên">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Favico</label>
                            <div class="tongimg">
                                <?php if ($setadmin->favico) : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><img class="img" src="<?= $setadmin->favico ?>"></div>
                                        <input type="hidden" name="favico" value="<?= $setadmin->favico ?>" class="cus_ckfinder image_link">
                                    </div>
                                    <span class="cus_delete_img" title="Xóa" onclick="deleteOneImg(this)"><i class="fa fa-times fa-fw"></i></span>
                                <?php else : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><b>Chọn ảnh</b></div>
                                        <input type="hidden" class="cus_ckfinder image_link" name="favico">
                                    </div>
                                <?php endif; ?>
                            </div>
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