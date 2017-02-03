<?php
class Shendou_Utils
{
	const FETCH_MODE_CURL = 1;
	
	const FETCH_MODE_HTTP = 2;
	
	const FETCH_MODE_FILE = 4;
	
	const TABLE_MOVIE_SOURCE = 1;
	
	const TABLE_MOVIE_CATE = 2;
	
	

	/**
	 * @param string $url
	 * @param int $connectTimeout
	 * @param int $type enum[FETCH_MODE_CURL,FETCH_MODE_HTTP,FETCH_MODE_FILE]
	 * @return string
	 */
	public static function fetchContentByUrl($url, $connectTimeout = 10, $type = self::FETCH_MODE_CURL)
	{
		switch($type) {
			case self::FETCH_MODE_HTTP:
				return self::fetchContentByUrlH($url, $connectTimeout);
			case self::FETCH_MODE_FILE:
				return file_get_contents($url);
			default:
				return self::fetchContentByUrlC($url, $connectTimeout);
		}
	}
	
	/**
	 * @param string $url
	 * @param int $connectTimeout
	 * @return string
	 */
	public static function fetchContentByUrlC($url, $connectTimeout = 10)
	{
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;		
	}
	
	/**
	 * @param string $url
	 * @param int $connectTimeout
	 * @return string
	 */	
	public static function fetchContentByUrlH($url, $connectTimeout = 20)
	{
		$ret = Tmovie_Http::quickGet($url, $connectTimeout, false, $status);
		if ($status == 200) {
			return $ret;
		}
		return '';
	}
	
	/**
	 * @param string $content
	 */
	public static function filterCollectContent(&$content)
	{
		$aPatt = array(
			'/<script.*?>.*?<\/script>/is',
			'/<iframe.*?>.*?<\/iframe>/is',
			'/<object.*?>.*?<\/object>/is',
			'/<a.*?>.*?<\/a>/is',
			'/style\=".*?"/is'
		);
		foreach ($aPatt as $item) {
			$content = preg_replace($item, '', $content);
		}	
		unset($content);
	}
	
	/**
	 * @param string $content
	 * @param string $replaceMent
	 * @return string
	 */
	public static function filterHtmlTag($content, $replaceMent = '')
	{
		return preg_replace('/(<(\/)?[^>]*>)/is', $replaceMent, $content);	
	}
	
	/**
	 * 生成密码的salt，防止密码hash碰撞 
	 *
	 * @param int $min
	 * @param int $max
	 * @return string
	 */
	public static function createSalt($min = 5, $max = 10)
	{
		$ret = '';
		if ($min > $max) {
			$max = $min;
		}
		$key = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$len = rand($min, $max);
		$salt_len = strlen($key) - 1;
		for ($i = 1; $i <= $len; $i ++) {
			$ret .= $key{rand(0, $salt_len)};
		}
		return $ret;
	}
	
	public static function strlength($str)
	{
		return (strlen($str) + mb_strlen($str,'UTF8')) / 2; 
	}	
	
	/**
	 * 模拟登陆
	 */
	public static function curl($cookie,$userAgent, $destURL, $paramStr='', $flag='get', $ip='110.85.5.78',$referer='http://seo.chinaz.com/yahoo.com')
	{  
   		$curl = curl_init();  
	    if($flag == 'post') {	//post传递  
	        curl_setopt($curl, CURLOPT_POST, 1);  
	        curl_setopt($curl, CURLOPT_POSTFIELDS, $paramStr);  
	    } 
		 
	    curl_setopt($curl, CURLOPT_URL, $destURL);	//目的地址  
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$ip, 'CLIENT-IP:'.$ip));  //构造IP  
	    curl_setopt($curl, CURLOPT_REFERER, $referer);  
	    curl_setopt($curl, CURLOPT_TIMEOUT, 10);	//10s超时时间  
	      
	    curl_setopt ($curl, CURLOPT_USERAGENT, $userAgent);  
	    //curl_setopt ($curl, CURLOPT_COOKIEJAR, $cookie);  
	    curl_setopt ($curl, CURLOPT_COOKIEFILE, $cookie);  
	      
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);  
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
	    $str = curl_exec($curl);  
	    curl_close($curl); 
		 
	    return $str;  
	} 
}