<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Slide
        <a href="<?= admin_url('slide/add') ?>" class="btn btn-success btn-flat">
            <i class="fa fa-plus-circle"></i> Thêm mới
        </a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li><a href="<?= admin_url('slide') ?>">Slide</a></li>
        <li class="active">Chỉnh sửa</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form">
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nội dung</h3>
                    </div>
                    <?php $this->load->view('admin/message', $this->data); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tên <span class="label label-danger">(Bắt buộc)</span></label>
                            <input type="text" name="name" value="<?= htmlentities($info->name) ?>" class="form-control" placeholder="Nhập tên">
                        </div>
                        <div class="form-group">
                            <label>Liên kết</label>
                            <input type="text" name="link" value="<?= $info->link ?>" class="form-control" placeholder="http://">
                            <span class="cHelp"><?= _help_link_slide ?></span>
                        </div>
                        <div class="form-group">
                            <label>Mô tả ngắn</label>
                            <textarea name="intro" class="form-control" rows="5"><?= $info->intro ?></textarea>
                            <span class="cHelp"><?= _help_intro ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin thêm </h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="tongimg">
                                <?php if ($info->image_link) : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><img class="img" src="<?= $info->image_link ?>"></div>
                                        <input type="hidden" name="image_link" value="<?= $info->image_link ?>" class="cus_ckfinder image_link">
                                    </div>
                                    <span class="cus_delete_img" title="Xóa" onclick="deleteOneImg(this)"><i class="fa fa-times fa-fw"></i></span>
                                <?php else : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><b>Chọn ảnh</b></div>
                                        <input type="hidden" class="cus_ckfinder image_link" name="image_link">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <span class="cHelp"><?= _help_img ?>1366 x 400px</span>
                        </div>
                        <div class="form-group hidden">
                            <label>Hình ảnh Mobile</label>
                            <div class="tongimg">
                                <?php if ($info->image_link_mobile) : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><img class="img" src="<?= $info->image_link_mobile ?>"></div>
                                        <input type="hidden" name="image_link_mobile" value="<?= $info->image_link_mobile ?>" class="cus_ckfinder image_link">
                                    </div>
                                    <span class="cus_delete_img" title="Xóa" onclick="deleteOneImg(this)"><i class="fa fa-times fa-fw"></i></span>
                                <?php else : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><b>Chọn ảnh đại diện</b></div>
                                        <input type="hidden" class="cus_ckfinder image_link" name="image_link_mobile">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <span class="cHelp"><?= _help_img ?>767 x 300px</span>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="status">
                                <option value="1" <?= ($info->status == 1) ? 'selected' : '' ?>>Hiển thị</option>
                                <option value="0" <?= ($info->status == 0) ? 'selected' : '' ?>>Ẩn</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Thứ tự</label>
                            <input type="number" name="sort_order" value="<?= $info->sort_order ?>" class="form-control" placeholder="0">
                            <span class="cHelp"><?= _help_sort ?></span>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <button type="submit" value="Lưu & thoát" name="cus_btn_save" class="btn btn-danger"><i class="fa fa-external-link"></i> Lưu & thoát</button>
                        <button type="submit" value="Lưu lại" name="cus_btn_save" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>