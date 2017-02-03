<?php
class sitemapControllor extends Shendou_Controllor_ManageAbstract
{
	public function __construct()
	{
		parent::__construct();
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
			$this->getPurview();
		}
	}
	
	public function getControllorName()
	{
		return 'sitemap';
	}
	
	public function indexAction()
	{
		$opaction = trim($this->mRequest->opac);
		
		$host = $this->mSiteCfg['webInfo']['site']['host'];
		$html = '';
		if ($opaction == 'run') {
			$html .= '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
			$html .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
			$html .= '<url>' . "\n";
			$html .= 		'<loc>' . $host . '</loc>' . "\n";
			$html .= 		'   <lastmod>'. date('Y-m-d') .'</lastmod>' . "\n";
			$html .= 		'   <changefreq>monthly</changefreq>' . "\n";
			$html .= 		'   <priority>1.0</priority>' . "\n";
			$html .= '</url>' . "\n\n";
				
			$sql = 'select * from skytech_categories where cate_level=1 and cate_status=1';	
			$db = $this->mApp->getDb();
			$ret = $db->query($sql)->toArray();
			
			foreach($ret as $item){
				$num = $this->getPages($item['id']);
				if (!$num) {
					continue;
				}
				
				for($i=1; $i<=$num; $i++) {
					$html .= '<url>'. "\n";
					$html .=	'   <loc>' . $host . $item['cate_url'] . 'list_' . $i . '.html</loc>'. "\n";
					$html .=	'   <changefreq>monthly</changefreq>'. "\n";
					$html .=	'   <priority>0.8</priority>'. "\n";
					$html .= '</url>' . "\n\n";	
				}
			}
			
			$sql = 'select * from skytech_categories where cate_level>1 and cate_status=1';	
			$ret = $db->query($sql)->toArray();
			foreach($ret as $item){
				$num = $this->getPages($item['id']);
				if (!$num) {
					continue;
				}
				
				for($i=1; $i<=$num; $i++) {
					$html .= '<url>' . "\n";
					$html .=  	'   <loc>' . $host . $item['cate_url'] . 'list_' . $i . '.html</loc>' . "\n";
					$html .=	'   <changefreq>monthly</changefreq>' . "\n";
					$html .=	'   <priority>0.6</priority>' . "\n";
					$html .=  '</url>' . "\n\n";		  
				}
			}
			
			$sql = 'select * from skytech_topic where topic_status=1';	
			$ret = $db->query($sql)->toArray();
			foreach($ret as $item){
				$html .=  '<url>' . "\n";
				$html .=  	'   <loc>' . $host . $item['topic_url'] . 'index.html</loc>' . "\n";
				$html .=	'   <changefreq>monthly</changefreq>' . "\n";
				$html .=	'   <priority>0.8</priority>' . "\n";
				$html .=  '</url>' . "\n\n";		  
			}

			$sql = 'select * from skytech_article where art_status=1';	
			$ret = $db->query($sql)->toArray();
			foreach($ret as $item){
				$html .=  '<url>' . "\n";
				$html .=  	'   <loc>' . $host . '/blog/' . Shendou_Pinyin::to($item['art_title']) . '.html</loc>' . "\n";
				$html .=	'   <changefreq>monthly</changefreq>' . "\n";
				$html .=	'   <priority>0.4</priority>' . "\n";
				$html .=  '</url>' . "\n\n";		  
			}
			
			$sql = 'select tag_name from sky_tag';	
			$ret = $db->query($sql)->toArray();
			foreach($ret as $item){
				$html .=  '<url>' . "\n";
				$html .=  	'   <loc>' . $host . '/keyword/' . $item['tag_name'] . '/</loc>' . "\n";
				$html .=	'   <changefreq>monthly</changefreq>' . "\n";
				$html .=	'   <priority>0.4</priority>' . "\n";
				$html .=  '</url>' . "\n\n";		  
			}			
			
			$html .= '</urlset>';
			echo $html;
			file_put_contents('../web/sitemap.xml', $html);
			return;
		}
		
		include $this->autoload();	
	}

	public function getPages($id)
	{
		$db = $this->mApp->getDb();
		$data = $db->query('select count(article_id) as num from skytech_categories_article where categorie_id = ' . $id)->toArray();
		if (empty($data)) {
			return 0;
		}
		
		$pagesize = $this->mSiteCfg['webInfo']['static']['pagesize'];
		$num = ceil($data[0]['num']/$pagesize);
		return $num;		
	}
	
}	
?>