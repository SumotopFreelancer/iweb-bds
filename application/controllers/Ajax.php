<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Ajax extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('ward_model');
    }
    function ajax_get_ward()
    {
        $result = [
            'status' => -1,
            'message' => 'Truy cập không cho phép'
        ];
        if ($this->input->post()) {
            $district_id = $this->input->post('district_id');
            $input = [];
            $input['where'] = ['district_id' => $district_id];
            $input['order_by'] = ['sort_order' => 'asc'];
            $wards = $this->ward_model->get_list($input);
            if (!empty($wards)) {
                $html = '<li data-id="0" data-type="default" class="itext-9" onclick="get_val_data(this)">-- Chọn phường --</li>';
                foreach ($wards as $row) {
                    $html .= '<li data-id="' . $row->id . '" data-type="default" class="itext-9" onclick="get_val_data(this)">' . $row->name . '</li>';
                }
                $result = [
                    'status' => 1,
                    'html' => $html
                ];
            } else {
                $result = [
                    'status' => 0,
                    'message' => 'Không tìm thấy dữ liệu'
                ];
            }
        }
        echo json_encode($result);
    }
}
