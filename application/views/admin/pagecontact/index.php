<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Cài đặt trang liên hệ</h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li class="active">Cài đặt trang liên hệ</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form">
        <?php $this->load->view('admin/message', $this->data); ?>
        <!-- Thông tin -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Nội dung</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="title_content_contact" value="<?= htmlentities(isJson($setadmin->content_contact)->title) ?>" class="form-control" placeholder="Nhập tiêu đề">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Thông tin liên hệ</label>
                            <textarea name="info_content_contact" class="form-control editor"><?= isJson($setadmin->content_contact)->info ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Thông báo đăng ký thành công</label>
                            <textarea name="success_content_contact" class="form-control editor"><?= isJson($setadmin->content_contact)->success ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SEO -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">SEO</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Hình ảnh</label>
                            <div class="tongimg">
                                <?php if (isJson($setadmin->seo_contact)->image_link) : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><img class="img" src="<?= isJson($setadmin->seo_contact)->image_link ?>"></div>
                                        <input type="hidden" name="image_link" value="<?= isJson($setadmin->seo_contact)->image_link ?>" class="cus_ckfinder image_link">
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
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title_seo" value="<?= htmlentities(isJson($setadmin->seo_contact)->title) ?>" class="form-control" placeholder="Nhập title">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description_seo" class="form-control" rows="3" placeholder="Nhập description"><?= isJson($setadmin->seo_contact)->description ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Keywords</label>
                            <textarea name="keyword_seo" class="form-control" rows="2" placeholder="Nhập keyword"><?= isJson($setadmin->seo_contact)->keyword ?></textarea>
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