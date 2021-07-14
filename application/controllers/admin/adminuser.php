<?php if(!defined('BASEPATH')) exit('非法访问');
class Adminuser extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('admin/admin_model','admin');
	}
	//展示管理员列表
	public function list_admin(){
		$perpage = 7;
		//配置分页信息
		$config['base_url'] = site_url('admin/adminuser/list_admin/');
		$config['total_rows'] = $this->db->count_all_results('admin');
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
		$data['admin'] = $this->admin->list_admin();
		$this->load->view('admin/list_admin.html',$data);
	}

	//引入管理员添加页面
	public function add_admin_page(){
		$this->load->view('admin/add_admin.html');
	}
	//添加管理员动作
	public function add_admin(){
		 //设置验证规则
		$this->form_validation->set_rules('admin_name','管理员名称','required');
		$this->form_validation->set_rules('admin_password','管理员密码','required|min_length[4]|max_length[12]|md5');
		$this->form_validation->set_rules('repwd','重复密码','required|matches[admin_password]');
		if($this->form_validation->run()==false){
			echo validation_errors();
		}else{
			$data['admin_name']=$this->input->post('admin_name',true);
			$data['admin_password']=md5($this->input->post('admin_password',true));
			$data['addtime']=date('Y-m-d H:i:s',time());
			$status = $this->admin->add_admin($data);
			//var_dump($status);die;
			if($status){
				s('admin/adminuser/list_admin','添加成功');
			}
			else{
				e('admin/adminuser/add_admin_page','添加失败');
			}
		}
	 }

	 //编辑页面
	 public function edit_admin(){
	 	$id = $this->uri->segment(4);
	 	$data['admin'] = $this->admin->check_admin($id);
	 	$this->load->view('admin/edit_admin.html',$data);
	 }

	 /*
	 *编辑动作
	 */
	 public function edit(){
			$id=$this->input->post('id');
			$admin_name=$this->input->post('admin_name');
			$admin_password = md5(trim($this->input->post('admin_password')));
			$data=array(
				'admin_name'=>$admin_name,
				'admin_password'=>$admin_password;
			$status = $this->admin->update_admin($id,$data);
			if($status){
				s('admin/adminuser/list_admin','修改成功');
			}
			else{
				e('修改失败！');
			}
	 }

	 //删除栏目
	 public function del($id){
	 	 $id=$this->uri->segment(4);
	 	 $this->admin->del_admin($id);
	 	 s('admin/adminuser/list_admin','删除成功');

	 }
	}