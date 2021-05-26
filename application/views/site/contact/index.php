<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= (isset($breadcrumb) && $breadcrumb) ? $breadcrumb : '' ?>
<div class="page-contact pt-40">
  <div class="container">
    <div class="max-960">
      <h1 class="text-center"><?= $contact->title ?></h1>
      <div class="block-editor-content mt-30"><?= $contact->info ?></div>
      <form method="POST" action="" class="mt-30" id="submitForm">
        <?php if (isset($message) && $message) : ?><?= $message ?><?php endif; ?>
        <div class="row">
          <div class="col-lg-5">
            <div class="form-group">
              <label><strong>Họ tên (*)</strong></label>
              <div class="wInput">
                <i class="iwe iwe-user-dark"></i>
                <input type="text" name="name" class="form-control" value="<?= set_value('name') ?>">
                <?php if (form_error('name')) : ?><span class="error text-danger"><?= form_error('name') ?></span><?php endif; ?>
              </div>
            </div>
            <div class="form-group">
              <label><strong>Điện thoại (*)</strong></label>
              <div class="wInput">
                <i class="iwe iwe-phone-dark"></i>
                <input type="number" name="phone" class="form-control" value="<?= set_value('phone') ?>">
                <?php if (form_error('phone')) : ?><span class="error text-danger"><?= form_error('phone') ?></span><?php endif; ?>
              </div>
            </div>
            <div class="form-group">
              <label><strong>Email (*)</strong></label>
              <div class="wInput">
                <i class="iwe iwe-email-dark"></i>
                <input type="email" name="email" class="form-control" value="<?= set_value('email') ?>">
                <?php if (form_error('email')) : ?><div class="error text-danger"><?= form_error('email') ?></div><?php endif; ?>
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="form-group d-none">
              <input type="text" name="address" class="form-control" value="<?= set_value('address') ?>">
              <?php if (form_error('address')) : ?><span class="error text-danger"><?= form_error('address') ?></span><?php endif; ?>
            </div>
            <div class="form-group">
              <label><strong>Nội dung liên lạc (*)</strong></label>
              <div class="wInput">
                <i class="iwe iwe-edit-dark"></i>
                <textarea rows="5" name="content" class="form-control"><?= set_value('content') ?></textarea>
                <?php if (form_error('content')) : ?><span class="error text-danger"><?= form_error('content') ?></span><?php endif; ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label><strong>Mã bảo vệ (*)</strong></label>
                  <?php $sess_captcha = $this->session->userdata('captcha'); ?>
                  <div class="captchare wInput">
                    <i class="iwe iwe-scurity-dark"></i>
                    <span class="captcha"><?= $sess_captcha['word']; ?></span>
                    <input type="text" class="form-control ipcaptcha" name="captcha" value="<?= set_value('captcha') ?>">
                    <?php if (form_error('captcha')) : ?><div class="error text-danger"><?= form_error('captcha') ?></div><?php endif; ?>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 d-flex justify-content-end align-items-end">
                <div class="form-group">
                  <button type="submit" class="btn btn-gui ibg-primary strong">GỬI</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="block-map mt-40"><object data="<?= $contact->map; ?>"></object></div>
</div>
<?php if ($this->input->post()) : ?>
  <script>
    $(function() {
      var offset = -80;
      $('html, body').animate({
        scrollTop: $("#submitForm").offset().top + offset
      }, 1000);
    });
  </script>
<?php endif; ?>