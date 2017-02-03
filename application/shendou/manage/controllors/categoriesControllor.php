<?php
class categoriesControllor extends Shendou_Controllor_ManageAbstract
{
	
	private $categories = null;
	public function __construct()
	{
		parent::__construct();
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
			$this->getPurview();
		}
		$this->categories = new Shendou_Model_Categories;
	}
	
	public function getControllorName()
	{
		return 'categories';
	}
	
	/**
	 * 栏目首页
	 */
	public function indexAction()
	{
		
		$data = $this->db->query('select * from skytech_categories order by cate_sort')->toArray();
		
		$data = $this->getMenuTree($data, 0);
		
		$categories = $this->createHtml($data);
		
		include $this->load('categories');
	} 
	
	/**
	 * 添加或修改栏目
	 */
	public function addOrUpdateCateAction()
	{
		$id = trim($this->mRequest->id);
		$cate_id = trim($this->mRequest->cate_id);
		
		if ($cate_id) {
			$cate_info = $this->categories->get($cate_id);
		}
				
		if ($this->mRequest->isPost()) {

			$data = $this->mRequest->getPost('data');

			$cate_parent_id = $this->mRequest->getPost('cate_parent_id');
			
			$cate_id = $data['id'];
			unset($data['id']);
			$cate_name = $data['cate_name'];
			
			$data['cate_status'] = isset($data['cate_status']) ? 0 : 1;
			$data['cate_is_topic'] = isset($data['cate_is_topic']) ? 1 : 0;
			
			if ($cate_name == '' || Shendou_Utils::strlength($cate_name) > 100) {
				$this->showMsg(-1, null, '栏目长度不能超过100！');
			}
			
			if (Shendou_Utils::strlength($data['cate_seo_title']) > 250 ) {
				$this->showMsg(-2, null, 'SEO标题长度不能超过250！');
			}
			
			if (Shendou_Utils::strlength($data['cate_description']) > 250 ) {
				$this->showMsg(-3, null, '栏目描述长度不能超过250！');
			}
			
			if ($cate_id) {
				$upnext = $this->mRequest->getPost('upnext');
				if ($upnext) {
					$this->categories->updateSubCateInfo($cate_id, $data);
				} 
				
				$this->categories->update($cate_id, $data);
			} else {
								
				/**
				 * 栏目保存路径就是栏目的拼音
				 */
				if ($cate_parent_id > 0)  {
					$data['cate_parent_id'] = $cate_parent_id;
				}	
				
				if (!$data['cate_url']) {
					$data['cate_url']  = '/' . Shendou_Pinyin::to($cate_name, true) . '/';
				}	
		
				$id  = $this->categories->add($data);
				
				if ($id == -1) {
					$this->showMsg(0, null, '栏目添加失败！');
				} else if ($id == -2) {
					$this->showMsg(0, null, '专题设置失败！');
				} else if ($id == 0) {
					$this->showMsg(0, null, '系统错误！');
				}
			}
			
			$this->showMsg(1, null, '添加成功！');
		}
		
		include $this->load('add_or_update_categories');
		
	}

	public function batchAddAction()
	{
		//$cates = $this->getCateHtml();
		$ret = $this->db->query('select id,cate_name,cate_parent_id,cate_level from skytech_categories order by cate_sort')->toArray();
		
		$temp = $this->getMenuTree($ret, 0);
		$cates = $this->createOptions($temp);
		
		if ($this->mRequest->isPost()) {
			$cateParentId = $this->mRequest->cate_parent_id;
			$cateListTemplate = $this->mRequest->cate_list_template;
			$cateArticleTemplte = $this->mRequest->cate_article_templte;
			
			$cates = $this->mRequest->getPost('data');	
			
			foreach($cates as $item) {
				if (!$item['cate_name']) {
					continue;
				}
				
				$data = array(
					'cate_parent_id' => $cateParentId,
					'cate_list_template' => $cateListTemplate,
					'cate_article_templte' => $cateArticleTemplte,
					'cate_name' => $item['cate_name'],
					'cate_sort' => $item['cate_sort'],
					'cate_url' => '/' . Shendou_Pinyin::to($item['cate_name'], true) . '/'
				);
				
				$this->categories->add($data);
			}
			
			$this->mResponse->redirect($this->mRouter->urlEx($this->C, ''));
		}
		
		include $this->load('add_batch_categories');
	}

	public function deleteAction()
	{
		$id = trim($this->mRequest->id);
		
		if (!Lamb_Utils::isInt($id, true)) {
			return;
		}

		if ($this->categories->delete($id)) {
			$url = $this->mSiteCfg['dynamic_url']['categories_index'];
			$this->mResponse->eecho("<script>window.location.href='$url';</script>");		
			return;
		}
		
		include $this->load('error');
	}

	
	/**
	 * 创建html
	 */
	public function createHtml($tree)
    {
        $html = "";
		if (empty($tree)){
			return $html;
		}
		
		$article_index_url = $this->mSiteCfg['dynamic_url']['article_index'];
		
       	foreach($tree as $key => $t)
        {
            if(!$t['parent_id'])
            {
                $html .= "<li class='dd-item dd-item item-blue2' data-id={$t['id']}>";
                $html .= "<div class='dd-handle'><a href='{$article_index_url}/cid/{$t['id']}/cname/{$t['cate_name']}'>{$t['cate_name']}</a><span>&nbsp; ID: {$t['id']}</span>";
                $html .= "<div class='pull-right action-buttons' id={$t['id']}>";
				
				if (!$t['cate_status']) {
					$html .= "<a title='隐藏'><i class='ace-icon fa fa-eye-slash bigger-130'></i></a>";
				}
				
				if ($t['cate_is_topic']) {
					$html .= "<a title='专题'><i class='ace-icon fa fa-bookmark bigger-130'></i></a>";
				}
				
				$html .= "<a class='add_sub_catag' title='添加子栏目' cate_name='{$t['cate_name']}'><i class='ui-icon ace-icon fa fa-plus-circle purple'></i></a>";
				$html .= "<a class='blue update_catag'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
				$html .= "<a class='red del_catag'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
				$html .= "</div></div></li>";
            }
            else
            {
        
                $html .= "<li class='dd-item' data-id={$t['id']}>";
                $html .= "<div class='dd-handle'><a href='{$article_index_url}/cid/{$t['id']}/cname/{$t['cate_name']}'>{$t['cate_name']}</a><span>&nbsp; ID: {$t['id']}</span>";

                $html .= "<div class='pull-right action-buttons' id={$t['id']}>";
				if (!$t['cate_status']) {
					$html .= "<a title='隐藏'><i class='ace-icon fa fa-eye-slash bigger-130'></i></a>";
				}
				
				if ($t['cate_is_topic']) {
					$html .= "<a title='专题'><i class='ace-icon fa fa-bookmark bigger-130'></i></a>";
				}
				$html .= "<a class='add_sub_catag' title='添加子栏目'><i class='ui-icon ace-icon fa fa-plus-circle purple'></i></a>";
                $html .= "<a class='blue update_catag' cate_name='{$t["cate_name"]}'><i class='ace-icon fa fa-pencil bigger-130'></i></a>";
				$html .= "<a class='red del_catag'><i class='ace-icon fa fa-trash-o bigger-130'></i></a>";
				$html .= "</div></div>";
                $html .= "<ol class='dd-list'>" .$this->createHtml($t['parent_id']) . "</ol>";
                $html = $html."</li>";
            }
        }

        return $html;
    }
}	
?>

