<?php
abstract class Shendou_Collect_Abstract implements Shendou_Collect_Interface
{
	protected $mChannelid;
	
	public function __construct()
	{
		
	}
	
	/**
	 * 设置分类ID
	 */
	public function setChannelid($channelid = null)
	{
		if (null === $channelid) {
			return $this->mChannelid;
		}
		
		$this->mChannelid = (int)$channelid;
		return $this;
	}
	
	public function filterHtmlTag($content, $replaceMent = '')
	{
		return preg_replace('/(<(\/)?[^>]*>)/is', $replaceMent, $content);	
	}
	
	public function trimall($str)//删除空格
	{
    	$qian=array(" ","　","\t","\n","\r");
    	$hou=array("","","","","");
    	return str_replace($qian,$hou,$str);    
	}	
	

}