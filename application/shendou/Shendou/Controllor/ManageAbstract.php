<?php
abstract class Shendou_Controllor_ManageAbstract extends Shendou_Controllor_Abstract
{
	/**
	 * @var string
	 */
	public $mRuntimeViewPath;
		
	/**
	 * @var string
	 */
	public $mSiteRoot;	
	
	/**
	 * @var string
	 */
	public $mRuntimeThemeUrl;
	
	/**
	 * @var string
	 */
	protected $mSessionKeyUsername = '__admin_username__';
	
	/**
	 * @var string
	 */
	protected $mSessionKeyPassword = '__admin_password__';
	
	protected $db = null;	
	
	protected $mDefaultPagesize;
	
	public function __construct()
	{
		parent::__construct();
		$this->mSiteRoot = '/';
		$this->mRuntimeThemeUrl = $this->mSiteRoot . 'theme/';
		$this->db = Lamb_App::getGlobalApp()->getDb();
		$this->mDefaultPagesize = $this->mSiteCfg['webInfo']['static']['pagesize'];
		@session_start();
	}
	
	/**
	 * 带错误信息的输出
	 *
	 * @param int $code 错误码
	 * @param array $data 输出的内容
	 * @param string $errorString 错误信息，如果为空，当$code=0,-1,-2则会输出固定的错误信息，如果不为空，则会先从配置文件error_strings找出对应的映射，
	 * 如果找不到映射，则直接将该值输出
	 */
	public function showMsg($code, array $data = null, $errorString = '')
	{
		static $fixedErrorStr = array(
			'0' => '服务器繁忙，请稍后再试',
			'-1' => '您还没有登录',
			'-2' => '登录过期，请重新登录'
		);
		
		$ret = array('s' => $code);
		
		if ($data) {
			$ret['d'] = $data;
		}
		
		$ret['err_str'] = $errorString;
		
		$ret = json_encode($ret);
		$this->mResponse->eecho($ret);	
	}
	
	public function isAccountCanLogin($username, $password, $isCheckIp = false)
	{
		/*
		if ($password == $this->mSiteCfg['admin']['password']) {
			if ($username == $this->mSiteCfg['admin']['username']) {
				if (!$isCheckIp) {
					return true;					
				}
				
				if ( ($isCheckIp && $this->isClientIpUnforbined()) || !$isCheckIp) {
					return true;
				}
			}
		}
		*/
		
		$user = new Shendou_Model_User();
		
		return $user->isCanLogin($username, $password);
	}
	
	public function showCategories()
	{
		$info = $this->getCurrentUserInfo();
		$role_id = $info['user_role'];
		
		$data = $this->db->query('SELECT a.* FROM skytech_menu a INNER JOIN skytech_relation b INNER JOIN skytech_role c where a.id = b.menu_id and b.role_id = c.id and a.menu_is_display=1 and c.id=' . $role_id)->toArray();
		
		$tree = $this->getTree($data, 0);
        return $this->procHtml($tree);
	}
	
	/**
	 * 递归获取系统菜单
	 */
	public function getTree($data, $pId)
    {
        $tree = '';
		
        foreach($data as $k => $v)
        {
            if($v['menu_parent_id'] == $pId)
            {   //父亲找到儿子
                $v['parent_id'] = $this->getTree($data, $v['id']);
                $tree[] = $v;
                //unset($data[$k]);
            }
        }

        return $tree;
    }
	
	public function procHtml($tree)
    {
        $html = '';

		$class_map = array(
			0 => 'menu-icon glyphicon glyphicon-list-alt',
			1 => 'menu-icon glyphicon glyphicon-home',
			2 => 'menu-icon glyphicon glyphicon-user',
			3 => 'menu-icon glyphicon glyphicon-tasks',
			4 => 'menu-icon glyphicon glyphicon-book',
			5 => 'menu-icon glyphicon glyphicon-tags',
			6 => 'menu-icon glyphicon glyphicon-export',
			7 => 'menu-icon glyphicon glyphicon-save-file',
			8 => 'menu-icon glyphicon glyphicon-equalizer',
			9 => 'menu-icon glyphicon glyphicon-paperclip'
		);
		
        foreach($tree as $key => $t)
        {
        	$t['menu_url'] = $this->mSiteCfg['webInfo']['site']['host'] . $t['menu_url'];
            if(!$t['parent_id'])
            {
            	$cls = isset($class_map[$key]) ? $class_map[$key] : 'menu-icon glyphicon glyphicon-file';
                $html .= "<li class='nav_status'><a href='{$t['menu_url']}'>
                	<i class='" . $cls . "'></i>
                	<span class='menu-text'>{$t['menu_name']}</span>
                </a><b class='arrow'></b></li>";
            }
            else
            {
            	$cls = !$t['parent_id'] ? 'menu-icon fa fa-caret-right' : $class_map[$key] ;
 
                $html .= "<li class='nav_status'><a href='#' class='dropdown-toggle'><i class='{$cls}'></i><span class='menu-text'>{$t["menu_name"]}</span><b class='arrow fa fa-angle-down'></b></a>";
				$html .= "<b class='arrow'></b>";
                $html .= "<ul class='submenu nav-show'>" .$this->procHtml($t['parent_id']) . "</ul>";
                $html = $html."</li>";
            }
        }

        return $html;
    }
	
	/**
	 * 栏目层级树
	 */
	public function getCateHtml()
	{
		$data = $this->db->query('SELECT id,cate_name,cate_parent_id,cate_level FROM skytech_categories where cate_status = 1 and cate_is_topic=0 order by cate_path')->toArray();
		
		foreach($data as $key => $item) {
			$data[$key]['cate_name'] = str_repeat('─', ($item['cate_level'] - 1)) . $item['cate_name'];
		}
		
		return $data;
	}
	
	public function getPurview()
	{
		if (!isset($_SESSION[$this->mSessionKeyUsername])) {
			$this->mResponse->redirect($this->mRouter->urlEx('index', 'login'));
		}
		
		$username = $_SESSION[$this->mSessionKeyUsername];
		
		$user = new Shendou_Model_User();
		$info = $user->get($username);
		$role_id = $info['user_role'];
		
		$data = $this->db->query('SELECT menu_url FROM skytech_menu a INNER JOIN skytech_relation b INNER JOIN skytech_role c where a.id = b.menu_id and b.role_id = c.id and c.id=' . $role_id)->toArray();
		
		$manager_root = $this->mSiteCfg['webInfo']['site']['host'];
		$url = $manager_root  . '/skytech_admin.php?s=' . $this->C . '/' . $this->A;
		
		foreach($data as $item){
			if ($manager_root . $item['menu_url'] == $url) {
				return true;
			}
		}
		
		$this->mResponse->redirect($this->mRouter->urlEx('index', 'error'));
	}
	
	public function checkPurview()
	{
		if (isset($_SESSION[$this->mSessionKeyUsername]) && isset($_SESSION[$this->mSessionKeyPassword])
			&& $this->isAccountCanLogin($_SESSION[$this->mSessionKeyUsername], $_SESSION[$this->mSessionKeyPassword], false)) {
			return true;
		}
			
		$this->mResponse->redirect($this->mRouter->urlEx('index', 'login'));
		return false;
	}	
	
	public function getCurrentUserInfo()
	{
		if (isset($_SESSION[$this->mSessionKeyUsername])) {
			$username = $_SESSION[$this->mSessionKeyUsername];
			$user = new Shendou_Model_User();
			return $user->get($username);
		}
		
		return null;
	}
	
	public function getCustmerWeb($id)
	{
		/*	
		if ($id == 1) {
			return '<a href="http://www.kl-autoparts.com" target="_blank">框立</a>';
		} else if ($id == 2) {
			return '<a href="http://www.shuodeadhesive.com" target="_blank">烁得</a>';
		}
		 * 
		 */
		 
		return ''; 
	}
	
		
	public function codeAction()
	{
		$c_check_code_image = new Shendou_CodeFile();
		$c_check_code_image ->OutCheckImage();	
	}
	
	
	public function getClientUrl($controllor, $action, array $param = null, $encode = true, $full = true)
	{
		return  $this->mSiteCfg['webInfo']['site']['host'] . '/index.php' . Lamb_App::getGlobalApp()->getRouter()->urlEx($controllor, $action, $param, $encode, $full);
	}
	
	
	public function log($str)
	{
		$path =  date('Y-m-d') . ".txt";
		$str = date('Y-m-d H:i:s') . " 信息：{$str}";
		file_put_contents($path, $str . "\r", FILE_APPEND);
	}	
}