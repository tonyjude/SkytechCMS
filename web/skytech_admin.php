<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set("date.timezone","PRC");
define('ADMIN_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('APP_PATH', ADMIN_ROOT . '../application/shendou/');
set_include_path(ADMIN_ROOT . '../library/'
	.PATH_SEPARATOR . APP_PATH
	.PATH_SEPARATOR . get_include_path());
require_once 'Lamb/Loader.php';
$loader = Lamb_Loader::getInstance();
$loader->registerNamespaces('Shendou');
//registry

$aCfg = require_once('config.inc.php');
$aCfg['manage_controllor_path'] .= PATH_SEPARATOR . $aCfg['controllor_path'];
Lamb_Registry::set(CONFIG, $aCfg);
								
Lamb_App::getInstance()->setControllorPath($aCfg['manage_controllor_path'])
						->setViewPath($aCfg['manage_view_path'])
						->setViewRuntimePath($aCfg['view_runtime_path'])
					    ->setDbCallback('getDb')
					    ->setErrorHandler(new Shendou_ErrorHandler)
					    ->setSqlHelper(new Lamb_Mysql_Sql_Helper)
					    ->run();
												
	

	/**
	 * 获取单例数据库对
	 */
	function getDb()
	{
		static $instances = null;
		
		if ($instances) {
			return $instances;
		}
		
		$cfg = Lamb_Registry::get(CONFIG);
		$cfg = $cfg['db_cfg'];

		try{
			$objInstance = new Lamb_Mysql_Db(
				$cfg['dsn'], $cfg['username'], $cfg['password'],
				array(
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_NAMED,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"
				)
			);
			$objInstance->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('Lamb_Db_RecordSet', array($objInstance)));
		}catch (Exception $e){
			//Lamb_Debuger::debug($e);
			die('Connect database error');
		}
		
		$instances = $objInstance;
		return $objInstance;	
	}
						
?>