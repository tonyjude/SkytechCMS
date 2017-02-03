<?php
class Shendou_Collect_MadeInChina_Item extends Shendou_Collect_ItemAbstract
{
	public function __construct()
	{
		
	}
		
	public $sPatt = array(
		'name'    => '/class="base_name"><h1>(.*?)<\/h1>/is',	                          		
	
	);
	
	public function collectItem($url, $mark, $source)
	{
		$patt = $this->sPatt;
		$ret = array(
			'name' => '',
			'actors' => '不详',
			'directors' => '不详',
			'tag' => '不详',
			'year' => 0,
			'area' => '其他',
			'update_time' => time(),
			'mark' => '',
			'description' => '不详',
			'play_data' => '',
			'is_end' => 0,
			'type' => 4
		);
		
		if (!Lamb_Utils::isHttp($url)) {
			return $ret;
		}
		
		if (! ($html = Lamb_Utils::fetchContentByUrlH($url))) {
			return $ret;
		}
		
		foreach (array('name', 'year', 'pic', 'actors', 'area', 'tag', 'description', 'channel') as $key) {
			if (preg_match($patt[$key], $html, $result)) {
				$ret[$key] = trim($result[1]);
			}
		}
		 
		
		if (!isset($ret['channel']) || empty($ret['channel'])) {
			return $ret;
		}
		
		
		$ret['mark'] = $mark;
		$ret['actors'] = $this->filterHtmlTag($ret['actors']);
		$ret['actors'] = str_replace("/" , " ", $ret['actors']);
		$ret['tag']    = str_replace("/" , " ", $ret['tag']);
		$ret['description'] = $this->filterHtmlTag($ret['description']);


		
		return $ret;
	}
	
	

	
}
