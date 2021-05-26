<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Loại dự án
        <a href="<?= admin_url('catalog/add') ?>" class="btn btn-success btn-flat">
            <i class="fa fa-plus-circle"></i> Thêm mới
        </a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li><a href="<?= admin_url('catalog') ?>">Loại dự án</a></li>
        <li class="active">Chỉnh sửa</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form" data-model="catalog_model" data-action="edit" data-id="<?= $info->id ?>">
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nội dung</h3>
                        <a target="_blank" class="pull-right cus_view_flast" href="<?= base_url($info->url) ?>"><i class="fa fa-eye"></i> Xem</a>
                    </div>
                    <?php $this->load->view('admin/message', $this->data); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tên <span class="label label-danger">(Bắt buộc)</span></label>
                            <input type="text" name="name" value="<?= htmlentities($info->name) ?>" class="form-control" id="auto_convert_name">
                            <span class="cHelp"><?= _help_name ?></span>
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" name="url" value="<?= $info->url ?>" class="form-control">
                            <span class="cHelp"><?= _help_url ?></span>
                        </div>
                        <div class="form-group hidden">
                            <label>Danh mục cha</label>
                            <select name="parent_id" class="form-control select2" style="width: 100%;">
                                <option value="">Là danh mục cha</option>
                                <?php if (isset($catalog) && $catalog) : ?>
                                    <?php foreach ($catalog as $row) : ?>
                                        <option <?= ($row->id == $info->parent_id) ? 'selected' : '' ?><?= ($row->id == $info->id) ? 'disabled' : '' ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                                        <?php if (count($this->catalog_model->menucon_admin($row->id)) > 0) : ?>
                                            <?php foreach ($this->catalog_model->menucon_admin($row->id, check_sort($setadmin->sort_catalog)) as $cap2) : ?>
                                                <option <?= ($cap2->id == $info->parent_id) ? 'selected' : '' ?><?= ($cap2->id == $info->id) ? 'disabled' : '' ?> value="<?= $cap2->id ?>">--|<?= $cap2->name ?></option>
                                                <?php if (count($this->catalog_model->menucon_admin($cap2->id)) > 0) : ?>
                                                    <?php foreach ($this->catalog_model->menucon_admin($cap2->id, check_sort($setadmin->sort_catalog)) as $cap3) : ?>
                                                        <option <?= ($cap3->id == $info->parent_id) ? 'selected' : '' ?><?= ($cap3->id == $info->id) ? 'disabled' : '' ?> value="<?= $cap3->id ?>">--|--|<?= $cap3->name ?></option>
                                                        <?php if (count($this->catalog_model->menucon_admin($cap3->id)) > 0) : ?>
                                                            <?php foreach ($this->catalog_model->menucon_admin($cap3->id, check_sort($setadmin->sort_catalog)) as $cap4) : ?>
                                                                <option disabled value="<?= $cap4->id ?>">--|--|--|<?= $cap4->name ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <span class="cHelp"><?= _help_catalog_parent ?></span>
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
                            <span class="cHelp"><?= _help_img ?>600 x 400px</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?= ($info->status == 1) ? 'selected' : '' ?>>Hiển thị</option>
                                        <option value="0" <?= ($info->status == 0) ? 'selected' : '' ?>>Ẩn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trang chủ</label>
                                    <select class="form-control" name="home">
                                        <option value="0" <?= ($info->home == 0) ? 'selected' : '' ?>>Không</option>
                                        <option value="1" <?= ($info->home == 1) ? 'selected' : '' ?>>Có</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group <?= switch_sort($setadmin->sort_catalog) ?>">
                            <label>Thứ tự</label>
                            <input type="number" name="sort_order" value="<?= $info->sort_order ?>" class="form-control" placeholder="0">
                            <span class="cHelp"><?= _help_sort ?></span>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">SEO </h3>
                        <div class="no-margin pull-right">
                            <a class="cus_btn_seo btn-warning"><i class="fa fa-superpowers"></i> Tạo Seo</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="tongimg">
                                <?php if ($info->image_seo) : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><img class="img" src="<?= $info->image_seo ?>"></div>
                                        <input type="hidden" name="image_seo" value="<?= $info->image_seo ?>" class="cus_ckfinder image_link">
                                    </div>
                                    <span class="cus_delete_img" title="Xóa" onclick="deleteOneImg(this)"><i class="fa fa-times fa-fw"></i></span>
                                <?php else : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><b>Chọn ảnh</b></div>
                                        <input type="hidden" class="cus_ckfinder image_link" name="image_seo">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" name="title" value="<?= htmlentities($info->title) ?>" class="form-control">
                            <span class="cHelp"><?= _help_title ?></span>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="description" class="form-control" rows="5"><?= $info->description ?></textarea>
                            <span class="cHelp"><?= _help_description ?></span>
                        </div>
                        <div class="form-group">
                            <label>Từ khóa</label>
                            <textarea name="keyword" class="form-control" rows="2"><?= $info->keyword ?></textarea>
                            <span class="cHelp"><?= _help_keyword ?></span>
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