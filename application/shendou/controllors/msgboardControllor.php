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
				$this->log($data['msg_email'] . '邮件发送' . ($flag ? '成功' : '失败'));
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
				$this->log($this->mSiteCfg['webInfo']['site']['email'] . '邮件发送' . ($flag ? '成功' : '失败'));
				$this->showResults(1);
			}
		}

		$this->showResults(0);
	}

	public function sendMail($data) 
	{
		$isSend = $this->mSiteCfg['webInfo']['site']['isSend'];
		if (!$isSend) {
			return false;
		}
		
		$num = rand(0, 9);
		$num = $num == 7 ? 1 : 0; 
		$channel = array('Google','Bing');
		$source = $channel[$num];

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
		$table .= isset($data['msg_name']) && $data['msg_name'] != '' ? "<tr><td>Name</td><td>{$data['msg_name']}</td><tr>" : '';
		$table .= isset($data['msg_company']) && $data['msg_company'] != '' ? "<tr><td>Company</td><td>{$data['msg_company']}</td><tr>" : '';
		$table .= isset($data['msg_product']) && $data['msg_product'] != '' ? "<tr><td>Product</td><td>{$data['msg_product']}</td><tr>" : '';
		$table .= isset($data['msg_email']) && $data['msg_email'] != '' ? "<tr><td>Email</td><td>{$data['msg_email']}</td><tr>" : '';
		$table .= isset($data['msg_fax']) && $data['msg_fax'] != '' ? "<tr><td>Fax</td><td>{$data['msg_fax']}</td><tr>" : '';
		$table .= isset($data['msg_phone']) && $data['msg_phone'] != '' ? "<tr><td>Phone</td><td>{$data['msg_phone']}</td><tr>" : '';
		$table .= isset($data['msg_country']) && $data['msg_country'] != '' ? "<tr><td>Country</td><td>{$data['msg_country']}</td><tr>" : '';
		$table .= isset($data['msg_city']) && $data['msg_city'] != '' ? "<tr><td>City</td><td>{$data['msg_city']}</td><tr>" : '';
		$table .= isset($data['msg_address']) && $data['msg_address'] != '' ? "<tr><td>Address</td><td>{$data['msg_address']}</td><tr>" : '';
		$table .= isset($data['msg_comments']) && $data['msg_comments'] != '' ? "<tr><td>Message</td><td>{$data['msg_comments']}</td><tr>" : '';
		$table .= "</tbody></table>";									
						
		$receiver = $this->mSiteCfg['webInfo']['site']['email'];				
		if (!Lamb_Utils::isEmail($receiver)) {
			return false;
		}
		
		$mail = new PHPMailer;
	
		//$mail->SMTPDebug = 3;                                // Enable verbose debug output
	
		$mail->isSMTP();                                       // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com'; 					   // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                                // Enable SMTP authentication
		$mail->Username = 'webskytech16@gmail.com';            // SMTP username
		$mail->Password = 'skytech!@123456';                           // SMTP password
		$mail->SMTPSecure = 'tls';                  		   // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                             		   // TCP port to connect to
		
		$clientName = explode('@', $receiver);
		$mail->setFrom('webskytech16@gmail.com', 'skytech');
		$mail->addAddress($receiver, $clientName[0]);    		// Add a recipient
		$mail->addReplyTo($receiver, 'Information');
	
		$mail->isHTML(true);                                  	// Set email format to HTML
		$mail->Subject = 'Inquiry Email Data';
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

}