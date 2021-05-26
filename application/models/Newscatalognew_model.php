<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Newscatalognew_model extends MY_Model
{
	var $table = 'news_catalognew';

	function get_list_catalog_by_new_id($id)
	{
		$this->db->select("catalog_id");
		$this->db->where('new_id', $id);
		$query = $this->db->get($this->table);
		$result = [];
		foreach ($query->result() as $key => $value) {
			$result[$key] = $value->catalog_id;
		}
		return $result;
	}
}
