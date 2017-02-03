<?php
class custmerControllor extends Shendou_Controllor_ManageAbstract
{
	private $cust = null;
	public function __construct()
	{
		parent::__construct();
		$this->cust = new Shendou_Model_Custmer();
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
			//$this->getPurview();
		}
	}
	
	public function getControllorName()
	{
		return 'custmer';
	}
	
	public function indexAction()
	{
		$q = trim($this->mRequest->q);
		$page = trim($this->mRequest->p);
		$page = Lamb_Utils::isInt($page, true) ? $page : 1;
		
		$data = $this->getCurrentUserInfo();
		if (!$data) {
			$this->mResponse->redirect($this->mRouter->urlEx('index', 'login'));
		}
		
		if ($data['user_name'] == 'skytech' && $data['user_role'] == 1) {
					
			$sql = 'select a.*, b.in_name from skytech_member_info as a, skytech_industry as b where a.industry_id = b.id';
			
			$prevPageUrl  = $this->mRouter->urlEx('custmer', '', array('p' =>  $page-1, 'q' => $q));
			$nextPageUrl  = $this->mRouter->urlEx('custmer', '', array('p' => $page+1, 'q' => $q));

			$pageUrl = $this->mRouter->urlEx('custmer', '', array('q' => $q));
				
			include $this->load('custmer_list');
			return;
		}
		
		$info = $this->db->query("select a.*, b.in_name from skytech_member_info as a, skytech_industry as b where a.industry_id = b.id and uid={$data['id']}")->toArray();
		
		$industry = $this->db->query('select * from skytech_industry')->toArray();
		
		if (!empty($info)) {
			$info = $info[0];
		}
		
		include $this->load('custmer_info');	
	}
	
	
	/**
	 * 客户网站信息详情
	 */
	public function infoAction()
	{
		$id = trim($this->mRequest->id);
		
		if (!Lamb_Utils::isInt($id, true)) {
			include $this->load('error');
			return;
		}
		
		$info = $this->cust->get($id);
		$industry = $this->db->query('select * from skytech_industry')->toArray();
		if (empty($info)) {
			include $this->load('error');
			return;
		}

		include $this->autoload();
	}
	
	public function configAction()
	{
		$webInfo = $this->mSiteCfg['webInfo'];
		
		if ($this->mRequest->isPost()) {
			$webInfo = $this->mRequest->getPost();
			
			$webInfo['webInfo']['banner'] = explode("\n", $webInfo['webInfo']['banner']);
			$webInfo = "<?php\nreturn " . var_export($webInfo, true) . ';';
			
			Lamb_IO_File::putContents(DATA_PATH . 'web.var.php', $webInfo);
			$this->showMsg(1, null, '保存成功');	
		} 

		include $this->autoload();
	}
	
	public function updateAction()
	{
		if ($this->mRequest->isPost()) {
			$data = $this->mRequest->getPost('data');
			$id = trim($this->mRequest->getPost('id'));
				
			if ($this->cust->update($id, $data)) {
				$this->showMsg(1, null, '修改成功');
			}
		}
		
		$this->showMsg(0);		
	}
	
}
		