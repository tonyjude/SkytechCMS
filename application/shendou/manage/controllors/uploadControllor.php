<?php
class uploadControllor extends Shendou_Controllor_ManageAbstract
{
	public function __construct()
	{
		parent::__construct();	
	}
	
	public function getControllorName()
	{
		return 'upload';
	}
	
	/**
 	 *  本地图片上传
	 */
	public function indexAction()
	{
      	phpinfo();
	}
	
	/**
 	 *  远程图片上传
	 */
	public function remoteAction()
	{
        $_w = trim($this->mRequest->getPost('w'));
        $_h = trim($this->mRequest->getPost('h'));
        $config = $this->mSiteCfg['webInfo']['upload'];
        $config['width']  = $_w;		
    	$config['height'] = $_h;

        $uri = htmlspecialchars($this->mRequest->getPost('uri'));   
        $uri = $this->getRemoteImage($uri, $config);    

    	if($uri == 'error'){
    		echo "{'tip':'远程图片抓取失败！','srcUrl':'" . $uri . "'}";
    		return;
    	}

        echo "{'tip':'远程图片抓取成功！','srcUrl':'" . $uri . "'}";
    }
	
	public function uploadAction()
	{
		$callback = trim($this->mRequest->callback);

		if (!$callback) {
			$callback = 'coverCallback';
		}
		
		if ($this->mRequest->isPost()) {
			$up  = new Shendou_Model_Uploader("upfile");
			$info = $up->getFileInfo();
			if($info['url'] == ''){
	        	$this->showResults(0, null, $info['state']);
	        	return;
	        }
			
			$this->showResults(1, null, $info['url']);			 
		}
		
		include $this->load('upload_iframe');
	}
	
	
	public function progressAction()
	{
		$i   = ini_get('session.upload_progress.name');
		$key = ini_get("session.upload_progress.prefix") . $_GET[$i];
		
		if (!empty($_SESSION[$key])) {
			$current = $_SESSION[$key]["bytes_processed"];
			$total = $_SESSION[$key]["content_length"];
			echo $current < $total ? ceil($current / $total * 100) : 100;
		}else{
			echo 100;
		}
	}
	
	 public function getRemoteImage($uri,$config)
    {

    	//忽略抓取时间限制
        set_time_limit(0);
        $tmpNames = array();
       
        //http开头验证
        if(strpos($uri,"http") !== 0){
            array_push($tmpNames , "error");
            return;
        }
       
        //获取请求头
        $heads = get_headers($uri, 1);
      
        //死链检测
        if (!( stristr($heads[0] , "200") && stristr($heads[0] , "OK" ))) {
            array_push($tmpNames , "error");
            return;
        }

        //格式验证(扩展名验证和Content-Type验证)
        $fileType = strtolower(strrchr($uri , '.'));
        if (!in_array($fileType , $config['allowFiles'])) {
            array_push($tmpNames , "error");
            return;
        }

        //打开输出缓冲区并获取远程图片
        ob_start();
        $context = stream_context_create(
            array (
                'http' => array (
                    'follow_location' => false 
                )
            )
        );
       
        readfile($uri,false,$context);
        $img = ob_get_contents();
        ob_end_clean();

        //大小验证
        $uriSize = strlen($img); //得到图片大小
        $allowSize = $config['maxSize'];
        if ($uriSize > $allowSize) {
            array_push($tmpNames , "error");
            return;
        }

        //创建保存位置
        $savePath = $config['img_path'];
        if (!file_exists($savePath)) {
            mkdir("$savePath" , 0777);
        }
        //写入文件
        $tmpName = $savePath . Lamb_Utils::crc32FormatHex(rand(1 , 10000) . time()). strrchr($uri , '.');
      
        try {
            $fp = @fopen($tmpName, "a");
            fwrite($fp , $img);
            fclose($fp);
       		//Diupin_Model_Uploader::cuttingImg($tmpName, $config); // PS: gif图片暂时不能裁剪
            array_push($tmpNames,  $tmpName);
        }catch (Exception $e) {
            array_push($tmpNames , "error" );
        }

        return $tmpNames[0];
    }

}