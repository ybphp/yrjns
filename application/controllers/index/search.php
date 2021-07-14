<?php
header('Content-Type: text/html; charset=utf-8');
/*
 *前台搜索控制器
 */
class Search extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('search_model','search');
	}
	public function search_article(){
		$status = trim($this->input->post('search_article'));
		if(empty($status)){
			e('请输入关键字！');exit;
		}
		$data['search'] = $this->search->search_article($status);
		//var_dump($data['search']);die;
		if(empty($data['search'])){
			e('抱歉，不能给你结果！');
		}else{
			$this->load->view('index/search.html',$data);
		}
	}
}