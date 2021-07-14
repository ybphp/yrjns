<?php if(!defined('BASEPATH'))exit('非法访问');
class Category extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->model('admin/category_model','cate');
	}
	/*
	 *显示栏目
	 */
	 public function list_cate(){
	 	$perpage = 7;
		//配置分页信息
		$config['base_url'] = site_url('admin/category/list_cate/');
		$config['total_rows'] = $this->db->count_all_results('category');
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
		 $data['cate'] = $this->cate->list_cate();
		 $this->load->view('admin/list_cate.html',$data);
	 }

	/*
	 *添加栏目页面
	 */
	 public function add_cate_page(){
	 	$this->load->helper('form');
		$this->load->view('admin/add_cate.html');
	 }

	 /*
	 *添加栏目动作
	 */
	 public function add_cate(){
		
		$status=$this->form_validation->run('cate');
		if($status){
			$data =array(
				'cname'=>$_POST['cname'],
				'summary'=>$_POST['summary']
			);
			$this->cate->add_cate($data);
			s('admin/category/list_cate','添加成功');
		}else{
			$this->load->helper('form');
			$this->load->view('admin/add_cate.html');
		}
	 }

	 /*
	 *编辑栏目
	 */
	 public function edit_cate(){
		 $id=$this->uri->segment(4);
		 //echo $id;die;
		 $data['cate']= $this->cate->check_cate($id);
		 $this->load->helper('form');
		 //var_dump($data);die;
		 $this->load->view('admin/edit_cate.html',$data);
	 }

	 /*
	 *编辑动作
	 */
	 public function edit(){
		$status=$this->form_validation->run('cate');
		if($status){
			$id=$this->input->post('id');
			$cname=$this->input->post('cname');
			$summary = $this->input->post('summary');
			$data=array(
				'cname'=>$cname,
				'summary'=>$summary);
			$data['cate']=$this->cate->update_cate($id,$data);
			s('admin/category/list_cate','修改成功');
		}else{
			$this->load->helper('form');
			$this->load->view('admin/edit_cate.html');
		}
	 }

	 //删除栏目
	 public function del($id){
	 	 $id=$this->uri->segment(4);
	 	 $this->cate->del($id);
	 	 s('admin/category/list_cate','删除成功');
	 	
	 }
}