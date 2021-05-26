<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ajax extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function slug()
	{
		$name = trim($this->input->post('name', TRUE));
		$model = $this->input->post('model');
		$this->load->model($model);
		$action = $this->input->post('action');
		$url = chuyenurl($name);

		$where = ['url' => $url];
		if ($action == 'add') {
			if ($this->{$model}->get_info_rule($where)) {
				$url = $url . '-' . now();
			}
		} else {
			$id = $this->input->post('id');
			if ($this->{$model}->get_info_rule($where)) {
				$info_slug = $this->{$model}->get_info_rule($where);
				if ($info_slug->id != $id) {
					$url = $url . '-' . now();
				}
			}
		}
		echo $url;
	}

	function convert_tags()
	{
		$this->load->model('tags_model');
		$name = mb_strtolower(trim($this->input->post('name')));
		$action = $this->input->post('action');
		$url = chuyenurl($name);
		$where = ['url' => $url];
		if ($action == 'add') {
			if ($this->tags_model->check_exists($where)) {
				$input = [];
				$input['where'] = ['name' => $name];
				$num = $this->tags_model->get_total($input);
				$url = $url . '-' . $num;
			}
		} else {
			$id = $this->input->post('id');
			if ($this->tags_model->check_exists($url)) {
				$info = $this->tags_model->get_info_rule($url);
				if ($info->id != $id) {
					$input = [];
					$input['where'] = ['name' => $name];
					$num = $this->tags_model->get_total($input);
					$url = $url . '-' . $num;
				}
			}
		}
		echo $url;
	}

	function convert_tagsproduct()
	{
		$this->load->model('tagsproduct_model');
		$name = mb_strtolower(trim($this->input->post('name')));
		$action = $this->input->post('action');
		$url = chuyenurl($name);
		$where = ['url' => $url];
		if ($action == 'add') {
			if ($this->tagsproduct_model->check_exists($where)) {
				$input = [];
				$input['where'] = ['name' => $name];
				$num = $this->tagsproduct_model->get_total($input);
				$url = $url . '-' . $num;
			}
		} else {
			$id = $this->input->post('id');
			if ($this->tagsproduct_model->check_exists($url)) {
				$info = $this->tagsproduct_model->get_info_rule($url);
				if ($info->id != $id) {
					$input = [];
					$input['where'] = ['name' => $name];
					$num = $this->tagsproduct_model->get_total($input);
					$url = $url . '-' . $num;
				}
			}
		}
		echo $url;
	}

	// function inserttag(){
	// 	$this->load->model('tagsnews_model');
	// 	$filejson = file_get_contents('./news.json');
	// 	$json_data = isJson($filejson,true);
	// 	foreach($json_data as $row){
	// 		if(isJson($row->tags)){
	// 			foreach(isJson($row->tags) as $tag){
	// 				$data = ['new_id' => $row->id, 'tag_id' => $tag];
	// 				$this->tagsnews_model->create($data);
	// 			}
	// 		}
	// 	}
	// }
}
