<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tagsnews_model extends MY_Model
{
	var $table = 'tags_news';

	function get_total_tags($input = [])
	{
		if ((isset($input['where'])) && $input['where']) {
			$this->db->where($input['where']);
		}
		$query = $this->db->get($this->table);
		return $query->num_rows();
	}
}
