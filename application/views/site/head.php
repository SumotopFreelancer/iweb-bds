<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$title_fix = isset($title) ? $title : '';
$description_fix = isset($description) ? $description : '';
$keywords_fix = isset($keywords) ? $keywords : '';
$url_fix = isset($url) ? $url : '';
$image_fix = isset($image_seo) ? $image_seo : '';
?>
<meta charset="UTF-8">
<meta name="robots" content="index,follow">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<meta name="title" content="<?= $title_fix ?>">
<meta name="description" content="<?= $description_fix ?>">
<meta name="keywords" content="<?= $keywords_fix ?>">
<meta property="og:locale" content="vi_VN">
<meta property="og:type" content="website">
<meta property="og:title" content="<?= $title_fix ?>">
<meta property="og:description" content="<?= $description_fix ?>">
<meta property="og:url" content="<?= $url_fix ?>">
<meta property="og:site_name" content="<?= base_url() ?>">
<meta property="og:image" content="<?= $image_fix ?>">
<meta property="og:image:alt" content="<?= $title_fix ?>">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="<?= $title_fix ?>">
<meta name="twitter:domain" content="<?= base_url() ?>">
<meta name="twitter:description" content="<?= $description_fix ?>">
<meta name="twitter:image" content="<?= $image_fix ?>">
<meta name="generator" content="<?= _author ?>">
<meta name="author" content="<?= _author ?>">
<meta name="copyright" content="<?= _author ?>">
<meta name="resource-type" content="Document">
<meta name="distribution" content="Global">
<meta name="revisit-after" content="1 days">
<title><?= $title_fix ?></title>
<link rel="canonical" href="<?= $url_fix ?>">
<link rel="icon" href="<?= $setAll->favico ?>" type="image/x-icon">
<link rel="shortcut icon" href="<?= $setAll->favico ?>" type="image/x-icon">

<link rel="stylesheet" href="<?= public_url('dist/bootstrap/bootstrap.min.css') ?>">
<link rel="stylesheet" href="<?= public_url('dist/mmenu/jquery.mmenu.css') ?>">
<link rel="stylesheet" href="<?= public_url('dist/carousel/owl.carousel.min.css') ?>">
<link rel="stylesheet" href="<?= public_url('dist/styles/style.css') ?>">
<link rel="stylesheet" href="<?= public_url('dist/styles/custom.css') ?>">
<?php if (isset($styleCart) && $styleCart) {
	echo $styleCart;
} ?>
<?php if (isset($setAll->check_css) && $setAll->check_css == 'on') : ?>
	<link rel="stylesheet" href="<?= public_url('dist/styles/overadd.css') ?>">
<?php endif; ?>
<script src="<?= public_url('dist/scripts/jquery.min.js') ?>"></script>