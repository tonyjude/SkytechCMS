<?php
class Shendou_Db
{
	/**
	 * 获取不同类型的单例数据库对象
	 */
	public static function get($type)
	{
		static $instances = array();
		
		if (isset($instances[$type])) {
			return $instances[$type];
		}
		
		$cfg = Lamb_Registry::get(CONFIG);
		
		$cfg = $cfg['web_db_cfg'][$type];
		
		try{
			$objInstance = new Lamb_Mysql_Db(
				$cfg['dsn'], $cfg['username'], $cfg['password'],
				array(
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NAMED,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8mb4';"
				)
			);
			$objInstance->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('Lamb_Db_RecordSet', array($objInstance)));
		}catch (Exception $e){
			die('Connect database error');
		}
		
		$instances[$type] = $objInstance;
		return $objInstance;	
	}
}