<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script src="<?= public_url('dist/bootstrap/bootstrap.min.js') ?>"></script>
<script src="<?= public_url('dist/mmenu/jquery.mmenu.js') ?>"></script>
<script src="<?= public_url('dist/carousel/owl.carousel.min.js') ?>"></script>
<script src="<?= public_url('dist/scripts/jquery.lazy.min.js') ?>"></script>
<script src="<?= public_url('dist/scripts/common.js') ?>"></script>
<?php /*
<div class="modal fade" id="addToCartDone" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">THÔNG BÁO</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body text-center text-success">Sản phẩm đã được thêm vào giỏ hàng!</div>
    </div>
  </div>
</div>
<script>
  $(".addToCart").click(function() {
    var type = $(this).attr('data-type');
    var id = $(this).attr('data-id');
    var redirect = $(this).attr('data-redirect');
    var qty = 1;
    if (type === 'detail') {
      qty = $("input[name='qty']").val();
    }
    if (type === 'detailHot') {
      qty = $("input[name='qtyHot']").val();
    }
    $.ajax({
      type: "post",
      url: "/gio-hang/them-vao-gio-hang",
      data: {
        id: id,
        qty: qty
      },
      beforeSend: function() {
        $('.addToCart').prop('disabled', true);
      },
      success: function(result) {
        $('.addToCart').prop('disabled', false);
        var data = $.parseJSON(result);
        if (data.status === 1) {
          if (redirect === 'true') {
            window.location.href = "<?= base_url('gio-hang') ?>"
          } else {
            $('.cart-ajax').html(data.qty);
            $('#addToCartDone').modal('toggle');
          }
        } else {
          console.log(data.messenger)
        }
      }
    });
  });
</script>
*/ ?>