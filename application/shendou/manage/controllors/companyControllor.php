<?php
class companyControllor extends Shendou_Controllor_ManageAbstract
{
	private $company = null;
	private $flinks  = null;
	public function __construct()
	{
		parent::__construct();
		$this->company = new Shendou_Model_Company();
		$this->flinks  = new Shendou_Model_Flinks();
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
			$this->getPurview();
		}
	}
	
	public function getControllorName()
	{
		return 'company';
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
		
		/*
		if ($data['user_name'] == 'skytech' && $data['user_role'] == 1) {
				
			$sql = 'select * from skytech_company';
			
			$prevPageUrl  = $this->mRouter->urlEx('company', '', array('p' =>  $page-1, 'q' => $q));
			$nextPageUrl  = $this->mRouter->urlEx('company', '', array('p' => $page+1, 'q' => $q));

			$pageUrl = $this->mRouter->urlEx('company', '', array('q' => $q));
				
			include $this->load('company_list');
			return;
		}
		
		$info = $this->db->query("select * from skytech_company where uid={$data['id']}")->toArray();
		*/
		
		$info = $this->db->query("select * from skytech_company")->toArray();
		
		if (!empty($info)) {
			$info = $info[0];
		}
		
		include $this->load('company_info');
	}
	
	/**
	 * 企业信息详情
	 */
	public function infoAction()
	{
		$id = trim($this->mRequest->id);
		
		if (!Lamb_Utils::isInt($id, true)) {
			include $this->load('error');
			return;
		}
		
		$info = $this->company->get($id);
		
		$this->d($info);
		if (empty($info)) {
			include $this->load('error');
			return;
		}
	
		include $this->autoload();
	}
	
	public function flinksAction()
	{
		$page = trim($this->mRequest->p);
		
		if (!Lamb_Utils::isInt($page, true) || $page == 0) {
			$page = 1;
		}
		
		$aPrepareSource = array();
		
		$sql = 'SELECT * from skytech_flinks order by id desc';
			
		$prevPageUrl  = $this->mRouter->urlEx($this->C, 'flinks', array('p' => $page-1));
		$nextPageUrl  = $this->mRouter->urlEx($this->C, 'flinks', array('p' => $page+1));

		$pageUrl = $this->mRouter->urlEx($this->C, 'flinks');

		
		include $this->autoload();
	}
	
	public function addOrUpdateFlinksAction()
	{
		$fid = trim($this->mRequest->fid);
		
		if ($fid) {
			$info = $this->flinks->get($fid);
		}
		
		if ($this->mRequest->isPost()) {
			
			$data = $this->mRequest->getPost('data');
			
			if (trim($data['flink_name']) == '') {
				$this->showMsg(0, null, '标题不能为空！');
			} 
			
			if (trim($data['flink_site']) == '') {
				$this->showMsg(0, null, 'url不能为空！');
			} 

			$id = trim($this->mRequest->getPost('id'));
			
			if ($id) {
				if ($this->flinks->update($id, $data)) {
					$this->showMsg(1, null, '修改成功！');
				}
				
				$this->showMsg(0, null, '修改失败，请联系系统管理员！');
			}
			
			$id = $this->flinks->add($data);				
			if ($id) {
				$this->showMsg(1, null, '添加成功！');
			} 
			
			$this->showMsg(0, null, '添加失败，请联系系统管理员！');			
		}
		
		include $this->load('add_or_update_flinks');
	}
	
	public function deleteFlinksAction()
	{
		$id = trim($this->mRequest->id);
		
		if (!Lamb_Utils::isInt($id, true)) {
			$this->showResults(0);
		}

		if ($this->flinks->delete($id)) {
			$this->showResults(1);
		}
		
		$this->showResults(0);
	}
	
	public function updateAction()
	{
		if ($this->mRequest->isPost()) {
			$data = $this->mRequest->getPost('data');
			
			

			$id = trim($this->mRequest->getPost('id'));
			
			if ($this->company->update($id, $data)) {
				$this->showMsg(1, null, '保存成功！');
			}
		}
		
		$this->showMsg(0, null, '保存失败！');		
	}
	
}