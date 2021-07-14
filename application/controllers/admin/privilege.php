<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Privilege extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('captcha');
	    $this->load->library('form_validation');
		$this->load->model('admin/privilege_model');
	}
	//用户登陆页
	public function login(){
		$this->load->view('admin/login.html');
	}
	//用户登陆动作
	public function loginin(){
		$admin_name=trim($this->input->post('admin_name'));
		$admin_password=trim($this->input->post('admin_password'));
		//$captcha = strtolower($this->input->post('captcha'));
		#获取session中保存的验证码
		//$code = strtolower($this->session->userdata('code'));
		//p($code);die;
		//var_dump($admin_name);var_dump($admin_password);die;
		//if($captcha === $code){
			if($admin=$this->privilege_model->get_admin($admin_name,$admin_password)){
				//登陆成功，保存session
				$this->session->set_userdata('admin_name',$admin);
				echo "1";
			}
			else{
				echo "0";
			}
		//}else{
			//e("验证码错误！");
		//}
	}


	//生成验证码
	//public function code(){
		//$vals = array(
			//'word_length'=>4,
			//'img_width' => 120,
			//'img_height' => 30,
		//);
		//$code = create_captcha($vals);
		//$this->session->set_userdata('code',$code);
	//}

	//退出登陆
	public function login_out(){
		//清除session
		$this->session->sess_destroy();
		redirect('admin/privilege/login');
		/* <a href="<?php echo site_url('admin/privilege/login_out');?>">退出</a>*/
	}
}