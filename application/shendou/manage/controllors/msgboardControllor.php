<?php
class msgboardControllor extends Shendou_Controllor_ManageAbstract
{
	private $board = null;
	public function __construct()
	{
		parent::__construct();
		$this->board = new Shendou_Model_Msgboard();
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
			$this->getPurview();
		}
	}
	
	public function getControllorName()
	{
		return 'msgboard';
	}
	
	/**
	 * 添加留言
	 */
	public function addAction()
	{
		if ($this->mRequest->isPost()) {
		
			$data['msg_name'] = trim($this->mRequest->getPost('msg_name'));	
			$data['msg_company'] = trim($this->mRequest->getPost('msg_company'));
			$data['msg_product'] = trim($this->mRequest->getPost('msg_product'));	
			$data['msg_email']  = trim($this->mRequest->getPost('msg_email'));	
			$data['msg_phone']  = trim($this->mRequest->getPost('msg_phone'));	
			$data['msg_country']  = trim($this->mRequest->getPost('msg_country'));	
			$data['msg_city']  = trim($this->mRequest->getPost('msg_city'));
			$data['msg_comments']  = trim($this->mRequest->getPost('msg_comments'));
			$data['msg_date'] = time();
			
			$this->board->add($data);						
		}
	}
	
	/**
	 * 留言板列表
	 */
	public function indexAction()
	{
		/**
		 * 根据用户的不同权限， 查看自己的数据
		 */
		$q = trim($this->mRequest->q);
		$page = trim($this->mRequest->p);
		$page = Lamb_Utils::isInt($page, true) ? $page : 1;
		$pagesize = 30;
		
		/*
		$info = $this->getCurrentUserInfo();
		if (!$info) {
			$this->mResponse->redirect($this->mRouter->urlEx('index', 'login'));
		}
		
		if ($info['user_name'] == 'skytech' && $info['user_role'] == 1) {
			$sql = "select msg.*, info.name from skytech_msgboard as msg INNER JOIN skytech_member_info as info where msg.msg_from_id = info.uid and msg_status=1";
		} else {
			$sql = "select msg.*, info.name from skytech_msgboard as msg INNER JOIN skytech_member_info as info where msg.msg_from_id = info.uid and msg_from_id={$info['id']} and msg_status=1";
		}
		*/
		
		$sql = "select * from skytech_msgboard where msg_status=1 order by id desc";
		
		$prevPageUrl  = $this->mRouter->urlEx('msgboard', '', array('p' =>  $page-1, 'q' => $q));
		$nextPageUrl  = $this->mRouter->urlEx('msgboard', '', array('p' => $page+1, 'q' => $q));

		$pageUrl = $this->mRouter->urlEx('msgboard', '', array('q' => $q));
		
		
		include $this->autoload();
	}
	
	/**
	 * 留言板详情
	 */
	public function infoAction()
	{
		$id = trim($this->mRequest->id);
		
		if (!Lamb_Utils::isInt($id, true)) {
			include $this->load('error');
			return;
		}
		
		$info = $this->board->get($id);
		if (!$info['msg_isread']) {
			$this->board->update($id, array('msg_isread' => 1));
		}
		if (empty($info)) {
			include $this->load('error');
			return;
		}
	
		include $this->autoload();
	}
	
	public function deleteAction()
	{
		$id = trim($this->mRequest->id);
		
		if (!Lamb_Utils::isInt($id, true)) {
			$ids = explode(',', $id);
			
			if (empty($ids)) {
				$this->showResults(0);
			} 
			
			unset($ids[count($ids)]);
			foreach($ids as $item) {
				if (!Lamb_Utils::isInt($item, true)) {
					continue;
				}	
				$this->board->delete($item);	
			}
		} else {
			$this->board->delete($id);
		}
		
		$this->showResults(1);
	}
	
	public function updateAction()
	{
		$id = trim($this->mRequest->id);
		$is_p = trim($this->mRequest->is_p);
		
		if (!Lamb_Utils::isInt($id, true)) {
			include $this->load('error');
			return;
		}

		$this->board->update($id, !$is_p);

		$this->mResponse->redirect($this->mRouter->urlEx($this->C, ''));
	}

}