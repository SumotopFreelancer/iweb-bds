<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Danh mục <small>Dịch vụ</small>
        <a href="<?= admin_url('catalogservice/add') ?>" class="btn btn-success btn-flat">
            <i class="fa fa-plus-circle"></i> Thêm mới
        </a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li><a href="<?= admin_url('catalogservice') ?>">Danh mục</a></li>
        <li class="active">Thêm mới</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form" data-model="catalogservice_model" data-action="add">
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nội dung</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tên <span class="label label-danger">(Bắt buộc) <?= form_error('name') ?></span></label>
                            <input type="text" name="name" value="<?= set_value('name') ?>" class="form-control" id="auto_convert_name">
                            <span class="cHelp"><?= _help_name ?></span>
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" name="url" value="<?= set_value('url') ?>" class="form-control">
                            <span class="cHelp"><?= _help_url ?></span>
                        </div>
                        <div class="form-group hidden">
                            <label>Danh mục cha</label>
                            <select name="parent_id" class="form-control select2" style="width: 100%;">
                                <option value="">Là danh mục cha</option>
                                <?php if (isset($catalog) && $catalog) : ?>
                                    <?php foreach ($catalog as $row) : ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                        <?php if (count($this->catalogservice_model->menucon_admin($row->id)) > 0) : ?>
                                            <?php foreach ($this->catalogservice_model->menucon_admin($row->id, check_sort($setadmin->sort_catalog_service)) as $cap2) : ?>
                                                <option value="<?= $cap2->id ?>">--|<?= $cap2->name ?></option>
                                                <?php if (count($this->catalogservice_model->menucon_admin($cap2->id)) > 0) : ?>
                                                    <?php foreach ($this->catalogservice_model->menucon_admin($cap2->id, check_sort($setadmin->sort_catalog_service)) as $cap3) : ?>
                                                        <option value="<?= $cap3->id ?>">--|--|<?= $cap3->name ?></option>
                                                        <?php if (count($this->catalogservice_model->menucon_admin($cap3->id)) > 0) : ?>
                                                            <?php foreach ($this->catalogservice_model->menucon_admin($cap3->id, check_sort($setadmin->sort_catalog_service)) as $cap4) : ?>
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
                            <textarea name="intro" class="form-control" rows="5"><?= set_value('intro') ?></textarea>
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
                                <div class="image_avata" onclick="openCKfinder(this)">
                                    <div class="show_img"><b>Chọn ảnh đại diện</b></div>
                                    <input type="hidden" name="image_link" class="cus_ckfinder image_link">
                                </div>
                            </div>
                            <span class="cHelp"><?= _help_img ?>600 x 400px</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="form-control" name="status">
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 hidden">
                                <div class="form-group">
                                    <label>Trang chủ</label>
                                    <select class="form-control" name="home">
                                        <option value="0">Không</option>
                                        <option value="1">Có</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Thứ tự</label>
                            <input type="number" name="sort_order" value="<?= set_value('sort_order') ?>" class="form-control" placeholder="0">
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
                                <div class="image_avata" onclick="openCKfinder(this)">
                                    <div class="show_img"><b>Chọn ảnh</b></div>
                                    <input type="hidden" name="image_seo" class="cus_ckfinder image_link">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề</label>
                            <input type="text" name="title" value="<?= set_value('title') ?>" class="form-control">
                            <span class="cHelp"><?= _help_title ?></span>
                        </div>
                        <div class="form-group">
                            <label>Mô tả</label>
                            <textarea name="description" class="form-control" rows="5"><?= set_value('description') ?></textarea>
                            <span class="cHelp"><?= _help_description ?></span>
                        </div>
                        <div class="form-group">
                            <label>Từ khóa</label>
                            <textarea name="keyword" class="form-control" rows="2"><?= set_value('keyword') ?></textarea>
                            <span class="cHelp"><?= _help_keyword ?></span>
                        </div>
                    </div>
                    <div class="box-footer clearfix">
                        <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>