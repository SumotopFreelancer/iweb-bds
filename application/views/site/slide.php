<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (isset($slide_list) && $slide_list) : ?>
  <div id="slide" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <?php foreach ($slide_list as $key => $row) : ?>
        <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
          <a href="<?= $row->link ?>">
            <img class="d-block w-100" src="<?= $row->image_link ?>" alt="<?= $row->name ?>">
          </a>
        </div>
      <?php endforeach; ?>
    </div>
    <a class="control prev" href="#slide" role="button" data-slide="prev">
      <i class="iwe iwe-arrow-left-white"></i>
      <span class="sr-only">Prev</span>
    </a>
    <a class="control next" href="#slide" role="button" data-slide="next">
      <i class="iwe iwe-arrow-right-white"></i>
      <span class="sr-only">Next</span>
    </a>
  </div>
<?php endif; ?>