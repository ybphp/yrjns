<?php if(!defined('BASEPATH')) exit('非法访问');
//用户管理模型
class Member_model extends CI_Model{
	//文章列表
	public function list_article($username){
		$condition['author'] = $username;
		$data = $this->db->where($condition)->order_by('id','desc')->get('article')->result_array();
		return $data;
	}

	//查看文章
	public function show_article($id){
		$condition['id'] = $id;
		$query = $this->db->where($condition)->get('article');
		return $query->row_array();
	}

	//删除文章
	public function del_article($id){
		$this->db->delete('article',array('id'=>$id));
		return true;
	}
	//收藏文章列表
	public function list_collect_article($username){
		$data = $this->db->query("select c.id as cid,c.collect_user,c.collect_time,a.id as aid,a.title,a.author,a.pic,a.cate from yr_collect_article as
c left join yr_article as a on c.collect_article_id=a.id where collect_user='$username'" )->result_array();
		//var_dump($data);die;
		return $data;
	}

	//移除收藏文章
	public function del_collect_article($cid){
		$this->db->delete('collect_article',array('id'=>$cid));
		return true;
	}

	//添加头像
	public function userpic($data){
		$condition['username'] = $data['username'];
		$this->db->where($condition)->update('user',$data);
		return true;
	}

	//显示头像
	public function show_userpic ($username){
		$condition['username'] = $username;
		$data = $this->db->where($condition)->get('user')->result_array();
		return $data;
	}

	//更新用户信息
	public function edit_memberinfo($data){
		$condition['username'] = $data['username'];
		$this->db->where($condition)->update('user',$data);
		return true;
	}

	//检查原密码
	public function ckPassword($password){
		$condition['password'] = md5($password);
		$data = $this->db->where($condition)->get('user')->row_array();
		return $data;
	}

	//修改密码
	public function edit_password($data){
		$condition['username'] = $data['username'];
		$this->db->where($condition)->update('user',$data);
		return true;
	}
}