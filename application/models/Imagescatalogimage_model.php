<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Imagescatalogimage_model extends MY_Model
{
	var $table = 'images_catalogimage';

	function get_list_catalog_by_image_id($id)
	{
		$this->db->select("catalog_id");
		$this->db->where('image_id', $id);
		$query = $this->db->get($this->table);
		$result = [];
		foreach ($query->result() as $key => $value) {
			$result[$key] = $value->catalog_id;
		}
		return $result;
	}
}
