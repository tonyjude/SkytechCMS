<?php
class Shendou_Model_Custmer extends Shendou_Model 
{
	const E_FALL = 0;
	
	public function __construct()
    {   
        parent::__construct();
	}
		
	/**
	 * @param array $data
	 * @return int
	 */
	public function add($data)
	{
		$table = new Lamb_Db_Table('skytech_member_info', Lamb_Db_Table::INSERT_MODE);
		
		$db = $this->mApp->getDb();
		$sql = $table->set($data)->getInsertSql();
		$db->query($sql);
		
		return $db->lastInsertId();
	}
	
	/**
	 * @param array $data
	 * @param string $val
	 * @return int
	 */
	public function update($id, array $data)
	{
		unset($data['id']);
		if(!($ret = $this->get($id))){
			return self::E_FALL;
		}
		
		$table = new Lamb_Db_Table('skytech_member_info');
		return $table->setOrGetWhere('id=' . $ret['id'])
			  		 ->set($data)
			  		 ->execute();
	}
	
	
	public function get($id)
	{
		if (Lamb_Utils::isInt($id, true)) {
			$sql = 'select * from skytech_member_info where id = :id';
			$aPrepareSource = array(
				':id' => array($id, PDO::PARAM_INT)
			);
		} else {
			$sql = 'select * from skytech_member_info where name = :name';
			$aPrepareSource = array(
				':name' => array($id, PDO::PARAM_STR)
			);
		}
				
		$ret = $this->mApp->getDb()->getNumDataPrepare($sql, $aPrepareSource, true);
		
		if ($ret['num'] != 1) {
			return null;
		}
		
		return $ret['data'];
	}
	
	/**
	 * @param string $val
	 * @return boolean
	 */
	public function delete($id)
	{
		$sql = 'delete skytech_member_info where uid = :id';
		return $this->mApp->getDb()->quickPrepare($sql, array(':id' => array($id, PDO::PARAM_INT)), true);
	}
	
	
}