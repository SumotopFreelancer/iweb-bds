<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Phường
    <a href="<?= admin_url('ward/add') ?>" class="btn btn-success btn-flat">
      <i class="fa fa-plus-circle"></i> Thêm mới
    </a>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li class="active">Phường</li>
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
          <th>Quận</th>
          <th class="text-center">Sidebar</th>
          <th class="b-active text-center" style="width: 90px;">Hành động</th>
        </tr>
        <?php foreach ($list as $key => $row) : ?>
          <tr class='row_<?= $row->id ?>'>
            <td class="text-center"><input type="checkbox" name="id[]" value="<?= $row->id; ?>"></td>
            <td class="cus_td_50"><?= $key + 1 ?></td>
            <td><?= $row->name ?></td>
            <td><?= $row->districtName ?></td>
            <td class="text-center">
              <a id="sidebarajax<?= $row->id ?>" class="sidebarajax thea" data-id="<?= $row->id ?>" href="javascript:void(0)">
                <?php if ($row->sidebar == 0) : ?><i class="fa fa-times-circle-o"></i><?php endif ?>
                <?php if ($row->sidebar == 1) : ?><i class="fa fa-check-circle-o"></i><?php endif ?>
              </a>
            </td>
            <td class="b-active">
              <a href="<?= admin_url('ward/edit/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-warning" title="Chỉnh sửa"><i class="fa fa-edit fa-fw"></i></a>
              <a href="<?= admin_url('ward/delete/' . $row->id) ?>" class="btn btn-sm btn-social-icon btn-danger btn_del_one" title="Xóa"><i class="fa fa-trash-o fa-fw"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="box-footer clearfix">
      <button type="button" class="btn btn-sm btn-danger btn_del_all" url="<?= admin_url('ward/del_all') ?>">Xóa hết</button>
      <?= $phantrang ?>
    </div>
  </div>
</section>
<script>
  $(".sidebarajax").click(function() {
    var id = $(this).attr('data-id');
    $.ajax({
      type: "post",
      url: "<?= admin_url('ward/sidebar') ?>",
      data: {
        id: id
      },
      beforeSend: function() {
        $('#sidebarajax' + id).html('<i class="fa fa-spinner fa-spin"></i>');
      },
      success: function(data) {
        $('#sidebarajax' + id).html(data);
      }
    });
  });
</script>