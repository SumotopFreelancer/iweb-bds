<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Productscatalog_model extends MY_Model
{
	var $table = 'products_catalog';

	function get_list_catalog_by_product_id($id)
	{
		$this->db->select("catalog_id");
		$this->db->where('product_id', $id);
		$query = $this->db->get($this->table);
		$result = [];
		foreach ($query->result() as $key => $value) {
			$result[$key] = $value->catalog_id;
		}
		return $result;
	}
}
