<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<header>
	<!-- Desktop -->
	<div class="d-none d-lg-block">
		<div class="header bg-img lazy py-20" data-src="<?= base_url($setAll->bannerHeader) ?>">
			<div class="container position-relative ">
				<div class="row">
					<div class="col-lg-3 d-flex align-items-center">
						<a href="/">
							<img src="<?= isJson($setAll->logo)->image_link ?>" alt="<?= isJson($setAll->logo)->name ?>">
						</a>
					</div>
					<div class="col-lg-6 d-flex align-items-center">
						<div class="slogan"><?= $setAll->slogan ?></div>
					</div>
					<div class="contact-header lazy" data-src="<?= public_url('dist/images/khung-hotline.png') ?>">
						<div class="content d-table">
							<div class="img d-table-cell pr-10">
								<img src="<?= public_url('dist/images/icon-hotline.png') ?>" alt="icon-hotline">
							</div>
							<div class="text d-table-cell itext-primary">
								<div class="phone text-md">
									<a href="tel:<?= check_phone(isJson($setAll->phone)->phone1) ?>" class="itext-primary"><?= isJson($setAll->phone)->phone1 ?></a>
									<?php if (isJson($setAll->phone)->phone2) : ?>
										- <a href="tel:<?= check_phone(isJson($setAll->phone)->phone2) ?>" class="itext-primary"><?= isJson($setAll->phone)->phone2 ?></a>
									<?php endif; ?>
								</div>
								<div class="email">
									<a href="mailto:<?= $setAll->email ?>" class="itext-primary"><?= $setAll->email ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('site/menu', $this->data) ?>
	</div>
	<!-- Mobile -->
	<div class="d-lg-none">
		<div class="block-mobile-nav text-center py-2 position-relative">
			<a class="p-3 btn-menu" href="#menu-mobi">
				<i class="iwe iwe-bars-primary"></i><span class="sr-only">Menu</span>
			</a>
			<a class="p-2" href="/"><img src="<?= isJson($setAll->logo)->image_link ?>" alt="<?= isJson($setAll->logo)->name ?>"></a>
		</div>
		<div class="nav-search border rounded-sm mx-15 position-relative mb-15 d-flex px-15 py-10 d-md-none">
			<i class="iwe iwe-search-primary"></i>
			<div class="text ml-15 itext-9">Nhập thông tin tìm kiếm</div>
		</div>
		<?php $this->load->view('site/menumobile', $this->data) ?>
	</div>
</header>