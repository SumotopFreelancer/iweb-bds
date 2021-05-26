<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Menu
        <a href="<?= admin_url('menu/add') ?>" class="btn btn-success btn-flat">
            <i class="fa fa-plus-circle"></i> Thêm mới
        </a>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li><a href="<?= admin_url('menu') ?>">Danh sách</a></li>
        <li class="active">Thêm mới</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="alert alert-info">
                <h4><i class="icon fa fa-info"></i> Hướng dẫn!</h4>
                <p>Bước 1: Click chọn "LOẠI MENU" bên dưới</p>
                <p>Bước 2: Tùy chỉnh "NỘI DUNG" menu bên phải</p>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Loại Menu</h3>
                </div>
                <div class="box-body">
                    <ul class="nav nav-pills nav-stacked cus_loai_menu">
                        <li data-type="pages" class="active">
                            <a href="javascript:;"><i class="fa fa-file-text"></i> Trang</a>
                        </li>
                        <li data-type="catalognew">
                            <a href="javascript:;"><i class="fa fa-bars"></i> Danh mục bài viết</a>
                        </li>
                        <li data-type="news">
                            <a href="javascript:;"><i class="fa fa-newspaper-o"></i> Bài viết</a>
                        </li>
                        <li data-type="catalog">
                            <a href="javascript:;"><i class="fa fa-bars"></i> Loại dự án</a>
                        </li>
                        <li data-type="products">
                            <a href="javascript:;"><i class="fa fa-th-large"></i> Dự án</a>
                        </li>
                        <li data-type="catalogservice" class="hidden">
                            <a href="javascript:;"><i class="fa fa-bars"></i> Danh mục dịch vụ</a>
                        </li>
                        <li data-type="services" class="hidden">
                            <a href="javascript:;"><i class="fa fa-user-md"></i> Dịch vụ</a>
                        </li>
                        <li data-type="outlink">
                            <a href="javascript:;"><i class="fa fa-link"></i> Liên kết tự tạo</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Nội dung</h3>
                </div>
                <?php $this->load->view('admin/message', $this->data); ?>
                <div class="msg"></div>
                <form action="" method="POST" id="form">
                    <div class="box-body">
                        <div id="load_type_menu" class="form-group">
                            <label></label>
                            <select id="report" name="id_type" class="form-control select2" style="width: 100%;"></select>
                            <div id="type_hide"></div>
                        </div>
                        <div class="form-group">
                            <label>Tên menu <span class="label label-danger">(Bắt buộc) <span id="cus_er_name"></span></span></label>
                            <input id="name" type="text" name="name" value="<?= set_value('name') ?>" class="form-control" placeholder="Nhập tên menu">
                        </div>
                        <div class="form-group">
                            <label>Menu cha</label>
                            <select name="parent_id" class="form-control select2" style="width: 100%;">
                                <option value="">Là menu cha</option>
                                <?php if (isset($menu) && $menu) : ?>
                                    <?php foreach ($menu as $row) : ?>
                                        <option value="<?= $row->id ?>"><?= $row->name ?></option>
                                        <?php if ($row->child) : ?>
                                            <?php foreach ($row->child as $cap2) : ?>
                                                <option value="<?= $cap2->id ?>">--|<?= $cap2->name ?></option>
                                                <?php if ($cap2->child) : ?>
                                                    <?php foreach ($cap2->child as $cap3) : ?>
                                                        <option value="<?= $cap3->id ?>">--|--|<?= $cap3->name ?></option>
                                                        <?php if ($cap3->child) : ?>
                                                            <?php foreach ($cap3->child as $cap4) : ?>
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
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="status">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Thứ tự</label>
                            <input type="number" name="sort_order" value="<?= set_value('sort_order') ?>" class="form-control" placeholder="Nhập thứ tự">
                        </div>
                        <div class="form-group hidden">
                            <label>Vị trí</label>
                            <select class="form-control" name="module">
                                <option value="default">Menu Chính</option>
                                <option value="top">Menu Top</option>
                                <option value="left">Menu Left</option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="box-footer clearfix">
                    <button class="btn btn-success pull-right cus_btn_sub_menu"><i class="fa fa-floppy-o"></i> Lưu lại</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $('.cus_btn_sub_menu').click(function() {
            $('.cus_messenger_action').remove();
            var name = $('#name').val();
            $.ajax({
                type: "post",
                url: "<?= admin_url('menu/validationadd') ?>",
                data: {
                    name: name
                },
                success: function(data) {
                    if (data == 1) {
                        $('#form').submit();
                    } else {
                        $('#cus_er_name').html($.parseJSON(data).name);
                        $('#name').focus();
                        return false;
                    }
                }
            });
        });
        // Auto load ajax in first load
        var type = $('.cus_loai_menu li.active').attr('data-type');
        $.ajax({
            type: "post",
            url: "<?= admin_url('menu/load_type_menu') ?>",
            data: {
                type: type
            },
            success: function(data) {
                var repon = $.parseJSON(data);
                $('#load_type_menu label').html(repon.label);
                $('#type_hide').html(repon.type_hide);
                if (repon.loai == 'inlink') {
                    $('#report').html(repon.html);
                    $('#load_type_menu .select2').show();
                    var data_url = $("#load_type_menu .select2 option:selected").attr('data-url');
                    $('#data_url').val(data_url);
                    var data_name = $.trim($("#load_type_menu .select2 option:selected").text().replace(/--\|/g, ""));
                    $('#name').val(data_name);
                    $('#load_type_menu .select2').change(function() {
                        var data_url = $("#load_type_menu .select2 option:selected").attr('data-url');
                        $('#data_url').val(data_url);
                        var data_name = $.trim($("#load_type_menu .select2 option:selected").text().replace(/--\|/g, ""));
                        $('#name').val(data_name);
                    });
                }
                if (repon.loai == 'outlink') {
                    $('#name').val('');
                    $('#report').val(null);
                    $('#load_type_menu .select2').hide();
                }
            }
        });
        // Load ajax when click
        $('.cus_loai_menu li').click(function() {
            // Active menu when click
            $('#cus_er_name').html('');
            $('.cus_loai_menu li').removeClass('active');
            $(this).addClass('active');

            var type = $(this).attr('data-type');
            $.ajax({
                type: "post",
                url: "<?= admin_url('menu/load_type_menu') ?>",
                data: {
                    type: type
                },
                success: function(data) {
                    var repon = $.parseJSON(data);
                    $('#load_type_menu label').html(repon.label);
                    $('#type_hide').html(repon.type_hide);
                    if (repon.loai == 'inlink') {
                        $('#report').html(repon.html);
                        $('#type_hide').html(repon.type_hide);
                        $('#load_type_menu .select2').show();
                        var data_url = $("#load_type_menu .select2 option:selected").attr('data-url');
                        $('#data_url').val(data_url);
                        var data_name = $.trim($("#load_type_menu .select2 option:selected").text().replace(/--\|/g, ""));
                        $('#name').val(data_name);
                        $('#load_type_menu .select2').change(function() {
                            var data_url = $("#load_type_menu .select2 option:selected").attr('data-url');
                            $('#data_url').val(data_url);
                            var data_name = $.trim($("#load_type_menu .select2 option:selected").text().replace(/--\|/g, ""));
                            $('#name').val(data_name);
                        });
                    }
                    if (repon.loai == 'outlink') {
                        $('#name').val('');
                        $('#report').val(null);
                        $('#load_type_menu .select2').hide();
                    }
                }
            });
        });
    });
</script>