<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= (isset($breadcrumb) && $breadcrumb) ? $breadcrumb : '' ?>
<div class="container block-cart-page py-40" id="pagecart">
  <div class="max-960">
    <div class="block-title text-center mb-30">
      <h1 class="b">Giỏ hàng của bạn</h1>
      <?php if ($total_items > 0) : ?>
        <div class="desc b itext-9">Bạn có <span class="cart-ajax itext-red strong"><?= $total_items ?></span> sản phẩm trong giỏ hàng</div>
      <?php else : ?>
        <div class="desc text-danger">Chưa có sản phẩm trong giỏ hàng!</div>
      <?php endif; ?>
    </div>
    <?php if ($total_items > 0) : ?>
      <div class="block-content">
        <?php
        $tonghoadon = 0;
        foreach ($cart as $key => $row) :
          $tonghoadon += $row['subtotal'];
        ?>
          <div class="card cus_delete<?= $key ?>">
            <div class="row align-items-stretch">
              <div class="col-md-1 col-sm-2 col-3 d-flex align-items-center">
                <img src="<?= check_image('', $row['img'], TRUE) ?>" class="img" alt="<?= $row['name'] ?>">
              </div>
              <div class="col-md-5 col-sm-6 col-9">
                <div class="card-body">
                  <h5 class="card-title truncate">
                    <a href="<?= base_url($row['url']) ?>" target="_blank"><?= $row['name'] ?></a>
                  </h5>
                  <?php if ($row['discount'] > 0 && $row['price_goc'] > $row['discount']) : ?>
                    <p class="card-text">
                      <span class="itext-red"><?= number_format($row['price']) ?><sup><?= _unit ?></sup></span>
                      <span class="price-old"><?= number_format($row['price_goc']) ?><sup><?= _unit ?></sup></span>
                    </p>
                  <?php else : ?>
                    <p class="card-text"><?= number_format($row['price_goc']) ?><sup><?= _unit ?></sup></p>
                  <?php endif; ?>
                  <div class="control">
                    <a href="javascript:void(0)" class="qty-dec" onclick="down($(this))">-</a>
                    <input type="number" name="qty" min="1" max="999" value="<?= $row['qty'] ?>" onchange="updateqty($(this))" data-proid="<?= $row['id'] ?>" data-rowid="<?= $row['rowid'] ?>" />
                    <a href="javascript:void(0)" class="qty-inc" onclick="up($(this))">+</a>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-sm-4 col-12 align-self-end text-right total-price-item">
                <div class="card-body itext-primary">
                  <span class="pricesub" id="cus_subtotal<?= $row['rowid'] ?>"><?= number_format($row['subtotal']) ?></span><sup><?= _unit ?></sup>
                </div>
              </div>
            </div>
            <a href="javascript:;" class="remove" data-rowid="<?= $row['rowid'] ?>" onclick="deleteqty($(this))"><i class="iwe iwe-close-light"></i></a>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="block-content">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 text-right">
            <div class="block-total-price">
              Tổng tiền: <span class="cus_tong"><?= number_format($tonghoadon) ?></span><sup><?= _unit ?></sup>
            </div>
            <div class="block-button-cart text-right mt-4">
              <a href="<?= base_url() ?>" class="btn btn-continue strong">TIẾP TỤC MUA HÀNG</a>
              <a href="<?= base_url('thong-tin-thanh-toan') ?>" class="btn btn-payment strong">THANH TOÁN</a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<script>
  // Update qty
  function updateqty(e) {
    var qty = e.val();
    if (qty <= 0) {
      qty = 1;
    }
    var rowid = e.attr('data-rowid');
    var proid = e.attr('data-proid');
    $.ajax({
      type: "post",
      url: "/gio-hang/cap-nhat-so-luong",
      data: {
        qty: qty,
        rowid: rowid,
        proid: proid
      },
      beforeSend: function() {
        $("input[name='qty']").prop('disabled', true);
      },
      success: function(result) {
        $("input[name='qty']").prop('disabled', false);
        var data = $.parseJSON(result);
        if (data.status === 1) {
          // Số lượng trong giỏ hàng
          $('.cart-ajax').html(data.qty);
          // cập nhật tong tien tung san pham trong gio hang
          $('#cus_subtotal' + rowid).html(data.subtotal);
          // cập nhật số lượng trong giỏ hàng
          $('[data-rowid="' + rowid + '"]').val(data.sl);
          // cập nhật tong tien trong gio hang
          $('span.cus_tong').html(data.total);
        } else {
          console.log(data.messenger);
        }
      }
    });
  }
  // Update
  function update(qty, rowid, proid) {
    if (qty <= 0) {
      qty = 1;
    }
    $.ajax({
      type: "post",
      url: "/gio-hang/cap-nhat-so-luong",
      data: {
        qty: qty,
        rowid: rowid,
        proid: proid
      },
      beforeSend: function() {
        $("input[name='qty']").prop('disabled', true);
      },
      success: function(result) {
        $("input[name='qty']").prop('disabled', false);
        var data = $.parseJSON(result);
        if (data.status === 1) {
          // Số lượng trong giỏ hàng
          $('.cart-ajax').html(data.qty);
          // cập nhật tong tien tung san pham trong gio hang
          $('#cus_subtotal' + rowid).html(data.subtotal);
          // cập nhật số lượng trong giỏ hàng
          $('[data-rowid="' + rowid + '"]').val(data.sl);
          // cập nhật tong tien trong gio hang
          $('span.cus_tong').html(data.total);
        } else {
          console.log(data.messenger);
        }
      }
    });
  }

  function down(e) {
    var val = e.parent('.control').find('input').val();
    if (val > 1)
      e.parent('.control').find('input').val(parseInt(val) - 1);
    // update
    var qty = e.parent('.control').find('input').val();
    var rowid = e.parent('.control').find('input').attr('data-rowid');
    var proid = e.parent('.control').find('input').attr('data-proid');
    update(qty, rowid, proid);
  }

  function up(e) {
    var val = e.parent('.control').find('input').val();
    if (val < 999)
      e.parent('.control').find('input').val(parseInt(val) + 1);
    // update
    var qty = e.parent('.control').find('input').val();
    var rowid = e.parent('.control').find('input').attr('data-rowid');
    var proid = e.parent('.control').find('input').attr('data-proid');
    update(qty, rowid, proid);
  }

  // Delete
  function deleteqty(e) {
    var rowid = e.attr('data-rowid');
    $.ajax({
      type: "post",
      url: "/gio-hang/xoa-san-pham-trong-gio-hang",
      data: {
        rowid: rowid
      },
      beforeSend: function() {
        e.prop('disabled', true);
      },
      success: function(result) {
        e.prop('disabled', false);

        var data = $.parseJSON(result);
        if (data.status === 1) {
          if (data.total <= 0) {
            $('#pagecart').find('.block-content').remove();
          } else {
            $('.cart-ajax').html(data.qty);
            $('span.cus_tong').html(data.total);
            $('#pagecart .block-content').find('.cus_delete' + idrow).remove();
          }
        }
      }
    });
  }
</script>