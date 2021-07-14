<?php if(!defined('BASEPATH')) exit('非法访问');
//管理员登陆
class Privilege_model extends CI_Model{
	public function get_admin($admin_name,$admin_password){
		$condition['admin_name']=$admin_name;
		$condition['admin_password']=md5($admin_password);
		$query = $this->db->where($condition)->get('admin');
		return $query->row_array();
	}
}