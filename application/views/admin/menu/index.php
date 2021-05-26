<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Menu
    <a href="<?= admin_url('menu/add') ?>" class="btn btn-success btn-flat">
      <i class="fa fa-plus-circle"></i> Thêm mới
    </a>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li class="active">Menu</li>
  </ol>
</section>
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Danh sách</h3>
    </div>
    <?php $this->load->view('admin/message', $this->data); ?>
    <div class="msg"></div>
    <div class="box-body table-responsive no-padding mailbox-messages">
      <table class="table table-hover cus_text_mid" id="cus_menu_cus">
        <tr class="btn-default">
          <th class="cus_td_50">
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button>
          </th>
          <th>Tên</th>
          <th class="text-center">Thể loại</th>
          <th>Ngày tạo</th>
          <th class="text-center">Trạng thái</th>
          <th class="b-active">Hành động</th>
        </tr>
        <?php foreach ($menu as $row) : ?>
          <tr class='row_<?= $row->id ?>'>
            <td class="text-center"><input type="checkbox" name="id[]" value="<?= $row->id; ?>"></td>
            <td>
              <div><b><?= $row->name ?></b>
                <?php if (type_menu($row->type, $row->id_type)['error'] != 'ok') : ?>
                  <span class="label label-danger"><?= type_menu($row->type, $row->id_type)['error'] ?></span>
                <?php endif; ?>
              </div>
            </td>
            <td class="text-center">
              <span class="label label-primary"><?= type_menu($row->type, $row->id_type)['texttype'] ?></span>
            </td>
            <td><?= get_date_admin($row->created) ?></td>
            <td class="text-center">
              <a id="statusajax<?= $row->id ?>" class="statusajax thea" data-id="<?= $row->id ?>" href="javascript:void(0)">
                <?php if ($row->status == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                <?php if ($row->status == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
              </a>
            </td>
            <td class="b-active">
              <a data-toggle="modal" data-target="#modal-edit" class="btn btn-sm btn-social-icon btn-warning ed_ajax" title="Chỉnh sửa" data-id="<?= $row->id ?>" data-name="<?= $row->name ?>" data-parent="<?= $row->parent_id ?>" data-status="<?= $row->status ?>" data-order="<?= $row->sort_order ?>" data-url="<?= $row->url ?>" data-type="<?= $row->type ?>"><i class="fa fa-edit fa-fw"></i></a>
              <a href="<?= admin_url('menu/delete/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
            </td>
          </tr>
          <?php if ($row->child) : ?>
            <?php foreach ($row->child as $cap2) : ?>
              <tr class='row_<?= $cap2->id ?>'>
                <td class="text-center"><input type="checkbox" name="id[]" value="<?= $cap2->id; ?>"></td>
                <td>
                  <div>--|<?= $cap2->name ?>
                    <?php if (type_menu($cap2->type, $cap2->id_type)['error'] != 'ok') : ?>
                      <span class="label label-danger"><?= type_menu($cap2->type, $cap2->id_type)['error'] ?></span>
                    <?php endif; ?>
                  </div>
                </td>
                <td class="text-center">
                  <span class="label label-primary"><?= type_menu($cap2->type, $cap2->id_type)['texttype'] ?></span>
                </td>
                <td><?= get_date_admin($cap2->created) ?></td>
                <td class="text-center">
                  <a id="anhienajax<?= $cap2->id ?>" class="anhienajax thea" data-idanhien="<?= $cap2->id ?>" href="javascript:void(0)">
                    <?php if ($cap2->status == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                    <?php if ($cap2->status == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
                  </a>
                </td>
                <td class="b-active">
                  <a data-toggle="modal" data-target="#modal-edit" class="btn btn-sm btn-social-icon btn-warning ed_ajax" title="Chỉnh sửa" data-id="<?= $cap2->id ?>" data-name="<?= $cap2->name ?>" data-parent="<?= $cap2->parent_id ?>" data-status="<?= $cap2->status ?>" data-order="<?= $cap2->sort_order ?>" data-url="<?= $cap2->url ?>" data-type="<?= $cap2->type ?>"><i class="fa fa-edit fa-fw"></i></a>
                  <a href="<?= admin_url('menu/delete/' . $cap2->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
                </td>
              </tr>
              <?php if ($cap2->child) : ?>
                <?php foreach ($cap2->child as $cap3) : ?>
                  <tr class='row_<?= $cap3->id ?>'>
                    <td class="text-center"><input type="checkbox" name="id[]" value="<?= $cap3->id; ?>"></td>
                    <td>
                      <div>--|--|<?= $cap3->name ?>
                        <?php if (type_menu($cap3->type, $cap3->id_type)['error'] != 'ok') : ?>
                          <span class="label label-danger"><?= type_menu($cap3->type, $cap3->id_type)['error'] ?></span>
                        <?php endif; ?>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="label label-primary"><?= type_menu($cap3->type, $cap3->id_type)['texttype'] ?></span>
                    </td>
                    <td><?= get_date_admin($cap3->created) ?></td>
                    <td class="text-center">
                      <a id="anhienajax<?= $cap3->id ?>" class="anhienajax thea" data-idanhien="<?= $cap3->id ?>" href="javascript:void(0)">
                        <?php if ($cap3->status == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                        <?php if ($cap3->status == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
                      </a>
                    </td>
                    <td class="b-active">
                      <a data-toggle="modal" data-target="#modal-edit" class="btn btn-sm btn-social-icon btn-warning ed_ajax" title="Chỉnh sửa" data-id="<?= $cap3->id ?>" data-name="<?= $cap3->name ?>" data-parent="<?= $cap3->parent_id ?>" data-status="<?= $cap3->status ?>" data-order="<?= $cap3->sort_order ?>" data-url="<?= $cap3->url ?>" data-type="<?= $cap3->type ?>"><i class="fa fa-edit fa-fw"></i></a>
                      <a href="<?= admin_url('menu/delete/' . $cap3->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
                    </td>
                  </tr>
                  <?php if ($cap3->child) : ?>
                    <?php foreach ($cap3->child as $cap4) : ?>
                      <tr class='row_<?= $cap4->id ?>'>
                        <td class="text-center"><input type="checkbox" name="id[]" value="<?= $cap4->id; ?>"></td>
                        <td>
                          <div>--|--|--|<?= $cap4->name ?>
                            <?php if (type_menu($cap4->type, $cap4->id_type)['error'] != 'ok') : ?>
                              <span class="label label-danger"><?= type_menu($cap4->type, $cap4->id_type)['error'] ?></span>
                            <?php endif; ?>
                          </div>
                        </td>
                        <td class="text-center">
                          <span class="label label-primary"><?= type_menu($cap4->type, $cap4->id_type)['texttype'] ?></span>
                        </td>
                        <td><?= get_date_admin($cap4->created) ?></td>
                        <td class="text-center">
                          <a id="anhienajax<?= $cap4->id ?>" class="anhienajax thea" data-idanhien="<?= $cap4->id ?>" href="javascript:void(0)">
                            <?php if ($cap4->status == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                            <?php if ($cap4->status == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
                          </a>
                        </td>
                        <td class="b-active">
                          <a data-toggle="modal" data-target="#modal-edit" class="btn btn-sm btn-social-icon btn-warning ed_ajax" title="Chỉnh sửa" data-id="<?= $cap4->id ?>" data-name="<?= $cap4->name ?>" data-parent="<?= $cap4->parent_id ?>" data-status="<?= $cap4->status ?>" data-order="<?= $cap4->sort_order ?>" data-url="<?= $cap4->url ?>" data-type="<?= $cap4->type ?>"><i class="fa fa-edit fa-fw"></i></a>
                          <a href="<?= admin_url('menu/delete/' . $cap4->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="box-footer clearfix">
      <button type="button" class="btn btn-sm btn-danger btn_del_all" url="<?= admin_url('menu/del_all') ?>">Xóa hết</button>
    </div>
  </div>
</section>
<div class="modal fade" id="modal-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Chỉnh sửa <small></small></h4>
      </div>
      <div class="modal-body">
        <div class="msg_mu"></div>
        <input type="hidden" name="id">
        <div class="form-group">
          <label>Tên menu <span class="label label-danger">(Bắt buộc) <span id="cus_er_name"></span></span></label>
          <input type="text" name="name" class="form-control" placeholder="Nhập tên menu">
        </div>
        <div class="form-group" id="checktype">
          <label>Liên kết</label>
          <input id="h-url" type="url" name="url" class="form-control" placeholder="http://">
        </div>
        <div class="form-group">
          <label>Menu cha</label>
          <select name="parent_id" class="form-control select2" style="width: 100%;">
            <option value="">Là menu cha</option>
            <?php if (isset($menu) && $menu) : ?>
              <?php foreach ($menu as $row) : ?>
                <option value="<?= $row->id ?>"><?= $row->name ?></option>
                <?php if (count($this->menu_model->menucon_admin($row->id)) > 0) : ?>
                  <?php foreach ($this->menu_model->menucon_admin($row->id) as $cap2) : ?>
                    <option value="<?= $cap2->id ?>">--|<?= $cap2->name ?></option>
                    <?php if (count($this->menu_model->menucon_admin($cap2->id)) > 0) : ?>
                      <?php foreach ($this->menu_model->menucon_admin($cap2->id) as $cap3) : ?>
                        <option value="<?= $cap3->id ?>">--|--|<?= $cap3->name ?></option>
                        <?php if (count($this->menu_model->menucon_admin($cap3->id)) > 0) : ?>
                          <?php foreach ($this->menu_model->menucon_admin($cap3->id) as $cap4) : ?>
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
          <input type="number" name="sort_order" class="form-control" placeholder="Nhập thứ tự">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Tắt</button>
        <button type="button" class="btn btn-primary cus_update_menu"><i class="fa fa-floppy-o"></i> Lưu lại</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(".statusajax").click(function() {
    var id = $(this).attr('data-id');
    $.ajax({
      type: "post",
      url: "<?= admin_url('menu/status') ?>",
      data: {
        id: id
      },
      beforeSend: function() {
        $('#noibatajax' + id).html('<i class="fa fa-spinner fa-spin"></i>');
      },
      success: function(data) {
        $('#statusajax' + id).html(data);
      }
    });
  });

  $(".ed_ajax").click(function() {
    var id = $(this).attr('data-id');
    var name = $(this).attr('data-name');
    var url = $(this).attr('data-url');
    var parent_id = $(this).attr('data-parent');
    var status = $(this).attr('data-status');
    var sort_order = $(this).attr('data-order');
    var type = $(this).attr('data-type');
    $('#checktype').show();
    if (type != 'outlink') {
      $('#checktype').hide();
    }
    $('#modal-edit .modal-header').attr('data-type', type);
    $('#modal-edit .modal-header small').html(name);
    $("input[name='id']").val(id);
    $("input[name='name']").val(name);
    $("input[name='url']").val(url);
    $("select[name='parent_id']").val('').trigger("change");
    if (parent_id > 0) {
      $("select[name='parent_id']").val(parent_id).trigger("change");
    }
    $("select[name='status']").val(status);
    $("input[name='sort_order']").val(sort_order);
  });

  $('.cus_update_menu').click(function() {
    $('.msg_mu').find('.callout').remove()
    var id = $("input[name='id']").val();
    var name = $("input[name='name']").val();
    var url = $("input[name='url']").val();
    var parent_id = $("select[name='parent_id']").val();
    var status = $("select[name='status']").val();
    var sort_order = $("input[name='sort_order']").val();
    var type = $('#modal-edit .modal-header').attr('data-type');
    if (type != 'outlink') {
      var data_edit = {
        id: id,
        name: name,
        parent_id: parent_id,
        status: status,
        sort_order: sort_order
      }
    } else {
      var data_edit = {
        id: id,
        name: name,
        url: url,
        parent_id: parent_id,
        status: status,
        sort_order: sort_order
      }
    }
    $.ajax({
      type: "post",
      url: "<?= admin_url('menu/validationadd') ?>",
      data: {
        name: name
      },
      success: function(data) {
        if (data == 1) {
          editmenu(data_edit);
        } else {
          $('#cus_er_name').html($.parseJSON(data).name);
          $("input[name='name']").focus();
          return false;
        }
      }
    });
  });

  function editmenu(data) {
    $.ajax({
      type: "post",
      url: "<?= admin_url('menu/edit') ?>",
      data: data,
      success: function(data) {
        $('.msg_mu').html(data);
      }
    });
  }

  $("#modal-edit").on("hidden.bs.modal", function() {
    window.location.href = "<?= admin_url('menu') ?>";
  });
</script>