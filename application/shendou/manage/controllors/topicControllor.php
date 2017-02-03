<?php
class topicControllor extends Shendou_Controllor_ManageAbstract
{
	private $topic = null;
	public function __construct()
	{
		parent::__construct();
		$this->topic = new Shendou_Model_Topic();
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
			$this->getPurview();
		}
	}
	
	public function getControllorName()
	{
		return 'topic';
	}
	
	public function indexAction()
	{

		$page = trim($this->mRequest->p);
		$page = Lamb_Utils::isInt($page, true) ? $page : 1;
		$pagesize = 10;

		$sql = "select * from skytech_topic where topic_status=1 ";

		$prevPageUrl  = $this->mRouter->urlEx('topic', '', array('p' =>  $page-1));
		$nextPageUrl  = $this->mRouter->urlEx('topic', '', array('p' => $page+1));

		$pageUrl = $this->mRouter->urlEx('topic', '');

		include $this->load('topic');
	}
	
	public function addOrUpdateAction()
	{
		$id = trim($this->mRequest->id);
		if ($id) {
			$info = $this->topic->get($id);
		}

		if ($this->mRequest->isPost()) {
			
			$data = $this->mRequest->getPost('data');
			if ($data['topic_name'] == '') {
				$this->showMsg(-3, null, '专题名称不能为空！');
			}
			
			if (strlen($data['topic_name']) > 200 ) {
				$this->showMsg(-4, null, '专题名称长度不能超过200！');
			}
			
			if (!$data['topic_author']) {
				$data['topic_author'] = $_SESSION[$this->mSessionKeyUsername];
			}
			
			if (!$data['topic_readcount']) {
				$data['topic_readcount'] = rand(10, 100);
			}

			//如果ID不存在添加专题， ID存在修改专题
			if ($data['id']) {
				if ($this->topic->update($data['id'], $data)) {
					$this->showMsg(1, array('url' => $this->createTopic($data['id'])), '修改成功！');
				} else {
					$this->showMsg(0, null, '修改失败！');
				}
			}
			
			$topic_url = '/' . Shendou_Pinyin::to($data['topic_name'], true). '/';
			$data['topic_url'] = $topic_url;
			if (!$data['topic_img'] || !Lamb_Utils::isHttp($data['topic_img'])) {
				if(isset($data['topic_content']) && preg_match('/<img.*?src="(.*?)"/i', $data['topic_content'], $result)) {
					if (!empty($result)) {
						$data['topic_img'] = trim($result[1]);
					}
				}
			}
			
			$id = $this->topic->add($data);
			if ($id) {
				$this->showMsg(1, array('url' => $this->createTopic($id)), '添加成功！');
			}
			
			$this->showMsg(0, null, '系统错误，请联系系统管理员！');
		}


		include $this->load('add_or_update_topic');
	}
	
	public function createTopic($id)
	{
		$url = $this->getClientUrl('looper', 'createhtml', array('ac' => 'topic', 'id' => $id));
		return $url;
	}
	
	public function deleteAction()
	{
		$id = trim($this->mRequest->id);
		
		if (!Lamb_Utils::isInt($id, true)) {
			return;
		}

		if ($this->topic->delete($id)) {
			$this->showMsg(1, null, '删除成功！');
		}
		
		$this->showMsg(0, null, '删除失败！');
	}

}