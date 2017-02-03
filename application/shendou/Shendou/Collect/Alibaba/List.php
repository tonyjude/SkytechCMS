<?php
class Shendou_Collect_Alibaba_List extends Shendou_Collect_Abstract
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function getUrl($keywords, $page = 1)
	{
		return  "https://sourcing.alibaba.com/rfq_search_list.htm?searchText=" . urlencode($keywords) . "&recently=Y&page=" . $page;
	}
	
	public function collect($url, $external = null, &$error = null)
	{
		$ret = null;
		if (!($html = Lamb_Utils::fetchContentByUrlH($url))) {
			$error = self::E_NET_FAIL;
			return $ret;	
		}
		
		if (!preg_match_all('/class="item-main".*?<a.*?href="(.*?)">(.*?)<\/a>.*?class="item-digest">(.*?)<\/div>.*?class="item-info".*?>Date Posted: (.*?)<span.*?item-other-count">.*?title="(.*?)".*?class="country-flag.*?title="(.*?)".*?Quotes Left: <span>(.*?)</is', $html, $result, PREG_SET_ORDER)) {
			$error = self::E_RULE_NOT_MATCH;	
			return $ret;
		}
		
		foreach($result as $key => $item) {
			/*
			if (trim($item[4]) == date('Y-m-d')) {
				$error = self::E_DATA_ERROR;
				break;
			}
			*/
			
			$ret[$key]['purchase_url'] = trim($item[1]);
			$ret[$key]['purchase_name'] = trim($this->filterHtmlTag($item[2]));
			$ret[$key]['purchase_description'] = trim($this->filterHtmlTag($item[3]));
			$ret[$key]['purchase_post_date'] = trim($item[4]);
			$ret[$key]['purchase_quantity'] = trim($item[5]);
			$ret[$key]['purchase_request'] = trim($item[6]);
			$ret[$key]['purchase_quote_left'] = trim($item[7]);
			
		}
		
		$error = self::S_OK;
		return $ret;
	}
}