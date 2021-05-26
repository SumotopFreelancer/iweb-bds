<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Sidebar extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        if ($this->input->post()) {
            $data = [
                'sidebarReg' => json_encode([
                    'title' => $this->input->post('sidebarRegTitle', TRUE),
                    'success' => $this->input->post('sidebarRegSuccess', TRUE)
                ]),
                'sidebarProduct' => json_encode([
                    'title' => $this->input->post('sidebarProductTitle', TRUE)
                ]),
                'sidebarBank' => json_encode([
                    'title' => $this->input->post('sidebarBankTitle', TRUE),
                    'content' => $this->input->post('sidebarBankContent')
                ]),
                'sidebarNew' => json_encode([
                    'title' => $this->input->post('sidebarNewTitle', TRUE)
                ])
            ];
            foreach ($data as $key => $row) {
                if ($this->setup_model->update_rule(['col' => $key], ['value' => $row])) {
                    $this->session->set_flashdata('message', '<div class="callout callout-success">Chỉnh sửa thành công</div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="callout callout-danger">Không chỉnh sửa được</div>');
                }
            }
            redirect(admin_url('sidebar'));
        }
        $this->data['temp'] = 'admin/sidebar/index';
        $this->load->view('admin/main', $this->data);
        $this->db->cache_delete_all();
    }
}
