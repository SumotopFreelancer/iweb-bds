<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<footer class="footer ibg-2 pb-30">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <div class="item mt-30 text-white">
          <?php if (isJson($setAll->footer1)->title) : ?>
            <div class="text-md"><strong><?= isJson($setAll->footer1)->title ?></strong></div>
          <?php endif; ?>
          <?php if (isJson($setAll->footer1)->content) : ?>
            <div class="block-editor-content mt-10 itext-9"><?= isJson($setAll->footer1)->content ?></div>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-md-3">
        <div class="item mt-30 text-white">
          <?php if (isJson($setAll->footer2)->title) : ?>
            <div class="text-md"><strong><?= isJson($setAll->footer2)->title ?></strong></div>
          <?php endif; ?>
          <?php if (isJson($setAll->footer2)->content) : ?>
            <div class="block-editor-content mt-10 itext-9"><?= isJson($setAll->footer2)->content ?></div>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-md-4">
        <div class="item mt-30 text-white">
          <?php if (isJson($setAll->footer3)->title) : ?>
            <div class="text-md"><strong><?= isJson($setAll->footer3)->title ?></strong></div>
          <?php endif; ?>
          <div class="mt-10 footer-support">
            <div class="input-group mt-lg-0 mt-15 position-relative">
              <input type="text" class="form-control" placeholder="Nhập địa chỉ email" name="email">
              <button type="button" class="btn input-group-append input-group-text text-sm border-0 ibg-primary px-15 b btnEmailFooter"><i class="iwe iwe-paper-plane"></i></button>
            </div>
            <div class="note"></div>
            <script>
              $('.btnEmailFooter').click(function() {
                $('.footer-support .note').find('.result').remove();
                var email = $(".footer-support input[name='email']").val();
                $.ajax({
                  type: "post",
                  url: "/contact-email",
                  data: {
                    email: email
                  },
                  beforeSend: function() {
                    $('.btnEmailFooter').html('...');
                    $('.btnEmailFooter').prop('disabled', true);
                  },
                  success: function(result) {
                    $('.btnEmailFooter').html('<i class="iwe iwe-paper-plane"></i>');
                    $('.btnEmailFooter').prop('disabled', false);
                    var data = $.parseJSON(result);
                    if (data.status == 1) {
                      $(".footer-support input[name='email']").val('');
                      $('.footer-support .note').html(data.messenger);
                    } else {
                      $('.footer-support .note').html(data.error);
                    }
                  }
                })
              });
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>
<?php if ($setAll->copyright) : ?>
  <div class="footer-bot ibg-0 text-center py-10 itext-6 b"><?= $setAll->copyright ?></div>
<?php endif; ?>
<a id="return-to-top" class="td-scroll-up td-scroll-up-visible" href="javascript:void(0)"><img src="<?= public_url('dist/images/back-to-top.png') ?>" alt="return to top"></a>
<div class="widget-icon">
  <?php if (isJson($setAll->social)->id_facebook) : ?>
    <div class="messenger">
      <div class="box">
        <a href="https://www.messenger.com/t/<?= isJson($setAll->social)->id_facebook ?>" title="Chat ngay để nhận tư vấn" target="_blank" class="fl-google-messenger">
          <img src="/public/dist/images/default/widget-messenger.svg" alt="icon-messenger">
        </a>
        <div class="text text-xs">Chat ngay để nhận tư vấn</div>
      </div>
    </div>
  <?php endif; ?>
  <?php if (isJson($setAll->social)->zalo) : ?>
    <div class="zalo">
      <div class="box">
        <a href="https://zalo.me/<?= check_phone(isJson($setAll->social)->zalo) ?>" title="Chat với chúng tôi qua Zalo" target="_blank" class="fl-google-zalo">
          <img src="/public/dist/images/default/widget-zalo.svg" alt="icon-zalo">
        </a>
        <div class="text text-xs">Chat với chúng tôi qua Zalo</div>
      </div>
    </div>
  <?php endif; ?>
  <div class="call">
    <div class="box" data-toggle="modal" data-target="#widget-icon-phone">
      <a href="javascript:;" title="Gọi ngay" class="fl-google-call">
        <img src="/public/dist/images/default/widget-phone.svg" alt="icon-call">
      </a>
      <div class="text text-xs">Gọi ngay</div>
    </div>
  </div>
</div>
<div class="modal fade" id="widget-icon-phone" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
        <div class="content">
          <div class="title">Vui lòng để lại số điện thoại, chúng tôi sẽ gọi lại cho bạn sau 5 phút.</div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Số điện thoại của bạn" name="phone">
            <div class="input-group-append">
              <button class="btn btn-yeucau" type="button"><span>Yêu cầu gọi lại</span></button>
            </div>
          </div>
          <div class="note"></div>
          <?php if (isJson($setAll->phone)->phone1) : ?>
            <div class="other"><span>Hoặc</span></div>
            <div class="info text-center mt-3">
              <div class="title">Liên hệ với chúng tôi qua hotline:</div>
              <div class="hotline">
                <a href="tel:<?= check_phone(isJson($setAll->phone)->phone1) ?>"><?= isJson($setAll->phone)->phone1 ?></a>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <script>
        $('.btn-yeucau').click(function() {
          $('#widget-icon-phone .note').find('.alert').remove();
          var phone = $("#widget-icon-phone input[name='phone']").val();
          $.ajax({
            type: "post",
            url: "/contact-phone",
            data: {
              phone: phone
            },
            beforeSend: function() {
              $('.btn-yeucau>span').html('<i class="fa fa-spinner fa-spin"></i>');
              $('.btn-yeucau').prop('disabled', true);
            },
            success: function(result) {
              $('.btn-yeucau>span').html('Yêu cầu gọi lại');
              $('.btn-yeucau').prop('disabled', false);
              var data = $.parseJSON(result);
              if (data.status == 1) {
                $("#widget-icon-phone input[name='phone']").val('');
                $('#widget-icon-phone .note').html(data.messenger);
              } else {
                $('#widget-icon-phone .note').html(data.error);
              }
            }
          })
        });
      </script>
    </div>
  </div>
</div>