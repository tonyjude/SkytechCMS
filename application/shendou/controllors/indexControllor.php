<?php
class indexControllor extends Shendou_Controllor_FrontAbstract
{
	protected $mDefaultPagesize;
	
	public function __construct()
	{
		parent::__construct();
		$this->mDefaultPagesize = $this->mSiteCfg['webInfo']['static']['pagesize'];
	}
	
	public function getControllorName()
	{
		return 'index';
	}
	
	public function tipsAction()
	{
		include $this->load('tips');
	}
	
	public function indexAction()
	{
		$info = $this->mSiteCfg['webInfo'];
		
		$title = $info['site']['web_title'];
		$keywords = $info['site']['web_keywords'];
		$description = $info['site']['description'];
		
		include $this->load('index');
	}
	
	public function searchAction()
	{
		$page = trim($this->mRequest->p);
		$keywords = trim($this->mRequest->k);
		$pagesize = $this->mDefaultPagesize;
		
		$info  = $this->mSiteCfg['webInfo'];
		$title = $info['site']['web_title'];
		$description = $info['site']['description'];
		
		if (!$page) {
			$page = 1;
		}
		
		if ($keywords == '') {
			return ;	
		}
			
		$sql = "select * from skytech_article where art_title like '%{$keywords}%' order by id desc ";
		
		$prevPageUrl  = '/index.php?s=index/search/k/' . $keywords . '/p/' . '#prevPage#';
		$nextPageUrl  = '/index.php?s=index/search/k/' . $keywords . '/p/' . '#nextPage#';
		$pageUrl = '/index.php?s=index/search/k/' . $keywords . '/p/' . '#page#';
		
		include $this->load('search');	
		
	}
	
	public function codeAction()
	{
		$c_check_code_image = new Shendou_CodeFile();
		$c_check_code_image ->OutCheckImage();	
	}
}