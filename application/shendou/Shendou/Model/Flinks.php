<?php
class Shendou_Model_Flinks extends Shendou_Model 
{
	
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
		unset($data['id']);
		$table = new Lamb_Db_Table('skytech_flinks', Lamb_Db_Table::INSERT_MODE);

		return $table->set($data)->execute();
		
	}
	
	public function get($id, $fields = '*')
	{
		if (Lamb_Utils::isInt($id, true)) {
			$sql = "select {$fields} from skytech_flinks where id = :id";
			$aPrepareSource = array(
				':id' => array($id, PDO::PARAM_INT)
			);
		} 
				
		$ret = $this->mApp->getDb()->getNumDataPrepare($sql, $aPrepareSource, true);
		
		if ($ret['num'] != 1) {
			return null;
		}
		
		return $ret['data'];
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
			return 0;
		}
		
		$table = new Lamb_Db_Table('skytech_flinks');
		return $table->setOrGetWhere('id=' . $ret['id'])
			  		 ->set($data)
					 ->execute();  		
	}
	
	/**
	 * @param 对于栏目的删除涉及到递归删除其所有子栏目等情况，考虑进度暂时不做处理
	 * @return boolean
	 */
	public function delete($id)
	{		
		$db = $this->mApp->getDb();
		$sql = 'delete from skytech_flinks where id = :id';
		$db->quickPrepare($sql, array(':id' => array($id, PDO::PARAM_INT)), true);
		
		return true;
	}
	
}