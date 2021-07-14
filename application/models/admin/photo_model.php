<?php if(!defined('BASEPATH')) exit('非法访问');
//xi相册信息管理
class Photo_model extends CI_Model{
	//相册列表
	public function list_photo(){
		$data=$this->db->get('photo')->result_array();
		return $data;
	}

	//添加
	public function add_photo($data){
		$this->db->insert('photo',$data);
		return true;
	}

	//删除
	public function del($id){
		$this->db->delete('photo',array('id'=>$id));
		return true;
	}

	//查看对应图片信息
	public function check_photo($id){
		$data = $this->db->where(array('id'=>$id))->get('photo')->result_array();
		return $data;
	}

	//修改图片
	public function update_photo($id,$data){
		$this->db->update('photo',$data,array('id' =>$id));
		return true;
	}
}