<?php
class Shendou_Collect_MadeInChina_List extends Shendou_Collect_Abstract
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function getUrl($keywords, $page = 1)
	{
		return  "http://sourcing.made-in-china.com/sourcingrequest?keyword=" . urlencode($keywords) . "&sort=post_date_desc&page={$page}&type=keyword";
	}
	
	public function collect($url, $external = null, &$error = null)
	{
		$ret = null;
		if (!($html = Lamb_Utils::fetchContentByUrlH($url))) {
			$error = self::E_NET_FAIL;
			return $ret;	
		}
		
		if (!preg_match_all('/<h6 class="title">.*?<a href="(.*?)".*?>(.*?)<\/a>.*?class="country">(.*?)<\/span>.*?class="price">.*?Purchase Quantity.*?<\/span>(.*?)<\/div>.*?class="desc">(.*?)<\/p>.*?class="date">(.*?)<\/p>.*?class="qty">(.*?)<\/div>.*?date2">(.*?)<\/p>/is', $html, $result, PREG_SET_ORDER)) {
			$error = self::E_RULE_NOT_MATCH;	
			return $ret;
		}
		
		foreach($result as $key => $item) {

			$ret[$key]['purchase_url'] = trim($item[1]);
			$ret[$key]['purchase_name'] = trim($this->filterHtmlTag($item[2]));
			$ret[$key]['purchase_request'] = trim($this->filterHtmlTag($item[3]));
			$ret[$key]['purchase_quantity'] = $this->trimall($this->filterHtmlTag($item[4]));
			$ret[$key]['purchase_description'] = trim($this->filterHtmlTag($item[5]));
			$ret[$key]['purchase_post_date'] = trim($this->filterHtmlTag($item[6]));
			$ret[$key]['purchase_quote_left'] = trim($this->filterHtmlTag($item[7]));
			$ret[$key]['purchase_valid_date'] = trim($this->filterHtmlTag($item[8]));
		}
		
		$error = self::S_OK;
		return $ret;
	}
}