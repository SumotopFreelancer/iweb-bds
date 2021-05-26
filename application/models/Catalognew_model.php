<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Catalognew_model extends MY_Model
{
	var $table = 'catalog_new';

	function parent($catalog)
	{
		if ($catalog->parent_id == 0) {
			return $catalog;
		} else {
			$c = $this->catalognew_model->get_info($catalog->parent_id);
			if ($c->parent_id == 0) {
				return $c;
			} else {
				$c1 = $this->catalognew_model->get_info($c->parent_id);
				if ($c1->parent_id == 0) {
					return $c1;
				} else {
					$c2 = $this->catalognew_model->get_info($c1->parent_id);
					return $c2;
				}
			}
		}
	}
}
