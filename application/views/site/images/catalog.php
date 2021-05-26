<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= (isset($breadcrumb) && $breadcrumb) ? $breadcrumb : '' ?>
<div class="catalog-service">
  <div class="box-service">
    <div class="container">
      <div class="info text-center mb-15">
        <h1 class="title mb-15"><?= $catalog->name ?></h1>
        <div class="intro"><?= $catalog->intro ?></div>
      </div>
      <?php if (isset($list) && $list) : ?>
        <div class="row">
          <?php foreach ($list as $key => $row) : ?>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="item mt-15">
                <a href="<?= base_url($row->image_link) ?>" data-fancybox="images<?= $key ?>" data-caption="<?= $row->name ?>">
                  <div class="bg-img bg-service lazy" data-src="<?= check_image($row->image_link) ?>">
                    <div class="info">
                      <h2 class="name"><?= $row->name ?></h2>
                    </div>
                  </div>
                </a>
                <?php if (isJson($row->image_list)) : ?>
                  <div class="d-none">
                    <?php foreach (isJson($row->image_list) as $img => $alt) : ?>
                      <a href="<?= base_url($img) ?>" data-fancybox="images<?= $key ?>" data-caption="<?= $alt ?>"></a>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <!-- Fancybox -->
        <link rel="stylesheet" href="<?= public_url('dist/fancybox/jquery.fancybox.min.css') ?>">
        <script src="<?= public_url('dist/fancybox/jquery.fancybox.min.js') ?>"></script>
      <?php endif; ?>
      <div class="box-pagination mt-15 mb-30"><?= $phantrang ?></div>
    </div>
  </div>
</div>