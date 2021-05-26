<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tagsproductproducts_model extends MY_Model
{
	var $table = 'tagsproduct_products';

	function get_total_tags($input = [])
	{
		if ((isset($input['where'])) && $input['where']) {
			$this->db->where($input['where']);
		}
		$query = $this->db->get($this->table);
		return $query->num_rows();
	}
}
