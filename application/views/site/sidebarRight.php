<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="mt-lg-0 mt-30">
	<?php if (!empty($sidebarReg)) : ?>
		<div class="sidebarReg rounded-sm shadow-center px-30 pt-30 pb-15">
			<h2 class="strong text-center"><?= $sidebarReg->title ?></h2>
			<div class="form-group mt-30">
				<div class="wInput position-relative">
					<i class="iwe iwe-user-dark"></i>
					<input class="form-control border-0 ibg-f1 b pl-30" name="name" placeholder="Nhập họ tên" type="text">
				</div>
			</div>
			<div class="form-group mb-10">
				<div class="wInput position-relative">
					<i class="iwe iwe-phone-dark"></i>
					<input class="form-control border-0 ibg-f1 b pl-30" name="phone" placeholder="Số điện thoại" type="number">
				</div>
			</div>
			<div class="note"></div>
			<button type="button" class="btn ibg-primary rounded-sm w-100 b text-white text-sm py-10 btnViewHome mt-10">ĐẶT NGAY</button>
			<div class="w-100 border rounded-sm py-10 text-center mt-15">
				<a href="tel:<?= check_phone(isJson($setAll->phone)->phone1) ?>" class="itext-red strong"><i class="iwe iwe-phone-red mr-10"></i><?= isJson($setAll->phone)->phone1 ?></a>
			</div>
		</div>
	<?php endif; ?>
	<?php if (!empty($sidebarProducts)) : ?>
		<div class="sidebarProduct rounded-sm shadow-center px-15 py-15 mt-30">
			<h2 class="strong itext-primary"><?= $sidebarProduct->title ?></h2>
			<div class="content border-top ibr-base-colord mt-15 pt-10">
				<div class="row">
					<?php foreach ($sidebarProducts as $row) : ?>
						<div class="col-md-6 text-xs">
							<a href="<?= base_url('tim-kiem?txtSearch=&district_id=' . $row['districtId'] . '&ward_id=' . $row['id'] . '&type=search') ?>" target="_blank">
								<span class="itext-primary"><?= $row['name'] ?></span> (<?= $row['total'] ?>)
							</a>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<?php if (!empty($sidebarBank)) : ?>
		<div class="sidebarBank rounded-sm mt-30">
			<h2 class="strong text-white ibg-primary px-15 py-15"><i class="iwe iwe-bank mr-10"></i><?= $sidebarBank->title ?></h2>
			<div class="content block-editor-content px-15 py-15"><?= $sidebarBank->content ?></div>
		</div>
	<?php endif; ?>
	<?php if (!empty($sidebarNews)) : ?>
		<div class="sidebarNew rounded-sm mt-30">
			<h2 class="strong text-white ibg-primary px-15 py-15"><i class="iwe iwe-bars-white mr-10"></i><?= $sidebarNew->title ?></h2>
			<ul class="py-15 px-15 shadow-center">
				<?php foreach ($sidebarNews as $key => $row) : ?>
					<li class="b <?= $key > 0 ? 'mt-15 pt-15 border-top ibr-top-dashed' : '' ?>">
						<a href="<?= base_url(_blog . '/' . $row->url) ?>">
							<div class="bg-img lazy" data-src="<?= check_image('', $row->img) ?>"></div>
							<div class="name-new line-3"><?= $row->name ?></div>
							<div class="clearfix"></div>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
</div>
<script>
	$('.btnViewHome').click(function() {
		$('.sidebarReg .note').find('.result').remove();
		var name = $(".sidebarReg input[name='name']").val();
		var phone = $(".sidebarReg input[name='phone']").val();
		var link = window.location.href;
		$.ajax({
			type: "post",
			dataType: 'json',
			url: "/contact-view",
			data: {
				name: name,
				phone: phone,
				link: link
			},
			beforeSend: function() {
				$('.btnViewHome').html('...');
				$('.btnViewHome').prop('disabled', true);
			},
			success: function(result) {
				$('.btnViewHome').html('ĐẶT NGAY');
				$('.btnViewHome').prop('disabled', false);
				if (result.status == 1) {
					$(".sidebarReg input[name='name']").val('');
					$(".sidebarReg input[name='phone']").val('');
					$('.sidebarReg .note').html(result.messenger);
				} else {
					$('.sidebarReg .note').html(result.error);
				}
			}
		})
	});
</script>