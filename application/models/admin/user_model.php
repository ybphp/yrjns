<?php if(!defined('BASEPATH')) exit('非法访问');
//后台用户信息管理
class User_model extends CI_Model{
	//用户列表
	public function list_user(){
		$data=$this->db->get('user')->result_array();
		return $data;
	}

	//添加用户
	public function add_user($res){
		$this->db->insert('user',$res);
	}
	//删除用户
	public function del($id){

		$this->db->delete('user',array('id'=>$id));
	}
}