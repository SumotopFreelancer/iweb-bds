<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= (isset($breadcrumb) && $breadcrumb) ? $breadcrumb : '' ?>
<div class="block-checkout-page py-40">
  <div class="container">
    <div class="row">
      <div class="col-lg-7">
        <form id="checkoutForm" action="<?= base_url('thong-tin-thanh-toan'); ?>" method="POST">
          <h2 class="mb-10 strong itext-primary mb-20">THÔNG TIN GIAO HÀNG</h2>
          <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Họ và tên (*)" value="<?= set_value('name') ?>">
            <?php if (form_error('name')) : ?><span class="er"><?= form_error('name') ?></span><?php endif; ?>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" value="<?= set_value('email') ?>">
            <?php if (form_error('email')) : ?><span class="er"><?= form_error('email') ?></span><?php endif; ?>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="phone" placeholder="Số điện thoại (*)" value="<?= set_value('phone') ?>">
            <?php if (form_error('phone')) : ?><span class="er"><?= form_error('phone') ?></span><?php endif; ?>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="address" placeholder="Địa chỉ (*)" value="<?= set_value('address') ?>">
            <?php if (form_error('address')) : ?><span class="er"><?= form_error('address') ?></span><?php endif; ?>
          </div>
          <div class="mb-4">
            <div class="mb-2 custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="frmCheck1">
              <label class="custom-control-label" for="frmCheck1">Giao hàng đến địa chỉ khác</label>
            </div>
            <div id="content-checkbox-1" class="form-content-checkbox mt-3" style="display: none;">
              <div class="form-group">
                <input type="text" class="form-control" name="other_name" placeholder="Họ và tên">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="other_email" placeholder="Email">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="other_phone" placeholder="Số điện thoại">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="other_address" placeholder="Địa chỉ">
              </div>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="frmCheck2">
              <label class="custom-control-label" for="frmCheck2">Yêu cầu xuất hóa đơn</label>
            </div>
            <div id="content-checkbox-2" class="form-content-checkbox mt-3" style="display: none;">
              <div class="form-group">
                <input type="text" class="form-control" name="company_name" placeholder="Tên công ty">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="company_email" placeholder="Email">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="company_mst" placeholder="Mã số thuế">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="company_address" placeholder="Địa chỉ">
              </div>
            </div>
          </div>
          <h2 class="mb-10 strong itext-primary mb-20">HÌNH THỨC THANH TOÁN</h2>
          <div class="card accordion payment-accordion mb-2" id="payment-accordion">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <h5 class="heading">
                  <input type="radio" value="COD" name="payment" id="radio-payment-2" data-toggle="collapse" data-target="#payment2" aria-expanded="true" checked="checked">
                  <label for="radio-payment-2">COD</label>
                </h5>
                <div id="payment2" class="collapse show" data-parent="#payment-accordion">
                  <div class="inner text-center">Thanh toán khi nhận hàng</div>
                </div>
              </li>
              <?php if ($this->setPage->nganhang) : ?>
                <li class="list-group-item">
                  <h5 class="heading">
                    <input type="radio" value="Chuyển khoản" name="payment" id="radio-payment-1" data-toggle="collapse" data-target="#payment1" aria-expanded="true">
                    <label for="radio-payment-1">Chuyển khoản qua ngân hàng</label>
                  </h5>
                  <div id="payment1" class="collapse" data-parent="#payment-accordion">
                    <div class="inner text-center"><?= $this->setPage->nganhang ?></div>
                  </div>
                </li>
              <?php endif; ?>
            </ul>
          </div>
          <div class="form-group">
            <textarea rows="5" class="form-control" name="message" placeholder="Ghi chú"><?= set_value('message') ?></textarea>
          </div>
          <div class="row align-items-center">
            <div class="col-5">
              <a href="<?= base_url('gio-hang') ?>" class="btn-text-link itext-red"><i class="iwe iwe-arrow-left-double-red"></i> GIỎ HÀNG</a>
            </div>
            <div class="col-7 text-right">
              <button type="submit" class="btn btn-hoantat strong rounded-md px-20">Hoàn thành<i class="iwe iwe-arrow-right-long-white ml-10"></i></button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-5 mt-lg-0 mt-30">
        <div class="block-info-cart">
          <div class="block-card">
            <?php
            $tonghoadon = 0;
            foreach ($cart as $row) :
              $tonghoadon += $row['subtotal'];
            ?>
              <div class="card">
                <div class="row no-gutters">
                  <div class="col-sm-2 col-3">
                    <div class="image">
                      <div class="img">
                        <img src="<?= check_image('', $row['img'], TRUE) ?>" alt="<?= $row['name'] ?>">
                      </div>
                      <div class="quantity"><span><?= $row['qty'] ?></span></div>
                    </div>
                  </div>
                  <div class="col-sm-7 col-5">
                    <h4 class="card-title mb-0 p-1 pl-2 b">
                      <a href="<?= base_url($row['url']) ?>" target="_blank"><?= $row['name'] ?></a>
                    </h4>
                  </div>
                  <div class="col-sm-3 col-4">
                    <div class="card-body p-2 text-right">
                      <p class="price"><?= number_format($row['subtotal']) ?><sup><?= _unit ?></sup></p>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="card-button">
            <hr>
            <div class="block-notional-price">
              <div class="row price-group">
                <div class="col-6">Tạm tính:</div>
                <div class="col-6 price text-right"><?= number_format($tonghoadon) ?><sup><?= _unit ?></sup></div>
              </div>
              <hr>
            </div>
            <div class="block-total-price">
              <div class="row price-group align-items-center">
                <div class="col-6 total-label">Tổng cộng:</div>
                <div class="col-6 total-price price text-right itext-primary">
                  <div><span class="text-lg"><?= number_format($tonghoadon) ?></span><sup><?= _unit ?></sup></div>
                  <div class="text-xs itext-9">(Đã bao gồm VAT nếu có)</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#frmCheck1').on('click', function() {
    if ($(this).is(":checked")) {
      $("#content-checkbox-1").show();
    } else {
      $("#content-checkbox-1").hide();
    }
  });
  $('#frmCheck2').on('click', function() {
    if ($(this).is(":checked")) {
      $("#content-checkbox-2").show();
    } else {
      $("#content-checkbox-2").hide();
    }
  });
</script>