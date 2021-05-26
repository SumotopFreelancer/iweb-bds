<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= (isset($breadcrumb) && $breadcrumb) ? $breadcrumb : '' ?>
<div class="container py-40" id="cartdone">
  <div class="row">
    <div class="col-lg-8">
      <div class="block-billing mb-30">
        <div class="block-title strong">ĐẶT HÀNG THÀNH CÔNG</div>
        <div class="block-content">
          <div class="message"><?= $this->setPage->cartdone; ?></div>
          <div class="block-info-cart mt-3">
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
                      <h3 class="card-title mb-0 p-1 pl-2">
                        <a href="<?= base_url($row['url']) ?>" target="_blank"><?= $row['name'] ?></a>
                      </h3>
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
                  <div class="col-6 total-price price text-right itext-red">
                    <div><span class="text-lg"><?= number_format($tonghoadon) ?></span><sup><?= _unit ?></sup></div>
                    <div class="text-xs itext-9">(Đã bao gồm VAT nếu có)</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-3 text-right mb-30">
        <a href="/" class="btn btn-home strong rounded-md px-20"><i class="iwe iwe-return-white mr-10"></i>Về trang chủ</a>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="block-billing-product mb-30">
        <div class="block-title strong">GIAO HÀNG & THANH TOÁN</div>
        <div class="block-content">
          <div class="customer">
            <div class="tcus">THÔNG TIN KHÁCH HÀNG</div>
            <p>Họ và tên: <b><?= $done['user_name'] ?></b></p>
            <p>Địa chỉ: <b><?= $done['user_address'] ?></b></p>
            <p>Số điện thoại: <b><?= $done['user_phone'] ?></b></p>
            <p>Email: <b><?= $done['user_email'] ?></b></p>
          </div>
          <?php if ($done['other_name'] || $done['other_address'] || $done['other_phone'] || $done['other_email']) : ?>
            <div class="other_customer">
              <div class="tcus">Giao hàng đến</div>
              <?php if ($done['other_name']) : ?><p>Họ và tên: <b><?= $done['other_name'] ?></b></p>
              <?php endif; ?>
              <?php if ($done['other_address']) : ?><p>Địa chỉ: <b><?= $done['other_address'] ?></b></p>
              <?php endif; ?>
              <?php if ($done['other_phone']) : ?><p>Số điện thoại: <b><?= $done['other_phone'] ?></b></p>
              <?php endif; ?>
              <?php if ($done['other_email']) : ?><p>Email: <b><?= $done['other_email'] ?></b></p>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          <?php if ($done['company_name'] || $done['company_email'] || $done['company_address'] || $done['company_mst']) : ?>
            <div class="company_customer">
              <div class="tcus">THÔNG TIN XUẤT HÓA ĐƠN</div>
              <?php if ($done['company_name']) : ?><p>Tên công ty: <b><?= $done['company_name'] ?></b></p>
              <?php endif; ?>
              <?php if ($done['company_address']) : ?><p>Địa chỉ: <b><?= $done['company_address'] ?></b></p>
              <?php endif; ?>
              <?php if ($done['company_email']) : ?><p>Email: <b><?= $done['company_email'] ?></b></p>
              <?php endif; ?>
              <?php if ($done['company_mst']) : ?><p>Mã số thuế: <b><?= $done['company_mst'] ?></b></p>
              <?php endif; ?>
            </div>
          <?php endif; ?>
          <?php if ($done['payment']) : ?>
            <div class="company_customer">
              <div class="tcus">PHƯƠNG THỨC THANH TOÁN</div>
              <div><b><?= $done['payment'] ?></b></div>
            </div>
          <?php endif; ?>
          <?php if ($done['message']) : ?>
            <div class="message mt-10">
              <div class="tcus">GHI CHÚ</div>
              <div class="mess-content"><?= $done['message'] ?></div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>