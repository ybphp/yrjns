<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
class Write extends Home_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('article_model','article');
		$this->load->library('upload');
		$this->load->library('pagination');
	}
	
	//载入发表文章页
	public function write_article(){
		$data['cate'] = $this->article->show_cate();
		$this->load->view('index/header.html');
		$this->load->view('index/write.html',$data);
		$this->load->view('index/footer.html');
	}

	//发表文章
	public function add_article(){
		/*************文件上传*************/
		
		//载入上传类
		$status = $this->upload->do_upload('pic');
		if(!$status){
			e('必须选择上传一张图片');
		}
		$wrong = $this->upload->display_errors();
		if($wrong){
			e($wrong);
		}
		//返回信息
		$info = $this->upload->data();
		//var_dump($info);die;

		/***********缩略图*************/
		//配置
		$pic['source_image'] = $info['full_path'];
		$pic['create_thumb'] = false;
		$pic['maintain_ratio'] = true;
		$pic['width'] = 240;
		$pic['height'] = 240;

		//载入缩略图类
		$this->load->library('image_lib',$pic);

		//执行动作
		$img = $this->image_lib->resize();
		if(!$img){
			error('缩略图操作失败');
		}

		//获取表单信息
		$data['cate'] = $this->input->post('mySelect');
		$data['role'] = $this->input->post('radioSet');
		$data['author'] = $this->input->post('author');
		$data['pic'] = $info['file_name'];
		$data['addtime'] = $this->input->post('employTime');
		$data['title'] = $this->input->post('title');
		$data['content'] = $this->input->post('content');
		//var_dump($data);die;
		$result = $this->article->add_article($data);
		if($result){
			e("发表失败");
		}
		else{
			s('index/write/write_article','发表成功，等待审核');
		}
	}
}