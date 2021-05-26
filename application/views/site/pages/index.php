<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= (isset($breadcrumb) && $breadcrumb) ? $breadcrumb : '' ?>
<?php if (isset($page) && $page) : ?>
  <div class="py-40">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h1><?= $page->name ?></h1>
          <div class="block-editor-content mt-20"><?= $page->content ?></div>
        </div>
        <div class="col-lg-4">
          <?php $this->load->view('site/sidebarRight', $this->data); ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>