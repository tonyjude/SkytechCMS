<?php
class templateControllor extends Shendou_Controllor_ManageAbstract
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
		return 'template';
	}
	
	public function indexAction()
	{
		$ret = Lamb_IO_File::getFileList(APP_PATH . 'views/default/');
		
		include $this->autoload();	
	}
	
	public function templateAction()
	{
		$path = trim($this->mRequest->path);
		if (!$path) {
			return;
		}
		
		$realPath = APP_PATH . 'views/default/' . $path;
		if ($this->mRequest->isPost()) {
			$content = trim($this->mRequest->getPost('content'));
			if (!Lamb_IO_File::putContents($realPath, $content)) {
				$this->showMsg(1, null, '没有权限，保存失败！');	
			}
			
			$this->showMsg(1, null, '保存成功！');	
		}

		$content = Lamb_IO_File::getContents($realPath);
		
		include $this->load('template_info');	
	}
}