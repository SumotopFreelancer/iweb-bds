<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<nav class="menu-top">
	<ul class="nav-menu d-flex justify-content-center">
		<?php if (isset($menuDefault) && $menuDefault) : ?>
			<?php foreach ($menuDefault as $row) : ?>
				<li><a href="<?= re_menu($row->url, $row->type, $row->id_type) ?>"><?= $row->name ?><?= $row->child ? '<i class="iwe iwe-arrow-down ml-1"></i>' : '' ?></a>
					<?php if ($row->child) : ?>
						<ul class="submenu">
							<?php foreach ($row->child as $con) : ?>
								<li><a href="<?= re_menu($con->url, $con->type, $con->id_type) ?>"><?= $con->name ?></a>
									<?php if ($con->child) : ?>
										<ul class="submenu">
											<?php foreach ($con->child as $con1) : ?>
												<li><a href="<?= re_menu($con1->url, $con1->type, $con1->id_type) ?>"><?= $con1->name ?></a></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
</nav>