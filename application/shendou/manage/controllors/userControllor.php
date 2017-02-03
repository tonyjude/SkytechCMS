<?php
class userControllor extends Shendou_Controllor_ManageAbstract
{
	private $user = null;
	public function __construct()
	{
		parent::__construct();	
		$this->user = new Shendou_Model_User();
		if (!in_array($this->A, array('login', 'loginout'))) {
			$this->checkPurview();
			$this->getPurview();
		}
	}
	
	public function getControllorName()
	{
		return 'user';
	}
	
	
	public function indexAction()
	{
		$page = trim($this->mRequest->p);
		$page = Lamb_Utils::isInt($page, true) ? $page : 1;
			
		$sql = "select * from skytech_user ";	
		
		$prevPageUrl  = $this->mRouter->urlEx('user', '', array('p' =>  $page-1));
		$nextPageUrl  = $this->mRouter->urlEx('user', '', array('p' => $page+1));

		$pageUrl = $this->mRouter->urlEx('user', '');

		include $this->autoload();
	}
	
	public function groupAction()
	{
		$sql = "select * from skytech_role";	
		
		include $this->autoload();
	}
	
	public function addOrUpdateAction()
	{
		if ($this->mRequest->isPost()) {
			
			$data = $this->mRequest->getPost('data');
			if ($data['user_name'] == '') {
				$this->showMsg(-3, null, '用户名称不能为空！');
			}
			
			if (strlen($data['user_name']) > 100 ) {
				$this->showMsg(-4, null, '用户名称长度不能超过100！');
			}
			
			if ($data['user_password'] == '') {
				$this->showMsg(-5, null, '密码不能为空！');
			}
			
			if (strlen($data['user_password']) > 100 ) {
				$this->showMsg(-6, null, '密码长度不能超过100！');
			}
			
			$data['rigister_time'] = date('Y-m-d H:i:s');
			$data['user_password'] = md5($data['user_password']);
			
			$id = $this->user->add($data);
			if ($id) {
				$this->showMsg(1, null, '添加成功！');
			}
			
			$this->showMsg(0, null, '系统错误，请联系系统管理员！');
		}

		include $this->load('add_or_update_user');
	}
	
	
	/**
	 *  用户组权限设置
	 * 
	 */
	public function setAction()
	{
		$id = trim($this->mRequest->id);
		if (!Lamb_Utils::isInt($id, true)) {
			$id = 0;
		}
		
		if ($this->mRequest->isPost()) {
			$data = $this->mRequest->getPost('purviews');
			$id = $this->mRequest->getPost('id');
			
			if ($this->user->updatePurviews($id, $data)) {
				$this->showMsg(1, null, '保存成功!');
			}
			
			$this->showMsg(0, null, '保存失败!');
		}
		
		$data  = $this->db->query('SELECT id,menu_name,menu_url,menu_parent_id FROM skytech_menu')->toArray();
		$menus = $this->db->query('select menu_id from skytech_relation where role_id = ' . $id)->toArray();
		
		$ret = array();
		foreach($menus as $item){
			$ret[] = $item['menu_id'];
		}
		
		foreach($data as $key => $item) {
			if (in_array($item['id'], $ret)) {
				$data[$key]['check'] = 1;				
			} else {
				$data[$key]['check'] = 0;	
			}	
		}
		
		$tree = $this->getTree($data, 0);
		
		$purviews = $this->procPurviews($tree);
		
		include $this->autoload();
	}
	
	
	public function changeAction()
	{
		$id = trim($this->mRequest->id);
		$id = Lamb_Utils::isInt($id, true) ? $id : 0;
		$this->db->exec('update skytech_user set status = !status WHERE id=' . $id);
		echo 1;
	}
	
	public function procPurviews($tree)
    {
        $html = '';
		
        foreach($tree as $key => $t) {
        	$check = $t['check'] ? 'checked=checked' : '';
        	
            if(!$t['parent_id']) {
                $html .= "<li>";
                $html .= "<label><input type='checkbox' value='{$t['id']}' name='purviews[]'  " . $check . " class='ace'><span class='lbl'></span></label>";
                $html .= "<span class='menu-text'>{$t['menu_name']}</span>";
                $html .= "</li>";
            } else  { 
                $html .= "<li>";
                $html .= "<label><input type='checkbox' value='{$t['id']}' name='purviews[]' " . $check . " class='ace'><span class='lbl'></span></label>";
                $html .= "<span class='menu-text'>{$t["menu_name"]}</span>";
                $html .= "<ul class='submenu nav-show p_submenu clearfix'>" .$this->procPurviews($t['parent_id']) . "</ul>";
                $html = $html."</li>";
            }
        }

        return $html;
    }

}