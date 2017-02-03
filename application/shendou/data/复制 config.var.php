<?php
 return array (
  'site' => 
  array (
    'name' => '上海xx技术有限公',
    'host' => 'http://admin.test.com',
    'manager_root' => '',
    'root' => '',
    'img_host' => 'http://admin.test.com/',
    'keywords' => '',
    'description' => '',
    'mode' => '1', // 1动态 2静态
  ),
  'web_db_cfg' => array(
  	'web1' => array(
		'dsn' => 'mysql:host=127.0.0.1;dbname=test;',
		'username' => 'root',
		'password' => 'root@131420'
	)
  ),
  'upload' => 
  array (
    'maxSize' => 409600,
    'allowFiles' => 
    array (
      0 => '.doc',
      1 => '.png',
      2 => '.jpg',
      3 => '.jpeg',
      4 => '.gif',
    ),
    'img_path' => 'upload/',
  ),
  'static' => 
  array (
    'type' => '1',
    'extendtion' => 'html',
    'static_key' => '/keyword/',
    'pagesize' => 6,
    'save_path' => '../web/', 
    'template' => '../application/shendou/views/default',
  ),
  'router' => 
  array (
    'domain' => 'http://admin.test.com',
    'url' => 
    array (
      'delimiter' => '/',
      'param_name' => 's',
    ),
  ),
  
  'dynamic_url' => array(
    'default_img' => '/assets/avatars/profile-pic.jpg',
  	'loginout' => '/skytech_admin.php?s=index/loginout',
  	'categories_add_or_update' => '/skytech_admin.php?s=categories/addOrUpdateCate',
  	'categories_index' => '/skytech_admin.php?s=categories/',
  	'categories_delete' =>'/skytech_admin.php?s=categories/delete',
  	'upload' => '/skytech_admin.php?s=upload/upload',
  	'article_add_or_update' => '/skytech_admin.php?s=article/addOrUpdate',
  	'article_index' => '/skytech_admin.php?s=article/index',
  	'topic_addOrUpdate' => '/skytech_admin.php?s=topic/addOrUpdate',
  	'topic_index' => '/skytech_admin.php?s=topic/index',
  )
  
) + require(DATA_PATH . 'web.var.php');