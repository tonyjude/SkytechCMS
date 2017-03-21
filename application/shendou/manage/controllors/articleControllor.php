<?php
class articleControllor extends Shendou_Controllor_ManageAbstract
{
	private $article = null;
	public function __construct()
	{
		parent::__construct();
		$this->article = new Shendou_Model_Article;
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
			$this->getPurview();
		}
	}
	
	public function getControllorName()
	{
		return 'article';
	}
	
	public function indexAction()
	{
		$page = trim($this->mRequest->p);
		$q = trim($this->mRequest->q);
		$keywords = trim($this->mRequest->keywords);
		$cid = trim($this->mRequest->cid);
		$cname = trim($this->mRequest->cname);
		$cid = $cid ? $cid : 0;
		
		$pagesize = 30;
		
		if (!Lamb_Utils::isInt($page, true) || $page == 0) {
			$page = 1;
		}
		
		$aPrepareSource = array();
		
		if ($cid) {
			$sql = "select a.*,c.cate_name from skytech_article as a, skytech_categories as c, skytech_categories_article as ca where a.id = ca.article_id and c.id = ca.categorie_id and ca.categorie_id = :cid ";
			
			$aPrepareSource[':cid'] = array($cid, PDO::PARAM_INT);
		} else {
			$sql = "select a.*, b.cate_name from skytech_article as a, skytech_categories as b where a.art_catalog_id = b.id and a.art_status=:status ";
			
			$aPrepareSource[':status'] = array(1, PDO::PARAM_INT);
		}
		
		$sels = array_fill(0, 4, '');
		if ($q != '') {
			$sql .= " and recommend=:recommend ";
			$SELECTED = 'selected="selected"';
			$sels[$q] = $SELECTED;
			$aPrepareSource[':recommend'] = array($q, PDO::PARAM_INT);
		}
		
		if ($keywords) {
			$sql .= " and a.art_title like :title ";
			$aPrepareSource[':title'] = array('%'. $keywords . '%', PDO::PARAM_STR);
		} 
		
		$sql .= 'order by a.id desc';

		$prevPageUrl  = $this->mRouter->urlEx($this->C, '', array('p' =>  $page-1, 'q' => $q, 'cid' => $cid, 'cname' => $cname, 'keywords' => $keywords));
		$nextPageUrl  = $this->mRouter->urlEx($this->C, '', array('p' => $page+1, 'q' => $q, 'cid' => $cid, 'cname' => $cname, 'keywords' => $keywords));

		$pageUrl = $this->mRouter->urlEx($this->C, '', array('q' => $q, 'cid' => $cid, 'cname' => $cname, 'keywords' => $keywords));
		
		//$this->d($sql);
		
		include $this->autoload();	
		
	} 
	
	/**
	 * 添加或修改文章
	 */
	public function addOrUpdateAction()
	{
		$aid = trim($this->mRequest->aid);
		$cid  = trim($this->mRequest->cid);
		$cname = trim($this->mRequest->cname);
		
		//$cates = $this->getCateHtml();
		
		$ret = $this->db->query('select id,cate_name,cate_parent_id,cate_level from skytech_categories where cate_is_topic=0 order by cate_sort')->toArray();
		
		$temp = $this->getMenuTree($ret, 0);
		$cates = $this->createOptions($temp, $cid);
		
		if ($aid) {
			$info = $this->article->get($aid);
		}
		
		if ($this->mRequest->isPost()) {
			$data = $this->mRequest->getPost('data');
			
			if (!$data['art_author']) {
				$data['art_author'] = $_SESSION[$this->mSessionKeyUsername];
			}
			
			if (!$data['art_readcount']) {
				$data['art_readcount'] = rand(10, 100);
			}

			$id = trim($this->mRequest->getPost('id'));
			if ($id) {
				$this->article->update($id, $data);
				$this->showMsg(1, array('url' => $this->createItem($id)), '修改成功！');
			} else {
				if (!$data['art_image'] || !Lamb_Utils::isHttp($data['art_image'])) {
					if(isset($data['art_content']) && preg_match('/<img.*?src="(.*?)"/i', $data['art_content'], $result)) {
						if (!empty($result)) {
							$data['art_image'] = trim($result[1]);
						}
					}
				}
				
				if (isset($data['art_content']) && !$data['art_excerpt']) {
					$data['art_excerpt'] = substr(Shendou_Utils::filterHtmlTag($data['art_content']), 0, 200);
				}
					
				$id = $this->article->add($data);				
				if ($id) {
					$this->showMsg(1, array('url' => $this->createItem($id)), '添加成功！');
				} 
				$this->showMsg(0, null, '添加失败，请联系系统管理员！');		
			}
		}
		
		include $this->load('add_or_update_article');
	}

	public function createItem($id)
	{
		$url = $this->getClientUrl('looper', 'createhtml', array('ac' => 'item', 'id' => $id));
		return $url;
	}
	
	public function deleteAction()
	{
		$aid = trim($this->mRequest->aid);
		
		if (!Lamb_Utils::isInt($aid, true)) {
			$ids = explode(',', $aid);
			
			if (empty($ids)) {
				$this->showResults(0);
			} 
			
			unset($ids[count($ids)]);
			foreach($ids as $item) {
				if (!Lamb_Utils::isInt($item, true)) {
					continue;
				}	
				$this->article->delete($item);	
			}
		} else {
			$this->article->delete($aid);
		}
		
		$this->showResults(1);
	}
	
	public function getCate($data, $pId)
    {
        $tree = '';
		
        foreach($data as $k => $v)
        {
            if($v['cate_parent_id'] == $pId)
            {
            	$v['cate_name'] = str_repeat('─', ($v['cate_level'] - 1)) . $v['cate_name'];
                $v['parent_id'] = $this->getCate($data, $v['id']);
                $tree[] = $v;
            }
        }

        return $tree;
    }
	
}	
?>