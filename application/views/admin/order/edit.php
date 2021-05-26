<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<section class="content-header">
  <h1>Chi tiết đơn hàng</h1>
  <ol class="breadcrumb">
    <li><a href="<?= admin_url() ?>"><i class="fa fa-dashboard"></i>Bảng điều khiển</a></li>
    <li><a href="<?= admin_url('order') ?>">Đơn hàng</a></li>
    <li class="active">Chi tiết</li>
  </ol>
</section>
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title text-blue"><b>I - TÌNH TRẠNG ĐƠN HÀNG</b></h3>
      <?= ($info->status == 1) ? '<span class="label label-warning ml-2"><i class="fa fa-spinner"></i> Đang xử lý</span>' : '' ?>
      <?= ($info->status == 2) ? '<span class="label label-success ml-2"><i class="fa fa-check"></i> Giao hàng thành công</span>' : '' ?>
      <?= ($info->status == 3) ? '<span class="label label-danger ml-2"><i class="fa fa-times"></i> Hủy đơn hàng</span>' : '' ?>
    </div>
    <div class="msg"></div>
    <?php if ($info->status == 1) : ?>
      <div class="box-body">
        <div class="row">
          <div class="col-md-3" id="status">
            <div class="form-group no-margin">
              <select name="status" class="form-control select2" style="width: 100%;">
                <option value="">Chọn tình trạng</option>
                <option value="2">-- Giao hàng thành công</option>
                <option value="3">-- Hủy đơn hàng</option>
              </select>
            </div>
            <div class="error"></div>
          </div>
          <div class="col-md-7 hidden" id="note_admin">
            <div class="input-group no-margin">
              <span class="input-group-addon">Ghi chú</span>
              <input name="note_admin" type="text" class="form-control">
            </div>
            <div class="error"></div>
          </div>
          <div class="col-md-2 hidden" id="hoadon_veryfi">
            <div class="text-right">
              <button title="Cập nhật" class="btn btn-warning hoadon_veryfi" type="submit">Cập nhật</button>
            </div>
          </div>
        </div>
      </div>
    <?php else : ?>
      <div class="box-body table-responsive">
        <table class="table table-hover cus_text_mid">
          <tr class="btn-default text-center">
            <th>Thời gian</th>
            <th>Ghi chú</th>
            <th>Tình trạng</th>
          </tr>
          <tr>
            <td><?= get_date_admin($info->updated) ?></td>
            <td><?= $info->note_admin ?></td>
            <td>
              <?php if ($info->status == 2) : ?>
                <span class="label label-success"><i class="fa fa-check"></i> Giao hàng thành công</span>
              <?php endif; ?>
              <?php if ($info->status == 3) : ?>
                <span class="label label-danger"><i class="fa fa-times"></i> Hủy đơn hàng</span>
              <?php endif; ?>
            </td>
          </tr>
        </table>
      </div>
    <?php endif; ?>
  </div>
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title text-blue"><b>II - THÔNG TIN KHÁCH HÀNG</b></h3>
    </div>
    <div class="box-body p-15-30">
      <div class="mb-1">Đơn hàng: <b>#<?= str_pad($info->id, 6, '0', STR_PAD_LEFT) ?></b> - Ngày đặt: <b><?= get_date_admin($info->created) ?></b></div>
      <div class="row">
        <div class="col-md-6 order mb-1">
          <h4 class="text-tomato"><b>THÔNG TIN NGƯỜI ĐẶT</b></h4>
          <p><b>Họ tên: </b><?= $info->user_name ?></p>
          <p><b>Số điện thoại: </b><?= $info->user_phone ?></p>
          <p><b>Email: </b><?= $info->user_email ?></p>
          <p><b>Địa chỉ: </b><?= $info->user_address ?></p>
        </div>
        <?php if ($info->other_name || $info->other_email || $info->other_phone || $info->other_address) : ?>
          <div class="col-md-6 order mb-1">
            <h4 class="text-tomato"><b>THÔNG TIN NGƯỜI NHẬN</b></h4>
            <p><b>Họ tên: </b><?= $info->other_name ?></p>
            <p><b>Số điện thoại: </b><?= $info->other_phone ?></p>
            <p><b>Email: </b><?= $info->other_email ?></p>
            <p><b>Địa chỉ: </b><?= $info->other_address ?></p>
          </div>
        <?php endif ?>
        <?php if ($info->company_name || $info->company_email || $info->company_address || $info->company_mst) : ?>
          <div class="col-md-6 order mb-1">
            <h4 class="text-tomato"><b>THÔNG TIN XUẤT HÓA ĐƠN</b></h4>
            <p><b>Tên công ty: </b><?= $info->company_name ?></p>
            <p><b>Email: </b><?= $info->company_email ?></p>
            <p><b>Địa chỉ: </b><?= $info->company_address ?></p>
            <p><b>Mã số thuế: </b><?= $info->company_mst ?></p>
          </div>
        <?php endif ?>
        <div class="col-md-6 order mb-1">
          <h4 class="text-tomato"><b>HÌNH THỨC THANH TOÁN</b></h4>
          <p><b>Loại thanh toán: </b><?= $info->payment ?></p>
        </div>
        <?php if ($info->message) : ?>
          <div class="col-md-12 order mb-1">
            <h4 class="text-tomato"><b>GHI CHÚ</b></h4>
            <p><?= $info->message ?></p>
          </div>
        <?php endif ?>
      </div>
    </div>
  </div>
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title text-blue"><b>III - CHI TIẾT ĐƠN HÀNG</b></h3>
    </div>
    <div class="box-body table-responsive no-padding mailbox-messages">
      <table class="table table-hover cus_text_mid">
        <tr class="btn-default">
          <th class="text-center cus_td_50">STT</th>
          <th>Tên sản phẩm</th>
          <th class="text-center">SL</th>
          <th>Đơn giá</th>
          <th class="text-right">Tổng tiền <small>(VNĐ)</small></th>
        </tr>
        <?php if (isset($orderdetail) && $orderdetail) : ?>
          <?php foreach ($orderdetail as $key => $row) : ?>
            <tr>
              <td class="cus_td_50"><?= $key + 1 ?></td>
              <td>
                <?php if ($this->products_model->get_info($row->product_id)) :
                  $product = $this->products_model->get_info($row->product_id);
                ?>
                  <a href="<?= base_url($product->url) ?>"><?= $product->name ?></a>
                <?php else : ?>
                  <p><?= $row->product_name ?></p>
                  <p class="text-red">(Sản phẩm này đã bị xóa khỏi hệ thống)</p>
                <?php endif; ?>
              </td>
              <td class="text-center"><?= $row->qty ?></td>
              <td><?= number_format($row->price) ?></td>
              <td class="text-right"><?= number_format($row->amount); ?></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
        <tr>
          <th colspan="5" class="text-right">
            <h4>Tổng cộng: <b><?= number_format($info->amount) ?></b></h4>
          </th>
        </tr>
      </table>
    </div>
  </div>
</section>
<script type="text/javascript">
  $(document).ready(function() {
    $("select[name='status']").change(function() {
      var val = $(this).val();
      console.log(val);
      if (val > 0) {
        $('#note_admin').removeClass('hidden');
        $('#hoadon_veryfi').removeClass('hidden');
      } else {
        $('#note_admin').addClass('hidden');
        $('#hoadon_veryfi').addClass('hidden');
      }
    });
    $('.hoadon_veryfi').click(function() {
      if (!confirm('Bạn chắc chắn muốn cập nhật trạng thái?')) {
        return false;
      }
      var status = $("select[name='status']").val();
      var note_admin = $("input[name='note_admin']").val();
      var id = <?= $info->id ?>;
      $.ajax({
        type: "post",
        url: "<?= admin_url('order/updatestatus') ?>",
        data: {
          status: status,
          note_admin: note_admin,
          id: id
        },
        beforeSend: function() {
          $('.hoadon_veryfi').html('<i class="fa fa-spinner fa-spin"></i>');
          $('.hoadon_veryfi').prop('disabled', true);
        },
        success: function(data) {
          $('.hoadon_veryfi').html('Cập nhật');
          $('.hoadon_veryfi').prop('disabled', false);
          if (data == 1) {
            window.location.href = "<?= current_url() ?>";
          } else {
            var error = $.parseJSON(data);
            if (error.status) {
              $('#status .error').append('<label class="text-red">' + error.status + '</label>');
            }
            if (error.note_admin) {
              $('#note_admin .error').append('<label class="text-red">' + error.note_admin + '</label>');
            }
          }
        }
      })

    });
  });
</script>