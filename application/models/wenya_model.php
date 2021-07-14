<?php if(!defined('BASEPATH')) exit('非法访问');
class Wenya_model extends CI_Model{
	//添加文章
	public function add($data){
		$this->db->insert('wenya',$data);
		return true;
	}

}