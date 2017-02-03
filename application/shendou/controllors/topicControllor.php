<?php
class topicControllor extends Shendou_Controllor_FrontAbstract
{
	private $topic = null;
	public function __construct()
	{
		parent::__construct();
		$this->topic = new Shendou_Model_Topic;
	}
	
	public function getControllorName()
	{
		return 'topic';
	}
	
	public function indexAction()
	{
		$id = trim($this->mRequest->id);
		$t  = trim($this->mRequest->t);
		if (!Lamb_Utils::isInt($id, true)) {
			return;
		}
		
		$data = $this->topic->get($id);
		$default_template = $data['topic_templte'];
		
		$title = $data['topic_title'];
		$topic_seo_title = $data['topic_seo_title'];
		$keywords = $data['topic_keywords'];
		$description = htmlentities($data['topic_description']);
		
		$indexUrl = $this->mRouter->urlEx('index', 'index');
		$topicUrl = $this->mRouter->urlEx('topic', 'index', array('id' => $data['id']));
		
		$breadNavigation = '<a href="' . $indexUrl . '">Home</a><span>></span><a href="'. $topicUrl .'">' . $data['topic_name'] . '</a>';
				
		include $this->load($default_template);	
	}

}