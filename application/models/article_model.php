<?php if(!defined('BASEPATH')) exit('非法访问');
class Article_model extends CI_Model{
	//添加文章
	public function add_article($data){
		$result = $this->db->insert('article',$data);
		return $result;
	}

	//文章列表
	public function list_article(){
		$condition['auditing'] = 'T';
		$data = $this->db->where($condition)->order_by('id','desc')->get('article')->result_array();
		return $data;
	}

	//最新文章展示
	public function hot_article(){
		$condition['status'] = '最新';
		$condition['auditing'] = "T";
		$data = $this->db->where($condition)->order_by('id','desc')->limit(10)->get('article')->result_array();
		return $data;
	}

	//最热文章展示
	public function new_article(){
		$condition['status'] = '最热';
		$condition['auditing'] = "T";
		$data = $this->db->where($condition)->order_by('id','desc')->limit(2)->get('article')->result_array();
		return $data;
	}

	//技术文档列表
	public function document_article(){
		$condition['cate'] = '技术文档';
		$condition['auditing'] = "T";
		$data = $this->db->where($condition)->order_by('id','desc')->get('article')->result_array();
		return $data;
	}

	//冰霜时节文章列表
	public function bssj_article(){
		$condition['cate'] = '冰霜时节';
		$condition['auditing'] = "T";
		$data = $this->db->where($condition)->order_by('id','desc')->limit(6)->get('article')->result_array();
		return $data;
	}

	//可显示文章列表总数
	public function page_total(){
		//$total = $this->db->where('auditing','F')->count_all('article');
		$total = $this->db->query("select auditing from yr_article where auditing='T'")->num_rows();
		return $total;
	}
	
	//可显示评论列表总数
	public function lyb_total($ar_id){
		$condition['article_id'] = $ar_id;
		$total = $this->db->where($condition)->get('lyb')->num_rows();
		return $total;
	}

	//查看文章
	public function show_article($ar_id){
		$this->db->query("update yr_article set sum=sum+1 where id='$ar_id'");
		$condition['id'] = $ar_id;
		$query = $this->db->where($condition)->get('article');
		return $query->row_array();
	}

	//栏目列表
	public function show_cate(){
		$data = $this->db->get('category')->result_array();
		return $data;
	}

	//收藏文章
	public function collect_article($data){
		$result = $this->db->where($data)->get('collect_article')->num_rows();
		if($result>=1){
			return false;
		}
		else{
			$status= $this->db->insert('collect_article',$data);
			return true;
		}
	}
	
	//文章评论
	public function lyb_article($data){
		$result = $this->db->insert('lyb',$data);
		return $result;
	}
	//查看评论
	public function show_lyb($ar_id){
		$condition['article_id'] = $ar_id;
		$result= $this->db->where($condition)->order_by('id','desc')->get('lyb')->result_array();
		return $result;
	}
	
	//检查用户是否提交相同评论
	public function check_lyb($data){
		$result = $this->db->where($data)->get('lyb')->num_rows();
		if($result>=1){
			return false;
		}
		else{
			return true;
		}
	}
}