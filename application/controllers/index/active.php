<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
class Active extends CI_Controller{
		public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('user_model','user');
	}
	//邮箱验证
	public function checkactive(){
		$verify = trim($this->input->get_post('verify'));
		//p($verify);die;
		$nowtime = time(); 
		$data = $this->user->ckActive($verify);
		if(!empty($data)){ 
		    if($nowtime>$data[0]['token_exptime']){
		       e('您的激活有效期已过，请登录您的帐号重新发送激活邮件.'); 
		    }else{
		    	$status['id'] = $data[0]['id'];
		    	$status['status'] = 1; 
		        $result = $this->user->activeEmail($status); 
		        if($result) 
		       s('index/user/login','邮箱激活成功，欢迎登录！'); 
		    } 
		}else{ 
		    	e('验证失败,请重新验证！');     
		} 
	}

	//找回密码
	public function resetPassword(){
		$token = trim($this->input->get_post('token'));
		$nowtime = time(); 
		$data = $this->user->resetPassword($token);
		if(!empty($data)){ 
		    if($nowtime>$data[0]['token_exptime']){
		       e('您的激活有效期已过，请登录您的帐号重新发送激活邮件.'); 
		    }else{
		    	$this->session->set_userdata('user_token',$token);
		       s('index/active/resetPassword_view','邮箱验证成功，请重置密码！'); 
		    } 
		}else{ 
		    	e('验证失败,请重新验证！');     
		} 
	}

	//载入重置密码页
	public function resetPassword_view(){
		$user_token = $this->session->userdata('user_token');
		if(!empty($user_token)){
			$this->load->view('index/reset_password.html');
		}else{
			e('没发现你的找回密码密钥啊！');
		}
	}

	//重置密码动作
	public function resetPassword_action(){
		$this->form_validation->set_rules('pwd','密码','required|min_length[4]|max_length[12]|md5');
		$this->form_validation->set_rules('repwd','重复密码','required|matches[pwd]');
		$data['password'] = md5(trim($this->input->post('pwd',true)));
		$data['token'] = $this->session->userdata('user_token');
		//var_dump($data);die;
		if($this->form_validation->run()==false){
				echo validation_errors();
			}else{
				if($this->user->newPassword($data)){
					s('index/user/login','重置密码成功！');
				}else{
					e('重置密码失败！');
				}
			}
	}
}