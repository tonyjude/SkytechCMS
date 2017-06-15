<?php
class Shendou_Model_Static extends Shendou_Model
{
	const T_INDEX = 1;
	
	const T_ITEM = 2;
	
	const T_TOPIC = 4;
	
	const T_LIST = 8;
	
		
	/**
	 * @var array
	 */
	protected $mItemLooperParam = array();
	
	/**
	 * @var array
	 */
	protected $mListLooperParam = array();

	/**
	 * @var string
	 */
	protected $mTaskUrl = '';
	
	/**
	 * @var int
	 */
	protected $mCurrentTask;
	
	protected $mCurrentTaskType;
	
	/**
	 * @var array
	 */
	protected $mTasks = array();	
		
	public function __construct()
	{
		parent::__construct();
	}
	
	
	/**
	 * @param int $time	
	 * @return Shendou_Model_Static
	 */
	public function createIndex($time = 1)
	{
		$path = $this->router('index', array('id' => 'index'));
		$this->core($this->loadControllor('index', 'index'), 'index', $path);
			
		$this->endEcho(self::T_INDEX, $time);
		return $this;
	}
	
	/**
	 * @return Ttkvod_Model_Static
	 */	
	public function createItem($id, $art_title)
	{
		$action = 'index';
		$controllor = $this->loadControllor('item', $action);
		$router_path = $this->router('item', array('id' => $id, 'art_title' => $art_title));
		
		$this->core($controllor, $action, $router_path, array('id' => $id));
		return $this;
	}
	
	public function createTopic($id)
	{
		$action = 'index';
		$controllor = $this->loadControllor('topic', $action);
		$router_path = $this->router('topic', array('id' => $id));
		
		$this->core($controllor, $action, $router_path, array('id' => $id));
		return $this;
	}
	
	/**
	 * @return Ttkvod_Model_Static
	 */	
	public function createList($id, $p = null, $tag = null)
	{
		$action = 'index';
		$controllor = $this->loadControllor('list', $action);

		$param = array('id' => $id);
		if (null !== $p) {
			$param['p'] = $p;
		}
		
		if (null !== $tag) {
			$param['tag'] = $tag;
		}
		$router_path = $this->router('list', $param);
		$this->core($controllor, $action, $router_path, $param);
		return $this;
	}

	
	/**
	 * @param Ttkvod_Controllor $controllor
	 * @param string $action
	 * @param array $param
	 * @return void
	 */
	public function core($controllor, $action, $router_path, array $param = array())
	{
		$method = ($action ? $action : 'index') . 'Action';
		if (method_exists($controllor, $method)) {
			$param['ct'] = -1;
			$this->mRequest->setUserParams($param);
			ob_start();		
			$controllor->$method();
			$buffer = ob_get_contents();
			ob_end_clean();
			
			if (strstr($router_path, 'list_1.html')) {
				$this->putContent(preg_replace('/list_1/', 'index', $router_path), $buffer);
			}
			$this->putContent($router_path, $buffer);
		}
	}

	/**
	 * @param string $controllor
	 * @param string $action
	 * @return Ttkvod_Controllor
	 */
	public function loadControllor($controllor, $action)
	{
		$class = $controllor . 'Controllor';
		Lamb_Loader::loadClass($class, $this->mSiteCfg['controllor_path']);
		$this->mDispatcher->setOrGetControllor($controllor)->setOrGetAction($action);
		return new $class;
	}
	
	/**
	 * @param string $url
	 * @return Ttkvod_Model_Static
	 */
	public function setTaskUrl($url)
	{
		$this->mTaskUrl = (string)$url;
		return $this;
	}
	
	/** 
	 * @param int $tasktype T_ITEM T_LIST
	 * @return Ttkvod_Model_Static
	 */
	public function setCurrentTaskType($tasktype)
	{
		$this->mCurrentTaskType = (int)$tasktype;
		return $this;
	}
	
	/**
	 * @param string $model
	 * @param array  $param
	 * @return string
	 */
	public function router($model, array $param)
	{
		$path = '/index.html';
		$extend = $this->mSiteCfg['webInfo']['static']['extendtion'];
		if ($model == 'list') {
			$id = isset($param['id']) ? $param['id'] : 0;
			$path = $this->getListPath($id);
			$path = $path . "list_{$param['p']}.{$extend}";
		} else if ($model == 'topic') {
			$id = isset($param['id']) ? $param['id'] : 0;
			$path = $this->getTopicPath($id);
			$path = $path . "index.{$extend}";
		} else if ($model == 'item') {
			$title = Shendou_Pinyin::to(trim($param['art_title']));
			//$title = isset($param['id']) ? $param['id'] : 0;
			$path = 'blog/' . "{$title}.{$extend}";
		}
		
		return $path;
	}
	
	public function getListPath($id)
	{
		$sql = 'select cate_url from skytech_categories where id=' . $id;
		
		$ret = $this->mApp->getDb()->query($sql)->toArray();
		
		if (empty($ret)) {
			return null;
		}
		
		return $ret[0]['cate_url'];
	}
	
	public function getTopicPath($id)
	{
		$sql = 'select topic_url from skytech_topic where id=' . $id;
		
		$ret = $this->mApp->getDb()->query($sql)->toArray();
		
		if (empty($ret)) {
			return null;
		}
		
		return $ret[0]['topic_url'];
	}
	
	
	/**
	 * @param array $condition = array(
	 *		'id' => int, 'tag' => int, 'limit' => int
	 * )
	 * @return int	 
	 */
	public function createListLooper(array $condition = array())
	{
		$ctr = $this->mDispatcher->loadControllor('listControllor', true);
		$listPagesize = $ctr->getListPagesize();
		unset($ctr);
		$aPrepareSource = array();

		$sql = 'select sa.* from skytech_article as sa, skytech_categories_article as s where sa.id = s.article_id and categorie_id=:art_catalog_id';
		$aPrepareSource[':art_catalog_id'] = array($condition['id'], PDO::PARAM_INT);
		
		$num = $this->mApp->getDb()->getPrepareRowCount($sql, $aPrepareSource);
		if ($num == 0) {
			$this->mListLooperParam['num'] = 1;
			$this->mListLooperParam['id'] = $condition['id'];
			return 1;
		}
		
		$num = ceil($num / $listPagesize);
		$this->mListLooperParam['num'] = $num;
		if (isset($condition['limit']) && Lamb_Utils::isInt($condition['limit'], true)) {
			$num = min($num, $condition['limit']);
			$this->mListLooperParam['limit'] = $condition['limit'];
		}	
		$this->mListLooperParam['id'] = $condition['id'];
		return $num;
	}
	
	/**
	 * @param array $condition = array(
	 *		'id' => int,
	 *		'updateDate' => (array(0) >=, array(0, 1) >=0 && <=1 ),
	 *		'limit' => int
	 *	)
	 * @return int
	 */
	public function createItemLooper(array $condition = array())
	{
		$sql = 'select id,art_title from skytech_article where 1=1';
		
		if (isset($condition['cid']) && Lamb_Utils::isInt($condition['cid'], true)) {
			$sql .= ' and art_catalog_id=' . $condition['cid'];
		}
		
		if (isset($condition['id']) && $condition['id']) {
			$sql .= ' and id=' . $condition['id'];
		}
		
		if (isset($condition['art_postdate'])) {
			$art_postdate = $condition['art_postdate'];
			if (is_array($art_postdate)) {
				if (count($art_postdate) == 1 && $art_postdate[0]) {
					$sql .= " and art_postdate>='" . $art_postdate[0] . "'";
				} else if (count($art_postdate) == 2 && $art_postdate[0] && $art_postdate[1]) {
					$sql .= " and art_postdate>='" . $art_postdate[0] . "' and art_postdate<='" . $art_postdate[1] . "'";
				}
			}
		}

		$this->mItemLooperParam['sql'] = $sql;
		if (isset($condition['limit']) && Lamb_Utils::isInt($condition['limit'], true)) {
			$this->mItemLooperParam['limit'] = $condition['limit'];
			$sql = $this->mApp->getSqlHelper()->getLimitSql($sql, $condition['limit']);
		}
		$num = $this->mApp->getDb()->getNumData($sql);	
		if ($num == 0) {
			return 0;
		}
		return $num;
	}
	
	public function createTopicLooper(array $condition = array())
	{
		$sql = 'select * from skytech_topic where topic_status=1 ';
		$this->mItemLooperParam['sql'] = $sql;
		$this->mItemLooperParam['id']  = $condition['id'];	
		
		if (isset($condition['limit']) && Lamb_Utils::isInt($condition['limit'], true)) {
			$this->mItemLooperParam['limit'] = $condition['limit'];
			$sql = $this->mApp->getSqlHelper()->getLimitSql($sql, $condition['limit']);
		}
		
		$num = $this->mApp->getDb()->getNumData($sql);		
		if ($num == 0) {
			return 0;
		}
	
		return $num;
	}
	
	public function looperHandler($taskFlag, Shendou_HttpPageLooper $looper)
	{
		$pages = $looper->getCount();
		$page  = $looper->setOrGetCurrentPage();
		$time  = $looper->setOrGetSleepSecond();
		
		if ($page == 1) {
			$url = $this->mRequest->getRequestUri() . '/p/2';
		} else {
			$url = preg_replace('/\/p\/[^\/]*/is', '/p/' . ($page+1), $this->mRequest->getRequestUri());
		}
		
		ob_start();
		switch ($taskFlag) {
			case Shendou_HttpPageLooper::TASK_END:
				$this->endEcho($this->mCurrentTaskType, $time);
				break;
			case Shendou_HttpPageLooper::PER_TASK_BEGIN:
				echo "共 <b>$pages</b> 页，当前第 <b style='color:red'>$page</b> 页<br/>";
				break;
			case Shendou_HttpPageLooper::PER_TASK_END:
				echo "当前页处理完毕，{$time}秒后跳转到下一页 <script>setTimeout(function(){location.href='$url'}, " . ($time * 1000) . ")</script>";
				break;
		}
		ob_end_flush();		
	}
	
	public function listLooperCallback($page, $pagesize = 100)
	{
		$param = $this->mListLooperParam;
		if (empty($param)) {
			return false;
		} 
		
		$start = ($page - 1) * $pagesize + 1;		
		$id = $param['id'];
		$end = $start + $pagesize;
		$end = min($end, $param['num'] + 1);
			
		if (isset($param['limit'])) {
			$end = min($end, $param['limit'] + 1);
		}
		$tag = isset($param['tag']) ? $param['tag'] : null;
		$data = array(
			'id' => $id, 'tag' => $tag	
		);
		
		for (; $start < $end; $start++) {
			$this->createList($id, $start, $tag);
			$data['p'] = $start;
			$this->printInfo($data, false);
		}
	}
	
	public function itemLooperCallback($page, $pagesize = 100)
	{
		$param = $this->mItemLooperParam;
		$db = $this->mApp->getDb();
		$sqlHelper = $this->mApp->getSqlHelper();
		if (isset($param['limit']) && Lamb_Utils::isInt($param['limit'], true)) {
			if($param['limit'] < $page  * $pagesize ) {
				$pagesize = $param['limit'] - ($page - 1) * $pagesize;
				if ($pagesize <= 0) {
					return ;
				}
			}
		}
		$sql = $sqlHelper->getLimitSql($param['sql'], $pagesize, ($page - 1) * $pagesize);
		
		foreach ($db->query($sql)->toArray() as $item) {
			$this->createItem($item['id'], $item['art_title']);
			$this->printInfo($item);
		}
	}
	
	public function topicLooperCallback($page, $pagesize = 100)
	{
		$param = $this->mItemLooperParam;
		$id = $param['id'];
		$this->createTopic($id);
		echo "专题：<b style='color:green'></b>, ID : <b style='color:green'>$id</b> 生成成功<br/>";		
	}	
	
	/**
	 * @param string $path
	 * @param string $content
	 * @return void
	 */
	public function putContent($path, $content)
	{
		$path = rtrim($this->mSiteCfg['webInfo']['static']['save_path'], '\\/') . (strpos($path, '/') ? '/' . $path : $path);
		Lamb_IO_File::mkdir(dirname($path));
		Lamb_IO_File::putContents($path, $content);
	}
	
	public function printInfo($data, $isItem = true)
	{
		if ($isItem) {
			echo "文章：<b style='color:green'>{$data['art_title']}</b>, ID : <b style='color:green'>{$data['id']}</b> 生成成功<br/>";			
		} else {
			$param = array('id' => $data['id'], 'p' => $data['p']);
			$param['tag'] = $data['tag'] === null ? '' : $data['tag'];
			$path = $this->router('list', $param);
			echo "栏目：<b style='color:green'>" . ($param['tag'] ? $param['tag'] : '全部') ."</b>，路径：<b style='color:green'>{$path}</b>，生成成功<br/>";
		}
	}
	
	/**
	 * @param int $intervalTimeout
	 */
	public function endEcho($type, $intervalTimeout = 1)
	{
		$info = array(
			self::T_INDEX => '首页生成完毕&nbsp;<a href="/" target="_blank">首页</a>',
			self::T_ITEM  => '内容页生成完毕',
			self::T_TOPIC => '专题生成完毕',
			self::T_LIST  => '列表页生成完毕'
		);
		ob_start();
		echo $info[$type];
		if ($this->mTaskUrl) {
			echo ',' . $intervalTimeout . '秒后自动进入下一个任务。';
			echo "<script language='javascript' type='text/javascript'>
				 function redirect() 
				 {
					 window.location.href = '$this->mTaskUrl';
				 }
				 window.setTimeout('redirect();', {$intervalTimeout});
			 </script>";
		}
		ob_end_flush();
	}
}