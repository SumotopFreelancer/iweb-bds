<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Hình ảnh
        <a href="<?= admin_url('images/add') ?>" class="btn btn-success btn-flat">
            <i class="fa fa-plus-circle"></i> Thêm mới
        </a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li><a href="<?= admin_url('images') ?>">Hình ảnh</a></li>
        <li class="active">Thêm mới</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form" data-model="images_model" data-action="add">
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
                        <div class="form-group">
                            <label>Mô tả ngắn</label>
                            <textarea name="intro" class="form-control" rows="5"><?= set_value('intro') ?></textarea>
                            <span class="cHelp"><?= _help_intro ?></span>
                        </div>
                        <div class="form-group">
                            <label>Nội dung <a class="cTool" title="<?= _help_content ?>"></a></label>
                            <textarea name="content" class="form-control editor" rows="10" cols="80"><?= set_value('content') ?></textarea>
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
                            <label>Danh mục <span class="label label-danger">(Bắt buộc) <?= form_error('catalog_ids[]') ?></span></label>
                            <div class="list_catalog">
                                <?php if (isset($catalog) && $catalog) : ?>
                                    <?php foreach ($catalog as $row) : ?>
                                        <div class="checkbox lv1" id="ctl<?= $row->id ?>">
                                            <label>
                                                <input class="laygiatri" type="checkbox" name="catalog_ids[]" value="<?= $row->id ?>" <?= set_checkbox('catalog_ids[]', $row->id); ?>><?= $row->name ?>
                                            </label>
                                        </div>
                                        <?php if (count($this->catalogimage_model->menucon_admin($row->id)) > 0) : ?>
                                            <?php foreach ($this->catalogimage_model->menucon_admin($row->id, check_sort($setadmin->sort_catalog_image)) as $cap2) : ?>
                                                <div class="checkbox lv2" id="ctl<?= $row->id ?>">
                                                    <label>
                                                        <input class="laygiatri" type="checkbox" name="catalog_ids[]" value="<?= $cap2->id ?>" <?= set_checkbox('catalog_ids[]', $cap2->id); ?>><?= $cap2->name ?>
                                                    </label>
                                                </div>
                                                <?php if (count($this->catalogimage_model->menucon_admin($cap2->id)) > 0) : ?>
                                                    <?php foreach ($this->catalogimage_model->menucon_admin($cap2->id, check_sort($setadmin->sort_catalog_image)) as $cap3) : ?>
                                                        <div class="checkbox lv3" id="ctl<?= $row->id ?>">
                                                            <label>
                                                                <input class="laygiatri" type="checkbox" name="catalog_ids[]" value="<?= $cap3->id ?>" <?= set_checkbox('catalog_ids[]', $cap3->id); ?>><?= $cap3->name ?>
                                                            </label>
                                                        </div>
                                                        <?php if (count($this->catalogimage_model->menucon_admin($cap3->id)) > 0) : ?>
                                                            <?php foreach ($this->catalogimage_model->menucon_admin($cap3->id, check_sort($setadmin->sort_catalog_image)) as $cap4) : ?>
                                                                <div class="checkbox lv4" id="ctl<?= $row->id ?>">
                                                                    <label>
                                                                        <input class="laygiatri" type="checkbox" name="catalog_ids[]" value="<?= $cap4->id ?>" <?= set_checkbox('catalog_ids[]', $cap4->id); ?>><?= $cap4->name ?>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <a class="setupcatalog" href="<?= admin_url('catalogimage/add') ?>"><i class="fa fa-exclamation-triangle"></i> CLICK THÊM DANH MỤC</a>
                                <?php endif; ?>
                            </div>
                            <span class="cHelp"><?= _help_catalog ?></span>
                            <input type="hidden" name="catalog_id">
                        </div>
                        <div class="form-group">
                            <label>Ngày đăng:</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                <input type="text" class="form-control cus_timer" name="timer" value="<?= get_date_admin(now()) ?>">
                            </div>
                            <span class="cHelp"><?= _help_timer ?></span>
                        </div>
                        <div class="form-group">
                            <div class="tongimg">
                                <div class="image_avata" onclick="openCKfinder(this)">
                                    <div class="show_img"><b>Chọn ảnh</b></div>
                                    <input type="hidden" name="image_link" class="cus_ckfinder image_link">
                                </div>
                            </div>
                            <span class="cHelp"><?= _help_img ?>600 x 400px</span>
                        </div>
                        <div class="form-group">
                            <label>Ảnh kèm theo:</label>
                            <div id="wGallery" class="cus_image_action"></div>
                            <div class="cus_image_list">
                                <img class="img-responsive" class="cus_btn_add_image_list" onclick="openCKfinderMulti('gallery', 'altGallery', 'wGallery')" src="<?= public_url('admin/img/plus.png') ?>" alt="...">
                            </div>
                            <span class="cHelp"><?= _help_img_list ?>600 x 400px</span>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trang chủ</label>
                                    <select class="form-control" name="home">
                                        <option value="0">Không</option>
                                        <option value="1">Có</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group <?= switch_sort($setadmin->sort_images) ?>">
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
<!-- Check danh mục -->
<script type="text/javascript">
    var val = [];
    $('.laygiatri:checked').each(function(i) {
        $(this).parents('.checkbox').append('<span class="ctlchinh" onclick="danhmucchinh($(this))">Danh mục chính</span>');
    });
    $('.laygiatri').click(function() {
        if (this.checked) {
            $(this).parents('.checkbox').append('<span class="ctlchinh" onclick="danhmucchinh($(this))">Danh mục chính</span>');
        } else {
            $(this).parents('.checkbox').find('.ctlchinh').remove();
        }
    });

    function danhmucchinh(e) {
        $('.list_catalog').find('.ctlchinh').removeClass('active');
        e.addClass('active');
        var id = e.parents('.checkbox').find('.laygiatri').val();
        $("input[name='catalog_id']").val(id);
    }
</script>