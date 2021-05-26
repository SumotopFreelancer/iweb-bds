<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config = array(
	'header' => array('index'),
	'menu' => array('index', 'add', 'edit', 'delete', 'del_all', 'status', 'load_type_menu', 'validationadd'),
	'pagehome' => array('index'),
	'footer' => array('index'),
	'pages' => array('index', 'add', 'edit', 'delete', 'del_all', 'status'),
	'products' => array('index', 'ajax_get_ward', 'ajax_add', 'add', 'ajax_edit', 'edit', 'delete', 'del_all', 'status', 'highlight', 'home'),
	'catalog' => array('index', 'add', 'edit', 'delete', 'del_all', 'status', 'home'),
	'district' => array('index', 'add', 'edit', 'delete', 'del_all'),
	'ward' => array('index', 'add', 'edit', 'delete', 'del_all', 'sidebar'),
	'area' => array('index', 'add', 'edit', 'delete', 'del_all'),
	'direction' => array('index', 'add', 'edit', 'delete', 'del_all'),
	'price' => array('index', 'add', 'edit', 'delete', 'del_all'),
	'news' => array('index', 'add', 'edit', 'delete', 'del_all', 'status', 'sidebar', 'autocomplete'),
	'catalognew' => array('index', 'add', 'edit', 'delete', 'del_all', 'status'),
	'tags' => array('index', 'add', 'edit', 'delete', 'del_all'),
	'contact' => array('index', 'delete', 'del_all'),
	'contactemail' => array('index', 'delete', 'del_all'),
	'contactphone' => array('index', 'delete', 'del_all'),
	'contactview' => array('index', 'delete', 'del_all'),
	'pagecontact' => array('index'),
	'sidebar' => array('index'),
	'social' => array('index'),
	'script' => array('index'),
	'infowebsite' => array('index'),
	'deletecache' => array('index'),
	'admin' => array('edit')
);
