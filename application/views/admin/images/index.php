<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Hình ảnh
    <a href="<?= admin_url('images/add') ?>" class="btn btn-success btn-flat">
      <i class="fa fa-plus-circle"></i> Thêm mới
    </a>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li class="active">Hình ảnh</li>
  </ol>
</section>
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Danh sách</h3> (<?= $total_rows ?>)
    </div>
    <?php $this->load->view('admin/message', $this->data); ?>
    <div class="msg"></div>
    <div class="box-body table-responsive no-padding mailbox-messages">
      <table class="table table-hover">
        <form method="GET" action="<?= admin_url('images') ?>">
          <tr>
            <th style="width: 30%">
              <div class="input-group">
                <span class="input-group-addon">Tên</span>
                <input name="name" value="<?= $this->input->get('name') ?>" type="text" class="form-control">
              </div>
            </th>
            <th style="width: 30%">
              <div class="form-group hidden">
                <select name="catalog_id" class="form-control select2" style="width: 100%;">
                  <option value="">Chọn danh mục</option>
                  <?php if (isset($catalog) && $catalog) : ?>
                    <?php foreach ($catalog as $row) : ?>
                      <option <?= ($this->input->get('catalog_id') == $row->id) ? 'selected' : '' ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                      <?php if (count($this->catalogimage_model->menucon_admin($row->id)) > 0) : ?>
                        <?php foreach ($this->catalogimage_model->menucon_admin($row->id, check_sort($setadmin->sort_catalog_image)) as $cap2) : ?>
                          <option <?= ($this->input->get('catalog_id') == $cap2->id) ? 'selected' : '' ?> value="<?= $cap2->id ?>">--|<?= $cap2->name ?></option>
                          <?php if (count($this->catalogimage_model->menucon_admin($cap2->id)) > 0) : ?>
                            <?php foreach ($this->catalogimage_model->menucon_admin($cap2->id, check_sort($setadmin->sort_catalog_image)) as $cap3) : ?>
                              <option <?= ($this->input->get('catalog_id') == $cap3->id) ? 'selected' : '' ?> value="<?= $cap3->id ?>">--|--|<?= $cap3->name ?></option>
                              <?php if (count($this->catalogimage_model->menucon_admin($cap3->id)) > 0) : ?>
                                <?php foreach ($this->catalogimage_model->menucon_admin($cap3->id, check_sort($setadmin->sort_catalog_image)) as $cap4) : ?>
                                  <option <?= ($this->input->get('catalog_id') == $cap4->id) ? 'selected' : '' ?> value="<?= $cap4->id ?>">--|--|--|<?= $cap4->name ?></option>
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
            </th>
            <th class="pull-right">
              <button title="Lọc" class="btn btn-warning" type="submit"><i class="fa fa-search"></i></button>
              <a href="<?= admin_url('images') ?>" title="Làm mới" class="btn btn-default" type="submit"><i class="fa fa-refresh"></i></a>
            </th>
          </tr>
        </form>
      </table>
      <table class="table table-hover cus_text_mid">
        <tr class="btn-default">
          <th class="cus_td_50">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
          </th>
          <th class="cus_td_50">STT</th>
          <th>Tên</th>
          <th>Danh mục</th>
          <th>Ngày tạo</th>
          <th class="text-center">Trạng thái</th>
          <th class="text-center">Trang chủ</th>
          <th class="b-active">Hành động</th>
        </tr>
        <?php foreach ($list as $key => $row) : ?>
          <tr class='row_<?= $row->id ?>'>
            <td class="text-center"><input type="checkbox" name="id[]" value="<?= $row->id; ?>"></td>
            <td class="cus_td_50"><?= $key + 1 ?></td>
            <td>
              <div class="info-default">
                <div class="img"><img src="<?= check_image_admin($row->image_link) ?>"></div>
                <div class="name"><a class="text-black" target="_blank" href="<?= site_url(_im . '/' . $row->url) ?>"><?= $row->name ?></a></div>
              </div>
            </td>
            <td><b class="line-1"><?= $this->catalogimage_model->get_info($row->catalog_id)->name ?></b></td>
            <td><?= get_date_admin($row->timer) ?></td>
            <td class="text-center">
              <a id="statusajax<?= $row->id ?>" class="statusajax thea" data-id="<?= $row->id ?>" href="javascript:void(0)">
                <?php if ($row->status == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                <?php if ($row->status == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
              </a>
            </td>
            <td class="text-center">
              <a id="homeajax<?= $row->id ?>" class="homeajax thea" data-id="<?= $row->id ?>" href="javascript:void(0)">
                <?php if ($row->home == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                <?php if ($row->home == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
              </a>
            </td>
            <td class="b-active">
              <a href="<?= admin_url('images/edit/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-warning" title="Chỉnh sửa"><i class="fa fa-edit fa-fw"></i></a>
              <a href="<?= admin_url('images/delete/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="box-footer clearfix">
      <button type="button" class="btn btn-sm btn-danger btn_del_all" url="<?= admin_url('images/del_all') ?>">Xóa hết</button>
      <?= $phantrang ?>
    </div>
  </div>
</section>
<script type="text/javascript">
  $(".statusajax").click(function() {
    var id = $(this).attr('data-id');
    $.ajax({
      type: "post",
      url: "<?= admin_url('images/status') ?>",
      data: {
        id: id
      },
      beforeSend: function() {
        $('#statusajax' + id).html('<i class="fa fa-spinner fa-spin"></i>');
      },
      success: function(data) {
        $('#statusajax' + id).html(data);
      }
    });
  });
  $(".homeajax").click(function() {
    var id = $(this).attr('data-id');
    $.ajax({
      type: "post",
      url: "<?= admin_url('images/home') ?>",
      data: {
        id: id
      },
      beforeSend: function() {
        $('#homeajax' + id).html('<i class="fa fa-spinner fa-spin"></i>');
      },
      success: function(data) {
        $('#homeajax' + id).html(data);
      }
    });
  });
</script>