<?php if(!defined('BASEPATH')) exit('非法访问');
$config = array(
	'article' => array(
		array(
			'field'=>'title',
			'lable'=>'标题',
			'rules'=>'required|min_length[5]'
		),
		array(
			'field'=>'author',
			'lable'=>'作者',
			'rules'=>'required|min_length[2]'
		),
		array(
			'field'=>'radioSet',
			'lable'=>'权限',
			'rules'=>'required|integer'
		),
		array(
			'field'=>'mySelect',
			'lable'=>'栏目',
			'rules'=>'required|integer'
		),
		array(
			'field'=>'content',
			'lable'=>'内容',
			'rules'=>'required|max_length[2000]'
		),
	),
	'cate'=>array(
		array(
			'field'=>'cname',
			'lable'=>'栏目名称',
			'rules'=>'required|max_length[20]'
		),
	),
);