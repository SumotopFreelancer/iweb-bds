<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Loại dự án
    <a href="<?= admin_url('catalog/add') ?>" class="btn btn-success btn-flat">
      <i class="fa fa-plus-circle"></i> Thêm mới
    </a>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li class="active">Loại dự án</li>
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
      <table class="table table-hover cus_text_mid">
        <tr class="btn-default">
          <th class="cus_td_50">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
          </th>
          <th class="cus_td_50">STT</th>
          <th>Tên</th>
          <th>Ngày tạo</th>
          <th class="text-center">Trạng thái</th>
          <th class="text-center">Trang chủ</th>
          <th class="b-active">Hành động</th>
        </tr>
        <?php $i = 1;
        foreach ($catalog as $row) : ?>
          <tr class='row_<?= $row->id ?>'>
            <td class="text-center"><input type="checkbox" name="id[]" value="<?= $row->id; ?>"></td>
            <td class="cus_td_50"><?= $i ?></td>
            <td>
              <a class="text-black" target="_blank" href="<?= base_url($row->url) ?>"><b><?= $row->name ?></b></a>
            </td>
            <td><?= get_date_admin($row->created) ?></td>
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
              <a href="<?= admin_url('catalog/edit/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-warning" title="Chỉnh sửa"><i class="fa fa-edit fa-fw"></i></a>
              <a href="<?= admin_url('catalog/delete/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
            </td>
          </tr>
          <?php if (count($this->catalog_model->menucon_admin($row->id)) > 0) : ?>
            <?php $j = $i + 1;
            foreach ($this->catalog_model->menucon_admin($row->id, check_sort($setadmin->sort_catalog)) as $lv1) : ?>
              <tr class='row_<?= $lv1->id ?>'>
                <td class="text-center"><input type="checkbox" name="id[]" value="<?= $lv1->id; ?>"></td>
                <td class="cus_td_50"><?= $j ?></td>
                <td><a class="text-black" target="_blank" href="<?= base_url($lv1->url) ?>">--|<?= $lv1->name ?></a></td>
                <td><?= get_date_admin($lv1->created) ?></td>
                <td class="text-center">
                  <a id="statusajax<?= $lv1->id ?>" class="statusajax thea" data-id="<?= $lv1->id ?>" href="javascript:void(0)">
                    <?php if ($lv1->status == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                    <?php if ($lv1->status == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
                  </a>
                </td>
                <?php /*
                <td class="text-center">
                  <a id="homeajax<?= $lv1->id ?>" class="homeajax thea" data-id="<?= $lv1->id ?>" href="javascript:void(0)">
                    <?php if ($lv1->home == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                    <?php if ($lv1->home == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
                  </a>
                </td>
                */ ?>
                <td class="b-active">
                  <a href="<?= admin_url('catalog/edit/' . $lv1->id) ?>" class="btn btn-sm btn-social-icon btn-warning" title="Chỉnh sửa"><i class="fa fa-edit fa-fw"></i></a>
                  <a href="<?= admin_url('catalog/delete/' . $lv1->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
                </td>
              </tr>
              <?php if (count($this->catalog_model->menucon_admin($lv1->id)) > 0) : ?>
                <?php $k = $j + 1;
                foreach ($this->catalog_model->menucon_admin($lv1->id, check_sort($setadmin->sort_catalog)) as $lv2) : ?>
                  <tr class='row_<?= $lv2->id ?>'>
                    <td class="text-center"><input type="checkbox" name="id[]" value="<?= $lv2->id; ?>"></td>
                    <td class="cus_td_50"><?= $k ?></td>
                    <td><a class="text-black" target="_blank" href="<?= base_url($lv2->url) ?>">--|--|<?= $lv2->name ?></a></td>
                    <td><?= get_date_admin($lv2->created) ?></td>
                    <td class="text-center">
                      <a id="statusajax<?= $lv2->id ?>" class="statusajax thea" data-id="<?= $lv2->id ?>" href="javascript:void(0)">
                        <?php if ($lv2->status == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                        <?php if ($lv2->status == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
                      </a>
                    </td>
                    <?php /*
                    <td class="text-center">
                      <a id="homeajax<?= $lv2->id ?>" class="homeajax thea" data-id="<?= $lv2->id ?>" href="javascript:void(0)">
                        <?php if ($lv2->home == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                        <?php if ($lv2->home == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
                      </a>
                    </td>
                    */ ?>
                    <td class="b-active">
                      <a href="<?= admin_url('catalog/edit/' . $lv2->id) ?>" class="btn btn-sm btn-social-icon btn-warning" title="Chỉnh sửa"><i class="fa fa-edit fa-fw"></i></a>
                      <a href="<?= admin_url('catalog/delete/' . $lv2->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
                    </td>
                  </tr>
                  <?php if (count($this->catalog_model->menucon_admin($lv2->id)) > 0) : ?>
                    <?php $l = $k + 1;
                    foreach ($this->catalog_model->menucon_admin($lv2->id, check_sort($setadmin->sort_catalog)) as $lv3) : ?>
                      <tr class='row_<?= $lv3->id ?>'>
                        <td class="text-center"><input type="checkbox" name="id[]" value="<?= $lv3->id; ?>"></td>
                        <td class="cus_td_50"><?= $l ?></td>
                        <td><a class="text-black" target="_blank" href="<?= base_url($lv3->url) ?>">--|--|--|<?= $lv3->name ?></a></td>
                        <td><?= get_date_admin($lv3->created) ?></td>
                        <td class="text-center">
                          <a id="statusajax<?= $lv3->id ?>" class="statusajax thea" data-id="<?= $lv3->id ?>" href="javascript:void(0)">
                            <?php if ($lv3->status == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                            <?php if ($lv3->status == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
                          </a>
                        </td>
                        <?php /*
                        <td class="text-center">
                          <a id="homeajax<?= $lv3->id ?>" class="homeajax thea" data-id="<?= $lv3->id ?>" href="javascript:void(0)">
                            <?php if ($lv3->home == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                            <?php if ($lv3->home == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
                          </a>
                        </td>
                        */ ?>
                        <td class="b-active">
                          <a href="<?= admin_url('catalog/edit/' . $lv3->id) ?>" class="btn btn-sm btn-social-icon btn-warning" title="Chỉnh sửa"><i class="fa fa-edit fa-fw"></i></a>
                          <a href="<?= admin_url('catalog/delete/' . $lv3->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
                        </td>
                      </tr>
                    <?php $l++;
                      $k++;
                      $j++;
                      $i++;
                    endforeach; ?>
                  <?php endif; ?>
                <?php $k++;
                  $j++;
                  $i++;
                endforeach; ?>
              <?php endif; ?>
            <?php $j++;
              $i++;
            endforeach; ?>
          <?php endif; ?>
        <?php $i++;
        endforeach; ?>
      </table>
    </div>
    <div class="box-footer clearfix">
      <button type="button" class="btn btn-sm btn-danger btn_del_all" url="<?= admin_url('catalog/del_all') ?>">Xóa hết</button>
    </div>
  </div>
</section>
<script type="text/javascript">
  $(".statusajax").click(function() {
    var id = $(this).attr('data-id');
    $.ajax({
      type: "post",
      url: "<?= admin_url('catalog/status') ?>",
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
      url: "<?= admin_url('catalog/home') ?>",
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