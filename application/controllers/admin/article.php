<?php if(!defined('BASEPATH')) exit("非法访问");
/*
 *发表文章类
 */
class Article extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('upload');
		$this->load->model('admin/article_model','article');
	}

	/*
	 *文章
	 */
	public function list_article(){
		$perpage = 7;
		//配置分页信息
		$config['base_url'] = site_url('admin/article/list_article/');
		$config['total_rows'] = $this->db->count_all_results('article');
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
		$data['article']=$this->article->list_article();
		$this->load->view('admin/list_article.html',$data);
	}


	/*
	 *编辑文章
	 */
	public function edit_article(){
		 $id=$this->uri->segment(4);
		 $data['cate'] = $this->article->show_cate();
		 $data['article']= $this->article->check_article($id);
		 $this->load->helper('form');
		 $this->load->view('admin/edit_article.html',$data);
	}

	/*
	 *编辑文章动作
	 */
	 public function edit(){
		$status = $this->upload->do_upload('pic');
		if($status){
			//载入上传类
		$img = $this->upload->do_upload('pic');
		if(!$img){
			error('必须选择上传一张图片');
		}
		$wrong = $this->upload->display_errors();
		if($wrong){
			error($wrong);
		}
		//返回信息
		$info = $this->upload->data();
		/**********缩略图************/
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
		$data['pic'] = $info['file_name'];
	}

		//获取表单信息
		$data['id'] = $this->input->post('id');
		$data['cate'] = $this->input->post('mySelect');
		$data['role'] = $this->input->post('radioSet');
		$data['author'] = $this->input->post('author');
		$data['addtime'] = $this->input->post('employTime');
		$data['title'] = $this->input->post('title');
		$data['content'] = $this->input->post('content');
		//var_dump($data);die();
		$result = $this->article->update_article($data);
		if($result){
				redirect('admin/article/list_article');
			}
		else{
				echo "发表失败";
			}

 	}

 	//文章审核页面
 	public function auditing(){
 		$perpage = 7;
		//配置分页信息
		$config['base_url'] = site_url('admin/article/auditing/');
		$config['total_rows'] = $this->db->count_all_results('article');
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
 		$data['article']=$this->article->list_article();
 		$this->load->view('admin/list_auditing.html',$data);
 	}

 	//修改文章状态动作
 	public function update_auditing(){
 		$data['id'] = $this->input->post('id');
 		$data['auditing'] = $this->input->post('auditing');
 		$data['status'] = $this->input->post('status');
 		$result = $this->article->update_auditing($data);
 		if($result){
 			s('admin/article/auditing','修改成功');
 		} else{
 			e('修改失败');
 		}
 	}

 	//删除文章
 	public function del_article(){
	 $id=$this->uri->segment(4);
	 $status = $this->article->del_article($id);
	 if($status)
	 	s('admin/article/list_article','删除成功');
	else
		e('删除失败！');
 	}
}