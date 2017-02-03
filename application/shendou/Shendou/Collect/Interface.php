<?php
interface Shendou_Collect_Interface
{
	const S_OK = 1;
	
	const E_NET_FAIL = -1;
	
	const E_RULE_NOT_MATCH = -2;
	
	const E_DATA_ERROR = -4;
	
	
	
	
	/**
	 * @param int $page
	 * @return string
	 */
	public function getUrl($page);
	
	/**
	 * @param string $url
	 * @param array $externals
	 * @param array
	 */
	public function collect($url, $externals = null, &$error = null);
}