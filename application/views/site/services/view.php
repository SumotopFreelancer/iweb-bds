<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= (isset($breadcrumb) && $breadcrumb) ? $breadcrumb : '' ?>
<?php if (isset($post) && $post) : ?>
  <div class="detail-service">
    <div class="container">
      <div class="max-960 py-40">
        <h1 class="text-center b"><?= $post->name ?></h1>
        <?php if ($post->content) : ?>
          <div class="block-editor-content b mt-20 itext-6"><?= $post->content ?></div>
        <?php endif; ?>
        <div class="share mt-30">
          <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d20664dcf478a1c"></script>
          <div class="addthis_inline_share_toolbox_7uan"></div>
        </div>
      </div>
    </div>
    <?php if (!empty($rely)) : ?>
      <div class="homeListService py-40 ibg-f1">
        <div class="container">
          <h2>THÔNG TIN LIÊN QUAN</h2>
          <div class="row">
            <?php foreach ($rely as $row) : ?>
              <div class="col-md-4 mt-30 position-relative text-center">
                <a href="<?= base_url(_dv . '/' . $row->url) ?>">
                  <div class="bg-img ratio-1-1 lazy" data-src="<?= check_image('', $row->img, TRUE) ?>">
                    <div class="text-white px-15 pb-15 pt-40 ibg-gradient ibg-absolute-bottom w-100 text-md"><?= $row->name ?></div>
                  </div>
                </a>
                <div class="mt-25">
                  <a href="<?= base_url(_dv . '/' . $row->url) ?>" class="ibg-primary text-white px-40 py-10 shadow rounded-lg d-inline-block btn-primary-hover border">XEM THÊM</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>