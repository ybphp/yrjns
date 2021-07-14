<?php if(!defined('BASEPATH'))exit('No direct script acess allow');
class Admin_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$admin_name = $this->session->userdata('admin_name');
		if(!$admin_name){
			redirect('admin/privilege/login');
		}
	}
}

class Home_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$user= $this->session->userdata('user');
		if(!$user){
			s('index/user/login','请先登录！');
		}
	}
}