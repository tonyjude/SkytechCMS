<?php
class logisticsControllor extends Shendou_Controllor_ManageAbstract
{
	private $board = null;
	public function __construct()
	{
		parent::__construct();
		$this->board = new Shendou_Model_Msgboard();
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
		}
	}
	
	public function getControllorName()
	{
		return 'logistics';
	}
	
	public function indexAction()
	{
				
	}
	
}
		