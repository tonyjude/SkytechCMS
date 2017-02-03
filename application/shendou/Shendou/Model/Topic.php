<?php
class Shendou_Model_Topic extends Shendou_Model
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
		$data['topic_postdate'] = date('Y-m-d');
		$table = new Lamb_Db_Table('skytech_topic', Lamb_Db_Table::INSERT_MODE);
		
		$db = $this->mApp->getDb();
		$sql = $table->set($data)->getInsertSql();
		$db->query($sql);
		
		return $db->lastInsertId();
	}
	
	public function get($id)
	{
		if (Lamb_Utils::isInt($id, true)) {
			$sql = 'select * from skytech_topic where id = :id';
			$aPrepareSource = array(
				':id' => array($id, PDO::PARAM_INT)
			);
		} else {
			$sql = 'select * from skytech_topic where topic_name = :topic_name';
			$aPrepareSource = array(
				':topic_name' => array($id, PDO::PARAM_STR)
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
		
		$table = new Lamb_Db_Table('skytech_topic');
		$sql = $table->setOrGetWhere('id=' . $ret['id'])->set($data)->getUpdateSql();
		return $this->mApp->getDb()->query($sql);		
	}
	
	/**
	 * @param 对于栏目的删除涉及到递归删除其所有子栏目等情况，考虑进度暂时不做处理
	 * @return boolean
	 */
	public function delete($id)
	{		
		$db = $this->mApp->getDb();
		$sql = 'update skytech_topic set topic_status = 0 where id = :id';
		
		return $db->quickPrepare($sql, array(':id' => array($id, PDO::PARAM_INT)), true);
	}
	
	
}