<?php if(!defined('BASEPATH')) exit('非法访问');
class Photo_model extends CI_Model{
	//相册列表
	public function list_photo(){
		$data=$this->db->get('photo')->result_array();
		return $data;
	}

}