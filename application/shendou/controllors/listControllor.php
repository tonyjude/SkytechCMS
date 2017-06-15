<?php
class listControllor extends Shendou_Controllor_FrontAbstract
{
	protected $mDefaultPagesize;
	
	private $article = null;
	private $categories = null; 
	public function __construct()
	{
		parent::__construct();
		$this->article = new Shendou_Model_Article;
		$this->categories = new Shendou_Model_Categories;
		$this->mDefaultPagesize = $this->mSiteCfg['webInfo']['static']['pagesize'];
	}
	
	public function getControllorName()
	{
		return 'list';
	}
	
	public function indexAction()
	{
		$id = trim($this->mRequest->id);
		$page = trim($this->mRequest->p);
		$t  = trim($this->mRequest->t);
		$pagesize = $this->mDefaultPagesize;
		
		if (!Lamb_Utils::isInt($id, TRUE)) {
			return;
		}

		if (!Lamb_Utils::isInt($page, TRUE) || $page == 0) {
			$page = 1;
		}
		
		$sql = 'SELECT a.* FROM skytech_article as a, skytech_categories as c, skytech_categories_article as ca where a.id = ca.article_id and c.id = ca.categorie_id and ca.categorie_id = ' . $id . ' order by a.id desc ';
		
		$prevPageUrl  = $this->mRouter->urlEx($this->C, '', array('id' => $id, 'p' => '#prevPage#'));
		$nextPageUrl  = $this->mRouter->urlEx($this->C, '', array('id' => $id, 'p' => '#nextPage#'));

		$pageUrl = $this->mRouter->urlEx($this->C, '', array('id' => $id, 'p' => '#page#'));
		
		$ret = $this->categories->get($id);
		$cate_path = $ret['cate_path'];
		$cate_ids  = explode('@', $cate_path,-1);
		$info = $this->categories->getByIds($cate_ids);
		
		$breadNavigation = $this->breadNavigation($info);	
		$default_template = $ret['cate_list_template'];
		
		$title = $ret['cate_seo_title'] ? $ret['cate_seo_title'] : $ret['cate_name'];
		$keywords = $ret['cate_keywords'] ? $ret['cate_keywords'] : $ret['cate_name'];
		$description = $ret['cate_description'] ? $ret['cate_description'] : $ret['cate_name'];
		
		$firstPageUrl = $this->mRouter->urlEx($this->C, '', array('id' => $id, 'p' => 1));
		$lastPageUrl  = $this->mRouter->urlEx($this->C, '', array('id' => $id, 'p' => '#lastPage#'));
			
		include $this->load($default_template);	

	}
	
	public function getImg($img)
	{
		if (Lamb_Utils::isHttp($img)) {
			return $img;
		}
		
		if ($img == '') {
			return $this->mSiteCfg['dynamic_url']['default_img'];
		}
		
		if (strpos($img, 'upload') == 0) {
			return '/skytech_cms_new/sd_site_m/' . $img;
		}
		
		return $img;
	}
	
	public function getListPagesize()
	{
		return $this->mDefaultPagesize;
	}

}