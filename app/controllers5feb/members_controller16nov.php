<?php
ob_start();
class MembersController extends AppController {
	var $name = 'members';
	var $layout = "frontend";
	var $helpers = array('Form','Html','Error','Javascript', 'Ajax','Paginator',);
	var $components = array('RequestHandler','Email','MailchimpApi','Ggapi');
	var $uses = array('Member','State','userMeta','Group', 'School', 'Course', 'TutCourse','TutEvent','Page','CauseSchool','UserImage','CauseTutor','TutMessage','Privilege','TutRating','PaymentHistory','TutorWithdrawal','TutorToCause','AddFund','CauseWithdrawal','EmailTemplate','TutorRequestCause','UpcomingMember','UpcomingSchool','Charge','StdCourse','Notice');
	
	// function executes before each action to execute 
	function beforeFilter() {
		
		parent::beforeFilter();
		
		$bypassPage = array(
			'index',
			'paypal',
			'select_type',
			'add_fund',
			'fund_add',
            'error',
			'paypal_tutor',
			'paypal_cause',
			'simple_pay',
			'profiletutoravail',
			'tutor',
			'cause',
			'testEmail',
			'first_data_sucess',
			'yourpay',
			'cronjob',
			'reviewcronjob',
			'stripe_pay',
			'stripe_sucess'
		);
		
		
		// check session of users

		if($this->Session->read('Member.memberid')=='' && $this->params['action'] != 'index'){
			
			/*echo 'facebook';
			die;*/
			
		App::import('Vendor', 'facebook', array(
			'file' => 'facebook/facebook.php'
		));
		
		$facebook = new Facebook(array(
     		'appId'  => APPID ,
			'secret' => SECRET ,
		));
		
		$loginUrl = $facebook->getLoginUrl();
		
		$this->set('facebookURL', $loginUrl);
		
		
		
		//if($_REQUEST['code']!='' && $_REQUEST['state']!='')
		//{
		$user = $facebook->getUser();
		
		//die;
		if ($user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $facebook->api('/me');
				
				//$this->data['User']['id']=$userId;
				$Checkfbid = $this->Member->find('first', array(
					'conditions' => array(
						'Member.facebookId' => $user_profile['id']
					)
				));
				//$this->data['Member']['id'] = $Checkfbid['id'];
				$this->data['Member']['facebookId'] = $user_profile['id'];
				$this->data['Member']['active'] = '1';
				$userMeta['userMeta']['fname']  = $user_profile['first_name'];
				$userMeta['userMeta']['lname']  = $user_profile['last_name'];
								
				
				$this->Session->write('Member.memberid', $Checkfbid['Member']['id']);
				$this->Session->write('Member.active', $Checkfbid['Member']['active']);
				$this->Session->write('Member.group_id', $Checkfbid['Member']['group_id']);
				
				$this->Session->write('Member.id', $this->data['Member']['facebookId']);
				$logoutUrl = $facebook->getLogoutUrl();
				$this->Session->write('Member.logoutUrl', $logoutUrl);
				//pr($this->data);
				//die; 
				if (!$Checkfbid) {
					$this->Member->create();
					$this->Member->save($this->data);
					
					$lastId = $this->Member->getLastInsertId();
					
					$lastmember = $this->Member->find('first', array(
						'conditions' => array(
							'Member.id' => $lastId
						)
					));
					
					
					$this->Session->write('Member.memberid', $lastmember['Member']['id']);
					$this->Session->write('Member.active', $lastmember['Member']['active']);
					$this->Session->write('Member.group_id', $lastmember['Member']['group_id']);
					
					
					$userMeta['userMeta']['member_id'] = $lastId;
					$this->userMeta->create();
					$this->userMeta->save($userMeta);
					
					$this->redirect(array(
						'controller' => 'members',
						'action' => 'select_type'
					));
					
					
				} else {
					
					if ($this->Session->read('Member.active')=='0') {
						
						session_destroy();
						
						$this->redirect(array(
						'controller' => 'homes',
						'action' => 'block_user'
						));
						
					}
					
					if ($this->Session->read('Member.id')) {
					//	$this->checkuserstep($this->Session->read('Member.id'));
					}
				}
				
				//$this->Session->write('Member.id', $this->data['Member']['facebookId']);
				
				echo "<script>
					window.opener.location.reload()
					self.close();
					</script>";
				
				
			}
			catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
			}
			
			
			
		}
			
			
			//facebook
			
		}
		
		
		
		/* if(!$this->CheckAdminSession() && isset($this->params['admin']) && $this->params['action'] != 'admin_login'){
		$this->redirect(array('controller'=>'members','action' => 'login','admin' => true));
		exit();
		}else if($this->CheckAdminSession() && isset($this->params['admin']) && $this->params['action'] == 'admin_login'){
		$this->redirect(array('controller'=>'members','action' => 'dashboard','admin' => true));
		} */
		
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
				
				$this->redirect($loginUrl);
			}
		}
		
	}
	
	//Function for checking the existance of user's email in the database & used for validation
	function checkemail() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$email = $_REQUEST['data']['Member']['email'];
		
		$count = $this->Member->find('count', array(
			'conditions' => array(
				'email' => $email
			)
		));
		
		/*echo $count;
		die;*/
		if ($count > 0) {
			echo "false";
		} else {
			echo "true";
		}
	}
	
	
	/* function for validation for schhol name on school admin in add user */
	
	
	function checkeschool() {
		$schoolid = $_REQUEST['data']['Member']['school_id'];
		
		
		
		$count = $this->Member->find('count', array(
			'conditions' => array(
				'Member.school_id' => $schoolid,
				'Member.group_id' => '4'
			)
		));
		
		if ($count > 0) {
			echo 'false';
		} else {
			echo 'true';
		}
		
		die;
		
		
	}
	
	
	//function for showing the top 5 
	
	function admin_dashboard() {
		$this->layout = "admin";
		
		Configure::write('debug', 0);
		
		$schools = $this->School->find('all', array(
			'limit' => '5',
			'order' => 'School.created DESC'
		));
		
		$this->set('schools', $schools);
		
		
		$tutors = $this->Member->find('all', array(
			'conditions' => array(
				'Member.group_id' => '7'
			),
			'order' => 'Member.created DESC'
		));
		$this->set('tutors', $tutors);
		$students = $this->Member->find('all', array(
			'conditions' => array(
				'Member.group_id' => '8'
			),
			'order' => 'Member.created DESC'
		));
		$this->set('students', $students);
		$causes = $this->Member->find('all', array(
			'conditions' => array(
				'Member.group_id' => '6'
			),
			'order' => 'Member.created DESC'
		));
		$this->set('causes', $causes);
		
		$courses = $this->Course->find('all', array(
			'limit' => '5',
			'order' => 'Course.created DESC'
		));
		$this->set('courses', $courses);
		
		
	}
	
	//function for the login of the user.
	function checkadminlogin() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		if ($this->RequestHandler->isAjax()) {
			$username = $this->data['Member']['username'];
			$password = $this->data['Member']['pwd'];
			
			
			$user = $this->Member->find('count', array(
				'conditions' => array(
					'Member.email' => $username,
					'Member.pwd' => md5($password),
					'Member.active' => '1'
				)
			));
			
			
			if ($user) {
				$getAdminData = $this->Member->find('first', array(
					'conditions' => array(
						'Member.email' => $username,
						'Member.pwd' => md5($password),
						'Member.active' => '1'
					)
				));
				
				if (!empty($getAdminData)) {
					$this->Session->write('Admin.email', $getAdminData['Member']['email']);
					$this->Session->write('Admin.id', $getAdminData['Member']['id']);
					$this->Session->write('Admin.loginStatus', $getAdminData['Member']['login_status']);
					$this->Session->write('Admin.group_id', $getAdminData['Member']['group_id']);
					$this->Session->write('Admin.school_id', $getAdminData['Member']['school_id']);
					
					echo "authorized";
					
				}
			} else {
				//echo $html->link('Forgot Password ?',array('controller'=>'Users','action'=>'requestPassword'));
				echo "Username and/or Password not matched !";
			}
			
		}
		
	}
	
	
	
	
	
	
	// function to check if user exists or not then redirect the page accordingly.
	
	
	function admin_login() {
		$this->layout = "admin";
		
	}
	
	
	
	//logout admin from admin section
	function admin_logout() {
		$this->Member->create();
		$db                             = $this->Member->getDataSource();
		$data['Member']['login_status'] = $db->expression("NOW()");
		$data['Member']['id']           = $this->Session->read('Admin.id');
		$this->Member->save($data);
		
		$this->Session->delete('Admin.id');
		$this->Session->delete('Admin.email');
		$this->Session->delete('Admin.loginStatus');
		$this->Session->delete('Admin.group_id');
		$this->redirect(array(
			'action' => 'login',
			'admin' => true
		));
	}
	
	function admin_index() {
		$this->layout = "admin";
	}
	
	
	
	//function for the admin to change his/her password	
	function admin_change_password() {
		/*	echo '<pre>';
		print_r($this->data);
		die;*/
		
		Configure::write('debug', 0);
		$this->layout = "admin";
		$this->set("changepassword", "selected"); //set main navigation class
		$this->set('manageClass', 'selected');
		$uid      = $this->Session->read('Admin.id');
		$email    = $this->Session->read('Admin.email');
		$userdata = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $this->Session->read('Admin.id'),
				'Member.email' => $email
			)
		));
		
		if ($userdata) {
			if (!empty($this->data)) {
				$this->Member->updateAll(array(
					'Member.pwd' => "'" . md5($this->data['Member']['pwd']) . "'",
					'Member.email' => "'" . $this->data['Member']['email'] . "'"
				), array(
					'Member.email' => $email,
					'Member.id' => $this->Session->read('Admin.id')
				) //(conditions) where userid=schoolid
					);
				
				$this->Session->setFlash('Password changed successfully');
				$this->redirect(array(
					'action' => 'change_password',
					'admin' => true
				));
			}
			
		}
		
		else {
		}
		
	}
	
	
	//function for adding the new user. controller=>users,action=>admin_add
	function admin_add($id = NULL) {
		
		$id           = convert_uudecode(base64_decode($id));
		$this->layout = "admin";
		Configure::write('debug', 0);
		$this->set("parentClass", "selected"); //set main navigation class
		
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		$this->set("states", $states);
		
		$alldata    = $this->School->find('all');
		$schoolname = Set::combine($alldata, '{n}.School.id', '{n}.School.school_name');
		//print_r($schoolname);
		//die;
		$this->set("schoolname", $schoolname);
		
		if (!empty($this->data)) {
			$data['Member']['pwd']       = md5($this->data['Member']['pwd']);
			$data['Member']['email']     = $this->data['Member']['email'];
			$data['Member']['group_id']  = $this->data['Member']['group_id'];
			$data['Member']['active']    = $this->data['Member']['status'];
			$data['Member']['school_id'] = $this->data['Member']['school_id'];
			
			$this->Member->create();
			$db = $this->Member->getDataSource();
			$data['Member']['created'] = $db->expression("NOW()");
			$this->Member->save($data);
			$lastId = $this->Member->getLastInsertId();
			
			if ($lastId) {
				$userMeta['userMeta']['fname']     = $this->data['userMeta']['fname'];
				$userMeta['userMeta']['lname']     = $this->data['userMeta']['lname'];
				$userMeta['userMeta']['address']   = $this->data['userMeta']['address'];
				$userMeta['userMeta']['state']     = $this->data['userMeta']['state'];
				$userMeta['userMeta']['city']      = $this->data['userMeta']['city'];
				$userMeta['userMeta']['zip']       = $this->data['userMeta']['zip'];
				$userMeta['userMeta']['contact']   = $this->data['userMeta']['contact'];
				$userMeta['userMeta']['member_id'] = $lastId;
				
				$this->userMeta->create();
				
				if ($this->userMeta->save($userMeta)) {
					$this->Session->setFlash('User has been added');
			
					$this->redirect(array(
						'controller'=>'members',				  
						'action' => 'admin_member_view',
					));
					
					
				}
			}
		}
	}
	
	
	//function for adding the new user. controller=>users,action=>admin_add
	function admin_edit($id = NULL) {
		$this->layout = "admin";
		Configure::write('debug', 0);
		$this->set("parentClass", "selected"); //set main navigation class
		
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		$this->set("states", $states);
		
		$id = convert_uudecode(base64_decode($id));
		
		
		$alldata    = $this->School->find('all');
		$schoolname = Set::combine($alldata, '{n}.School.id', '{n}.School.school_name');
		
		$this->set("schoolname", $schoolname);
		
		$admindata = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $id
			)
		));
		
		$this->set('admindata', $admindata);
		
		
		
		
		if (!empty($this->data)) {
			/*echo '<pre>';
			print_r($this->data);
			die;
			
			*/
			$data['Member']['stripeid']  = $this->data['Member']['stripeid'];
			$data['Member']['email']  = $this->data['Member']['email'];
			$data['Member']['group_id']  = $this->data['Member']['group_id'];
			$data['Member']['active']    = $this->data['Member']['status'];
			$data['Member']['id']        = $this->data['Member']['id'];
			$data['Member']['school_id'] = $this->data['Member']['school_id'];
			$data['Member']['creditable_balance'] = $this->data['Member']['creditable_balance'];
					
			$this->Member->create();
			$db = $this->Member->getDataSource();
			
			if ($this->Member->save($data)) {
				$userMeta['userMeta']['fname']   = $this->data['userMeta']['fname'];
				$userMeta['userMeta']['lname']   = $this->data['userMeta']['lname'];
				$userMeta['userMeta']['address'] = $this->data['userMeta']['address'];
				
				$userMeta['userMeta']['state']     = $this->data['userMeta']['state'];
				$userMeta['userMeta']['city']      = $this->data['userMeta']['city'];
				$userMeta['userMeta']['zip']       = $this->data['userMeta']['zip'];
				$userMeta['userMeta']['contact']   = $this->data['userMeta']['contact'];
			//	$userMeta['userMeta']['member_id'] = $this->data['Member']['id'];
				$userMeta['userMeta']['note'] = $this->data['userMeta']['note'];
				
				$user = $this->userMeta->find('first', array(
					'conditions' => array(
						'member_id' => $this->data['Member']['id']
					)
				));
				
				$userMeta['userMeta']['id'] = $user['userMeta']['id'];
				
				$this->userMeta->create();
				
				if ($this->userMeta->save($userMeta)) {
				
				$this->Session->setFlash('User has been edited');
					
				//	$this->redirect($this->referer());
					
				}
				
				$this->Session->setFlash('User has been edited');
				
				$this->redirect(array(
					'action' => 'member_view',
					'admin' => true
				));
				
			}
		}
		
		
		$admindata = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $id
			)
		));
		
		$this->set('admindata', $admindata);
		
	}
	
	
	//function to edit user,param User Id
	
	
	
	function admin_member_view() {
		$this->layout = 'admin';
		
		$this->set("parentClass", "selected"); //set main navigation class
		
		
		if (isset($this->data)) {
			$this->Session->write('prntview.email', $this->data['Member']['email']);
			$this->Session->write('prntview.active', $this->data['Member']['active']);
			$this->Session->write('prntview.group_id', $this->data['Member']['group_id']);
			$this->Session->write('prntview.perpage', $this->data['Member']['perpage']);
			
			$this->data['Member']['email']    = $this->Session->read('prntview.email');
			$this->data['Member']['active']   = $this->Session->read('prntview.active');
			$this->data['Member']['group_id'] = $this->Session->read('prntview.group_id');
			$this->data['Member']['perpage']  = $this->Session->read('prntview.perpage');
			
		} else {
			$this->Session->delete('prntview');
		}
		
		if (strlen($this->Session->read('prntview.perpage')) > 0) {
			$this->data['Member']['perpage'] = $this->Session->read('prntview.perpage');
		} else {
			$this->data['Member']['perpage'] = 10;
		}		
		
		/*echo '<pre>';
		print_r($this->data);
		die;*/
		
		
		
		$this->paginate['Member'] = array(
			'conditions' => array(
				'AND' => array(
					'Member.email  LIKE' => "%" . $this->data['Member']['email'] . "%",
					'Member.active LIKE' => "%" . $this->data['Member']['active'] . "%",
					'Member.group_id LIKE' => "%" . $this->data['Member']['group_id'] . "%"
				)
			),
			'limit' => $this->data['Member']['perpage']
		);
		
		
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		//$cities = Set::combine($alldata,'{n}.State.id','{n}.State.city');
		$this->set("states", $states);
		//$this->set("cities",$cities);
		
		
		/*$this->paginate = array(
		'limit' => 2
		);
		*/
		
		$members = $this->paginate('Member');
		
		$this->set('members', $members);
		//pr($members); die;
		
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'members';
			$this->render('members');
		}
		
		
	}
	
	
	
	//Function for deleting users,questions, articles etc
	function admin_delete($id = NULL) {
		if (is_numeric($id)) {
		} else {
			$id = convert_uudecode(base64_decode($id));
		}
		
	//	echo $id;
	//	die;
		
		$this->autoRender = false;
		Configure::write('debug', 0);
		if (!$this->RequestHandler->isAjax()) {
			$this->layout = "admin";
		}
		if ($this->RequestHandler->isAjax() && !$id) {
			$this->autoRender = false;
			$this->layout     = "";
			
			/*foreach ($this->data['Member']['id'] as $del_id):
				$delete[]  = $this->Member->delete($del_id);
				$delMeta[] = $this->userMeta->deleteAll(array(
					'userMeta.member_id' => $del_id
				));
			endforeach;
			if (!empty($delete) && !empty($delMeta)) {
				echo "deleted";
			} else {
			}*/
			
			
		} else if ($this->RequestHandler->isAjax() && $id) {
			$this->autoRender = false;
			$this->layout     = "";
			$activeid = 3;
			$this->Member->updateAll(array(
				'Member.active' => "'" . $activeid . "'"
			), array(
				'Member.id' => $id
			));
		
			
			echo "deleted";
			
			
			
			
			/*$delete = $this->Member->delete($id);
			if ($delete) {
				$meta = $this->userMeta->deleteAll(array(
					'userMeta.member_id' => $id
				));
				$course = $this->TutCourse->deleteAll(array(
					'TutCourse.member_id' => $id
				));
				$event = $this->TutEvent->deleteAll(array(
					'TutEvent.tutor_id' => $id
				));
				$image = $this->UserImage->deleteAll(array(
					'UserImage.user_id' => $id
				));
				
			}
			if ($meta) {
				echo "deleted";
			}*/
			
			
		}
	} //THIS FUNCTION IS USED FOR CHECKING AND DELETING THE SESSION
	
	function checkfacebooklogin() {
		Configure::write('debug', 0);
		App::import('Vendor', 'facebook', array(
			'file' => 'facebook/facebook.php'
		));
		
		$facebook = new Facebook(array(
			'appId' =>  APPID ,
			'secret' => SECRET
		));
		$user     = $facebook->getUser();
		if (!$user) {
			$this->Session->delete('Member.id');
			$this->Session->delete('logoutUrl');
			$this->Session->delete('memberid');
			$this->Session->delete('active');
			$this->Session->delete('group_id');
			
			
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'index'
			));
		}
	}
	
	function logout() {
		$logouturl = $this->Session->read('Member.logoutUrl');
		session_destroy();
		$this->redirect("$logouturl");
		
		//		$this->redirect(array('controller'=>'members', 'action'=>'index'));
		
		/*		$this->Session->delete('Member.id');
		$this->Session->delete('Member.memberid');
		$this->Session->delete('Member.active');
		$this->Session->delete('Member.group_id');
		$logouturl =  $this->Session->read('Member.logoutUrl');
		$this->redirect("$logouturl");*/
	}
	
	
	function checkpercentage() {
		Configure::write('debug', 0);
		$this->data = $this->Member->find('first', array(
			'fields' => array(
				'userMeta.member_id',
				'userMeta.fname',
				'userMeta.lname',
				'userMeta.address',
				'userMeta.contact',
				'userMeta.city',
				'userMeta.state',
				'userMeta.country',
				'userMeta.zip'
			),
			'conditions' => array(
				'Member.facebookId' => $this->Session->read('Member.id')
			)
		));
		$x          = 0;
		
		foreach ($this->data['userMeta'] as $k => $v) {
			//echo $v;
			
			if (strlen($v) < 1 || $v == 'NULL') {
				$x++;
			}
			
		}
		return $x;
	}
	
	
	
	function regmember($id = NULL) {
		//$this->checkfacebooklogin();
		Configure::write('debug', 0);
		$this->layout = 'frontend';
//		$this->set('emailStatus','');
		$this->set('picture', $this->getProfilePic());
		
		$this->data = $this->Member->find('first', array(
			'conditions' => array(
				'Member.facebookId' => $this->Session->read('Member.id')
			)
		));
		$rightText  = $this->Page->find('first', array(
			'conditions' => array(
				'Page.id' => 24
			)
		));
		$this->set('rightText', $rightText);
		
		
		/*$countdata = $this->userMeta->find('count',
		array('conditions'=>
		array('OR'=>
		array('userMeta.member_id'=>$this->data['Member']['id'],
		'userMeta.fname <>' => 'NULL',
		'userMeta.lname <>' => 'NULL',
		'userMeta.address <>' => 'NULL',
		'userMeta.contact <>' => 'NULL',
		'userMeta.city <>' => 'NULL',
		'userMeta.state <>' => 'NULL',
		'userMeta.country <>' => 'NULL',
		'userMeta.zip <>' => 'NULL'
		),
		
		array('userMeta.member_id'=>$this->data['Member']['id'],
		'userMeta.fname <>' => '',
		'userMeta.lname <>' => '',
		'userMeta.address <>' => '',
		'userMeta.contact <>' => '',
		'userMeta.city <>' => '',
		'userMeta.state <>' => '',
		'userMeta.country <>' => '',
		'userMeta.zip <>' => ''
		)
		)));*/
		
		
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		
		/*echo '<pre>';
		print_r($states);
		die;*/
		
		$this->set("states", $states);
		
		if (isset($id) && $id != '') {
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
		//	$this->set('emailStatus','readonly');
			
		}
		
		
		
		
		
		
	}
	
	function getcourse($id = NULL) {
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		$data             = $this->Course->find('all', array(
			'conditions' => array(
				'school_id' => $id
			)
		));
		$course           = Set::combine($data, '{n}.Course.id', '{n}.Course.course_title');
		$this->set('course', $course);
		//print_r($course);
		$this->viewPath = 'elements' . DS . 'frontend';
		$this->render('getcourse');
		
	}
	function addcourse($id = NULL) {
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		//pr($this->data);
		//echo $id;
		if ($id != "") {
			$this->TutCourse->deleteAll(array(
				'TutCourse.member_id' => $this->Session->read('Member.memberid')
			));
		}
		//die;
		$i = 0;
		foreach ($this->data['TutCourse']['course_id'] as $data) {
			$mySaving['TutCourse']['school_id'] = $this->data['TutCourse']['school_id'];
			$mySaving['TutCourse']['course_id'] = $this->data['TutCourse']['course_id'][$i];
			$mySaving['TutCourse']['rate']      = $this->data['TutCourse']['rate'][$i];
			$mySaving['TutCourse']['member_id'] = $this->Session->read('Member.memberid');
			$db                                 = $this->TutCourse->getDataSource();
			$mySaving['TutCourse']['created']   = $db->expression("NOW()");
			if ($mySaving['TutCourse']['course_id']) {
				$this->TutCourse->create();
				$saved = $this->TutCourse->save($mySaving['TutCourse']);
			}
			$i++;
			
		}
		if ($saved) {
			$this->Session->setFlash('Your courses has been saved successfully');
			
			$this->Member->updateAll(array(
				'Member.school_id' => "'" . $this->data['TutCourse']['school_id'] . "'"
			), array(
				'Member.id' => $this->Session->read('Member.memberid')
			));
			
			
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'tutor_dashboard'
			));
		} else {
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'schoolinfo'
			));
		}
		
	}
	
	
	function getautocourse($id = NULL) {
		$this->layout     = '';
		$this->autoRender = false;
		Configure::write('debug', 0);
		//echo $id;
		//exit;
		
		$data = $_REQUEST['data'];
		
		$returnList = $this->Course->find('all', array(
			'limit' => '10',
			'conditions' => array(
				'course_id LIKE ' => $data . "%",
				'school_id' => $id
			),
			'order' => array(
					'Course.course_id ASC'
				)
		));
		
		$course = Set::combine($returnList, '{n}.Course.id', '{n}.Course.course_id');
		
		$dataList = array();
		
		foreach ($course as $id => $value) {
			$toReturn   = $value;
			$dataList[] = '<li id="' . $id . '">' . htmlentities($toReturn) .'</li>';
			// $i++;
		}
		
		if (count($dataList) >= 1) {
			$dataOutput = join("\r\n", $dataList);
			echo $dataOutput;
		} else {
			if (strlen($id) < 1) {
				echo 'Please select school first';
			} else {
				//echo 'No Results found!!';
			}
			
			
		}
		
		
		
	}
	
	function addmember() {
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		
		if (isset($this->data)) {
			$memberdata['Member']['id']     = $this->data['Member']['id'];
			$memberdata['Member']['email']  = $this->data['Member']['email'];
			$memberdata['Member']['active'] = 1;
			
			if (isset($this->data['Member']['group_id']) && $this->data['Member']['group_id'] != 'NULL') {
				$memberdata['Member']['group_id'] = $this->data['Member']['group_id'];
			}
			
			if ($this->Member->save($memberdata)) {
				$userMeta['userMeta']['fname']     = $this->data['userMeta']['fname'];
				$userMeta['userMeta']['lname']     = $this->data['userMeta']['lname'];
				$userMeta['userMeta']['address']   = $this->data['userMeta']['address'];
				$userMeta['userMeta']['city']      = $this->data['userMeta']['city'];
				$userMeta['userMeta']['state']     = $this->data['userMeta']['state'];
				$userMeta['userMeta']['zip']       = $this->data['userMeta']['zip'];
				$userMeta['userMeta']['contact']   = $this->data['userMeta']['contact'];
				$userMeta['userMeta']['biography']   = $this->data['userMeta']['biography'];
				$userMeta['userMeta']['member_id'] = $this->data['Member']['id'];
			/*	$userMeta['userMeta']['fb_allow'] = $this->data['userMeta']['fb_allow'];
				$userMeta['userMeta']['email_allow'] = $this->data['userMeta']['email_allow'];*/
				$userMeta['userMeta']['fb_allow'] = 1;
				$userMeta['userMeta']['email_allow'] = $this->data['userMeta']['email_allow'];
				
				$user = $this->userMeta->find('first', array(
					'conditions' => array(
						'member_id' => $this->data['Member']['id']
					)
				));
				
				$userMeta['userMeta']['id'] = $user['userMeta']['id'];
				
				$this->userMeta->create();
				
				if ($this->userMeta->save($userMeta)) {
					if ($this->data['Member']['user'] == 'cause') {
						$this->Session->setFlash('Your profile has been changed sucessfully');
						$this->redirect(array(
							'controller' => 'members',
							'action' => 'cause_dashboard'
						));
					} else if ($this->data['Member']['user'] == 'tutor') {
						$this->Session->setFlash('Your profile has been changed sucessfully');
						$this->redirect(array(
							'controller' => 'members',
							'action' => 'tutor_dashboard'
						));
					} else if ($this->data['Member']['user'] == 'student') {
						$this->Session->setFlash('Your profile has been changed sucessfully');
						$this->redirect(array(
							'controller' => 'members',
							'action' => 'student_dashboard'
						));
					} else {
						$this->checkuserstep($this->Session->read('Member.id'));
					}
					
				}
			}
			
		}
	}
	
	function index($id = NULL) {
		
	/*	$str = '100000868748349';
        $active_code =  base64_encode($str);
		echo $str.'<br>';
		echo $active_code.'<br>';
		$decode_code = base64_decode($active_code);
		echo $decode_code.'<br>';
		die;*/
		
		
		$homepage = array(
			'25',
			'26',
			'27',
			'28',
			'29',
			'30',
			'31',
			
		);
		
		
		$dynamictext = $this->Page->find('all', array(
			'conditions' => array(
				'Page.id' => $homepage
			)
		));
		
		$this->set('dynamictext', $dynamictext);
		
		/*	echo '<pre>';
		print_r($dynamictext);
		die;*/
		
		Configure::write('debug', 0);
		
		// local testing function 
		
		// use id 25 for cause
		
		// use id 8 for student fbid 100002648874956
		
		// use id 58 for tutor
		
		// user id 18 for jugal student
		
	/*	$this->Session->write('Member.memberid', 19);
		
		$Checkfbid = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			)
		));
		
		$this->Session->write('Member.group_id', $Checkfbid['Member']['group_id']);
		
		$this->Session->write('Member.id', $Checkfbid['Member']['facebookId']); 
		
		$this->checkuserstep($this->Session->read('Member.id'));  */
		
		// end local testing function 
		
		
		App::import('Vendor', 'facebook', array(
			'file' => 'facebook/facebook.php'
		));
		
		$facebook = new Facebook(array(
     		'appId'  => APPID ,
			'secret' => SECRET ,
		));
		
		
		//to get email form facebook
	$loginUrl = $facebook->getLoginUrl(
     array('req_perms' => 'email,read_stream')
	);	
		
	//	$loginUrl = $facebook->getLoginUrl();
		
		$this->set('facebookURL', $loginUrl);
		
		
		
		//if($_REQUEST['code']!='' && $_REQUEST['state']!='')
		//{
		$user = $facebook->getUser();
		
		//checking locally
	//	$user =1;
		
		
		//die;
		if ($user) {
			try {
				// Proceed knowing you have a logged in user who's authenticated.
				$user_profile = $facebook->api('/me');
			
				//checking locally
			/*    $user_profile['id'] = '100002648874956';
				$user_profile['email'] = 'promatics.jaswant@gmail.com';
				$user_profile['first_name'] = 'jaswant';
				$user_profile['last_name'] = 'singh';*/
				
				//$this->data['User']['id']=$userId;
				$Checkfbid = $this->Member->find('first', array(
					'conditions' => array(
						'Member.facebookId' => $user_profile['id'],
						'Member.active !=' => 3
					)
				));
				
				
				
				//$this->data['Member']['id'] = $Checkfbid['id'];
				// save email of user
				$this->data['Member']['email'] = $user_profile['email'];
				$this->data['Member']['facebookId'] = $user_profile['id'];
				$this->data['Member']['active'] = '0';
				$userMeta['userMeta']['fname']  = $user_profile['first_name'];
				$userMeta['userMeta']['lname']  = $user_profile['last_name'];
								
				
				$this->Session->write('Member.memberid', $Checkfbid['Member']['id']);
				$this->Session->write('Member.active', $Checkfbid['Member']['active']);
				$this->Session->write('Member.group_id', $Checkfbid['Member']['group_id']);				
				$this->Session->write('Member.id', $this->data['Member']['facebookId']);
				
				
				$logoutUrl = $facebook->getLogoutUrl();
				$this->Session->write('Member.logoutUrl', $logoutUrl);
				//pr($this->data);
				//die; 
				if ($Checkfbid) {
						
					if ($Checkfbid['Member']['active'] == '0') {
						
						session_destroy();
						
						$this->redirect(array(
						'controller' => 'homes',
						'action' => 'unactive_user'
						));
						
					}
					else if($Checkfbid['Member']['active'] == '1')
					{
						$this->checkuserstep($this->Session->read('Member.id'));
					}
					else if($Checkfbid['Member']['active'] == '2')
					{
						session_destroy();
						
						$this->redirect(array(
						'controller' => 'homes',
						'action' => 'block_user'
						));
						
					}
					
				} else {
					
					$str = $user_profile['id'];
				    $this->data['Member']['activation_key'] =  base64_encode($str);
			
					$this->Member->create();
					$this->Member->save($this->data);
					
					$lastId = $this->Member->getLastInsertId();
					
					$this->welcome_email_template($lastId);
					
					$lastmember = $this->Member->find('first', array(
						'conditions' => array(
							'Member.id' => $lastId
						)
					));
					
					
				/*	$this->Session->write('Member.memberid', $lastmember['Member']['id']);
					$this->Session->write('Member.active', $lastmember['Member']['active']);
					$this->Session->write('Member.group_id', $lastmember['Member']['group_id']);
				*/	
					
					$userMeta['userMeta']['member_id'] = $lastId;
					$this->userMeta->create();
					$this->userMeta->save($userMeta);
					
					session_destroy();
					
					$this->redirect(array(
						'controller' => 'homes',
						'action' => 'welcome_user'
					));
					
				}
				
				//$this->Session->write('Member.id', $this->data['Member']['facebookId']);
				
				echo "<script>
					window.opener.location.reload()
					self.close();
					</script>";
				
				
			}
			catch (FacebookApiException $e) {
				error_log($e);
				$user = null;
			}
			
			
			
		}
		
		if($this->data){
			$this->data['UpcomingMember']['active'] = '1';
			$this->UpcomingMember->create();
			$this->UpcomingMember->save($this->data);
			$this->Session->setFlash('Your request is successfully submitted! we will contact you shortly.');
			$this->redirect(array('controller'=>'members','action'=>'index'));
		}
		$schools = $this->UpcomingSchool->find(
			'list',
			array(
				'fields' => array(
					'UpcomingSchool.id',
					'UpcomingSchool.school_name'
				),
				'order' => array(
					'UpcomingSchool.school_name'
				)
			)
		);
		$this->set('schools',$schools);
		
	}
	
	
	function checkMemberExist() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$email    = $_REQUEST['data']['Member']['email'];
		$memberid = $_REQUEST['memberid'];
		
		//	echo $email.$memberid;
		
		
		$count = $this->Member->find('count', array(
			'conditions' => array(
				'Member.email' => $email,
				'Member.id !=' => $memberid
			)
		));
		//	echo $count;
		
		
		
		
		if ($count > 0) {
			echo "false";
		} else {
			echo "true";
		}
	}
	
	function cause_dashboard() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		
		$causeNotice = $this->Notice->find('all', array('conditions'=>
												  array('Notice.group_id LIKE'=> "%"."6"."%")
												  )
									 );

		$this->set('causeNotice',$causeNotice);
		
		
		$this->cause_element();
		
		
		
	}
	
	function tutor_dashboard() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		
		$tutornotice = $this->Notice->find('all', array('conditions'=>
												  array('Notice.group_id LIKE'=> "%"."7"."%")
												  )
									 );

		$this->set('tutornotice',$tutornotice);
		
		
		// tutor dashboard function for left and right element 
		$this->tutor_element();
		// end tutor dashboard function for left and right element 
		
	}
	
	function getCauseRequest() {
		return $this->CauseTutor->find('count', array(
			'conditions' => array(
				'tutor_id' => $this->Session->read('Member.memberid'),
				'status' => 0
			)
		));
	}
	
	function getProfilePic() {
		return $this->UserImage->find('first', array(
			'fields' => array(
				'image_name'
			),
			'conditions' => array(
				'user_id' => $this->Session->read('Member.memberid'),
				'UserImage.active' => '1'
			),
			'order' => array(
				'id' => 'desc'
			),
			'limit' => '1'
		));
	}
	
	function getProfilePic1($id = NULL) {
		return $this->UserImage->find('first', array(
			'fields' => array(
				'image_name'
			),
			'conditions' => array(
				'user_id' => $id,
				'UserImage.active' => '1'
			),
			'order' => array(
				'id' => 'desc'
			),
			'limit' => '1'
		));
	}
	
	function student_dashboard() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		// student dashboard leftside bar 
		
		
		$studentcourse =  $this->StdCourse->find('all',array('conditions'=>array(
												 'StdCourse.member_id'=> $this->Session->read('Member.memberid'),
												 )
							 )
				 );
		
		$studentnotice = $this->Notice->find('all', array('conditions'=>
														  array('Notice.group_id LIKE'=> "%"."8"."%")
														  )
											 );
		
	/*	echo '<pre>';
		print_r($studentnotice);
		die;
		*/
		$this->set('studentcourse',$studentcourse);
		$this->set('studentnotice',$studentnotice);

		
		
		
		
		$this->student_element();
		
		// end student dashboard leftside bar 
		
	}
	
	function cause_request() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		$this->tutor_element();
		
		$this->set('CountRequest', $this->getCauseRequest());
		
		
		$causeResult = $this->CauseTutor->find('all', array(
			'conditions' => array(
				'CauseTutor.status' => '0',
				'tutor_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		$this->set('causeResult', $causeResult);
		if (count($this->data)) {
			if (isset($this->data['Member']['accept'])) {
				echo "on";
				$this->CauseTutor->updateAll(array(
					'CauseTutor.status' => "'1'"
				), array(
					'CauseTutor.id' => $this->data['Member']['id']
				));
				$this->Session->setFlash('Accepted successfully!');
				$this->redirect(array(
					'action' => 'cause_request'
				));
			} else {
				$this->CauseTutor->delete($this->data['Member']['id']);
				$this->Session->setFlash('Deleted successfully!');
				$this->redirect(array(
					'action' => 'cause_request'
				));
			}
		}
	}
	
	function payment() {
		$this->layout = 'frontend';
	}
	
	
	
	function step2() {
		$this->data = $this->Member->find('first', array(
			'fields' => array(
				'Member.group_id'
			),
			'conditions' => array(
				'Member.facebookId' => $this->Session->read('Member.id')
			)
		));
		//print_r($this->data);
		//$usertype=7;
		$usertype   = $this->data['Member']['group_id'];
		
		if ($usertype == '6') {
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'cause_dashboard'
			));
		}
		
		if ($usertype == '8') {
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'student_dashboard'
			));
		}
		
		
		/*	if($this->data['Member']['group_id']==6 || $this->data['Member']['group_id']==8){
		$this->redirect(array('controller'=>'members','action'=>'dashboard'));
		}*/
		
		
		$x = $this->checkpercentage();
		$x = 70 - 10 * $x;
		$this->set('x', $x);
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
	}
	
	
	function step3() {
		$this->data = $this->Member->find('first', array(
			'fields' => array(
				'Member.group_id'
			),
			'conditions' => array(
				'Member.facebookId' => $this->Session->read('Member.id')
			)
		));
		//print_r($this->data);
		//$usertype=7;
		$usertype   = $this->data['Member']['group_id'];
		
		if ($usertype == '6') {
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'cause_dashboard'
			));
		}
		
		if ($usertype == '8') {
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'student_dashboard'
			));
		}
		
		
		/*	if($this->data['Member']['group_id']==6 || $this->data['Member']['group_id']==8){
		$this->redirect(array('controller'=>'members','action'=>'dashboard'));
		}*/
		
		
		$x = $this->checkpercentage();
		$x = 70 - 10 * $x;
		$this->set('x', $x);
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
	}
	
	function schoolinfo() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$schools      = $this->School->find('all');
		$this->set('schools', $schools);
		
		$tutcources = $this->TutCourse->find('all', array(
			'conditions' => array(
				'TutCourse.member_id' => $this->Session->read('Member.memberid')
			)
		));
		$this->set('tutcources', $tutcources);
		
	}
	
	function editschoolinfo() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$schools      = $this->School->find('all');
		$this->set('schools', $schools);
		
		$tutcources = $this->TutCourse->find('all', array(
			'conditions' => array(
				'TutCourse.member_id' => $this->Session->read('Member.memberid')
			)
		));
		$this->set('tutcources', $tutcources);
		
	}
	
	
	function deletecourse() {
		$deleteCourse = $this->TutCourse->deleteAll(array(
			'TutCourse.member_id' => $this->Session->read('Member.memberid'),
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
	function tutor_payment($id = NULL) {
		$this->layout = 'frontend';
		
		$memberData = $this->Member->find('first', array(
			'conditions' => array(
				'Member.facebookId' => $this->Session->read('Member.id')
			)
		));
		
		$this->set('memberData', $memberData);
		
		if (isset($id) && $id != '') {
			$profile = 'edit';
			$this->set('profile', $profile);
		}
	}
	
	function tutor_paypal_detial() {
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		
		if (isset($this->data)) {
			if ($this->data['Member']['payment'] == 'Paypal') {
				$this->tutorpaypal['Member']['paypalEmail'] = $this->data['Member']['paypalEmail'];
			}
			
			if ($this->data['Member']['payment'] == 'Mailed Check') {
				$this->tutorpaypal['Member']['mailedCheck'] = $this->data['Member']['mailedCheck'];
			}
			
			$this->tutorpaypal['Member']['paymentFrequency'] = $this->data['Member']['paymentFrequency'];
			
			
		/*	$memberdata = $this->Member->find('first', array(
				'conditions' => array(
					'Member.facebookId' => $this->Session->read('Member.id')
				)
			));
			*/
			
			$this->tutorpaypal['Member']['id'] = $this->Session->read('Member.memberid');
		
			$savedmember =  $this->Member->save($this->tutorpaypal);
			
			
			if ($savedmember) {
				if ($this->data['edit']['profile'] == 'edit') {
					$this->redirect(array(
						'controller' => 'members',
						'action' => 'tutor_dashboard'
					));
				} else {
					$this->redirect(array(
						'controller' => 'members',
						'action' => 'calendar'
					));
				}
				
			}
			
		}
		
		
	}
	
	
	function calendar($id = NULL) {
		$this->layout = 'frontend';
		
		$tutevent = $this->TutEvent->find('all', array(
			'conditions' => array(
				'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
			)
		));
		
		$this->set('tutevent', $tutevent);
		
		if (isset($id) && $id != '') {
			$profile = 'edit';
			$this->set('profile', $profile);
		}
		
	}
	
	function addevent($id = null) {
		Configure::write('debug', 0);
		
		
		/*	if(isset($this->data))
		{
		
		
		if(isset($this->data['TutEvent']['id']))
		{
		$this->addevent['TutEvent']['id'] = $this->data['TutEvent']['id'];	
		}
		
		
		
		$start_formatted_date = date('Y-m-d H:i:s',strtotime($this->data['TutEvent']['start_date']));
		$end_formatted_date = date('Y-m-d H:i:s',strtotime($this->data['TutEvent']['end_date']));
		
		$this->addevent['TutEvent']['start_date'] = $start_formatted_date;
		
		$this->addevent['TutEvent']['end_date'] = $end_formatted_date;
		
		$this->addevent['TutEvent']['tutor_id'] = $this->Session->read('Member.memberid');
		
		$this->TutEvent->Save($this->addevent);
		$this->redirect(array('controller'=>'Members','action' => 'addevent'));
		
		
		}
		if($id) {
		$edittut = 	$this->TutEvent->find('first',array('conditions' =>  array('TutEvent.id' => $id)));
		$this->set('edittut',$edittut);	
		}*/
		
		$this->paginate['TutEvent'] = array(
			'conditions' => array(
				'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
			),
			'limit' => 20
		);
		
		
		$tutevent = $this->paginate('TutEvent');
		
		
		$this->set('tutevent', $tutevent);
		
		
	}
	
	function delete_event($id = null) {
		$id = $_GET['deleteid'];
		
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		if ($id) {
			$this->TutEvent->delete($id);
		}
		
		echo 'sucess';
		
		
	}
	
	function view_event($id = null) {
		Configure::write('debug', 0);
		$viewtut = $this->TutEvent->find('first', array(
			'conditions' => array(
				'TutEvent.id' => $id
			)
		));
		
		$this->set('viewtut', $viewtut);
	}
	
	function testdashboard() {
	}
	
	function testprofile() {
	}
	
	
	function pickdate() {
		Configure::write('debug', 0);
		
	}
	
	
	function checkuserstep($fbid = null) {
		Configure::write('debug', 0);
		
	
		
		$userdata = $this->Member->find('first', array(
			'conditions' => array(
				'Member.facebookId' => $this->Session->read('Member.id'),
				'Member.active !=' => 3
			)
		));
		
		/*	echo '<pre>';
		print_r($userdata);
		die;*/
		
		//print_r($this->data);
		//$usertype=7;
		$usertype = $userdata['Member']['group_id'];
		
		if ($usertype == '6') {
			if ($userdata['userMeta']['fname'] != "" && $userdata['userMeta']['lname'] != "" && $userdata['Member']['email'] != "" ) {
				$causestep2 = $this->CauseSchool->find('count', array(
					'conditions' => array(
						'CauseSchool.cause_id' => $this->Session->read('Member.memberid')
					)
				));
				
				if ($causestep2) {
					$this->redirect(array(
						'controller' => 'members',
						'action' => 'cause_dashboard'
					));
				}
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'cause_schoolinfo'
				));
				
			} else {
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'regmember'
				));
			}
			
			
		}
		
		if ($usertype == '7') {
			if ($userdata['userMeta']['fname'] != "" && $userdata['userMeta']['lname'] != "" && $userdata['Member']['email'] != "" ) {
				
				
			/*	
				if ($userdata['Member']['paymentFrequency'] != "" && ($userdata['Member']['paypalEmail'] != "" || $userdata['Member']['mailedCheck'] != "")) {
					$step3 = $this->TutEvent->find('count', array(
						'conditions' => array(
							'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
						)
					));
					
					if ($step3) {
						$step4 = $this->TutCourse->find('count', array(
							'conditions' => array(
								'TutCourse.member_id' => $this->Session->read('Member.memberid')
							)
						));
						if ($step4) {*/
							
							
							$this->redirect(array(
								'controller' => 'members',
								'action' => 'tutor_dashboard'
							));
							
							
			/*			}
						$this->redirect(array(
							'controller' => 'members',
							'action' => 'schoolinfo'
						));
					}
					$this->redirect(array(
						'controller' => 'members',
						'action' => 'calendar'
					));
					
				}
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'tutor_payment'
				));*/
				
				
				
				
			}
			
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'regmember'
			));
			
		}
		
		if ($usertype == '8') {
			if ($userdata['userMeta']['fname'] != "" && $userdata['userMeta']['lname'] != "" && $userdata['Member']['email'] != "" ) {
				if ($userdata['Member']['school_id'] != "") {
					$this->redirect(array(
						'controller' => 'members',
						'action' => 'student_dashboard'
					));
				}
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'student_schoolinfo'
				));
				
			} else {
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'regmember'
				));
			}
		}
		
		if ($usertype == 'NULL' || $usertype == '') {
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'select_type'
			));
		}
		
		/*	echo 'jaswnat';
		echo '<pre>';
		print_r($userdata);
		
		die;*/
		
	}
	
	function copyschedule() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		if (isset($this->data)) {
			/*	echo '<pre>';
			print_r($_POST);
			die;			
			*/
			if ($this->data['TutEvent']['spe_date']) {
				$sourcedate = date("Y-m-d", strtotime($this->data['TutEvent']['source_date']));
				
				
				$desdate = date('Y-m-d', strtotime($this->data['TutEvent']['spe_date']));
				
				$sourcetime = $this->TutEvent->find('all', array(
					'conditions' => array(
						'TutEvent.start_date  LIKE' => "%" . $sourcedate . "%",
						'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
					)
				));
				
				for ($j = 0; $j < count($sourcetime); $j++) {
					$timestart = date('H:i', strtotime($sourcetime[$j]['TutEvent']['start_date']));
					$timeend   = date('H:i', strtotime($sourcetime[$j]['TutEvent']['end_date']));
					
					$finalstartdate = $desdate . ' ' . $timestart;
					
					$finalenddate = $desdate . ' ' . $timeend;
					
					$this->TutEvent->create();
					
					$this->copyevent['TutEvent']['start_date'] = $finalstartdate;
					
					$this->copyevent['TutEvent']['end_date'] = $finalenddate;
					
					$this->copyevent['TutEvent']['tutor_id'] = $this->Session->read('Member.memberid');
					
					$this->TutEvent->Save($this->copyevent);
				}
				
			} else {
				$sourcedate = date("Y-m-d", strtotime($this->data['TutEvent']['source_date']));
				
				$startdate = date("Y-m-d", strtotime($this->data['TutEvent']['start_date']));
				
				$replacedate = $this->data['TutEvent']['end_date'];
				
				$desdate = date('Y-m-d', strtotime($replacedate));
				
				
				
				
				$sourcetime = $this->TutEvent->find('all', array(
					'conditions' => array(
						'TutEvent.start_date  LIKE' => "%" . $sourcedate . "%",
						'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
					)
				));
				
				$days = $this->dateDiff($startdate, $desdate);
				
				
				for ($counter = 0; $counter <= $days; $counter++) {
					$srcplusone = date('Y-m-d', strtotime("+$counter day", strtotime($startdate)));
					
					for ($j = 0; $j < count($sourcetime); $j++) {
						$timestart = explode(' ', $sourcetime[$j]['TutEvent']['start_date']);
						$timeend   = explode(' ', $sourcetime[$j]['TutEvent']['end_date']);
						
						$finalstartdate = $srcplusone . ' ' . $timestart[1];
						
						$finalenddate = $srcplusone . ' ' . $timeend[1];
						
						$this->TutEvent->create();
						
						$this->copyevent['TutEvent']['start_date'] = $finalstartdate;
						
						$this->copyevent['TutEvent']['end_date'] = $finalenddate;
						
						$this->copyevent['TutEvent']['tutor_id'] = $this->Session->read('Member.memberid');
						
						$this->TutEvent->Save($this->copyevent);
					}
				}
				
				
			}
			
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'calendar'
			));
		}
		
	}
	
	function copyweek() {
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
				'controller' => 'members',
				'action' => 'calendar'
			));
		} else {
			for ($i = $source_start_date, $k = 0; $i <= $source_end_date; $i++, $k++) {
				if (in_array(date('D', $i), $this->data['TutEvent']['checkdate'])) {
					$sourcetime = $this->TutEvent->find('all', array(
						'conditions' => array(
							'TutEvent.start_date  LIKE' => "%" . date('Y-m-d', $i) . "%",
							'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
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
								$this->Session->read('Member.memberid');
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
								$this->Session->read('Member.memberid');
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
				'controller' => 'members',
				'action' => 'calendar'
			));
		}
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
											'TutEvent.tutor_id' => $this->Session->read('Member.memberid')),
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
														'TutEvent.tutor_id' => $this->Session->read('Member.memberid')),
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
														'TutEvent.tutor_id' => $this->Session->read('Member.memberid')),
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
		
		$this->addevent['TutEvent']['tutor_id'] = $this->Session->read('Member.memberid');
		
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
	
	
	/*
		
		function tutorsearch()
		{
		  
		
		
		Configure::write('debug', 0);
		
		
			$schoolid = $this->Member->find('first',array('conditions'=>
													  array(
															'Member.id'=>$this->Session->read('Member.memberid')
														),
													  'recursive' => -1
													  )
										);
		
	
		
		$school_id = $schoolid['Member']['school_id']; 
		
		
		$schooldata = $this->School->find('first',array('conditions'=>
														array('School.id'=>$school_id),
														'recursive' => -1
														)
										  );
		
		$schoolname = $schooldata['School']['school_name'];
		
		
		$this->set('schoolname',$schoolname);
	
			
		$alltutorcourse = $this->TutCourse->find('all',array(
													   'fields' => array(
																		'DISTINCT TutCourse.member_id'
																		)
															   )
												   );
		
		foreach($alltutorcourse as $atc)
		{
		
			$filteralltutorcourse[] = $atc['TutCourse']['member_id'];
		}
		
		
		$alltutorevent = $this->TutEvent->find('all',array(
												   'fields' => array(
																	'DISTINCT TutEvent.tutor_id'
																	)
														   )
											   );
	
		
		foreach($alltutorevent as $ate)
		{
				$filteralltutorevent[] = $ate['TutEvent']['tutor_id'];
		}
		
		$uniquealltutor = array_intersect($filteralltutorcourse, $filteralltutorevent);
		
		$allfinaltutor = $this->Member->find('all',array('conditions'=>
														 array('Member.id'=> $uniquealltutor,
															   'Member.group_id'=> '7',
															   'Member.school_id'=> $school_id
															   ),
														 'recursive' => -1,
														 'fields'=> array('Member.id','Member.school_id')
														 )
											 );
		
		foreach($allfinaltutor as $aft)
		{
			$matchtutor[] = $aft['Member']['id']; 
			
			
		}
		
		
	


		if(!$this->RequestHandler->isAjax() && !isset($this->data) ) {
			
	
			
			$this->paginate['Member'] = array(
			'conditions' => array(
				'Member.id' => $matchtutor
			),
			'order'=>array(
						'Member.created DESC'
				),
			'limit' => 5
			);
			
			$filtertutor1 = $this->paginate('Member');
			
			$this->set('filtertutor1',$filtertutor1);

			
		}
		
		
		
		if (isset($this->data)) {
			$this->Session->write('tutorsearch.course_id', $this->data['TutCourse']['course_id']);
			
			$this->Session->write('tutorsearch.startdate', $this->data['TutEvent']['startdate']);
			
			
			$this->Session->write('tutorsearch.starttime', $this->data['TutEvent']['starttime']);
			$this->Session->write('tutorsearch.endtime', $this->data['TutEvent']['endtime']);
			
			$this->Session->write('tutorsearch.causename', $this->data['userMeta']['cause_name']);
			
		} else {
			
			
			
			
		}
		
		
		
		$courseid  = $this->Session->read('tutorsearch.course_id');
		$startdate = $this->Session->read('tutorsearch.startdate');
		$starttime   = $this->Session->read('tutorsearch.starttime');
		$endtime   = $this->Session->read('tutorsearch.endtime');
		$causename = $this->Session->read('tutorsearch.causename');
		
		if ($courseid) {
			$this->Session->delete('tutorsearch.startdate');
			$this->Session->delete('tutorsearch.starttime');
			$this->Session->delete('tutorsearch.endtime');
			$this->Session->delete('tutorsearch.causename');
			$this->Session->write('tutorsearch.courseIdSelect',$courseid);
			$this->paginate['TutCourse'] = array(
				'conditions' => array(
					'TutCourse.course_id' => $courseid,
					'TutCourse.member_id' => $matchtutor
				),
				'fields'=>array(
								'DISTINCT TutCourse.member_id',
								),
				'recursive' => 2,
				'limit' => 5
			);
			
			$filtertutor = $this->paginate('TutCourse');
		} else if (isset($startdate) && $startdate != '' && isset($starttime) && $starttime != '' && isset($endtime) && $endtime != '') {
			$startArray = explode(" ",$startdate);
			
	
		
			$startDate = date('d-m-y',strtotime($startArray[0]));
			$starttTime = date('H:i',strtotime($starttime));
			
			$endDate = date('d-m-y',strtotime($startArray[0]));
			
			$endtTime = date('H:i',strtotime($endtime));
			
	
			
			$this->Session->delete('tutorsearch.course_id');
			$this->Session->delete('tutorsearch.causename');
			
			$tutorid = $this->TutEvent->find('all', array(
				'conditions' => array(
					"DATE_FORMAT(TutEvent.start_date,'%H:%i:%s') >=" =>  $starttTime,
					"DATE_FORMAT(TutEvent.end_date,'%H:%i:%s') <=" => $endtTime,
					"DATE_FORMAT(TutEvent.start_date,'%d-%m-%y') >=" => $startDate ,
					"DATE_FORMAT(TutEvent.start_date,'%d-%m-%y') <=" => $startDate
					
				),
				'fields' => array(
					'*',
					"DATE_FORMAT(TutEvent.start_date,'%d-%m-%y %H:%i:%s')",
					"DATE_FORMAT(TutEvent.end_date,'%d-%m-%y %H:%i:%s')",
				)
			));
			

			
			
			$alltutorevent = array();
			foreach($tutorid as $tr) {
				$alltutorevent[] = $tr['TutEvent']['tutor_id'];
			}
			
			$tutorbytime = array_intersect($alltutorevent, $matchtutor);
			
	
			
			
			$this->paginate['Member'] = array(
				'conditions' => array(
					'Member.id' => $tutorbytime
				),
				'recursive' => 1,
				'limit' => 5
			);
			
			$filtertutorbytime = $this->paginate('Member');
			
		} else if (isset($causename) && $causename != '') {
			$this->Session->delete('tutorsearch.course_id');
			$this->Session->delete('tutorsearch.startdate');
			$this->Session->delete('tutorsearch.starttime');
			$this->Session->delete('tutorsearch.endtime');
			
			$c