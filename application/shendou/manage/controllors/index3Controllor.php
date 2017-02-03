<?php
class indexControllor extends Shendou_Controllor_ManageAbstract
{
	private $user = null;
	public function __construct()
	{
		parent::__construct();
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
		}
		$this->user = new Shendou_Model_User();
		
	}
	
	public function getControllorName()
	{
		return 'index';
	}
	
	public function testAction()
	{
		
		$user = new Shendou_Model_User();
		$info = $user->get('test');
		
		$data = null;
		if (isset($info['purview'])) {
			try{
				$data = json_decode($info['purview'], true);
				
			}catch(Exception $e) {}
		}
		
		print_r($data);
	}
	
	public function indexAction()
	{
		include $this->load('index');
	}
	
	public function loginAction()
	{
		if ($this->mRequest->isPost()) {
			
			$username = trim($this->mRequest->getPost('user_login', ''));
			$password = trim($this->mRequest->getPost('user_pass', ''));
			
			if (empty($username) || empty($password)) {
				$this->showMsg(0, null, '帐号或密码不能为空');
			}
			
			if (!$this->isAccountCanLogin($username, md5($password))) {
				$this->showMsg(-1, null, '帐号或密码错误');
			}				
			
			$_SESSION[$this->mSessionKeyUsername] = $username;
			$_SESSION[$this->mSessionKeyPassword] = md5($password);
			
			$url = $this->mRouter->urlEx('article', 'index');
			
			$this->showMsg(1, array('url' => $url));
		}
		
		$this->showMsg(0);
	}
	
	
	public function loginoutAction()
	{
		unset($_SESSION[$this->mSessionKeyUsername], $_SESSION[$this->mSessionKeyPassword]);
		
		$this->mResponse->redirect($this->mRouter->urlEx('index', 'index'));	
	}

}

?>