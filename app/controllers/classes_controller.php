<?php
ob_start();
class ClassesController extends AppController {
	var $name = 'classes';
	var $layout = "frontend";
	var $helpers = array('Form','Html','Error','Javascript', 'Ajax','Paginator',);
	var $components = array('RequestHandler','Email','MailchimpApi','Ggapi','Cookie');
	var $uses = array('Member','State','userMeta','Group', 'School', 'Course', 'TutCourse','TutEvent','Page','CauseSchool','UserImage','CauseTutor','TutMessage','Privilege','TutRating','PaymentHistory','TutorWithdrawal','TutorToCause','AddFund','CauseWithdrawal','EmailTemplate','TutorRequestCause','UpcomingMember','UpcomingSchool','Charge','StdCourse','Notice','Wage','FileUpload','Chat');
	
	
	function beforeFilter(){
		
	$bypassPage = array();
		
	if (isset($this->params['admin']) && $this->params['action'] != 'admin_login') {
			if (!$this->checkPrivilege($this->action, $this->Session->read(), true)) {
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'login',
					'admin' => true
				));
			}
		} else if (isset($this->params['admin']) && $this->params['action'] == 'admin_login') {
			if ($this->checkPrivilege($this->action, $this->Session->read(), true)) {
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'dashboard',
					'admin' => true
				));
			}
		} else if ((!isset($this->params['admin']) && $this->params['action'] == 'checkadminlogin') || in_array($this->action, $bypassPage) || $this->RequestHandler->isAjax()) {
		} else {
			if (!$this->checkPrivilege($this->action, $this->Session->read(), false)) {
			
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'logout'
				));
			}
		}
		
		
	}
	
	
	
	function live($id=NULL)
	{
		
		
		/*echo $id;
		$id = convert_uudecode(base64_decode($id));
		echo $id;
		die;*/
		
		
		Configure::write('debug', 0);
		$this->layout="frontend";
		
		$encode = $id;
		
		
		$id = convert_uudecode(base64_decode($id));
		
		
		$paymentData = $this->PaymentHistory->find('first',array(
														'conditions'=>
														 array('PaymentHistory.id'=> $id,
															   ),
														 'recursive'=> -1
														 )
												   
												   );
		
		
		
		
		
		
		
		$currentdate = date('Y-m-d H:i:s');
		$startclass = $paymentData['PaymentHistory']['booked_start_time'];
		$endclass = $paymentData['PaymentHistory']['booked_end_time'];
		
		
		$classstatus = $this->PaymentHistory->find('all',array(
														'conditions'=>
														 array('PaymentHistory.id'=> $id,
															   'PaymentHistory.booked_start_time <' => $currentdate ,
															   'PaymentHistory.booked_end_time >' => $currentdate ,
															   ),
														 'recursive'=> -1
														 )
												   
												   );
		
		
//		$currentdate = date('Y-m-d H:i:s');
		
		$ts = strtotime($startclass);
		
		$second = $ts - strtotime($currentdate);
		
		
		
		
		if(count($classstatus))
		{
			/*echo count($classstatus).'<br>';
			echo 'class is live now';*/
			
			$this->redirect(array(
						'controller' => 'classes',
						'action' => 'live_start',$encode
					));
			
			
		}
		else if($second > 0)
		{
			
		//	echo 'The Class will start in some time.';
			
		}
		else if($second < 0)
		{
			
			//echo 'class is completed Redirect to cms page';
			
			$this->redirect(array(
					'controller' => 'classes',
					'action' => 'live_end'
				));
			
		}
		
		
			
	//	$this->set('paymentData',$paymentData);
	
		$this->set('second',$second);
		
		
		
		/*echo count($classstatus);
		print_r($classstatus);
		die;*/
		
		/*$ts = mktime( 6, 30, 0, 1, 5, 2012 );
		$te = mktime( 6, 30, 0, 1, 5, 2012 );
		*/
	
	/*	echo $second;
		die;
		
		echo $currentdate;
		echo $ts;*/
	
		
	/*	echo '<pre>';
		print_r($paymentData);
		die;
		*/
		
			
		/*$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '49')));
		$this->set("statdatas",$statdatas);
		pr($statdatas);
		die;*/
	
		
	}
	
	
	function live_start($id=NULL)
	{
		
		Configure::write('debug', 0);
		$this->layout="frontend";
		
		$encode = $id;
		
		$id = convert_uudecode(base64_decode($id));	
		
		
		
	/*	$countuploadFile = $this->FileUpload->find('count',array('conditions'=>array('FileUpload.payment_id'=>$id),
													  'recursive'=> -1					  
													  )
										  );
	
		$this->set('countuploadFile',$countuploadFile);
		
		
		
		$this->paginate['FileUpload'] = array(
			'conditions' => array(
				'FileUpload.payment_id' => $id
			),
			'recursive' => -1,
			'order' => 'FileUpload.created DESC',
			'limit' => 2
		);
		$uploadFile	= $this->paginate('FileUpload');
		
		$this->set('uploadFile',$uploadFile);
		$this->set('encode',$encode);*/
		
/*		
		if(!$this->RequestHandler->isAjax()) {
			$this->layout="frontend";
		}
		if($this->RequestHandler->isAjax()) {
			    $this->layout="";
				Configure::write('debug',0);
				$this->viewPath = 'elements'.DS.'frontend';
				$this->render('liveupload');
		}*/
		
	
		
	/*	
		$countchatMsg = $this->Chat->find('count',array('conditions'=>array('Chat.payment_id'=>$id),
														  'recursive'=> -1					  
														  )
											  );
		
		$this->set('countchatMsg',$countchatMsg);
		
		
		
		
		$this->paginate['Chat'] = array(
			'conditions' => array('Chat.payment_id'=>$id),
			'order' => >array('Chat.created DESC'),
			'limit' => 2
		);
		$chatMsg	= $this->paginate('Chat');*/
		
	/*	
		$this->paginate['Chat'] = array(
			'conditions' => array(
				'Chat.payment_id' => $id
			),
			'order' => 'Chat.created DESC',
			'limit' => 2
		);
		$chatMsg	= $this->paginate('Chat');
		
		$this->set('chatMsg',$chatMsg);*/

		
	/*	$chatMsg = $this->Chat->find('all',array(
											  'conditions'=>array('Chat.payment_id'=>$id),
											  'order'=> 'Chat.created DESC',
											  'fields'=>array('Chat.from_id','Chat.message','Chat.created','Member.image_name','Member.showImage','Member.facebookId'),
											  'limit'=>2
											  )
								  );
		
		$result = array_reverse($chatMsg);
		
		$this->set('chatMsg',$result);*/
		
		
		
		
		
		
		
		
		/*echo '<pre>';
		print_r($uploadFile);
		die;*/
		
		
		
/*		
		echo '<pre>';
		print_r($uploadFile);
		die;
		*/
		
		
		$paymentData = $this->PaymentHistory->find('first',array(
														'conditions'=>
														 array('PaymentHistory.id'=> $id,
															   )
														 )
												   
												   );
		
		$studentId = $paymentData['PaymentHistory']['student_id'];
		$tutorId = $paymentData['PaymentHistory']['tutor_id'];
		$memberId = $this->Session->read('Member.memberid');
		
		if($memberId==$studentId || $memberId==$tutorId)
		{
			
			
		}
		else
		{
			$this->redirect(array(
								  'controller'=>'classes',
								  'action'=>'auth_user'
								  )
							);
		}
		
		
		
		$currentdate = date('Y-m-d H:i:s');
		$startclass = $paymentData['PaymentHistory']['booked_start_time'];
		$endclass = $paymentData['PaymentHistory']['booked_end_time'];
		
		
		$classstatus = $this->PaymentHistory->find('all',array(
														'conditions'=>
														 array('PaymentHistory.id'=> $id,
															   'PaymentHistory.booked_start_time <' => $currentdate ,
															   'PaymentHistory.booked_end_time >' => $currentdate ,
															   ),
														 'recursive'=> -1
														 )
												   
												   );
		
		
		$currentdate = date('Y-m-d H:i:s');
		
		$ts = strtotime($startclass);
		
		$second = $ts - strtotime($currentdate);
		
		$es = strtotime($endclass);
		
		$secondleft = $es - strtotime($currentdate);
		
		$this->set('secondleft',$secondleft);
		
		if(count($classstatus))
		{
			
		}
		else if($second > 0)
		{
			
			$this->redirect(array(
							'controller' => 'classes',
							'action' => 'live',$encode
						));
			
		}
		else if($second < 0)
		{
			//echo 'class is completed Redirect to cms page';
			$this->redirect(array(
					'controller' => 'classes',
					'action' => 'live_end'
				));
		}
		
		$this->set('paymentData',$paymentData);
		
		
		/*$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '49')));
		$this->set("statdatas",$statdatas);
		pr($statdatas);
		die;*/
	
		
		
	}
	
	
	
	function live_end()
	{
		Configure::write('debug', 0);
		
		$this->layout="frontend";
	
		$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '47')));
		$this->set("statdatas",$statdatas);
		
	}
	
	function auth_user()
	{
		Configure::write('debug', 0);
		
		$this->layout="frontend";
	
		$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '48')));
		$this->set("statdatas",$statdatas);
	
	}
	
	
	function end_session()
	{
		Configure::write('debug', 0);
		
		$this->layout="frontend";
	
		$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '49')));
		$this->set("statdatas",$statdatas);
	
	}
	
	
	
	// ajax call function 
	
	function server_time()
	{
		Configure::write('debug', 0);
		$this->layout = '';
		$this->autoRender = false;
		
		$now = new DateTime(); 
		return $now->format("M j, Y H:i:s O")."\n"; 
	}
	
	function file_upload($paymentId = NULL)
	{
		
		$paymentId = convert_uudecode(base64_decode($paymentId));		
		
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
	/*	$sizeOfFile=$_FILES['userImage']['size'];*/
		$serverContent = $_SERVER['CONTENT_LENGTH'];
		
		//1048576 -- 1 mb
		//1048576 -- 2 mb
		//4194304 -- 4 mb
		//5242880 -- 5 mb
		
		
		/*echo '<pre>';
		echo 'content_length'.$_SERVER['CONTENT_LENGTH'];
		print_r($_FILES);
		echo '</pre>';
		die;*/
		
		
		if($serverContent>=5242880){ 
		//if the size exceed 5 mb, then gives a msg to user, e.g size should be less than 5 mb
			echo "sizeError";exit;
		}
	
		App::Import('Component', 'Upload');
		//print_r($_FILES);die;exit;
		
		$upload = new UploadComponent();
		if (!empty($_FILES)) {
			$destination  = realpath('../../app/webroot/files/upload/') . '/';
			$imgName      = pathinfo($_FILES['userImage']['name']);
			$ext          = $imgName['extension'];
			$time         = explode(" ", microtime());
			$newImgName   = md5($time[1]);
			$tempFile     = $_FILES['userImage']['tmp_name'];
			$file         = $_FILES['userImage'];
				
			$result = $upload->upload($file, $destination, $newImgName . "." . $ext);
			
			if ($result) {
				
				$filename = $newImgName . "." . $ext;
				$orgfilename = $_FILES['userImage']['name'];
				$filetype = $_FILES['userImage']['type'];
				
				$this->data['FileUpload']['member_id'] = $this->Session->read('Member.memberid');
				$this->data['FileUpload']['payment_id'] = $paymentId;
				$this->data['FileUpload']['file_name'] = $filename;
				$this->data['FileUpload']['org_file_name'] = $orgfilename;
				$this->data['FileUpload']['file_type'] = $filetype;
				
				
				$this->FileUpload->create();
				if($this->FileUpload->save($this->data))
				{
				   echo 'ok';
				}				
				
			}
				
		
			
		}
	}
	
	
	
	function check_chat($chatcnt = NULL , $paymentId = NULL)
	{
		
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		/*echo '<pre>';
		print_r($_REQUEST);
		*/
		
		$paymentId = convert_uudecode(base64_decode($paymentId));		
	//	$uploadcnt = $_REQUEST['uploadcnt'];
		
		$countchat = $this->Chat->find('count',array('conditions'=>array('Chat.payment_id'=>$paymentId),
														   'recursive' => -1
														   )
											 );
		
		if($countchat > $chatcnt)
		{
			echo 'true';
		}
		else
		{
		   echo 'false';
		}
		die;
		
	}
	
	
	
	
	
	function check_upload($uploadcnt = NULL , $paymentId = NULL)
	{
		
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		/*echo '<pre>';
		print_r($_REQUEST);
		*/
		
		$paymentId = convert_uudecode(base64_decode($paymentId));		
	//	$uploadcnt = $_REQUEST['uploadcnt'];
		
		$countfile = $this->FileUpload->find('count',array('conditions'=>array('FileUpload.payment_id'=>$paymentId),
														   'recursive' => -1
														   )
											 );
		
		if($countfile > $uploadcnt)
		{
			echo 'true';
		}
		else
		{
		   echo 'false';
		}
		
		
		die;
		
		
	
	
		
	}
	
	
	function save_chat()
	{
		
		Configure::write('debug', 0);
		$this->layout     = "";
		$this->autoRender = false;
		
		$id = $_REQUEST['id'];
		$chat = $_REQUEST['chat'];
		
		$paymentId = convert_uudecode(base64_decode($id));
		
		$this->data['Chat']['payment_id'] = $paymentId;
		$this->data['Chat']['from_id'] = $this->Session->read('Member.memberid');
		$this->data['Chat']['message'] = $chat;
		
		
		$this->Chat->create();
		if($this->Chat->save($this->data))
		{
			echo 'true';
		}
		else
		{
		   echo 'false';
		}
		
		die;
		
		
	}
	
	
	function getupload($id=NULL)
	{
		
		$encode = $id;
		
		$id=convert_uudecode(base64_decode($id));
		
		
		$countuploadFile = $this->FileUpload->find('count',array('conditions'=>array('FileUpload.payment_id'=>$id),
													  'recursive'=> -1					  
													  )
										  );
	
		$this->set('countuploadFile',$countuploadFile);
		
		
		
		$this->paginate['FileUpload'] = array(
			'conditions' => array(
				'FileUpload.payment_id' => $id
			),
			'recursive' => -1,
			'fields'=>array('FileUpload.file_name','FileUpload.org_file_name'),
			'order' => 'FileUpload.created DESC',
			'limit' => 6
		);
		$uploadFile	= $this->paginate('FileUpload');
		
		
	/*	echo '<pre>';
		print_r($uploadFile);
		die;*/
		
		
		$this->set('uploadFile',$uploadFile);
		$this->set('encode',$encode);
		
		
		if($this->RequestHandler->isAjax()) 
			{
			   Configure::write('debug', 0);
			   $this->layout     = "";
			   $this->autoRender = false;
			   $this->viewPath = 'elements'.DS.'frontend';
			   $this->render('liveupload');
			}
	
		
	}
	
	
	
	function getchat($id=NULL)
	{
		
		$encode = $id;
		
		$id=convert_uudecode(base64_decode($id));
		
		$countChat = $this->Chat->find('count',array('conditions'=>array('Chat.payment_id'=>$id),
												  'recursive'=> -1					  
												  )
									  );
	
		$this->set('countChat',$countChat);
			
		$this->paginate['Chat'] = array(
			'conditions' => array(
				'Chat.payment_id' => $id
			),
			'order' => 'Chat.created DESC',
			'fields'=>array('Chat.from_id','Chat.message','Member.image_name','Member.showImage','Member.facebookId'),
			'limit' => 3
		);
		$chatMsg	= $this->paginate('Chat');
		
		
		$result = array_reverse($chatMsg);
		$this->set('chatMsg',$result);
		
	//	$this->set('chatMsg',$chatMsg);
	
		$this->set('encode',$encode);
		
		if($this->RequestHandler->isAjax()) 
			{
			   Configure::write('debug', 0);
			   $this->layout     = "";
			   $this->autoRender = false;
			   $this->viewPath = 'elements'.DS.'frontend';
			   $this->render('livechat');
			}
		
	}
	
	
	function extend_session($min=NULL,$id=NULL)
	{
		
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;
		
		
		$paymentid = convert_uudecode(base64_decode($id));
		
		
		App::import('Vendor', 'stripephp', array('file' => 'stripephp'.DS.'lib'.DS.'Stripe.php'));
		
		// set your secret key: remember to change this to your live secret key in production
		// see your keys here https://manage.stripe.com/account
		
		Stripe::setApiKey(STRIPEID);
		
		//live
	//	Stripe::setApiKey("STXx0V2iZwH17qPszOID8zCyItKRzWAH");
		// tesing
	//	Stripe::setApiKey("hzKG6oNLVXaJpipg5j2AWqv0gl90MQZi");
		
		
		if (!empty($min)) {
			
			
			$this->PaymentHistory->unbindModel(array('belongsTo' => array('tutor','TutEvent')));
		
			$amtpaymentdata = $this->PaymentHistory->find('first',array('conditions'=>
																 array('PaymentHistory.id'=> $paymentid),
																 'recursive'=> 2,
																 'fields'=>array('student.stripeid','student.creditable_balance','student.id','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours','PaymentHistory.tutor_id','PaymentHistory.booked_end_time','PaymentHistory.amount')
																 )
												   );
			
			
		
		
			$customerId = $amtpaymentdata['student']['stripeid'];
			$balance = $amtpaymentdata['student']['creditable_balance'];
			$studentId = $amtpaymentdata['student']['id'];
			$tutorId = $amtpaymentdata['PaymentHistory']['tutor_id'];
			$checkamount =  $amtpaymentdata['PaymentHistory']['tutor_rate_per_hour'];
			
			$updhour = (( $amtpaymentdata['PaymentHistory']['tutoring_hours'] *  60 ) + $min)/60;
			
			$chargeamount =  ($min/60) * $amtpaymentdata['PaymentHistory']['tutor_rate_per_hour'];			
			$chargeamount = sprintf("%.2f",$chargeamount );
			
			$updamount = $amtpaymentdata['PaymentHistory']['amount'] + $chargeamount;
			
			$bookedend =  $amtpaymentdata['PaymentHistory']['booked_end_time'];
			$uptenddate =  strtotime($bookedend) + $min*60;
			$uptenddate = date('Y-m-d H:i:s',$uptenddate);
			
			
		/*	echo '<pre>';
			echo $paymentid;
			print_r($amtpaymentdata);
			echo 'tutoring hours'.$amtpaymentdata['PaymentHistory']['tutoring_hours'].'update hours'.$updhour.'charge amount'.$chargeamount.'update amount'.$updamount;
			echo 'enddate'.$bookedend.'Update enddate'.$uptenddate.'rate per hour'.$checkamount;			
			die;*/
			
			
			
			if($checkamount==0)
			{
				if($this->PaymentHistory->updateAll(array(
					'PaymentHistory.booked_end_time' => "'" . $uptenddate . "'",
					'PaymentHistory.tutoring_hours' => "'" . $updhour . "'",
				), array(
					'PaymentHistory.id' => $paymentid
				)))
				{
					
					echo 'true';
					
				}
				
				
				
			}
			else if($balance >= $chargeamount)
			{
					
				if ($this->PaymentHistory->updateAll(array(
					'PaymentHistory.booked_end_time' => "'" . $uptenddate . "'",
					'PaymentHistory.tutoring_hours' => "'" . $updhour . "'",
					'PaymentHistory.amount' => "'" . $updamount . "'",					
				), array(
					'PaymentHistory.id' => $paymentid
				))) {
					
					$this->Member->updateAll(array(
						'Member.creditable_balance' => "Member.creditable_balance-" . $chargeamount
					), array(
						'Member.id' => $studentId
					));
				
							
					$this->Member->updateAll(array(
						'Member.balance' => ('Member.balance+' . $chargeamount)
					), array(
						'Member.id' => $tutorId
					));
					
					
					echo 'true';
					
				}
			
				
			}
			else if(!empty($customerId))
			{
				
				//	$customerId = $getAmount['student']['stripeid'];
					
					$cent = $chargeamount * 100;
					
					// charge the Customer instead of the card
					Stripe_Charge::create(array(
					  "amount" => $cent, # amount in cents, again
					  "currency" => "usd",
					  "customer" => $customerId)
					);
				
				
					if ($this->PaymentHistory->updateAll(array(
					'PaymentHistory.booked_end_time' => "'" . $uptenddate . "'",
					'PaymentHistory.tutoring_hours' => "'" . $updhour . "'",
					'PaymentHistory.amount' => "'" . $updamount . "'",					
				), array(
					'PaymentHistory.id' => $paymentid
				))) {
					
					
					$this->Member->updateAll(array(
						'Member.balance' => ('Member.balance+' . $chargeamount)
					), array(
						'Member.id' => $tutorId
					));
					
					
					echo 'true';
					
					
					
					
					}
					
			
				
			}
			else
			{	
			
				echo 'false';
			
			}
			
			
		}
		
		
		
		die;
		
		
		
	}
	
	
	
	
		
}	
?>
