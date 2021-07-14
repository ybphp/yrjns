<?php if(!defined("BASEPATH")) exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
class Member extends Home_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('email');
		$this->load->library('pagination');
		$this->load->library('upload');
		$this->load->library('form_validation');
		$this->load->model('member_model','member');
	}

	/*
	 *用户信息管理
	 */
	public function userinfo(){
		//获取该用户名
		$user = $this->session->userdata('user');
		$data['article'] = $this->member->list_article($user['username']);
		//var_dump($data);die;

		//文章分页
		$perpage = 3;
		//配置分页信息
		$config['base_url'] = site_url('index/member/userinfo/');
		$config['total_rows'] = $this->db->where(array('author'=>$user['username']))->count_all_results('article');
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
		//文章列表
		$data['article']=$this->member->list_article($user['username']);
		//载入用户信息管理页
		$this->load->view('index/member.html',$data);
	}
	//展示文章详情
	public function show_article($id){
		//$ar_id = $this->input->post('id');
		$data['content'] = $this->member->show_article($id);
		$this->load->view('index/content.html',$data);
	}

	//删除文章
 	public function del_article(){
	 $id=$this->uri->segment(4);
	 $status = $this->member->del_article($id);
	 if($status)
	 	s('index/member/userinfo','删除成功');
	else
		e('删除失败！');
 	}

 	//展示收藏文章
 	public function collect_article(){
 		//获取该用户名
		$user = $this->session->userdata('user');
		$username = $user['username'];
		$config['base_url'] = site_url('index/member/collect_article/');
		//文章分页
		$perpage = 3;
		//配置分页信息
		$config['base_url'] = site_url('index/member/collect_article/');
		$config['total_rows'] =$this->db->where(array('collect_user'=>$username))->count_all_results('collect_article');
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
		//p($offset);die;
		$this->db->limit($perpage,$offset);
		//文章列表
		$data['collect_article']=$this->member->list_collect_article($username);
		//载入用户信息管理页
		$this->load->view('index/collect_article.html',$data);
 	}

 	//删除收藏文章
 	public function del_collect_article(){
	 $cid=$this->uri->segment(4);
	 $status = $this->member->del_collect_article($cid);
	 if($status)
	 	s('index/member/collect_article','移除成功');
	else
		e('移除失败！');
 	}

 	//个人信息左侧栏目

 	//上传用户头像
 	public function userpic(){
		//载入上传类
		$status = $this->upload->do_upload('touxiang');
		if(!$status){
			e('请选择一张图片');
		}
		$wrong = $this->upload->display_errors();
		if($wrong){
			e($wrong);
		}
		//返回信息
		$info = $this->upload->data();

		/***********缩略图*************/
		//配置
		$pic['source_image'] = $info['full_path'];
		$pic['create_thumb'] = false;
		$pic['maintain_ratio'] = true;
		$pic['width'] = 100;
		$pic['height'] = 100;

		//载入缩略图类
		$this->load->library('image_lib',$pic);

		//执行动作
		$img = $this->image_lib->resize();
		if(!$img){
			error('缩略图操作失败');
		}

		//获取表单
		$user = $this->session->userdata('user');
		$data['username'] = $user['username'];
		$data['user_pic'] = $info['file_name'];
		//获取用户头像
		$userpic= $this->member->show_userpic($user['username']);
		// file_exists() 函数检查文件或目录是否存在。
		//p($userpic);die;
	 	$myfile = 'public/uploads/'.$userpic[0]['user_pic'];
	 	 //var_dump($myfile);die;
		  if (file_exists($myfile)) {
		    $result=unlink($myfile);
		  }
		$result = $this->member->userpic($data);
		if($result){
			s('index/member/userinfo','添加头像成功');
		}
		else{
			e("添加失败");
		}

 	}


 	//个人信息页
 	public function memberinfo(){
 		$user = $this->session->userdata('user');
		//获取用户信息
		$data['user']= $this->member->show_userpic($user['username']);
		//载入个人信息页
 		$this->load->view('index/member_info.html',$data);
 	}

 	//修改个人信息动作
 	public function edit_memberinfo(){
 		$this->form_validation->set_rules('username','用户名','required');
 		$this->form_validation->set_rules('realname','真实姓名','max_length[12]');
 		$this->form_validation->set_rules('gener','性别','integer');
 		if($this->form_validation->run()==false){
 			echo validation_errors();
 		}else{
	 		$data['username']=$this->input->post('username',true);
			$data['realname']=$this->input->post('realname',true);
			$data['gener']=$this->input->post('sex',true);
			//p($data);die;
			$result = $this->member->edit_memberinfo($data);
			if($result)
				s('index/member/memberinfo','修改成功');
			else
				e('修改失败！');
		}
 	}

 	//密码修改页
 	public function edit_password(){
 		$this->load->view('index/edit_password.html');
 	}

 	//修改密码动作
 	public function edit_password_action(){
 		$this->form_validation->set_rules('password','原密码','required');
		$this->form_validation->set_rules('pwd','密码','required|min_length[4]|max_length[12]|md5');
		$this->form_validation->set_rules('repwd','重复密码','required|matches[pwd]');
		if($this->form_validation->run()==false){
 			echo validation_errors();
 		}else{
	 			//检查原密码是否正确
	 			$password = trim($this->input->post('password'));
				$result = $this->member->ckPassword($password);
				//p($result);die;
				if(!empty($result)){
					$user = $this->session->userdata('user');
					$data['username'] = $user['username'];
			 		$data['password']=md5(trim($this->input->post('password',true)));
					$result = $this->member->edit_password($data);
					if($result)
						s('index/member/edit_password','修改成功');
					else
						e('修改失败！');
			}
			else{
				e('艹，原密码不会忘了吧！');
			}
		}
 	}
}