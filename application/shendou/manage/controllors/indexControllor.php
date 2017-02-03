<?php
class indexControllor extends Shendou_Controllor_ManageAbstract
{
	private $user = null;
	public function __construct()
	{
		parent::__construct();	
		$this->user = new Shendou_Model_User();
		if (!in_array($this->A, array('login', 'loginout', 'code', 'install'))) {
			$this->checkPurview();
		}
	}
	
	public function getControllorName()
	{
		return 'index';
	}
	
	public function loginAction()
	{
		if ($this->mRequest->isPost()) {
			
			$username = trim($this->mRequest->getPost('username', ''));
			$password = trim($this->mRequest->getPost('password', ''));
			$safecode = trim($this->mRequest->getPost('safeCode', ''));

			if (empty($safecode) || strtolower($safecode) != strtolower($_SESSION['randval'])) {
				$this->showMsg(0, null, '验证码错误');
			}
			
			if ($username == '' || $password == '') {
				$this->showMsg(0, null, '帐号或密码不能为空');
			}
			
			if (!$this->isAccountCanLogin($username, md5($password))) {
				$this->showMsg(-1, null, '帐号或密码错误');
			}				
			
			$_SESSION[$this->mSessionKeyUsername] = $username;
			$_SESSION[$this->mSessionKeyPassword] = md5($password);
			
			$url = $this->mRouter->urlEx('index', 'index');
			
			$this->showMsg(1, array('url' => $url));
		}

		include $this->load('login');
	}
	
	public function registerAction()
	{
		if ($this->mRequest->isPost()) {

			$username = trim($this->mRequest->getPost('username', ''));
			$email = trim($this->mRequest->getPost('email', ''));
			$password = trim($this->mRequest->getPost('password', ''));
			$repassword = trim($this->mRequest->getPost('repassword', ''));
			$code = trim($this->mRequest->getPost('code', ''));
			
			if ($username == '' || $password == '') {
				$this->showMsg(0, null, '帐号或密码不能为空！');
			}
			
			if ($email == '') {
				$this->showMsg(0, null, '邮箱不能为空！');
			}
			
			if ($code == '') {
				$this->showMsg(0, null, '邀请码不能为空！');
			}
			
			if ($password == '') {
				$this->showMsg(0, null, '密码不能为空！');
			}
			
			if ($repassword == '') {
				$this->showMsg(0, null, '确认密码不能为空！');
			}
			
			if ($repassword != $password) {
				$this->showMsg(0, null, '确认密码不一致！');
			}
			
			if ($this->user->get($username)) {
				$this->showMsg(0, null, '用户名已存在！');
			}
			
			if (!$this->user->checkRequestCode($code)) {
				$this->showMsg(0, null, '邀请码有误！');
			}
			
			$data = array(
				'user_name' => $username,
				'user_password' => md5($password), 
				'user_email' => $email,
				'user_role' => 2,
				'rigister_time' => date('Y-m-d H:i:s')
			);
 
			if ($this->user->add($data)) {
				$url = $this->mRouter->urlEx('index', 'login');
				$this->showMsg(1, array('url' => $url), '注册成功！');
			}			
		}
		
		include $this->load('register');
	}
	
	public function indexAction()
	{
		$sql = 'select * from skytech_article order by id desc limit 5';
		$db = $this->mApp->getDb();
		$alist = $db->query($sql)->toArray();
		$aNum  = $db->query('select count(id) as num from skytech_article where art_status=1')->toArray();
		$tNum  = $db->query('select count(id) as num from skytech_topic where topic_status=1')->toArray();
		
		include $this->load('index');
	}
	
	public function installAction()
	{
		$step = trim($this->mRequest->step);
		$phpv = phpversion();
	    $sp_os = PHP_OS;		
		$cwd = getcwd();															
	    $sp_server = $_SERVER['SERVER_SOFTWARE'];
	    $sp_name = $_SERVER['SERVER_NAME'];
	    $sp_max_execution_time = ini_get('max_execution_time');
		
	    $sp_mysql = (function_exists('mysql_connect') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
		$info = gd_info();
		if (empty($info)) {
			$sp_gd = '<font color=red>[×]Off</font>';
		}else{
			$sp_gd = '<font color=green>[√]On</font>';
		}
		
		$cfg = $this->mSiteCfg['db_cfg'];
		
		if (!$step || $step <1 || $step > 3) {
			$step = 1;
		}
		
		if ($step == 2) {
			
			$db = $this->mApp->getDb();
			$tables = $db->query("show tables")->toArray();
			
			if (empty($tables)) {
				$path = APP_PATH . 'data/skytech.sql'; 
				$create = new Shendou_Model_Createtable();
				$flag = $create->createFromFile($path);
				if ($flag) {
					$tables = $db->query("show tables")->toArray();
				}
			} 
					
		}
		
		$wizard = array(
			1 => 'wizard1',
			2 => 'wizard2',
			3 => 'wizard3'
		); 
			
		include $this->load($wizard[$step]);
	}
	
	public function loginoutAction()
	{
		unset($_SESSION[$this->mSessionKeyUsername], $_SESSION[$this->mSessionKeyPassword]);
		$this->showMsg(1);
	}

	public function errorAction()
	{
		include $this->load('error');
	}

}