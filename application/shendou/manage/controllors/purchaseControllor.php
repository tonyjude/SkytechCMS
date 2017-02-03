<?php
class purchaseControllor extends Shendou_Controllor_ManageAbstract
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
		return 'purchase';
	}
	
	public function indexAction()
	{
		$q = trim($this->mRequest->q);
		$q = $q ? $q : 0;
		$keywords = trim($this->mRequest->keywords);
		$page = trim($this->mRequest->p);
		if (!Lamb_Utils::isInt($page, true) || !$page) {
			$page = 1;
		}
		
		$custmers = $this->getCustmers();
		
		$info = $this->getCurrentUserInfo();
		if (!$info) {
			$this->mResponse->redirect($this->mRouter->urlEx('index', 'login'));
		}
		
		if ($info['user_name'] == 'skytech' && $info['user_role'] == 1) {
			$sql = "select pur.*, info.name from skytech_purchase as pur INNER JOIN skytech_member_info as info where pur.purchase_for_id = info.uid";
		} else {
			$sql = "select pur.*, info.name from skytech_purchase as pur INNER JOIN skytech_member_info as info where pur.purchase_for_id = info.uid and purchase_for_id={$info['id']}";
		}
		
		$aPrepareSource = array();
		if ($q > 0 && $keywords == '') {
			$sql .= ' and purchase_for_id = :purchase_for_id';
			$aPrepareSource[':purchase_for_id'] = array($q, PDO::PARAM_INT);
		} else if ($q > 0 && $keywords != '') {
			$sql .= ' and purchase_for_id = :purchase_for_id and purchase_name like :purchase_name';
			$aPrepareSource[':purchase_for_id'] = array($q, PDO::PARAM_INT);
			$aPrepareSource[':purchase_name'] = array('%' . $keywords . '%', PDO::PARAM_STR);
		} else if ($keywords != '') {
			$sql .= ' and purchase_name like :purchase_name';
			$aPrepareSource[':purchase_name'] = array('%' . $keywords . '%', PDO::PARAM_STR);
		}

		
		$prevPageUrl  = $this->mRouter->urlEx('purchase', '', array('p' =>  $page-1, 'q' => $q, 'keywords' => $keywords));
		$nextPageUrl  = $this->mRouter->urlEx('purchase', '', array('p' => $page+1, 'q' => $q, 'keywords' => $keywords));

		$pageUrl = $this->mRouter->urlEx('purchase', '', array('q' => $q, 'keywords' => $keywords));
		
		
		include $this->autoload();			
	}
	
	public function getChannelImg($id)
	{
		if ($id == 0) {
			return 'http://sourcing.made-in-china.com/favicon.ico';
		} else if ($id == 1) {
			return 'https://sourcing.alibaba.com/favicon.ico';
		}
	}
	
	public function getCustmers($id = null)
	{
		if ($id) {
			return $this->db->query('SELECT * FROM skytech_member_info where uid=' . $id)->toArray();
		}
		
		return $this->db->query('SELECT uid,name FROM skytech_member_info')->toArray();
	}
	
}
		