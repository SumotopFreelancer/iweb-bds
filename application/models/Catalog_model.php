<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Catalog_model extends MY_Model
{
	var $table = 'catalog';

	function parent($catalog)
	{
		if ($catalog->parent_id == 0) {
			return $catalog;
		} else {
			$c = $this->catalog_model->get_info($catalog->parent_id);
			if ($c->parent_id == 0) {
				return $c;
			} else {
				$c1 = $this->catalog_model->get_info($c->parent_id);
				if ($c1->parent_id == 0) {
					return $c1;
				} else {
					$c2 = $this->catalog_model->get_info($c1->parent_id);
					return $c2;
				}
			}
		}
	}
}
