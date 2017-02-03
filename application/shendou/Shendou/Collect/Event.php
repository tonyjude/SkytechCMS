<?php
class Shendou_Collect_Event
{
	/** 
	 * @var int
	 */
	protected $mCurrTypeid;
	
	protected $db;
	
	public function __construct()
	{
		$this->db = Lamb_App::getGlobalApp()->getDb();
	}
	
	/*
	 * 资源写入数据库
	 * @param array $data
	 * return bollean 
	 */
	public function writeToDb(array $data)
	{
		$purchase = new Lamb_Db_Table('skytech_purchase',  Lamb_Db_Table::INSERT_MODE);
		
		unset($data['id']);	
		return $purchase->set($data)->execute();
	}
	
	/**
	 * 资源写入客户的数据库
	 */
	public function writeToCustmerDb($db, array $data)
	{
		$purchase = new Lamb_Db_Table('skytech_purchase',  Lamb_Db_Table::INSERT_MODE);
		
		unset($data['id']);	
		
		return $purchase->set($data)->setOrGetDb($db)->execute();
	}
			
}
