<?php if(!defined('BASEPATH')) exit('非法访问');
class Admin extends Admin_Controller{
	//后台首页
	public function index(){
		$this->load->view('admin/main.html');
	}
	//展示头部
	public function top(){
		$this->load->view('admin/top.html');
	}
	//展示左侧
	public function left(){
			$this->load->view('admin/left.html');
	}
	//展示中间
	public function center(){
		$this->load->view('admin/center.html');
	}
	//展示底部
	public function down(){
			$this->load->view('admin/down.html');
	}
	//展示内容
	public function tab(){
			$this->load->view('admin/tab.html');
	}
}