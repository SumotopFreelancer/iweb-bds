<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Bài viết
        <a href="<?= admin_url('news/add') ?>" class="btn btn-success btn-flat">
            <i class="fa fa-plus-circle"></i> Thêm mới
        </a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li><a href="<?= admin_url('news') ?>">Bài viết</a></li>
        <li class="active">Chỉnh sửa</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form" data-model="news_model" data-action="edit" data-id="<?= $info->id ?>">
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nội dung</h3>
                        <a target="_blank" class="pull-right cus_view_flast" href="<?= base_url(_blog . '/' . $info->url) ?>"><i class="fa fa-eye"></i> Xem</a>
                    </div>
                    <?php $this->load->view('admin/message', $this->data); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tựa đề <span class="label label-danger">(Bắt buộc) <?= form_error('name') ?></span></label>
                            <input type="text" name="name" value="<?= htmlentities($info->name) ?>" class="form-control" id="auto_convert_name">
                            <span class="cHelp"><?= _help_name ?></span>
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" name="url" value="<?= $info->url ?>" class="form-control">
                            <span class="cHelp"><?= _help_url ?></span>
                        </div>
                        <div class="form-group">
                            <label>Mô tả ngắn</label>
                            <textarea name="intro" class="form-control" rows="5"><?= $info->intro ?></textarea>
                            <span class="cHelp"><?= _help_intro ?></span>
                        </div>
                        <div class="form-group">
                            <label>Nội dung <a class="cTool" title="<?= _help_content ?>"></a></label>
                            <textarea name="content" class="form-control editor" rows="10" cols="80"><?= $info->content ?></textarea>
                        </div>
                        <div class="form-group hidden">
                            <label>Tác giả</label>
                            <input type="text" name="author" value="<?= $info->author ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tags</label>
                            <div class="input-group">
                                <input onkeyup="ajaxSearch();" onfocus="focusSearch();" id="name-tag" name="tags" type="text" autocomplete="off" class="form-control">
                                <?php
                                $list = '';
                                if (isset($listtags) && $listtags) {
                                    foreach ($listtags as $row) {
                                        if ($list == '') {
                                            $list .= $row->name;
                                        } else {
                                            $list .= ',' . $row->name;
                                        }
                                    }
                                }
                                ?>
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger" id="click-tag">Thêm</button>
                                </div>
                            </div>
                            <input type="hidden" name="listtagpost" id="listtagpost" value="<?= $list ?>">
                            <div class="ssug" id="suggestions">
                                <div id="autoSuggestionsList"></div>
                            </div>
                            <div id="tags-list">
                                <?php if (isset($listtags) && $listtags) : ?>
                                    <?php foreach ($listtags as $row) : ?>
                                        <span onclick="removetag(this)" data-valuetag="<?= $row->name ?>" class="itemtag"><?= $row->name ?> <b class="closetag">x</b></span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
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
                                        <div class="checkbox lv1">
                                            <label>
                                                <input class="laygiatri" type="checkbox" name="catalog_ids[]" value="<?= $row->id ?>" <?= in_array($row->id, $catalog_ids) ? 'checked' : '' ?>><?= $row->name ?>
                                            </label>
                                            <?php if (in_array($row->id, $catalog_ids)) : ?>
                                                <span class="ctlchinh <?= $row->id == $info->catalog_id ? 'active' : '' ?>" onclick="danhmucchinh($(this))">Danh mục chính</span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (count($this->catalognew_model->menucon_admin($row->id)) > 0) : ?>
                                            <?php foreach ($this->catalognew_model->menucon_admin($row->id, check_sort($setadmin->sort_catalog_new)) as $cap2) : ?>
                                                <div class="checkbox lv2">
                                                    <label>
                                                        <input class="laygiatri <?= $row->id == $info->catalog_id ? 'active' : '' ?>" type="checkbox" name="catalog_ids[]" value="<?= $cap2->id ?>" <?= in_array($cap2->id, $catalog_ids) ? 'checked' : '' ?>><?= $cap2->name ?>
                                                    </label>
                                                    <?php if (in_array($cap2->id, $catalog_ids)) : ?>
                                                        <span class="ctlchinh <?= $cap2->id == $info->catalog_id ? 'active' : '' ?>" onclick="danhmucchinh($(this))">Danh mục chính</span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if (count($this->catalognew_model->menucon_admin($cap2->id)) > 0) : ?>
                                                    <?php foreach ($this->catalognew_model->menucon_admin($cap2->id, check_sort($setadmin->sort_catalog_new)) as $cap3) : ?>
                                                        <div class="checkbox lv3">
                                                            <label>
                                                                <input class="laygiatri <?= $row->id == $info->catalog_id ? 'active' : '' ?>" type="checkbox" name="catalog_ids[]" value="<?= $cap3->id ?>" <?= in_array($cap3->id, $catalog_ids) ? 'checked' : '' ?>><?= $cap3->name ?>
                                                            </label>
                                                            <?php if (in_array($cap3->id, $catalog_ids)) : ?>
                                                                <span class="ctlchinh <?= $cap3->id == $info->catalog_id ? 'active' : '' ?>" onclick="danhmucchinh($(this))">Danh mục chính</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php if (count($this->catalognew_model->menucon_admin($cap3->id)) > 0) : ?>
                                                            <?php foreach ($this->catalognew_model->menucon_admin($cap3->id, check_sort($setadmin->sort_catalog_new)) as $cap4) : ?>
                                                                <div class="checkbox lv4">
                                                                    <label>
                                                                        <input class="laygiatri <?= $row->id == $info->catalog_id ? 'active' : '' ?>" type="checkbox" name="catalog_ids[]" value="<?= $cap4->id ?>" <?= in_array($cap4->id, $catalog_ids) ? 'checked' : '' ?>><?= $cap4->name ?>
                                                                    </label>
                                                                    <?php if (in_array($cap4->id, $catalog_ids)) : ?>
                                                                        <span class="ctlchinh <?= $cap4->id == $info->catalog_id ? 'active' : '' ?>" onclick="danhmucchinh($(this))">Danh mục chính</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <span class="cHelp"><?= _help_catalog ?></span>
                            <input type="hidden" name="catalog_id" value="<?= $info->catalog_id ?>">
                        </div>
                        <div class="form-group">
                            <label>Ngày đăng:</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-clock-o"></i></div>
                                <input type="text" class="form-control cus_timer" name="timer" value="<?= get_date_admin($info->timer) ?>">
                            </div>
                            <span class="cHelp"><?= _help_timer ?></span>
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
                            <div class="col-md-6 hidden">
                                <div class="form-group">
                                    <label>Trang chủ</label>
                                    <select class="form-control" name="home">
                                        <option value="0" <?= ($info->home == 0) ? 'selected' : '' ?>>Không</option>
                                        <option value="1" <?= ($info->home == 1) ? 'selected' : '' ?>>Có</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Sidebar</label>
                                    <select class="form-control" name="sidebar">
                                        <option value="0" <?= ($info->sidebar == 0) ? 'selected' : '' ?>>Không</option>
                                        <option value="1" <?= ($info->sidebar == 1) ? 'selected' : '' ?>>Có</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group hidden">
                            <label>Layout</label>
                            <select class="form-control" name="layout">
                                <option value="sidebar" <?= ($info->layout == 'sidebar') ? 'selected' : '' ?>>Sidebar</option>
                                <option value="full" <?= ($info->layout == 'full') ? 'selected' : '' ?>>Full</option>
                            </select>
                        </div>
                        <div class="form-group <?= switch_sort($setadmin->sort_news) ?>">
                            <label>Thứ tự</label>
                            <input type="number" name="sort_order" value="<?= $info->sort_order ?>" class="form-control" placeholder="0">
                            <span class="cHelp"><?= _help_sort ?></span>
                        </div>
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
                                        <div class="show_img"><b>Chọn ảnh đại diện</b></div>
                                        <input type="hidden" class="cus_ckfinder image_link" name="image_link">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <span class="cHelp"><?= _help_img ?>600 x 400px</span>
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
                        <button type="submit" value="Lưu & thoát" name="cus_btn_save" class="btn btn-danger submit"><i class="fa fa-external-link"></i> Lưu & thoát</button>
                        <button type="submit" value="Lưu lại" name="cus_btn_save" class="btn btn-success pull-right submit"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<!-- Check danh mục -->
<script type="text/javascript">
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
<!-- Check Tags -->
<script type="text/javascript">
    function isEmpty(value) {
        return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
    }
    $(document).ready(function() {
        $("#click-tag").click(function() {
            var tags = $('#name-tag').val();
            if (!isEmpty(tags)) {
                $.each(tags.split(','), function(index, value) {
                    if (!isEmpty(value)) {
                        if ($.inArray(value.trim(), updatetag().split(',')) == -1) {
                            $('#tags-list').append('<span onclick="removetag(this)" data-valuetag="' + value.trim() + '" class="itemtag">' + value.trim() + ' <b class="closetag">x</b></span>');
                        }
                    }
                });
            }
            updatetag();
            $('#name-tag').val('');
        });
    });

    function updatetag() {
        var string = '';
        $.each($('#tags-list .itemtag'), function() {
            if (isEmpty(string)) {
                string = string + $(this).attr('data-valuetag');
            } else {
                string = string + ',' + $(this).attr('data-valuetag');
            }
        });
        return string;
    }

    function removetag(itemtag) {
        itemtag.remove();
        updatetag();
    }

    function focusSearch() {
        $.ajax({
            type: "POST",
            url: "<?= admin_url('news/autocomplete') ?>",
            success: function(data) {
                if (data.length > 0) {
                    $('#suggestions').show();
                    $('#autoSuggestionsList').html(data);
                } else {
                    $('#suggestions').hide();
                }
            }
        });
    }

    function ajaxSearch() {
        var input_data = $('#name-tag').val();
        if (input_data.length === 0) {
            $('#suggestions').hide();
        } else {
            $.ajax({
                type: "POST",
                url: "<?= admin_url('news/autocomplete') ?>",
                data: {
                    search_data: input_data
                },
                success: function(data) {
                    if (data.length > 0) {
                        $('#suggestions').show();
                        $('#autoSuggestionsList').html(data);
                    } else {
                        $('#suggestions').hide();
                    }
                }
            });
        }
    }

    function addtag(valuetag) {
        var string = '';
        if (isEmpty(string)) {
            string = string + $(valuetag).text();
        } else {
            string = string + ',' + $(valuetag).text();
        }
        $('#name-tag').val(string);
        $('#suggestions').hide();
    }
    $(".submit").click(function() {
        $('#listtagpost').val(updatetag());
    });
    $(document).mouseup(function(e) {
        if ($(e.target).closest("#suggestions").length === 0) {
            $("#suggestions").hide();
        }
    });
</script>