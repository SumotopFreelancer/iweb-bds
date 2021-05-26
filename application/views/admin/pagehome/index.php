<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Cài đặt trang chủ</h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li class="active">Cài đặt trang chủ</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form">
        <?php $this->load->view('admin/message', $this->data); ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">DỰ ÁN NỔI BẬT</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="homeProduct" value="<?= htmlentities($setadmin->homeProduct) ?>" class="form-control" placeholder="Nhập tiêu đề">
                </div>
                <div class="form-group">
                    <label>Check dự án <span class="text-red">"Nổi bật"</span></label>
                    <a href="<?= admin_url('products') ?>" class="btn btn-success">Cài đặt</a>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">LOẠI DỰ ÁN TRANG CHỦ</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Check loại dự án <span class="text-red">"Trang chủ"</span></label>
                    <a href="<?= admin_url('catalog') ?>" class="btn btn-success">Cài đặt</a>
                </div>
                <div class="form-group">
                    <label>Check dự án <span class="text-red">"Trang chủ"</span></label>
                    <a href="<?= admin_url('products') ?>" class="btn btn-success">Cài đặt</a>
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
                                <?php if (isJson($setadmin->seo)->image_link) : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><img class="img" src="<?= isJson($setadmin->seo)->image_link ?>"></div>
                                        <input type="hidden" name="image_link_seo" value="<?= isJson($setadmin->seo)->image_link ?>" class="cus_ckfinder image_link">
                                    </div>
                                    <span class="cus_delete_img" title="Xóa" onclick="deleteOneImg(this)"><i class="fa fa-times fa-fw"></i></span>
                                <?php else : ?>
                                    <div class="image_avata" onclick="openCKfinder(this)">
                                        <div class="show_img"><b>Chọn ảnh</b></div>
                                        <input type="hidden" class="cus_ckfinder image_link" name="image_link_seo">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title_seo" value="<?= htmlentities(isJson($setadmin->seo)->title) ?>" class="form-control" placeholder="Nhập title">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description_seo" class="form-control" rows="3" placeholder="Nhập description"><?= isJson($setadmin->seo)->description ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Keywords</label>
                            <textarea name="keyword_seo" class="form-control" rows="2" placeholder="Nhập keyword"><?= isJson($setadmin->seo)->keyword ?></textarea>
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
<script>
    $('.addItem').click(function() {
        var type = $(this).attr('data-type');
        var item = $(this).attr('data-item');
        if (type == 'support') {
            var img = item + 'Img[]';
            var name = item + 'Name[]';
            var intro = item + 'Intro[]';
            $(this).closest('.box-body').find('.boxParent').append('<div class="col-md-4 item"><div class="form-group relative"><div class="text-right"><span class="btn btn-xs btn-danger btn-flat" title="Xóa" onclick="delItem(this)">Xóa item</span></div><div class="tongimg"><div class="image_avata" onclick="openCKfinder(this)"><div class="show_img"><b>Chọn ảnh</b></div><input type="hidden" name="' + img + '" class="cus_ckfinder image_link"></div></div><input class="form-control" name="' + name + '" type="text" placeholder="Nhập tên"><textarea class="form-control" name="' + intro + '" rows="3" placeholder="Nhập nội dung"></textarea></div></div>');
        } else if (type == 'history') {
            var name = item + 'Title[]';
            var intro = item + 'Intro[]';
            $(this).closest('.box-body').find('.boxParent').append('<div class="col-md-6 item"><div class="form-group relative"><div class="text-right"><span class="btn btn-xs btn-danger btn-flat" title="Xóa" onclick="delItem(this)">Xóa item</span></div><input class="form-control" name="' + name + '" type="text" placeholder="Nhập tiêu đề"><input class="form-control" name="' + intro + '" type="text" placeholder="Nhập mô tả"></div></div>');
        } else if (type == 'partner') {
            var img = item + 'Img[]';
            var link = item + 'Link[]';
            $(this).closest('.box-body').find('.boxParent').append('<div class="col-md-3 item"><div class="form-group relative"><div class="text-right"><span class="btn btn-xs btn-danger btn-flat" title="Xóa" onclick="delItem(this)">Xóa item</span></div><div class="tongimg"><div class="image_avata" onclick="openCKfinder(this)"><div class="show_img"><b>Chọn ảnh</b></div><input type="hidden" name="' + img + '" class="cus_ckfinder image_link"></div></div><input class="form-control" name="' + link + '" type="text" placeholder="http://"></div></div>');
        }
    });

    function delItem(e) {
        $(e).parents('.item').remove();
    }
</script>