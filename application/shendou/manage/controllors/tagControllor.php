<?php
class tagControllor extends Shendou_Controllor_ManageAbstract
{
	public function __construct()
	{
		parent::__construct();
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
			$this->getPurview();
		}
	}
	
	public function getControllorName()
	{
		return 'tag';
	}
	
	public function indexAction()
	{
		$page = trim($this->mRequest->p);
		$q = trim($this->mRequest->q);
		$keywords = trim($this->mRequest->keywords);
	
		if (!Lamb_Utils::isInt($page, true) || $page == 0) {
			$page = 1;
		}
		
		$sql = 'select * from sky_tag where 1=1 ';
		
		$aPrepareSource = array();
			
		$prevPageUrl  = $this->mRouter->urlEx($this->C, '', array('p' =>  $page-1, 'q' => $q, 'keywords' => $keywords));
		$nextPageUrl  = $this->mRouter->urlEx($this->C, '', array('p' => $page+1, 'q' => $q, 'keywords' => $keywords));

		$pageUrl = $this->mRouter->urlEx($this->C, '', array('q' => $q, 'keywords' => $keywords));
		
		include $this->autoload();	
		
	}
	
}	
?>