<?php
class tagControllor extends Shendou_Controllor_FrontAbstract
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function getControllorName()
	{
		return 'tag';
	}
	
	public function indexAction()
	{
		$keyword = trim($this->mRequest->keyword);
		$pagesize = $this->mSiteCfg['webInfo']['static']['pagesize'];

		if ($keyword == '') {
			return;
		}
		
		$title = $keyword;
		$description = $keyword;
		
		$sql = 'SELECT sa.* FROM skytech_article as sa, sky_tag_relation as str, sky_tag as st WHERE str.tag_id = st.id and sa.id = str.article_id and st.tag_name=:tag_name';
		
		$aPrepareSource = array(
			':tag_name' => array(str_replace('-', ' ', $keyword), PDO::PARAM_STR)
		);
		
		include $this->load('tag');
	}
	


}