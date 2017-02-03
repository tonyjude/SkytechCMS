<?php
class looperControllor extends Shendou_Controllor_FrontAbstract
{
	public function __construct()
	{
		parent::__construct();
		set_time_limit(0);
	}
	
	public function getControllorName()
	{
		return 'index';
	}	
	
	public function createhtmlAction()
	{
		$action = trim($this->mRequest->ac);
		$key = trim($this->mRequest->key);
		$intervalSecond = trim($this->mRequest->is);
		$page = trim($this->mRequest->p);
		$pagesize =  trim($this->mRequest->psi);;
		$id = trim($this->mRequest->id);
		$cid = trim($this->mRequest->cid);
		$limit = trim($this->mRequest->limit);
		$tagid = trim($this->mRequest->tagid);
		$sdate = trim($this->mRequest->sd);
		$edate = trim($this->mRequest->ed);
		$taskurl = trim($this->mRequest->turl);
		
		if (!Lamb_Utils::isInt($key, true)) {
			$key = 0;
		}
		
		if (!Lamb_Utils::isInt($page, true)) {
			$page = 1;
		}
		
		if (!Lamb_Utils::isInt($pagesize, true)) {
			$pagesize = $this->mSiteCfg['webInfo']['static']['pagesize'];
		}
		
		if (!Lamb_Utils::isInt($intervalSecond, true)) {
			$intervalSecond = 2;
		}
	
		$model = new Shendou_Model_Static();
		if ($taskurl) {
			$model->setTaskUrl($taskurl);
		}		
		switch ($action) {
			case 'index':
				$model->createIndex($intervalSecond);
				break;
			case 'item':
			case 'list':
				$condition = array();
				
				if ($action == 'list' && !Lamb_Utils::isInt($id, true)){
					$this->mResponse->eecho("id : {$id} illegal");
				}
				
				$condition['id'] = $id;
				if (Lamb_Utils::isInt($cid, true)) {
					$condition['cid'] = $cid;
				}
				
				if (Lamb_Utils::isInt($limit, true)) {
					$condition['limit'] = $limit;
				}
				
				if ($action == 'list') {
					$count = $model->createListLooper($condition);
					
					$handler = array($model, 'listLooperCallback');
					$model->setCurrentTaskType(Shendou_Model_Static::T_LIST);
				} else {
				
					if ($sdate == '0' && $edate == '0') {
						$h = (int)date('h');
						if ( $h < 4 ) {
							$condition['art_postdate'] = array(date('Y-m-d', time() - 30 * 24 * 3600), date('Y-m-d 23:59:59'));
						} else {
							$condition['art_postdate'] = array(date('Y-m-d'), date('Y-m-d 23:59:59'));
						}
					} else {
						if ($sdate !== false) {
							if ($edate !== false) {
								$condition['art_postdate'] = array($sdate, $edate);
							} else {
								$condition['art_postdate'] = array($sdate);
							}
						} else if ($edate !== false){
							$condition['art_postdate'] = array(0, $edate);
						}
					}
					
					$count = $model->createItemLooper($condition);

					$handler = array($model, 'itemLooperCallback');
					$model->setCurrentTaskType(Shendou_Model_Static::T_ITEM);
				}
				
				$obj = new Shendou_HttpPageLooper($pagesize);
				$obj->setCount(ceil($count / $pagesize))
					->setOrGetSleepSecond($intervalSecond)
					->setHandler($handler)
					->setMsgHandler(array($model, 'looperHandler'))
					->setOrGetCurrentPage($page)
					->run();
				break;
			case 'topic':
				$condition = array();
				
				if (!Lamb_Utils::isInt($id, true)){
					$this->mResponse->eecho("id : {$id} illegal");
				}
				
				if (Lamb_Utils::isInt($limit, true)) {
					$condition['limit'] = $limit;
				}

				$condition['id'] = $id; 
				$count = $model->createTopicLooper($condition);
				$handler = array($model, 'topicLooperCallback');
				$model->setCurrentTaskType(Shendou_Model_Static::T_TOPIC);
				
				$obj = new Shendou_HttpPageLooper($pagesize);
				$obj->setCount(ceil($count / $pagesize))
					->setOrGetSleepSecond($intervalSecond)
					->setHandler($handler)
					->setMsgHandler(array($model, 'looperHandler'))
					->setOrGetCurrentPage($page)
					->run();	
				break;	
			case 'topictask':
				$urlParam = array('ac' => $action, 'psi' => $pagesize, 'is' => $intervalSecond, 'key' => $key);
				$topicIds = $this->getTopicsInfo();
				
				if ($key >= count($topicIds)) {
					$this->mResponse->eecho("任务执行完毕！");
				} else {
					$urlParam['key'] = $key + 1;
				}
				
				$id = $topicIds[$key];
				if (!Lamb_Utils::isInt($id, true)) {
					$this->mResponse->eecho("id illegal");
				}
				
				$urlParam['id'] = $id;
				$urlParam['limit'] = $limit;
				
				$taskurl = $this->mRouter->urlEx($this->mDispatcher->setOrGetControllor(), $this->mDispatcher->setOrGetAction(), $urlParam);
				$url = $this->mRouter->urlEx($this->mDispatcher->setOrGetControllor(), $this->mDispatcher->setOrGetAction(), array(
								'ac' => 'topic', 'limit' => $limit, 'psi' => $pagesize, 'is' => $intervalSecond,
								'id' => $id, 'turl' => $taskurl
							));
									
				$this->mResponse->redirect($url);
				break;	
			case 'listtask':
				$urlParam = array('ac' => $action, 'psi' => $pagesize, 'is' => $intervalSecond, 'key' => $key);
				
				$ids = $this->getCategorieIds();
				if ($key >= count($ids)) {
					$this->mResponse->eecho("任务执行完毕！");
				} else {
					$urlParam['key'] = $key + 1;
				}
				
				$id = $ids[$key];
				if (!Lamb_Utils::isInt($id, true)) {
					$this->mResponse->eecho("id illegal");
				}
				
				$urlParam['id'] = $id;
				$urlParam['limit'] = $limit;
				
				$taskurl = $this->mRouter->urlEx($this->mDispatcher->setOrGetControllor(), $this->mDispatcher->setOrGetAction(), $urlParam);
				$url = $this->mRouter->urlEx($this->mDispatcher->setOrGetControllor(), $this->mDispatcher->setOrGetAction(), array(
								'ac' => 'list', 'limit' => $limit, 'psi' => $pagesize, 'is' => $intervalSecond,
								'id' => $id, 'turl' => $taskurl
							));
				$this->mResponse->redirect($url);
				break;
			default:
				$url = '?s=looper/createhtml/ac/index/' . $this->mRouter->url(array('turl' => $taskurl));
				$this->mResponse->redirect($url);
				break;
		}
		
		
	}
	
	public function getCategorieIds()
	{
		$sql = 'select id from skytech_categories where cate_is_topic=0 order by cate_path';
		$ret = $this->mApp->getDb()->query($sql)->toArray();
		if (empty($ret)) {
			return null;
		}
		
		$cIds = array();
		foreach($ret as $item) {
			$cIds[] = $item['id'];
		}
		
		return $cIds;
	}
	
	public function getTopicsInfo()
	{
		$sql = 'select id from skytech_topic where topic_status = 1 order by id';
		$ret = $this->mApp->getDb()->query($sql)->toArray();
		if (empty($ret)) {
			return null;
		}
		
		$tpoicIds = array();
		foreach($ret as $item) {
			$tpoicIds[] = $item['id'];
		}
		
		return $tpoicIds;
	}
	
}