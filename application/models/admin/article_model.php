<?php if(!defined('BASEPATH')) exit('非法访问');
class Article_model extends CI_Model{
	//添加文章
	public function add_article($data){
		$this->db->insert('article',$data);
	}

	//文章列表
	public function list_article(){
		$data = $this->db->order_by('id','desc')->get('article')->result_array();
		return $data;
	}

	//查看文章
	public function show_article($ar_id){
		$condition['id'] = $ar_id;
		$query = $this->db->where($condition)->get('article');
		return $query->row_array();
	}
	//查看对应文章
	public function check_article($id){
		$data = $this->db->where(array('id'=>$id))->get('article')->result_array();
		return $data;
	}

	//修改文章
	public function update_article($data){
		$id=$data['id'];
		$this->db->update('article',$data,array('id' =>$id));
		return true;
	}

	//审核文章状态
	public function update_auditing($data){
		$id=$data['id'];
		$this->db->update('article',$data,array('id' =>$id));
		return true;
	}

	//栏目列表
	public function show_cate(){
		$data = $this->db->get('category')->result_array();
		return $data;
	}

	//删除文章
	public function del_article($id){
		$this->db->delete('article',array('id'=>$id));
		return true;
	}
}