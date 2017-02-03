<?php
/**
 * Lamb Framework
 * @author 小羊
 * @package Lamb
 */
class Lamb_Utils
{
	const OBJECT_CALL_RET_ERROR = 0xffff;
	
	/**
	 * @var array
	 */
	protected static $sSingleInstanceMaps = array();
	
	/**
	 * @var array
	 */
	protected static $sObjectCallHashs = array();


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
		$ret = Lamb_Http::quickGet($url, $connectTimeout, false, $status);
		if ($status == 200) {
			return $ret;
		}
		return '';
	}
	
	/**
	 * 多字节版的substr
	 *
	 * @param string $str 要操作的字符串
	 * @param int $start
	 * @param int $len
	 * @return string
	 */
	public static function mbSubstr($str, $start)
	{
		preg_match_all("/[\x80-\xff]?./",$str,$ar);
		if(func_num_args() >= 3) {
		    $end = func_get_arg(2);
		    return join("",array_slice($ar[0],$start,$end));
		}else
		    return join("",array_slice($ar[0],$start));	
	}
	
	/**
	 * 多字节版的strlen
	 *
	 * @param string $str
	 * @return int
	 */
	public static function mbLen($str)
 	{
		preg_match_all("/[\x80-\xff]?./",$str,$ar);
		return count($ar[0]);
	}
	
	/**
	 * 带密钥的加密解密方法
	 *
	 * @param string $string
	 * @param string $key
	 * @param string $operation 加密 DECODE 解密 ENCODE
	 * @param int $expriy 有效期
	 * @return string
	 */
	public static function authcode($string, $key, $operation = 'DECODE',  $expiry = 0, $ckey_length = 7) 
	{	
		$key = md5($key);	
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
	
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
	
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
	
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
	
		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
					return '';
				}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	
	}
	
	/**
	 * @param string $str
	 * @return string
	 */
	public static function crc32FormatHex($str)
	{
		return sprintf("%0xd", crc32($str));
	}
	
	/**
	 * @param int $feed
	 * @return string
	 */
	public static function getRandString($feed = 10000)
	{
		return microtime(1).rand(1,$feed);
	}
	
	/**
	 * 用于一些带有默认配置的选项
	 *
	 * @param & array $arrDefault
	 * @param array $arrSrc
	 * @return void
	 */
	public static function setOptions(&$arrDefault, $arrSrc)
	{
		foreach($arrSrc as $k => $v){
			$arrDefault[$k]		=	$v;
		}
		unset($arrDefault);
	}	
	
	/**
	 * @param string $str
	 * @return boolean
	 */
	public static function isEmail($str)
	{
		return preg_match('/^[\w]+@[\w\-]+(\.[a-zA-Z]+)+$/is', (string)$str);
	}	
	
	/**
	 * @param string $str
	 * @return boolean
	 */
	public static function isHttp($str)
	{
		return !empty($str) && strtolower(substr((string)$str, 0, 7)) == 'http://';
	}
	
	/**
	 * 判断源字符串是否为整数如果参数
	 * $bPostive为true，则判读是否正整数
	 *
	 * @param string $str
	 * @param boolean $bPostive
	 * @return boolean
	 */
	public static function isInt($str, $bPostive = false)
	{
		return preg_match($bPostive ? '/^\d+$/s' : '/^-?\d+$/s', (string)$str);
	}
	
	/**
	 * 判断$str是否为数字包括整数小数，
	 * 如果第二个参数为true，则判断$str是否正的数字
	 *
	 * @param string $str
	 * @param boolean $bPostive
	 * @return boolean
	 */
	public static function isNumber($str, $bPostive = false)
	{
		return $bPostive ? preg_match('/^((\d+\.\d+)|(\d+))$/s', (string)$str) : is_numeric($str);
	}

	/**
	 * @param object $object
	 * @return void
	 */
	public static function registerCallObject($object)
	{
		self::$sObjectCallHashs[spl_object_hash($object)] = $object;
	}
	
	/**
	 * @param object $object
	 * @return void
	 */
	public static function unregisterCallObject($object)
	{
		$hash = spl_object_hash($object);
		if (array_key_exists($hash, self::$sObjectCallHashs)) {
			unset(self::$sObjectCallHashs[$hash]);
		}
	}
	
	/**
	 * @param string $hash
	 * @param string $method
	 * @param array $param
	 * @return mixed
	 */
	public static function objectCall($hash, $method, array $param = null)
	{
		$objectHashs = self::$sObjectCallHashs;
		if (array_key_exists($hash, $objectHashs)) {
			return $param === null ? call_user_func(array($objectHashs[$hash], $method)) : 
						call_user_func_array(array($objectHashs[$hash], $method), $param);
		}
		return self::OBJECT_CALL_RET_ERROR;
	}
	
	/**
	 * @param string $class
	 * @param array $param
	 * @param boolean $reset
	 * @return object
	 */
	public static function getSingleInstance($class, array $param = array(), $reset = false)
	{
		$hash = self::crc32FormatHex($class . print_r($param, true));
		
		if (!$reset && array_key_exists($hash, self::$sSingleInstanceMaps) && self::$sSingleInstanceMaps[$hash]) {
			return self::$sSingleInstanceMaps[$hash];
		}
		
		$ref = new ReflectionClass($class);
		$obj = $ref->newInstanceArgs($param);
		self::$sSingleInstanceMaps[$hash] = $obj;
		return $obj;
	}	
	
	/**
	 * @param string $string
	 * @return int
	 */
	public static function isUtf8($string)
	{
		return preg_match('%^(?:
			 [\x09\x0A\x0D\x20-\x7E]            # ASCII
		   | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
		   |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
		   | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
		   |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
		   |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
		   | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
		   |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
	   )*$%xs', $string);
	}

	/**
	 * 将汉字转换成拼音
	 * 此类是根据ASCII码转换，GB2312库对多音字也无能为力，此类优点是性能比较高。
	 * GB2312标准共收录6763个汉字，此类的算法只支持其中的一级汉字3755个，不在范围内的汉字是无法转换，如：中国前总理朱镕基的“镕”字。
	 * @param string $s
	 * @param boolean $isfirst
	 * @return string
	 */
	public static function pinyin($s, $isfirst = false) 
	{
		
	}
}