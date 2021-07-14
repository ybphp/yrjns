<?php if(!defined('BASEPATH')) exit('非法访问');
//用户管理模型
class Search_model extends CI_Model{
	
	//前台首页搜索
	public function search_article($status){
		
		//$total = $this->db->query("select * from yr_article where content regexp replace('$status',',','|')")->result();
		//对象转换为数组
		//$arr = (array)$total;
		$result = $this->db->query("select id,title,author from yr_article where author like '%$status%' or content like '%$status%'" )->result_array();
		//var_dump($total);die;
		return $result;
		
	}

}