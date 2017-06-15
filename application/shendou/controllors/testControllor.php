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
		set_time_limit(0);
		$page = trim($this->mRequest->p);
		$page = $page ? $page : 1;
		$pagesize = 1;
		$offset = ($page-1)*$pagesize;
		$sql = "select id,site from skytech_seotest limit $offset, $pagesize";
		$ret = $this->db->query($sql)->toArray();
		
		if (empty($ret)) {
			exit('over');
		}
		
		foreach ($ret as $item) {
			$data = file_get_contents($item['site']);
			if (!$data) {
				$this->log('网站： ' . $item['site'] . ' ID: ' . $item['id'] . '采集失败');
				continue;
			}
			
			$this->db->query("update skytech_seotest set data='{$data}' where id={$item['id']}");
		}

		$this->redirect('/?s=test/test/p/'  . ++$page);
	}
	
		
}