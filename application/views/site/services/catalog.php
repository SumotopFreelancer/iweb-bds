<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= isset($breadcrumb) && $breadcrumb ? $breadcrumb : '' ?>
<?php if (isset($catalog) && $catalog) : ?>
  <div class="homeListService py-40">
    <div class="container">
      <h2 class="text-lg text-center strong"><?= $catalog->title ?></h2>
      <?php if (!empty($data_child)) : ?>
        <div class="row">
          <?php foreach ($data_child as $row) : ?>
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
        <?php if ($phantrang) : ?>
          <div class="box-pagination mt-30"><?= $phantrang ?></div>
        <?php endif; ?>
      <?php else : ?>
        <div class="mt-30 text-center">Danh mục chưa có bài viết!</div>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>