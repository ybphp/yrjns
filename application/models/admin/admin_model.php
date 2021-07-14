<?php if(!defined('BASEPATH')) exit('非法访问');
//管理员信息管理
class Admin_model extends CI_Model{
	//管理员列表
	public function list_admin(){
		$data=$this->db->get('admin')->result_array();
		return $data;
	}

	//添加
	public function add_admin($data){
		$this->db->insert('admin',$data);
		return true;
	}

	//查看对应管理员详情
	public function check_admin($id){
		$data = $this->db->where(array('id'=>$id))->get('admin')->result_array();
		return $data;
	}

	//修改
	public function update_admin($id,$data){
		$this->db->update('admin',$data,array('id'=>$id));
		return true;
	}

	//删除
	public function del_admin($id){
		$this->db->delete('admin',array('id'=>$id));
	}
}