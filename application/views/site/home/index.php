<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('site/search', $this->data) ?>
<?php if (!empty($homeProducts)) : ?>
	<div class="homeProducts py-40 ibg-f1">
		<div class="container">
			<?php if (!empty($homeProduct)) : ?>
				<h1><i class="iwe iwe-highlight mr-10"></i><?= $homeProduct ?></h1>
			<?php endif; ?>
			<div class="owl-carousel owl-theme owlCustom mt-30">
				<?php foreach ($homeProducts as $row) : ?>
					<div class="item position-relative">
						<a href="<?= base_url($row->catUrl . '/' . $row->url) ?>">
							<div class="bg-img lazy ratio-3-2 rounded-sm position-relative <?= $row->proStock == 1 ? 'hasBuy' : '' ?>" data-src="<?= check_image('', $row->img) ?>">
								<?php if ($row->proNew == 1) : ?>
									<span class="icon-new">
										<img src="<?= public_url('dist/images/icon-moi.png') ?>" alt="icon-new">
									</span>
								<?php endif; ?>
								<?php if ($row->proStock  == 1) : ?>
									<strong class="icon-buy text-white text-xs">ĐÃ BÁN</strong>
								<?php endif; ?>
							</div>
							<div class="title mt-10 strong"><?= $row->name ?></div>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
			<script>
				$(document).ready(function() {
					$('.homeProducts .owl-carousel').owlCarousel({
						autoplay: true,
						autoplayTimeout: 3000,
						margin: 30,
						loop: false,
						nav: true,
						dots: false,
						navText: ['<i class="iwe iwe-arrow-left-white"></i>', '<i class="iwe iwe-arrow-right-white"></i>'],
						responsive: {
							0: {
								items: 1
							},
							575: {
								items: 2
							},
							991: {
								items: 4
							}
						}
					});
				});
			</script>
		</div>
	</div>
<?php endif; ?>
<?php if (!empty($homeProductByCatalog)) : ?>
	<div class="homeProductByCatalog py-40">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<?php foreach ($homeProductByCatalog as $key => $row) : ?>
						<div class="productBox rounded-sm cusSpace <?= $key > 0 ? 'mt-30' : '' ?>">
							<div class="productTitle d-flex align-items-center justify-content-between ibg-primary position-relative pl-15">
								<h2 class="strong text-uppercase">
									<a class="text-white" href="<?= base_url($row['url']) ?>">
										<i class="iwe iwe-cat mr-10"></i><?= $row['name'] ?>
									</a>
								</h2>
								<div class="w-50 productViewAll">
									<a class="itext-primary" href="<?= base_url($row['url']) ?>">Xem tất cả<i class="iwe iwe-arrow-right-double-primary ml-1"></i></a>
								</div>
							</div>
							<div class="productContent px-15 pb-15">
								<div class="row">
									<?php foreach ($row['products'] as $item) : ?>
										<div class="col-md-6 col-item">
											<div class="productItem shadow-center px-15 py-15 mt-15 rounded-sm">
												<a href="<?= base_url($item->catUrl . '/' . $item->url) ?>">
													<h3 class="strong"><?= $item->name ?></h3>
													<div class="bg-img lazy ratio-3-2 position-relative mt-15 <?= $item->proStock == 1 ? 'hasBuy' : '' ?>" data-src="<?= check_image('', $item->img) ?>">
														<?php if ($item->proNew == 1) : ?>
															<span class="icon-new">
																<img src="<?= public_url('dist/images/icon-moi.png') ?>" alt="icon-new">
															</span>
														<?php endif; ?>
														<?php if ($item->proStock  == 1) : ?>
															<strong class="icon-buy text-white text-xs">ĐÃ BÁN</strong>
														<?php endif; ?>
													</div>
													<div class="properties">
														<div class="d-md-none d-block">
															<strong class="itext-base-color">
																Giá: <span class="itext-red text-md"><?= $item->price ? $item->price . ' tỷ' : 'Liên hệ' ?></span>
															</strong>
														</div>
														<div class="mt-10 row">
															<div class="col-6">
																<div class="district py-1 line-1">
																	<i class="iwe iwe-district mr-10"></i><?= $item->districtName ? $item->districtName : 'Đang cập nhật' ?>
																</div>
															</div>
															<div class="col-6">
																<div class="ward py-1 line-1">
																	<i class="iwe iwe-ward mr-10"></i><?= $item->wardName ? $item->wardName : 'Đang cập nhật' ?>
																</div>
															</div>
															<div class="col-6">
																<div class="ratio py-1 line-1">
																	<i class="iwe iwe-ratio mr-10"></i><?= $item->area_ratio ? $item->area_ratio : 'Đang cập nhật' ?>
																</div>
															</div>
															<div class="col-6">
																<div class="direction py-1 line-1">
																	<i class="iwe iwe-direction mr-10"></i><?= $item->directionName ? $item->directionName : 'Đang cập nhật' ?>
																</div>
															</div>
															<div class="col-6">
																<div class="bedroom py-1 line-1">
																	<i class="iwe iwe-bedroom mr-10"></i><?= $item->bedroom ? $item->bedroom . ' phòng ngủ' : 'Đang cập nhật' ?>
																</div>
															</div>
															<div class="col-6">
																<div class="bathroom py-1 line-1">
																	<i class="iwe iwe-bathroom mr-10"></i><?= $item->bathroom ? $item->bathroom . ' phòng tắm' : 'Đang cập nhật' ?>
																</div>
															</div>
														</div>
														<div class="mt-10 d-none d-md-block">
															<div class="rounded-sm ibg-f1 text-center py-10">
																<strong class="itext-base-color">
																	Giá: <span class="itext-red text-md"><?= $item->price ? $item->price . ' tỷ' : 'Liên hệ' ?></span>
																</strong>
															</div>
														</div>
													</div>
													<div class="clearfix d-md-none d-block"></div>
												</a>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="col-lg-4">
					<?php $this->load->view('site/sidebarRight', $this->data) ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>