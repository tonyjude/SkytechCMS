<?php
class navigationControllor extends Shendou_Controllor_ManageAbstract
{
	private $categories = null;
	private $navigation = null;
	public function __construct()
	{
		parent::__construct();
		$this->categories = new Shendou_Model_Categories;
		$this->navigation = new Shendou_Model_Navigation;
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
			$this->getPurview();
		}
	}
	
	public function getControllorName()
	{
		return 'navigation';
	}
	
	public function indexAction()
	{
		$data = $this->db->query('select * from skytech_cate_navigation')->toArray();
		
		$data = $this->getMenuTree($data, 0);
		
		$categories = $this->createHtml($data);
		
		include $this->load('navigation');
	}
	
	/**
	 * 添加或修改菜单
	 */
	public function addOrUpdateAction()
	{
		$id = trim($this->mRequest->id);
		$nav_id = trim($this->mRequest->nav_id);
		
		if ($nav_id) {
			$nav_info = $this->navigation->get($nav_id);
		}
				
		if ($this->mRequest->isPost()) {
				
			$data = $this->mRequest->getPost('data');
			$cate_parent_id = $this->mRequest->getPost('cate_parent_id');
			
			$nav_id = $data['nav_id'];
			$cate_name = $data['cate_name'];
			unset($data['nav_id']);
			if ($cate_name == '' || Shendou_Utils::strlength($cate_name) > 100) {
				$this->showMsg(-1, null, '菜单名称长度不能超过100！');
			}
			
			if (!Lamb_Utils::isInt($data['cate_sort'])) {
				$this->showMsg(-2, null, '菜单排列顺序有误！');
			}
			
			if (Shendou_Utils::strlength($data['cate_seo_title']) > 250 ) {
				$this->showMsg(-2, null, '菜单SEO长度不能超过250！');
			}
			
			if (Shendou_Utils::strlength($data['cate_keywords']) > 250 ) {
				$this->showMsg(-3, null, '菜单关键字长度不能超过250！');
			}
			
			if (Shendou_Utils::strlength($data['cate_description']) > 500 ) {
				$this->showMsg(-4, null, '菜单描述不能超过500！');
			}
			
			if (!Lamb_Utils::isInt($data['cate_parent_id'], true)) {
				$data['cate_parent_id'] = 0;
			}
			
			$data['cate_url'] = '/' . Shendou_Pinyin::to($cate_name, true) . '/';
			
			if ($nav_id) {
				$this->navigation->update($nav_id, $data);
			} else {
				
				/**
				 * 如果是顶级菜单，栏目保存路径就是菜单的拼音， 如果是子菜单， 路径则是 父栏菜单拼音/子菜单拼音
				 */
				if ($cate_parent_id == 0)  {
					if (!$data['cate_url'] || strlen($data['cate_url']) == 0) {
						$data['cate_url'] = '/' . Shendou_Pinyin::to($cate_name, true) . '/';
					} 
				} else {
					$data['cate_parent_id'] = $cate_parent_id;
					$ret = $this->navigation->get($cate_parent_id, 'cate_url');
					$data['cate_url'] = $ret['cate_url'] . Shendou_Pinyin::to($cate_name, true) . '/';
				}
				
				$id  = $this->navigation->add($data);

				if (!$id) {
					$this->showMsg(0, null, '系统错误！');
				}
			}
			
			$this->showMsg(1, null, '添加成功！');	
		}
		
		include $this->load('add_or_update_navigation');
	}
	
	/**
	 * 删除菜单
	 */
	public function deleteAction()
	{
		$id = trim($this->mRequest->id);
		
		if (!Lamb_Utils::isInt($id, true)) {
			return;
		}

		if ($this->navigation->delete($id)) {
			$url = $this->mSiteCfg['dynamic_url']['navigation_index'];
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

       	foreach($tree as $key => $t)
        {
            if(!$t['parent_id'])
            {
                $html .= "<li class='dd-item dd-item item-red' data-id={$t['id']}>";
                $html .= "<div class='dd-handle'><a href='{$t['cate_url']}'>{$t['cate_name']}</a>";
                $html .= "<div class='pull-right action-buttons' id={$t['id']}>";
				$html .= "<a class='add_sub_menu' title='添加子菜单' cate_name='{$t['cate_name']}'><i class='glyphicon glyphicon-plus'></i></a>";
				$html .= "<a class='blue update_menu' title='编辑菜单'><i class='glyphicon glyphicon-edit'></i></a>";
				$html .= "<a class='red del_menu' title='删除菜单'><i class='glyphicon glyphicon-trash'></i></a>";
				$html .= "</div></div></li>";
            }
            else
            {
        
                $html .= "<li class='dd-item' data-id={$t['id']}>";
                $html .= "<div class='dd-handle'><a href='#'>{$t['cate_name']}</a>";
                $html .= "<div class='pull-right action-buttons' id={$t['id']}>";
				$html .= "<a class='add_sub_menu' title='添加子菜单'><i class='glyphicon glyphicon-plus'></i></a>";
                $html .= "<a class='blue update_menu' title='编辑子菜单' cate_name='{$t["cate_name"]}'><i class='glyphicon glyphicon-edit'></i></a>";
				$html .= "<a class='red del_menu'  title='删除子菜单'><i class='glyphicon glyphicon-trash'></i></a>";
				$html .= "</div></div>";
                $html .= "<ol class='dd-list'>" .$this->createHtml($t['parent_id']) . "</ol>";
                $html = $html."</li>";
            }
        }

        return $html;
    }
}

?>