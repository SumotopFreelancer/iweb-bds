<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?= isset($breadcrumb) && $breadcrumb ? $breadcrumb : '' ?>
<?php $this->load->view('site/search', $this->data) ?>
<?php if (!empty($product)) : ?>
	<div class="proDetail py-40">
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<h1><?= $product->name ?>
						<?php if ($product->proStock == 1) : ?>
							<span class="ml-15 text-xs b ibg-red text-white px-15 py-1 rounded">Đã bán</span>
						<?php endif; ?>
					</h1>
					<div class="address mt-15">
						<i class="iwe iwe-district mr-10"></i><?= $product->address ? $product->address : 'Đang cập nhật' ?>
					</div>
					<div class="price mt-15 strong text-md">
						Giá: <span class="itext-red text-lg"><?= $product->price ? $product->price . ' tỷ' : 'Liên hệ' ?></span>
						<?php if ($product->priceType > 0) : ?>
							<span class="ml-20 <?= $product->priceType == 1 ? 'priceFixed' : 'priceBar' ?>">
								<?= $product->priceType == 1 ? 'Giá chốt' : 'Còn thương lượng' ?>
							</span>
						<?php endif; ?>
					</div>
					<div class="price mt-10 strong text-md">
						Diện tích tổng: <span class="itext-primary text-lg"><?= $product->area ? $product->area . ' m<sup>2</sup>' : 'Đang cập nhật' ?></span>
					</div>
					<div class="properties border-bottom border-top mt-15 pb-15">
						<div class="row">
							<div class="col-md-3 col-sm-6">
								<div class="bedroom line-1 mt-15">
									<i class="iwe iwe-bedroom mr-1"></i><?= $product->bedroom ? $product->bedroom . ' phòng ngủ' : 'Đang cập nhật' ?>
								</div>
							</div>
							<div class="col-md-3 col-sm-6">
								<div class="bathroom line-1 mt-15">
									<i class="iwe iwe-bathroom mr-1"></i><?= $product->bathroom ? $product->bathroom . ' phòng tắm' : 'Đang cập nhật' ?>
								</div>
							</div>
							<div class="col-md-3 col-sm-6">
								<div class="ratio line-1 mt-15">
									<i class="iwe iwe-ratio mr-1"></i><?= $product->area_ratio ? $product->area_ratio : 'Đang cập nhật' ?>
								</div>
							</div>
							<div class="col-md-3 col-sm-6">
								<div class="direction line-1 mt-15">
									<i class="iwe iwe-direction mr-1"></i><?= !empty($directionName) ? $directionName : 'Đang cập nhật' ?>
								</div>
							</div>
						</div>
					</div>
					<h2 class="strong mt-40">THÔNG TIN CHI TIẾT</h2>
					<div class="block-editor-content tableOfContent mt-20 itext-6">
						<div class="box_stick mt-30">
							<div class="outer">
								<div id="big" class="owl-carousel owl-theme">
									<div class="item">
										<a href="<?= check_image('', $product->image_link, TRUE) ?>" data-fancybox="gallery" data-caption="<?= $product->name ?>">
											<img src="<?= check_image('', $product->image_link, TRUE) ?>" alt="<?= $product->name ?>">
										</a>
									</div>
									<?php if (!empty($image_list)) : ?>
										<?php foreach ($image_list as $img => $alt) : ?>
											<div class="item">
												<a href="<?= check_image('', $img, TRUE) ?>" data-fancybox="gallery" data-caption="<?= $alt ?>">
													<img src="<?= check_image('', $img, TRUE) ?>" alt="<?= $alt ?>">
												</a>
											</div>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
								<div id="thumbs" class="owl-carousel owl-theme mt-10">
									<div class="item border">
										<div class="bg-img" style="background-image: url('<?= check_image('', $product->image_link, TRUE) ?>')"></div>
									</div>
									<?php if (!empty($image_list)) : ?>
										<?php foreach ($image_list as $img => $alt) : ?>
											<div class="item border">
												<div class="bg-img" style="background-image: url('<?= $img ?>')"></div>
											</div>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="content text-justify mt-30"><?= $product->content ?></div>
						<div class="text-center mt-20 phone">
							<a class="btn btn-success strong text-white mt-15 text-md" href="tel:<?= check_phone($product->phone) ?>"><i class="iwe iwe-call-phone mr-10"></i><?= $product->phone ?></a>
							<a class="btn ibg-primary strong text-white mt-15 text-sm" href="https://zalo.me/<?= check_phone($product->phone) ?>" target="_blank"><i class="iwe iwe-chat-now mr-10"></i>CHAT VỚI NGƯỜI BÁN</a>
						</div>
					</div>
					<?php if (!empty($rely)) : ?>
						<div class="rely mt-40">
							<h2 class="strong">DỰ ÁN LIÊN QUAN</h2>
							<?php foreach ($rely as $key => $row) : ?>
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
												Giá: <span class="itext-red text-md"><?= $row->price ? $row->price : 'Liên hệ' ?> tỷ</span>
											</div>
											<h3 class="strong mt-10 d-md-block d-none"><?= $row->name ?></h3>
											<div class="mt-15 itext-6 address"><i class="iwe iwe-address mr-10"></i><?= $row->address ?></div>
											<div class="properties row itext-3">
												<div class="col-md-3 col-6 d-md-none d-block">
													<div class="district line-1 mt-10">
														<?= $row->districtName ? $row->districtName : 'Đang cập nhật' ?>
													</div>
												</div>
												<div class="col-md-3 col-6 d-md-none d-block">
													<div class="ward line-1 mt-10">
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
						</div>
					<?php endif; ?>
				</div>
				<div class="col-lg-4">
					<?php $this->load->view('site/sidebarRight', $this->data); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
<!-- Fancybox -->
<link rel="stylesheet" href="<?= public_url('dist/fancybox/jquery.fancybox.min.css') ?>">
<script src="<?= public_url('dist/fancybox/jquery.fancybox.min.js') ?>"></script>
<script>
	// Slide
	$(document).ready(function() {
		// Slide && Fancybox
		var bigimage = $("#big");
		var thumbs = $("#thumbs");
		var syncedSecondary = true;
		bigimage
			.owlCarousel({
				items: 1,
				slideSpeed: 2000,
				nav: false,
				autoplay: true,
				dots: false,
				loop: true,
				responsiveRefreshRate: 200,
			})
			.on("changed.owl.carousel", syncPosition);

		thumbs
			.on("initialized.owl.carousel", function() {
				thumbs
					.find(".owl-item")
					.eq(0)
					.addClass("current");
			})
			.owlCarousel({
				items: 5,
				dots: false,
				nav: true,
				margin: 15,
				navText: [
					'<i class="iwe iwe-arrow-left-white"></i>',
					'<i class="iwe iwe-arrow-right-white"></i>'
				],
				smartSpeed: 200,
				slideSpeed: 500,
				slideBy: 4,
				responsiveRefreshRate: 100
			})
			.on("changed.owl.carousel", syncPosition2);

		function syncPosition(el) {
			var count = el.item.count - 1;
			var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

			if (current < 0) {
				current = count;
			}
			if (current > count) {
				current = 0;
			}
			thumbs
				.find(".owl-item")
				.removeClass("current")
				.eq(current)
				.addClass("current");
			var onscreen = thumbs.find(".owl-item.active").length - 1;
			var start = thumbs
				.find(".owl-item.active")
				.first()
				.index();
			var end = thumbs
				.find(".owl-item.active")
				.last()
				.index();

			if (current > end) {
				thumbs.data("owl.carousel").to(current, 100, true);
			}
			if (current < start) {
				thumbs.data("owl.carousel").to(current - onscreen, 100, true);
			}
		}

		function syncPosition2(el) {
			if (syncedSecondary) {
				var number = el.item.index;
				bigimage.data("owl.carousel").to(number, 100, true);
			}
		}
		thumbs.on("click", ".owl-item", function(e) {
			e.preventDefault();
			var number = $(this).index();
			bigimage.data("owl.carousel").to(number, 300, true);
		});

		$('#big .owl-item.cloned').find('a').removeAttr("data-fancybox");
	});
</script>