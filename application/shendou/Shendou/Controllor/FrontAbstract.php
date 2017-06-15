<?php
abstract class Shendou_Controllor_FrontAbstract extends Shendou_Controllor_Abstract
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

	protected $db = null;
	
	public function __construct()
	{
		parent::__construct();
		$this->mSiteRoot = '/';
		$this->mRuntimeTemplate = $this->mSiteCfg['template'];
		$this->mRuntimeThemeUrl = $this->mSiteRoot . 'themes/';
		$this->mRuntimeViewPath = $this->mSiteCfg['view_path'] . $this->mRuntimeTemplate . '/';
		$this->mApp->setViewPath($this->mRuntimeViewPath);
		$this->db = Lamb_App::getGlobalApp()->getDb();
		@session_start();
	}
	
	public function showWebMenu($isTop = true, $pid = 0)
	{
		$sql = 'select * from skytech_categories where cate_status=1 and cate_parent_id=0 order by cate_sort';
		if (!$isTop) {
			$sql = 'select * from skytech_categories where cate_status=1 order by cate_sort';
		}
		$data = $this->db->query($sql)->toArray();
		$tree = $this->getMenuTree($data, $pid);
        $tree_html  = $this->procHtml($tree);

		return $tree_html;
	}
	
	public function getArticleByID($id)
	{
		$sql = 'select * from skytech_article where id=:id';
		$ret = $this->db->getNumDataPrepare($sql, array(':id' => array($id, PDO::PARAM_INT)), true);
		
		if ($ret['num'] != 1) {
			return null;
		}
		
		return $ret['data'];
	}
	
	public function showSubMenu($id)
	{
		$sql = "select * from skytech_categories where cate_status=1 and cate_parent_id=$id order by cate_sort";
	
		$data = $this->db->query($sql)->toArray();
       
	   	$html = '';
		if (empty($data)) {
			return $html;
		} 
        foreach($data as $key => $t)
        {
			$url = $this->mRouter->urlEx('list', 'index', array('id' => $t['id']));	
            $html .= "<li><a href='{$url}'>{$t['cate_name']}</a></li>";
        }
	   
		return $html;
	}
	
	/**
	 * 面包屑导航
	 */
	public function breadNavigation($info)
	{
		$html = '';
		$indexUrl = $this->mRouter->urlEx('index', 'index');
		
		$html .= '<a href="'. $indexUrl .'">Home</a><span>></span>';
		foreach($info as $key => $item) {
			$cate_url = $this->mRouter->urlEx('list', 'index', array('id' => $item['id'])); 	 
			$html .= '<a href="'. $cate_url .'">' . $item['cate_name'] . '</a>';
			if ($key < count($info) -1) {
				$html .= '<span>></span>';
			} 
		}	
		
		return $html;	
	}
	
	public function topicHtml($topic_data)
	{
		$html = '';
		foreach($topic_data as $item) {		
			$url = $this->mRouter->urlEx('topic', 'index', array('id' => $item['id']));			
			$html .= "<li><a href='{$url}'>{$item['topic_name']}</a></li>";
		}
		
		return $html;
	}
	
	public function procHtml($tree)
	{
		$html = '';
		if (empty($tree)) {
			return $html;
		} 
        foreach($tree as $key => $t)
        {
			$controllor = $t['cate_is_topic'] ? 'topic' : 'list';
			$url = $t['cate_is_linked'] ? $t['cate_linked_url'] : $this->mRouter->urlEx($controllor, 'index', array('id' => $t['id'], 't' => $t['cate_name']));
            if(!$t['parent_id'])
            {
                $html .= "<li><a href='{$url}'>{$t['cate_name']}</a></li>";
            }
            else
            {
            	$dropdown_menu = 'dropdown';	
            	if ($t['cate_level'] == 2) {
            		$dropdown_menu = 'dropdown-submenu';
            	}
                $html .= "<li class='{$dropdown_menu}'><a href='{$url}' data-submenu=''><span>{$t['cate_name']}</span></a>";
				
                $html .= "<ul class='dropdown-menu'>" .$this->procHtml($t['parent_id']) . "</ul>";
                $html = $html."</li>";
            }
        }

        return $html;
	}
	
	public function getCateByID($id, $field='cate_description')
	{
		$sql = "select {$field} from skytech_categories where id=:id";
		$ret = $this->db->getNumDataPrepare($sql, array(':id' => array($id, PDO::PARAM_INT)), true);
		
		if ($ret['num'] != 1) {
			return null;
		}
		
		if ($field == 'cate_description') {
			return $ret['data']['cate_description'];
		}
		
		return $ret['data'];
	}
	
	public function getItemByCate($id)
	{
		$sql = "select id,art_title from skytech_categories_article as sc, skytech_article as sa where categorie_id=$id and sc.article_id = sa.id";
		return $this->mApp->getDb()->query($sql)->toArray();
	}
	
	public function getTopic($id, $filed='topic_description')
	{
		$sql = "select {$filed} from skytech_topic where id={$id}";
		$ret = $this->db->query($sql)->toArray();
		if (!empty($ret)) {
			return $ret[0][$filed];
		}
		
		return '';
	}
	
	/**
	 * 获取所有标签|指定栏目的标签
	 */
	public function getTagsByCate($num = 0, $cid = 0)
	{
		if ($cid) {
			$sql = "SELECT DISTINCT c.tag_name FROM sky_tag_relation a, skytech_categories_article b, sky_tag c WHERE categorie_id=$cid and a.article_id = b.article_id and a.tag_id = c.id ORDER by c.tag_num desc";
			
		} else {
			$sql = "SELECT tag_name FROM sky_tag c ORDER by tag_num desc";
		}
		
		$sql .= $num ? " limit $num" : '';
		
		$html = '';
		$ret = $this->db->query($sql)->toArray();
		if (!empty($ret)) {
			foreach($ret as $item) {
				$html .= "<a href='" . $this->mSiteCfg['webInfo']['static']['static_key'] . $item['tag_name'] . "'>{$item['tag_name']}</a>";
			}
		}
		
		return $html;
	}
	
	public function log($str)
	{
		$path =  date('Y-m-d') . ".txt";
		$str = date('Y-m-d H:i:s') . " 信息：{$str}";
		file_put_contents($path, $str . "\r", FILE_APPEND);
	}	
	
	public function redirect($url, $time=1)
	{
		 $time = $time * 1000;	
		 echo "<script language='javascript' type='text/javascript'>
				 function redirect() 
				 {
					 self.location.href= '$url';
				 }
				 window.setTimeout('redirect();', $time);
			 </script>";
		
		exit;
	}
}

