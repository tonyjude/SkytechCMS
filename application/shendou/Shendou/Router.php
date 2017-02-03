<?php
class Shendou_Router extends Lamb_App_Router
{
	/**
	 * @var array
	 */
	protected $mHosts;
	
	/**
	 * @var boolean
	 */
	public  $mIsStatic;
	
	/**
	 * @var string
	 */
	protected $mStaticExtend;
	
	/**
	 * @var string
	 */
	protected $mStaticPath;
	
	/**
	 * @var array
	 */
	protected $mHostCaches;
	
	/**
	 * @var array
	 */
	protected $mSiteCfg;
	
	
	public function __construct()
	{
		parent::__construct();
		$cfg = Lamb_Registry::get(CONFIG);
		$this->mSiteCfg = $cfg;
		$this->setUrlDelimiter($cfg['router']['url']['delimiter'])
			 ->setRouterParamName($cfg['router']['url']['param_name']);
		$this->mHosts = array();
		$this->mIsStatic = $cfg['webInfo']['site']['mode'] == 2;
		$this->mStaticPath = '';
		$this->mStaticExtend = $cfg['webInfo']['static']['extendtion']; 
	}
	
	/**
	 * @param string $controllor
	 * @param string $action
	 * @param array $param
	 * @param boolean $encode
	 * @param boolean $full
	 * @param boolean $isStatic
	 * @return string
	 */
	public function getDefaultLink($controllor, $action, array $param = null, $encode = true, $full = false, $isStatic = true)
	{
		$key = $controllor;
		
		$host = $full ? $this->getHost() : '';

		if (!$isStatic && (!$controllor || $controllor == 'index') && $action == 'index') {
			return $host;	
		}

		if (!$isStatic || !in_array($controllor, array('index'))) {
			return $this->getDynamicPageUrlTempalte($host, $controllor, $action, $param, $encode, $full);
		}
		
		if ($key == 'index') {
			if (!$action || $action == 'index') {
				return $host;// . '/index.' . $this->mStaticExtend;
			} else {
				$name = $action;
				ksort($param);
				$temp = implode('_', array_values($param));
				if ($temp) {
					$name .= '_' . $temp;
				}
				return $name;
			}
		}
	}
	
	
	/**
	 * @param string $action
	 * @param array $param
	 * @param boolean $encode
	 * @param boolean $full
	 * @param boolean $isStatic
	 * @return string
	 */
	public function getListLink($action, array $param = null, $encode = true, $full = true, $isStatic = true)
	{	
		$staticHost = $dynamicHost = $this->getHost();
		$id = isset($param['id']) ? $param['id'] : 0;
		$p  = isset($param['p']) ? $param['p'] : 1;
		if(!$param){
			$param = array();
		}

		if (!$isStatic) {
			return $this->getDynamicPageUrlTempalte($dynamicHost, 'list', $action, $param, $encode, $full);
		}
		
		$db = Lamb_App::getGlobalApp()->getDb();
		$ret = $db->query('select cate_url from skytech_categories where id=' . $id)->toArray();
		$path = '';
		if (!empty($ret)) {
			$path = $ret[0]['cate_url'];
		}
		
		if ($p == 1) {
			return "{$staticHost}{$path}";
		}
		
		return "{$staticHost}{$path}list_{$p}.{$this->mStaticExtend}";
	
	}
	
	/**
	 * @param string $action
	 * @param array $param
	 * @param boolean $encode
	 * @param boolean $full
	 * @param boolean $isStatic
	 * @return string
	 */
	public function getTopicLink($action, array $param = null, $encode = true, $full = true, $isStatic = true)
	{
		$staticHost = $dynamicHost = $this->getHost();
		$id = isset($param['id']) ? $param['id'] : 0;
		if(!$param){
			$param = array();
		}

		if (!$isStatic) {
			return $this->getDynamicPageUrlTempalte($dynamicHost, 'topic', $action, $param, $encode, $full);
		}
		
		$db = Lamb_App::getGlobalApp()->getDb();
		$ret = $db->query('select topic_url from skytech_topic where id=' . $id)->toArray();
		$path = '';
		if (!empty($ret)) {
			$path = $ret[0]['topic_url'];
		}
		
		return "{$staticHost}{$path}";
		//return "{$staticHost}{$path}index.{$this->mStaticExtend}";
	}
	
	
	public function getItemLink($action, array $param = null, $encode = true, $full = true, $isStatic = true)
	{
		$staticHost = $dynamicHost = $this->getHost();
		$title = isset($param['art_title']) ? $param['art_title'] : 0;
		if(!$param){
			$param = array();
		}
		
		if (!$isStatic) {
			return $this->getDynamicPageUrlTempalte($dynamicHost, 'item', $action, $param, $encode, $full);
		}
		
		$title = Shendou_Pinyin::to($title);
		return "{$staticHost}/blog/{$title}.{$this->mStaticExtend}";
		
	}
	
	/**
	 * @param string $host
	 * @param string $controllor
	 * @param string $action
	 * @param array $param
	 * @param boolean $encode
	 * @param boolean $full
	 * @return string
	 */
	public function getDynamicPageUrlTempalte($host, $controllor, $action, array $param, $encode = true, $full = false)
	{
		if (!isset($param['p']) || $param['p'] == 1) {
			return $host . parent::urlEx($controllor, $action, $param, $encode, $full); 
		} else {
			$page = $param['p'];
			unset($param['p']);
			return $host . parent::urlEx($controllor, $action, $param, $encode, $full) .
					parent::setUrlDelimiter() .
					parent::url(array('p' => $page), false);
		}	
	}
	
	
	/**
	 * @param string $controllor
	 * @param string $action
	 * @param array $param
	 * @param boolean $encode
	 * @param boolean $full
	 * @param boolen $isStatic 
	 * @return string
	 */
	public function urlEx($controllor = '', $action = '', array $param = null, $encode = true, $full = true, $isStatic = -1)
	{
		$isStatic = $isStatic == -1 ? $this->mIsStatic : $isStatic;
		$router = array(
			'list'  => 'getListLink',
			'topic' => 'getTopicLink',
			'item'  => 'getItemLink'
		);
		
		if (array_key_exists($controllor, $router)) {
			return $this->$router[$controllor]($action, $param, $encode, $full, $isStatic);
		} 

		return $this->getDefaultLink($controllor, $action, $param, $encode, $full, $isStatic);
	}
	
	public function getHost()
	{
		return $this->mSiteCfg['webInfo']['site']['root'];
	}

}