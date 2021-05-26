<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= (isset($breadcrumb) && $breadcrumb) ? $breadcrumb : '' ?>
<?php if (isset($tag) && $tag) : ?>
  <div class="page-catalog-new py-40">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h1>Tag "<?= $tag->name ?>"</h1>
          <?php if (isset($list) && $list) : ?>
            <?php foreach ($list as $key => $row) : ?>
              <div class="item mt-30 b">
                <div class="row">
                  <div class="col-sm-4">
                    <a href="<?= base_url($row->urlCat . '/' . $row->url) ?>">
                      <div class="bg-img lazy ratio-3-2" data-src="<?= check_image('', $row->img) ?>"></div>
                    </a>
                  </div>
                  <div class=" col-sm-8 mt-sm-0 mt-3">
                    <a href="<?= base_url($row->urlCat . '/' . $row->url) ?>">
                      <h2 class="line-2 itext-primary"><?= $row->name ?></h2>
                      <div class="line-4 mt-sm-3 mt-10 itext-6"><?= $row->intro ?></div>
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            <?php if ($phantrang) : ?>
              <div class="box-pagination mt-30"><?= $phantrang ?></div>
            <?php endif; ?>
          <?php else : ?>
            <div class="mt-20">Không tìm thấy bài viết</div>
          <?php endif; ?>
        </div>
        <div class="col-lg-4">
          <?php $this->load->view('site/sidebarRight', $this->data); ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>