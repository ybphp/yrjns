<?php if(!defined('BASEPATH'))exit('非法访问');
class Photo extends Admin_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('upload');
		$this->load->library('pagination');
		$this->load->model('admin/photo_model','photo');
	}

	//相册列表
	public function list_photo(){
		$perpage = 4;
		//配置分页信息
		$config['base_url'] = site_url('admin/photo/list_photo/');
		$config['total_rows'] = $this->db->count_all_results('photo');
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
		$data['photo'] = $this->photo->list_photo();
		$this->load->view('admin/list_photo.html',$data);
	}

	//添加照片
	public function add_photo(){
		$this->load->view('admin/add_photo.html');
	}

	//添加动作
	public function add(){
		//载入上传类
		$status = $this->upload->do_upload('photo');
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
		$pic['width'] = 500;
		$pic['height'] = 500;

		//载入缩略图类
		$this->load->library('image_lib',$pic);

		//执行动作
		$img = $this->image_lib->resize();
		if(!$img){
			e('缩略图操作失败');
		}

		//获取表单信息
		$data['photo_url'] = $info['file_name'];
		$data['photo_explain'] = $this->input->post('content');
		$result = $this->photo->add_photo($data);
		if($result){
			s('admin/photo/list_photo','添加照片成功');
		}
		else{
			e("添加失败");
		}
	}

	//删除照片
	public function del(){
		// file_exists() 函数检查文件或目录是否存在。
		// 如果指定的文件或目录存在则返回 true，否则返回 false。
		 $id=$this->uri->segment(4);
	 	 $status= $this->photo->check_photo($id);
	 	 $this->photo->del($id);
	 	 //var_dump($status);die;
	 	 $myfile = 'public/uploads/'.$status[0]['photo_url'];
	 	  //var_dump($myfile);die;
		  if (file_exists($myfile)) {
		    $result=unlink($myfile);
		    if($result)
		    	s('admin/photo/list_photo','删除成功');
		    else
		    	e('删除失败');
		  }else{
		  	e('图片不存在！');
		  }
	 	 	
	 }

	 //编辑照片
	 public function edit_photo(){
		 $id=$this->uri->segment(4);
		 $data['photo']= $this->photo->check_photo($id);
		 $this->load->helper('form');
		 $this->load->view('admin/edit_photo.html',$data);
	 }

	 /*
	 *编辑动作
	 */
	 public function edit(){
		$status = $this->upload->do_upload('photo');
		//修改图片
		if($status){
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
			$pic['width'] = 500;
			$pic['height'] = 500;

			//载入缩略图类
			$this->load->library('image_lib',$pic);

			//执行动作
			$img = $this->image_lib->resize();
			if(!$img){
				e('缩略图操作失败');
			}

			//获取表单信息
			$data['photo_url'] = $info['file_name'];
			$id = $this->input->post('id');
			$data['photo_explain'] = $this->input->post('photo_explain');
			$result = $this->photo->update_photo($id,$data);
			if($result){
				s('admin/photo/list_photo','添加修改成功');
			}
			else{
				e("修改失败");
			}
				
		}else{
			//没有修改图片
			$id=$this->input->post('id');
			$photo_explain=$this->input->post('photo_explain');
			$data=array('photo_explain'=>$photo_explain);
			if($data['photo']=$this->photo->update_photo($id,$data)){
				s('admin/photo/list_photo','修改成功');
			}else{
				$this->load->helper('form');
				$this->load->view('admin/edit_photo.html');
			}
		 }
	}
}