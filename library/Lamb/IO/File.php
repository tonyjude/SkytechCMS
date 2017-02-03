<?php
/**
 * Lamb Framework
 * @author LAMB
 * @package Lamb_IO
 */
class Lamb_IO_File
{
	/**
	 * @var source 
	 */
	protected $_mFileHandle = null;
	
	/**
	 * @var string 
	 */
	protected $_mPath = '';
	
	/**
	 * @param string $path
	 * @param string $mode
	 */
	public function __construct($path = '', $mode = '')
	{
		if ($path) {
			$this->setOrGetPath($path);
		}
			
		if ($path && $mode) {
			$this->open($path, $mode);
		}
	}
	
	/**
	 * Destruct the Lamb_IO_File
	 */
	public function __destruct()
	{
		$this->close();
	}
	
	/**
	 * Set or retrieve the value of '_mPath'
	 *
	 * @param string $path
	 * @return Lamb_IO_File | string
	 */
	public function setOrGetPath($path = null)
	{
		if (null === $path) {
			return $this->_mPath;
		}
		$this->_mPath = (string)$path;
		return $this;
	}
	
	/**
	 * Open the file
	 *
	 * @param string $path
	 * @param string $mode
	 * @return Lamb_IO_File
	 * @throws Lamb_IO_Exception
	 */
	public function open($path, $mode, $useIncludePath = false)
	{
		$handle = fopen($path, $mode, $useIncludePath);
		if (false === $handle) {
			throw new Lamb_IO_Exception("Can not open the file on the \"$path\" path");
		}
		$this->_mFileHandle = $handle;
		$this->setOrGetPath($path);
		return $this;
	}
	
	/**
	 * Close the opened file 
	 *
	 * @return boolean
	 */
	public function close()
	{
		$bRet = false;
		if ($this->_mFileHandle) {
			$bRet = fclose($this->_mFileHandle);
			$this->_mFileHandle = null;
		}
		return $bRet;
	}
	
	/**
	 * @return source
	 */
	public function getHandle()
	{
		return $this->_mFileHandle;
	}
	
	/**
	 * Get a list files in path
	 *
	 * @param string $path
	 * @return array
	 */
	public function toArray($path = '')
	{
		if (!$path) {
			$path = $this->setOrGetPath();
		}
		return file($path);
	}
	
	/**
	 * Read data from file
	 *
	 * @param string $path
	 * @return string
	 * @throws Lamb_IO_Exception
	 */
	public function read($size = 0)
	{
		if (!$this->_mFileHandle) {
			throw new Lamb_IO_Exception("Invaild file handle,must be open file first");
		}
		if ($size <= 0) {
			$size = $this->getFileSize($path);
		}
		return fread($this->_mFileHandle, $size);
	}
	
	/**
	 * Get the file's size 
	 *
	 * @param string $path if $path is empty,then use the default path
	 * @return int
	 */
	public function getFileSize($path = '')
	{
		if (!$path) {
			$path = $this->setOrGetPath();
		}
		return self::fileSize($path);
	}
	
	/**
	 * The wrapper of gets function
	 * 
	 * @param int $size
	 * @return stirng
	 * @throws Lamb_IO_Exception
	 */
	public function gets($size = 1024)
	{
		if (!$this->_mFileHandle) {
			throw new Lamb_IO_Exception("Invaild file handle,must be open file first");
		}
		return fgets($this->_mFileHandle, $size);
	}
	
	/**
	 * Clear the specifiec file's data
	 *
	 * @param string $path
	 */
	public function clear($path = '')
	{
		if (!$path) {
			$path = $this->setOrGetPath();
		}
		self::clearBuffer($path);
		return $this;
	}
	
	/**
	 * The wrapper of file_exists() function
	 *
	 * @param string $path
	 * @return boolean
	 */
	public static function exists($path)
	{
		return file_exists($path);
	}
	
	/**
	 * The wrapper of fileszie function
	 * 
	 * @param string $path
	 * @return int
	 */
	public static function fileSize($path)
	{
		return filesize($path);
	}
	
	/**
	 * The wrapper of file_put_contents() function
	 *
	 * @param stirng $strPath
	 * @param string $strContents
	 * @param int $nFlag
	 * @return int
	 */
	public static function putContents($strPath, $strContents, $nFlag=0)
	{
		return $nFlag<=0 ? file_put_contents($strPath, $strContents) 
						 : file_put_contents($strPath, $strContents, $nFlag);
	}
	
	/**
	 * The wrapper of file_get_contents() function
	 *
	 * @param string $strPath
	 * @param boolean $bCreate
	 * @return string
	 */
	public static function getContents($strPath, $bCreate=false)
	{
		if ($bCreate && !self::exists($strPath)) {
			self::clearBuffer($strPath);
		}
		return file_get_contents($strPath);
	}
	
	/**
	 * The wrapper of unlink() function
	 *
	 * @param string $strPath
	 * @return boolean
	 */
	public static function delete($strPath)
	{
		return @unlink($strPath);
	}
	
	/**
	 * The wrapper of filemtime function
	 *
	 * @param string $strPath
	 * @return int
	 */
	public static function getLastModifytime($strPath)
	{
		return filemtime($strPath);
	}
	
	/**
	 * 删除指定目录下的所有文件
	 *
	 * @param string $dir
	 * @param boolean $isRmdir
	 */
	public static function delFileUnderDir($dir, $isRmdir = false)
	{
		$oDir=opendir($dir);
		while($file = readdir($oDir))
		{
			if($file != "." && $file != "..")
			{
				$file=$dir . DIRECTORY_SEPARATOR . $file;
				is_dir($file) ? self::delFileUnderDir($file, $isRmdir) : self::delete($file);
			}
		}
		closedir($oDir);
		
		if ($isRmdir) {
			rmdir($dir);
		}
	}
	
	/**
	 *  静态方法 写文件 param1 文件名 param2 写入字符串 param3 选项
	 *
	 * @param string $file
	 * @param string $str
	 * @param string $option
	 * @return void
	 */
	public static function write($file, $str="", $option="w")
	{
		$oFile=fopen($file, $option);
		fwrite($oFile, $str);
		fclose($oFile);
	}
	
	/**
	 * Get the specific file's extendtion
	 *
	 * @param string $strPath
	 * @return string
	 */
	public static function getFileExt($strPath)
	{
		$ret = '';
		if (($pos = strripos($strPath, '.')) !== false) {
			$ret = substr($strPath, $pos);
		}
		return $ret;
	}
	
	/**
	 * Clear the specific path data
	 *
	 * @param string $strPath
	 * @param boolean $bLock
	 */
	public static function clearBuffer($strPath, $bLock=false)
	{
		$bLock ? self::putContents($strPath, '', LOCK_EX) : fclose(fopen($strPath, 'w'));
	}
	
	/**
	 * 获取对应路径不会重复的文件名
	 *
	 * @param string $filepath
	 * @param string $delimiter 
	 * @param int $_index [reserve]
	 * @return string
	 */
	public static function getUniqueName($filepath, $delimiter = '_', $_index = 0)
	{
		if (!self::exists($filepath)) {
			return $filepath;
		}
		$ext = self::getFileExt($filepath);
		$filepath = dirname($filepath) . DIRECTORY_SEPARATOR . basename($filepath, $ext) . $delimiter . $_index++ . $ext;
		
		return self::getUniqueName($filepath, $delimiter, $_index);
	}
	
	/** 
	 *  将路径中的文件名CRC32编码
	 * eg:F:\dir1\file.txt => F:\dir1\(file的crc32加密后的数据).txt
	 *
	 * @param string $path
	 * @param string $suffix
	 * @return string
	 */
	public static function generateCrc32EncodeFileNamePath($path, $suffix = '.txt')
	{
		$dirname = dirname($path);
		$filename = Lamb_Utils::crc32FormatHex(basename($path, $suffix));
		return $dirname . DIRECTORY_SEPARATOR . $filename . $suffix;
	}
	
	/**
	 * 能够安全创建路径 即使子路径不存在
	 *
	 * @param string $path
	 * @return boolean
	 */
	public static function mkdir($path)
	{
		$cache = array();
		
		while (!file_exists($path)) {
			array_push($cache, $path);
			$path = dirname($path);
		}
		
		for ($j = 0, $i = count($cache) - 1; $i >= $j; $i--) {
			if (!mkdir($cache[$i])) {
				return false;
			}
		}
		
		return true;	
	}	
	
	
	/**
	 *  读取目录及其文件代码：
   	 *  $dir	 (string) 目录名称 
     *  $pattern (string) 规则 
     *  @return (array) 返回数组
  	 *	用例 列出网站根目录下所有以".php"扩展名（不区分大小写）结尾的文件 
     *  getFileList($_SERVER['DOCUMENT_ROOT'],"/\.php$/i")
	 */  
	public static function getFileList($dir,$pattern="")
	{ 
        $arr=array(); 
        $dir_handle=opendir($dir); 
        if($dir_handle) {       
            // 这里必须严格比较，因为返回的文件名可能是“0” 
            while(($file=readdir($dir_handle))!==false) { 

                if($file==='.' || $file==='..') { 
                    continue; 
                } 
                $tmp=realpath($dir.'/'.$file); 
                if(is_dir($tmp)) { 
                   //这是通用类型：如果是目录，递归继续遍历。但由于本用例不需要，先注释
                   $retArr=self::getFileList($tmp,$pattern); 
                   if(!empty($retArr)) { 
                        $arr[]=$retArr; //这是全路径
                   }                   
                   $arr[]=$file; //只获取当前名，不取全路径
                } else { 
                    if($pattern==="" || preg_match($pattern,$tmp)) { 
                        $arr['name'][] = $file;
						$arr['filemtime'][] = filemtime($tmp);
                    } 
                } 
            } 
            closedir($dir_handle); 
        } 
        return $arr; 
    } 
}