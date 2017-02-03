<?php
/**
 * UEditor编辑器通用上传类
 */
class Shendou_Model_Uploader extends Shendou_Model 
{
    private $fileField;            //文件域名
    private $file;                 //文件上传对象
    private $oriName;              //原始文件名
    private $fileName;             //新文件名
    private $fullName;             //完整文件名,即从当前配置目录开始的URL
    private $fileSize;             //文件大小
    private $fileType;             //文件类型
    private $stateInfo;            //上传状态信息,
    private $cfg;
    private $stateMap = array(    //上传状态映射表，国际化用户需考虑此处数据的国际化
        "SUCCESS" ,                //上传成功标记，在UEditor中内不可改变，否则flash判断会出错
        "文件大小超出 upload_max_filesize 限制" ,
        "文件大小超出 MAX_FILE_SIZE 限制" ,
        "文件未被完整上传" ,
        "没有文件被上传" ,
        "上传文件为空" ,
        "POST" => "文件大小超出 post_max_size 限制" ,
        "SIZE" => "文件大小超出网站限制" ,
        "TYPE" => "不允许的文件类型" ,
        "DIR" => "目录创建失败" ,
        "IO" => "输入输出错误" ,
        "UNKNOWN" => "未知错误" ,
        "MOVE" => "文件保存时出错",
        "DIR_ERROR" => "创建目录失败",
        "SOURCE_IMG_ERROR" => "原文件不存在",
        "MARK_IMG_ERROR" => "水印图片不存在",
        "WATER_MARK_ERROR" => "水印失败"
    );

    /**
     * 构造函数
     * @param string $fileField 表单名称
     * @param bool $base64  是否解析base64编码，可省略。若开启，则$fileField代表的是base64编码的字符串表单名
     */
    public function __construct( $fileField , $base64 = false)
    {
        $this->fileField = $fileField;
        $this->stateInfo = $this->stateMap[0];
        $this->cfg = Lamb_Registry::get(CONFIG);
        $this->upFile( $base64 );
    }

    /**
     * 上传文件的主处理方法
     * @param $base64
     * @return mixed
     */
    private function upFile($base64)
    {
        //处理base64上传
        if ("base64" == $base64) {
            $content = $_POST[$this->fileField];
            $this->base64ToImage( $content );
            return;
        }

        //处理普通上传
        $file = $this->file = $_FILES[$this->fileField];

        if ( !$file ) {
            $this->stateInfo = $this->getStateInfo('POST');
            return;
        }
        if ( $this->file['error'] ) {
            $this->stateInfo = $this->getStateInfo($file['error']);
            return;
        }
        if ( !is_uploaded_file( $file['tmp_name'] ) ) {
            $this->stateInfo = $this->getStateInfo( "UNKNOWN" );
            return;
        }

        $this->oriName = $file['name'];
        $this->fileSize = $file['size'];
        $this->fileType = $this->getFileExt();
		
        if ( !$this->checkSize() ) {
            $this->stateInfo = $this->getStateInfo( "SIZE" );
            return;
        }
        if ( !$this->checkType() ) {
            $this->stateInfo = $this->getStateInfo( "TYPE" );
            return;
        }

        $folder = $this->getFolder();

        if ( $folder === false ) {
            $this->stateInfo = $this->getStateInfo( "DIR_ERROR" );
            return;
        }
		
        $this->fullName = $folder . $this->getName();
		
        if ( $this->stateInfo == $this->stateMap[ 0 ] ) {
				
			if ($this->cfg['webInfo']['upload']['isWatermark'] && ".gif" != $this->fileType) {
				//如果是.gif的图片不添加水印
				$file["tmp_name"] = $this->waterMark($file["tmp_name"], $this->cfg['webInfo']['upload']['watermark'], null, null, $this->cfg['webInfo']['upload']['waterposition']);
				
				if ($file["tmp_name"] == -1) {
					$this->fullName = ''; 
					$this->stateInfo = $this->getStateInfo("SOURCE_IMG_ERROR");
					return;
				} else if ($file["tmp_name"] == -2) {
					$this->fullName = ''; 
					$this->stateInfo = $this->getStateInfo("MARK_IMG_ERROR");
					return;
				} else if ($file["tmp_name"] == -3) {
					$this->fullName = ''; 
					$this->stateInfo = $this->getStateInfo("WATER_MARK_ERROR");
					return; 	
				}
			}
			
            if (!move_uploaded_file($file["tmp_name"] , $this->fullName)) {
                $this->stateInfo = $this->getStateInfo("MOVE");
            }
			
        }

    }

    /**
     * 对上传图片的大小进行裁剪
     *  @param $fileName
     *  @return   
     */
    public static function cuttingImg($fileName, $con)
    {
        $config = Lamb_Registry::get(CONFIG);
        $width  = $con['width']  ? $con['width']  : $config['webInfo']['upload']['width']; 
        $height = $con['height'] ? $con['height'] : $config['webInfo']['upload']['height'];  
        $size = getimagesize($fileName);

        switch ($size[2]) {
            case 1: $im_in = imagecreatefromgif($fileName);  
                break;
            case 2: $im_in = imagecreatefromjpeg($fileName);   
                break;
            case 3: $im_in = imagecreatefrompng($fileName);
                break;
        }

        $im_out = imagecreatetruecolor($width,$height);  
        imagecopyresampled($im_out,$im_in,0,0,0,0,$width,$height,$size[0],$size[1]);  
        imagejpeg($im_out,$fileName);
        chmod($fileName,0777);  
        imagedestroy($im_in);  
        imagedestroy($im_out);
    }    

    /**
     * 处理base64编码的图片上传
     * @param $base64Data
     * @return mixed
     */
    private function base64ToImage( $base64Data )
    {
        $img = base64_decode( $base64Data );
        $this->fileName = Lamb_Utils::crc32FormatHex(time() . rand( 1 , 10000 ) ) . ".png";
        $this->fullName = $this->getFolder() . $this->fileName;
        if ( !file_put_contents( $this->fullName , $img ) ) {
            $this->stateInfo = $this->getStateInfo( "IO" );
            return;
        }
        $this->oriName = "";
        $this->fileSize = strlen( $img );
        $this->fileType = ".png";
    }

    /**
     * 获取当前上传成功文件的各项信息
     * @return array
     */
    public function getFileInfo()
    {
        return array(
            "originalName" => $this->oriName ,
            "name" => $this->fileName ,
            "url" => $this->fullName ,
            "size" => $this->fileSize ,
            "type" => $this->fileType ,
            "state" => $this->stateInfo
        );
    }

    /**
     * 上传错误检查
     * @param $errCode
     * @return string
     */
    private function getStateInfo( $errCode )
    {
        return !$this->stateMap[ $errCode ] ? $this->stateMap[ "UNKNOWN" ] : $this->stateMap[ $errCode ];
    }

    /**
     * 重命名文件
     * @return string
     */
    private function getName()
    {
        return $this->fileName = Lamb_Utils::crc32FormatHex(time() . rand( 1 , 10000 )) . $this->getFileExt();
    }

    /**
     * 文件类型检测
     * @return bool
     */
    private function checkType()
    {
    	$temp = array();
    	foreach($this->cfg['webInfo']['upload'][ "allowFiles" ] as $key => $item) {
	    	if (trim($item) == $this->getFileExt()) {
	    		$temp[$key] = trim($item);
	    	}	
    	}
		
		if (empty($temp)) {
			return false;
		}
		
		return true;
        //return in_array( $this->getFileExt() , $this->cfg['webInfo']['upload'][ "allowFiles" ] );
    }

    /**
     * 文件大小检测
     * @return bool
     */
    private function  checkSize()
    {
        return $this->fileSize <= ( $this->cfg['webInfo']['upload'][ "maxSize" ]);
    }

    /**
     * 获取文件扩展名
     * @return string
     */
    private function getFileExt()
    {
        return strtolower( strrchr( $this->file[ "name" ] , '.' ) );
    }

    /**
     * 按照配置文件自动创建存储文件夹
     * @return string
     */
    private function getFolder()
    {
        $pathStr = $this->cfg['webInfo']['upload'][ "img_path" ];
        if ( strrchr( $pathStr , "/" ) != "/" ) {
            $pathStr .= "/";
        }
        
        if ( !file_exists( $pathStr ) ) {
            if ( !mkdir( $pathStr , 0777 , true ) ) {
                return false;
            }
        }
        return $pathStr;
    }
	
	/**
	 * 图片加水印（适用于png/jpg/gif格式）
	 * 
	 * @author flynetcn
	 *
	 * @param $srcImg 原图片
	 * @param $waterImg 水印图片
	 * @param $savepath 保存路径
	 * @param $savename 保存名字
	 * @param $positon 水印位置 
	 * 1:顶部居左, 2:顶部居右, 3:居中, 4:底部局左, 5:底部居右 
	 * @param $alpha 透明度 -- 0:完全透明, 100:完全不透明
	 * 
	 * @return 成功 -- 加水印后的新图片地址
	 *          失败 -- -1:原文件不存在, -2:水印图片不存在, -3:原文件图像对象建立失败
	 *          -4:水印文件图像对象建立失败 -5:加水印后的新图片保存失败
	 */
	public function waterMark($srcImg, $waterImg, $savepath=null, $savename=null, $positon=5, $alpha=100) {
	    $temp = pathinfo($srcImg);
	    $name = $temp['basename'];
	    $path = $temp['dirname'];
	    $savename = $savename ? $savename : $name;
	    $savepath = $savepath ? $savepath : $path;
	    $savefile = $savepath . DIRECTORY_SEPARATOR . $savename;
	    $srcinfo = @getimagesize($srcImg);
	    if (!$srcinfo) {
	        return -1; //原文件不存在
	    }
	    $waterinfo = @getimagesize($waterImg);
	    if (!$waterinfo) {
	        return -2; //水印图片不存在
	    }
	    $srcImgObj = $this->imageCreateFromExt($srcImg);
	    if (!$srcImgObj) {
	        return -3; //原文件图像对象建立失败
	    }
	    $waterImgObj = $this->imageCreateFromExt($waterImg);
	    if (!$waterImgObj) {
	        return -3; //水印文件图像对象建立失败
	    }
	    switch ($positon) {
		    //1顶部居左
		    case 1: $x=$y=0; break;
		    //2顶部居右
		    case 2: $x = $srcinfo[0]-$waterinfo[0]; $y = 0; break;
		    //3居中
		    case 3: $x = ($srcinfo[0]-$waterinfo[0])/2; $y = ($srcinfo[1]-$waterinfo[1])/2; break;
		    //4底部居左
		    case 4: $x = 0; $y = $srcinfo[1]-$waterinfo[1]; break;
		    //5底部居右
		    case 5: $x = $srcinfo[0]-$waterinfo[0]; $y = $srcinfo[1]-$waterinfo[1]; break;
		    default: $x=$y=0;
	    }
	    $this->imagecopymerge_alpha($srcImgObj, $waterImgObj, $x, $y, 0, 0, $waterinfo[0], $waterinfo[1], $alpha);
	    switch ($srcinfo[2]) {
		    case 1: imagegif($srcImgObj, $savefile); break;
		    case 2: imagejpeg($srcImgObj, $savefile); break;
		    case 3: imagepng($srcImgObj, $savefile); break;
		    default: return -3; //保存失败
	    }
	    imagedestroy($srcImgObj);
	    imagedestroy($waterImgObj);
	    return $savefile;
	}
	 
	 
	private function imageCreateFromExt($imgfile)
	{
	    $info = getimagesize($imgfile);
	    $im = null;
	    switch ($info[2]) {
		    case 1: $im=imagecreatefromgif($imgfile); break;
		    case 2: $im=imagecreatefromjpeg($imgfile); break;
		    case 3: $im=imagecreatefrompng($imgfile); break;
	    }
	    return $im;
	}
	
	private function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
	{
		$opacity=$pct;
        // getting the watermark width
        $w = imagesx($src_im);
        // getting the watermark height
        $h = imagesy($src_im);
             
        // creating a cut resource
        $cut = imagecreatetruecolor($src_w, $src_h);
        // copying that section of the background to the cut
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
        // inverting the opacity
        //$opacity = 100 - $opacity;
             
        // placing the watermark now
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $opacity);
	}
}