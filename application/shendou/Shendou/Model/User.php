<?php
class Shendou_Model_User extends Shendou_Model 
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
		unset($data['id']);
		$table = new Lamb_Db_Table('skytech_user', Lamb_Db_Table::INSERT_MODE);
		$db = $this->mApp->getDb();
		
		$sql = $table->set($data)->getInsertSql();
		$db->query($sql);
		$id = $db->lastInsertId();
		
		if ($id) {
			$db->query("insert into skytech_member_info (uid, name) values ({$id}, '{$data['user_name']}') ");
			$db->query("insert into skytech_company (uid) values ({$id})");
		}
		
		return $id;	 
	}
	
	public function checkRequestCode($code)
	{
		$sql = 'select id from skytech_request where code = :code and status = 1';
		$ret = $this->mApp->getDb()->getNumDataPrepare($sql, array(
			':code' => array($code, PDO::PARAM_STR)
		), true);
		
		if ($ret['num'] != 1) {
			return false;
		}
		
		$id = $ret['data']['id']; //修改邀请码为使用过了
		$this->mApp->getDb()->query("update skytech_request set status=0 where id=$id");
		
		return true;
	}
	
	public function get($id)
	{
		if (Lamb_Utils::isInt($id, true)) {
			$sql = 'select * from skytech_user where id = :id';
			$aPrepareSource = array(
				':id' => array($id, PDO::PARAM_INT)
			);
		} else {
			$sql = 'select * from skytech_user where user_name = :user_name';
			$aPrepareSource = array(
				':user_name' => array($id, PDO::PARAM_STR)
			);
		}
				
		$ret = $this->mApp->getDb()->getNumDataPrepare($sql, $aPrepareSource, true);
		
		if ($ret['num'] != 1) {
			return null;
		}
		
		return $ret['data'];
	}
	
	
	
	public function isCanLogin($username, $password)
	{
		$sql = 'select * from skytech_user where user_name = :user_name and user_password = :user_password and status=1';
		$aPrepareSource = array(
			':user_name' => array($username, PDO::PARAM_STR),
			':user_password' => array($password, PDO::PARAM_STR)
		);
				
		$ret = $this->mApp->getDb()->getNumDataPrepare($sql, $aPrepareSource, true);
				
		if ($ret['num'] == 0) {
			return false;
		}
		
		return true;
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
		$table = new Lamb_Db_Table('skytech_user');
		return $table->setOrGetWhere('id=' . $ret['id'])
			  		 ->set($data)
			  		 ->execute();
	}
	
	/**
	 * @param string $val
	 * @return boolean
	 */
	public function delete($id)
	{
		$sql = 'update skytech_user set status=0 where id = :id';
		return $this->mApp->getDb()->quickPrepare($sql, array(':id' => array($id, PDO::PARAM_INT)), true);
	}
	
	/**
	 * 修改用户组权限
	 */
	public function updatePurviews($id, $data) 
	{
		$sql = 'delete from skytech_relation where role_id = ' . $id;
	
		$db = $this->mApp->getDb();
		$db->exec($sql);
		/*if (!$flag) {
			return false;
		}*/
		if (!empty($data)) {
			foreach($data as $item) {
				$db->query("insert into skytech_relation (role_id, menu_id) values ($id, $item)");
			}
		}
		
		return true;
	}
	
}