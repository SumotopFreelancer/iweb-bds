<?php
defined('BASEPATH') or exit('No direct script access allowed');

function loadCI()
{
    $CI = get_instance();
    $CI->load->model('pages_model');
    $CI->load->model('catalognew_model');
    $CI->load->model('news_model');
    $CI->load->model('tags_model');
    $CI->load->model('catalog_model');
    $CI->load->model('products_model');
    $CI->load->model('tagsproduct_model');
    $CI->load->model('catalogservice_model');
    $CI->load->model('services_model');
    $CI->load->model('catalogimage_model');
    $CI->load->model('images_model');
    return $CI;
}
function sitemapUpdate()
{
    $CI = loadCI();
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;

    $root = $dom->createElement('urlset');
    $root->setAttribute('xmlns', "http://www.sitemaps.org/schemas/sitemap/0.9");
    $root->setAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
    $root->setAttribute('xsi:schemaLocation', "http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd");

    $result = $dom->createElement('url');
    $root->appendChild($result);
    $result->appendChild($dom->createElement('loc', base_url()));
    $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, time())));
    $result->appendChild($dom->createElement('priority', '1.0'));

    // Pages
    $input = [];
    $input['where'] = ['status' => 1];
    $dataArr        = $CI->pages_model->get_list($input);
    $root           = appendChildElem($CI, $dom, $dataArr, $root, 'pages');
    // Catalog_new
    $input = [];
    $input['where'] = ['status' => 1];
    $dataArr        = $CI->catalognew_model->get_list($input);
    $root           = appendChildElem($CI, $dom, $dataArr, $root, 'catalog_new');
    // News
    $input = [];
    $input['where'] = ['status' => 1, 'timer <=' => now()];
    $dataArr        = $CI->news_model->get_list($input);
    $root           = appendChildElem($CI, $dom, $dataArr, $root, 'news');
    // Tags
    $dataArr        = $CI->tags_model->get_list();
    $root           = appendChildElem($CI, $dom, $dataArr, $root, 'tags');
    // Catalog
    $input = [];
    $input['where'] = ['status' => 1];
    $dataArr        = $CI->catalog_model->get_list($input);
    $root           = appendChildElem($CI, $dom, $dataArr, $root, 'catalog');
    // Products
    $input = [];
    $input['where'] = ['status' => 1, 'timer <=' => now()];
    $dataArr        = $CI->products_model->get_list($input);
    $root           = appendChildElem($CI, $dom, $dataArr, $root, 'products');
    // Tagsproduct
    $dataArr        = $CI->tagsproduct_model->get_list();
    $root           = appendChildElem($CI, $dom, $dataArr, $root, 'tags_product');
    // Catalog_service
    $input = [];
    $input['where'] = ['status' => 1];
    $dataArr        = $CI->catalogservice_model->get_list($input);
    $root           = appendChildElem($CI, $dom, $dataArr, $root, 'catalog_service');
    // Services
    $input = [];
    $input['where'] = ['status' => 1, 'timer <=' => now()];
    $dataArr        = $CI->services_model->get_list($input);
    $root           = appendChildElem($CI, $dom, $dataArr, $root, 'services');
    // Catalog_image
    $input = [];
    $input['where'] = ['status' => 1];
    $dataArr        = $CI->catalogimage_model->get_list($input);
    $root           = appendChildElem($CI, $dom, $dataArr, $root, 'catalog_image');
    // Images
    $input = [];
    $input['where'] = ['status' => 1, 'timer <=' => now()];
    $dataArr        = $CI->images_model->get_list($input);
    $root           = appendChildElem($CI, $dom, $dataArr, $root, 'images');
    // Trang cứng (Liên hệ, Giỏ hàng...v.v)
    $result = $dom->createElement('url');
    $root->appendChild($result);
    $result->appendChild($dom->createElement('loc', base_url() . "lien-he"));
    $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, time())));
    $result->appendChild($dom->createElement('priority', '1.0'));

    $dom->appendChild($root);

    $dom->save('sitemap.xml') or die('XML Create Error');
}
function appendChildElem($CI, $dom, $dataArr, $root, $type)
{
    if (!empty($dataArr)) {
        foreach ($dataArr as $row) {
            if ($type == 'pages') {
                processPages($CI, $row, $dom, $root);
            } elseif ($type == 'catalog_new') {
                processCatalogNew($CI, $row, $dom, $root);
            } elseif ($type == 'news') {
                processNews($CI, $row, $dom, $root);
            } elseif ($type == 'tags') {
                processTags($CI, $row, $dom, $root);
            } elseif ($type == 'catalog') {
                processCatalog($CI, $row, $dom, $root);
            } elseif ($type == 'products') {
                processProducts($CI, $row, $dom, $root);
            } elseif ($type == 'tags_product') {
                processTagsproduct($CI, $row, $dom, $root);
            } elseif ($type == 'catalog_service') {
                processCatalogService($CI, $row, $dom, $root);
            } elseif ($type == 'services') {
                processServices($CI, $row, $dom, $root);
            } elseif ($type == 'catalog_image') {
                processCatalogImage($CI, $row, $dom, $root);
            } elseif ($type == 'images') {
                processImages($CI, $row, $dom, $root);
            }
        }
    }
    return $root;
}
// Pages
function processPages($CI, $row, $dom, $root)
{
    $result = $dom->createElement('url');
    $root->appendChild($result);
    $url = base_url(_pg . '/' . $row->url);
    $result->appendChild($dom->createElement('loc', $url));
    $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
    $result->appendChild($dom->createElement('priority', '0.8'));
}
// CatalogNew
function processCatalogNew($CI, $row, $dom, $root)
{
    $input = [];
    $catalog_subs = $CI->catalognew_model->get_sub_full($row);
    $input['select'] = 'news.id';
    $input['join'] = [
        'news_catalognew' => ['news_catalognew.new_id = news.id']
    ];
    $input['where'] = ['status' => 1, 'timer <=' => now()];
    $input['where_in'] = ['news_catalognew.catalog_id', $catalog_subs];
    $input['group_by'] = 'news.id';
    $total_rows = $CI->news_model->get_total($input);
    if ($total_rows > 0) {
        $page = ceil($total_rows / 20);
        for ($i = 1; $i <= $page; $i++) {
            $result = $dom->createElement('url');
            $root->appendChild($result);
            $urlCate = base_url(_cblog . '/' . $row->url);
            if ($i > 1) {
                $urlCate = base_url(_cblog . '/' . $row->url . '/' . $i);
            }
            $result->appendChild($dom->createElement('loc', $urlCate));
            $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
            $result->appendChild($dom->createElement('priority', '0.8'));
        }
    } else {
        $result = $dom->createElement('url');
        $root->appendChild($result);
        $result->appendChild($dom->createElement('loc', base_url(_cblog . '/' . $row->url)));
        $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
        $result->appendChild($dom->createElement('priority', '0.8'));
    }
}
// News
function processNews($CI, $row, $dom, $root)
{
    $result = $dom->createElement('url');
    $root->appendChild($result);
    $result->appendChild($dom->createElement('loc', base_url(_blog . '/' . $row->url)));
    $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
    $result->appendChild($dom->createElement('priority', '0.8'));
}
// Tags
function processTags($CI, $row, $dom, $root)
{
    $input = [];
    $input['where'] = ['tags.id' => $row->id, 'timer <=' => now(), 'news.status' => 1];
    $total_rows = $CI->tags_model->get_total_tag_by_tag_id($input);
    if ($total_rows > 0) {
        $page = ceil($total_rows / 20);
        for ($i = 1; $i <= $page; $i++) {
            $result = $dom->createElement('url');
            $root->appendChild($result);
            $urlTags = base_url(_tags . '/' . $row->url);
            if ($i > 1) {
                $urlTags = base_url(_tags . '/' . $row->url . '/' . $i);
            }
            $result->appendChild($dom->createElement('loc', $urlTags));
            $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
            $result->appendChild($dom->createElement('priority', '0.8'));
        }
    } else {
        $result = $dom->createElement('url');
        $root->appendChild($result);
        $result->appendChild($dom->createElement('loc', base_url(_tags . '/' . $row->url)));
        $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
        $result->appendChild($dom->createElement('priority', '0.8'));
    }
}
// Catalog
function processCatalog($CI, $row, $dom, $root)
{
    $input = [];
    $catalog_subs = $CI->catalog_model->get_sub_full($row);
    $input['select'] = 'products.id';
    $input['join'] = [
        'products_catalog' => ['products_catalog.product_id = products.id']
    ];
    $input['where'] = ['status' => 1, 'timer <=' => now()];
    $input['where_in'] = ['products_catalog.catalog_id', $catalog_subs];
    $input['group_by'] = 'products.id';
    $total_rows = $CI->products_model->get_total($input);
    if ($total_rows > 0) {
        $page = ceil($total_rows / 20);
        for ($i = 1; $i <= $page; $i++) {
            $result = $dom->createElement('url');
            $root->appendChild($result);
            $urlCate = base_url($row->url);
            if ($i > 1) {
                $urlCate = base_url($row->url . '/' . $i);
            }
            $result->appendChild($dom->createElement('loc', $urlCate));
            $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
            $result->appendChild($dom->createElement('priority', '0.8'));
        }
    } else {
        $result = $dom->createElement('url');
        $root->appendChild($result);
        $result->appendChild($dom->createElement('loc', base_url($row->url)));
        $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
        $result->appendChild($dom->createElement('priority', '0.8'));
    }
}
// Products
function processProducts($CI, $row, $dom, $root)
{
    $result = $dom->createElement('url');
    $root->appendChild($result);
    $urlCate = $CI->catalog_model->get_info($row->catalog_id)->url;
    $result->appendChild($dom->createElement('loc', base_url($urlCate . '/' . $row->url)));
    $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
    $result->appendChild($dom->createElement('priority', '0.8'));
}
// Tagsproduct
function processTagsproduct($CI, $row, $dom, $root)
{
    $input = [];
    $input['where'] = ['tagsproduct.id' => $row->id, 'timer <=' => now(), 'products.status' => 1];
    $total_rows = $CI->tagsproduct_model->get_total_tag_by_tag_id($input);
    if ($total_rows > 0) {
        $page = ceil($total_rows / 20);
        for ($i = 1; $i <= $page; $i++) {
            $result = $dom->createElement('url');
            $root->appendChild($result);
            $urlTags = base_url(_tagsproduct . '/' . $row->url);
            if ($i > 1) {
                $urlTags = base_url(_tagsproduct . '/' . $row->url . '/' . $i);
            }
            $result->appendChild($dom->createElement('loc', $urlTags));
            $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
            $result->appendChild($dom->createElement('priority', '0.8'));
        }
    } else {
        $result = $dom->createElement('url');
        $root->appendChild($result);
        $result->appendChild($dom->createElement('loc', base_url(_tagsproduct . '/' . $row->url)));
        $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
        $result->appendChild($dom->createElement('priority', '0.8'));
    }
}
// CatalogService
function processCatalogService($CI, $row, $dom, $root)
{
    $input = [];
    $catalog_subs = $CI->catalogservice_model->get_sub_full($row);
    $input['select'] = 'services.id';
    $input['join'] = [
        'services_catalogservice' => ['services_catalogservice.service_id = services.id']
    ];
    $input['where'] = ['status' => 1, 'timer <=' => now()];
    $input['where_in'] = ['services_catalogservice.catalog_id', $catalog_subs];
    $input['group_by'] = 'services.id';
    $total_rows = $CI->services_model->get_total($input);
    if ($total_rows > 0) {
        $page = ceil($total_rows / 20);
        for ($i = 1; $i <= $page; $i++) {
            $result = $dom->createElement('url');
            $root->appendChild($result);
            $urlCate = base_url(_cdv . '/' . $row->url);
            if ($i > 1) {
                $urlCate = base_url(_cdv . '/' . $row->url . '/' . $i);
            }
            $result->appendChild($dom->createElement('loc', $urlCate));
            $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
            $result->appendChild($dom->createElement('priority', '0.8'));
        }
    } else {
        $result = $dom->createElement('url');
        $root->appendChild($result);
        $result->appendChild($dom->createElement('loc', base_url(_cdv . '/' . $row->url)));
        $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
        $result->appendChild($dom->createElement('priority', '0.8'));
    }
}
// Services
function processServices($CI, $row, $dom, $root)
{
    $result = $dom->createElement('url');
    $root->appendChild($result);
    $result->appendChild($dom->createElement('loc', base_url(_dv . '/' . $row->url)));
    $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
    $result->appendChild($dom->createElement('priority', '0.8'));
}
// CatalogImage
function processCatalogImage($CI, $row, $dom, $root)
{
    $input = [];
    $catalog_subs = $CI->catalogimage_model->get_sub_full($row);
    $input['select'] = 'images.id';
    $input['join'] = [
        'images_catalogimage' => ['images_catalogimage.image_id = images.id']
    ];
    $input['where'] = ['status' => 1, 'timer <=' => now()];
    $input['where_in'] = ['images_catalogimage.catalog_id', $catalog_subs];
    $input['group_by'] = 'images.id';
    $total_rows = $CI->images_model->get_total($input);
    if ($total_rows > 0) {
        $page = ceil($total_rows / 20);
        for ($i = 1; $i <= $page; $i++) {
            $result = $dom->createElement('url');
            $root->appendChild($result);
            $urlCate = base_url(_cim . '/' . $row->url);
            if ($i > 1) {
                $urlCate = base_url(_cim . '/' . $row->url . '/' . $i);
            }
            $result->appendChild($dom->createElement('loc', $urlCate));
            $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
            $result->appendChild($dom->createElement('priority', '0.8'));
        }
    } else {
        $result = $dom->createElement('url');
        $root->appendChild($result);
        $result->appendChild($dom->createElement('loc', base_url(_cim . '/' . $row->url)));
        $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
        $result->appendChild($dom->createElement('priority', '0.8'));
    }
}
// Images
function processImages($CI, $row, $dom, $root)
{
    $result = $dom->createElement('url');
    $root->appendChild($result);
    $result->appendChild($dom->createElement('loc', base_url(_im . '/' . $row->url)));
    $result->appendChild($dom->createElement('lastmod', gmdate(DATE_W3C, $row->updated)));
    $result->appendChild($dom->createElement('priority', '0.8'));
}
/* Hàm của Dom xml

    1. createElement
    2. appendChild

*/