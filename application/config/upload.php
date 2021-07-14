<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//配置
$config['upload_path'] = './public/uploads/';
$config['allowed_types'] = 'gif|png|jpg|jpeg';
$config['max_size'] = '10240';
$config['file_name'] = time().mt_rand(1000,9999);