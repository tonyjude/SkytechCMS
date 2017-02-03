<?php
define('CONFIG', 'site_config');
define('DATA_PATH', APP_PATH . 'data/');
return array(
	'controllor_path' => APP_PATH . 'controllors/',
	'manage_controllor_path' => APP_PATH . 'manage/controllors/',
	'manage_view_path' => APP_PATH . 'manage/views/',
	'view_path' => APP_PATH . 'views/',
	'view_runtime_path' => DATA_PATH . '/~runtime/',
	'template' => 'default',
	
	'db_cfg' => array (
		'dsn' => 'mysql:host=127.0.0.1;dbname=skytech_test',
		'username' => 'root',
		'password' => 'root'
	),
	
	'admin' => array(
		'allow_ips' => array('192.168.*'),
		'username' => 'skytech',
		'password' => 'a048d83498fb39db6d03c0042c407c0a'
	),
	
	'router' => 
	  array (
		'domain' => '/',
		'url' => 
		array (
		  'delimiter' => '/',
		  'param_name' => 's',
		),
	 ),
	
	'dynamic_url' => array(
		'default_img' => '/assets/avatars/profile-pic.jpg',
		'loginout' => '/skytech_admin.php?s=index/loginout',
		'categories_batch_add' => '/skytech_admin.php?s=categories/batchAdd',
		'categories_add_or_update' => '/skytech_admin.php?s=categories/addOrUpdateCate',
		'categories_index' => '/skytech_admin.php?s=categories/',
		'categories_delete' =>'/skytech_admin.php?s=categories/delete',
		'upload' => '/skytech_admin.php?s=upload/upload',
		'article_add_or_update' => '/skytech_admin.php?s=article/addOrUpdate',
		'article_index' => '/skytech_admin.php?s=article/index',
		'topic_addOrUpdate' => '/skytech_admin.php?s=topic/addOrUpdate',
		'topic_index' => '/skytech_admin.php?s=topic/index',
		'flinks_index' => '/skytech_admin.php?s=company/flinks',
		'flinks_add_or_update' => '/skytech_admin.php?s=company/addOrUpdateFlinks'
	),
	
	//'languaji'
)  + require(DATA_PATH . 'config.var.php');