<?php
abstract class Shendou_Model
{
	protected $mApp;
	
	protected $mRequest;
	
	protected $mResponse;
	
	protected $mRouter;
	
	protected $mDispatcher;
	
	protected $mSiteCfg;
	
	public function __construct()
	{
		$this->mApp = Lamb_App::getGlobalApp();
		$this->mRequest = $this->mApp->getRequest();
		$this->mResponse = $this->mApp->getResponse();
		$this->mRouter = $this->mApp->getRouter();
		$this->mDispatcher = $this->mApp->getDispatcher();
		$this->mSiteCfg = Lamb_Registry::get(CONFIG);
	}
}