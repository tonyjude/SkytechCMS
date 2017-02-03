<?php
class testControllor extends Shendou_Controllor_FrontAbstract
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getControllorName()
	{
		return 'test';
	}
	
	public function indexAction()
	{
		$nav  = $this->category->getAll();
		$flag = trim($this->mRequest->f);
		$flag = $flag ? $flag : 0;
		
		include $this->load('index_index');
	}
	
	public function contactAction()
	{
		include $this->load('index_index');
	}
	
	public function testAction()
	{
		//echo strstr('/rubber-hose/list_1.html', 'list_12.html');
		echo preg_replace('/list_1/', 'index', '/rubber-hose/list_1.html');
	}
		
}