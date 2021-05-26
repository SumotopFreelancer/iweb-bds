<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Dự án
        <a href="<?= admin_url('products/add') ?>" class="btn btn-success btn-flat">
            <i class="fa fa-plus-circle"></i> Thêm mới
        </a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li><a href="<?= admin_url('products') ?>">Dự án</a></li>
        <li class="active">Chỉnh sửa</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form" data-model="products_model" data-action="edit" data-id="<?= $info->id ?>">
        <div class="row">
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Thông tin cơ bản</h3>
                        <?php $catalogurl = $this->catalog_model->get_info($info->catalog_id)->url; ?>
                        <a target="_blank" class="pull-right cus_view_flast" href="<?= base_url($catalogurl . '/' . $info->url) ?>"><i class="fa fa-eye"></i> Xem</a>
                    </div>
                    <div class="msg"></div>
                    <?php $this->load->view('admin/message', $this->data); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <input type="hidden" name="id" value="<?= $info->id ?>">
                            <label>Tên <span class=" label label-danger">(Bắt buộc) <span class="error errorName"></span></span></label>
                            <input type="text" name="name" value="<?= htmlentities($info->name) ?>" class="form-control" id="auto_convert_name">
                            <span class="cHelp"><?= _help_name ?></span>
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" name="url" value="<?= $info->url ?>" class="form-control">
                            <span class="cHelp"><?= _help_url ?></span>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Quận <span class="label label-danger">(Bắt buộc) <span class="error errorDistrict"></span></span></label>
                                    <select name="district_id" class="form-control select2" style="width: 100%;" id="district_id">
                                        <option value="">Chọn quận</option>
                                        <?php if (!empty($districts)) : ?>
                                            <?php foreach ($districts as $row) : ?>
                                                <option <?= $info->district_id == $row->id ? 'selected' : '' ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phường <span class="label label-danger">(Bắt buộc) <span class="error errorWard"></span></span></label>
                                    <select name="ward_id" class="form-control select2" style="width: 100%;" id="ward_id">
                                        <option value="">Chọn phường</option>
                                        <?php if (!empty($wards)) : ?>
                                            <?php foreach ($wards as $row) : ?>
                                                <option <?= $info->ward_id == $row->id ? 'selected' : '' ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Địa chỉ <span class="label label-danger">(Bắt buộc) <span class="error errorAddress"></span></span></label>
                                    <input type="text" name="address" value="<?= htmlentities($info->address) ?>" class="form-control" placeholder="Nhập địa chỉ">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Số điện thoại <span class="label label-danger">(Bắt buộc) <span class="error errorPhone"></span></span></label>
                                    <input type="text" name="phone" value="<?= htmlentities($info->phone) ?>" class="form-control" placeholder="Nhập số điện thoại">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Giá bán</label>
                                    <input type="text" name="price" value="<?= number_format($info->price, 1) ?>" class="form-control" data-format_price placeholder="0.0">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Loại giá</label>
                                    <select class="form-control" name="priceType">
                                        <option value="0">Chọn loại giá</option>
                                        <option value="1" <?= $info->priceType == 1 ? 'selected' : '' ?>>Giá chốt</option>
                                        <option value="2" <?= $info->priceType == 2 ? 'selected' : '' ?>>Còn thương lượng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Hướng</label>
                                    <select name="direction_id" class="form-control select2" style="width: 100%;">
                                        <option value="">Chọn hướng</option>
                                        <?php if (!empty($directions)) : ?>
                                            <?php foreach ($directions as $row) : ?>
                                                <option <?= $info->direction_id == $row->id ? 'selected' : '' ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Diện tích</label>
                                    <input type="number" name="area" value="<?= $info->area ?>" class="form-control" placeholder="Nhập diện tích">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Phòng ngủ</label>
                                    <input type="number" name="bedroom" value="<?= $info->bedroom ?>" class="form-control" placeholder="Nhập số lượng">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Phòng tắm</label>
                                    <input type="number" name="bathroom" value="<?= $info->bathroom ?>" class="form-control" placeholder="Nhập số lượng">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Diện tích tỷ lệ</label>
                                    <input type="text" name="area_ratio" value="<?= htmlentities($info->area_ratio) ?>" class="form-control" placeholder="Nhập diện tích tỷ lệ">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nội dung <a class="cTool" title="<?= _help_content ?>"></a></label>
                            <textarea name="content" class="form-control editor"><?= $info->content ?></textarea>
                        </div>
                        <div class="form-group hidden">
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
                        <h3 class="box-title">Thông tin thêm</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group" id="scrollCatalog">
                            <label>Loại dự án <span class="label label-danger">(Bắt buộc) <span class="error errorCatalog"></span></span></label>
                            <div class="list_catalog">
                                <?php if (!empty($catalog)) : ?>
                                    <?php foreach ($catalog as $row) : ?>
                                        <div class="checkbox lv1">
                                            <label>
                                                <input class="laygiatri" type="checkbox" name="catalog_ids[]" value="<?= $row->id ?>" <?= in_array($row->id, $catalog_ids) ? 'checked' : '' ?>><?= $row->name ?>
                                            </label>
                                            <?php if (in_array($row->id, $catalog_ids)) : ?>
                                                <span class="ctlchinh <?= $row->id == $info->catalog_id ? 'active' : '' ?>" onclick="danhmucchinh($(this))">Danh mục chính</span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if (count($this->catalog_model->menucon_admin($row->id)) > 0) : ?>
                                            <?php foreach ($this->catalog_model->menucon_admin($row->id, check_sort($setadmin->sort_catalog)) as $cap2) : ?>
                                                <div class="checkbox lv2">
                                                    <label>
                                                        <input class="laygiatri <?= $row->id == $info->catalog_id ? 'active' : '' ?>" type="checkbox" name="catalog_ids[]" value="<?= $cap2->id ?>" <?= in_array($cap2->id, $catalog_ids) ? 'checked' : '' ?>><?= $cap2->name ?>
                                                    </label>
                                                    <?php if (in_array($cap2->id, $catalog_ids)) : ?>
                                                        <span class="ctlchinh <?= $cap2->id == $info->catalog_id ? 'active' : '' ?>" onclick="danhmucchinh($(this))">Danh mục chính</span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if (count($this->catalog_model->menucon_admin($cap2->id)) > 0) : ?>
                                                    <?php foreach ($this->catalog_model->menucon_admin($cap2->id, check_sort($setadmin->sort_catalog)) as $cap3) : ?>
                                                        <div class="checkbox lv3">
                                                            <label>
                                                                <input class="laygiatri <?= $row->id == $info->catalog_id ? 'active' : '' ?>" type="checkbox" name="catalog_ids[]" value="<?= $cap3->id ?>" <?= in_array($cap3->id, $catalog_ids) ? 'checked' : '' ?>><?= $cap3->name ?>
                                                            </label>
                                                            <?php if (in_array($cap3->id, $catalog_ids)) : ?>
                                                                <span class="ctlchinh <?= $cap3->id == $info->catalog_id ? 'active' : '' ?>" onclick="danhmucchinh($(this))">Danh mục chính</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php if (count($this->catalog_model->menucon_admin($cap3->id)) > 0) : ?>
                                                            <?php foreach ($this->catalog_model->menucon_admin($cap3->id, check_sort($setadmin->sort_catalog)) as $cap4) : ?>
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
                                <?php else : ?>
                                    <a class="setupcatalog" href="<?= admin_url('catalog/add') ?>"><i class="fa fa-exclamation-triangle"></i> CLICK THÊM LOẠI DỰ ÁN</a>
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
                        <div class="form-group">
                            <label>Ảnh kèm theo:</label>
                            <div id="wGallery" class="cus_image_action">
                                <?php if (isJson($info->image_list)) : ?>
                                    <?php foreach (isJson($info->image_list) as $key => $row) : ?>
                                        <div class="col-md-6">
                                            <input name="gallery[]" type="hidden" value="<?= $key ?>">
                                            <div class="cus_img_box"><img src="<?= $key ?>" class="img-responsive"></div>
                                            <input class="form-control" name="galleryAlt[]" type="text" value="<?= $row ?>" placeholder="Alt ảnh">
                                            <span class="cus_delete_img" title="Xóa" onclick="deleteAnhKemTheo(this)"><i class="fa fa-times fa-fw"></i></span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="cus_image_list">
                                <img class="img-responsive" class="cus_btn_add_image_list" onclick="openCKfinderMulti('gallery', 'galleryAlt', 'wGallery')" src="<?= public_url('admin/img/plus.png') ?>">
                            </div>
                            <span class="cHelp"><?= _help_img_list ?>600 x 400px</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select class="form-control" name="status">
                                        <option value="1" <?= $info->status == 1 ? 'selected' : '' ?>>Hiển thị</option>
                                        <option value="0" <?= $info->status == 0 ? 'selected' : '' ?>>Ẩn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nổi bật</label>
                                    <select class="form-control" name="highlight">
                                        <option value="0" <?= $info->highlight == 0 ? 'selected' : '' ?>>Không</option>
                                        <option value="1" <?= $info->highlight == 1 ? 'selected' : '' ?>>Có</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trang chủ</label>
                                    <select class="form-control" name="home">
                                        <option value="0" <?= $info->home == 0 ? 'selected' : '' ?>>Không</option>
                                        <option value="1" <?= $info->home == 1 ? 'selected' : '' ?>>Có</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mới</label>
                                    <select class="form-control" name="proNew">
                                        <option value="0" <?= $info->proNew == 0 ? 'selected' : '' ?>>Không</option>
                                        <option value="1" <?= $info->proNew == 1 ? 'selected' : '' ?>>Có</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tình trạng</label>
                                    <select class="form-control" name="proStock">
                                        <option value="0" <?= $info->proStock == 0 ? 'selected' : '' ?>>Chưa bán</option>
                                        <option value="1" <?= $info->proStock == 1 ? 'selected' : '' ?>>Đã bán</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group <?= switch_sort($setadmin->sort_products) ?>">
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
                        <button type="button" class="btn btn-danger submit" onclick="addRows(this, 'redirect')"><i class="fa fa-external-link"></i> Lưu & thoát</button>
                        <button type="button" class="btn btn-success pull-right submit" onclick="addRows(this, 'reload')"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<script>
    // Check loại dự án
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
    // Check Tags
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
            url: "<?= admin_url('products/autocomplete') ?>",
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
                url: "<?= admin_url('products/autocomplete') ?>",
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
    // Load Ward
    $('#district_id').on("select2:select", function(e) {
        var district_id = $(this).val();
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?= admin_url('products/ajax_get_ward') ?>",
            data: {
                district_id: district_id
            },
            success: function(result) {
                if (result.status == 1 || result.status == 0) {
                    $('#ward_id').html(result.html);
                } else {
                    console.log(result);
                }
            }
        });
    });
    // Edit
    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    function addRows(e, type) {
        $('#form .error').html('');
        var data = $('#form').serializeObject();
        data.content = CKEDITOR.instances.content.getData();
        $.ajax({
            url: "<?= admin_url('products/ajax_edit') ?>",
            type: "POST",
            dataType: 'json',
            data: data,
            beforeSend: function() {
                $('body').append('<div class="loading"><span><i class="fa fa-spinner fa-pulse"></i></span></div>');
                $(e).prop('disabled', true);
            },
            success: function(result) {
                $('body').find('.loading').remove();
                $(e).prop('disabled', false);
                if (result.status == 1) {
                    if (type == 'redirect') {
                        window.location.href = result.redirect;
                    }
                    if (type == 'reload') {
                        window.location.href = result.reload;
                    }
                } else if (result.status == 0) {
                    if (result.errors.name) {
                        $('#form input[name="name"]').focus();
                        $('#form .errorName').html(result.errors.name);
                    } else if (result.errors.district_id) {
                        $('#form select[name="district_id"]').select2('open');
                        $('#form .errorDistrict').html(result.errors.district_id);
                    } else if (result.errors.ward_id) {
                        $('#form select[name="ward_id"]').select2('open');
                        $('#form .errorWard').html(result.errors.ward_id);
                    } else if (result.errors.address) {
                        $('#form input[name="address"]').focus();
                        $('#form .errorAddress').html(result.errors.address);
                    } else if (result.errors.phone) {
                        $('#form input[name="phone"]').focus();
                        $('#form .errorPhone').html(result.errors.phone);
                    } else if (result.errors.catalog_ids) {
                        $('html, body').animate({
                            scrollTop: $(".errorCatalog").offset().top - 30
                        }, 100);
                        $('#form .errorCatalog').html(result.errors.catalog_ids);
                    }
                } else if (result.status == 2) {
                    $('.msg').html(result.message);
                } else {
                    console.log(result);
                }
            }
        });
    }
</script>