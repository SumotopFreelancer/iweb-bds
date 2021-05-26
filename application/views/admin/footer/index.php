<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Cài đặt Footer</h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li class="active">Cài đặt Footer</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form">
        <?php $this->load->view('admin/message', $this->data); ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Footer 1</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="title_footer1" value="<?= htmlentities(isJson($setadmin->footer1)->title) ?>" class="form-control" placeholder="Nhập tiêu đề">
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea name="content_footer1" class="form-control editor"><?= isJson($setadmin->footer1)->content ?></textarea>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Footer 2</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="title_footer2" value="<?= htmlentities(isJson($setadmin->footer2)->title) ?>" class="form-control" placeholder="Nhập tiêu đề">
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea name="content_footer2" class="form-control editor"><?= isJson($setadmin->footer2)->content ?></textarea>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Footer 3</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="title_footer3" value="<?= htmlentities(isJson($setadmin->footer3)->title) ?>" class="form-control" placeholder="Nhập tiêu đề">
                </div>
                <div class="form-group hidden">
                    <label>Nội dung</label>
                    <textarea name="content_footer3" class="form-control editor"><?= isJson($setadmin->footer3)->content ?></textarea>
                </div>
            </div>
        </div>
        <div class="box hidden">
            <div class="box-header with-border">
                <h3 class="box-title">Footer 4</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="title_footer4" value="<?= htmlentities(isJson($setadmin->footer4)->title) ?>" class="form-control" placeholder="Nhập tiêu đề">
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <textarea name="content_footer4" class="form-control editor"><?= isJson($setadmin->footer4)->content ?></textarea>
                </div>
            </div>
        </div>
        <div class="box-footer clearfix">
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
        </div>
    </form>
</section>