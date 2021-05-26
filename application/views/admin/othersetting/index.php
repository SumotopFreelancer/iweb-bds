<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
    <h1>Cài đặt khác</h1>
    <ol class="breadcrumb">
        <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
        <li class="active">Cài đặt khác</li>
    </ol>
</section>
<section class="content">
    <form action="" method="POST" id="form">
        <?php $this->load->view('admin/message', $this->data); ?>
        <div class="box collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">SẢN PHẨM</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body" style="display: none;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SẮP XẾP DANH MỤC: <a class="cTool" title="Thứ tự này ảnh hưởng đến giao diện quản trị và website"></a></label>
                            <select name="sort_catalog" class="form-control select2">
                                <option value="default" <?= $setadmin->sort_catalog == 'default' ? 'selected' : '' ?>>Mặc định (Mới tạo nằm trên)</option>
                                <option value="numAsc" <?= $setadmin->sort_catalog == 'numAsc' ? 'selected' : '' ?>>Thứ tự (Nhỏ -> Lớn)</option>
                                <option value="numDesc" <?= $setadmin->sort_catalog == 'numDesc' ? 'selected' : '' ?>>Thứ tự (Lớn -> Nhỏ)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SẮP XẾP SẢN PHẨM: <a class="cTool" title="Thứ tự này ảnh hưởng đến giao diện quản trị và website"></a></label>
                            <select name="sort_products" class="form-control select2">
                                <option value="default" <?= $setadmin->sort_products == 'default' ? 'selected' : '' ?>>Mặc định (Mới tạo nằm trên)</option>
                                <option value="numAsc" <?= $setadmin->sort_products == 'numAsc' ? 'selected' : '' ?>>Thứ tự (Nhỏ -> Lớn)</option>
                                <option value="numDesc" <?= $setadmin->sort_products == 'numDesc' ? 'selected' : '' ?>>Thứ tự (Lớn -> Nhỏ)</option>
                                <option value="timerDesc" <?= $setadmin->sort_products == 'timerDesc' ? 'selected' : '' ?>>Ngày xuất bản (Mới -> Cũ)</option>
                                <option value="timerAsc" <?= $setadmin->sort_products == 'timerAsc' ? 'selected' : '' ?>>Ngày xuất bản (Cũ -> Mới)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SỐ LƯỢNG HIỂN THỊ <small>(Trang con)</small>: <a class="cTool" title="Số lượng này chỉ ảnh hưởng đến giao diện website"></a></label>
                            <input type="number" name="pagination_catalog" value="<?= $setadmin->pagination_catalog ?>" class="form-control" placeholder="0">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SỐ LƯỢNG HIỂN THỊ <small>(Trang cha)</small>: <a class="cTool" title="Số lượng này chỉ ảnh hưởng đến giao diện website"></a></label>
                            <input type="number" name="limit_catalog" value="<?= $setadmin->limit_catalog ?>" class="form-control" placeholder="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">TIN TỨC</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body" style="display: none;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SẮP XẾP DANH MỤC: <a class="cTool" title="Thứ tự này ảnh hưởng đến giao diện quản trị và website"></a></label>
                            <select name="sort_catalog_new" class="form-control select2">
                                <option value="default" <?= $setadmin->sort_catalog_new == 'default' ? 'selected' : '' ?>>Mặc định (Mới tạo nằm trên)</option>
                                <option value="numAsc" <?= $setadmin->sort_catalog_new == 'numAsc' ? 'selected' : '' ?>>Thứ tự (Nhỏ -> Lớn)</option>
                                <option value="numDesc" <?= $setadmin->sort_catalog_new == 'numDesc' ? 'selected' : '' ?>>Thứ tự (Lớn -> Nhỏ)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SẮP XẾP TIN TỨC: <a class="cTool" title="Thứ tự này ảnh hưởng đến giao diện quản trị và website"></a></label>
                            <select name="sort_news" class="form-control select2">
                                <option value="default" <?= $setadmin->sort_news == 'default' ? 'selected' : '' ?>>Mặc định (Mới tạo nằm trên)</option>
                                <option value="numAsc" <?= $setadmin->sort_news == 'numAsc' ? 'selected' : '' ?>>Thứ tự (Nhỏ -> Lớn)</option>
                                <option value="numDesc" <?= $setadmin->sort_news == 'numDesc' ? 'selected' : '' ?>>Thứ tự (Lớn -> Nhỏ)</option>
                                <option value="timerDesc" <?= $setadmin->sort_news == 'timerDesc' ? 'selected' : '' ?>>Ngày xuất bản (Mới -> Cũ)</option>
                                <option value="timerAsc" <?= $setadmin->sort_news == 'timerAsc' ? 'selected' : '' ?>>Ngày xuất bản (Cũ -> Mới)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SỐ LƯỢNG HIỂN THỊ <small>(Trang con)</small>: <a class="cTool" title="Số lượng này chỉ ảnh hưởng đến giao diện website"></a></label>
                            <input type="number" name="pagination_catalog_new" value="<?= $setadmin->pagination_catalog_new ?>" class="form-control" placeholder="0">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SỐ LƯỢNG HIỂN THỊ <small>(Trang cha)</small>: <a class="cTool" title="Số lượng này chỉ ảnh hưởng đến giao diện website"></a></label>
                            <input type="number" name="limit_catalog_new" value="<?= $setadmin->limit_catalog_new ?>" class="form-control" placeholder="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">HÌNH ẢNH</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body" style="display: none;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SẮP XẾP DANH MỤC: <a class="cTool" title="Thứ tự này ảnh hưởng đến giao diện quản trị và website"></a></label>
                            <select name="sort_catalog_image" class="form-control select2">
                                <option value="default" <?= $setadmin->sort_catalog_image == 'default' ? 'selected' : '' ?>>Mặc định (Mới tạo nằm trên)</option>
                                <option value="numAsc" <?= $setadmin->sort_catalog_image == 'numAsc' ? 'selected' : '' ?>>Thứ tự (Nhỏ -> Lớn)</option>
                                <option value="numDesc" <?= $setadmin->sort_catalog_image == 'numDesc' ? 'selected' : '' ?>>Thứ tự (Lớn -> Nhỏ)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SẮP XẾP HÌNH ẢNH: <a class="cTool" title="Thứ tự này ảnh hưởng đến giao diện quản trị và website"></a></label>
                            <select name="sort_images" class="form-control select2">
                                <option value="default" <?= $setadmin->sort_images == 'default' ? 'selected' : '' ?>>Mặc định (Mới tạo nằm trên)</option>
                                <option value="numAsc" <?= $setadmin->sort_images == 'numAsc' ? 'selected' : '' ?>>Thứ tự (Nhỏ -> Lớn)</option>
                                <option value="numDesc" <?= $setadmin->sort_images == 'numDesc' ? 'selected' : '' ?>>Thứ tự (Lớn -> Nhỏ)</option>
                                <option value="timerDesc" <?= $setadmin->sort_images == 'timerDesc' ? 'selected' : '' ?>>Ngày xuất bản (Mới -> Cũ)</option>
                                <option value="timerAsc" <?= $setadmin->sort_images == 'timerAsc' ? 'selected' : '' ?>>Ngày xuất bản (Cũ -> Mới)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SỐ LƯỢNG HIỂN THỊ <small>(Trang con)</small>: <a class="cTool" title="Số lượng này chỉ ảnh hưởng đến giao diện website"></a></label>
                            <input type="number" name="pagination_catalog_image" value="<?= $setadmin->pagination_catalog_image ?>" class="form-control" placeholder="0">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SỐ LƯỢNG HIỂN THỊ <small>(Trang cha)</small>: <a class="cTool" title="Số lượng này chỉ ảnh hưởng đến giao diện website"></a></label>
                            <input type="number" name="limit_catalog_image" value="<?= $setadmin->limit_catalog_image ?>" class="form-control" placeholder="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">DỊCH VỤ</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body" style="display: none;">
                <div class="row">
                    <div class="col-md-3">
                        <label>SẮP XẾP DANH MỤC: <a class="cTool" title="Thứ tự này ảnh hưởng đến giao diện quản trị và website"></a></label>
                        <select name="sort_catalog_service" class="form-control select2">
                            <option value="default" <?= $setadmin->sort_catalog_service == 'default' ? 'selected' : '' ?>>Mặc định (Mới tạo nằm trên)</option>
                            <option value="numAsc" <?= $setadmin->sort_catalog_service == 'numAsc' ? 'selected' : '' ?>>Thứ tự (Nhỏ -> Lớn)</option>
                            <option value="numDesc" <?= $setadmin->sort_catalog_service == 'numDesc' ? 'selected' : '' ?>>Thứ tự (Lớn -> Nhỏ)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SẮP XẾP DỊCH VỤ: <a class="cTool" title="Thứ tự này ảnh hưởng đến giao diện quản trị và website"></a></label>
                            <select name="sort_services" class="form-control select2">
                                <option value="default" <?= $setadmin->sort_services == 'default' ? 'selected' : '' ?>>Mặc định (Mới tạo nằm trên)</option>
                                <option value="numAsc" <?= $setadmin->sort_services == 'numAsc' ? 'selected' : '' ?>>Thứ tự (Nhỏ -> Lớn)</option>
                                <option value="numDesc" <?= $setadmin->sort_services == 'numDesc' ? 'selected' : '' ?>>Thứ tự (Lớn -> Nhỏ)</option>
                                <option value="timerDesc" <?= $setadmin->sort_services == 'timerDesc' ? 'selected' : '' ?>>Ngày xuất bản (Mới -> Cũ)</option>
                                <option value="timerAsc" <?= $setadmin->sort_services == 'timerAsc' ? 'selected' : '' ?>>Ngày xuất bản (Cũ -> Mới)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SỐ LƯỢNG HIỂN THỊ <small>(Trang con)</small>: <a class="cTool" title="Số lượng này chỉ ảnh hưởng đến giao diện website"></a></label>
                            <input type="number" name="pagination_catalog_service" value="<?= $setadmin->pagination_catalog_service ?>" class="form-control" placeholder="0">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SỐ LƯỢNG HIỂN THỊ <small>(Trang cha)</small>: <a class="cTool" title="Số lượng này chỉ ảnh hưởng đến giao diện website"></a></label>
                            <input type="number" name="limit_catalog_service" value="<?= $setadmin->limit_catalog_service ?>" class="form-control" placeholder="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">CÀI ĐẶT THÊM</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body" style="display: none;">
                <div class="form-group">
                    <label>CSS</label>
                    <div style="float: right;">
                        <label style="margin-right: 10px;">
                            <input type="radio" name="check_css" value="off" class="minimal" <?= $setadmin->check_css == 'off' ? 'checked' : '' ?>> Tắt
                        </label>
                        <label>
                            <input type="radio" name="check_css" value="on" class="minimal" <?= $setadmin->check_css == 'on' ? 'checked' : '' ?>> Bật
                        </label>
                    </div>
                    <textarea name="css" class="form-control" rows="50"><?= $css ?></textarea>
                </div>
                <div class="form-group">
                    <label>Copyright</label>
                    <textarea name="copyright" class="form-control editor"><?= $setadmin->copyright ?></textarea>
                </div>
            </div>
        </div>
        <div class="box-footer clearfix">
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-floppy-o"></i> Lưu lại</button>
        </div>
    </form>
</section>