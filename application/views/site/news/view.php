<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= (isset($breadcrumb) && $breadcrumb) ? $breadcrumb : '' ?>
<?php if (isset($post) && $post) : ?>
  <div class="page-detail-news py-40">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h1><?= $post->name ?></h1>
          <div class="block-editor-content tableOfContent mt-20 itext-6">
            <div class="content text-justify"><?= $post->content ?></div>
          </div>
          <div class="share mt-30">
            <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d20664dcf478a1c"></script>
            <div class="addthis_inline_share_toolbox_7uan"></div>
          </div>
          <?php if (!empty($tags)) : ?>
            <div class="tags mt-20">
              <span class="strong d-inline-block mt-1 text-nowrap mr-15 b"><i class="iwe iwe-tags mr-10"></i>Tags:</span>
              <?php foreach ($tags as $row) : ?>
                <a class="px-15 py-1 ibg-f1 rounded-sm b mt-10 mr-10 text-nowrap d-inline-block itext-primary text-xs" href="<?= base_url(_tags . '/' . $row->url) ?>"><?= $row->name ?></a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          <div class="row mt-15">
            <div class="col-6">
              <?php if (isset($post_prev) && $post_prev) : ?>
                <a class="itext-primary strong text-md" href="<?= base_url(_blog . '/' . $post_prev->url) ?>"><i class="iwe iwe-arrow-left-primary-md mr-10"></i>Bài trước</a>
              <?php endif; ?>
            </div>
            <div class="col-6 text-right">
              <?php if (isset($post_next) && $post_next) : ?>
                <a class="itext-primary strong text-md" href="<?= base_url(_blog . '/' . $post_next->url) ?>">Bài sau<i class="iwe iwe-arrow-right-primary-md ml-10"></i></a>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <?php $this->load->view('site/sidebarRight', $this->data); ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>