<?php if(!defined('BASEPATH')) exit('非法访问');
//用户管理模型
class User_model extends CI_Model{
	const TBL_USER = 'user';
	//注册用户
	public function user_add($data){
		return $this->db->insert(self::TBL_USER,$data);
	}
	//验证邮箱是否已被注册
	public function checkEmail($email){
		$condition['email']=$email;
		$data = $this->db->where($condition)->get(self::TBL_USER);
		return $data->row_array();
	}

	//验证用户名是否已被使用
	public function checkUsername($username){
		$condition['username']=$username;
		$data = $this->db->where($condition)->get(self::TBL_USER);
		return $data->row_array();
	}

	//用户登陆
	public function get_user($username,$password){
		$condition['username']=$username;
		$condition['password']=md5($password);
		$condition['status'] = 1;
		$query = $this->db->where($condition)->get(self::TBL_USER);
		return $query->row_array();
	}

	//用户帐号是否被激活
	public function get_user_status($username){
		$condition['username']=$username;
		$condition['status'] = 1;
		$query = $this->db->where($condition)->get(self::TBL_USER);
		return $query->row_array();
	}

	//用户帐号是否存在
	public function check_user($username){
		$condition['username']=$username;
		$query = $this->db->where($condition)->get(self::TBL_USER);
		return $query->row_array();
	}

	//找回密码时验证用户是否存在
	public function findPassword($data){
		$condition['username']=$data['username'];
		$condition['email']=$data['email'];
		$condition['status']=1;
		$query = $this->db->where($condition)->get(self::TBL_USER);
		return $query->row_array();
	}

	//找回密码密钥更新
	public function findPassword_token($data){
		$condition['username']=$data['username'];
		$condition['status']=1;
		$this->db->where($condition)->update(self::TBL_USER,$data);
		return true;
	}

	//找回密码激活码验证
	public function resetPassword($token){
		$condition['token']=$token;
		$condition['status'] = "1";
		$data = $this->db->where($condition)->get(self::TBL_USER)->result_array();
		return $data;
	}

	//重置密码
	public function newPassword($data){
		$condition['token']=$data['token'];
		$this->db->where($condition)->update(self::TBL_USER,$data);
		return true;
	}

	//邮箱激活码验证
	public function ckActive($verifty){
		$condition['token']=$verifty;
		$condition['status'] = "0";
		$data = $this->db->where($condition)->get(self::TBL_USER)->result_array();
		return $data;
	}

	//邮箱激活
	public function activeEmail($status){
		$condition['id']=$status['id'];
		$this->db->where($condition)->update(self::TBL_USER,$status);
		return true;
	}
}