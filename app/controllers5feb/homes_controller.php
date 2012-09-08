<?php
ob_start();
class HomesController extends AppController {
	var $name = 'homes';
	var $layout = "frontend";
	var $helpers = array('Form','Html','Error','Javascript', 'Ajax','Paginator',);
	var $components = array('RequestHandler','Email','Cookie');
	var $uses = array('Member','State','userMeta','UserImage','Group', 'School', 'Course', 'TutCourse','TutEvent','Page','ContactUsMessage','AddFund','CauseSchool','TutMessage','Wage');
	
	
	function beforeFilter() {
		
	//	parent::beforeFilter();
	
	// check session of users
		
	}
	
	
	function index(){
	
	}
	function about_us() {
		
	
		Configure::write('debug', 0);
		
	/*	if(!$this->Session->read('Member.memberid'))
		{
			$this->facebook_login();
		}*/
		
		
		$this->layout="frontend";
	
			/* $reviews=$this->Review->find('all',array('order'=>array('Review.created DESC'),'limit'=>'5'));
			$this->set('reviews',$reviews);
				if($this->Session->read('Member.group_id') == '3'){
			$savedSearches=$this->saveSearch->find('all',array('conditions'=>array('parent_id'=>$this->Session->read('Member.id')),'limit'=>'10'));
			$this->set('savedSearches',$savedSearches);
			
			}	 */
			$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '1')));
			$this->set("statdatas",$statdatas);
		//pr($statdatas);die;
	}
	
	function service_terms() {
		$this->layout="frontend";
		/*$reviews=$this->Review->find('all',array('order'=>array('Review.created DESC'),'limit'=>'5'));
		$this->set('reviews',$reviews);
		
		if($this->Session->read('Member.group_id') == '3'){	$savedSearches=$this->saveSearch->find('all',array('conditions'=>array('parent_id'=>$this->Session->read('Member.id')),'limit'=>'10'));
			$this->set('savedSearches',$savedSearches);
		
		} */
		$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '2')));
		$this->set("statdatas",$statdatas);
	
	}
	
	//Function for the CMS standard terms page
	function terms_of_service() {
		
		/*if(!$this->Session->read('Member.memberid'))
		{
			$this->facebook_login();
		}*/
		
		
		
		$this->layout="frontend";
		/* $reviews=$this->Review->find('all',array('order'=>array('Review.created DESC'),'limit'=>'5'));
		$this->set('reviews',$reviews);
		
		if($this->Session->read('Member.group_id') == '3'){
		
			$savedSearches=$this->saveSearch->find('all',array('conditions'=>array('parent_id'=>$this->Session->read('Member.id')),'limit'=>'10'));
			$this->set('savedSearches',$savedSearches);
		
		} */
		$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '3')));
		$this->set("statdatas",$statdatas);
	
	}
	
	//Function for the CMS site map page
	function site_map() {
		$this->layout="frontend";
		/* $reviews=$this->Review->find('all',array('order'=>array('Review.created DESC'),'limit'=>'5'));
		$this->set('reviews',$reviews);
		
		if($this->Session->read('Member.group_id') == '3'){
		
			$savedSearches=$this->saveSearch->find('all',array('conditions'=>array('parent_id'=>$this->Session->read('Member.id')),'limit'=>'10'));
			$this->set('savedSearches',$savedSearches);
		
		} */
		$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '4')));
		$this->set("statdatas",$statdatas);
	
	}
	
	//Function for the CMS privacy policy page
	function privacy_policy() {
		$this->layout="frontend";
		
		/*if(!$this->Session->read('Member.memberid'))
		{
			$this->facebook_login();
		}*/
		
		/* $reviews=$this->Review->find('all',array('order'=>array('Review.created DESC'),'limit'=>'5'));
		$this->set('reviews',$reviews);
		
		
		if($this->Session->read('Member.group_id') == '3'){
		
			$savedSearches=$this->saveSearch->find('all',array('conditions'=>array('parent_id'=>$this->Session->read('Member.id')),'limit'=>'10'));
			$this->set('savedSearches',$savedSearches);
		
		} */
		$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '5')));
		$this->set("statdatas",$statdatas);
	
	}
	
	//Function for the CMS parent resources page
	function resources() {
		$this->layout="frontend";
		
		/* $reviews=$this->Review->find('all',array('order'=>array('Review.created DESC'),'limit'=>'5'));
		$this->set('reviews',$reviews);
	
		
		if($this->Session->read('Member.group_id') == '3'){
		
			$savedSearches=$this->saveSearch->find('all',array('conditions'=>array('parent_id'=>$this->Session->read('Member.id')),'limit'=>'10'));
			$this->set('savedSearches',$savedSearches);
		
		} */
		$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '10')));
		$this->set("statdatas",$statdatas);
	
	}
	
	function contact_us(){
		
	/*	if(!$this->Session->read('Member.memberid'))
		{
			$this->facebook_login();
		}*/
		
		
		Configure::write('debug', 0);			
		
		$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '39')));
		
		$this->set("statdatas",$statdatas);
		
		/*$statdataaddress= $this->Page->find('all',array('conditions'=> array('Page.id' => '40')));
	
		$this->set("statdataaddress",$statdataaddress);
		
		$statdataaddress= '2719 E 10th St Bloomington, IN 47408';
		
		$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.urlencode($statdataaddress).'&sensor=false');
					
		$output= json_decode($geocode);
		
		$lat = $output->results[0]->geometry->location->lat;
		
		$long = $output->results[0]->geometry->location->lng;
		
		$this->set("lat",$lat);
		
		$this->set("long",$long);*/
		
	}
	
	function support(){
	
	}
	
	function save_message()
	{
		
		$this->ContactUsMessage->save($this->data);
		$guestId=$this->ContactUsMessage->id;
		//$this->sendMail($guestId);
		$this->Session->setFlash('Thanks for your query! We will revert back to you soon');
		$this->redirect(array('controller'=>'homes', 'action'=>'contact_us'));

	}
	function send_mail($guestId=null)
	{
		$query_data=$this->ContactUsMessage->find('first',array("conditions"=>array('ContactUsMessage.id' =>$guestId)));	
		$userInfo=$query_data['ContactUsMessage']['first_name'].",".$query_data['ContactUsMessage']['last_name'].",".$query_data['ContactUsMessage']['email'];									
												
		$email_template = $this->get_email_template('queryMail');
																							
		$this->Email->to = 'promatics.ajayendra@gmail.com';
		
		//$this->Email->replyTo = $query_data['ContactUsMessage']['email'];
		
		$this->Email->replyTo = 'promatics.ajayendra@gmail.com';
		
		//$this->Email->from = $query_data['ContactUsMessage']['email'];
		
		$this->Email->from = 'promatics.ajayendra@gmail.com';
		
		$this->Email->subject = 'User Contact Form Submission';
									
		$this->Email->sendAs = 'html';
		
		$this->set('first_name', 'Admin');
		
		$this->set('last_name', '');
		
		$this->set('user_info',$userInfo);
		
		$this->set('msg_content',nl2br($query_data['ContactUsMessage']['message']));
		
		$email_template = $this->get_email_template('queryMail');
		
		$email_template_content =  $this->render_email_template($email_template['EmailTemplate']['html_content']);
		//echo "<pre>";print_r($email_template_content);die;
		$this->set('email_template_content',$email_template_content);	
		
		$this->Email->template = 'email_template';			
									
		$this->Email->send();	
	}
	
	
		
		//Function for the CMS payment sucess page
	function success() {
		
		// all frontend
		$this->layout="frontend";
	
		$statdatas= $this->Page->find('first',array('conditions'=> array('Page.id' => '22')));
		$this->set("statdatas",$statdatas);
	
	}
	
	
		//Function for the CMS payment failure page
	function failure() {
		
		// all frontend
		
		$this->layout="frontend";
		
	
		$statdatas= $this->Page->find('first',array('conditions'=> array('Page.id' => '23')));
		$this->set("statdatas",$statdatas);
		
	
	}
	
		//Function for the blocking deactive user
	function block_user() {
		
		/*if(!$this->Session->read('Member.memberid'))
		{
			$this->facebook_login();
		}*/
		
		
		// all frontend
		
		$this->layout="frontend";
		
	
		$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '32')));
		
	/*	echo '<pre>';
		echo print_r($statdatas);
		die;*/
		
		$this->set("statdatas",$statdatas);
		
	
	}
	
	
	//Function for the welcome email
	function welcome_user() {
		
	/*	if(!$this->Session->read('Member.memberid'))
		{
			$this->facebook_login();
		}*/
		
		
		// all frontend
		
		$this->layout="frontend";
		
	
		$statdatas= $this->Page->find('first',array('conditions'=> array('Page.id' => '41')));
		$this->set("statdatas",$statdatas);
		
	
	}
	
	//Function for the unactive user
	function unactive_user() {
		
		
	/*	if(!$this->Session->read('Member.memberid'))
		{
			$this->facebook_login();
		}*/
		
		
		// all frontend
		
		$this->layout="frontend";
		
	
		$statdatas= $this->Page->find('first',array('conditions'=> array('Page.id' => '42')));
		$this->set("statdatas",$statdatas);
		
	
	}
	
	
	
	function parents()
	{
		
		/*if(!$this->Session->read('Member.memberid'))
		{
			$this->facebook_login();
		}*/
		
		$this->layout="frontend";
		Configure::write('debug', 0);
		
		$parents = array(
			'36',
		);
		
		
		$dynamictext = $this->Page->find('all', array(
			'conditions' => array(
				'Page.id' => $parents
			)
		));
		
		$this->set('dynamictext', $dynamictext);
		
	}
	
	
		//Function for the CMS payment sucess page
	function admin_success() {
		
		// all frontend
		$this->layout="admin";
	
		$statdatas= $this->Page->find('first',array('conditions'=> array('Page.id' => '37')));
		$this->set("statdatas",$statdatas);
	
	}
	
	
		//Function for the CMS payment failure page
	function admin_failure() {
		
		// all frontend
		
		$this->layout="admin";
		
	
		$statdatas= $this->Page->find('first',array('conditions'=> array('Page.id' => '38')));
		$this->set("statdatas",$statdatas);
		
	
	}
	
	
			//Function for the CMS payment sucess page
	function global_gateway_sucess() {
		
		
	/*	echo '<pre>';
		print_r($_REQUEST);
		die;*/
		
		
		// all frontend
		$this->layout="frontend";
	
		$statdatas= $this->Page->find('first',array('conditions'=> array('Page.id' => '22')));
		$this->set("statdatas",$statdatas);
	
	}
	
	
		//Function for the CMS payment failure page
	function global_gateway_failure() {
		
		// all frontend
		
		$this->layout="frontend";
		
	
		$statdatas= $this->Page->find('first',array('conditions'=> array('Page.id' => '23')));
		$this->set("statdatas",$statdatas);
		
	
	}
	
	
	
	function profile_active($memberid = NULL , $activecode = NULL )
	{
		
	
		
		
	$this->layout="frontend";
	
	$statdatas= $this->Page->find('first',array('conditions'=> array('Page.id' => '43')));
	$this->set("statdatas",$statdatas);
		
		
	 $memberData  = $this->Member->find('first',array('conditions'=>array(
																  'Member.activation_key' => $activecode,
																  'Member.id'=> $memberid
																  )));
	 
	 
	/* echo '<pre>';
	 echo $memberid.$activecode;
	 
	 print_r($memberData);
	 if($memberData)
	 {
		 echo 'if';
	 }
	 echo '</pre>';
	 die;*/
	 
	 
	 if($memberData)
	 {
		
		if($memberData['Member']['active']=='0' || $memberData['Member']['active']=='1')
		{
		 $active = 1;
		 
		 $this->Member->updateAll(array(
					'Member.active' => "'" . $active . "'"
					), array(
					'Member.id' => $memberData['Member']['id']
					)
				);
		 
		/*  if($this->Session->read('Member.id'))
		 {
			$this->set('redirect',1); 
			$this->Session->setFlash('You will redirect to your account within 5 seconds.');
		 }*/
		}
		else if($memberData['Member']['active']=='2')
		{
			session_destroy();
						
			$this->redirect(array(
			'controller' => 'homes',
			'action' => 'block_user'
			));
		
		}
		else if($memberData['Member']['active']=='3')
		{
			session_destroy();
						
			$this->redirect(array(
			'controller' => 'homes',
			'action' => 'deleted_user'
			));
		}
		 
		 
	 }
	 else
	 {
		  $this->redirect(array(
						'controller' => 'homes',
						'action' => 'unactive_user'
					)); 
		 
	 }
	 
	 
	/*	if(!$this->Session->read('Member.memberid'))
		{
			$this->facebook_login();
		}
	 */
	 
	 
	 
	/* echo '<pre>';
	 print_r($memberData);
	 die;*/
	
		
	}
	
	function deleted_user()
	{
		
		$this->layout="frontend";
		
		$statdatas= $this->Page->find('first',array('conditions'=> array('Page.id' => '44')));
		$this->set("statdatas",$statdatas);
		
	}
	
	
	
	
	
	
/*	function actived()
	{
		
		$this->layout="frontend";
		
		$statdatas= $this->Page->find('first',array('conditions'=> array('Page.id' => '43')));
		$this->set("statdatas",$statdatas);
		
	}*/
	
	
	
	function stripe_pay()
	{
		
	
	
	
		
	}
	
	
	function stripe_pay2()
	{
		
		
		
	}
	
	function register_again()
	{
	    $id =	$this->Session->read('Member.memberid');
		
		$activeid = 3;
		$this->Member->updateAll(array(
			'Member.active' => "'" . $activeid . "'"
		), array(
			'Member.id' => $id
		));
		
		$this->redirect(array('controller'=>'members', 'action'=>'logout'));
		
	}
	
	
	
	function login()
	{
		/*$username = $this->Cookie->read('username');
		$password = $this->Cookie->read('password');
		echo $username;
		die;*/
		
		$this->newcheckuserstep();
	}
	
	//function for the login of the backend user.
	function checkfrontendlogin() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		
		/*echo '<pre>';
		print_r($this->data);
		die;*/
		
		
		if ($this->RequestHandler->isAjax()) {
			$username = $this->data['Member']['username'];
			$password = $this->data['Member']['pwd'];
			
			
		
			
			
			$groupId = array('6','7','8');
			
			
			$user = $this->Member->find('count', array(
				'conditions' => array(
					'Member.email' => $username,
					'Member.pwd' => md5($password),
					'Member.group_id' => $groupId,
					'Member.active !=' => 3
				)
			));
			
			
			if ($user) {
				$getMemberData = $this->Member->find('first', array(
					'conditions' => array(
						'Member.email' => $username,
						'Member.pwd' => md5($password),
						'Member.group_id' => $groupId,
						'Member.active !=' => 3
					)
				));
				
				if (!empty($getMemberData)) {
					
					$this->Session->write('Member.email', $getMemberData['Member']['email']);
					$this->Session->write('Member.memberid', $getMemberData['Member']['id']);
					$this->Session->write('Member.active', $getMemberData['Member']['active']);
					$this->Session->write('Member.group_id', $getMemberData['Member']['group_id']);
					
					if($getMemberData['Member']['facebookId'])
					{
						$this->Session->write('Member.facebook_id', $getMemberData['Member']['facebookId']);
					}
					
					// print_r($getMemberData);
					
				/*	if($this->data['Member']['remember'])
					{
						$md5password = md5($password);
						
						$expire=time()+60*60*24*30;
						
						$this->Cookie->write('username', $username, $encrypt = false, $expires = $expire);
						$this->Cookie->write('password', $md5password, $encrypt = false, $expires = $expire);
						
						setcookie( "vegetable", "artichoke", time()+3600, "/" );
					
					}*/
					
					echo "authorized";
					
				}
			} else {
				//echo $html->link('Forgot Password ?',array('controller'=>'Users','action'=>'requestPassword'));
				echo "The username or password you entered is incorrect.";
			}
			
		}
		
	}
	
	
	function registration()
	{
		
		$this->newcheckuserstep();
		
		
		//$this->checkfacebooklogin();
		Configure::write('debug', 0);
		$this->layout = 'frontend';
//		$this->set('emailStatus','');

	//	$this->set('picture', $this->getProfilePic());
		
	/*	$this->data = $this->Member->find('first', array(
			'conditions' => array(
				'Member.facebookId' => $this->Session->read('Member.id'),
				'Member.active !=' => 3
			)
		));*/
	
	
		
		
		$rightText  = $this->Page->find('first', array(
			'conditions' => array(
				'Page.id' => 24
			)
		));
		$this->set('rightText', $rightText);
		
		
		
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		
		
		
		/*echo '<pre>';
		print_r($states);
		die;*/
		
		$this->set("states", $states);
		
		
		$allSchool = $this->School->find('all'); //retireve all states
		$schools  = Set::combine($allSchool, '{n}.School.id', '{n}.School.school_name');
		$this->set("schools", $schools);
		
		
		
		
		$groupId = $this->Session->read('Member.group_id');
		
		if($groupId)
		{
			if ($groupId == 6) {
				$user = 6;
				$this->set('user', $user);
			} else if ($groupId == 7) {
				$user = 7;
				$this->set('user', $user);
			} else if ($groupId == 8) {
				$user = 8;
				$this->set('user', $user);
			}
		
		}
		else
		{
			
			$this->Session->setFlash('Please select user type first.');
			$this->redirect(array('controller'=>'members', 'action'=>'select_type'));
		}
		
		
		
		
		/*if (isset($id) && $id != '') {
			$usertype = $this->Member->find('first', array(
				'conditions' => array(
					'Member.id' => $id
				)
			));
			
			if ($usertype['Member']['group_id'] == 6) {
				$user = 'cause';
				$this->set('user', $user);
			} else if ($usertype['Member']['group_id'] == 7) {
				$user = 'tutor';
				$this->set('user', $user);
			} else if ($usertype['Member']['group_id'] == 8) {
				$user = 'student';
				$this->set('user', $user);
			}
			$this->set('emailStatus','readonly');
			
		}*/
	
	
	
	}
	
	
	function savemember()
	{
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		App::Import('Component', 'Upload');
				
		$upload = new UploadComponent();
		
		if (isset($this->data)) {
			
			if($this->Session->read('Member.group_id')==6)
			{
			
			$tmpimage = $this->Session->read('Member.tmpimage');
			
			$src = 'img/members/temp/'.$tmpimage;
			$des = 'img/members/'.$tmpimage;
			
			rename('img/members/temp/'.$tmpimage,'img/members/'.$tmpimage);
			rename('img/members/temp/thumb/'.$tmpimage,'img/members/thumb/'.$tmpimage);
			
		/*	echo '<pre>';
			print_r($_POST);
			print_r($this->data);
			die;*/
			
			
		//	$memberdata['Member']['id']     = $this->data['Member']['id'];
		
			$memberdata['Member']['active'] = 1;
			$memberdata['Member']['pwd'] = md5($this->data['Member']['pwd']);
			$memberdata['Member']['email']  = $this->data['Member']['email'];
			$memberdata['Member']['group_id'] = $this->Session->read('Member.group_id');
			$memberdata['Member']['fname']  = $this->data['userMeta']['fname'];
			$memberdata['Member']['lname']  = $this->data['userMeta']['lname'];
			
		/*	echo 'ok'.'<pre>';
				print_r($_POST);
				print_r($memberdata);
				print_r($_SESSION);
				die;*/
			
			
			
			$this->Member->create();
			
			if ($this->Member->save($memberdata)) {
				
				
				
				$Lastid = $this->Member->id;
				
				
				foreach ($this->data['CauseSchool']['school_id'] as $key => $value) {
					$data['CauseSchool']['cause_id']  = $Lastid;
					$data['CauseSchool']['school_id'] = $value;
					$this->CauseSchool->create();
					$this->CauseSchool->save($data);
				}
				
				
				$userMeta['userMeta']['fname']     = $this->data['userMeta']['fname'];
				$userMeta['userMeta']['lname']     = $this->data['userMeta']['lname'];
				$userMeta['userMeta']['address']   = $this->data['userMeta']['address'];
				$userMeta['userMeta']['city']      = $this->data['userMeta']['city'];
				$userMeta['userMeta']['state']     = $this->data['userMeta']['state'];
				$userMeta['userMeta']['zip']       = $this->data['userMeta']['zip'];
				$userMeta['userMeta']['contact']   = $this->data['userMeta']['contact'];
				$userMeta['userMeta']['biography']   = $this->data['userMeta']['biography'];
				$userMeta['userMeta']['member_id'] = $Lastid;
			/*	$userMeta['userMeta']['fb_allow'] = $this->data['userMeta']['fb_allow'];
				$userMeta['userMeta']['email_allow'] = $this->data['userMeta']['email_allow'];*/
				$userMeta['userMeta']['fb_allow'] = 1;
				$userMeta['userMeta']['email_allow'] = $this->data['userMeta']['email_allow'];
				
				
				$this->userMeta->create();
				
				if ($this->userMeta->save($userMeta)) {
					
					if($tmpimage)
					{
						
						$this->Member->updateAll(array('Member.image_name'=>"'".$tmpimage."'"),
												array('Member.id'=>$Lastid)
												);
						
						$data['UserImage']['user_id']    = $Lastid;
						$data['UserImage']['image_name'] = $tmpimage;
						$db                              = $this->UserImage->getDataSource();
						$data['UserImage']['created']    = $db->expression("NOW()");
						$data['UserImage']['active']     = 1;
						$this->UserImage->create();
						if ($this->UserImage->save($data)) {
							
							$this->Session->delete('Member.tmpimage');						
						//	$this->redirect(array('controller'=>'homes', 'action'=>'login'));
						}
					}
					
					
				$getMemberData = $this->Member->find('first', array(
					'conditions' => array(
						'Member.id' => $Lastid,
						'Member.active !=' => 3
					)
				));
				
				if (!empty($getMemberData)) {
					
					$this->Session->write('Member.email', $getMemberData['Member']['email']);
					$this->Session->write('Member.memberid', $getMemberData['Member']['id']);
					$this->Session->write('Member.active', $getMemberData['Member']['active']);
					$this->Session->write('Member.group_id', $getMemberData['Member']['group_id']);
					
					if($getMemberData['Member']['facebookId'])
					{
						$this->Session->write('Member.facebook_id', $getMemberData['Member']['facebookId']);
					}
					
					// print_r($getMemberData);
					
				/*	if($this->data['Member']['remember'])
					{
						$md5password = md5($password);
						
						$expire=time()+60*60*24*30;
						
						$this->Cookie->write('username', $username, $encrypt = false, $expires = $expire);
						$this->Cookie->write('password', $md5password, $encrypt = false, $expires = $expire);
						
						setcookie( "vegetable", "artichoke", time()+3600, "/" );
					
					}*/
					
				
					
				}	
				
				$this->send_first_msg($Lastid);					
					
				$this->redirect(array('controller'=>'homes', 'action'=>'login'));
					
				}
			}
			
			}
			
			else if($this->Session->read('Member.group_id')==7)
			{
			
		/*	echo 'tutor';
			die;*/
			
			$tmpimage = $this->Session->read('Member.tmpimage');
			
			$src = 'img/members/temp/'.$tmpimage;
			$des = 'img/members/'.$tmpimage;
			
			rename('img/members/temp/'.$tmpimage,'img/members/'.$tmpimage);
			rename('img/members/temp/thumb/'.$tmpimage,'img/members/thumb/'.$tmpimage);
			
		/*	echo '<pre>';
			print_r($this->data);
			die;
			*/
			
		//	$memberdata['Member']['id']     = $this->data['Member']['id'];
		
			$memberdata['Member']['active'] = 1;
			$memberdata['Member']['pwd'] = md5($this->data['Member']['pwd']);
			$memberdata['Member']['email']  = $this->data['Member']['email'];
			$memberdata['Member']['school_id']  = $this->data['Member']['school_id'];
			$memberdata['Member']['group_id'] = $this->Session->read('Member.group_id');
			$memberdata['Member']['fname']  = $this->data['userMeta']['fname'];
			$memberdata['Member']['lname']  = $this->data['userMeta']['lname'];
			
			if($this->data['Member']['facebookId'])
			{
				$memberdata['Member']['facebookId']  = $this->data['Member']['facebookId'];
			}
			
			
			
			
			
		/*	echo 'ok'.'<pre>';
				print_r($_POST);
				print_r($memberdata);
				print_r($_SESSION);
				die;*/
			
			
			$this->Member->create();
			
			if ($this->Member->save($memberdata)) {
				
				
				
				$Lastid = $this->Member->id;
				
				$userMeta['userMeta']['fname']     = $this->data['userMeta']['fname'];
				$userMeta['userMeta']['lname']     = $this->data['userMeta']['lname'];
				$userMeta['userMeta']['address']   = $this->data['userMeta']['address'];
				$userMeta['userMeta']['city']      = $this->data['userMeta']['city'];
				$userMeta['userMeta']['state']     = $this->data['userMeta']['state'];
				$userMeta['userMeta']['zip']       = $this->data['userMeta']['zip'];
				$userMeta['userMeta']['contact']   = $this->data['userMeta']['contact'];
				$userMeta['userMeta']['biography']   = $this->data['userMeta']['biography'];
				$userMeta['userMeta']['member_id'] = $Lastid;
			/*	$userMeta['userMeta']['fb_allow'] = $this->data['userMeta']['fb_allow'];
				$userMeta['userMeta']['email_allow'] = $this->data['userMeta']['email_allow'];*/
				$userMeta['userMeta']['fb_allow'] = 1;
				$userMeta['userMeta']['email_allow'] = $this->data['userMeta']['email_allow'];
				
				
				$this->userMeta->create();
				
				if ($this->userMeta->save($userMeta)) {
					
					if($tmpimage)
					{
						
						$this->Member->updateAll(array('Member.image_name'=>"'".$tmpimage."'"),
												array('Member.id'=>$Lastid)
												);
						
						
						$data['UserImage']['user_id']    = $Lastid;
						$data['UserImage']['image_name'] = $tmpimage;
						$db                              = $this->UserImage->getDataSource();
						$data['UserImage']['created']    = $db->expression("NOW()");
						$data['UserImage']['active']     = 1;
						$this->UserImage->create();
						if ($this->UserImage->save($data)) {
							
							$this->Session->delete('Member.tmpimage');						
						//	$this->redirect(array('controller'=>'homes', 'action'=>'login'));
						}
					}
					
					
				$getMemberData = $this->Member->find('first', array(
					'conditions' => array(
						'Member.id' => $Lastid,
						'Member.active !=' => 3
					)
				));
				
				if (!empty($getMemberData)) {
					
					$this->Session->write('Member.tempmemberid', $getMemberData['Member']['id']);
					
				/*	$this->Session->write('Member.email', $getMemberData['Member']['email']);
					$this->Session->write('Member.memberid', $getMemberData['Member']['id']);
					$this->Session->write('Member.active', $getMemberData['Member']['active']);
					$this->Session->write('Member.group_id', $getMemberData['Member']['group_id']);
					
					if($getMemberData['Member']['facebookId'])
					{
						$this->Session->write('Member.facebook_id', $getMemberData['Member']['facebookId']);
					}*/
					
					// print_r($getMemberData);
					
				/*	if($this->data['Member']['remember'])
					{
						$md5password = md5($password);
						
						$expire=time()+60*60*24*30;
						
						$this->Cookie->write('username', $username, $encrypt = false, $expires = $expire);
						$this->Cookie->write('password', $md5password, $encrypt = false, $expires = $expire);
						
						setcookie( "vegetable", "artichoke", time()+3600, "/" );
					
					}*/
					
				
					
				}	
					
					
				$this->send_first_msg($Lastid);						
					
				$this->redirect(array('controller'=>'homes', 'action'=>'select_courses'));
					
				}
			}
			
			}
			else if($this->Session->read('Member.group_id')==8)
			{
			
			$tmpimage = $this->Session->read('Member.tmpimage');
			
			$src = 'img/members/temp/'.$tmpimage;
			$des = 'img/members/'.$tmpimage;
			
			rename('img/members/temp/'.$tmpimage,'img/members/'.$tmpimage);
			rename('img/members/temp/thumb/'.$tmpimage,'img/members/thumb/'.$tmpimage);
			
		/*	echo '<pre>';
			print_r($this->data);
			die;*/
			
			
		//	$memberdata['Member']['id']     = $this->data['Member']['id'];
		
			$memberdata['Member']['active'] = 1;
			$memberdata['Member']['pwd'] = md5($this->data['Member']['pwd']);
			$memberdata['Member']['email']  = $this->data['Member']['email'];
			$memberdata['Member']['school_id']  = $this->data['Member']['school_id'];
			$memberdata['Member']['group_id'] = $this->Session->read('Member.group_id');
			$memberdata['Member']['fname']  = $this->data['userMeta']['fname'];
			$memberdata['Member']['lname']  = $this->data['userMeta']['lname'];
			
			
			if($this->data['Member']['facebookId'])
			{
				$memberdata['Member']['facebookId']  = $this->data['Member']['facebookId'];
			}
			
			
			
		/*	echo 'ok'.'<pre>';
				print_r($_POST);
				print_r($memberdata);
				print_r($_SESSION);
				die;*/
			
			
			$this->Member->create();
			
			if ($this->Member->save($memberdata)) {
				
				
				
				$Lastid = $this->Member->id;
				
				$userMeta['userMeta']['fname']     = $this->data['userMeta']['fname'];
				$userMeta['userMeta']['lname']     = $this->data['userMeta']['lname'];
				$userMeta['userMeta']['address']   = $this->data['userMeta']['address'];
				$userMeta['userMeta']['city']      = $this->data['userMeta']['city'];
				$userMeta['userMeta']['state']     = $this->data['userMeta']['state'];
				$userMeta['userMeta']['zip']       = $this->data['userMeta']['zip'];
				$userMeta['userMeta']['contact']   = $this->data['userMeta']['contact'];
				$userMeta['userMeta']['biography']   = $this->data['userMeta']['biography'];
				$userMeta['userMeta']['member_id'] = $Lastid;
			/*	$userMeta['userMeta']['fb_allow'] = $this->data['userMeta']['fb_allow'];
				$userMeta['userMeta']['email_allow'] = $this->data['userMeta']['email_allow'];*/
				$userMeta['userMeta']['fb_allow'] = 1;
				$userMeta['userMeta']['email_allow'] = $this->data['userMeta']['email_allow'];
				
				
				$this->userMeta->create();
				
				if ($this->userMeta->save($userMeta)) {
					
					if($tmpimage)
					{
						
						$this->Member->updateAll(array('Member.image_name'=>"'".$tmpimage."'"),
												array('Member.id'=>$Lastid)
												);
						
						
						$data['UserImage']['user_id']    = $Lastid;
						$data['UserImage']['image_name'] = $tmpimage;
						$db                              = $this->UserImage->getDataSource();
						$data['UserImage']['created']    = $db->expression("NOW()");
						$data['UserImage']['active']     = 1;
						$this->UserImage->create();
						if ($this->UserImage->save($data)) {
							
							$this->Session->delete('Member.tmpimage');						
						//	$this->redirect(array('controller'=>'homes', 'action'=>'login'));
						}
					}
					
					
				$getMemberData = $this->Member->find('first', array(
					'conditions' => array(
						'Member.id' => $Lastid,
						'Member.active !=' => 3
					)
				));
				
				if (!empty($getMemberData)) {
					
					$this->Session->write('Member.email', $getMemberData['Member']['email']);
					$this->Session->write('Member.memberid', $getMemberData['Member']['id']);
					$this->Session->write('Member.active', $getMemberData['Member']['active']);
					$this->Session->write('Member.group_id', $getMemberData['Member']['group_id']);
					
					if($getMemberData['Member']['facebookId'])
					{
						$this->Session->write('Member.facebook_id', $getMemberData['Member']['facebookId']);
					}
					
					// print_r($getMemberData);
					
				/*	if($this->data['Member']['remember'])
					{
						$md5password = md5($password);
						
						$expire=time()+60*60*24*30;
						
						$this->Cookie->write('username', $username, $encrypt = false, $expires = $expire);
						$this->Cookie->write('password', $md5password, $encrypt = false, $expires = $expire);
						
						setcookie( "vegetable", "artichoke", time()+3600, "/" );
					
					}*/
					
				
					
				}	
					
				$this->send_first_msg($Lastid);					
				
				$this->redirect(array('controller'=>'homes', 'action'=>'login'));
					
				}
			}
			
			}
		
			
			
			
			
			
			
			
			
			
			
			
			
		}
	}
	
	
	
	function checkMemberEmail()
	{
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$email    = $_REQUEST['data']['Member']['email'];
		
		$email = trim($email);
		
	/*	echo $email;
		
		$count = $this->Member->find('all', array(
			'conditions' => array(
				'Member.email' => $email,
				'Member.active !=' => 3
			),
			'recursive' => -1
		));
		
		print_r($count);
		die;
	*/	
		$count = $this->Member->find('count', array(
			'conditions' => array(
				'Member.email' => $email,
				'Member.active !=' => 3
			),
			'recursive' => -1
		));
		
	//	echo $count;
		
		if ($count > 0) {
			echo "false";
		} else {
			echo "true";
		}
		
	}
	
	
	function forget_password()
	{
		
		if($this->data)
		{
			$email = $this->data['Member']['email'];
			
			$memberData = $this->Member->find('first',array(
												  'conditions'=>
												  array('Member.email'=> $email,
														'Member.active' => 1
														)
												  )
									);
			
			
			if($memberData)
			{
				$id = $memberData['Member']['id'];
				
				$this->Session->setFlash('Email sent.');
				
				$this->forgetpassword_email_template($id);
				
			}
			
			
			/*echo $email;
			echo count($memberData);
			echo $id;
			echo '<pre>';
			print_r($memberData);
			die;*/
			
		}
		
	
	
	}
	
	
	function new_password($memberid = null,$md5email = null,$expire = null)
	{
	
//	echo md5('jspanwarbwr@gmail.com');
	
	$this->set('memberid',$memberid);
	$this->set('md5email',$md5email);
	
	
	if($this->data)
	{
		
		$memberid = $this->data['Member']['id'];
		$email = $this->data['Member']['email'];
		
		
		$memberData = $this->Member->find('first',array('conditions'=>array('md5(Member.email)'=> $email,
																			'Member.id'=> $memberid  	 
																								 )
														)
										  );
		
		
		$this->Member->updateAll(array(
			'Member.pwd' => "'" . md5($this->data['Member']['pwd']) . "'",
		), array(
			'Member.id' => $memberid
		) 
		);
		
		$this->Session->setFlash('Password changed successfully');
		
/*		
		echo '<pre>';
		print_r($memberData);
		print_r($this->data);
		die;*/
		
	}
	else
	{
	
		$current = time(); 
		$diff = $current - $expire;
			
		$hours = round($diff / 3600);
		
		if($hours >= 24) 
		{
			$this->redirect(array('controller'=>'Homes','action' => 'password_expired'));
		}
		
	}
	
	
	}
	
	
	
	
	function img_reg_upload()
	{
		
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
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
		
		
		$medHeight = '169';
		$medWidth  = '245';
		App::Import('Component', 'Upload');
		//print_r($_FILES);die;exit;
		
		$upload = new UploadComponent();
		if (!empty($_FILES)) {
			$destination  = realpath('../../app/webroot/img/members/temp') . '/';
			$destination2 = realpath('../../app/webroot/img/members/temp/thumb') . '/';
			$imgName      = pathinfo($_FILES['userImage']['name']);
			$ext          = $imgName['extension'];
			$time         = explode(" ", microtime());
			$newImgName   = md5($time[1]);
			
			$imageName = $newImgName.'.'.$ext;
			
			
			
			$tempFile     = $_FILES['userImage']['tmp_name'];
			$file         = $_FILES['userImage'];
			if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif') {
				$result = $upload->upload($file, $destination, $newImgName . "." . $ext, array(
					'type' => 'resizemin',
					'size' => array(
						'' . $medWidth . '',
						'' . $medHeight . ''
					)
				));
				
				$resul2 = $upload->upload($file, $destination2, $newImgName . "." . $ext, array(
					'type' => 'resizemin',
					'size' => array(
						'60',
						'60'
					)
				));
		
			if ($result) {
				
				$deleteImg = $this->Session->read('Member.tmpimage');
				
				if($deleteImg)
				{
				
					if(file_exists(ROOT.DS.'app'.DS.'webroot'.DS.'img'.DS.'members'.DS.'temp'.DS.$deleteImg))
					{
	
						unlink(ROOT.DS.'app'.DS.'webroot'.DS.'img'.DS.'members'.DS.'temp'.DS.$deleteImg);
	
					}
					
					if(file_exists(ROOT.DS.'app'.DS.'webroot'.DS.'img'.DS.'members'.DS.'temp'.DS.'thumb'.DS.$deleteImg))
					{
	
						unlink(ROOT.DS.'app'.DS.'webroot'.DS.'img'.DS.'members'.DS.'temp'.DS.'thumb'.DS.$deleteImg);
	
					}
				
				}
				
				$this->Session->write('Member.tmpimage', $imageName);
				
				$this->Session->delete('Member.facebook_id');
				
				echo $newImgName . "." . $ext . "##success";
				exit;
			}
			else
			{
				echo "error";
				exit;	
			}
			
		
		
				
			/*	if ($result) {
					$this->UserImage->updateAll(array(
						'UserImage.active' => "'0'"
					), array(
						'UserImage.user_id' => $this->Session->read('Member.memberid'),
						'UserImage.active !=' => "'0'"
					));
					$data['UserImage']['user_id']    = $this->Session->read('Member.memberid');
					$data['UserImage']['image_name'] = $newImgName . "." . $ext;
					$db                              = $this->UserImage->getDataSource();
					$data['UserImage']['created']    = $db->expression("NOW()");
					$data['UserImage']['active']     = 1;
					$this->UserImage->create();
					
					if ($this->UserImage->save($data)) {
						echo "success";
						exit;
					} else {
						echo "error";
						exit;
					}
				}*/
			}
		}
	}
	
	
	
	
	
	function forgetpassword_email_template($id = null){
		
		$memberData = $this->Member->find('first',array(
												  'conditions'=>
												  array('Member.id'=> $id,
														'Member.active' => 1
														)
												  )
									);
			
		
		
		$to	= $memberData['Member']['email'];
		$memberid = $memberData['Member']['id'];
		$name = $memberData['userMeta']['fname'].' '.$memberData['userMeta']['lname'];
		$md5email = md5($to);
		$expire = time();
		
		$this->set('name', $name );
		$this->set('memberid', $memberid );
		$this->set('md5email', $md5email );
		$this->set('HTTP_ROOT', HTTP_ROOT );
		$this->set('expire', $expire );
		

		
	//	$email_template = $this->get_email_template('date_booking_confirmation');							
	
		$email_template = $this->get_email_template(8);										
																							
		$this->Email->to = $to;
		
		$this->Email->replyTo = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->from = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->subject = $email_template['EmailTemplate']['subject'];
									
		$this->Email->sendAs = 'html';
		
		$this->Email->template = 1;
		
		$email_template_content =  $this->render_email_template($email_template['EmailTemplate']['html_content']);
			
		$this->set('email_template_content',$email_template_content);	
		
		$this->Email->template = 'email_template';	
		
		$this->Email->smtpOptions = array(
		'port'=>'465', 
		'timeout'=>'30',
		'auth' => true,
		'host' => 'ssl://smtp.tutorcause.com',
		'username'=>'notifications@tutorcause.com',
		'password'=>'3micedownlow',
		
		);
		

		$this->set('smtp_errors', $this->Email->smtpError);
		
		/*echo '<pre>';
		print_r($this->Email);
		die;*/
		
										
		$this->Email->send();
		
	}
	
	
	function set_availability($id = null)
	{
		$this->layout = 'frontend';
		
		$tutevent = $this->TutEvent->find('all', array(
			'conditions' => array(
				'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid'),
				'TutEvent.start_date >=' => date('Y-m-d'),
			),
			'order'=>array('TutEvent.start_date ASC'),
			'recursive' => -1
		));
		
	/*	echo '<pre>';
		print_r($tutevent);
		die;
		*/
		
		$seteventtime = $this->TutEvent->find('first', array(
			'conditions' => array(
				'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid'),
				'TutEvent.start_date >=' => date('Y-m-d'),
				'TutEvent.title' => 'Booked'
			),
			'order'=>array('TutEvent.start_date ASC'),
			'recursive' => -1
		));
		
		
	/*	echo '<pre>';
		print_r($senteventtime);
		die;*/
		
		
		
		
		if($seteventtime['TutEvent']['start_date'])
	{
		  $startdate = $seteventtime['TutEvent']['start_date'];
		  $day = date("j", strtotime($startdate));
		  $month = date("n", strtotime($startdate));
		  $month = $month - 1;
		  $year = date("Y", strtotime($startdate));
		  
		  $this->set('day',$day);
		  $this->set('month',$month);
		  $this->set('year',$year);
	}
	
	$this->set('tutevent', $tutevent);
			
	/*	pr($tutevent);
		die;*/
		
	/*	if (isset($id) && $id != '') {
			$profile = 'edit';
			$this->set('profile', $profile);
		}*/
		
	}
	
	function selecteditevent()
	{
		
		$this->layout = "";
		Configure::write('debug', 0);
		$this->autoRender = false;
	
	    $id = $_REQUEST['id'];
		$timediff = $_REQUEST['timediff'];
	
		$eventdata =  $this->TutEvent->find('first',array('conditions'=>array('TutEvent.id'=> $id )
																)
							  );
		
		$start_formatted_date = $eventdata['TutEvent']['start_date'];
		
		$cookie_year = date('Y', strtotime($start_formatted_date));
		$cookie_month = date('m', strtotime($start_formatted_date));
		$cookie_day = date('d', strtotime($start_formatted_date));
		
		$past_end_date = $eventdata['TutEvent']['end_date'];
		
		$timedifference = $timediff." minutes";
		
		$end_formatted_date = date('Y-m-d H:i:s',strtotime($timedifference, strtotime($past_end_date)));
		
	
		$comparestart =	$this->TutEvent->find('all',array('conditions' =>
												  array(
														'TutEvent.id !='=>$id,
														'TutEvent.start_date between ? and ?' => array($start_formatted_date,$end_formatted_date),
														'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')),
												  	  'recursive' => -1
												  ));
		
		
		$compareend =	$this->TutEvent->find('all',array('conditions' =>
											  array(
													'TutEvent.id !='=>$id,
													'TutEvent.end_date between ? and ?' => array($start_formatted_date,$end_formatted_date),
													'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')),
											  		
											  'recursive' => -1
											  ));
		
		
		
			if(count($comparestart) > 0 || count($compareend) > 0)
			{
				    $x = 'allready';
				
					$resp = $x.','.$cookie_year.','.$cookie_month.','.$cookie_day;	
					
			}
			else
			{	
					$this->TutEvent->updateAll(array(
					'TutEvent.end_date' => "'" . $end_formatted_date . "'",
					), array(
					'TutEvent.id' => $id
					) //(conditions) where userid=schoolid
					);
					
					$x = 'ok';
				
					$resp = $x.','.$cookie_year.','.$cookie_month.','.$cookie_day;	
			}
			
		/*	echo '<pre>';
			print_r($_REQUEST);
			print_r($comparestart);
			print_r($compareend);
			
			echo $timedifference.'<br/>';
			echo $past_end_date.'<br/>';
			echo $end_formatted_date.'<br/>';
			*/
			
			
			echo $resp;
			die;
			
		
		
	}
	
	
	function selectaddevent() {
		$this->layout = "";
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$start = $_GET['var1'];
		$end   = $_GET['var2'];
		$allday   = $_GET['var3'];
		
	//	echo $start.'lastdate'.$end.'allday'.$allday;
		
		
		
		
		
		$startexp = explode("GMT", $start);
		$endexp   = explode("GMT", $end);
		
		$start_formatted_date = date('Y-m-d H:i:s', strtotime($startexp[0]));
		$end_formatted_date   = date('Y-m-d H:i:s', strtotime($endexp[0]));
		
		$cookie_year = date('Y', strtotime($startexp[0]));
		$cookie_month = date('m', strtotime($startexp[0]));
		$cookie_day = date('d', strtotime($startexp[0]));
		
		
/*		 $this->LogfileRecord->find('all',
  'conditions' => array('LogfileRecord.date between ? and ?' => array($start_date, $end_date)));
*/      
		
		$addedYet="";
		
		if($allday == 'true' )
		{
		
		$start_formatted_day = date('Y-m-d', strtotime($startexp[0]));
			
		$comparestartday =	$this->TutEvent->find('all',array('conditions' =>
									  array(
											'TutEvent.start_date LIKE' => "%".$start_formatted_day."%",
											'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')),
									  'recursive' => -1
									  ));
		
	//	print_r($comparestartday);
		
		
		
			if(count($comparestartday))
			{
				$addedYet = -3;
			}
			
		}
		else
		{
		
		$comparestart =	$this->TutEvent->find('all',array('conditions' =>
												  array(
														'TutEvent.start_date between ? and ?' => array($start_formatted_date,$end_formatted_date),
														'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')),
												  'recursive' => -1
												  ));
		
		
		
		
		
		if($comparestart){
			
		$addedYet = -3; 

			
		/*	// pick all four dates and then select lowest and highest 
			$first_date = $start_formatted_date;
			$second_date = $end_formatted_date;
			$third_date = $comparestart[0]['TutEvent']['start_date'];
			$four_date = $comparestart[0]['TutEvent']['end_date'];
			if($second_date<=$four_date){
				$final_end=$four_date;
			}
			else{
				$final_end=$second_date;
			}
			if($first_date<=$third_date){
				$final_start=$first_date;
			}
			else{
				$final_start=$third_date;
			}
			
			//update query
			
				$this->TutEvent->updateAll(array('TutEvent.start_date'=>"'".$final_start."'",'TutEvent.end_date'=>"'".$final_end."'"),array('TutEvent.id'=>$comparestart[0]['TutEvent']['id']));
				$addedYet=$comparestart[0]['TutEvent']['id'];	
			
	*/
		
		}
		
		else{
			
			$compareend =	$this->TutEvent->find('all',array('conditions' =>
												  array(
														'TutEvent.end_date between ? and ?' => array($start_formatted_date,$end_formatted_date),
														'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')),
												  'recursive' => -1
												  ));
		
			if($compareend){
				
				
			$addedYet = -3; 

				
				/*
				// pick all four dates and then select lowest and highest 
				$first_date = $start_formatted_date;
				$second_date = $end_formatted_date;
				$third_date = $compareend[0]['TutEvent']['start_date'];
				$four_date = $compareend[0]['TutEvent']['end_date'];
				if($second_date<=$four_date){
					$final_end=$four_date;
				}
				else{
					$final_end=$second_date;
				}
				if($first_date<=$third_date){
					$final_start=$first_date;
				}
				else{
					$final_start=$third_date;
				}
				
				
				$this->TutEvent->updateAll(array('TutEvent.start_date'=>"'".$final_start."'",'TutEvent.end_date'=>"'".$final_end."'"),array('TutEvent.id'=>$compareend[0]['TutEvent']['id']));
				$addedYet=$compareend[0]['TutEvent']['id'];
				// pick all four dates and then select lowest and highest 
				//update query   
				*/
			
			}
		
		}
		
		}

		
		
		$this->addevent['TutEvent']['start_date'] = $start_formatted_date;
		
		if($allday=='true' && count($comparestartday)==0)
		{
			
		$startdayplusunix = strtotime("+1 day", strtotime($startexp[0]));	
		
		$this->addevent['TutEvent']['end_date'] =  date('Y-m-d H:i:s', $startdayplusunix);
			
		}
		else
		{
		$this->addevent['TutEvent']['end_date'] = $end_formatted_date;
		}
		
		$this->addevent['TutEvent']['tutor_id'] = $this->Session->read('Member.tempmemberid');
		
	/*	echo '<pre>';
		echo $start;
		print_r (explode("GMT",$start));
		echo 'allday'.$allday;
		echo 'addedyet'.$addedYet;
		print_r($this->addevent);
		die;*/
		
	
		//$this->redirect(array('controller'=>'Members','action' => 'calendar'));
		
		
		$currentdate = date('Y-m-d H:i:s');
		
		$current_ts = strtotime($currentdate);
		
		$start_ts = strtotime($start_formatted_date);
		
		$end_ts = strtotime($end_formatted_date);
		
		$diffhours = $end_ts - $start_ts;
		
		$diffmin = round($diffhours / 60);
		
		
		
		$diff = $current_ts - $start_ts;
		
		if($diff > 0 )
		{
			
		$x= -2; 
		echo $x.','.$cookie_year.','.$cookie_month.','.$cookie_day;	
		}
	/*	else if($diffmin <= 30 )
		{
		   $z = -4;	 
		   echo $z.','.$cookie_year.','.$cookie_month.','.$cookie_day;	
		}  */
		else
		{
			if($addedYet==""){
				$this->TutEvent->Save($this->addevent);
				$id = $this->TutEvent->id;
				echo $id.','.$cookie_year.','.$cookie_month.','.$cookie_day;
			}
			else
			{
				echo $addedYet.','.$cookie_year.','.$cookie_month.','.$cookie_day;
			}
			
		}
		
		
		
	}
	
	
	function savefbid()
	{
		
		$this->layout = "";
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		
		
	/*	Configure::write('debug', 0);*/
		
	/*	echo '<pre>';
		print_r($_REQUEST);
		echo '</pre>';
		die;*/
		
		
		if($_REQUEST['id'])
		{
			
			$fbId = $_REQUEST['id'];
			$fname = $_REQUEST['first'];
			$lname = $_REQUEST['last'];
			$email = $_REQUEST['email'];
			
			$count = $this->Member->find('count', array(
			'conditions' => array(
			'Member.facebookId' => $fbId,
			'Member.active !=' => 3
			),
			'recursive' => -1
			));
			//	echo $count;
			
			if ($count > 0) {
			echo "false";
			} else {
			$this->Session->write('Member.facebook_id',$fbId);
			$this->Session->write('Member.fname',$fname);
			$this->Session->write('Member.lname',$lname);
			$this->Session->write('Member.email',$email);
			
			$this->Session->delete('Member.tmpimage');
				
			$this->Session->write('Member.facebook_id',$fbId);	
			echo "true";
			}
			
		 /*	$this->Cookie->delete('fbs_226449800757981');
			
			setcookie("fbs_226449800757981", "", time()-3600);*/
			
		}
		
	//	$this->redirect($this->referer());
		
		die;
		
		/*
		Configure::write('debug', 0);
		
		
		if($this->data)
		{
			$fbId = $this->data['Member']['facebookId'];
			
			$fname = $this->data['Member']['fname'];
			
			$lname = $this->data['Member']['lname'];
			
			$email = $this->data['Member']['email'];
			
			$this->Session->write('Member.facebook_id',$fbId);
			$this->Session->write('Member.fname',$fname);
			$this->Session->write('Member.lname',$lname);
			$this->Session->write('Member.email',$email);
			
			$this->Session->delete('Member.tmpimage');
			
		}
		
		
		$this->redirect($this->referer());
		
		die;*/
		
	}
	
	
	function select_courses()
	{
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$schools      = $this->School->find('all');
		$this->set('schools', $schools);
		
		$tutcources = $this->TutCourse->find('all', array(
			'conditions' => array(
				'TutCourse.member_id' => $this->Session->read('Member.tempmemberid')
			)
		));
		
		$memberdata = $this->Member->find('first',array(
												'conditions' => array('Member.id' => $this->Session->read('Member.tempmemberid')),
												'recursive' => -1
														)
										  );
		
		
		$min_wage = $this->Wage->find('all',array(
													'conditions'=>array('Wage.id'=> '1'),
													)
									  );
		
		$this->set('min_wage', $min_wage);
		
		$this->set('memberdata', $memberdata);
		
		$this->set('tutcources', $tutcources);
		
	}
	
	
	function addcourse($id = NULL) {
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
	/*	
		pr($this->data);
		echo $id;
		die;*/
		
		
		if ($id != "") {
			$this->TutCourse->deleteAll(array(
				'TutCourse.member_id' => $this->Session->read('Member.tempmemberid')
			));
		}
		
		//die;
		$i = 0;
		foreach ($this->data['TutCourse']['course_id'] as $data) {
			$mySaving['TutCourse']['school_id'] = $this->data['TutCourse']['school_id'];
			$mySaving['TutCourse']['course_id'] = $this->data['TutCourse']['course_id'][$i];
			$mySaving['TutCourse']['rate']      = $this->data['TutCourse']['rate'][$i];
			$mySaving['TutCourse']['member_id'] = $this->Session->read('Member.tempmemberid');
			$db                                 = $this->TutCourse->getDataSource();
			$mySaving['TutCourse']['created']   = $db->expression("NOW()");
			if ($mySaving['TutCourse']['course_id']) {
				$this->TutCourse->create();
				$saved = $this->TutCourse->save($mySaving['TutCourse']);
			}
			$i++;
			
		}
		if ($saved) {
		//	$this->Session->setFlash('Your courses has been saved successfully');
			
		/*	$this->Member->updateAll(array(
				'Member.school_id' => "'" . $this->data['TutCourse']['school_id'] . "'"
			), array(
				'Member.id' => $this->Session->read('Member.tempmemberid')
			));*/
			
			
			$this->redirect(array(
				'controller' => 'homes',
				'action' => 'set_availability'
			));
		} else {
			
			$this->redirect(array(
				'controller' => 'homes',
				'action' => 'select_courses'
			));
		}
		
	}
	
	
	
	function deletecourse() {
		$deleteCourse = $this->TutCourse->deleteAll(array(
			'TutCourse.member_id' => $this->Session->read('Member.tempmemberid'),
			'TutCourse.school_id' => $_REQUEST['schoolId'],
			'TutCourse.course_id' => $_REQUEST['courseId']
		));
		if ($deleteCourse) {
			echo "1";
			exit;
		} else {
			echo mysql_error();
			exit;
		}
		
		
	}
	
	
	
	function copyschedule() {
		
		
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->autoRender = false;
		
		/*	
		echo '<pre>';
		print_r($_POST);
		die;*/
		
		
		if (isset($this->data)) {
			
			
			$stime = date("H:i:s",strtotime($this->data['TutEvent']['starttime']));
			$etime = date("H:i:s",strtotime($this->data['TutEvent']['endtime']));
			
			
			
			
			if ($this->data['TutEvent']['spe_date']) {
				
				$sourcedate = date("Y-m-d", strtotime($this->data['TutEvent']['source_date']));
				
				
				$desdate = date('Y-m-d', strtotime($this->data['TutEvent']['spe_date']));
				
				
				$finalstime = $sourcedate.' '.$stime;
				$finaletime = $sourcedate.' '.$etime;
				
				
				if($this->data['TutEvent']['allday'])
				{
						$sourcetime = $this->TutEvent->find('all', array(
							'conditions' => array(
								'TutEvent.start_date  LIKE' => "%" . $sourcedate . "%",
								'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')
							),
							'recursive'=>-1
						));
				}
				else
				{
						$sourcetime = $this->TutEvent->find('all', array(
							'conditions' => array(
								'TutEvent.start_date >=' => $finalstime,
								'TutEvent.end_date <=' => $finaletime,
								'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')
							),
							'recursive'=> -1
						));
				}
				
				for ($j = 0; $j < count($sourcetime); $j++) {
					$timestart = date('H:i', strtotime($sourcetime[$j]['TutEvent']['start_date']));
					$timeend   = date('H:i', strtotime($sourcetime[$j]['TutEvent']['end_date']));
					
					$finalstartdate = $desdate . ' ' . $timestart;
					
					$finalenddate = $desdate . ' ' . $timeend;
					
					$result = $this->collapseevent($finalstartdate , $finalenddate);
					
					if($result=='true')
					{
						continue;
					}
					
					
					$this->TutEvent->create();
					
					$this->copyevent['TutEvent']['start_date'] = $finalstartdate;
					
					$this->copyevent['TutEvent']['end_date'] = $finalenddate;
					
					$this->copyevent['TutEvent']['tutor_id'] = $this->Session->read('Member.tempmemberid');
					
					$this->TutEvent->Save($this->copyevent);
				}
				
			
				
			} else {
				$sourcedate = date("Y-m-d", strtotime($this->data['TutEvent']['source_date']));
				
				$startdate = date("Y-m-d", strtotime($this->data['TutEvent']['start_date']));
				
				$replacedate = $this->data['TutEvent']['end_date'];
				
				$desdate = date('Y-m-d', strtotime($replacedate));
				
				
				$finalstime = $startdate.' '.$stime;
				$finaletime = $startdate.' '.$etime;
				
				/*echo $finalstime;
				echo $finaletime;*/
				
				
				
				if($this->data['TutEvent']['allday'])
				{
					$sourcetime = $this->TutEvent->find('all', array(
						'conditions' => array(
							'TutEvent.start_date  LIKE' => "%" . $sourcedate . "%",
							'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')
						),
						'recursive'=>-1
					));
				}
				else
				{
					$sourcetime = $this->TutEvent->find('all', array(
						'conditions' => array(
							'TutEvent.start_date >=' => $finalstime,
							'TutEvent.end_date <=' => $finaletime,
							'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')
						),
						'recursive'=> -1
					));
				}
				
			/*	echo '<pre>';
				print_r($sourcetime);
				die;*/
				
				
				
				$days = $this->dateDiff($startdate, $desdate);
				
				
				for ($counter = 1; $counter <= $days; $counter++) {
					$srcplusone = date('Y-m-d', strtotime("+$counter day", strtotime($startdate)));
					
					/*echo $srcplusone;
					die;*/
					
					for ($j = 0; $j < count($sourcetime); $j++) {
						$timestart = explode(' ', $sourcetime[$j]['TutEvent']['start_date']);
						$timeend   = explode(' ', $sourcetime[$j]['TutEvent']['end_date']);
						
						$finalstartdate = $srcplusone . ' ' . $timestart[1];
						
						$finalenddate = $srcplusone . ' ' . $timeend[1];
						
						
						$result = $this->collapseevent($finalstartdate , $finalenddate);
					
						if($result=='true')
						{
							continue;
						}
						
						$this->TutEvent->create();
						
						$this->copyevent['TutEvent']['start_date'] = $finalstartdate;
						
						$this->copyevent['TutEvent']['end_date'] = $finalenddate;
						
						$this->copyevent['TutEvent']['tutor_id'] = $this->Session->read('Member.tempmemberid');
						
						$this->TutEvent->Save($this->copyevent);
					}
				}
				
				
			}
			
			$this->redirect(array(
				'controller' => 'homes',
				'action' => 'set_availability'
			));
		}
		
	}
	
	function copyweek() {
		
	/*	echo '<pre>';
		print_r($_POST);*/
		
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;
		
	/*	$source_start_date = strtotime($this->data['TutEvent']['source_week_date']);
		$source_end_date   = strtotime(date("Y-m-d", $source_start_date) . " +7 days");
		
		
		$source_start_date = strtotime($this->data['TutEvent']['source_date']);
		$source_end_date   = $source_start_date;
		
		$start_on          = strtotime($this->data['TutEvent']['start_week_date']);
		$end_on            = strtotime($this->data['TutEvent']['end_week_date']);  */
		
		$endsRadio         = $this->data['TutEvent']['endsOn'];
		
		
	/*	$occur             = $this->data['TutEvent']['occur'];*/
		
		
		
		
				$sourcedate = date("Y-m-d", strtotime($this->data['TutEvent']['source_date']));
				
				$stime = date("H:i:s",strtotime($this->data['TutEvent']['starttime']));
				$etime = date("H:i:s",strtotime($this->data['TutEvent']['endtime']));
				
				
				$finalstime = $sourcedate.' '.$stime;
				$finaletime = $sourcedate.' '.$etime;
		
			
				$startdate = date("Y-m-d", strtotime($this->data['TutEvent']['start_week_date']));
				
				$replacedate = $this->data['TutEvent']['end_week_date'];
				
				$desdate = date('Y-m-d', strtotime($replacedate));
				
				
				$finalstime = $startdate.' '.$stime;
				$finaletime = $startdate.' '.$etime;
				
				/*echo $finalstime;
				echo $finaletime;*/
				
				
				
				if($this->data['TutEvent']['allday'])
				{
					$sourcetime = $this->TutEvent->find('all', array(
						'conditions' => array(
							'TutEvent.start_date  LIKE' => "%" . $sourcedate . "%",
							'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')
						),
						'recursive'=>-1
					));
				}
				else
				{
					$sourcetime = $this->TutEvent->find('all', array(
						'conditions' => array(
							'TutEvent.start_date >=' => $finalstime,
							'TutEvent.end_date <=' => $finaletime,
							'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')
						),
						'recursive'=> -1
					));
				}
				
			/*	echo '<pre>';
				print_r($sourcetime);
				die;*/
				
				
				
				$days = $this->dateDiff($startdate, $desdate);
				
				
				for ($counter = 1; $counter <= $days; $counter++) {
					$srcplusone = date('Y-m-d', strtotime("+$counter day", strtotime($startdate)));
					
					if (in_array(date('D', strtotime("+$counter day", strtotime($startdate)) ), $this->data['TutEvent']['checkdate'])) {
						
					/*	echo 'if';
						echo date('D', $srcplusone);
						print_r($this->data['TutEvent']['checkdate']);
						die;*/
						
					}
					else
					{
						/*echo 'else';
						echo date('D', $srcplusone);
						print_r($this->data['TutEvent']['checkdate']);
						die;*/
						continue;
					}
					
					
					/*echo $srcplusone;
					die;*/
					
					for ($j = 0; $j < count($sourcetime); $j++) {
						$timestart = explode(' ', $sourcetime[$j]['TutEvent']['start_date']);
						$timeend   = explode(' ', $sourcetime[$j]['TutEvent']['end_date']);
						
						$finalstartdate = $srcplusone . ' ' . $timestart[1];
						
						$finalenddate = $srcplusone . ' ' . $timeend[1];
						
						
						$result = $this->collapseevent($finalstartdate , $finalenddate);
					
						if($result=='true')
						{
							continue;
						}
						
						$this->TutEvent->create();
						
						$this->copyevent['TutEvent']['start_date'] = $finalstartdate;
						
						$this->copyevent['TutEvent']['end_date'] = $finalenddate;
						
						$this->copyevent['TutEvent']['tutor_id'] = $this->Session->read('Member.tempmemberid');
						
						$this->TutEvent->Save($this->copyevent);
					}
				}
				
		

			
			$this->redirect(array(
				'controller' => 'homes',
				'action' => 'set_availability'
			));
			
		
		
	
		
		
		
		
		
		
		/*
		
		$this->autoRender  = false;
		$source_start_date = strtotime($this->data['TutEvent']['source_week_date']);
		$source_end_date   = strtotime(date("Y-m-d", $source_start_date) . " +7 days");
		$start_on          = strtotime($this->data['TutEvent']['start_week_date']);
		$end_on            = strtotime($this->data['TutEvent']['end_week_date']);
		$endsRadio         = $this->data['TutEvent']['endsOn'];
		$occur             = $this->data['TutEvent']['occur'];
		if (date('D', $source_start_date) != date('D', $start_on)) {
			$this->Session->setFlash('Source day and start day do not match!');
			$this->redirect(array(
				'controller' => 'homes',
				'action' => 'set_availability'
			));
		} else {
			for ($i = $source_start_date, $k = 0; $i <= $source_end_date; $i++, $k++) {
				if (in_array(date('D', $i), $this->data['TutEvent']['checkdate'])) {
					$sourcetime = $this->TutEvent->find('all', array(
						'conditions' => array(
							'TutEvent.start_date  LIKE' => "%" . date('Y-m-d', $i) . "%",
							'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')
						)
					));
					foreach ($sourcetime as $key => $value) {
						if ($endsRadio == "on") {
							//echo "1";exit;
							for ($j = $start_on; $j <= $end_on; $j++) {
								$this->TutEvent->create();
								$this->copyevent['TutEvent']['start_date'] = date('Y-m-d', ($j + (60 * 60 * 24 * $k))) . " " . date('H:i:s', strtotime($value['TutEvent']['start_date']));
								$this->copyevent['TutEvent']['end_date']   = date('Y-m-d', ($j + (60 * 60 * 24 * $k))) . " " . date('H:i:s', strtotime($value['TutEvent']['end_date']));
								$this->copyevent['TutEvent']['tutor_id']   = $value['TutEvent']['tutor_id'];
								$this->Session->read('Member.tempmemberid');
								$this->TutEvent->Save($this->copyevent);
								
								$j = $j + (60 * 60 * 24 * 7);
							}
						} else if ($endsRadio == "occ") {
							//echo "ok";exit;
							for ($j = $start_on, $l = 1; $l <= $occur; $j++, $l++) {
								// echo $j."<br>";
								$this->TutEvent->create();
								$this->copyevent['TutEvent']['start_date'] = date('Y-m-d', ($j + (60 * 60 * 24 * $k))) . " " . date('H:i:s', strtotime($value['TutEvent']['start_date']));
								$this->copyevent['TutEvent']['end_date']   = date('Y-m-d', ($j + (60 * 60 * 24 * $k))) . " " . date('H:i:s', strtotime($value['TutEvent']['end_date']));
								$this->copyevent['TutEvent']['tutor_id']   = $value['TutEvent']['tutor_id'];
								$this->Session->read('Member.tempmemberid');
								$this->TutEvent->Save($this->copyevent);
								
								$j = $j + (60 * 60 * 24 * 7);
							}
							//exit();
						}
					}
				}
				$i = $i + (60 * 60 * 24);
			}
			$this->redirect(array(
				'controller' => 'homes',
				'action' => 'set_availability'
			));
		}*/
		
		
		
	}
	
	
	
	function dateDiff($start, $end) {
		
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;
		
		
		$start_ts = strtotime($start);
		
		$end_ts = strtotime($end);
		
		$diff = $end_ts - $start_ts;
		
		return round($diff / 86400);
		
	}  
	
	
	function settutorsession()
	{
		
		
		$getMemberData = $this->Member->find('first', array(
					'conditions' => array(
						'Member.id' => $this->Session->read('Member.tempmemberid'),
						'Member.active !=' => 3
					)
				));
				
			if (!empty($getMemberData)) {
			
				
				$this->Session->write('Member.email', $getMemberData['Member']['email']);
				$this->Session->write('Member.memberid', $getMemberData['Member']['id']);
				$this->Session->write('Member.active', $getMemberData['Member']['active']);
				$this->Session->write('Member.group_id', $getMemberData['Member']['group_id']);
				
				if($getMemberData['Member']['facebookId'])
				{
					$this->Session->write('Member.facebook_id', $getMemberData['Member']['facebookId']);
				}
				
				// print_r($getMemberData);
				
			/*	if($this->data['Member']['remember'])
				{
					$md5password = md5($password);
					
					$expire=time()+60*60*24*30;
					
					$this->Cookie->write('username', $username, $encrypt = false, $expires = $expire);
					$this->Cookie->write('password', $md5password, $encrypt = false, $expires = $expire);
					
					setcookie( "vegetable", "artichoke", time()+3600, "/" );
				
				}*/
				
			
				
			}	
				
					
		$this->redirect(array('controller'=>'homes', 'action'=>'login'));
		
		
		
		
	}
	
	
	function password_expired()
	{
	
		Configure::write('debug', 0);
		
		$this->layout="frontend";
	
		$statdatas= $this->Page->find('all',array('conditions'=> array('Page.id' => '45')));
		$this->set("statdatas",$statdatas);
		
	}
	
	
	function send_first_msg($id=NULL)
	{
		
		$data['TutMessage']['to_id']           = $id;
		
		$toMemberData = $this->userMeta->find(
				'first',
				array(
					'conditions' => array(
						'userMeta.member_id' => $data['TutMessage']['to_id']
					)
				)
			);
		
		$userName = $toMemberData['userMeta']['fname'].' '.$toMemberData['userMeta']['lname'];
		
		$data['TutMessage']['from_id']         = 1;
		$data['TutMessage']['conversation_id'] = uniqid();
		
		if($this->Session->read('Member.group_id')==6)
		{
			$data['TutMessage']['subject']  = 'Welcome '.$userName;
			$data['TutMessage']['message']  = "Bake Sales are over for your philanthropy, because your group is now equipped with a powerful partner - TutorCause.  The TutorCause team's mission is to help your philanthropy achieve its fundraising goals. We're here to help with any questions along the way.";
		}
		else if($this->Session->read('Member.group_id')==7)
		{
			$data['TutMessage']['subject']  = 'Welcome '.$userName;
			$data['TutMessage']['message']  = "You've achieved the first step towards a better tutoring experience. With TutorCause, you can use the extra money you're earning to pay down student loans, support a philanthropy, or just earn some pocket money!  The TutorCause team's mission is to make you successful, so as you use TutorCause, please tell us how to help.";
		}
		else if($this->Session->read('Member.group_id')==8)
		{
			$data['TutMessage']['subject']  = 'Welcome '.$userName;
			$data['TutMessage']['message']  = "Get ready to achieve the grades you always wanted with TutorCause!  Please contact your friends at TutorCause with any questions. ";
		}
		
		
		
		$data['TutMessage']['datetime']        = date('Y-m-d H:i:s');
		$data['TutMessage']['status']          = 0;
		$this->TutMessage->create();
		if($this->TutMessage->save($data)){/*
			$toMemberData = $this->userMeta->find(
				'first',
				array(
					'conditions' => array(
						'userMeta.member_id' => $data['TutMessage']['to_id']
					)
				)
			);
			$fromMemberData = $this->userMeta->find(
				'first',
				array(
					'conditions' => array(
						'userMeta.member_id' => $data['TutMessage']['from_id']
					)
				)
			);
			if($toMemberData['userMeta']['email_allow']==1){
				$sendMessage = $this->sendEmailAlert($toMemberData['Member']['email'],$toMemberData['userMeta']['fname'],$fromMemberData['userMeta']['fname'],$data['TutMessage']['subject'],$data['TutMessage']['message']);
			}
			echo "Message Sent";
			exit;
		*/}
		
		return true;
		
	}
	
	
	function collapseevent($start,$end)
	{
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
	
		$comparestart =	$this->TutEvent->find('all',array('conditions' =>
												  array(
														'TutEvent.start_date between ? and ?' => array($start,$end),
														'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')),
												  	  'recursive' => -1
												  ));
		
		
		$compareend =	$this->TutEvent->find('all',array('conditions' =>
											  array(
													'TutEvent.end_date between ? and ?' => array($start,$end),
													'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')),
											  		
											  'recursive' => -1
											  ));
		
		
		$comparemid = $this->TutEvent->find('all',array('conditions' =>
											  array(
													'TutEvent.start_date <=' => $start,
													'TutEvent.end_date >=' => $end,
													'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid')),
											  		
											  'recursive' => -1
											  ));
		
		if(count($comparestart) > 0 || count($compareend) > 0 || count($comparemid) > 0 )
		{
				 return 'true';
		}
		else
		{	
				return 'false';
		}
		
		/*$eventData = $this->TutEvent->find('all',array('conditions'=>
													array('TutEvent.start_date >='=>$start,
														  'TutEvent.end_date <='=>$end,
														  'TutEvent.tutor_id'=> $this->Session->read('Member.memberid')
														  ),
													'recursive'=>-1
																		)
									  );
		
		if(count($eventData))
		{
		  return 'true';
		}
		else
		{
		  return 'false';
		}*/
		
		
		/*echo '<pre>';
		print_r($eventData);
		echo count($eventData);
		die;*/
		
		
		
	}
	
	
	
	function editschedule()
	{
		
		/*echo '<pre>';
		print_r($_REQUEST);
		die;*/
		
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$id = $_REQUEST['id'];
		
		$eventdata =  $this->TutEvent->find('first',array('conditions'=>array('TutEvent.id'=> $id )
																)
							  );
		
		$start_formatted_date = $eventdata['TutEvent']['start_date'];
		
		$cookie_year = date('Y', strtotime($start_formatted_date));
		$cookie_month = date('m', strtotime($start_formatted_date));
		$cookie_day = date('d', strtotime($start_formatted_date));
		
		
		$desdate = date('Y-m-d', strtotime($_REQUEST['sdate']));
		$timestart = date('H:i', strtotime($_REQUEST['stime']));
		$timeend   = date('H:i', strtotime($_REQUEST['etime']));
		
		if($_REQUEST['stime']=='' || $_REQUEST['etime']=='')
		{
		  
		  $x = 'blank';
          $resp = $x.','.$cookie_year.','.$cookie_month.','.$cookie_day;	
		  
		  
		}
		else if($timestart >= $timeend )
		{
		  $x = 'greater';
          $resp = $x.','.$cookie_year.','.$cookie_month.','.$cookie_day;	
		  
		}
		else
		{
		
			$finalstartdate = $desdate . ' ' . $timestart;
			
			$finalenddate = $desdate . ' ' . $timeend;
			
			$result = $this->collapseeventid($finalstartdate , $finalenddate , $id);
			
			if($result=='false')
			{
				
				/*echo 'finalsdate'.$finalstartdate;
				echo 'finalenddate'.$finalenddate;
				echo 'id'.$id;
				die;*/
				
				
				$this->TutEvent->updateAll(array(
				'TutEvent.start_date' => "'".$finalstartdate."'",
				'TutEvent.end_date' => "'".$finalenddate."'",
				), array(
				'TutEvent.id' => $id
				));
				
				$x = 'ok';
		        $resp = $x.','.$cookie_year.','.$cookie_month.','.$cookie_day;	
				
			}
			else
			{
				$x = 'allready';
		        $resp = $x.','.$cookie_year.','.$cookie_month.','.$cookie_day;	
				
			}
		
		}
		
		
		echo $resp;
		die;
		
	/*	echo $result;
		echo '<pre>';
		print_r($_POST);
		die;
		*/
		
		
	}
	
	
	
	
	function collapseeventid($start=NULL,$end=NULL,$id=NULL)
	{
				
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		
	
		$comparestart =	$this->TutEvent->find('all',array('conditions' =>
												  array(
														'TutEvent.start_date between ? and ?' => array($start,$end),
														'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid'),
														'TutEvent.id !=' => $id   ),
												        
												  	  'recursive' => -1
												  ));
		
		
		$compareend =	$this->TutEvent->find('all',array('conditions' =>
											  array(
													'TutEvent.end_date between ? and ?' => array($start,$end),
													'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid'),
													'TutEvent.id !=' => $id),
											  		
											  'recursive' => -1
											  ));
		
		
		$comparemid = $this->TutEvent->find('all',array('conditions' =>
											  array(
													'TutEvent.start_date <=' => $start,
													'TutEvent.end_date >=' => $end,
													'TutEvent.tutor_id' => $this->Session->read('Member.tempmemberid'),
													'TutEvent.id !=' => $id ),
											  		
											  'recursive' => -1
											  ));
		
		
		
		
		if(count($comparestart) > 0 || count($compareend) > 0 || count($comparemid) > 0 )
		{
				 return 'true';
		}
		else
		{	
				return 'false';
		}
			
			
		/*echo '<pre>';
		print_r($comparestart);
		print_r($compareend);
		print_r($comparemid);
		die;*/
		
		
	}
	
	
	
	
	
}
?>