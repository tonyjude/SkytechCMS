<?php
class itemControllor extends Shendou_Controllor_FrontAbstract
{
	private $tag = null;
	private $article = null;
	private $categories = null; 
	public function __construct()
	{
		parent::__construct();
		$this->tag = new Shendou_Model_Tag;
		$this->article = new Shendou_Model_Article;
		$this->categories = new Shendou_Model_Categories;
	}
	
	public function getControllorName()
	{
		return 'item';
	}
	
	public function indexAction()
	{
		$id = trim($this->mRequest->id);
	
		if (!Lamb_Utils::isInt($id, true)) {
			return;
		}

		$data = $this->article->get($id);
		if (!$data) {
			return;
		}
		
		$db = $this->mApp->getDb();
		
		$Previous = $db->query('select id,art_title from skytech_article where art_catalog_id=' . $data['art_catalog_id'] . ' and art_status=1 and id>' . $id .' order by id asc limit 0,1')->toArray();
		
		$Next = $db->query('select id,art_title from skytech_article where art_catalog_id=' . $data['art_catalog_id'] . ' and art_status=1 and id<' . $id .' order by id desc limit 0,1')->toArray();
		
		$tags = $this->tagHtml($id);
		$ret  = $this->categories->get($data['art_catalog_id']);
		$default_template = $ret['cate_article_templte'];

		$cate_path = $ret['cate_path'];
		$cate_ids  = explode('@', $cate_path,-1);
		$info = $this->categories->getByIds($cate_ids);
		
		$breadNavigation = $this->breadNavigation($info);
		
		$title = $data['art_title'];
		$keywords = $data['art_tag'];
		$description = htmlentities($data['art_excerpt']);
		
		include $this->load($default_template);	
	}
	
	public function tagHtml($id)
	{
		$html = '';
		$ret = $this->tag->getTagRelation($id);
		if (empty($ret)) {
			return $html;
		}
		
		foreach($ret as $item){
			$tag = str_replace(' ', '-', $item['tag_name']); 
			$tag_url = $this->mSiteCfg['webInfo']['site']['root'] . $this->mSiteCfg['webInfo']['static']['static_key'] . $tag . '/';
			$html .= "<a target='_blank' href='$tag_url'>{$item['tag_name']}</a>";
		}
		
		return $html;		
	}
	
	public function getImg($img)
	{
		if (Lamb_Utils::isHttp($img)) {
			return $img;
		}
		
		if ($img == '') {
			return $this->mSiteCfg['dynamic_url']['default_img'];
		}
		
		return $this->mSiteCfg['webInfo']['site']['manager_root'] . '/' . $img;
	}

}