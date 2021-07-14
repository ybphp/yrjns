<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("content-type:text/html;charset=utf-8");
class Wenya extends CI_Controller{
		public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('wenya_model','wenya');
	}
	//文雅网祝福语入库
	public function index(){
		$data['username'] = trim($this->input->get_post('username'));
		$data['email'] = trim($this->input->post('email'));
		$data['content'] = trim($this->input->post('content'));
		$result= $this->wenya->add($data);
		if($result){ 
		    echo "1";
		}else{ 
		   echo "0";
		} 
	}
}