<?php
abstract class Shendou_Controllor_Abstract extends Lamb_Controllor_Abstract
{
	/**
	 * @var string current Controllor;
	 */
	public $C;
	
	/**
	 * @var string current Action
	 */
	public $A;
	
	/** 
	 * @var array
	 */
	protected $mSiteCfg;
	
	/**
	 * @var string
	 */
	protected $mRuntimeTemplate;
	
	/**
	 * @var string
	 */
	protected $mHash;
	
	/**
	 * @var string
	 */	
	protected $mRefer;
			
	
	public function __construct()
	{
		parent::__construct();
		$this->mSiteCfg = Lamb_Registry::get(CONFIG);
		$this->C = $this->mDispatcher->setOrGetControllor();
		$this->A = $this->mDispatcher->setOrGetAction();
		$this->mRefer = $this->mRequest->getServer('HTTP_REFERER', '');	
		$this->mHash = spl_object_hash($this);
		Lamb_Utils::registerCallObject($this);			
	}
	
	/**
	 * @param string $filename
	 * @return string
	 */
	public function load($filename)
	{
		return $this->mView->load($filename, $this->mRuntimeTemplate);		
	}
	
	/**
	 * @return string
	 */
	public function autoload()
	{
		return $this->load($this->C . '_' . $this->A);
	}
	
	/**
	 * 递归获取网站栏目
	 */
	public function getMenuTree($data, $pId)
    {
        $tree = '';
		
        foreach($data as $k => $v)
        {
            if($v['cate_parent_id'] == $pId)
            {   //父亲找到儿子
                $v['parent_id'] = $this->getMenuTree($data, $v['id']);
                $tree[] = $v;
                //unset($data[$k]);
            }
        }

        return $tree;
    }
	
	
	/**
	 * 创建options
	 */
	public function createOptions($tree, $cid=0)
    {
        $html = "";
		if (empty($tree)){
			return $html;
		}
		
       	foreach($tree as $key => $t)
        {
            if(!$t['parent_id'])
            {
                $html .= "<option value={$t['id']} " . ($cid == $t['id'] ? "selected='selected'" : '') .  ">";
				$html .=  str_repeat('─', $t['cate_level']-1) . $t['cate_name'];
				$html .= "</option>";
		
            }
            else
            {
            	$html .= "<option value={$t['id']} " . ($cid == $t['id'] ? "selected='selected'" : '') .  ">";
				$html .=  str_repeat('─', $t['cate_level']-1) . $t['cate_name'] . "</option>";
               	$html .=  $this->createOptions($t['parent_id'], $cid);
            }
        }

        return $html;
    }
	
	public function redirect($url)
	{
		 echo "<script language='javascript' type='text/javascript'>
				 function redirect() 
				 {
					 window.location.href('$url');
				 }
				 window.setTimeout('redirect();', 2000);
			 </script>";
		
		exit;
	}
		
	public function showResults($code, array $data = null, $errorString = '')
	{
		static $fixedErrorStr = array(
			'0' => 'Server is busy, please try again later'
		);
		
		$ret = array('s' => $code);
		
		if ($data) {
			$ret['d'] = $data;
		}
		
		if (!$errorString && isset($fixedErrorStr[$code])) {
			$errorString = $fixedErrorStr[$code];
		}
		
		$ret['err_str'] = $errorString;
		
		$ret = json_encode($ret);
		$this->mResponse->eecho($ret);	
	}
		
	public function d($data)
	{
		Lamb_Debuger::debug($data);
	}
}