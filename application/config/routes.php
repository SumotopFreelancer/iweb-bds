<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// *** BACKEND ============================================================================

$route['admin/pages/(:num)'] = 'admin/pages/index/$1'; // Trang
$route['admin/pages'] = 'admin/pages/index'; // Danh sách

$route['admin/tags/(:num)'] = 'admin/tags/index/$1';
$route['admin/tags'] = 'admin/tags/index';

$route['admin/catalognew/(:num)'] = 'admin/catalognew/index/$1'; // Danh mục tin tức cha
$route['admin/catalognew'] = 'admin/catalognew/index'; // Danh sách
$route['admin/news/(:num)'] = 'admin/news/index/$1'; // Tin tức
$route['admin/news'] = 'admin/news/index'; // Danh sách

// $route['admin/tagsproduct/(:num)'] = 'admin/tagsproduct/index/$1';
// $route['admin/tagsproduct'] = 'admin/tagsproduct/index';

$route['admin/catalog/(:num)'] = 'admin/catalog/index/$1'; // Phân trang
$route['admin/catalog'] = 'admin/catalog/index'; // Loại dự án

$route['admin/products/(:num)'] = 'admin/products/index/$1'; // Phân trang
$route['admin/products'] = 'admin/products/index'; // Dự án

$route['admin/district/(:num)'] = 'admin/district/index/$1'; // Phân trang
$route['admin/district'] = 'admin/district/index'; // Quận

$route['admin/ward/(:num)'] = 'admin/ward/index/$1'; // Phân trang
$route['admin/ward'] = 'admin/ward/index'; // Phường

$route['admin/area/(:num)'] = 'admin/area/index/$1'; // Phân trang
$route['admin/area'] = 'admin/area/index'; // Diện tích

$route['admin/direction/(:num)'] = 'admin/direction/index/$1'; // Phân trang
$route['admin/direction'] = 'admin/direction/index'; // Hướng

$route['admin/price/(:num)'] = 'admin/price/index/$1'; // Phân trang
$route['admin/price'] = 'admin/price/index'; // Khoản giá

// $route['admin/order/(:num)'] = 'admin/order/index/$1';
// $route['admin/order'] = 'admin/order/index'; // Danh sách
// $route['admin/orderinfo'] = 'admin/orderinfo/index'; // Cài đặt khác

$route['admin/catalogservice/(:num)'] = 'admin/catalogservice/index/$1'; // Danh mục tin tức cha
$route['admin/catalogservice'] = 'admin/catalogservice/index'; // Danh sách
$route['admin/services/(:num)'] = 'admin/services/index/$1'; // Tin tức
$route['admin/services'] = 'admin/services/index'; // Danh sách

// $route['admin/catalogimage/(:num)'] = 'admin/catalogimage/index/$1';// Danh mục hình ảnh cha
// $route['admin/catalogimage'] = 'admin/catalogimage/index';// Danh sách
// $route['admin/images/(:num)'] = 'admin/images/index/$1';// Hình ảnh
// $route['admin/images'] = 'admin/images/index';// Danh sách

// $route['admin/feedback/(:num)'] = 'admin/feedback/index/$1';// Ý kiến khách hàng
// $route['admin/feedback'] = 'admin/feedback/index';// Danh sách

// $route['admin/supportonline/(:num)'] = 'admin/supportonline/index/$1';// Hỗ trợ trực tuyến
// $route['admin/supportonline'] = 'admin/supportonline/index';// Danh sách

$route['admin/contact/(:num)'] = 'admin/contact/index/$1'; // Khách hàng liên hệ
$route['admin/contact'] = 'admin/contact/index'; // Danh sách

$route['admin/contactphone/(:num)'] = 'admin/contactphone/index/$1'; // Khách hàng liên hệ
$route['admin/contactphone'] = 'admin/contactphone/index'; // Danh sách

$route['admin/contactemail/(:num)'] = 'admin/contactemail/index/$1'; // Khách hàng liên hệ
$route['admin/contactemail'] = 'admin/contactemail/index'; // Danh sách

$route['admin/contactview/(:num)'] = 'admin/contactview/index/$1'; // Khách hàng liên hệ
$route['admin/contactview'] = 'admin/contactview/index'; // Danh sách

// $route['admin/contactfooter/(:num)'] = 'admin/contactfooter/index/$1';// Khách hàng liên hệ
// $route['admin/contactfooter'] = 'admin/contactfooter/index';// Danh sách

$route['admin/menu'] = 'admin/menu/index'; // Danh sách

$route['admin/slide/(:num)'] = 'admin/slide/index/$1'; // Slide
$route['admin/slide'] = 'admin/slide/index'; // Danh sách

// $route['admin/notlink/(:num)'] = 'admin/notlink/index/$1'; // Điểm khác biệt
// $route['admin/notlink'] = 'admin/notlink/index'; // Danh sách

// $route['admin/headerlink/(:num)'] = 'admin/headerlink/index/$1'; // Liên kết tùy chỉnh Header
// $route['admin/headerlink'] = 'admin/headerlink/index'; // Liên kết tùy chỉnh Header

// $route['admin/visit/(:num)'] = 'admin/visit/index/$1';// Thống kê truy cập
// $route['admin/visit'] = 'admin/visit/index';// Thống kê truy cập

$route['admin/pagehome'] = 'admin/pagehome/index'; // Trang chủ
$route['admin/pagecontact'] = 'admin/pagecontact/index'; // Trang liên hệ
$route['admin/header'] = 'admin/header/index'; // Header
$route['admin/footer'] = 'admin/footer/index'; // Footer
$route['admin/sidebar'] = 'admin/sidebar/index'; // Sidebar
$route['admin/social'] = 'admin/social/index'; // Mạng xã hội
$route['admin/script'] = 'admin/script/index'; // Script
$route['admin/infowebsite'] = 'admin/infowebsite/index'; // Thông tin chung
$route['admin/othersetting'] = 'admin/othersetting/index'; // Cài đặt khác
$route['admin/deletecache'] = 'admin/deletecache/index'; // Xóa cache

$route['admin/admin/(:num)'] = 'admin/admin/index/$1'; // Quản trị viên
$route['admin/admin'] = 'admin/admin/index'; // Quản trị viên

$route['admin/admingroup/(:num)'] = 'admin/admingroup/index/$1'; // Nhóm quản trị
$route['admin/admingroup'] = 'admin/admingroup/index'; // Nhóm quản trị

$route['admin/login'] = 'admin/login/index'; // Đăng nhập
$route['admin/home'] = 'admin/home/index'; // Dashboard
$route['admin'] = 'admin/home/index'; // Dashboard

$route['admin/(:any)'] = 'myerror'; // Error


// *** FRONTEND ============================================================================

// Ajax
$route['load-ward'] = 'ajax/ajax_get_ward';

// Trang tìm kiếm
$route['tim-kiem/(:num)'] = 'search/index/$1';
$route['tim-kiem'] = 'search';

// Trang liên hệ
$route['contact-phone'] = 'contact/contact_phone';
$route['contact-email'] = 'contact/contact_email';
$route['contact-view'] = 'contact/contact_view';
// $route['contact-footer'] = 'contact/contact_footer';
$route['lien-he'] = 'contact';

// Giỏ hàng
$route['gio-hang/them-vao-gio-hang'] = 'cart/addajax';
$route['gio-hang/cap-nhat-so-luong'] = 'cart/updateajax';
$route['gio-hang/xoa-san-pham-trong-gio-hang'] = 'cart/deleteajax';
$route['gio-hang'] = 'cart';
$route['thong-tin-thanh-toan'] = 'order/checkout';
$route['dat-hang-thanh-cong'] = 'order/cartdone';

// Trang
$route[_pg . '/(:any)/(:num)'] = 'pages/view/$1/$2';
$route[_pg . '/(:any)'] = 'pages/view/$1';

// // Tags sản phẩm
// $route[_tagsproduct . '/(:any)/(:num)'] = 'products/tags/$1/$2';
// $route[_tagsproduct . '/(:any)'] = 'products/tags/$1';

// // Dich vu
// $route[_cdv . '/(:any)/(:num)'] = 'services/catalog/$1/$2'; // Danh mục phân trang
// $route[_cdv . '/(:any)'] = 'services/catalog/$1'; // Danh mục
// $route[_dv . '/(:any)'] = 'services/view/$1';

// // Hình ảnh
// $route[_cim.'/(:any)/(:num)'] = 'images/catalog/$1/$2'; // Danh mục phân trang
// $route[_cim.'/(:any)'] = 'images/catalog/$1'; // Danh mục
// $route[_im.'/(:any)'] = 'images/view/$1';

// Tin tức
$route[_cblog . '/(:any)/(:num)'] = 'news/catalog/$1/$2'; // Danh mục phân trang
$route[_cblog . '/(:any)'] = 'news/catalog/$1'; // Danh mục
$route[_blog . '/(:any)'] = 'news/view/$1';

// Tags sản phẩm
$route[_tags . '/(:any)/(:num)'] = 'news/tags/$1/$2';
$route[_tags . '/(:any)'] = 'news/tags/$1';

// Sản phẩm
$route['(:any)/(:num)'] = 'products/catalog/$1/$2'; // Phân trang
$route['(:any)/(:any)'] = 'products/view/$2'; // Chi tiết sản phẩm
$route['(:any)'] = 'products/catalog/$1'; // Danh mục


/* Defaul page: error, home */
$route['default_controller'] = 'home';
$route['404_override'] = 'myerror';
$route['translate_uri_dashes'] = FALSE;
