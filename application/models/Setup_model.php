<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Setup_model extends MY_Model
{
	var $table = 'setup';

	function get_setup($col = [])
	{
		$this->db->select('col, value');
		if ($col) {
			$this->db->where_in('col', $col);
		}
		$query = $this->db->get($this->table);
		$allData = $query->result_array();
		$newArr = [];
		foreach ($allData as $value) {
			$newArr[$value['col']] = $value['value'];
		}
		return (object) $newArr;
	}
}
