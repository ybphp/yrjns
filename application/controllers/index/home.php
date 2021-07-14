<?php if(!defined('BASEPATH')) exit('非法访问');
/*
 *默认前台控制器
 */
class Home extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('article_model','article');
	}
	//首页显示
	public function index(){
		//$this->output->cache(59/60);
		$data['hot'] = $this->article->hot_article();
		$data['new'] = $this->article->new_article();
		$data['bssj'] = $this->article->bssj_article();
		//var_dump($data);die();
		$this->load->view('index/index.html',$data);
	}

	//相册页
	public function photo(){
		$this->load->view('index/header.html');
		$this->load->view('index/photo.html');
		$this->load->view('index/footer.html');
	}
	//个人详情页
	public function message(){
		$this->load->view('index/header.html');
		$this->load->view('index/message.html');
		$this->load->view('index/footer.html');
	}
	//给丫头的空间
	public function love(){
		$this->load->view('index/love.html');
	}

	//文雅网
	public function wenya(){
		$this->load->view('index/wenya.html');
	}

	//双色球页
	public function doubleBall(){
		$this->load->view('index/doubleBall.html');
	}

 }