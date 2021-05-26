<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= (isset($breadcrumb) && $breadcrumb) ? $breadcrumb : '' ?>
<?php $this->load->view('site/search', $this->data) ?>
<?php if (!empty($catalog)) : ?>
  <div class="productCate py-40">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h1><?= $catalog->name ?></h1>
          <?php if (!empty($data_child)) : ?>
            <?php foreach ($data_child as $key => $row) : ?>
              <div class="productHorizontal rounded-sm shadow-center <?= $key > 0 ? 'mt-15' : 'mt-30' ?>">
                <h3 class="strong mb-15 d-md-none d-block"><?= $row->name ?></h3>
                <a href="<?= base_url($row->catUrl . '/' . $row->url) ?>">
                  <div class="bg-img lazy <?= $row->proStock == 1 ? 'hasBuy' : '' ?>" data-src="<?= check_image('', $row->img) ?>">
                    <?php if ($row->proNew == 1) : ?>
                      <span class="icon-new">
                        <img src="<?= public_url('dist/images/icon-moi.png') ?>" alt="icon-new">
                      </span>
                    <?php endif; ?>
                    <?php if ($row->proStock  == 1) : ?>
                      <strong class="icon-buy text-white text-xs">ĐÃ BÁN</strong>
                    <?php endif; ?>
                  </div>
                  <div class="text px-15 py-10">
                    <div class="price itext-base-color strong">
                      Giá: <span class="itext-red text-md"><?= $row->price ? $row->price . ' tỷ' : 'Liên hệ' ?></span>
                    </div>
                    <h3 class="strong mt-10 d-md-block d-none"><?= $row->name ?></h3>
                    <div class="mt-15 itext-6 address"><i class="iwe iwe-address mr-10"></i><?= $row->address ?></div>
                    <div class="properties row itext-3">
                      <div class="col-md-3 col-6 d-md-none d-block">
                        <div class="district line-1 mt-10 ">
                          <?= $row->districtName ? $row->districtName : 'Đang cập nhật' ?>
                        </div>
                      </div>
                      <div class="col-md-3 col-6 d-md-none d-block">
                        <div class="ward line-1 mt-10 ">
                          <?= $row->wardName ? $row->wardName : 'Đang cập nhật' ?>
                        </div>
                      </div>
                      <div class="col-md-3 col-6">
                        <div class="bedroom line-1 mt-10 ">
                          <i class="iwe iwe-bedroom mr-1"></i><?= $row->bedroom ? $row->bedroom . ' phòng ngủ' : 'Đang cập nhật' ?>
                        </div>
                      </div>
                      <div class="col-md-3 col-6">
                        <div class="bathroom line-1 mt-10 ">
                          <i class="iwe iwe-bathroom mr-1"></i><?= $row->bathroom ? $row->bathroom . ' phòng tắm' : 'Đang cập nhật' ?>
                        </div>
                      </div>
                      <div class="col-md-3 col-6">
                        <div class="ratio line-1 mt-10 ">
                          <i class="iwe iwe-ratio mr-1"></i><?= $row->area_ratio ? $row->area_ratio : 'Đang cập nhật' ?>
                        </div>
                      </div>
                      <div class="col-md-3 col-6">
                        <div class="direction line-1 mt-10 ">
                          <i class="iwe iwe-direction mr-1"></i><?= $row->directionName ? $row->directionName : 'Đang cập nhật' ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                </a>
              </div>
            <?php endforeach; ?>
            <?php if (isset($phantrang) && $phantrang) : ?>
              <div class="box-pagination mt-30"><?= $phantrang ?></div>
            <?php endif; ?>
          <?php else : ?>
            <div class="mt-20">Không tìm thấy dự án!</div>
          <?php endif; ?>
        </div>
        <div class="col-lg-4">
          <?php $this->load->view('site/sidebarRight', $this->data) ?>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>