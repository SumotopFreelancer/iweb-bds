<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Lấy ip mạng khách vào website
function get_user_ip()
{
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') > 0) {
            $addr = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($addr[0]);
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        return $_SERVER['REMOTE_ADDR'];
    } else {
        return 0;
    }
}
function public_url($url = '')
{
    return base_url('public/' . $url);
}
function full_get()
{
    $params = $_SERVER['QUERY_STRING']; //for parameters
    return '?' . $params;
}
function pre($list, $exit = true)
{
    echo "<pre>";
    print_r($list);
    if ($exit) {
        die();
    }
}
function isJson($string)
{
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? json_decode($string) : false;
}
// Router menu
function re_menu($url = '', $type, $id_type)
{
    if ($type == 'news' || $type == 'services' || $type == 'products' || $type == 'images' || $type == 'pages') {
        if ($type == 'pages') { // Page
            $url = _pg . '/' . $url;
        }
        if ($type == 'services') { // Service
            $url = _dv . '/' . $url;
        }
        if ($type == 'news') { // New
            $url = _blog . '/' . $url;
        }
        if ($type == 'images') { // Image
            $url = _im . '/' . $url;
        }
        if ($type == 'products') { // Product
            $CI = get_instance();
            $CI->load->model('products_model');
            $CI->load->model('catalog_model');
            $product = $CI->products_model->get_info($id_type);
            if ($product) {
                $catalog = $CI->catalog_model->get_info($product->catalog_id);
                if ($catalog) {
                    $url = $catalog->url . '/' . $url;
                }
            }
        }
        return base_url($url);
    } elseif ($type == 'outlink') {
        return $url; // Custom link
    } else {
        if ($type == 'catalogservice') {
            $url = _cdv . '/' . $url; // Catalog service
        }
        if ($type == 'catalognew') {
            $url = _cblog . '/' . $url; // Catalog news
        }
        if ($type == 'catalogimage') {
            $url = _cim . '/' . $url; // Catalog image
        }
        return base_url($url);
    }
}
function convert_vi_to_en($str)
{
    $characters = [
        '/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/' => 'a',
        '/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/' => 'e',
        '/ì|í|ị|ỉ|ĩ/' => 'i',
        '/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/' => 'o',
        '/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/' => 'u',
        '/ỳ|ý|ỵ|ỷ|ỹ/' => 'y',
        '/đ/' => 'd',
        '/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/' => 'A',
        '/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/' => 'E',
        '/Ì|Í|Ị|Ỉ|Ĩ/' => 'I',
        '/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/' => 'O',
        '/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/' => 'U',
        '/Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'Y',
        '/Đ/' => 'D',
    ];
    return preg_replace(array_keys($characters), array_values($characters), $str);
}
function chuyenurl($list)
{
    return strtolower(preg_replace(['/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'], ['', '-', ''], convert_vi_to_en($list)));
}
/* cat chuoi 1: cắt theo kí tự*/
function cstr($text, $start = 0, $limit = 12)
{
    if (function_exists('mb_substr')) {
        $more = (mb_strlen($text) > $limit) ? TRUE : FALSE;
        $text = mb_substr($text, 0, $limit, 'UTF-8');
        return [$text, $more];
    } elseif (function_exists('iconv_substr')) {
        $more = (iconv_strlen($text) > $limit) ? TRUE : FALSE;
        $text = iconv_substr($text, 0, $limit, 'UTF-8');
        return [$text, $more];
    } else {
        preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/",  $text, $ar);
        if (func_num_args() >= 3) {
            if (count($ar[0]) > $limit) {
                $more = TRUE;
                $text = join("", array_slice($ar[0], 0, $limit)) . "...";
            }
            $more = TRUE;
            $text = join("", array_slice($ar[0], 0, $limit));
        } else {
            $more = FALSE;
            $text =  join("", array_slice($ar[0], 0));
        }
        return [$text, $more];
    }
}
function sub_str($text, $limit = 25)
{
    $val = cstr($text, 0, $limit);
    return $val[1] ? $val[0] . "..." : $val[0];
}
/* Cat chuoi cach 2 : cat theo từ*/
function text_limit($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    foreach (explode(' ', $str) as $word) {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        if (strlen($word) > $minword && strlen($sub) >= $length) {
            break;
        }
    }
    return $sub . (($len < strlen($str)) ? '...' : '');
}
// Xóa thư mục (cache)
function remove_directory($directory, $empty = FALSE)
{
    if (substr($directory, -1) == '/') {
        $directory = substr($directory, 0, -1);
    }
    if (!file_exists($directory) || !is_dir($directory)) {
        return FALSE;
    } elseif (!is_readable($directory)) {
        return FALSE;
    } else {
        $handle = opendir($directory);
        while (FALSE !== ($item = readdir($handle))) {
            if ($item != '.' && $item != '..') {
                $path = $directory . '/' . $item;
                if (is_dir($path)) {
                    remove_directory($path);
                } else {
                    unlink($path);
                }
            }
        }
        closedir($handle);
        if ($empty == FALSE) {
            if (!rmdir($directory)) {
                return FALSE;
            }
        }
        return TRUE;
    }
}
function doiSize($size)
{
    if ($size < 1024) {
        $size = $size . " Bytes";
    } elseif (($size < 1048576) && ($size > 1023)) {
        $size = round($size / 1024, 1) . " KB";
    } elseif (($size < 1073741824) && ($size > 1048575)) {
        $size = round($size / 1048576, 1) . " MB";
    } else {
        $size = round($size / 1073741824, 1) . " GB";
    }
    return $size;
}
function folderSize($dir)
{
    $size = 0;
    foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
        $size += is_file($each) ? filesize($each) : folderSize($each);
    }
    return $size;
}
//Cấu hình gui mail
function config_send_mail()
{
    $config = [];
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
    $config['smtp_port'] = '465';
    $config['smtp_timeout'] = '30';
    $config['smtp_user'] = _emailroot;
    $config['smtp_pass'] = _passemailroot;
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
    return $config;
}
//Cấu hình gui mail
function config_send_mail_root($smtp_user = '', $smtp_pass = '')
{
    $config = [];
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
    $config['smtp_port'] = '465';
    $config['smtp_timeout'] = '30';
    $config['smtp_user'] = $smtp_user;
    $config['smtp_pass'] = $smtp_pass;
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['wordwrap'] = TRUE;
    $config['mailtype'] = 'html';
    return $config;
}
// Check image
function check_image($thumb, $image, $vuong = FALSE)
{
    if ($thumb) {
        return base_url($thumb);
    }
    if ($image) {
        return base_url($image);
    }
    if ($vuong == TRUE) {
        return public_url('dist/images/no-image-300x300.png');
    }
    return public_url('dist/images/no-image-300x170.png');
}
//Return number
function check_phone($string)
{
    return preg_replace('/[^0-9]/', '', $string);
}
//Return price
function check_price($price = 0, $discount = 0, $type = 'default')
{
    $html = '';
    if ($type == 'default') {
        $html .= '<div class="price mt-10">';
        if ($price > 0) {
            if ($discount > 0 && $discount < $price) {
                $html .= '<span class="text-xs itext-9"><s>' . number_format($price) . '<sup>' . _unit . '</sup></s></span>';
                $html .= '<span class="itext-red ml-10">' . number_format($discount) . '<sup>' . _unit . '</sup></span>';
            } else {
                $html .= '<span class="itext-red">' . number_format($price) . '<sup>' . _unit . '</sup></span>';
            }
        } else {
            $html .= '<span class="itext-red">Liên hệ</span>';
        }
        $html .= '</div>';
    } else if ($type == 'detail') {
        $html .= '<div class="price mt-15">';
        if ($price > 0) {
            if ($discount > 0 && $discount < $price) {
                $html .= '<span class="itext-red text-lg">' . number_format($discount) . '<sup>' . _unit . '</sup></span>';
                $html .= '<span class="itext-9 ml-15"><s>' . number_format($price) . '<sup>' . _unit . '</sup></s></span>';
            } else {
                $html .= '<span class="itext-red text-lg">' . number_format($price) . '<sup>' . _unit . '</sup></span>';
            }
        } else {
            $html .= '<span class="itext-red text-lg">Liên hệ</span>';
        }
        $html .= '</div>';
    } else if ($type == 'detailHot') {
        $html .= '<div class="price mt-15">';
        if ($price > 0) {
            if ($discount > 0 && $discount < $price) {
                $html .= '<span class="itext-primary text-lg">' . number_format($discount) . '<sup>' . _unit . '</sup></span>';
                $html .= '<span class="itext-9 ml-15"><s>' . number_format($price) . '<sup>' . _unit . '</sup></s></span>';
            } else {
                $html .= '<span class="itext-primary text-lg">' . number_format($price) . '<sup>' . _unit . '</sup></span>';
            }
        } else {
            $html .= '<span class="itext-primary text-lg">Liên hệ</span>';
        }
        $html .= '</div>';
    }

    return $html;
}
function check_sort($string = 'default', $table = '')
{
    if ($table) {
        $sort = [$table . '.id', 'desc'];
        if ($string == 'default') {
            $sort = [$table . '.id', 'desc'];
        }
        if ($string == 'numAsc') {
            $sort = [$table . '.sort_order', 'asc'];
        }
        if ($string == 'numDesc') {
            $sort = [$table . '.sort_order', 'desc'];
        }
        if ($string == 'timerAsc') {
            $sort = [$table . '.timer' => 'asc'];
        }
        if ($string == 'timerDesc') {
            $sort = [$table . '.timer', 'desc'];
        }
    } else {
        $sort = ['id', 'desc'];
        if ($string == 'default') {
            $sort = ['id', 'desc'];
        }
        if ($string == 'numAsc') {
            $sort = ['sort_order', 'asc'];
        }
        if ($string == 'numDesc') {
            $sort = ['sort_order', 'desc'];
        }
        if ($string == 'timerAsc') {
            $sort = ['timer', 'asc'];
        }
        if ($string == 'timerDesc') {
            $sort = ['timer', 'desc'];
        }
    }
    return $sort;
}
function val_seo($string1 = '', $string2 = '')
{
    return $string1 ? htmlspecialchars($string1, ENT_QUOTES) : htmlspecialchars($string2, ENT_QUOTES);
}
function val_img_seo($img1 = '', $img2 = '')
{
    return $img1 ? base_url($img1) : base_url($img2);
}
// Load tin tức sidebar
function sidebarNew()
{
    $CI = get_instance();
    $CI->load->model('news_model');
    $CI->load->model('setup_model');
    // Load setup
    $setPage = $CI->setup_model->get_setup(['sort_news']);
    $input = [];
    $input['select'] = 'name, url, image_link as img';
    $input['where'] = ['status' => 1, 'sidebar' => 1, 'timer <=' => now()];
    $input['order_by'] = [
        check_sort($setPage->sort_news)[0] => check_sort($setPage->sort_news)[1],
        'id' => 'desc'
    ];
    $input['limit'] = [5, 0];
    return $CI->news_model->get_list($input);
}
