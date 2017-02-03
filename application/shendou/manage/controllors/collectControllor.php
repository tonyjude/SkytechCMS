<?php
class collectControllor extends Shendou_Controllor_ManageAbstract
{
	private $madeinchina_list = null;
	private $alibaba_list = null;
	private $event  = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->madeinchina_list = new Shendou_Collect_MadeInChina_List();
		$this->alibaba_list = new Shendou_Collect_Alibaba_List();
		$this->event = new Shendou_Collect_Event();
	}
	
	public function getControllorName()
	{
		return 'collect';
	}
	
	/**
	 * 客户数据采集
	 */
	public function indexAction()
	{
		set_time_limit(0) ;
		header("Content-type: text/html; charset=utf-8"); 
		
		$totalPage = 3;
		$key = trim($this->mRequest->k);
		$key = Lamb_Utils::isInt($key,true) ? $key : 0;
		$page = trim($this->mRequest->p);
		$page = Lamb_Utils::isInt($page,true) ? $page : 1;
		$offset = trim($this->mRequest->os);
		$offset = Lamb_Utils::isInt($offset,true) ? $offset : 0;
		$ch = trim($this->mRequest->ch);
		$ch = Lamb_Utils::isInt($ch,true) ? $ch : 0;	
		
		$ret = $this->db->query('select uid,name,keyword from skytech_member_info')->toArray();
		if (empty($ret)) {
			exit('over');
		}
		
		if ($key >= count($ret)) {
			exit('collect over!');
		}

		$db_key   = $ret[$key]['name'];
		$keyword  = $ret[$key]['keyword'];
		$uid  = $ret[$key]['uid'];
		$keywords = explode(',', $keyword);
		
		$channels = array(
			'Made In China',
			'Alibaba'
		);

		if ($offset >= count($keywords)) {
			$offset = 0;
			$ch++;
		}
		
		if ($ch >= count($channels)) {
			$ch = 0;
			$key++; 
			
			echo "采集下一客户<br/>";
			$this->mResponse->redirect($this->mRouter->urlEx('collect', '', array('ch' => $ch, 'os' => $offset, 'p' => $page++, 'k' => $key)), 3);
		}
		
		echo '正在采集' . $db_key . '用户  [' . $channels[$ch] . '] 频道关键词 [' . $keywords[$offset] .'] 第' . $page . '页<br/>';
	
		$this->collect($keywords[$offset], $page, $ch, $db_key, $uid);
		
		$page++;
		if ($page > $totalPage) {
			$offset++;
			$page = 1;
		}
		
		$this->mResponse->redirect($this->mRouter->urlEx('collect', '', array('ch' => $ch, 'os' => $offset, 'p' => $page++, 'k' => $key)), 3);
				
	}
	
	/**
	 * 数据插入
	 * @param keywords 关键词
	 * @param page 页数
	 * @param ch 频道 
	 */
	public function collect($keywords, $page, $ch, $db_key, $uid)
	{
		if ($ch == 0) {
			//获取列表页数据			
			$data = $this->madeinchina_list->collect($this->madeinchina_list->getUrl($keywords, $page));
		} else if ($ch == 1) {
			$data = $this->alibaba_list->collect($this->alibaba_list->getUrl($keywords, $page));
		}
		
		if (empty($data)) {
			$this->log("频道{$ch}关键词{$keywords}数据采集失败， 资源不足！");
			echo '数据采集失败， 资源不足<br/>';
			return;
		}
		
		$custmer_db = Shendou_Db::get($db_key);
		foreach($data as $item) {
			$item['purchase_channel'] = $ch;
			$item['purchase_time'] = date('Y-m-d H:i:s');
			$item['purchase_url']  =  $ch == 0 ? 'http://sourcing.made-in-china.com' . $item['purchase_url'] : $item['purchase_url'];
			$item['purchase_for_id'] = $uid;//客户网站唯一标示
			
			if (!$this->event->writeToDb($item)) {
				$this->log(print_r($item, true) . "数据插入失败\r\n -----------------------");
				echo '数据插入失败<br/>';
			}
			
			unset($item['purchase_for_id']);
			$this->event->writeToCustmerDb($custmer_db, $item);
		}
	
	}
	
}
		