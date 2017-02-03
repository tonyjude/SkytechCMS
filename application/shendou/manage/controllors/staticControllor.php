<?php
class staticControllor extends Shendou_Controllor_ManageAbstract
{
	public function getControllorName()
	{
		return 'static';
	}
	
	public function indexAction()
	{
		$opaction = trim($this->mRequest->opac);
		$action = trim($this->mRequest->ac);
		$id = trim($this->mRequest->id);
		$cid = trim($this->mRequest->cid);
		$pagesize = trim($this->mRequest->psi);
		$intervalSecond = trim($this->mRequest->is);
		$limit = trim($this->mRequest->limit);
		$sdate = trim($this->mRequest->sd);
		$edate = trim($this->mRequest->ed);
		
		if ($opaction == 'run') {
			if (!Lamb_Utils::isInt($intervalSecond, true)) {
				$intervalSecond = 2;
			}
			
			if (!Lamb_Utils::isInt($pagesize, true)) {
				$pagesize = $this->mSiteCfg['webInfo']['static']['pagesize'];
			}	
			
			$urlparam = array('is' => $intervalSecond, 'psi' => $pagesize, 'limit' => $limit );
			
			switch ($action) {
				case 'index':					
					break;
				case 'topictask':
					break;	
				case 'item' :
					if ($sdate && $edate) {
						if (strtotime($sdate) > strtotime($edate)) {
							$this->mResponse->eecho("<script>alert('更新起始时间不能比结束时间早')</script>");
						}
					}
					
					if (!empty($sdate) && $sdate != '0' && strtotime($sdate) === false) {
						$this->mResponse->eecho("<script>alert('更新起始时间格式不正确')</script>");
					} else if ($sdate != '0') {
						$urlparam['sd'] = $sdate;
					} else if ($sdate == '0') {
						$urlparam['sd'] = '0';
					}
	
					if (!empty($edate) && $edate != '0' && strtotime($edate) === false) {
						$this->mResponse->eecho("<script>alert('更新结束时间格式不正确')</script>");
					} else if ($edate != '0') {
						$urlparam['ed'] = $edate;
					} else if ($edate == '0') {
						$urlparam['ed'] = '0';
					}
					
					$urlparam['id'] = $id;
					break;
				case 'list':
					if (!Lamb_Utils::isInt($id, true) || !$id) {
						$this->mResponse->eecho("<script>alert('请选择栏目分类')</script>");
					}
					$urlparam['id'] = $id;
					break;
				case 'listtask':
					break;
			}

			$urlparam['ac'] = $action;
			$url = $this->getClientUrl('looper', 'createhtml', $urlparam);
			
			$this->mResponse->redirect($url);
		}
		
		$sdate = date('Y-m-d 00:00');
		$edate = date('Y-m-d 23:59');
		$cates = $this->getCateHtml();	
		include $this->load('static_index');
		
	}

}