<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tags_model extends MY_Model
{
	var $table = 'tags';

	function check_name_tags($name)
	{
		$query = $this->db->query("select * from tags where name LIKE CONCAT(convert('" . mb_strtolower($name) . "', BINARY))");
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	function get_info_tags($name)
	{
		$query = $this->db->query("select * from tags where name LIKE CONCAT(convert('" . mb_strtolower($name) . "', BINARY))");
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
	}
	function get_list_tag_by_new_id($id)
	{
		$this->db->select('tags.id, tags.name, tags.url');
		$this->db->from('tags_news');
		$this->db->join('tags', 'tags.id = tags_news.tag_id', 'left');
		$this->db->where('new_id', $id);
		return $this->db->get()->result();
	}
	function get_list_tag_by_tag_id($input = [])
	{
		$this->db->select('news.id, news.name, news.intro, news.url, news.image_link, news.catalog_id, news.timer');
		$this->db->join('tags_news', 'tags_news.new_id = news.id');
		$this->db->join('tags', 'tags_news.tag_id = tags.id');
		if ((isset($input['where'])) && $input['where']) {
			$this->db->where($input['where']);
		}
		$this->db->group_by('news.id');
		$this->db->order_by('timer', 'desc');
		if (isset($input['limit'][0]) && isset($input['limit'][1])) {
			$this->db->limit($input['limit'][0], $input['limit'][1]);
		}
		return $this->db->get('news')->result();
	}
	function get_total_tag_by_tag_id($input = [])
	{
		$this->db->select('news.id, news.name, news.url, news.image_link, news.catalog_id, news.timer');
		$this->db->join('tags_news', 'tags_news.new_id = news.id');
		$this->db->join('tags', 'tags_news.tag_id = tags.id');
		if ((isset($input['where'])) && $input['where']) {
			$this->db->where($input['where']);
		}
		$this->db->group_by('news.id');
		return $this->db->get('news')->num_rows();
	}
}
