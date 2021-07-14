<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
class Article extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('article_model','article');
		$this->load->library('pagination');
	}

	//展示文章列表
	public function list_article(){
		$perpage = 4;
		//配置分页信息
		$config['base_url'] = site_url('index/article/list_article/');
		$config['total_rows'] = $this->article->page_total();
		$config['per_page'] = $perpage;
		$config['uri_segment'] = 4;

		//自定义分页链接
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		//初始化分页类
		$this->pagination->initialize($config);
		$data['pageinfo'] = $this->pagination->create_links();
		//p($data);die;
		$offset=$this->uri->segment(4);
		$this->db->limit($perpage,$offset);

		$data['res'] = $this->article->list_article();
		$this->load->view('index/header.html');
		$this->load->view('index/article.html',$data);
		$this->load->view('index/footer.html');
	}

	//技术文档列表
	public function list_document(){
		$perpage = 12;
		//配置分页信息
		$config['base_url'] = site_url('index/article/list_document/');
		$config['total_rows'] = $this->article->page_total();
		$config['per_page'] = $perpage;
		$config['uri_segment'] = 4;

		//自定义分页链接
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		//初始化分页类
		$this->pagination->initialize($config);
		$data['pageinfo'] = $this->pagination->create_links();
		//p($data);die;
		$offset=$this->uri->segment(4);
		$this->db->limit($perpage,$offset);

		$data['res'] = $this->article->document_article();
		$this->load->view('index/document.html',$data);
	}
	
	//文章详情页
	public function show_article(){
		$ar_id = $this->uri->segment(4);
		$data['content'] = $this->article->show_article($ar_id);
		$data['lyb'] = $this->article->show_lyb($ar_id);
		$this->load->view('index/content.html',$data);
	}
	
	//留言详情页
	public function show_lyb(){
	$ar_id = 40;
		//评论分页
		$perpage = 2;
		//配置分页信息
		$config['base_url'] = site_url('index/article/show_lyb/');
		$config['total_rows'] = $this->article->lyb_total($ar_id);
		$config['per_page'] = $perpage;
		$config['uri_segment'] = 4;

		//自定义分页链接
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';
		//初始化分页类
		$this->pagination->initialize($config);
		$data['pageinfo'] = $this->pagination->create_links();
		$offset=$this->uri->segment(4);
		$this->db->limit($perpage,$offset);
		$data['lyb'] = $this->article->show_lyb($ar_id);
		$this->load->view('index/content.html',$data);
	}

	//收藏文章
	public function collect_article(){
		$user = $this->session->userdata('user');
		if(!empty($user)){
			$data['collect_article_id'] = $this->input->post('collect_article_id');
			$data['collect_user'] = $this->input->post('collect_user');
			$result = $this->article->collect_article($data);
			if($result){
				e('收藏成功');
			}
			else{
				e('您已经收藏该文章！');
			}
		}else{
			e("请先登录");
		}
	}
	
	//发表评论
	public function lyb_article(){
		$user = $this->session->userdata('user');
		$data['username'] = trim($this->input->post('username'));
		$data['content'] = trim($this->input->post('content'));
		$data['article_id'] = $this->input->post('article_id');
		if(!empty($user)){
			$data['username'] = $user;
		}
		//将为空的数组去除
		//$data = array_filter($data);
		//var_dump($temp);die;
		if(empty($data['username'])){
			e('请填写昵称！');
		}
		if(empty($data['content'])){
			e('请填写评论！');
		}
		if(empty($data['article_id'])){
			e('文章id未获取到，这是一个错误！');
		}
		$check_result = $this->article->check_lyb($data);
		if(!$check_result){
			e("该评论你已提交！");
		}
		$result = $this->article->lyb_article($data);
			if($result){
				e('评论成功！');
			}
			else{
				e('抱歉，评论失败！');
			}
	}

}