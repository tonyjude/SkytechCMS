<?php
class msgboardControllor extends Shendou_Controllor_FrontAbstract
{
	private $model= null; 
	public function __construct()
	{
		parent::__construct();
		$this->model = new Shendou_Model_Msgboard;
	}
	
	public function getControllorName()
	{
		return 'msgboard';
	}
	
	public function indexAction()
	{
		if ($this->mRequest->isPost()) {
				
			$safecode = $this->mRequest->getPost('safeCode');
			if (empty($safecode) || strtolower(trim($safecode)) != strtolower($_SESSION['randval'])) {
				$this->showResults(0, null, 'Verification Code Error');
			}
				
			$data = $this->mRequest->getPost('data');
			
			if (isset($data['msg_email']) && trim($data['msg_email']) == '') {
				$this->showResults(-1, null, 'email can not be empty');
			}
	
			if ($this->model->add($data)) {
				$flag = $this->sendMail($data);
				//$this->log($data['msg_email'] . '邮件发送' . ($flag ? '成功' : '失败'));
				$this->showResults(1);
			}
		}

		$this->showResults(0);
	}
	
	public function index2Action()
	{
		if ($this->mRequest->isPost()) {
			$data = $this->mRequest->getPost('data');
		
			if (isset($data['msg_email']) && trim($data['msg_email']) == '') {
				$this->showResults(-1, null, 'email can not be empty');
			}
			
			if ($this->model->add($data)) {
				$flag = $this->sendMail($data);
				//$this->log($this->mSiteCfg['webInfo']['site']['email'] . '邮件发送' . ($flag ? '成功' : '失败'));
				$this->showResults(1);
			}
		}

		$this->showResults(0);
	}

	public function sendMail($data) 
	{
		$source  = 'From Google Search';
		$data['msg_from'] = $source;
		$data['msg_source_page'] = $_SERVER["HTTP_REFERER"];
		$this->requestPost('http://admin.91yiyingxiao.com/?s=task/msgboard', $data);
		
		$isSend = $this->mSiteCfg['webInfo']['site']['isSend'];
		if (!$isSend) {
			return false;
		}
		
		$table = '<style>
					table {
						border-collapse: collapse;
						border-spacing: 0;
						padding: 8px 0;
						width: 100%;
					}
					table td {
						padding: 6px 8px;
						font-size: 14px;
						background: #F4F3F4;
						border: 2px solid #fff;
					}
				</style>';
		
		$table .= "<table><tbody>";
		
		$table .= "<tr><td>From</td><td>{$source}</td><tr>";
		
		$table .= isset($data['msg_company']) && $data['msg_company'] != '' ? "<tr><td>Company Name</td><td>{$data['msg_company']}</td><tr>" : '';
		
		$table .= isset($data['msg_name']) && $data['msg_name'] != '' ? "<tr><td>Contact Name</td><td>{$data['msg_name']}</td><tr>" : '';
		
		$table .= isset($data['msg_source_page']) && $data['msg_source_page'] != '' ? "<tr><td>Source Page</td><td>{$data['msg_source_page']}</td><tr>" : '';
		
		$table .= isset($data['msg_email']) && $data['msg_email'] != '' ? "<tr><td>Email</td><td>{$data['msg_email']}</td><tr>" : '';

		$table .= isset($data['msg_phone']) && $data['msg_phone'] != '' ? "<tr><td>Phone</td><td>{$data['msg_phone']}</td><tr>" : '';
		
		$table .= isset($data['msg_tel']) && $data['msg_tel'] != '' ? "<tr><td>Tel</td><td>{$data['msg_tel']}</td><tr>" : '';
		
		$table .= isset($data['msg_address']) && $data['msg_address'] != '' ? "<tr><td>Address</td><td>{$data['msg_address']}</td><tr>" : '';
		
		$table .= isset($data['msg_comments']) && $data['msg_comments'] != '' ? "<tr><td>Message</td><td>{$data['msg_comments']}</td><tr>" : '';
		
		$msg_date = date('Y-m-d H:i');
		$table .=  "<tr><td>Message Time</td><td>{$msg_date}</td><tr>";
		
		$table .= "</tbody></table>";									
						
		$receiver  = $this->mSiteCfg['webInfo']['site']['email'];	
		$receivers = explode(',', $receiver);
		$mail = new PHPMailer;
	
		$mail->isSMTP();                                       // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com'; 					   // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                                // Enable SMTP authentication
		$mail->Username = 'webskytech16@gmail.com';            // SMTP username
		$mail->Password = 'skytech!@123456';                           // SMTP password
		$mail->SMTPSecure = 'tls';                  		   // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                             		   // TCP port to connect to
		
		$mail->setFrom('webskytech16@gmail.com', 'skytech');
		foreach($receivers as $item){
		   $clientName = explode('@', $item);	
		   $mail->addAddress($item, $clientName[0]);    		// Add a recipient
		}

		$mail->addReplyTo($receivers[0], 'Information');
		$mail->isHTML(true);                                  	// Set email format to HTML
		$mail->Subject = 'From Google Search ' . $data['msg_subject'];
		$mail->Body    =  $table;
		
		$mail->AltBody = 'Dear customer, Here is the inquiry email，Thank you for using the skytech service！';
	
		if(!$mail->send()) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * 添加留言
	 */
	public function addAction()
	{
		
		if ($this->mRequest->isPost()) {
			$data = $_POST;	
			$data['msg_date'] = time();
			$this->model->add($data);						
		}
	}
	
	/**
	 * 模拟post进行url请求
	 * @param string $url
	 * @param array $post_data
	 */
	public function requestPost($url = '', $post_data = array()) 
	{
		if (empty($url) || empty($post_data)) {
			return false;
		}
		
		$o = "";
		foreach ( $post_data as $k => $v ) 
		{ 
			$o.= "$k=" . urlencode( $v ). "&" ;
		}
		$post_data = substr($o,0,-1);
	
		$postUrl = $url;
		$curlPost = $post_data;
		$ch = curl_init();//初始化curl
		curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		$data = curl_exec($ch);//运行curl
		curl_close($ch);
		
		return $data;
	}

}