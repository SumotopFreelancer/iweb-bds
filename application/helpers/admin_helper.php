<?php
defined('BASEPATH') or exit('No direct script access allowed');

function admin_url($url = '')
{
	return base_url('admin/' . $url);
}
function type_menu($type = 'Không xác định', $id_type = 0)
{
	$CI = get_instance();
	$CI->load->model('pages_model');
	$CI->load->model('catalognew_model');
	$CI->load->model('news_model');
	$CI->load->model('catalog_model');
	$CI->load->model('products_model');
	$CI->load->model('catalogservice_model');
	$CI->load->model('services_model');

	$result = ['texttype' => $type, 'error' => 'Không tồn tại'];

	if ($type == 'outlink') {
		$result['texttype'] = 'Liên kết';
		$result['error'] = 'ok';
	}
	if ($type == 'pages') {
		$result['texttype'] = 'Trang';
		if ($CI->pages_model->get_info($id_type)) {
			$result['error'] = 'ok';
		}
	}
	if ($type == 'news') {
		$result['texttype'] = 'Bài viết';
		if ($CI->news_model->get_info($id_type)) {
			$result['error'] = 'ok';
		}
	}
	if ($type == 'catalognew') {
		$result['texttype'] = 'Danh mục bài viết';
		if ($CI->catalognew_model->get_info($id_type)) {
			$result['error'] = 'ok';
		}
	}
	if ($type == 'products') {
		$result['texttype'] = 'Sản phẩm';
		if ($CI->products_model->get_info($id_type)) {
			$result['error'] = 'ok';
		}
	}
	if ($type == 'catalog') {
		$result['texttype'] = 'Danh mục sản phẩm';
		if ($CI->catalog_model->get_info($id_type)) {
			$result['error'] = 'ok';
		}
	}
	if ($type == 'services') {
		$result['texttype'] = 'Dịch vụ';
		if ($CI->services_model->get_info($id_type)) {
			$result['error'] = 'ok';
		}
	}
	if ($type == 'catalogservice') {
		$result['texttype'] = 'Danh mục dịch vụ';
		if ($CI->catalogservice_model->get_info($id_type)) {
			$result['error'] = 'ok';
		}
	}
	return $result;
}
function convert_name_quyen($str)
{
	$characters = array(
		'catalogservice' => 'Danh mục dịch vụ',
		'services' => 'Dịch vụ',

		'catalogimage' => 'Danh mục hình ảnh',
		'images' => 'Hình ảnh',

		'catalogproject' => 'Danh mục đào tạo',
		'projects' => 'Đào tạo',

		'catalognew' => 'Danh mục bài viết',
		'news' => 'Bài viết',

		'catalog' => 'Loại dự án',
		'products' => 'Dự án',

		'orderinfo' => 'Cài đặt đơn hàng',
		'order' => 'Đơn hàng',

		'slide' => 'Slide',

		'notlink' => 'Giới thiệu',

		'contactfooter' => 'Khách hàng đăng ký nhận tư vấn',
		'contactphone' => 'Khách hàng yêu cầu gọi lại',
		'contactemail' => 'Khách hàng đăng ký nhận tin',
		'contactview' => 'Khách hàng đăng ký xem nhà',

		'pagehome' => 'Cài đặt trang chủ',
		'pagecontact' => 'Cài đặt trang liên hệ',

		'pages' => 'Trang',
		'contact' => 'Khách hàng liên hệ',
		'header' => 'Header',
		'headerlink' => 'Liên kết header',
		'sidebar' => 'Sidebar',
		'social' => 'Mạng xã hội',
		'footer' => 'Footer',
		'script' => 'Script',
		'infowebsite' => 'Cài đặt chung',
		'deletecache' => 'Xóa cache',
		'admin' => 'Quản trị viên',

		'load_type_menu' => 'Load loại menu',
		'validationadd' => 'Kiểm tra',
		'menu' => 'Menu',

		'ajax_get_ward' => 'Ajax danh sách phường',
		'ajax_add' => 'Ajax thêm mới',
		'ajax_edit' => 'Ajax chỉnh sửa',
		'highlight' => 'Nổi bật',

		'district' => 'Quận',
		'ward' => 'Phường',
		'area' => 'Diện tích',
		'direction' => 'Hướng',
		'price' => 'Khoản giá',
		'autocomplete' => 'Ajax danh sách Tags',
		'tags' => 'Tags',

		'index' => 'Xem',
		'add' => 'Thêm',
		'edit' => 'Sửa',
		'delete' => 'Xóa',
		'del_all' => 'Xóa nhiều',
		'status' => 'Ẩn/hiện',
		'home' => 'Trang chủ',

		'get_list_country_by_ip' => 'Thông tin IP'
	);
	foreach ($characters as $key => $row) {
		if ($str == $key) {
			return str_replace($key, $row, $str);
		}
	}
}
function get_url_add($url = '', $name, $model)
{
	$CI = &get_instance();
	$CI->load->model($model);

	if ($url == '') {
		$url = chuyenurl($name);
	}
	$where = ['url' => $url];
	if ($CI->{$model}->get_info_rule($where)) {
		$url = $url . '-' . now();
	}
	return $url;
}
function get_url_edit($url = '', $name, $model, $id)
{
	$CI = &get_instance();
	$CI->load->model($model);

	if ($url == '') {
		$url = chuyenurl($name);
	}
	$where = ['url' => $url];
	if ($CI->{$model}->get_info_rule($where)) {
		$info_slug = $CI->{$model}->get_info_rule($where);
		if ($info_slug->id != $id) {
			$url = $url . '-' . now();
		}
	}
	return $url;
}
// Check image
function check_image_admin($image = '')
{
	if ($image) {
		return base_url($image);
	}
	return public_url('admin/img/no-image-80x80.png');
}
// Switch sort
function switch_sort($string = '')
{
	if ($string == 'numAsc' || $string == 'numDesc') {
		return 'numShow';
	} else {
		return 'hidden';
	}
}
// Check và lưu danh mục chính
function main_catalog($catalog_id, $catalog_ids)
{
	if (in_array(intval($catalog_id), $catalog_ids)) {
		return intval($catalog_id);
	} else {
		return intval($catalog_ids[0]);
	}
}
// Resize Image
function resize_image($filename = '', $width = 300, $height = 170)
{
	if ($filename) {
		list($img_width) = getimagesize(base_url($filename));
		if ($img_width > $width) {
			$config = [
				'image_library' => 'gd2',
				'source_image' => $_SERVER['DOCUMENT_ROOT'] . $filename,
				'new_image' => $_SERVER['DOCUMENT_ROOT'] . '/uploads/images/thumbnail/',
				'quality' => '80%',
				'maintain_ratio' => TRUE,
				'create_thumb' => TRUE,
				'thumb_marker' => '-' . $width . '-' . $height,
				'width' => $width,
				'height' => $height
			];
			$CI = get_instance();
			$CI->load->library('image_lib');
			$CI->image_lib->initialize($config);
			if (!$CI->image_lib->resize()) {
				return $CI->image_lib->display_errors();
			} else {
				$path_parts = pathinfo($filename);
				$name = $path_parts['filename'];
				$pre = $path_parts['extension'];
				return '/uploads/images/thumbnail/' . $name . '-' . $width . '-' . $height . '.' . $pre;
			}
			$CI->image_lib->clear();
		}
	}
	return $filename;
}
// Check image_thumb
function check_thumb($postImg, $infoImg, $infoThumb, $width = 300, $height = 170)
{
	$result = '';
	if ($postImg !== $infoImg) {
		$result = resize_image($postImg, $width, $height);
	} else {
		if (!$infoThumb) {
			$result = resize_image($infoImg, $width, $height);
		}
	}
	return $result;
}
// checkYoutube
function checkYoutube($link = '')
{
	return str_replace("watch?v=", "embed/", $link);
}
// Merge
function merge($img = [], $alt = [])
{
	$merge = '';
	if ($img) {
		$merge = json_encode(array_combine($img, $alt));
	}
	return $merge;
}
// Merge 2 box
function merge2Box($arr1 = [], $arr2 = [])
{
	if ($arr1) {
		foreach ($arr1 as $key => $val) {
			$merge[] = ['val1' => $val, 'val2' => $arr2[$key]];
		}
	}
	return json_encode($merge);
}
// Merge 3 box
function merge3Box($arr1 = [], $arr2 = [], $arr3 = [])
{
	if ($arr1) {
		foreach ($arr1 as $key => $val) {
			$merge[] = ['val1' => $val, 'val2' => $arr2[$key], 'val3' => $arr3[$key]];
		}
	}
	return json_encode($merge);
}
// Merge 4 box
function merge4Box($arr1 = [], $arr2 = [], $arr3 = [], $arr4 = [])
{
	if ($arr1) {
		foreach ($arr1 as $key => $val) {
			$merge[] = ['val1' => $val, 'val2' => $arr2[$key], 'val3' => $arr3[$key], 'val4' => $arr4[$key]];
		}
	}
	return json_encode($merge);
}
