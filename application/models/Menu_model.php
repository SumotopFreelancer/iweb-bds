<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Menu_model extends MY_Model
{
    var $table = 'menu';

    function get_menu($sort = [])
    {
        $input = $menuItems = [];
        $input['where'] = ['status' => 1, 'parent_id' => 0];
        $input['order_by'] = ['sort_order' => 'asc'];
        $menuItems = $this->menu_model->get_list($input);
        $this->get_child($menuItems);
        return $menuItems;
    }

    function get_child($items)
    {
        $menuItems = [];
        foreach ($items as $item) {
            $item->child = [];
            if (count($this->menu_model->menucon($item->id)) > 0) {
                $menuItems = $this->menu_model->menucon($item->id, ['sort_order', 'asc']);
                $item->child = $menuItems;
                $this->get_child($menuItems);
            }
        }
        return $menuItems;
    }

    function get_menu_admin($sort = [])
    {
        $input = $menuItems = [];
        $input['where'] = ['parent_id' => 0];
        $input['order_by'] = ['sort_order' => 'asc'];
        $menuItems = $this->menu_model->get_list($input);
        $this->get_child_admin($menuItems);
        return $menuItems;
    }

    function get_child_admin($items)
    {
        $menuItems = [];
        foreach ($items as $item) {
            $item->child = [];
            if (count($this->menu_model->menucon_admin($item->id)) > 0) {
                $menuItems = $this->menu_model->menucon_admin($item->id, ['sort_order', 'asc']);
                $item->child = $menuItems;
                $this->get_child_admin($menuItems);
            }
        }
        return $menuItems;
    }

    function updateMenu($id, $type, $url)
    {
        $where = ['id_type' => $id, 'type' => $type];
        if ($this->menu_model->check_exists($where)) {
            $data = [
                'url' => $url,
            ];
            $this->menu_model->update_rule($where, $data);
        }
    }
}
