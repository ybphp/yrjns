<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
class Photo extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('photo_model','photo');
	}
	//相册页
	public function list_photo(){
		$data['photo']=$this->photo->list_photo();
		$this->load->view('index/photo.html',$data);
	}
	
}