<?php
defined('BASEPATH') or exit('No direct script access allowed');

function get_time_logo($time)
{
	$format = '<div class="current-time"><span class="time">%H:%i</span></div>';
	$date = mdate($format, $time);
	return $date;
}
function get_gio_phu($time)
{
	$format = '%H:%i GMT +7';
	$date = mdate($format, $time);
	return $date;
}
function get_date_admin($time)
{
	$format = '%d/%m/%Y %H:%i';
	$date = mdate($format, $time);
	return $date;
}
function convert_time_admin($time)
{
	$time = str_replace("/", "-", $time);
	return strtotime($time);
}
function get_date($time, $full_time = true)
{
	$format = '%d/%m/%Y';
	if ($full_time) {
		$format = $format . ' %h:%i:%s';
	}
	$date = mdate($format, $time);
	return $date;
}
function get_date_user($time)
{
	$format = '%d/%m/%Y';
	$date = mdate($format, $time);
	return $date;
}
function get_ngay($time)
{
	$format = '%d';
	$date = mdate($format, $time);
	return $date;
}
function get_thang($time)
{
	$format = '%m';
	$date = mdate($format, $time);
	return $date;
}
function get_thu_ngay($time)
{
	$format = '%D, %d/%m/%Y';
	$date = mdate($format, $time);
	if (strstr($date, 'Mon') == true) {
		$date = str_replace('Mon', 'Thứ Hai', $date);
	}
	if (strstr($date, 'Tue') == true) {
		$date = str_replace('Tue', 'Thứ Ba', $date);
	}
	if (strstr($date, 'Wed') == true) {
		$date = str_replace('Wed', 'Thứ Tư', $date);
	}
	if (strstr($date, 'Thu') == true) {
		$date = str_replace('Thu', 'Thứ Năm', $date);
	}
	if (strstr($date, 'Fri') == true) {
		$date = str_replace('Fri', 'Thứ Sáu', $date);
	}
	if (strstr($date, 'Sat') == true) {
		$date = str_replace('Sat', 'Thứ Bảy', $date);
	}
	if (strstr($date, 'Sun') == true) {
		$date = str_replace('Sun', 'Chủ Nhật', $date);
	}
	return $date;
}
