<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Dự án
    <a href="<?= admin_url('products/add') ?>" class="btn btn-success btn-flat">
      <i class="fa fa-plus-circle"></i> Thêm mới
    </a>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li class="active">Dự án</li>
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
        <form method="GET" action="<?= admin_url('products') ?>">
          <tr>
            <th style="width: 30%" colspan="2">
              <div class="input-group mb-0" style="width:100%">
                <span class="input-group-addon">Tên</span>
                <input name="name" value="<?= $this->input->get('name') ?>" type="text" class="form-control">
              </div>
            </th>
            <th style="width: 30%" colspan="2">
              <div class="form-group mb-0">
                <select name="catalog_id" class="form-control select2" style="width: 100%;">
                  <option value="">Loại dự án</option>
                  <?php if (!empty($catalog)) : ?>
                    <?php foreach ($catalog as $row) : ?>
                      <option <?= ($this->input->get('catalog_id') == $row->id) ? 'selected' : '' ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                      <?php if (count($this->catalog_model->menucon_admin($row->id)) > 0) : ?>
                        <?php foreach ($this->catalog_model->menucon_admin($row->id, check_sort($setadmin->sort_catalog)) as $cap2) : ?>
                          <option <?= ($this->input->get('catalog_id') == $cap2->id) ? 'selected' : '' ?> value="<?= $cap2->id ?>">--|<?= $cap2->name ?></option>
                          <?php if (count($this->catalog_model->menucon_admin($cap2->id)) > 0) : ?>
                            <?php foreach ($this->catalog_model->menucon_admin($cap2->id, check_sort($setadmin->sort_catalog)) as $cap3) : ?>
                              <option <?= ($this->input->get('catalog_id') == $cap3->id) ? 'selected' : '' ?> value="<?= $cap3->id ?>">--|--|<?= $cap3->name ?></option>
                              <?php if (count($this->catalog_model->menucon_admin($cap3->id)) > 0) : ?>
                                <?php foreach ($this->catalog_model->menucon_admin($cap3->id, check_sort($setadmin->sort_catalog)) as $cap4) : ?>
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
              <a href="<?= admin_url('products') ?>" title="Làm mới" class="btn btn-default" type="submit"><i class="fa fa-refresh"></i></a>
            </th>
          </tr>
          <tr>
            <th style="width: 20%">
              <select name="price_id" class="form-control select2" style="width: 100%;">
                <option value="">Mức giá</option>
                <?php if (!empty($priceSearch)) : ?>
                  <?php foreach ($priceSearch as $row) : ?>
                    <option <?= $this->input->get('price_id') == $row->id ? 'selected' : '' ?> value="<?= $row->id ?>"><?= $row->price_from ?> -> <?= $row->price_to ?> tỷ</option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </th>
            <th style="width: 20%">
              <select name="area_id" class="form-control select2" style="width: 100%;">
                <option value="">Diện tích</option>
                <?php if (!empty($areaSearch)) : ?>
                  <?php foreach ($areaSearch as $row) : ?>
                    <option <?= $this->input->get('area_id') == $row->id ? 'selected' : '' ?> value="<?= $row->id ?>">
                      <?php if ($row->area_from == 0) : ?>
                        <?= '<= ' . $row->area_to ?> m2
                      <?php elseif ($row->area_to == 0) : ?>
                        <?= '>= ' . $row->area_from ?> m2
                      <?php else : ?>
                        <?= $row->area_from ?> - <?= $row->area_to ?> m2
                      <?php endif; ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </th>
            <th style="width: 20%">
              <select name="direction_id" class="form-control select2" style="width: 100%;">
                <option value="">Chọn hướng</option>
                <?php if (!empty($directions)) : ?>
                  <?php foreach ($directions as $row) : ?>
                    <option <?= $this->input->get('direction_id') == $row->id ? 'selected' : '' ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </th>
            <th style="width: 20%">
              <select name="district_id" class="form-control select2" style="width: 100%;" id="district_id">
                <option value="">Chọn quận</option>
                <?php if (!empty($districts)) : ?>
                  <?php foreach ($districts as $row) : ?>
                    <option <?= $this->input->get('district_id') == $row->id ? 'selected' : '' ?> value="<?= $row->id ?>"><?= $row->name ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </th>
            <th style="width: 20%">
              <select name="ward_id" class="form-control select2" style="width: 100%;" id="ward_id">
                <option value="">Chọn phường</option>
              </select>
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
          <th>Loại dự án</th>
          <th>Ngày tạo</th>
          <th>Giá</th>
          <th class="text-center">Trạng thái</th>
          <th class="text-center">Nổi bật</th>
          <th class="text-center">Trang chủ</th>
          <th class="b-active">Hành động</th>
        </tr>
        <?php foreach ($list as $key => $row) : ?>
          <tr class='row_<?= $row->id ?>'>
            <td class="text-center"><input type="checkbox" name="id[]" value="<?= $row->id; ?>"></td>
            <td class="cus_td_50"><?= $key + 1 ?></td>
            <td>
              <div class="info-default">
                <div class="img"><img src="<?= check_image_admin($row->avatar) ?>"></div>
                <div class="name"><a class="text-black line-1" target="_blank" href="<?= base_url($row->catalogUrl . '/' . $row->url) ?>"><?= $row->name ?></a></div>
              </div>
            </td>
            <td><?= $row->catalogName ?></td>
            <td><?= get_date_admin($row->timer) ?></td>
            <td>
              <?php if ($row->price > 0) : ?>
                <b><?= number_format($row->price, 1) ?> tỷ</b>
              <?php else : ?>
                <b>Liên hệ</b>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <a id="statusajax<?= $row->id ?>" class="statusajax thea" data-id="<?= $row->id ?>" href="javascript:void(0)">
                <?php if ($row->status == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                <?php if ($row->status == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
              </a>
            </td>
            <td class="text-center">
              <a id="highlightajax<?= $row->id ?>" class="highlightajax thea" data-id="<?= $row->id ?>" href="javascript:void(0)">
                <?php if ($row->highlight == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                <?php if ($row->highlight == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
              </a>
            </td>
            <td class="text-center">
              <a id="homeajax<?= $row->id ?>" class="homeajax thea" data-id="<?= $row->id ?>" href="javascript:void(0)">
                <?php if ($row->home == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                <?php if ($row->home == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
              </a>
            </td>
            <td class="b-active">
              <a href="<?= admin_url('products/edit/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-warning" title="Chỉnh sửa"><i class="fa fa-edit fa-fw"></i></a>
              <a href="<?= admin_url('products/delete/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="box-footer clearfix">
      <button type="button" class="btn btn-sm btn-danger btn_del_all" url="<?= admin_url('products/del_all') ?>">Xóa hết</button>
      <?= $phantrang ?>
    </div>
  </div>
</section>
<script>
  $(".statusajax").click(function() {
    var id = $(this).attr('data-id');
    $.ajax({
      type: "post",
      url: "<?= admin_url('products/status') ?>",
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
  $(".highlightajax").click(function() {
    var id = $(this).attr('data-id');
    $.ajax({
      type: "post",
      url: "<?= admin_url('products/highlight') ?>",
      data: {
        id: id
      },
      beforeSend: function() {
        $('#highlightajax' + id).html('<i class="fa fa-spinner fa-spin"></i>');
      },
      success: function(data) {
        $('#highlightajax' + id).html(data);
      }
    });
  });
  $(".homeajax").click(function() {
    var id = $(this).attr('data-id');
    $.ajax({
      type: "post",
      url: "<?= admin_url('products/home') ?>",
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
  var district_id_trigger = "<?= $this->input->get('district_id') ?>";
  var ward_id_trigger = "<?= $this->input->get('ward_id') ?>";
  if (district_id_trigger > 0) {
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: "<?= admin_url('products/ajax_get_ward') ?>",
      data: {
        district_id: district_id_trigger,
        ward_id: ward_id_trigger
      },
      success: function(result) {
        if (result.status == 1 || result.status == 0) {
          $('#ward_id').html(result.html);
        } else {
          console.log(result);
        }
      }
    });
  }
</script>