<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tagsproduct_model extends MY_Model
{
	var $table = 'tagsproduct';

	function check_name_tags($name)
	{
		$query = $this->db->query("select * from tagsproduct where name LIKE CONCAT(convert('" . mb_strtolower($name) . "', BINARY))");
		if ($query->num_rows() > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	function get_info_tags($name)
	{
		$query = $this->db->query("select * from tagsproduct where name LIKE CONCAT(convert('" . mb_strtolower($name) . "', BINARY))");
		if ($query->num_rows()) {
			return $query->row();
		}
		return FALSE;
	}
	function get_list_tag_by_product_id($id)
	{
		$this->db->select('tagsproduct.id, tagsproduct.name, tagsproduct.url');
		$this->db->from('tagsproduct_products');
		$this->db->join('tagsproduct', 'tagsproduct.id = tagsproduct_products.tag_id', 'left');
		$this->db->where('product_id', $id);
		return $this->db->get()->result();
	}
	function get_list_tag_by_tag_id($input = [])
	{
		$this->db->select('products.id, products.name, products.url, products.image_link, products.catalog_id');
		$this->db->join('tagsproduct_products', 'tagsproduct_products.product_id = products.id');
		$this->db->join('tagsproduct', 'tagsproduct_products.tag_id = tagsproduct.id');
		if ((isset($input['where'])) && $input['where']) {
			$this->db->where($input['where']);
		}
		$this->db->group_by('products.id');
		$this->db->order_by('timer', 'desc');
		if (isset($input['limit'][0]) && isset($input['limit'][1])) {
			$this->db->limit($input['limit'][0], $input['limit'][1]);
		}
		return $this->db->get('products')->result();
	}
	function get_total_tag_by_tag_id($input = [])
	{
		$this->db->select('products.id, products.name, products.url, products.image_link, products.catalog_id');
		$this->db->join('tagsproduct_products', 'tagsproduct_products.product_id = products.id');
		$this->db->join('tagsproduct', 'tagsproduct_products.tag_id = tagsproduct.id');
		if ((isset($input['where'])) && $input['where']) {
			$this->db->where($input['where']);
		}
		$this->db->group_by('products.id');
		return $this->db->get('products')->num_rows();
	}
}
