<?php
class taskControllor extends Shendou_Controllor_ManageAbstract
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getControllorName()
	{
		return 'task';
	}
	
	
	/**
	 * 邀请码生成
	 */
	public function indexAction()
	{
		$code = array();
		for ($i = 0, $j = 50; $i < $j; $i++) {
			$code[] = Shendou_Utils::createSalt();
		}
		
		foreach ($code as $item) {
			$this->db->query("insert into skytech_request (code) values ('$item')");
		}
			
	}

}