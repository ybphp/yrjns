<?php if(!defined('BASEPATH')) exit('非法访问');
//栏目管理模型
class Category_model extends CI_Model{
	//添加栏目
	public function add_cate($data){
		$this->db->insert('category',$data);
	}
	//查看栏目
	public function list_cate(){
		$data = $this->db->get('category')->result_array();
		return $data;
	}

	//查看对应栏目
	public function check_cate($id){
		$data = $this->db->where(array('id'=>$id))->get('category')->result_array();
		return $data;
		//p($data);die;
	}

	//修改栏目
	public function update_cate($id,$data){
		$this->db->update('category',$data,array('id' =>$id));
	}

	//删除栏目
	public function del($id){

		$this->db->delete('category',array('id'=>$id));
	}
}