<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Content-Type: text/html; charset=utf-8');
class User extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('captcha');
	    $this->load->library('form_validation');
		$this->load->model('user_model','user');
	}
	//用户登陆页
	public function login(){
		$this->load->view('index/header.html');
		$this->load->view('index/login.html');
		$this->load->view('index/footer.html');
	}
	//用户登陆动作
	public function signin(){
		$username=$this->input->post('username');
		$password=$this->input->post('password');
		$captcha = strtolower($this->input->post('captcha'));
		$code = strtolower($this->session->userdata('code'));
		if($captcha === $code){
			if($this->user->check_user($username)){
				if($this->user->get_user_status($username)){
					if($user = $this->user->get_user($username,$password)){
						//登陆成功，保存session
						$this->session->set_userdata('user',$user);
						redirect('index/home/index');
					}
					else{
						s('index/user/login',"用户名或密码错误！");
					}
				}else{
					e("该用户账号尚未被激活！");
				}
			}else{
				e('该用户尚未被注册！');
			}
		}else{
			s('index/user/login',"验证码错误，请重新输入");
		}
	}



	//用户注册页
	public function register(){
		$this->load->view('index/header.html');
		$this->load->view('index/register.html');
		$this->load->view('index/footer.html');
	}

	//用户注册动作
	 public function do_register(){
		 //设置验证规则
		$this->form_validation->set_rules('username','用户名','required');
		$this->form_validation->set_rules('password','密码','required|min_length[4]|max_length[12]|md5');
		$this->form_validation->set_rules('repwd','重复密码','required|matches[password]');
		$this->form_validation->set_rules('email','电子邮箱','required|valid_email');
		$captcha = strtolower($this->input->post('captcha'));
		$code = strtolower($this->session->userdata('code'));
		$email=$this->input->post('email');
		$username=trim($this->input->post('username'));
        $ckemail =$this->user->checkEmail($email);
        $ckusername =$this->user->checkUsername($username);
		if($captcha === $code){
			if($this->form_validation->run()==false){
				echo validation_errors();
			}else{
				if(!empty($ckusername)){
					e('不是告诉你了嘛，该用户名已被注册！');
				}

				if(!empty($ckemail)){
					e('不是说过邮箱已被注册了嘛!');
				}

				$data['username']=$this->input->post('username',true);
				$data['password']=$this->input->post('password',true);
				$data['email']=$this->input->post('email',true);
				//构造邮箱激活识别码
				$data['token'] = md5($data['username'].$data['password'].$data['email']);
				$data['token_exptime'] = time()+60*60*24;
				$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
				if($this->user->user_add($data)){
					//发送邮件
					$config['protocol'] = 'smtp';
					$config['smtp_host'] = 'smtp.163.com';
					$config['smtp_user'] = 'y13696535419@163.com';
					$config['smtp_pass'] = 'QWY0708';
					$config['mailtype'] = 'html';
					$config['validate'] = true;
					$config['priority'] = 1;
					$config['crlf'] = "\r\n";
					$config['smtp_port'] = 25;
					$config['charset'] = 'utf-8';
					$config['wordwrap'] = TRUE;
					$this->load->library('email');
					$this->email->initialize($config);
					$email=$this->input->get_post('email',true);
					//var_dump($email);die;
					$this->email->from('y13696535419@163.com','悠然见南山');
					$this->email->to($data['email']);
					$this->email->subject('悠然见南山');
					$emailbody = "亲爱的<font color='#ff0000'><strong>".$data['username']."：</strong></font><br/><font color='#ff0000'>欢迎来到悠然见南山文章网！</font><br/>请点击链接激活您的帐号。<br/>
				    <a href='http://www.yrjns.net/index.php/index/active/checkactive?verify=".$data['token']."' target=
				'_blank'>http://www.yrjns.net/index.php/index/active/checkactive?verify=".$data['token']."</a><br/>
				    如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。";
					$this->email->message($emailbody);
					if (!$this->email->send()){
						echo $this->email->print_debugger();
					}else{
						e("邮件已成功发送,请验证后登录！(提示：您的邮箱可能会将此验证邮件误认为成垃圾邮件，请到垃圾箱里找回该邮件！)");
						// redirect('www.yrjns.net');
					}
				}
				else{
					e('注册失败');
				}
			}
		}else{
			e("验证码错误，请重新输入!");
		}
	 }

	  //用户信息写入user_reg表，同时也把sina_id写入sina_login表
	 public function reg() {
          $haha =array(
                      "user_id" => $rs,
                      "sina_id" => $this->session->userdata('sina_id'),
                      "qq_id"   =>$this->session->userdata('qq_id'),
                      );
            if($haha['sina_id']||$haha['qq_id'])    $this->third->binding_third($haha);
    }
	//生成验证码
	public function code(){
		$vals = array(
			'word_length'=>4,
			'img_width' => 120,
			'img_height' => 30,
		);
		$code = create_captcha($vals);
		$this->session->set_userdata('code',$code);
	}

	//查看用户名是否已被注册
    public function ckUsername(){
		$username=trim($this->input->post('username'));
        $ckusername =$this->user->checkUsername($username);
        if(empty($ckusername)){
        	echo "<span style='color:green'>恭喜，可以使用！</span>";

        } else {
            echo "<span style='color:red'>此用户名已被使用</span>";
        }
    }

	 //验证邮箱是否存在
    public function ckEmail(){
		$email=trim($this->input->post('email'));
        $ckemail =$this->user->checkEmail($email);
        if(empty($ckemail)){
        	echo "<span style='color:green'>恭喜，邮箱可以使用！</span>";

        } else {
            echo "<span style='color:red'>此邮箱已被注册</span>";
        }
    }

    //找回密码
    //载入找回密码页
    public function findPassword(){
    	$this->load->view('index/find_password.html');
    }
    //找回密码动作
    public function findPassword_action(){
    	//设置验证规则
		$this->form_validation->set_rules('username','用户名','required');
		$this->form_validation->set_rules('email','电子邮箱','required|valid_email');
    	$data['username'] = $this->input->post('username');
    	$data['email'] = $this->input->post('email');
    	$data['token_exptime'] = time()+60*60*24;
    	//密钥
    	$key='1234';
    	$data['token'] = md5($data['username'].$data['email'].$key);
    	$result = $this->user->findPassword($data);
    	//var_dump($result);die;
    	if(!empty($result)){
    		if($this->user->findPassword_token($data)){
    		//发送邮件
					$config['protocol'] = 'smtp';
					$config['smtp_host'] = 'smtp.163.com';
					$config['smtp_user'] = 'y13696535419@163.com';
					$config['smtp_pass'] = 'QWY0708';
					$config['mailtype'] = 'html';
					$config['validate'] = true;
					$config['priority'] = 1;
					$config['crlf'] = "\r\n";
					$config['smtp_port'] = 25;
					$config['charset'] = 'utf-8';
					$config['wordwrap'] = TRUE;
					$this->load->library('email');
					$this->email->initialize($config);
					$email=$this->input->get_post('email',true);
					//var_dump($email);die;
					$this->email->from('y13696535419@163.com','悠然见南山');
					$this->email->to($data['email']);
					$this->email->subject('悠然见南山');
					$emailbody = "亲爱的<font color='#ff0000'><strong>".$data['username']."：</strong></font><br/>您在".date('Y-m-d:H:i:s')."提交了找回密码请求。请点击下面的链接重置密码<br/>
				    <a href='http://www.yrjns.net/index.php/index/active/resetpassword?token=".$data['token']."' target=
				'_blank'>http://www.yrjns.net/index.php/index/active/resetpassword?token=".$data['token']."</a><br/>
				    如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接24小时内有效。";
					$this->email->message($emailbody);
					if (!$this->email->send()){
						echo $this->email->print_debugger();
					}else{
						e("系统已向您的邮箱发送了一封邮件<br/>请登录到您的邮箱及时重置您的密码！(提示：系统可能将该邮件误认为成垃圾邮件，请到垃圾箱里找回该邮件！)");
						// redirect('www.yrjns.net');
					}
				}else{
					e('抱歉，你的密码因为人品不能被找回！请您以后更正人品！');
				}

    	}else{
    		e('您输入的用户名或邮箱有误！');
    	}
    }

    //退出登陆
	public function logout(){
		$this->session->unset_userdata('user');
		redirect('index/home/index');
	}
}