-- phpMyAdmin SQL Dump
-- version 4.4.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2021 at 09:42 AM
-- Server version: 10.1.18-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bds_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_group_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `last_login` int(11) NOT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`, `admin_group_id`, `created`, `last_login`, `type`) VALUES
(1, 'administrator', '6e13ba34f874bace5e32289146ef127b', 'Administrator', -1, 1528433953, 1621867237, 'root'),
(38, 'content', '25f9e794323b453885f5181f1b624d0b', 'dũng', 4, 1621653853, 1621653939, 'custom');

-- --------------------------------------------------------

--
-- Table structure for table `admin_group`
--

CREATE TABLE IF NOT EXISTS `admin_group` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_group`
--

INSERT INTO `admin_group` (`id`, `name`, `permissions`, `sort_order`, `created`) VALUES
(4, 'Content', '{"products":["index","ajax_get_ward","ajax_add","add","ajax_edit","edit","delete","del_all","status","highlight","home"],"news":["index","add","edit","delete","del_all","status","sidebar","autocomplete"],"admin":["edit"],"ajax":["slug"]}', 0, 1553314421),
(5, 'Super Admin', '{"header":["index"],"menu":["index","add","edit","delete","del_all","load_type_menu","validationadd"],"pagehome":["index"],"footer":["index"],"pages":["index","add","edit","delete","del_all","status"],"products":["index","ajax_get_ward","ajax_add","add","ajax_edit","edit","delete","del_all","status","highlight","home"],"catalog":["index","add","edit","delete","del_all","status","home"],"district":["index","add","edit","delete","del_all"],"ward":["index","add","edit","delete","del_all","sidebar"],"area":["index","add","edit","delete","del_all"],"direction":["index","add","edit","delete","del_all"],"price":["index","add","edit","delete","del_all"],"news":["index","add","edit","delete","del_all","status","sidebar"],"catalognew":["index","add","edit","delete","del_all","status"],"tags":["index","add","edit","delete","del_all"],"contact":["index","delete","del_all"],"contactemail":["index","delete","del_all"],"contactphone":["index","delete","del_all"],"contactview":["index","delete","del_all"],"pagecontact":["index"],"sidebar":["index"],"social":["index"],"script":["index"],"infowebsite":["index"],"deletecache":["index"],"admin":["edit"],"ajax":["slug"]}', 0, 1553494652);

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `id` int(11) NOT NULL,
  `area_from` int(11) NOT NULL,
  `area_to` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `area_from`, `area_to`, `sort_order`) VALUES
(1, 0, 30, 0),
(3, 50, 80, 0),
(4, 80, 100, 0),
(5, 100, 150, 0),
(6, 150, 200, 0),
(7, 200, 250, 0),
(8, 250, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `catalog`
--

CREATE TABLE IF NOT EXISTS `catalog` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `home` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `catalog`
--

INSERT INTO `catalog` (`id`, `name`, `url`, `image_link`, `image_seo`, `banner`, `intro`, `title`, `description`, `keyword`, `parent_id`, `created`, `updated`, `status`, `home`, `sort_order`) VALUES
(1, 'Nhà phố', 'nha-pho', '', '', '', '', '', '', '', 0, 1620961707, 1621868471, 1, 1, 1),
(2, 'Biệt thự sân vườn', 'biet-thu-san-vuon', '', '', '', '', '', '', '', 0, 1620962065, 1621868506, 1, 1, 2),
(5, 'Đất nền', 'dat-nen', '/uploads/files/nha-dat-duy-tan-chuyen-dat-nen-binh-tan.JPG', '/uploads/files/nha-dat-duy-tan-chuyen-dat-nen-binh-tan.JPG', '', 'Bán đất nền', 'Đất nền', 'Bán đất nền', 'đất nền quận bình tân, đất nền bình tân', 0, 1621868430, 1621868489, 1, 1, 1),
(4, 'Căn hộ', 'can-ho', '', '', '', '', '', '', '', 0, 1620962082, 1621652376, 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `catalog_image`
--

CREATE TABLE IF NOT EXISTS `catalog_image` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `home` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_new`
--

CREATE TABLE IF NOT EXISTS `catalog_new` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `home` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `catalog_new`
--

INSERT INTO `catalog_new` (`id`, `name`, `url`, `image_link`, `image_thumb`, `image_seo`, `banner`, `intro`, `title`, `description`, `keyword`, `parent_id`, `created`, `updated`, `status`, `home`, `sort_order`) VALUES
(1, 'Tin tức blog', 'tin-tuc-blog', '', '', '', '', '', '', '', '', 0, 1621147321, 1621398065, 1, 0, 1),
(2, '2', '2', '', '', '', '', '', '', '', '', 0, 1621395716, 1621395716, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `catalog_service`
--

CREATE TABLE IF NOT EXISTS `catalog_service` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `home` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  `sessions` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `country_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `phone`, `email`, `address`, `content`, `created`) VALUES
(1, 'họ tên liên hệ', '123213123', 'dksfah@gmail.com', '', 'Nội dung liên lạc', 1621330362),
(2, 'Họ tên 2 ', '019230123', 'hoten2@gmail.com', '', 'nôi dung liên lac 2', 1621330399),
(3, 'dsaf', '123', 'dsfa@gmail.com', '', 'dsfads', 1621478179),
(4, 'dfsafdsaf', '090909090909', 'dsfa@gmail.com', '', 'dfsafdsaf', 1621652667);

-- --------------------------------------------------------

--
-- Table structure for table `contact_email`
--

CREATE TABLE IF NOT EXISTS `contact_email` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contact_email`
--

INSERT INTO `contact_email` (`id`, `email`, `created`) VALUES
(1, 'sadfsdf@gg.com', 1621235771),
(2, 'dsfalj@gmail.com', 1621244558),
(3, 'asdf@gg.com', 1621244856),
(4, 'coder@iweb247.vn', 1621244979),
(5, 'tungocsang88@gmail.com', 1621330147),
(6, 'dsfafdsa@gmail.com', 1621478225),
(7, '22052021@gmail.com', 1621652538);

-- --------------------------------------------------------

--
-- Table structure for table `contact_footer`
--

CREATE TABLE IF NOT EXISTS `contact_footer` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_phone`
--

CREATE TABLE IF NOT EXISTS `contact_phone` (
  `id` int(11) NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `contact_phone`
--

INSERT INTO `contact_phone` (`id`, `phone`, `created`) VALUES
(1, '0900000001', 1621330469),
(2, '0900000002', 1621330475),
(3, '123213123', 1621478238),
(4, '09090909123', 1621652744);

-- --------------------------------------------------------

--
-- Table structure for table `contact_view`
--

CREATE TABLE IF NOT EXISTS `contact_view` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contact_view`
--

INSERT INTO `contact_view` (`id`, `name`, `phone`, `link`, `created`) VALUES
(3, '213dfsafdsaf', 'dfsafsd', 'http://bds.iweb247.net/biet-thu-san-vuon/dat-nen-tan-phu', 1621478261),
(2, 'sac', '123213', 'http://bds.iweb247.net/pg/gioi-thieu', 1621328898),
(4, 'dfsafasd', '2132131212321321', 'http://bds.iweb247.net/', 1621479211),
(5, 'sag', '22052021', 'http://bds.iweb247.net/', 1621652583),
(6, 'sang2', '222052021', 'http://bds.iweb247.net/can-ho/can-ho-aquaciti', 1621652619);

-- --------------------------------------------------------

--
-- Table structure for table `direction`
--

CREATE TABLE IF NOT EXISTS `direction` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `direction`
--

INSERT INTO `direction` (`id`, `name`, `sort_order`) VALUES
(1, 'Đông', 0),
(2, 'Tây', 0),
(3, 'Nam', 0),
(4, 'Bắc', 0),
(6, 'Đông Bắc', 5);

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE IF NOT EXISTS `district` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `district`
--

INSERT INTO `district` (`id`, `name`, `sort_order`) VALUES
(1, 'Tân Phú', 1),
(17, 'Bình Tân', 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `chucdanh` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ykien` text COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `header_link`
--

CREATE TABLE IF NOT EXISTS `header_link` (
  `id` int(11) NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_list` text COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `timer` int(11) NOT NULL,
  `view` int(11) NOT NULL,
  `catalog_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `home` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images_catalogimage`
--

CREATE TABLE IF NOT EXISTS `images_catalogimage` (
  `image_id` int(11) NOT NULL,
  `catalog_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `id_type` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=148 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `url`, `type`, `id_type`, `parent_id`, `sort_order`, `created`, `status`) VALUES
(138, 'Trang chủ', '/', 'outlink', 0, 0, 0, 1621328211, 1),
(139, 'Giới thiệu', 'gioi-thieu', 'pages', 1, 0, 2, 1621328217, 1),
(140, 'Dự án', '#', 'outlink', 0, 0, 3, 1621328244, 1),
(141, 'Nhà phố', 'nha-pho', 'catalog', 1, 140, 0, 1621328253, 1),
(142, 'Biệt thự sân vườn', 'biet-thu-san-vuon', 'catalog', 2, 140, 0, 1621328261, 1),
(143, 'Đất nền', 'dat-nen', 'catalog', 3, 140, 0, 1621328269, 1),
(144, 'Căn hộ', 'can-ho', 'catalog', 4, 140, 0, 1621328276, 1),
(145, 'Tin tức blog', 'tin-tuc-blog', 'catalognew', 1, 0, 4, 1621328298, 1),
(146, 'Liên hệ', '/lien-he', 'outlink', 0, 0, 6, 1621328315, 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) DEFAULT '0',
  `updated` int(11) DEFAULT '0',
  `timer` int(11) DEFAULT '0',
  `view` int(11) DEFAULT '0',
  `catalog_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `home` tinyint(1) NOT NULL,
  `sidebar` tinyint(1) NOT NULL,
  `author` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL,
  `layout` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `name`, `url`, `intro`, `content`, `title`, `description`, `keyword`, `image_link`, `image_thumb`, `image_seo`, `created`, `updated`, `timer`, `view`, `catalog_id`, `status`, `home`, `sidebar`, `author`, `sort_order`, `layout`) VALUES
(1, 'Bài 5', 'tieu-de-duoc-viet-boi-nhom-iwe-media-ngay-hom-nay-the-title-of-this-news', '', '<p>asdfsdf</p>\r\n\r\n<p><img alt="" src="/uploads/images/bds-1.png" style="width: 326px; height: 217px;" /></p>\r\n', '', '', '', '', '', '', 1621147343, 1621653732, 1621406520, 21, 1, 1, 0, 0, '', 0, 'sidebar'),
(2, 'Bài 4', 'tieu-de-duoc-viet-boi-nhom-iwe-media-ngay-hom-nay-the-title-of-this-news-1621147346', '', '', '', '', '', '', '', '', 1621147347, 1621397429, 1621147320, 5, 1, 1, 0, 1, '', 0, 'sidebar'),
(3, 'Bài 3', 'tieu-de-duoc-viet-boi-nhom-iwe-media-ngay-hom-nay-the-title-of-this-news-1621147350', '', '', '', '', '', '', '', '', 1621147351, 1621397416, 1621147320, 6, 1, 1, 0, 1, '', 0, 'sidebar'),
(4, 'Bài 2', 'tieu-de-duoc-viet-boi-nhom-iwe-media-ngay-hom-nay-the-title-of-this-news-1621147354', '', '', '', '', '', '', '', '', 1621147355, 1621397410, 1621147320, 20, 1, 1, 0, 1, '', 0, 'sidebar'),
(5, 'Bài 1', 'tieu-de-duoc-viet-boi-nhom-iwe-media-ngay-hom-nay-the-title-of-this-news-1621147357', '', '', '', '', '', '', '', '', 1621147358, 1621398175, 1620196920, 22, 1, 1, 0, 1, '', 0, 'sidebar');

-- --------------------------------------------------------

--
-- Table structure for table `news_catalognew`
--

CREATE TABLE IF NOT EXISTS `news_catalognew` (
  `new_id` int(11) NOT NULL,
  `catalog_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `news_catalognew`
--

INSERT INTO `news_catalognew` (`new_id`, `catalog_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notlink`
--

CREATE TABLE IF NOT EXISTS `notlink` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `images` text COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `transaction_id` int(255) NOT NULL,
  `id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `amount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `url`, `intro`, `content`, `title`, `description`, `keyword`, `image_link`, `image_thumb`, `image_seo`, `created`, `updated`, `status`, `sort_order`, `type`) VALUES
(1, 'Giới thiệu', 'gioi-thieu', '', '<p>Đang cập nhật</p>\r\n', '', '', '', '', '', '', 1621152109, 1621328850, 1, 0, 'default');

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE IF NOT EXISTS `price` (
  `id` int(11) NOT NULL,
  `price_from` float NOT NULL,
  `price_to` float NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `price`
--

INSERT INTO `price` (`id`, `price_from`, `price_to`, `sort_order`) VALUES
(10, 20, 100, 7),
(2, 0.8, 1, 0),
(3, 1, 2, 0),
(4, 2, 3, 0),
(5, 3, 5, 0),
(6, 5, 7, 0),
(7, 7, 10, 0),
(8, 10, 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `district_id` int(11) NOT NULL,
  `ward_id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `direction_id` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `bedroom` int(11) NOT NULL,
  `bathroom` int(11) NOT NULL,
  `area_ratio` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `proNew` tinyint(1) NOT NULL,
  `proStock` tinyint(1) NOT NULL,
  `priceType` tinyint(1) NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_list` text COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `timer` int(11) NOT NULL,
  `catalog_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `home` tinyint(1) NOT NULL,
  `highlight` tinyint(1) NOT NULL,
  `view` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `url`, `district_id`, `ward_id`, `address`, `phone`, `price`, `direction_id`, `area`, `bedroom`, `bathroom`, `area_ratio`, `proNew`, `proStock`, `priceType`, `content`, `title`, `description`, `keyword`, `image_link`, `image_seo`, `image_list`, `created`, `updated`, `timer`, `catalog_id`, `status`, `home`, `highlight`, `view`, `sort_order`) VALUES
(7, 'Bán nhà Mới  4x12, 1 trệt 3 lầu - liên khu 10-11 quận bình Tân Thông ra Phan Anh, Hương Lộ 2', 'ban-nha-moi-4x12-1-tret-3-lau-lien-khu-10-11-quan-binh-tan-thong-ra-phan-anh-huong-lo-2', 17, 11, 'Hẻm 1/ liên khu 10-11, Bình Trị Đông, Quận Bình Tân', '0902983367', 4.3, 3, 51, 4, 4, '4x12', 1, 0, 2, '<p><strong>Bán nhà Mới &nbsp;4x12, 1 trệt 3 lầu - liên khu 10-11 quận bình Tân Thông ra Phan Anh, Hương Lộ 2</strong></p>\n\n<p>Nhà mới xây kiến trúc hiện đại.</p>\n\n<p>Hẻm 1 xẹc thông ra phan anh, Tân Hòa Đông, Hương Lộ 2</p>\n\n<p>Dân cư đông đúc, An Ninh</p>\n\n<p><em><span style="color:#c0392b;"><strong>- Đi ngã tư 4 xã chỉ 4 phút</strong></span></em></p>\n\n<p><em><span style="color:#c0392b;"><strong>- Đi Đầm Sen 8&nbsp;phút</strong></span></em></p>\n\n<p><em><span style="color:#c0392b;"><strong>- Đi bến xe Miền Tây 12 phút</strong></span></em></p>\n', 'Bán nhà Mới  4x12, 1 trệt 3 lầu - liên khu 10-11 quận bình Tân Thông ra Phan Anh, Hương Lộ 2', 'Bán nhà liên khu 10-11 bình trị đông quận bình tân, sổ hồng riêng. Nhà mới xây đẹp kiểu hiện đại 2021. Giá dưới 5 tỷ', 'bán nhà liên khu 10 11, bán nhà quận bình tân, nhà đất duy tân, bán nhà bình trị đông', '/uploads/files/ban-nha-lien-khu-10-11-quan-binh-tan-2021 (3).jpg', '/uploads/files/ban-nha-lien-khu-10-11-quan-binh-tan-2021%20(5).jpg', '{"\\/uploads\\/files\\/ban-nha-lien-khu-10-11-quan-binh-tan-2021%20(5).jpg":"","\\/uploads\\/files\\/ban-nha-lien-khu-10-11-quan-binh-tan-2021%20(3).jpg":"","\\/uploads\\/files\\/ban-nha-lien-khu-10-11-quan-binh-tan-2021%20(4).jpg":"","\\/uploads\\/files\\/ban-nha-lien-khu-10-11-quan-binh-tan-2021%20(1).jpg":""}', 1621873559, 1621972643, 1621873200, 1, 1, 1, 1, 0, 0),
(2, 'Căn hộ AquaCiti', 'can-ho-aquaciti', 17, 12, 'Hồ Chí Minh', '0398 210 215', 4.2, 4, 400, 4, 5, '4 x 30', 0, 1, 2, '<p>Nội dung</p>\n', 'Căn hộ AquaCiti', '', '', '/uploads/images/hinh-anh-1.png', '', '{"\\/uploads\\/images\\/hinh-anh-2.png":"","\\/uploads\\/images\\/hinh-anh-3.png":"","\\/uploads\\/images\\/hinh-anh-4.png":""}', 1621091269, 1621950735, 1621091160, 4, 1, 1, 1, 0, 0),
(6, 'Bán nhà 4x10, 1 trệt 1 lầu - liên khu 10-11 quận bình Tân (kế bên hương lộ 2)', 'ban-nha-4x10-1-tret-1-lau-lien-khu-10-11-quan-binh-tan-ke-ben-huong-lo-2', 17, 10, 'Hẻm 1/ liên khu 10-11, Bình Trị Đông, Quận Bình Tân', '0902983367', 3.6, 2, 52, 2, 2, '4x10', 1, 0, 1, '', 'Bán nhà 4x10, 1 trệt 1 lầu - liên khu 10-11 quận bình Tân (kế bên hương lộ 2)', 'bán nhà liên khu 10-11 quận bình tân. diện tích 4x10 giá chốt 3.6 tỷ. Có sổ hồng riêng', 'bán nhà liên khu 10-11, bán nhà quận bình tân, bán nhà bình tân', '/uploads/files/ban-nha-lien-khu-10-11-quan-binh-tan (4).jpg', '', '{"\\/uploads\\/files\\/ban-nha-lien-khu-10-11-quan-binh-tan%20(3).jpg":"","\\/uploads\\/files\\/ban-nha-lien-khu-10-11-quan-binh-tan%20(1).jpg":"","\\/uploads\\/files\\/ban-nha-lien-khu-10-11-quan-binh-tan%20(2).jpg":""}', 1621872641, 1621972688, 1621872300, 1, 1, 1, 1, 0, 0),
(8, 'Bán nhà 4x18, 1 trệt 3 lầu, Hẻm 1/ đường 6m Đất Mới (Bình Trị Đông) Quận Bình Tân', 'ban-nha-4x18-hem-1-duong-6m-dat-moi-binh-tri-dong-quan-binh-tan', 17, 11, 'Hẻm 1/ đất mới (Bình Trị Đông) Quận Bình Tân', '0902983367', 5.8, 4, 72, 4, 5, '4x18', 0, 0, 2, '', 'Bán nhà 4x18, 1 trệt 3 lầu, Hẻm 1/ đường 6m Đất Mới (Bình Trị Đông) Quận Bình Tân', '', '', '', '', '', 1621874687, 1621874687, 1621873740, 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `products_catalog`
--

CREATE TABLE IF NOT EXISTS `products_catalog` (
  `product_id` int(11) NOT NULL,
  `catalog_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products_catalog`
--

INSERT INTO `products_catalog` (`product_id`, `catalog_id`) VALUES
(8, 1),
(6, 1),
(7, 1),
(2, 4),
(2, 2),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_list` text COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `timer` int(11) NOT NULL,
  `view` int(11) NOT NULL,
  `catalog_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `home` tinyint(1) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services_catalogservice`
--

CREATE TABLE IF NOT EXISTS `services_catalogservice` (
  `service_id` int(11) NOT NULL,
  `catalog_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setup`
--

CREATE TABLE IF NOT EXISTS `setup` (
  `id` int(11) NOT NULL,
  `col` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=187 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setup`
--

INSERT INTO `setup` (`id`, `col`, `value`) VALUES
(1, 'phone', '{"phone1":"0902983367","phone2":"000000000"}'),
(2, 'address', '{"address1":"56 Y\\u00ean Th\\u1ebf, Ph\\u01b0\\u1eddng 2, Qu\\u1eadn T\\u00e2n B\\u00ecnh, TP. H\\u1ed3 Ch\\u00ed Minh","address2":"409\\/5 Nguy\\u1ec5n Oanh, Ph\\u01b0\\u1eddng 17, Qu\\u1eadn G\\u00f2 V\\u1ea5p- TP H\\u1ed3 Ch\\u00ed Minh"}'),
(3, 'email', 'tungocsang88@gmail.com.vn'),
(4, 'website', 'nhadatduytan.com'),
(5, 'company', '{"tenquocte":"Nh\\u00e0 \\u0110\\u1ea5t Duy T\\u00e2n","tengoitat":"DuyTanLand"}'),
(6, 'logo', '{"name":"Logo","image_link":"\\/uploads\\/images\\/logo.png"}'),
(7, 'favico', '/uploads/images/logo.png'),
(8, 'map', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.125253019372!2d106.68259151395137!3d10.801717761682106!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528da7d3bd7ed%3A0x6fa69e50130290a0!2zOTQgUGjDuW5nIFbEg24gQ3VuZywgUGjGsOG7nW5nIDcsIFBow7ogTmh14bqtbiwgSOG7kyBDaMOtIE1pbmgsIFZp4buHdCBOYW0!5e0!3m2!1svi!2s!4v1594028111643!5m2!1svi!2s'),
(9, 'footer1', '{"title":"TH\\u00d4NG TIN LI\\u00caN H\\u1ec6","content":"<p>Nh\\u00e0 \\u0110\\u1ea5t Duy T\\u00e2n<\\/p>\\r\\n\\r\\n<p>----------------------------<\\/p>\\r\\n\\r\\n<p>Chuy\\u00ean nh\\u00e0 \\u0111\\u1ea5t B\\u00ecnh T\\u00e2n - T\\u00e2n Ph\\u00fa<\\/p>\\r\\n\\r\\n<p>\\u0110i\\u1ec7n tho\\u1ea1i: 0902 98 33 67<\\/p>\\r\\n\\r\\n<p>Email: nhadatduytanhcm@gmail.com<\\/p>\\r\\n\\r\\n<p>&nbsp;<\\/p>\\r\\n"}'),
(10, 'footer2', '{"title":"CH\\u00cdNH S\\u00c1CH","content":"<p>- H\\u1ed7 tr\\u1ee3 ki\\u1ec3m tra ph\\u00e1p l\\u00fd, qui ho\\u1ea1ch<\\/p>\\r\\n\\r\\n<p>- H\\u1ed7 tr\\u1ee3 vay v\\u1ed1n ng\\u00e2n h\\u00e0ng<\\/p>\\r\\n\\r\\n<p>- H\\u1ed7 tr\\u1ee3 c\\u00f4ng ch\\u1ee9ng, sang t\\u00ean<\\/p>\\r\\n"}'),
(11, 'footer3', '{"title":"\\u0110\\u0102NG K\\u00dd NH\\u1eacN NH\\u00c0 M\\u1edaI","content":"<ul>\\r\\n\\t<li><a href=\\"http:\\/\\/www.vdsilver.com\\/c-san-pham\\/nhan-nam\\">Nh\\u1eabn nam<\\/a><\\/li>\\r\\n\\t<li><a href=\\"http:\\/\\/www.vdsilver.com\\/c-san-pham\\/nhan-nu\\">Nh\\u1eabn n\\u1eef&nbsp;<\\/a><\\/li>\\r\\n\\t<li><a href=\\"http:\\/\\/www.vdsilver.com\\/c-san-pham\\/day-chuyen\\">D\\u00e2y chuy\\u1ec1n<\\/a><\\/li>\\r\\n\\t<li><a href=\\"http:\\/\\/www.vdsilver.com\\/c-san-pham\\/phu-kien\\">Ph\\u1ee5 ki\\u1ec7n<\\/a><\\/li>\\r\\n<\\/ul>\\r\\n"}'),
(12, 'footer4', '{"title":"FANPAGE","content":""}'),
(14, 'emailnhan', 'tungocsang88@gmail.com'),
(15, 'social', '{"facebook":"","id_facebook":"#","youtube":"","zalo":"0902983367","skype":"#","linkedin":"#","twitter":"https:\\/\\/www.facebook.com\\/tuvan.iweb247.vn\\/","instagram":""}'),
(16, 'copyright', '<p style="text-align: center;">Design by&nbsp;<a href="http://nhadatduytan.com">nhadatduytan.com</a></p>\r\n'),
(17, 'script_head', '<!-- Global site tag (gtag.js) - Google Analytics -->\r\n<script async src="https://www.googletagmanager.com/gtag/js?id=UA-197561233-1"></script>\r\n<script>\r\n  window.dataLayer = window.dataLayer || [];\r\n  function gtag(){dataLayer.push(arguments);}\r\n  gtag(''js'', new Date());\r\n\r\n  gtag(''config'', ''UA-197561233-1'');\r\n</script>\r\n'),
(18, 'script_body', ''),
(19, 'script_footer', ''),
(35, 'seo', '{"title":"TRANG CH\\u1ee6","description":"TRANG CH\\u1ee6","keyword":"TRANG CH\\u1ee6","image_link":""}'),
(151, 'sidebarNew', '{"title":"TIN M\\u1edaI NH\\u1ea4T"}'),
(36, 'seo_contact', '{"title":"LI\\u00caN H\\u1ec6","description":"LI\\u00caN H\\u1ec6","keyword":"LI\\u00caN H\\u1ec6","image_link":""}'),
(37, 'content_contact', '{"title":"LI\\u00caN H\\u1ec6","info":"<h2>FORM LI\\u00caN H\\u1ec6<\\/h2>\\r\\n\\r\\n<p>\\u0110\\u1ecba ch\\u1ec9: ADSAFDSAFDSAF<\\/p>\\r\\n\\r\\n<p>Email: dsafdsaklf@gmail.com<\\/p>\\r\\n\\r\\n<p>SDT: 09092103<\\/p>\\r\\n\\r\\n<p>Website: dsflakjlds.vn<\\/p>\\r\\n","success":"<p>C\\u1ea3m \\u01a1n b\\u1ea1n \\u0111\\u00e3 li\\u00ean h\\u1ec7!<\\/p>\\r\\n"}'),
(38, 'nganhang', '<p>xxx</p>\r\n'),
(39, 'cartdone', '<p>Cảm ơn Quý khách đã đặt hàng từ Shop, Shop sẽ liên hệ với Quý khách ngay sau khi nhận được đơn hàng!</p>\r\n'),
(115, 'slogan', 'Xin chào Quý khách!!!'),
(152, 'visit', '{"online":"0","day":"0","week":"0","month":"0","total":"0"}'),
(153, 'sort_catalog', 'numAsc'),
(154, 'sort_catalog_new', 'numAsc'),
(155, 'sort_catalog_image', 'numAsc'),
(156, 'sort_catalog_service', 'numAsc'),
(157, 'sort_products', 'timerDesc'),
(158, 'sort_news', 'timerDesc'),
(159, 'sort_images', 'timerAsc'),
(160, 'sort_services', 'timerAsc'),
(161, 'pagination_catalog', '3'),
(162, 'pagination_catalog_new', '10'),
(163, 'pagination_catalog_image', '1'),
(164, 'pagination_catalog_service', '3'),
(165, 'limit_catalog', '20'),
(166, 'limit_catalog_new', '10'),
(167, 'limit_catalog_image', '3'),
(168, 'limit_catalog_service', '4'),
(169, 'check_css', 'off'),
(170, 'emailorder', 'coder@iweb247.vn'),
(182, 'bannerHeader', '/uploads/images/khung-header.png'),
(183, 'homeProduct', 'Dự án nổi bật 2'),
(184, 'sidebarReg', '{"title":"\\u0110\\u0102NG K\\u00dd XEM NH\\u00c0","success":"Ch\\u00fac m\\u1eebng! Th\\u00f4ng tin c\\u1ee7a b\\u1ea1n \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c g\\u1eedi \\u0111i!"}'),
(185, 'sidebarProduct', '{"title":"B\\u00c1N NH\\u00c0 \\u0110\\u1ea4T QU\\u1eacN B\\u00ccNH T\\u00c2N"}'),
(186, 'sidebarBank', '{"title":"NG\\u00c2N H\\u00c0NG","content":"<p>dsafdsafdasf<\\/p>\\r\\n\\r\\n<p><img alt=\\"\\" src=\\"\\/uploads\\/images\\/hinh-demo.png\\" \\/><\\/p>\\r\\n"}');

-- --------------------------------------------------------

--
-- Table structure for table `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supportonline`
--

CREATE TABLE IF NOT EXISTS `supportonline` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `chucdanh` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `url`, `intro`, `title`, `description`, `keyword`, `image_link`, `image_seo`, `created`, `updated`, `sort_order`) VALUES
(1, 'tin tức 1', 'tin-tuc-1', '', '', '', '', '', '', 1621152621, 0, 1),
(2, 'tin bất động sản', 'tin-bat-dong-san', '', '', '', '', '', '', 1621152621, 0, 0),
(3, 'bất động sản 2021', 'bat-dong-san-2021', '', '', '', '', '', '', 1621152621, 0, 0),
(4, 'a', 'a', '', '', '', '', '', '', 1621395722, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tagsproduct`
--

CREATE TABLE IF NOT EXISTS `tagsproduct` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `intro` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `keyword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_seo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tagsproduct_products`
--

CREATE TABLE IF NOT EXISTS `tagsproduct_products` (
  `tag_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `tags_news`
--

CREATE TABLE IF NOT EXISTS `tags_news` (
  `tag_id` int(11) NOT NULL,
  `new_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `tags_news`
--

INSERT INTO `tags_news` (`tag_id`, `new_id`) VALUES
(3, 1),
(2, 1),
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `id` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `other_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `other_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `other_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `other_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_mst` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `ship` int(11) NOT NULL,
  `payment` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL,
  `note_admin` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_online`
--

CREATE TABLE IF NOT EXISTS `user_online` (
  `session` char(200) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ward`
--

CREATE TABLE IF NOT EXISTS `ward` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `district_id` int(11) NOT NULL,
  `sort_order` int(11) NOT NULL,
  `sidebar` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ward`
--

INSERT INTO `ward` (`id`, `name`, `district_id`, `sort_order`, `sidebar`) VALUES
(9, 'Bình Hưng Hòa A', 17, 1, 1),
(11, 'Bình Trị Đông', 17, 3, 1),
(10, 'Bình Hưng Hòa B', 17, 2, 1),
(8, 'Bình Hưng Hòa', 17, 0, 1),
(12, 'Bình Trị Đông A', 17, 4, 0),
(13, 'Bình Trị Đông B', 17, 5, 0),
(14, 'Tân Tạo', 17, 6, 0),
(15, 'Tân Tạo A', 17, 6, 0),
(16, 'An Lạc', 17, 7, 0),
(17, 'An Lạc A', 17, 8, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_group`
--
ALTER TABLE `admin_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`),
  ADD UNIQUE KEY `url_2` (`url`),
  ADD KEY `url_3` (`url`);

--
-- Indexes for table `catalog_image`
--
ALTER TABLE `catalog_image`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indexes for table `catalog_new`
--
ALTER TABLE `catalog_new`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indexes for table `catalog_service`
--
ALTER TABLE `catalog_service`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_email`
--
ALTER TABLE `contact_email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_footer`
--
ALTER TABLE `contact_footer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_phone`
--
ALTER TABLE `contact_phone`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_view`
--
ALTER TABLE `contact_view`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `direction`
--
ALTER TABLE `direction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header_link`
--
ALTER TABLE `header_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`),
  ADD FULLTEXT KEY `title` (`name`);

--
-- Indexes for table `notlink`
--
ALTER TABLE `notlink`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`),
  ADD FULLTEXT KEY `name` (`name`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indexes for table `setup`
--
ALTER TABLE `setup`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `col` (`col`);

--
-- Indexes for table `slide`
--
ALTER TABLE `slide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supportonline`
--
ALTER TABLE `supportonline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indexes for table `tagsproduct`
--
ALTER TABLE `tagsproduct`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url` (`url`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ward`
--
ALTER TABLE `ward`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `admin_group`
--
ALTER TABLE `admin_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `catalog_image`
--
ALTER TABLE `catalog_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `catalog_new`
--
ALTER TABLE `catalog_new`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `catalog_service`
--
ALTER TABLE `catalog_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `contact_email`
--
ALTER TABLE `contact_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `contact_footer`
--
ALTER TABLE `contact_footer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contact_phone`
--
ALTER TABLE `contact_phone`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `contact_view`
--
ALTER TABLE `contact_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `direction`
--
ALTER TABLE `direction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `district`
--
ALTER TABLE `district`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `header_link`
--
ALTER TABLE `header_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=148;
--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `notlink`
--
ALTER TABLE `notlink`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `setup`
--
ALTER TABLE `setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=187;
--
-- AUTO_INCREMENT for table `slide`
--
ALTER TABLE `slide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supportonline`
--
ALTER TABLE `supportonline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tagsproduct`
--
ALTER TABLE `tagsproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ward`
--
ALTER TABLE `ward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
