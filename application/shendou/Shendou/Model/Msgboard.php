<?php
class Shendou_Model_Msgboard extends Shendou_Model 
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
		$data['msg_date'] = date('Y-m-d H:i:s');
		$data['msg_name'] = isset($data['msg_name']) ? htmlspecialchars($data['msg_name']) : '';
		$data['msg_company'] = isset($data['msg_company']) ? htmlspecialchars($data['msg_company']) : '';
		$data['msg_product'] = isset($data['msg_product']) ? htmlspecialchars($data['msg_product']) : '';
		$data['msg_fax'] = isset($data['msg_fax']) ? htmlspecialchars($data['msg_fax']) : '';
		$data['msg_phone'] = isset($data['msg_phone']) ? htmlspecialchars($data['msg_phone']) : '';
		$data['msg_country'] = isset($data['msg_country']) ? htmlspecialchars($data['msg_country']) : '';
		$data['msg_city'] = isset($data['msg_city']) ? htmlspecialchars($data['msg_city']) : '';
		$data['msg_address'] = isset($data['msg_address']) ? htmlspecialchars($data['msg_address']) : '';
		$data['msg_comments'] = isset($data['msg_comments']) ? addslashes(htmlspecialchars($data['msg_comments'])) : '';
	
		$table = new Lamb_Db_Table('skytech_msgboard', Lamb_Db_Table::INSERT_MODE);
				
		//$sql = $table->set($data)->getInsertSql();
		//Lamb_Debuger::debug($sql);
		//return $this->mApp->getDb()->query($sql);
		return $table->set($data)->execute();
	}
	
	public function update($id, array $data)
	{
		unset($data['id']);
		if(!($ret = $this->get($id))){
			return self::E_FALL;
		}
		
		$table = new Lamb_Db_Table('skytech_msgboard');
		return $table->setOrGetWhere('id=' . $ret['id'])
			  		 ->set($data)
			  		 ->execute();
					 
	}
	
	public function get($id)
	{
		if (Lamb_Utils::isInt($id, true)) {
			$sql = 'select * from skytech_msgboard where id = :id';
			$aPrepareSource = array(
				':id' => array($id, PDO::PARAM_INT)
			);
		} else {
			$sql = 'select * from skytech_msgboard where msg_name = :msg_name';
			$aPrepareSource = array(
				':msg_name' => array($id, PDO::PARAM_STR)
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
		$sql = 'update skytech_msgboard set msg_status = 0 where id = :id';
		return $this->mApp->getDb()->quickPrepare($sql, array(':id' => array($id, PDO::PARAM_INT)), true);
	}
	
	
}