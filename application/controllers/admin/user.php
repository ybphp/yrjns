<?php if(!defined('BASEPATH')) exit('非法访问');
class User extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('admin/user_model','user');
	}
	//展示会员列表
	public function list_user(){
		$this->load->library('pagination');
		$perpage = 7;
		//配置分页信息
		$config['base_url'] = site_url('admin/user/list_user/');
		$config['total_rows'] = $this->db->count_all_results('user');
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
		$data['user'] = $this->user->list_user();
		$this->load->view('admin/list_user.html',$data);
	}

	//添加用户页面
	public function add_user_page(){
		$this->load->view('admin/add_user.html');
	}

	//添加用户
	public function add_user(){
		 //设置验证规则
		$this->form_validation->set_rules('username','用户名','required');
		$this->form_validation->set_rules('password','密码','required|min_length[4]|max_length[12]|md5');
		$this->form_validation->set_rules('repwd','重复密码','required|matches[password]');
		$this->form_validation->set_rules('email','邮箱','required');
		if($this->form_validation->run()==false){
			echo validation_errors();
		}else{
			$data['username']=$this->input->post('username',true);
			$data['password']=md5($this->input->post('password',true));
			$data['email']=$this->input->post('email',true);
			$data['addtime']=date('Y-m-d H:i:s',time());
			$data['user_ip'] = $_SERVER['REMOTE_ADDR'];
			//var_dump($data);die;
			if($this->user->add_user($data)){
				e('admin/user/add_user_page','添加失败');
			}
			else{
				s('admin/user/list_user','添加成功');
			}
		}
	 }



	 //删除用户
	 public function del($id){
	 	 $id=$this->uri->segment(4);
	 	 $this->user->del($id);
	 	 s('admin/user/list_user','删除成功');	
	 }
}