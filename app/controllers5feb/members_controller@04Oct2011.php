<?php
ob_start();
class MembersController extends AppController {
	var $name = 'members';
	var $layout = "frontend";
	var $helpers = array('Form','Html','Error','Javascript', 'Ajax','Paginator',);
	var $components = array('RequestHandler','Email','MailchimpApi');
	var $uses = array('Member','State','userMeta','Group', 'School', 'Course', 'TutCourse','TutEvent','Page','CauseSchool','UserImage','CauseTutor','TutMessage','Privilege','TutRating','PaymentHistory','TutorWithdrawal','TutorToCause','AddFund','CauseWithdrawal','EmailTemplate','TutorRequestCause','UpcomingMember','UpcomingSchool');
	
	// function executes before each action to execute 
	function beforeFilter() {
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
					
					$this->redirect($this->referer());
					
				}
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
		
		$this->autoRender = false;
		Configure::write('debug', 0);
		if (!$this->RequestHandler->isAjax()) {
			$this->layout = "admin";
		}
		if ($this->RequestHandler->isAjax() && !$id) {
			$this->autoRender = false;
			$this->layout     = "";
			
			/*echo '<pre>';
			print_r($this->data);
			die;*/
			
			foreach ($this->data['Member']['id'] as $del_id):
				$delete[]  = $this->Member->delete($del_id);
				$delMeta[] = $this->userMeta->deleteAll(array(
					'userMeta.member_id' => $del_id
				));
			//$deluserImage[] = $this->userImage->deleteAll(array('userImage.user_id' => $del_id));
			endforeach;
			if (!empty($delete) && !empty($delMeta)) {
				echo "deleted";
			} else {
			}
		} else if ($this->RequestHandler->isAjax() && $id) {
			$this->autoRender = false;
			$this->layout     = "";
			
			/*echo $id;
			die;*/
			
			$delete = $this->Member->delete($id);
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
			}
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
		$this->set('emailStatus','');
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
			$this->set('emailStatus','readonly');
			
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
			$this->Session->setFlash('Your courses has been saved Successfully');
			
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
				$userMeta['userMeta']['fb_allow'] = $this->data['userMeta']['fb_allow'];
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
		
		// use id 21 for cause
		
		// use id 8 for student
		
		// use id 6 for tutor
		
	/*	$this->Session->write('Member.memberid', 21);
		
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
						$this->checkuserstep($this->Session->read('Member.id'));
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
		
		if($this->data){
			$this->data['UpcomingMember']['active'] = '1';
			$this->UpcomingMember->create();
			$this->UpcomingMember->save($this->data);
			$this->Session->setFlash('Your request is successfully submitted! We will contact you shortly.');
			$this->redirect(array('controller'=>'members','action'=>'index'));
		}
		$schools = $this->UpcomingSchool->find(
			'list',
			array(
				'fields' => array(
					'UpcomingSchool.id',
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
		
		$this->cause_element();
		
		
		
	}
	
	function tutor_dashboard() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
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
				$this->Session->setFlash('Accepted Successfully!');
				$this->redirect(array(
					'action' => 'cause_request'
				));
			} else {
				$this->CauseTutor->delete($this->data['Member']['id']);
				$this->Session->setFlash('Deleted Successfully!');
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
		
		$this->update_balance();
		
		$userdata = $this->Member->find('first', array(
			'conditions' => array(
				'Member.facebookId' => $this->Session->read('Member.id')
			)
		));
		
		/*	echo '<pre>';
		print_r($userdata);
		die;*/
		
		//print_r($this->data);
		//$usertype=7;
		$usertype = $userdata['Member']['group_id'];
		
		if ($usertype == '6') {
			if ($userdata['userMeta']['fname'] != "" && $userdata['userMeta']['lname'] != "" && $userdata['Member']['email'] != "" && $userdata['userMeta']['contact'] != "" ) {
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
			if ($userdata['userMeta']['fname'] != "" && $userdata['userMeta']['lname'] != "" && $userdata['Member']['email'] != "" && $userdata['userMeta']['contact'] != "" ) {
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
						if ($step4) {
							$this->redirect(array(
								'controller' => 'members',
								'action' => 'tutor_dashboard'
							));
						}
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
				));
				
			}
			
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'regmember'
			));
			
		}
		
		if ($usertype == '8') {
			if ($userdata['userMeta']['fname'] != "" && $userdata['userMeta']['lname'] != "" && $userdata['Member']['email'] != "" && $userdata['userMeta']['contact'] != "" ) {
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
			$this->Session->setFlash('Source day and Start day do not match!');
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
		
		
	/*	
		echo '<pre>';
		echo $schoolname;
		echo $school_id;
		print_r($alltutorevent);
		print_r($alltutor);
		print_r($uniquealltutor);
	
		print_r($allfinaltutor);
		print_r($matchtutor);

		echo '</pre>';			
		die;
		*/


		if(!$this->RequestHandler->isAjax() && !isset($this->data) ) {
			
			$this->Session->delete('tutorsearch');
			
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
			
		//	$endArray = explode(" ",$enddate);
		
			$startDate = date('d-m-y',strtotime($startArray[0]));
			$starttTime = date('H:i',strtotime($starttime));
			
			$endDate = date('d-m-y',strtotime($startArray[0]));
			
			$endtTime = date('H:i',strtotime($endtime));
			
		//	echo "<pre>";print_r($startTime);exit;
			
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
			
	//		echo "<pre>";print_r($tutorid);exit;
			
			
			$alltutorevent = array();
			foreach($tutorid as $tr) {
				$alltutorevent[] = $tr['TutEvent']['tutor_id'];
			}
			
			$tutorbytime = array_intersect($alltutorevent, $matchtutor);
			
			
			
	/*	
				echo '<pre>';
				print_r($tutorid);
				print_r($alltutorevent);
				print_r($matchtutor);
				print_r($tutorbytime);
				die;
			*/
			
			
			
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
			
			$causedata = $this->userMeta->find('first', array(
				'conditions' => array(
					'userMeta.cause_name' => $causename,
					'Member.group_id' => 6,
				),
				'recursive' => 1,
				'fields' => array(
					'userMeta.member_id'
				)
			));
			
			$causeid = $causedata['userMeta']['member_id'];
			
			
			
			$this->paginate['CauseTutor'] = array(
				'conditions' => array(
					'CauseTutor.cause_id' => $causeid,
					'CauseTutor.tutor_id' => $matchtutor,
					'CauseTutor.status' => 1
				),
				'recursive' => 2,
				'limit' => 5
			);
			
			
			
			$filtertutor = $this->paginate('CauseTutor');
			
		}
		
		
		
		
		
		if(isset($filtertutor) && count($filtertutor))
		{
			
			$this->set('filtertutor',$filtertutor);
			
			
			if ($this->RequestHandler->isAjax()) {
				$this->layout = '';
				Configure::write('debug', 0);
				$this->AutoRender = false;
				$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
				$this->render('tutorsearch');
			}
			
		}
		else if(isset($filtertutorbytime) && count($filtertutorbytime))
		{
			
			$this->set('filtertutorbytime',$filtertutorbytime);
			
			if ($this->RequestHandler->isAjax()) {
				$this->layout = '';
				Configure::write('debug', 0);
				$this->AutoRender = false;
				$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
				$this->render('tutorsearchtime');
			}
			
			
			
		}
		
		
		
	
		
	
		
		
	
		
		
		
	}
	
	
	
	//Searching for the tutor
	
	
	function causesearch() {
		Configure::write('debug', 0);
		/*
		if(!$this->RequestHandler->isAjax() && !isset($_POST)) {
		
		$this->Session->delete('searchcause');
		}
		*/
		
		$requestedtutor = array();
		
		$session_id = $this->Session->read('Member.memberid');
		
		if($session_id)
		{
		
		$causeResult = $this->CauseTutor->find('all', array(
		'conditions' => array(
		'CauseTutor.status' => '1',
		'cause_id' => $session_id
		),
		'recursive' => -1
		));
		
		foreach($causeResult as $cr)
		{
			
			$requestedtutor[] = $cr['CauseTutor']['tutor_id'];
			
		}
		
		$this->set('requestedtutor',$requestedtutor);
		
		}
		
		
		if ($_POST || isset($tutorid)) {
			//pr($_POST);
			if (isset($_POST['selectRadio']) && $_POST['selectRadio'] == 'schoolname') {
				$schoolname = $_POST['schoolname'];
				
				
				$this->Session->write('searchcause.schoolname', $schoolname);
				$schoolname = $this->Session->read('searchcause.schoolname');
				$this->Session->delete('searchcause.tutorname');
				$causedata = $this->Member->find('all', array(
					'conditions' => array(
						'School.school_name' => $schoolname,
						'Member.group_id' => 7
					)
				));
				
				$tutorid = array();
				foreach ($causedata as $tuid) {
					$tutorid[] = $tuid['Member']['id'];
				}
				
				
				
				$this->paginate['userMeta'] = array(
					'conditions' => array(
						'userMeta.member_id' => $tutorid
					),
					'recursive' => 2,
					'limit' => 100
				);
				
				$filtertutor = $this->paginate('userMeta');
				
			}
			
			else if (isset($_POST['selectRadio']) && $_POST['selectRadio'] == 'tutorname' && isset($_POST['tutorname']) && $_POST['tutorname'] != '') {
				$tutorname = $_POST['tutorname'];
				$this->Session->write('searchcause.tutorname', $tutorname);
				$tutorname  = $this->Session->read('searchcause.tutorname');
				//echo "<pre>";print_r($tutorname1);exit;
				$tutorname1 = explode(" ", $tutorname);
				//echo "<pre>";print_r($tutorname1);exit;
				$tutorname2 = $tutorname1[0];
				$tutorname3 = $tutorname1[1];
				$this->Session->delete('searchcause.schoolname');
				
				$tutordata = $this->userMeta->find('first', array(
					'conditions' => array(
						'userMeta.fname LIKE' => $tutorname2,
						'userMeta.lname LIKE' => $tutorname3,
						'Member.group_id' => 7
					),
					'recursive' => 2,
					'fields' => array(
						'userMeta.member_id'
					)
				));
				
				$tutorid = $tutordata['userMeta']['member_id'];
				$this->Session->write('searchcause.tutorid', $tutorid);
				
				$this->paginate['userMeta'] = array(
					'conditions' => array(
						'userMeta.member_id' => $tutorid
					),
					'recursive' => 2,
					'limit' => 10
				);
				
				
				$filtertutor = $this->paginate('userMeta');
				
			}
		}
		
		
		/*else{
		
		$this->paginate['userMeta'] = array('conditions'=> array(
		'userMeta.member_id' =>$this->Session->read('searchcause.tutorname'), 
		),	
		'recursive' => 2,
		'limit' => 2
		);
		
		$filtertutor = $this->paginate('userMeta');		
		}*/
		
		if (isset($filtertutor)) {
			$this->set('filtertutor', $filtertutor);
			
		}
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members' . DS . 'causesearch';
			$this->render('causesearch');
		}
		
		
	}
	
	
	function save_request($id = NULL) {
		$tutorid = $id;
		$causeid = $this->Session->read('Member.memberid');
		$groupid = $this->Session->read('Member.group_id');
		/*echo 'tutorid'.$id;
		echo 'groupid'.$groupid;
		echo 'causeid'.$causeid;*/
		$status  = 0;
		
		$tutorname = $this->Member->find('first',array(
										 'conditions'=>
										  array('Member.id'=>$id)
										  )
							);
		
		
		
		$fname = $tutorname['userMeta']['fname'];
		$lname = $tutorname['userMeta']['lname'];
		
		
		
		$request = "Your request has been send to $fname $lname";
		
		
	/*	echo '<pre>';
		print_r($tutorname);
		echo $request;
		die;*/
		
		if (isset($id) && $groupid == 6) {
			$this->data['CauseTutor']['cause_id'] = $causeid;
			$this->data['CauseTutor']['tutor_id'] = $tutorid;
			$this->data['CauseTutor']['status']   = $status;
			$this->CauseTutor->save($this->data);
			
		}
		
		$this->Session->setFlash($request);
		$this->redirect(array(
			'controller' => 'members',
			'action' => 'cause_dashboard'
		));
	}
	
	
	
	// Function for autocomplete
	
	
	
	function get_course_id() {
		$this->layout = false;
		
		Configure::write('debug', 0);
		
		$course = $this->TutCourse->find("list", array(
			'limit' => '10',
			"conditions" => array(
				"TutCourse.course_id LIKE" => $_GET['q'] . "%"
			),
			"fields" => "TutCourse.course_id,TutCourse.course_id",
			"order" => "TutCourse.course_id Asc"
		));
		
		$courseid = array();
		
		if (!empty($course)) {
			foreach ($course as $key => $value) {
				echo "$key|$value\n";
				
			}
			
			
		} else {
			//echo "No Results Found";
		}
		
		die;
	}
	
	
	function get_cause_name() {
		$this->layout = false;
		
		Configure::write('debug', 0);
		
		$cause = $this->userMeta->find("list", array(
			'limit' => '10',
			"conditions" => array(
				"userMeta.cause_name LIKE" => $_GET['q'] . "%"
			),
			"fields" => "userMeta.cause_name,userMeta.cause_name",
			"order" => "userMeta.cause_name Asc"
		));
		
		$causename = array();
		
		if (!empty($cause)) {
			foreach ($cause as $key => $value) {
				echo "$key|$value\n";
				
			}
			
		} else {
			//echo "No Result Found";
		}
		
		die;
	}
	
	
	function runcal() {
	}
	
	/*function aboutus()
	{
	
	
	
	}
	
	function contactus()
	{
	
	
	}*/
	
	function student_schoolinfo() {
		$memberdata = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			)
		));
		
		/*		echo '<pre>';
		print_r($memberdata);
		die;
		*/
		
		$this->set('memberdata', $memberdata);
		$alldata    = $this->School->find('all');
		$schoolname = Set::combine($alldata, '{n}.School.id', '{n}.School.school_name');
		
		$this->set("schoolname", $schoolname);
		
	}
	
	function studentschoolsave() {
		if (isset($this->data)) {
			$this->Member->updateAll(array(
				'Member.school_id' => "'" . $this->data['Member']['school_id'] . "'"
			), array(
				'Member.id' => $this->Session->read('Member.memberid')
			));

                       $schoolchanged = '"'.'Your School has been changed successfully'.'"';    
		
			$this->Session->setFlash($schoolchanged);
			
		}
		
		$this->redirect(array(
			'controller' => 'members',
			'action' => 'student_dashboard'
		));
		
	}
	
	
	function cause_schoolinfo() {
		Configure::write('debug', 3);
		$schools = $this->CauseSchool->find('list', array(
			'fields' => array(
				'school_id'
			),
			'conditions' => array(
				'CauseSchool.cause_id' => $this->Session->read('Member.memberid'),
				'CauseSchool.all' => 0
			)
		));
		$this->set('schools', $schools);
		//pr($schools);exit;
		if (isset($this->data)) {
			$this->CauseSchool->deleteAll(array(
				'CauseSchool.cause_id' => $this->Session->read('Member.memberid')
			));
			if ($this->data['CauseSchool']['check'] == 'all') {
				$data['CauseSchool']['cause_id'] = $this->Session->read('Member.memberid');
				$data['CauseSchool']['all']      = '1';
				$this->CauseSchool->create();
				$this->CauseSchool->save($data);
				
				$this->userMeta->updateAll(array(
					'userMeta.cause_name' => "'" . $this->data['CauseSchool']['name'] . "'"
				), array(
					'userMeta.member_id' => $this->Session->read('Member.memberid')
				));
				
				$this->Member->updateAll(array(
					'Member.paypalEmail' => "'" . $this->data['Member']['paypalEmail'] . "'"
				), array(
					'Member.id' => $this->Session->read('Member.memberid')
				));
				
			} else {
				foreach ($this->data['CauseSchool']['school_id'] as $key => $value) {
					$data['CauseSchool']['cause_id']  = $this->Session->read('Member.memberid');
					$data['CauseSchool']['school_id'] = $value;
					$this->CauseSchool->create();
					$this->CauseSchool->save($data);
				}
				
				$this->userMeta->updateAll(array(
					'userMeta.cause_name' => "'" . $this->data['CauseSchool']['name'] . "'"
				), array(
					'userMeta.member_id' => $this->Session->read('Member.memberid')
				));
				
				$this->Member->updateAll(array(
					'Member.paypalEmail' => "'" . $this->data['Member']['paypalEmail'] . "'"
				), array(
					'Member.id' => $this->Session->read('Member.memberid')
				));
				
			}
			$this->Session->setFlash('School info has been saved sucessfully');
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'cause_dashboard'
			));
		}
		$memberdata = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			)
		));
		$this->set('memberdata', $memberdata);
		$alldata    = $this->School->find('all');
		$schoolname = Set::combine($alldata, '{n}.School.id', '{n}.School.school_name');
		
		$this->set("schoolname", $schoolname);
	}
	
	/* function causeschoolsave()
	{
	if(isset($this->data))
	{
	/*	echo '<pre>';
	print_r($this->data);
	die;
	
	$this->Member->updateAll(	
	array('Member.school_id' => "'" .$this->data['Member']['school_id']. "'"),
	array('Member.id' => $this->Session->read('Member.memberid')) //(conditions) where userid=schoolid
	);
	
	
	$this->userMeta->updateAll(	
	array('userMeta.amount_raised' => '"'.$this->data['userMeta']['amount_raised'].'"'),
	array('userMeta.member_id' => $this->Session->read('Member.memberid')) //(conditions) where userid=schoolid
	);
	
	}
	
	$this->redirect(array('controller'=>'members', 'action'=>'cause_dashboard'));	
	
	} */
	
	
	function dateDiff($start, $end) {
		$start_ts = strtotime($start);
		
		$end_ts = strtotime($end);
		
		$diff = $end_ts - $start_ts;
		
		return round($diff / 86400);
		
	}
	
	
	/*******************Edited by ajayendra**************************/
	function admin_front_static_page() {
		$this->layout = "admin";
		Configure::write('debug', 0);
		$staticdatas = $this->Page->find('all');
		//print_r($staticdatas);die;
		$this->set('manageClass', 'selected');
		$this->set("staticdatas", $staticdatas);
	}
	function admin_static_page_edit($id = NULL) {
		$this->layout = "admin";
		Configure::write('debug', 0);
		if (empty($this->data)) {
			$this->set("id", $id);
			$this->Page->id = $id;
			$this->data     = $this->Page->read();
		} else {
			//print_r($this->data['Page']);die;
			$this->Page->updateAll(array(
				'Page.body' => "'" . mysql_real_escape_string($this->data['Page']['body']) . "'",
				'Page.name' => "'" . mysql_real_escape_string($this->data['Page']['name']) . "'"
			), array(
				'Page.id' => $this->data['Member']['staticid']
			));
			$this->set("id", $this->data['Member']['staticid']);
			$this->Session->setFlash('Text has been updated successfully');
			$this->Page->id = $this->data['Member']['staticid'];
			$this->data     = $this->Page->read();
			
		}
	}
	//Function For Email Template
	
	function admin_email_template() {
		$this->layout="admin";
		Configure::write('debug', 0);
		$staticdatas = $this->EmailTemplate->find('all');
		//print_r($staticdatas);die;
		$this->set('manageClass','selected');
		$this->set("staticdatas",$staticdatas);
	}
	
	
	function admin_edit_email_template($id=NULL) {
		$this->layout="admin";
		Configure::write('debug', 0);
		if(empty($this->data)){
			$this->set("id",$id);
			$this->EmailTemplate->id = $id;
			$this->data = $this->EmailTemplate->read();
		}
		else
		{
			$this->EmailTemplate->updateAll(array('EmailTemplate.html_content' => "'".mysql_real_escape_string($this->data['EmailTemplate']['html_content'])."'" , 'EmailTemplate.title'=> "'". mysql_real_escape_string($this->data['EmailTemplate']['title']) ."'" ),array('EmailTemplate.id'=>$this->data['Member']['staticid']));
			$this->set("id",$this->data['Member']['staticid']);
			$this->Session->setFlash('Text has been updated successfully');
			$this->EmailTemplate->id =$this->data['Member']['staticid'];
			$this->data = $this->EmailTemplate->read();
		}
	}
	
	function about_us() {
		$this->layout = "frontend";
		Configure::write('debug', 0);
		/* $reviews=$this->Review->find('all',array('order'=>array('Review.created DESC'),'limit'=>'5'));
		$this->set('reviews',$reviews);
		if($this->Session->read('Member.group_id') == '3'){
		$savedSearches=$this->saveSearch->find('all',array('conditions'=>array('parent_id'=>$this->Session->read('Member.id')),'limit'=>'10'));
		$this->set('savedSearches',$savedSearches);
		
		}	 */
		$statdatas = $this->Page->find('all', array(
			'conditions' => array(
				'Page.id' => '1'
			)
		));
		$this->set("statdatas", $statdatas);
		//pr($statdatas);die;
	}
	
	function service_terms() {
		$this->layout = "frontend";
		/*$reviews=$this->Review->find('all',array('order'=>array('Review.created DESC'),'limit'=>'5'));
		$this->set('reviews',$reviews);
		
		if($this->Session->read('Member.group_id') == '3'){	$savedSearches=$this->saveSearch->find('all',array('conditions'=>array('parent_id'=>$this->Session->read('Member.id')),'limit'=>'10'));
		$this->set('savedSearches',$savedSearches);
		
		} */
		$statdatas    = $this->Page->find('all', array(
			'conditions' => array(
				'Page.id' => '2'
			)
		));
		$this->set("statdatas", $statdatas);
		
	}
	
	//Function for the CMS standard terms page
	function standard_terms() {
		$this->layout = "frontend";
		/* $reviews=$this->Review->find('all',array('order'=>array('Review.created DESC'),'limit'=>'5'));
		$this->set('reviews',$reviews);
		
		if($this->Session->read('Member.group_id') == '3'){
		
		$savedSearches=$this->saveSearch->find('all',array('conditions'=>array('parent_id'=>$this->Session->read('Member.id')),'limit'=>'10'));
		$this->set('savedSearches',$savedSearches);
		
		} */
		$statdatas    = $this->Page->find('all', array(
			'conditions' => array(
				'Page.id' => '3'
			)
		));
		$this->set("statdatas", $statdatas);
		
	}
	
	//Function for the CMS site map page
	function site_map() {
		$this->layout = "frontend";
		/* $reviews=$this->Review->find('all',array('order'=>array('Review.created DESC'),'limit'=>'5'));
		$this->set('reviews',$reviews);
		
		if($this->Session->read('Member.group_id') == '3'){
		
		$savedSearches=$this->saveSearch->find('all',array('conditions'=>array('parent_id'=>$this->Session->read('Member.id')),'limit'=>'10'));
		$this->set('savedSearches',$savedSearches);
		
		} */
		$statdatas    = $this->Page->find('all', array(
			'conditions' => array(
				'Page.id' => '4'
			)
		));
		$this->set("statdatas", $statdatas);
		
	}
	
	/********************************************/
	
	
	
	function admin_cause_view() {
		//$this->set("schoolid",$schoolid) ;
		
		//	echo $id;
		
		//	$id=convert_uudecode(base64_decode($id));
		
		/*echo $id;
		
		die;*/
		
		
		$this->layout = 'admin';
		
		$this->set("causeClass", "selected"); //set main navigation class
		
		Configure::write('debug', 0);
		/*$this->set("course_id",$this->data['Course']['course_id']);
		
		$this->set("course_title",$this->data['Course']['course_title']);
		$this->set("pages",$this->data['Course']['perpage']);
		$this->Session->delete('courseview');
		*/
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('causeview');
			//	echo 'jaswant';
			//	die;
			
		}
		
		
		if (isset($this->data)) {
			$this->Session->write('causeview.email', $this->data['Member']['email']);
			$this->Session->write('causeview.active', $this->data['Member']['active']);
			$this->Session->write('causeview.address', $this->data['userMeta']['address']);
			$this->Session->write('causeview.perpage', $this->data['Member']['perpage']);
			
			
			$this->data['Member']['email']     = $this->Session->read('causeview.email');
			$this->data['Member']['active']    = $this->Session->read('causeview.active');
			$this->data['userMeta']['address'] = $this->Session->read('causeview.address');
			$this->data['Member']['perpage']   = $this->Session->read('causeview.perpage');
			
		} else {
			$this->data['Member']['email']     = $this->Session->read('causeview.email');
			$this->data['Member']['active']    = $this->Session->read('causeview.active');
			$this->data['userMeta']['address'] = $this->Session->read('causeview.address');
			
			
		}
		
		
		if (strlen($this->Session->read('causeview.perpage')) > 0) {
			$this->data['Member']['perpage'] = $this->Session->read('causeview.perpage');
		} else {
			$this->data['Member']['perpage'] = '10';
		}
		$conditions = array();
		
		//$conditions=array_merge($conditions,array('Member.school_id' => $schoolid));
		$conditions = array_merge($conditions, array(
			'Member.group_id' => '6'
		));
		
		if ($this->data['Member']['email']) {
			$conditions = array_merge($conditions, array(
				'Member.email  LIKE' => $this->data['Member']['email'] . "%"
			));
			
		}
		
		if ($this->data['Member']['active']) {
			$conditions = array_merge($conditions, array(
				'Member.active' => $this->data['Member']['active']
			));
			
		}
		
		/*{
		$conditions['OR']=array_merge(array(   
		'userMeta.address LIKE'=> "%" . $this->data['userMeta']['address'] . "%",
		'userMeta.city LIKE'=> "%" . $this->data['userMeta']['address'] . "%",
		'userMeta.state LIKE'=> "%" . $this->data['userMeta']['address']. "%",
		'userMeta.country LIKE'=> "%".$this->data['userMeta']['address']."%",
		'userMeta.zip LIKE'=> "%".$this->data['userMeta']['address']."%"
		)
		);
		}	*/
		if ($this->data['userMeta']['address']) {
			$conditions['OR'] = array_merge(array(
				'userMeta.address LIKE' => "%" . $this->data['userMeta']['address'] . "%",
				'userMeta.city LIKE' => "%" . $this->data['userMeta']['address'] . "%",
				'userMeta.state LIKE' => "%" . $this->data['userMeta']['address'] . "%",
				'userMeta.country LIKE' => "%" . $this->data['userMeta']['address'] . "%",
				'userMeta.zip LIKE' => "%" . $this->data['userMeta']['address'] . "%"
			));
		}
		
		
		/*	echo '<pre>';
		print_r($conditions);
		die;*/
		
		
		$this->paginate['Member'] = array(
			'limit' => $this->data['Member']['perpage'],
			// 'order' => array('Course.id' => 'desc' ),
			'recursive' => 2
		);
		
		
		/*   $this->paginate['Course'] = array(
		'conditions'=>array(
		'Course.school_id' => $id
		)
		);
		
		$courses = $this->paginate('Course');*/
		
		
		
		$causes = $this->paginate('Member', $conditions);
		
		
		/*echo '<pre>';
		
		print_r($tutors);
		die;
		
		*/
		
		$this->set('causes', $causes);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'schools';
			$this->render('viewcause');
			
			
		}
	}
	
	
	
	/*********Edit Cause School info**************/
	
	
	function admin_edit_cause_schoolinfo($id = NULL) {
		Configure::write('debug', 3);
		$schools = $this->CauseSchool->find('list', array(
			'fields' => array(
				'school_id'
			),
			'conditions' => array(
				'CauseSchool.cause_id' => $this->Session->read('Member.memberid'),
				'CauseSchool.all' => 0
			)
		));
		$this->set('schools', $schools);
		
		$this->layout = "admin";
		$this->set("causeClass", "selected"); //set main navigation class
		
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
		/*echo "<pre>";print_r($admindata);exit;*/
		
		if (!empty($this->data)) {
			$this->CauseSchool->deleteAll(array(
				'CauseSchool.cause_id' => $this->Session->read('Member.memberid')
			));
			
			if ($this->data['CauseSchool']['check'] == 'all') {
				$this->CauseSchool->create();
				$data['CauseSchool']['cause_id'] = $this->Session->read('Member.memberid');
				$data['CauseSchool']['all']      = '1';
				$this->CauseSchool->save($data);
				
				$this->userMeta->updateAll(array(
					'userMeta.cause_name' => "'" . $this->data['CauseSchool']['name'] . "'"
				), array(
					'userMeta.member_id' => $this->Session->read('Member.memberid')
				));
				
			} else {
				foreach ($this->data['CauseSchool']['school_id'] as $key => $value) {
					$data['CauseSchool']['cause_id']  = $this->Session->read('Member.memberid');
					$data['CauseSchool']['school_id'] = $value;
					$this->CauseSchool->create();
					$this->CauseSchool->save($data);
				}
				
				$this->userMeta->updateAll(array(
					'userMeta.cause_name' => "'" . $this->data['CauseSchool']['name'] . "'"
				), array(
					'userMeta.member_id' => $this->Session->read('Member.memberid')
				));
				
			}
			
			$data['Member']['group_id']  = $this->data['Member']['group_id'];
			$data['Member']['active']    = $this->data['Member']['status'];
			$data['Member']['id']        = $this->data['Member']['id'];
			$data['Member']['school_id'] = $this->data['Member']['school_id'];
			
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
				$userMeta['userMeta']['member_id'] = $this->data['Member']['id'];
				
				$user = $this->userMeta->find('first', array(
					'conditions' => array(
						'member_id' => $this->data['Member']['id']
					)
				));
				
				$userMeta['userMeta']['id'] = $user['userMeta']['id'];
				
				$this->userMeta->create();
				
				if ($this->userMeta->save($userMeta)) {
					$this->Session->setFlash('User has been edited');
					
					$this->redirect(array(
						'action' => 'member_view',
						'admin' => true
					));
					
				}
			}
		}
		
		
		$admindata = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $id
			)
		));
		
		$this->set('admindata', $admindata);
		
	}
	
	
	
	
	
	//Function For Exporting the data in Excel
	
	
	function admin_exportcausecsv() {
		//$this->set("schoolId",$schoolId);
		
		
		/*$Page=$this->Member->find('all',array(
		'conditions'=>array(
		'Member.active !='=>'0'),
		'order'=>array(
		'Member.created'=>'desc')
		)
		);*/
		
		$Page = $this->Member->find('all', array(
			'conditions' => array(
				'Member.group_id' => '6'
			)
		));
		//echo "<pre>";print_r($Page);exit;
		$data = "S.No,Name,User Email,Address,Contact,Status\n";
		$i    = 1;
		foreach ($Page as $pages):
			$data .= $i . ",";
			
			$fullname = $pages['userMeta']['fname'] . ' ' . $pages['userMeta']['lname'];
			$data .= $fullname . ",";
			$useremail = $pages['Member']['email'];
			$data .= $useremail . ",";
			
			$address = $pages['userMeta']['address'] . ' ' . $pages['userMeta']['city'] . ' ' . $pages['userMeta']['state'] . ' ' . $pages['userMeta']['country'] . ' ' . $pages['userMeta']['zip'];
			
			$data .= $address . ",";
			
			$contact = $pages['userMeta']['contact'];
			$data .= $contact . ",";
			
			$sta = $pages['Member']['active'];
			if ($sta == 1) {
				$status = 'Active';
			} else {
				$status = 'Deactive';
			}
			$data .= $status . "\n";
			
			$i++;
		endforeach;
		echo $data;
		header("Content-type:text/octect-stream");
		header("Content-Disposition:attachment;filename=Cause(" . date('m/d/Y') . ").csv");
		die();
	}
	
	
	function select_type($id = null) {
		$selecttype = array(
			'33',
			'34',
			'35',
			
		);
		
		
		$dynamictext = $this->Page->find('all', array(
			'conditions' => array(
				'Page.id' => $selecttype
			)
		));
		
		$this->set('dynamictext', $dynamictext);
		
		
		
		
		if ($id) {
			$this->Member->updateAll(array(
				'Member.group_id' => "'" . $id . "'"
			), array(
				'Member.facebookId' => $this->Session->read('Member.id')
			));
			
			$this->Session->write('Member.group_id', $id);
			
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'regmember'
			));
			
		}
	}
	
	function imgUpload() {
		$medHeight = '180';
		$medWidth  = '180';
		App::Import('Component', 'Upload');
		$upload = new UploadComponent();
		if (!empty($_FILES)) {
			$destination  = realpath('../../app/webroot/img/members/') . '/';
			$destination2 = realpath('../../app/webroot/img/members/thumb/') . '/';
			$imgName      = pathinfo($_FILES['userImage']['name']);
			$ext          = $imgName['extension'];
			$time         = explode(" ", microtime());
			$newImgName   = md5($time[1]);
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
				}
			}
		}
	}
	
	
	
	function tutoravail($id = null) {
		$this->layout = 'frontend';
		
		$tutevent = $this->TutEvent->find('all', array(
			'conditions' => array(
				'TutEvent.tutor_id' => $id,
				'TutEvent.start_date >' => date('Y-m-d H:i:s')
			)
		));
		
		
		$this->set('tutevent', $tutevent);
		
		
		
	}
	
	function book_tutor_course($id = NULL) {
		$this->layout = 'frontend';
		$defaultCourse = $this->Session->read('tutorsearch.courseIdSelect');
		$this->set('defaultCourse',$defaultCourse);
		if (isset($_POST['courseid'])) {
			$courseid = $_POST['courseid'];
			
			//	$courserate = $this->
			
			/*	echo '<pre>';
			print_r($_POST);
			die;*/
			
			$tutcourse = $this->TutCourse->find('first', array(
				'conditions' => array(
					'TutCourse.id' => $courseid
				),
				'recursive' => -1
			));
			
			/*	echo '<pre>';
			print_r($tutcourse);
			die;*/
			
			
			$this->Session->write('booktutor.tutorid', $tutcourse['TutCourse']['member_id']);
			
			$this->Session->write('booktutor.coursename', $tutcourse['TutCourse']['course_id']);
			
			$this->Session->write('booktutor.rate', $tutcourse['TutCourse']['rate']);
			
			$this->redirect(array(
				'action' => 'book_tutor_time'
			));
			
		}
		
		$tutorcourse = $this->TutCourse->find('all', array(
			'conditions' => array(
				'TutCourse.member_id' => $id
			),
			'recursive' => -1
		));
		
		
		$this->set('tutorcourse', $tutorcourse);
		
	}
	
	function book_tutor_time() {
		$this->layout = 'frontend';
		$tutevent     = $this->TutEvent->find('all', array(
			'conditions' => array(
				'TutEvent.tutor_id' => $this->Session->read('booktutor.tutorid'),
				'TutEvent.start_date >' => date('Y-m-d H:i:s')
			)
		));
		
		
		/*	echo '<pre>';
		print_r($tutevent);
		die;*/
		$this->set('tutevent', $tutevent);
		
	}
	
	function selecttutortime() {
		$this->layout     = "";
		$this->autoRender = false;
		
		$tuteventid = $_REQUEST['tuteventid'];
		$starttime  = $_REQUEST['starttime'];
		$end        = $_REQUEST['end'];
		
		$this->Session->write('booktutor.tuteventid', $tuteventid);
		
		$this->Session->write('booktutor.starttime', $starttime);
		
		$this->Session->write('booktutor.endtime', $end);
		
		$start_ts = strtotime($starttime);
		
		$end_ts = strtotime($end);
		
		if ($start_ts > $end_ts) {
			$diff = $start_ts - $end_ts;
		} else {
			$diff = $end_ts - $start_ts;
		}
		
		$diffhours = $diff / 3600;
		
		$this->Session->write('booktutor.tuthours', $diffhours);
		
		echo 'sucess';
		
		
		
	}
	
	
	function fetch_tutor_hours() {
		$this->layout = '';
		
		$id = $_REQUEST['id'];
		
		/*	
		echo $id;
		die;
		
		echo $id;*/
		
		$bookedtime = $this->TutEvent->find('first', array(
			'conditions' => array(
				'TutEvent.id' => $id
			)
		));
		
		
		$start_ts = strtotime($bookedtime['TutEvent']['start_date']);
		
		$end_ts = strtotime($bookedtime['TutEvent']['end_date']);
		
		$diff = $end_ts - $start_ts;
		
		$diffhours = $diff / 3600;
		
		$count = $diffhours;
		
		
		
		//	return round($diff / 86400);		
		
		$this->set('count', $count);
		
		$this->set('bookedtime', $bookedtime);
		
		
	}
	
	
	function send_session_request() {
		Configure::write('debug', 0);
		$student_id          = $this->Session->read('Member.memberid');
		$tutor_id            = $this->Session->read('booktutor.tutorid');
		$booked_course       = $this->Session->read('booktutor.coursename');
		$booked_start_time   = $this->Session->read('booktutor.starttime');
		$unix_start_time     = strtotime($booked_start_time);
		$booked_end_time     = $this->Session->read('booktutor.endtime');
		$unix_end_time       = strtotime($booked_end_time);
		$tutor_rate_per_hour = $this->Session->read('booktutor.rate');
		$tutoring_hours      = $this->Session->read('booktutor.tuthours');
		$tut_event_id        = $this->Session->read('booktutor.tuteventid');
		
		$tutorName = $this->userMeta->find('first', array(
			'conditions' => array(
				'userMeta.member_id' => $tutor_id
			)
		));
		$tutName   = $tutorName['userMeta']['fname'] . " " . $tutorName['userMeta']['lname'];
		if (isset($_POST['booked']) && $_POST['booked'] == 1) {
			$this->data['PaymentHistory']['student_id']          = $student_id;
			$this->data['PaymentHistory']['tutor_id']            = $tutor_id;
			$this->data['PaymentHistory']['booked_course']       = $booked_course;
			$this->data['PaymentHistory']['booked_start_time']   = date('Y-m-d H:i:s', $unix_start_time);
			$this->data['PaymentHistory']['booked_end_time']     = date('Y-m-d H:i:s', $unix_end_time);
			$this->data['PaymentHistory']['tutor_rate_per_hour'] = $tutor_rate_per_hour;
			$this->data['PaymentHistory']['tutoring_hours']      = $tutoring_hours;
			$this->data['PaymentHistory']['tut_event_id']        = $tut_event_id;
			$this->data['PaymentHistory']['session_status']      = 'Booked';
			$this->PaymentHistory->save($this->data);
			$paymentid = $this->PaymentHistory->id;
			$this->set('paymentid', $paymentid);
			$this->Session->setFlash('Your request has been sent to ' . $tutName . '.');
			
			// To send a mail 
			
			$this->stdreq_email_template($paymentid);
			
			// End To send a mail 
			
			
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'student_dashboard'
			));
		}
		
	}
	
		function stdreq_email_template($paymentid = null){
			
		$paymentdata = $this->PaymentHistory->find('first',array('conditions'=>
															 array('PaymentHistory.id'=> $paymentid),
															 'recursive'=> 2
															 )
											   );
		
				
				
		$payingtutorid = $paymentdata['PaymentHistory']['tutor_id'];
		
		$tutoremail = $this->Member->find('first', array(
		'conditions' => array(
			'Member.id' => $payingtutorid
		)
	));
		
		$to	= $tutoremail['Member']['email'];
		
	//	$email_template = $this->get_email_template('date_booking_confirmation');							
	
		$email_template = $this->get_email_template(1);										
																							
		$this->Email->to = $to;
		
		$this->Email->replyTo = "notifications@tutorcause.com";
		
		$this->Email->from = "notifications@tutorcause.com";
		
		$this->Email->subject = $email_template['EmailTemplate']['subject'];
									
		$this->Email->sendAs = 'html';
		
		$this->Email->template = 1;
		
	/*	$from	= "tutorcause@gmail.com";
		$subject = 'Date booking confirmation';
		$message = $this->stdreq_email_template($paymentid);
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= 'From:'.$from . "\r\n";
	//	$headers .= 'BCc: promatics.jaswant@gmail.com' . "\r\n";

		mail($to, $subject, $message, $headers);*/
		
		
		$paymentdata = $this->PaymentHistory->find('first',array('conditions'=>
																 array('PaymentHistory.id'=> $paymentid),
																 'recursive'=> 2
																 )
												   );
		
		
		$studentname = $paymentdata['student']['userMeta']['fname']. " " .$paymentdata['student']['userMeta']['lname'];
		$tutorname = $paymentdata['tutor']['userMeta']['fname']. " " .$paymentdata['tutor']['userMeta']['lname'];
		$starttime =  $paymentdata['PaymentHistory']['booked_start_time'];
		$formatstarttime = date('F d, y @ G:i a',strtotime($starttime));
		$endtime =  $paymentdata['PaymentHistory']['booked_end_time'];
		$formatendtime = date('F d, y @ G:i a',strtotime($endtime));
		$course = $paymentdata['PaymentHistory']['booked_course'];
		$nettime = $paymentdata['PaymentHistory']['tutoring_hours'];
		$hourlyrate = $paymentdata['PaymentHistory']['tutor_rate_per_hour'];
		$totalcost = $nettime * $hourlyrate;
		$studentemail =  $paymentdata['student']['email']; 
		$totalcost1 =  sprintf("%.2f", $totalcost );
		
		$Time =  $formatstarttime." to ".$formatendtime;
		
		$this->set('tutorname', $tutorname );
		$this->set('studentname', $studentname );
		$this->set('studentemail', $studentemail );
		$this->set('course', $course );
		$this->set('Time', $Time );
		$this->set('hourlyrate', $hourlyrate );
		$this->set('totalcost1', $totalcost1 );
		
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
		
		
	   /*SMTP Options 
	   $this->Email->smtpOptions = array(
	   port'=>'25',
	   timeout'=>'30',
	   host' => 'ssl://smtp.gmail.com',
	   username'=>'notifications@tutorcause.com',
	   password'=>'3micedownlow',
	   );
	   
	    Set delivery method 
	   $this->Email->delivery = 'smtp';
	    Do not pass any args to send() 
	   $this->Email->send();
	    Check for SMTP errors. 
	   $this->set('smtp_errors', $this->Email->smtpError);*/
										
		$this->Email->send();
		
		
	/*	Configure::write('debug', 0);
		$template = "<div>
			<p>Dear ($tutorname )</p>
			<p>A student has booked you for session </p>
			<p> StudentName: $studentname</p>
			<p> Email: $studentemail</p>
			<p> Course: $course</p>
			<p>Time: $Time </p> 
			<p> HourlyRate: $ ". $hourlyrate."</p>
			<p>TotalSessionCost: $ ". $totalcost1." </p>
		</div>";
			return $template;*/
		
	}
	
	
	
	function send_msg_to_tutor() {
		$data['TutMessage']['to_id']           = $_POST['tutorId'];
		$data['TutMessage']['from_id']         = $this->Session->read('Member.memberid');
		$data['TutMessage']['conversation_id'] = uniqid();
		$data['TutMessage']['subject']         = $_POST['subject'];
		$data['TutMessage']['message']         = $_POST['message'];
		$data['TutMessage']['datetime']        = date('Y-m-d H:i:s');
		$data['TutMessage']['status']          = 0;
		$this->TutMessage->create();
		if($this->TutMessage->save($data)){
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
			echo "Message sent Successfully";
			exit;
		}
	}
	
	function messages() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		if ($this->Session->read('Member.group_id') == 6) {
			$this->cause_element();
		} else if ($this->Session->read('Member.group_id') == 7) {
			$this->tutor_element();
		} else if ($this->Session->read('Member.group_id') == 8) {
			$this->student_element();
		}
		$this->paginate['TutMessage'] = array(
			'fields' => array(
				'*',
				'count(TutMessage.conversation_id) as conId'
			),
			'conditions' => array(
				'TutMessage.to_id' => $this->Session->read('Member.memberid')
			),
			'order' => array(
				'TutMessage.datetime DESC'
			),
			'group' => array(
				'TutMessage.conversation_id'
			),
			'limit' => 5
		);
		$msgList	= $this->paginate('TutMessage');
		$this->set('msgList', $msgList);
		if ($this->RequestHandler->isAjax()) {
			$this->layout     = '';
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
			$this->render('message');
		}
	}
	
	function conversation() {
		$this->layout = '';
		Configure::write('debug', 0);
		$content = $this->TutMessage->find('all', array(
			'conditions' => array(
				'TutMessage.conversation_id' => $_REQUEST['conversation']
			)
		));
		$this->TutMessage->updateAll(array(
			'TutMessage.status' => "'1'"
		), array(
			'TutMessage.conversation_id' => $_REQUEST['conversation'],
			'TutMessage.to_id' => $this->Session->read('Member.memberid')
		));
		$this->set('content', $content);
	}
	
	function send_message() {
		$data['TutMessage']['to_id']           = $_REQUEST['fromid'];
		$data['TutMessage']['from_id']         = $this->Session->read('Member.memberid');
		$data['TutMessage']['conversation_id'] = $_REQUEST['conversation'];
		$data['TutMessage']['subject']         = $_REQUEST['subject'];
		$data['TutMessage']['message']         = $_REQUEST['message'];
		$data['TutMessage']['datetime']        = date('Y-m-d H:i:s');
		$data['TutMessage']['status']          = 0;
		$this->TutMessage->create();
		if($this->TutMessage->save($data)){
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
			$sendMessage = $this->sendEmailAlert($toMemberData['Member']['email'],$toMemberData['userMeta']['fname'],$fromMemberData['userMeta']['fname'],$data['TutMessage']['subject'],$data['TutMessage']['message']);
			echo "Message sent Successfully";
			exit;
		}
		
	}
	
	function edit_profile() {
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
			
			/*$this->data['Member']['fname'] = $this->data['Member']['fname'];
			$this->data['Member']['lname'] = $this->data['Member']['lname'];
			
			$this->data['Member']['biography'] = $this->data['Member']['biography'];
			$this->data['Member']['address'] = $this->data['Member']['address'];
			$this->data['Member']['contact'] = $this->data['Member']['contact'];
			$this->data['Member']['state'] = $this->data['Member']['state'];
			$this->data['Member']['country'] = $this->data['Member']['country'];
			$this->data['Member']['zip'] = $this->data['Member']['zip'];*/
			
			if ($this->Member->save($memberdata)) {
				$userMeta['userMeta']['fname']     = $this->data['userMeta']['fname'];
				$userMeta['userMeta']['lname']     = $this->data['userMeta']['lname'];
				$userMeta['userMeta']['address']   = $this->data['userMeta']['address'];
				$userMeta['userMeta']['city']      = $this->data['userMeta']['city'];
				$userMeta['userMeta']['state']     = $this->data['userMeta']['state'];
				$userMeta['userMeta']['zip']       = $this->data['userMeta']['zip'];
				$userMeta['userMeta']['contact']   = $this->data['userMeta']['contact'];
				$userMeta['userMeta']['member_id'] = $this->data['Member']['id'];
				
				$user = $this->userMeta->find('first', array(
					'conditions' => array(
						'member_id' => $this->data['Member']['id']
					)
				));
				
				$userMeta['userMeta']['id'] = $user['userMeta']['id'];
				
				$this->userMeta->create();
				
				if ($this->userMeta->save($userMeta)) {
					$this->checkuserstep($this->Session->read('Member.id'));
					
				}
			}
			
		}
	}
	
	function tutorRating() {
		//pr($this->Session->read('rating'));exit;
	}
	
	function rating() {
		if (isset($_REQUEST['by']) && isset($_REQUEST['rating'])) {
			if ($_REQUEST['by'] == 'knowledge') {
				$this->Session->write('rating.knowledge', $_REQUEST['rating']);
			} else if ($_REQUEST['by'] == 'ability') {
				$this->Session->write('rating.ability', $_REQUEST['rating']);
			}
		}
		exit;
	}
	
	function save_rating() {
		if (isset($this->data)) {
			if ($this->Session->read('rating.knowledge') && $this->Session->read('rating.ability')) {
				$TutRating['student_id'] = $this->Session->read('Member.memberid');
				$TutRating['tutor_id']   = $this->data['Member']['tutorId'];
				$TutRating['payment_id'] = $this->data['Member']['paymentId'];
				$TutRating['ability']    = $this->Session->read('rating.ability');
				$TutRating['knowledge']  = $this->Session->read('rating.knowledge');
				$TutRating['datetime']   = date('Y-m-d H:i:s');
				$this->TutRating->create();
				$this->TutRating->save($TutRating);
				$this->Session->delete('rating');
				$this->redirect(array(
					'action' => 'student_completed_session'
				));
			} else {
				$this->Session->setFlash('Please rate both, knowledge and ability');
				$this->redirect(array(
					'action' => 'student_completed_session'
				));
			}
		}
		exit;
	}
	
	function tutor($id = NULL) {
		
		$regId=explode('_',$id);
		$id=$regId[1];
		
//		$id = convert_uudecode(base64_decode($id));
		
		$this->set('picture', $this->getProfilePic1($id));
		
		$getBalance = $this->Member->find('first', array(
			/* 'fields' => array(
				'balance'
			), */
			'conditions' => array(
				'Member.id' => $id
			)
		));
		
		$this->set('getBalance', $getBalance);
		
		$causeResult = $this->CauseTutor->find('all', array(
		'conditions' => array(
		'CauseTutor.status' => '1',
		'tutor_id' => $id
		),
		'recursive' => 2
		));
		//pr($causeResult);exit;
		$this->set('causeResult', $causeResult);
		
		
		
			
	}
	function paypal($paymentid = Null) {
		
		
$email = "promatics.jaswant@gmail.com";
		
		$header = "";
		
		$emailtext = "";		
		// PHP 4.1

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ( FSOCKET , 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
	
	
		foreach ($_POST as $key => $value) {
						$emailtext .= $key . " = " . $value . "\n\n";
					}
		mail($email, "verified", $emailtext . "\n\n" . $req);
	
	
					
				if ($_POST['payment_status'] == 'Completed') {
						$existTxn = $this->PaymentHistory->find('count', array(
							'conditions' => array(
								'PaymentHistory.paypal_confirm_id' => $_POST['txn_id']
							),
							'recursive' => -1
						));
						
						if ($existTxn == 0) {
							
							$taxid         = $_POST['txn_id'];
							$email         = $_POST['payer_email'];
							$status        = 'complete';
							$amount        = $_POST['mc_gross'];
							$sessionstatus = 'Paided';
							$paymentdate = $_POST['payment_date'];
							
							$this->PaymentHistory->updateAll(array(
								'PaymentHistory.amount' => "'" . $amount . "'",
								'PaymentHistory.paypal_status' => "'" . $status . "'",
								'PaymentHistory.paypal_email' => "'" . $email . "'",
								'PaymentHistory.paypal_confirm_id' => "'" . $taxid . "'",
								'PaymentHistory.session_status' => "'" . $sessionstatus . "'",
								'PaymentHistory.paypal_date' => "'" . $paymentdate . "'"
							), array(
								'PaymentHistory.id' => $paymentid
							) //(conditions) where userid=schoolid
								);
							$getAmount = $this->PaymentHistory->find('first', array(
								'fields' => array(
									'SUM(PaymentHistory.tutor_rate_per_hour*PaymentHistory.tutoring_hours) AS amount',
									'PaymentHistory.tutor_id'
								),
								'conditions' => array(
									'PaymentHistory.id' => $paymentid
								)
							));
							
							$this->Member->updateAll(array(
								'Member.balance' => ('Member.balance+' . $getAmount[0]['amount'])
							), array(
								'Member.id' => $getAmount['PaymentHistory']['tutor_id']
							));
							
							
							/***		Sending Mail		***/
							
							
							$this->tutcnf_email_template($paymentid);
					
				
							$this->stdcnfm_email_template($paymentid);
							
							
							/***		End Sending Mail		**/
							
						}
						
					} 
					
				else if ($_POST['payment_status'] == 'Cancelled') {
						$this->payData['PaymentHistory']['paypal_status']     = 'unable to process';
						$this->payData['PaymentHistory']['paypal_email']      = '"' . $_POST['payer_email'] . '"';
						$this->payData['PaymentHistory']['paypal_confirm_id'] = '"' . $_POST['txn_id'] . '"';
						$this->payData['PaymentHistory']['paypal_date'] = '"' . $_POST['payment_date'] . '"';
						$this->PaymentHistory->save($this->payData);
					}
					
				}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
foreach ($_POST as $key => $value) {
						$emailtext .= $key . " = " . $value . "\n\n";
					}
mail($email, "Live-INVALID IPN", $emailtext . "\n\n" . $req);



}
}
fclose ($fp);
}
		
	
	}
	
	function paying_session($paymentid = NULL ) {
		$PaymentMethod = $this->Session->read('payment.method');
		if (isset($PaymentMethod)) {
			$this->set('method', $PaymentMethod);
		} else {
			$this->redirect(array(
				'action' => 'student_dashboard'
			));
		}
		if (isset($this->data)) {
			$amount     = $this->data['Member']['amount'];
			$balanceRow = $this->Member->find('first', array(
				'fields' => array(
					'Member.creditable_balance'
				),
				'conditions' => array(
					'Member.id' => $this->Session->read('Member.memberid')
				),
				'recursive' => -1
			));
			$balance    = $balanceRow['Member']['creditable_balance'];
			if ($balance >= $amount) {
				if ($this->PaymentHistory->updateAll(array(
					'PaymentHistory.amount' => "'" . $amount . "'",
					'PaymentHistory.paypal_status' => "'complete'",
					//'PaymentHistory.paypal_email' => "'".$email."'",
					//'PaymentHistory.paypal_confirm_id' => "'" .$taxid. "'",
					'PaymentHistory.session_status' => "'Paided'"
				), array(
					'PaymentHistory.id' => $paymentid
				))) {
					$this->Member->updateAll(array(
						'Member.creditable_balance' => "Member.creditable_balance-" . $amount
					), array(
						'Member.id' => $this->Session->read('Member.memberid')
					));
					$this->Session->delete('payment');
					$this->Session->setFlash('Payment Successfully!');
					
					$getAmount = $this->PaymentHistory->find('first', array(
						'fields' => array(
							'SUM(PaymentHistory.tutor_rate_per_hour*PaymentHistory.tutoring_hours) AS amount',
							'PaymentHistory.tutor_id'
						),
						'conditions' => array(
							'PaymentHistory.id' => $paymentid
						)
					));
					
					$this->Member->updateAll(array(
						'Member.balance' => ('Member.balance+' . $getAmount[0]['amount'])
					), array(
						'Member.id' => $getAmount['PaymentHistory']['tutor_id']
					));
					
				
					$this->tutcnf_email_template($paymentid);
					
				
					$this->stdcnfm_email_template($paymentid);
					
					$this->redirect(array(
						'action' => 'student_dashboard'
					));
					
					
				}
			}
		}
		$this->set('paymentid', $paymentid);
		$paydata = $this->PaymentHistory->find('first', array(
			'conditions' => array(
				'PaymentHistory.id' => $paymentid
			)
		));
		
		$this->set('paydata', $paydata);
		
	}
	
	
	function stdcnfm_email_template($paymentid = null){
		
		
				$paymentdata   = $this->PaymentHistory->find('first', array(
					'conditions' => array(
					'PaymentHistory.id' => $paymentid
					),
				'recursive' => 2
				));
				$payingstudentid = $paymentdata['PaymentHistory']['student_id'];
				$studentemail  = $this->Member->find('first', array(
					'conditions' => array(
					'Member.id' => $payingstudentid
					)
				));
				
				$to  = $studentemail['Member']['email'];
						
			//	$email_template = $this->get_email_template('student_paying_confirmation');						
			    $email_template = $this->get_email_template(2);										
																									
				$this->Email->to = $to;
				
				$this->Email->replyTo = "notifications@tutorcause.com";
				
				$this->Email->from = "notifications@tutorcause.com";
				
				$this->Email->subject = $email_template['EmailTemplate']['subject'];
											
				$this->Email->sendAs = 'html';
				
				$this->Email->template = 2;
			
	
		$paymentdata = $this->PaymentHistory->find('first',array('conditions'=>
																 array('PaymentHistory.id'=> $paymentid),
																 'recursive'=> 2
																 )
												   );
		
		$studentname = $paymentdata['student']['userMeta']['fname']. " " .$paymentdata['student']['userMeta']['lname'];
		$tutorname = $paymentdata['tutor']['userMeta']['fname']. " " .$paymentdata['tutor']['userMeta']['lname'];
		$starttime =  $paymentdata['PaymentHistory']['booked_start_time'];
		$formatstarttime = date('F d, y @ G:i a',strtotime($starttime));
		$endtime =  $paymentdata['PaymentHistory']['booked_end_time'];
		$formatendtime = date('F d, y @ G:i a',strtotime($endtime));
		$course = $paymentdata['PaymentHistory']['booked_course'];
		$nettime = $paymentdata['PaymentHistory']['tutoring_hours'];
		$hourlyrate = $paymentdata['PaymentHistory']['tutor_rate_per_hour'];
		$totalcost = $nettime * $hourlyrate;
		$tutoremail=  $paymentdata['tutor']['email']; 
		$totalcost1 =  sprintf("%.2f", $totalcost );
		$Time =  $formatstarttime." to ".$formatendtime;
		
		$this->set('studentname', $studentname );
		$this->set('tutorname', $tutorname );
		$this->set('tutoremail', $tutoremail );
		$this->set('course', $course );
		$this->set('Time', $Time );
		$this->set('hourlyrate', $hourlyrate );
		$this->set('totalcost1', $totalcost1 );
		
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
		
		
		
									
		$this->Email->send();
		
		
		
		
		/*$template = "<div>
			<p>Dear ($studentname )</p>
			<p>Your have paid session for the tutor </p>
			<p> TutorName: $tutorname</p>
			<p> Email: $tutoremail</p>
			<p> Course: $course</p>
			<p> Time: $Time</p>
			<p> HourlyRate: $". $hourlyrate."</p>
			<p>TotalSessionCost:$". $totalcost1." </p>
		</div>";
			return $template;*/
		
	}
	
	function tutcnf_email_template($paymentid = null){
		
			$paymentdata   = $this->PaymentHistory->find('first', array(
						'conditions' => array(
							'PaymentHistory.id' => $paymentid
						),
						'recursive' => 2
					));
					$payingtutorid = $paymentdata['PaymentHistory']['tutor_id'];
					$tutoremail    = $this->Member->find('first', array(
						'conditions' => array(
							'Member.id' => $payingtutorid
						)
					));
					
		
			$to = $tutoremail['Member']['email'];
					
		//	$email_template = $this->get_email_template('tutor_confirmation');										
		
			$email_template = $this->get_email_template(4);										
			
			$this->Email->to = $to;
			
			$this->Email->replyTo = "notifications@tutorcause.com";
			
			$this->Email->from = "notifications@tutorcause.com";
			
			$this->Email->subject = $email_template['EmailTemplate']['subject'];
										
			$this->Email->sendAs = 'html';
			
			$this->Email->template = 4;
	
					
					
					
	/*				$from          = "tutorcause@gmail.com";
					$subject       = 'Tutor confirmation';
					$message       = $this->tutcnf_email_template($paymentid);
					$headers       = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
					$headers .= 'From:' . $from . "\r\n";
				//	$headers .= 'BCc: promatics.jaswant@gmail.com' . "\r\n";
					
					@mail($to, $subject, $message, $headers);
		*/
		
		
		$paymentdata = $this->PaymentHistory->find('first',array('conditions'=>
																 array('PaymentHistory.id'=> $paymentid),
																 'recursive'=> 2
																 )
												   );
		
		//echo '<pre>';
		
		
		
		
		$studentname = $paymentdata['student']['userMeta']['fname']. " " .$paymentdata['student']['userMeta']['lname'];
		$tutorname = $paymentdata['tutor']['userMeta']['fname']. " " .$paymentdata['tutor']['userMeta']['lname'];
		$starttime =  $paymentdata['PaymentHistory']['booked_start_time'];
		$formatstarttime = date('F d, y @ G:i a',strtotime($starttime));
		$endtime =  $paymentdata['PaymentHistory']['booked_end_time'];
		$formatendtime = date('F d, y @ G:i a',strtotime($endtime));
		$course = $paymentdata['PaymentHistory']['booked_course'];
		$nettime = $paymentdata['PaymentHistory']['tutoring_hours'];
		$hourlyrate = $paymentdata['PaymentHistory']['tutor_rate_per_hour'];
		$totalcost = $nettime * $hourlyrate;
		$studentemail =  $paymentdata['student']['email']; 
		$totalcost1 =  sprintf("%.2f", $totalcost );
		$Time =  $formatstarttime." to ".$formatendtime;
		
		$this->set('tutorname', $tutorname );
		$this->set('studentname', $studentname );
		$this->set('studentemail', $studentemail );
		$this->set('course', $course );
		$this->set('Time', $Time );
		$this->set('hourlyrate', $hourlyrate );
		$this->set('totalcost1', $totalcost1 );
		
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
		
									
		$this->Email->send();		
		
		
/*		$template = "<div>
			<p>Dear ($tutorname)</p>
			<p>Student has paid for session </p>
			<p> StudentName: $studentname</p>
			<p> Email: $studentemail</p>
			<p> Course: $course</p>
			<p> Time: $Time</p>
			<p> HourlyRate: $". $hourlyrate."</p>
			<p>TotalSessionCost:$". $totalcost1." </p>
		</div>";
			return $template;
*/	

}
	
	
	
	function edit_student_school() {
		// student
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$this->data   = $this->getProfilePic();
		$countMsg     = $this->TutMessage->find('count', array(
			'conditions' => array(
				'to_id' => $this->Session->read('Member.memberid'),
				'status' => '0'
			)
		));
		$getBalance   = $this->Member->find('first', array(
			'fields' => array(
				'balance'
			),
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			)
		));
		$this->set('getBalance', $getBalance);
		$this->set('countMsg', $countMsg);
	}
	
	function session_request() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		$this->tutor_element();
		
		$sessionResult = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Booked',
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		$this->set('sessionResult', $sessionResult);
		if (count($this->data)) {
			
			
			if (isset($this->data['Member']['accept'])) {
			
			$amtpaymentid = $this->data['Member']['id'];
			$amtpaymentdata = $this->PaymentHistory->find('first',array('conditions'=>
																 array('PaymentHistory.id'=> $amtpaymentid),
																 'recursive'=> 2
																 )
												   );
			
			$checkamount =  $amtpaymentdata['PaymentHistory']['tutor_rate_per_hour'];
			
			if($checkamount==0)
			{
				$this->PaymentHistory->updateAll(array(
					'PaymentHistory.session_status' => "'Paided'"
				), array(
					'PaymentHistory.id' => $this->data['Member']['id']
				));
				
				$this->Session->setFlash('Accepted Successfully!');
				
			}
			else
			{	
				$this->PaymentHistory->updateAll(array(
					'PaymentHistory.session_status' => "'Accepted'"
				), array(
					'PaymentHistory.id' => $this->data['Member']['id']
				));
				
				$this->Session->setFlash('Accepted Successfully!');
				
			}
				
				
							// To send email	
				
			$paymentid = $this->data['Member']['id'];
			
			$this->tutreq_email_template($paymentid);
			
	
			
			//End To send email

				
				
				
				$this->redirect(array(
					'action' => 'session_request'
				));
			} else {
				$this->PaymentHistory->updateAll(array(
					'PaymentHistory.session_status' => "'Rejected'"
				), array(
					'PaymentHistory.id' => $this->data['Member']['id']
				));
				$this->Session->setFlash('Rejected Successfully!');
				$this->redirect(array(
					'action' => 'session_request'
				));
			}
		}
	}
	
	function tutreq_email_template($paymentid){
		
			$paymentdata = $this->PaymentHistory->find('first',array('conditions'=>
																	 array('PaymentHistory.id'=> $paymentid),
																	 'recursive'=> 2
																	 )
													   );
		
		
		$paymentdata = $this->PaymentHistory->find('first',array('conditions'=>
																 array('PaymentHistory.id'=> $paymentid),
																 'recursive'=> 2
																 )
												   );
			
					
					
			$payingtutorid = $paymentdata['PaymentHistory']['student_id'];
			
			$tutoremail = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $payingtutorid
			)
		));
		
		
		$to	 = $tutoremail['Member']['email'];
		
		/*	$to	 = $tutoremail['Member']['email'];
			$from	= "tutorcause@gmail.com";
			$subject = 'Deposite payment confirmation';
			$message = $this->tutreq_email_template($paymentid);
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from . "\r\n";
			
			mail($to, $subject, $message, $headers);*/
		
		
		//	$email_template = $this->get_email_template('accept_session_request');								
		
			$email_template = $this->get_email_template(3);								
																								
			$this->Email->to = $to;
			
			$this->Email->replyTo = "notifications@tutorcause.com";
			
			$this->Email->from = "notifications@tutorcause.com";
			
			$this->Email->subject = $email_template['EmailTemplate']['subject'];
										
			$this->Email->sendAs = 'html';
			
			$this->Email->template = 3;
			
			$studentname = $paymentdata['student']['userMeta']['fname']. " " .$paymentdata['student']['userMeta']['lname'];
			$tutorname = $paymentdata['tutor']['userMeta']['fname']. " " .$paymentdata['tutor']['userMeta']['lname'];
			$starttime =  $paymentdata['PaymentHistory']['booked_start_time'];
			$formatstarttime = date('F d, y @ G:i a',strtotime($starttime));
			$endtime =  $paymentdata['PaymentHistory']['booked_end_time'];
			$formatendtime = date('F d, y @ G:i a',strtotime($endtime));
			$course = $paymentdata['PaymentHistory']['booked_course'];
			$nettime = $paymentdata['PaymentHistory']['tutoring_hours'];
			$hourlyrate = $paymentdata['PaymentHistory']['tutor_rate_per_hour'];
			$totalcost = $nettime * $hourlyrate;
			$tutoremail =  $paymentdata['tutor']['email']; 
			$totalcost1 = sprintf("%.2f",$totalcost );
			$Time =  $formatstarttime." to ".$formatendtime;
			
			$this->set('studentname', $studentname );
			$this->set('tutorname', $tutorname );
		//	$this->set('starttime', $starttime );
		//	$this->set('formatstarttime', $formatstarttime );
		//	$this->set('endtime', $endtime );
		//	$this->set('formatendtime', $formatendtime );
			$this->set('course', $course );
		//	$this->set('nettime', $nettime );
			$this->set('hourlyrate', $hourlyrate );
		//	$this->set('totalcost', $totalcost );
			$this->set('tutoremail', $tutoremail );
			$this->set('totalcost1', $totalcost1 );
			$this->set('Time', $Time );
			
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
			
			
										
			$this->Email->send();		
		
		
		/*Configure::write('debug', 0);
		$template = "<div>
			<p>Dear ($studentname )</p>
			<p>A tutor has accepted your session request </p>
			<p> TutorName: $tutorname</p>
			<p> Email: $tutoremail</p>
			<p> Course: $course</p>
			<p> Time : $Time</p>
			<p> HourlyRate: $ ". $hourlyrate."</p>
			<p>TotalSessionCost: $ ". $totalcost1." </p>
		</div>";
			return $template;*/
		
	}
	
	
	function get_session_request($type, $userType) {
		return $this->PaymentHistory->find('count', array(
			'conditions' => array(
				'PaymentHistory.' . $userType => $this->Session->read('Member.memberid'),
				'PaymentHistory.session_status' => $type
			)
		));
	}
	function student_awaiting_approval() {
		Configure::write('debug', 0);
		if (isset($this->data)) {
			$this->PaymentHistory->deleteAll(array(
				'PaymentHistory.id' => $this->data['Member']['id']
			));
			$this->Session->setFlash('Session Request cancelled successfully!');
			$this->redirect(array(
				'action' => 'student_awaiting_approval'
			));
		}
		$this->layout = 'frontend';
		$this->student_element();
		
		$approvalAwaiting = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Booked',
				'PaymentHistory.student_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		$this->set('approvalAwaiting', $approvalAwaiting);
		
		
	}
	
	
	function student_awaiting_payment() {
		Configure::write('debug', 0);
		if (isset($this->data)) {
			$this->PaymentHistory->deleteAll(array(
				'PaymentHistory.id' => $this->data['Member']['id']
			));
			$this->Session->setFlash('Session Request cancelled successfully!');
			$this->redirect(array(
				'action' => 'student_awaiting_payment'
			));
		}
		$this->layout = 'frontend';
		
		$this->student_element();
		
		$payemntAwaiting = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Accepted',
				'PaymentHistory.student_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		$this->set('payemntAwaiting', $payemntAwaiting);
		
	}
	
	function student_upcoming_session() {
		Configure::write('debug', 0);
		if (isset($this->data)) {
			$this->PaymentHistory->updateAll(array(
				'PaymentHistory.session_status' => "'Refund'"
			), array(
				'PaymentHistory.id' => $this->data['Member']['id']
			));
			$this->Session->setFlash('Your refund request has been sent to Tutor Cause!');
			$this->redirect(array(
				'action' => 'student_upcoming_session'
			));
		}
		$this->layout = 'frontend';
		
		$this->student_element();
		
		$upcomingSession = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Paided',
				'PaymentHistory.student_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		$this->set('upcomingSession', $upcomingSession);
		
	}
	
	function student_completed_session() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		$this->student_element();
		
		$completed = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Completed',
				'PaymentHistory.student_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		$this->set('completed', $completed);
		//pr($completed);exit;
	}
	function get_school_name() {
		$this->layout = false;
		
		Configure::write('debug', 0);
		
		$school = $this->School->find("list", array(
			'limit' => '10',
			"conditions" => array(
				"School.school_name LIKE" => $_GET['q'] . "%"
			),
			"fields" => "School.school_name,School.school_name",
			"order" => "School.school_name Asc"
		));
		
		$schoolname = array();
		
		if (!empty($school)) {
			foreach ($school as $key => $value) {
				echo "$key|$value\n";
				
			}
			
		} else {
			//echo "No Result Found";
		}
		
		die;
	}
	
	
	
	function get_tutor_name() {
		$this->layout = false;
		
		Configure::write('debug', 0);
		
		$tutor = $this->userMeta->find("all", array(
			'limit' => '10',
			"conditions" => array(
				"userMeta.fname LIKE" => $_GET['q'] . "%",
				'Member.group_id' => 7
			),
			"order" => "userMeta.fname Asc"
		));
		
		
		/*echo '<pre>';
		print_r($tutor);
		die;*/
		
		
		
		
		/*$tutor=$this->userMeta->find("list",array('limit'=>'10',"conditions"=>array("userMeta.fname LIKE"=>$_GET['q']."%"),"fields"=>"userMeta.fname,userMeta.fname","order"=>"userMeta.fname Asc"));*/
		
		
		$tutorname = array();
		
		if (!empty($tutor)) {
			foreach ($tutor as $tu) {
				echo $tu['userMeta']['fname'] . ' ' . $tu['userMeta']['lname'] . "\n";
			}
		} else {
			//echo "No Result Found";
		}
		
		die;
	}
	
	function tutor_causes() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		$this->tutor_element();
		
		$causeResult = $this->CauseTutor->find('all', array(
			'conditions' => array(
				'CauseTutor.status' => '1',
				'tutor_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		//pr($causeResult);exit;
		$this->set('causeResult', $causeResult);
		
	}
	function grant() {
		Configure::write('debug', 0);
		if (is_numeric($this->data['Member']['grant'])) {
			$totalGrant = $this->CauseTutor->find('first', array(
				'fields' => array(
					'SUM(CauseTutor.grant) as totalGrant'
				),
				'conditions' => array(
					'CauseTutor.tutor_id' => $this->Session->read('Member.memberid')
				)
			));
			$total      = ($totalGrant[0]['totalGrant'] + $this->data['Member']['grant']) - $this->data['Member']['default'];
			
			if ((100 - $total) >= 0) {
				$this->CauseTutor->updateAll(array(
					'CauseTutor.grant' => $this->data['Member']['grant']
				), array(
					'CauseTutor.id' => $this->data['Member']['ctId']
				));
				$this->Session->setFlash('Grant Updated!');
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'tutor_causes'
				));
			} else {
				$this->Session->setFlash('Grant Exceeded');
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'tutor_causes'
				));
			}
		} else {
			$this->Session->setFlash('Invalid data');
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'tutor_causes'
			));
		}
	}
	
	
	function update_balance() {
		
		Configure::write('debug', 0);
		$getAmount = $this->PaymentHistory->find('all', array(
	//		'fields' => 'SUM(PaymentHistory.tutor_rate_per_hour*PaymentHistory.tutoring_hours) AS amount',
			'conditions' => array(
				'PaymentHistory.booked_end_time <' => date('Y-m-d H:i:s'),
				'PaymentHistory.session_status' => 'Paided',
			//	'PaymentHistory.paypal_status' => 'complete',
			//	'PaymentHistory.tutor_id' => $memberId
			)
		));
		
		
		if(count($getAmount))
		{
		foreach($getAmount as $ga)
			{
				
				if ($this->PaymentHistory->updateAll(array(
					'PaymentHistory.session_status' => "'Completed'",
					'PaymentHistory.paypal_status' => "'complete'"
				), array(
					'PaymentHistory.id' => $ga['PaymentHistory']['id']
				))) {
					$this->Member->updateAll(array(
						'Member.creditable_balance' => ('Member.creditable_balance+' . $ga['PaymentHistory']['amount']),
						'Member.balance' => ('Member.balance-' . $ga['PaymentHistory']['amount'])
					), array(
						'Member.id' => $ga['PaymentHistory']['tutor_id']
					));
				}
				
			}
		}

	}
	
	function tutor_element() {
		$this->set('picture', $this->getProfilePic());
		
		$this->set('CountRequest', $this->returnBoldCount($this->getCauseRequest()));
		$this->set('SessionRequest', $this->returnBoldCount($this->get_session_request('Booked', 'tutor_id')));
		$this->set('upcomingRequest', $this->returnBoldCount($this->get_session_request('Paided', 'tutor_id')));
		$this->set('paymentAwaiting', $this->returnBoldCount($this->PaymentHistory->find('count', array(
			'conditions' => array(
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid'),
				'PaymentHistory.session_status' => 'Accepted',
				'PaymentHistory.booked_start_time >='=>date('Y-m-d H:i:s')
			)))));
		
		$this->set('completedRequest', $this->returnBoldCount($this->get_session_request('Completed', 'tutor_id')));
		
		$countMsg = $this->TutMessage->find('count', array(
			'conditions' => array(
				'to_id' => $this->Session->read('Member.memberid'),
				'status' => '0'
			)
		));
		
		$getBalance = $this->Member->find('first', array(
			/* 'fields' => array(
				'Member.balance',
				'Member.creditable_balance'
			), */
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			),
			//'recursive' => -1
		));
		
		$withdrawalreq = $this->TutorWithdrawal->find('first', array(
			'conditions' => array(
				'TutorWithdrawal.tutor_id' => $this->Session->read('Member.memberid')
			),
			'order' => array(
				'TutorWithdrawal.id DESC'
			)
		));
		
		if ($withdrawalreq['TutorWithdrawal']['status'] == 'Pending') {
			$pendingrequest = 1;
			
			$this->set('pendingrequest', $this->returnBoldCount($pendingrequest));
		}
		
		$this->set('getBalance', $getBalance);
		$this->set('countMsg', $this->returnBoldCount($countMsg));
		
	}
	
	function student_element() {
		// student dashboard leftside bar 
		
		$this->set('picture', $this->getProfilePic());
		$countMsg   = $this->TutMessage->find('count', array(
			'conditions' => array(
				'to_id' => $this->Session->read('Member.memberid'),
				'status' => '0'
			)
		));
		$getBalance = $this->Member->find('first', array(
			/* 'fields' => array(
				'balance'
			), */
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			)
		));
		
		$this->set('awaitingRequest', $this->returnBoldCount($this->get_session_request('Booked', 'student_id')));
		$this->set('paymentRequest', $this->returnBoldCount($this->get_session_request('Accepted', 'student_id')));
		$this->set('upcomingRequest', $this->returnBoldCount($this->get_session_request('Paided', 'student_id')));
		$this->set('completedRequest', $this->returnBoldCount($this->get_session_request('Completed', 'student_id')));
		
		$this->set('getBalance', $getBalance);
		$this->set('countMsg', $this->returnBoldCount($countMsg));
		
		// end student dashboard leftside bar 
		
		
	}
	
	function cause_element() {
		$this->set('picture', $this->getProfilePic());
		$this->set('CountRequest', $this->returnBoldCount($this->getTutorRequest()));
		
		$countMsg   = $this->TutMessage->find('count', array(
			'conditions' => array(
				'to_id' => $this->Session->read('Member.memberid'),
				'status' => '0'
			)
		));
		$getBalance = $this->Member->find('first', array(
			/* 'fields' => array(
				'creditable_balance'
			), */
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			)
		));
		//echo "<pre>";print_r($getBalance);exit;
		$this->set('getBalance', $getBalance);
		$this->set('countMsg', $this->returnBoldCount($countMsg));
		
		$withdrawalreq = $this->CauseWithdrawal->find('first', array(
			'conditions' => array(
				'CauseWithdrawal.cause_id' => $this->Session->read('Member.memberid')
			),
			'order' => array(
				'CauseWithdrawal.id DESC'
			)
		));
		
		if ($withdrawalreq['CauseWithdrawal']['status'] == 'Pending') {
			$pendingrequest = 1;
			
			$this->set('pendingrequest', $this->returnBoldCount($pendingrequest));
		}
		
	}
	
	function get_statement() {
		Configure::write('debug', 0);
		
		$this->tutor_element();
		
		$getBalance = $this->Member->find('first', array(
			/* 'fields' => array(
				'Member.creditable_balance'
			), */
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			),
			//'recursive' => -1
		));
		//pr($getBalance);exit;
		$amounts = array();
		
		$amounts['creditable']   = $getBalance['Member']['creditable_balance'];
		$amounts['adminAmount']  = $getBalance['Member']['creditable_balance'] / 10;
		$amounts['actualAmonut'] = $getBalance['Member']['creditable_balance'] - $amounts['adminAmount'];
		
		//pr($amounts);exit;
		$this->set('amounts', $amounts);
		
		if (isset($this->data) && $amounts['creditable'] > 0) {
			$totalGrant = $this->CauseTutor->find('all', array(
				/*	'fields'=>array(
				'*',
				'(CauseTutor.grant/100*'.$amounts['actualAmonut'].") as CauseAmount"
				),*/
				'conditions' => array(
					'CauseTutor.tutor_id' => $this->Session->read('Member.memberid'),
					'CauseTutor.status' => 1,
					'CauseTutor.grant !=' => 0
				),
				//	'group'=>'CauseTutor.cause_id',
				'recursive' => -1
			));
			
			
			$withdrawal                                               = array();
			$withdrawal['TutorWithdrawal']['request_id']              = uniqid();
			$withdrawal['TutorWithdrawal']['tutor_id']                = $this->Session->read('Member.memberid');
			$withdrawal['TutorWithdrawal']['tutor_creditable_amount'] = $amounts['creditable'];
			$withdrawal['TutorWithdrawal']['tutor_payable_amount']    = $this->data['Member']['tutorAmount'];
			$withdrawal['TutorWithdrawal']['status']                  = 'Pending';
			
			
			if ($this->data['Member']['tutorAmount'] > 0) {
				$this->TutorWithdrawal->create();
				$this->TutorWithdrawal->save($withdrawal);
				$withdrawalid = $this->TutorWithdrawal->id;
				
			}
			
			
			
			
			/*		
			$withdrawalId = $this->TutorWithdrawal->getLastInsertID();
			$withdrawal['TutorToCause']['withdrawal_id'] = $withdrawalId;
			$withdrawal['TutorToCause']['tutor_id']=$withdrawal['TutorWithdrawal']['tutor_id'];
			$this->TutorToCause->create();
			$this->TutorToCause->save($withdrawal);*/
			
			
			
			foreach ($totalGrant as $grantTotal) {
				$causegrant['TutorToCause']['withdrawal_id'] = $withdrawalid;
				$causegrant['TutorToCause']['tutor_id']      = $this->Session->read('Member.memberid');
				$causegrant['TutorToCause']['cause_id']      = $grantTotal['CauseTutor']['cause_id'];
				$causegrant['TutorToCause']['cause_grant']   = $grantTotal['CauseTutor']['grant'];
				
				$causeAmount = ($grantTotal['CauseTutor']['grant'] / 100) * $amounts['actualAmonut'];
				
				$causegrant['TutorToCause']['cause_amount'] = $causeAmount;
				
				
				
				
				
				$this->TutorToCause->create();
				$this->TutorToCause->save($causegrant);
			}
			
			
			$this->Member->updateAll(array(
				'Member.creditable_balance' => 0
			), array(
				'Member.id' => $this->Session->read('Member.memberid')
			));
			
			
			$this->Session->setFlash("We have received your withdrawal request and will process it within 3 business days.");
			
			$this->redirect(array(
				'action' => 'tutor_dashboard'
			));
		}
		
		$this->tutor_element();
		$totalGrant = $this->CauseTutor->find('all', array(
			/*	'fields'=>array(
			'*',
			'(CauseTutor.grant/100*'.$amounts['actualAmonut'].") as CauseAmount"
			),*/
			'conditions' => array(
				'CauseTutor.tutor_id' => $this->Session->read('Member.memberid'),
				'CauseTutor.status' => 1,
				'CauseTutor.grant !=' => 0
			),
			//	'group'=>'CauseTutor.cause_id',
			'recursive' => 2
		));
		
		
		
		$this->set('charityInfo', $totalGrant);
	}
	
	function tutor_withdrawal() {
		Configure::write('debug', 0);
		$this->tutor_element();
		$withdrawalDetail = $this->TutorWithdrawal->find('all', array(
			'conditions' => array(
				'TutorWithdrawal.tutor_id' => $this->Session->read('Member.memberid')
			),
			'group' => array(
				'TutorWithdrawal.request_id'
			)
			// 'group'=>array(
			// 'TutorWithdrawal.request_id'
			// )
		));
		$this->set('withdrawalDetail', $withdrawalDetail);
		//pr($withdrawalDetail);exit;
		
	}
	function tutor_withdrawal_details() {
		$this->layout      = '';
		$requestId         = $_REQUEST['requestId'];
		$withdrawal        = $this->TutorWithdrawal->find('first', array(
			'conditions' => array(
				'TutorWithdrawal.id' => $requestId
			)
		));
		$withdrawalCharity = $this->TutorToCause->find('all', array(
			'conditions' => array(
				'TutorToCause.withdrawal_id' => $requestId
			)
		));
		//echo"<pre>";print_r($withdrawalCharity);exit;
		//echo"<pre>";print_r($withdrawal['TutorToCause']);exit;
		
		/* $withdrawalDetail = $this->TutorWithdrawal->find('all',
		array(
		'conditions'=>array(
		'TutorWithdrawal.request_id'=>$requestId
		),
		'recursive'=>2
		)
		); */
		$this->set('withdrawalDetail', $withdrawal);
		$this->set('withdrawalCharity', $withdrawalCharity);
		//echo"<pre>";print_r($withdrawalDetail);exit;
	}
	
	function testing() {
		Configure::write('debug', 0);
		
		
	}
	
	function testingamount() {
		Configure::write('debug', 0);
	}
	function image() {
		Configure::write('debug', 0);
	}
	function add_fund($step = NULL) {
		Configure::write('debug', 0);
		if (isset($step) && !empty($step)) {
			if ($step == "step1") {
				$studentReg   = $this->Session->read('Member.memberid');
				$studentGroup = $this->Session->read('Member.group_id');
				if (isset($studentReg) && $studentGroup == 8) {
					$this->Session->write('payment.fundId', $this->Session->read('Member.memberid'));
					$studentEmail = $this->Member->find('first',array(
						'conditions'=>array(
							'Member.id' =>$this->Session->read('Member.memberid')
						),
						'recursive'=>-1
					));
					$this->Session->write('payment.student_email',$studentEmail['Member']['email']);
					$this->redirect(array(
						'action' => 'add_fund/step2'
					));
				}
				$this->set('step', 'step1');
				if (isset($this->data)) {
					if (!empty($this->data['Member']['studentEmail'])) {
						/* $studentExist = $this->Member->find('first', array(
							'fields' => array(
								'Member.id',
								'userMeta.fname',
								'userMeta.lname'
							),
							'conditions' => array(
								'Member.email' => $this->data['Member']['studentEmail'],
								'Member.group_id' => 8
							)
						)); */
						/* if (!empty($studentExist)) {
							$this->Session->write('payment.fundId', $studentExist['Member']['id']);
							$this->Session->write('payment.fname', $studentExist['userMeta']['fname']);
							$this->Session->write('payment.lname', $studentExist['userMeta']['lname']);
							$this->redirect(array(
								'action' => 'addFund/step2'
							));
						} else {
							$this->Session->setFlash('Student not found!');
							$this->redirect(array(
								'action' => 'add_fund/step1'
							));
						} */
						$this->Session->write('payment.fundId',"true");
						$this->Session->write('payment.student_email',$this->data['Member']['studentEmail']);
						$this->redirect(array(
							'action' => 'add_fund/step2'
						));
					} else {
						$this->Session->setFlash('Please enter student Email ID');
						$this->redirect(array(
							'action' => 'add_fund/step1'
						));
					}
				}
			} 
			/* else if ($step == "step2") {
				$studentReg   = $this->Session->read('Member.memberid');
				$studentGroup = $this->Session->read('Member.group_id');
				if (isset($studentReg) && $studentGroup == 8) {
					$this->redirect(array(
						'action' => 'add_fund/step1'
					));
				}
				$sessionInfo = $this->Session->read('payment.fundId');
				if (isset($sessionInfo) && !empty($sessionInfo)) {
					if (isset($this->data)) {
						$this->redirect(array(
							'action' => 'add_fund/step3'
						));
					}
					$this->set('step', 'step2');
					$studentInfo = $this->Member->find('first', array(
						'conditions' => array(
							'Member.id' => $sessionInfo
						)
					));
					$this->set('studentInfo', $studentInfo);
				} else {
					$this->redirect(array(
						'action' => 'add_fund/step1'
					));
				}
				
			} */
			else if ($step == "step2") {
				$sessionInfo = $this->Session->read('payment.fundId');
				if (!isset($sessionInfo)) {
					$this->redirect(array(
						'action' => 'add_fund/step1'
					));
				}
				$this->set('step', 'step2');
				if (isset($this->data)) {
					if (!empty($this->data['Member']['amount']) && is_numeric($this->data['Member']['amount'])) {
						$addfund                               = array();
						$addfund['AddFund']['student_email']      = $this->Session->read('payment.student_email');
						$addfund['AddFund']['request_id']      = uniqid();
						$addfund['AddFund']['amount']          = $this->data['Member']['amount'];
						$addfund['AddFund']['payment_status']  = 'pending';
						$addfund['AddFund']['approval_status'] = 'Pending';
						$this->AddFund->create();
						$this->AddFund->save($addfund);
						$this->Session->write('payment.amount', $this->data['Member']['amount']);
						$this->Session->write('payment.paymentId', $this->AddFund->getLastInsertId());
						$this->redirect(array(
							'action' => 'add_fund/step3'
						));
					} else {
						$this->Session->setFlash('Invalid Amount');
						$this->redirect(array(
							'action' => 'add_fund/step2'
						));
					}
				}
			} else if ($step == "step3") {
				$sessionInfo   = $this->Session->read('payment.fundId');
				$sessionAmount = $this->Session->read('payment.amount');
				if (!isset($sessionInfo) || !isset($sessionAmount)) {
					$this->redirect(array(
						'action' => 'add_fund/step1'
					));
				}
				$this->set('step', 'step3');
			} else {
				$this->redirect(array(
					'action' => 'add_fund/step1'
				));
			}
		} else {
			$studentReg   = $this->Session->read('Member.memberid');
			$studentGroup = $this->Session->read('Member.group_id');
			if (isset($studentReg) && $studentGroup == 8) {
				$this->Session->write('payment.fundId',"true");
				$studentEmail = $this->Member->find('first',array(
						'conditions'=>array(
							'Member.id' =>$this->Session->read('Member.memberid')
						),
						'recursive'=>-1
					));
				$this->Session->write('payment.student_email',$studentEmail['Member']['email']);
				$this->redirect(array(
					'action' => 'add_fund/step2'
				));
			}
			$this->set('step', 'step1');
		}
		
	}
	
	function fund_add($id = null) {
		
$email = "promatics.jaswant@gmail.com";
		
		$header = "";
		
		$emailtext = "";		
		// PHP 4.1

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ( FSOCKET , 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
	
	
		foreach ($_POST as $key => $value) {
						$emailtext .= $key . " = " . $value . "\n\n";
					}
		mail($email, "verified", $emailtext . "\n\n" . $req);
	
	
						if ($_POST['payment_status'] == 'Completed') {
							$existTxn = $this->AddFund->find('count', array(
								'conditions' => array(
									'AddFund.paypal_confirm_id' => $_POST['txn_id']
								),
								'recursive' => -1
							));
							if ($existTxn == 0) {
							
								
								//Update Table
								$confirmId  = "'" . $_POST['txn_id'] . "'";
								$amount	 = "'" . $_POST['mc_gross'] . "'";
								$name	   = "'" . $_POST['first_name'] . " " . $_POST['last_name'] . "'";
								$email	  = "'" . $_POST['payer_email'] . "'";
								$address	= "'" . $_POST['address_street'] . "'";
								$city	   = "'" . $_POST['address_city'] . "'";
								$state	  = "'" . $_POST['address_state'] . "'";
								$country	= "'" . $_POST['address_country'] . "'";
								$zip		= "'" . $_POST['address_zip'] . "'";
								$status	 = "'complete'";
								$varifyText =md5(uniqid());
								
								//End
								$this->AddFund->updateAll(array(
									'AddFund.paypal_confirm_id' => $confirmId,
									'AddFund.amount' => $amount,
									'AddFund.name' => $name,
									'AddFund.email' => $email,
									'AddFund.address' => $address,
									'AddFund.city' => $city,
									'AddFund.state' => $state,
									'AddFund.country' => $country,
									'AddFund.zip' => $zip,
									'AddFund.payment_status' => $status,
									'AddFund.varify_text' => "'".$varifyText."'"
								), array(
									'AddFund.id' => $id
								));
								
								// email to student to claim money
								
								$this->verify_email_template($id,$_POST['first_name']. " " .$_POST['last_name'],$_POST['mc_gross'],$varifyText);
								
								// end email to student to claim money
								
							
							}
						} else if ($_POST['payment_status'] == 'Cancelled') {
							$this->payData['AddFund']['payment_status']    = 'unable to process';
							$this->payData['AddFund']['email']             = '"' . $_POST['payer_email'] . '"';
							$this->payData['AddFund']['paypal_confirm_id'] = '"' . $_POST['txn_id'] . '"';
							$this->AddFund->save($this->payData);
						}
						foreach ($_POST as $key => $value) {
							$emailtext .= $key . " = " . $value . "\n\n";
						}
					}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
foreach ($_POST as $key => $value) {
						$emailtext .= $key . " = " . $value . "\n\n";
					}
mail($email, "Live-INVALID IPN", $emailtext . "\n\n" . $req);



}
}
fclose ($fp);
}
		
	}
	
	function verify_email_template($id,$parentname,$amount,$verifyCode){
		
		$studentInfo = $this->AddFund->find(
								'first',
								array(
									'conditions'=>array(
										'AddFund.id' => $id
									)
								)
							);
		
		$to	  = $studentInfo['AddFund']['student_email'];
		
		$email_template = $this->get_email_template(5);										
																									
		$this->Email->to = $to;
		
		$this->Email->replyTo = "notifications@tutorcause.com";
		
		$this->Email->from = "notifications@tutorcause.com";
		
		$this->Email->subject = $email_template['EmailTemplate']['subject'];
									
		$this->Email->sendAs = 'html';
		
		$this->Email->template = '5';
		
		$this->set('amount', $amount );
		$this->set('parentname', $parentname );
		$this->set('verifyCode', $verifyCode );
		$this->set('HTTP_ROOT', HTTP_ROOT );
		
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
		
		
									
		$this->Email->send();
		
		
	/*	$to	  = $studentInfo['AddFund']['student_email'];
		$from	= "tutorcause@gmail.com";
		$subject = 'Money Received confirmation';
		$message = $this->verify_email_template($_POST['first_name']. " " .$_POST['last_name'],$_POST['mc_gross'],$varifyText);
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= 'From:'.$from . "\r\n";
		//	$headers .= 'BCc: promatics.jaswant@gmail.com' . "\r\n";
		mail($to, $subject, $message, $headers);
		*/
		
		/*Configure::write('debug', 0);
		$template = "<div>
			<p>Dear student</p>
			<p>You have recieved ".$amount. " from ".$parentname."</p>
			<p>Click below to activate your money.</p>
			<p><a href='".HTTP_ROOT."members/approve_fund/".$verifyCode."'>".HTTP_ROOT."members/approve_fund/".$verifyCode."</a></p>
			<p><b>Note:</b> Please make sure you are logged in before click on varify URL.</p>
		</div>";
		return $template;*/
		
		
	}
	
	
	
	
	function tutor_upcoming_session() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$this->tutor_element();
		$upcomingSession = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Paided',
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		$this->set('upcomingSession', $upcomingSession);
		//pr($upcomingSession);exit;
		
	}
	function causeget_statement() {
		Configure::write('debug', 0);
		
		$this->Cause_element();
		
		
		
		$alltutor = $this->TutorToCause->find('all', array(
			'conditions' => array(
				'TutorToCause.cause_id' => $this->Session->read('Member.memberid'),
				'TutorWithdrawal.status' => 'Approved'
			),
			'recursive' => 2
			
		));
		
		$this->set('alltutor', $alltutor);
		
		/*echo 'hi';
		echo '<pre>';
		print_r($alltutor);
		die;*/
		
		
		
		
		
		
		
	}
	
	function tutor_completed_session() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$this->tutor_element();
		$completed = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Completed',
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		$this->set('completed', $completed);
	}
	
	function paying_option($paymentid) {
		Configure::write('debug', 0);
		if (isset($this->data)) {
			$method  = $this->data['Member']['method'];
			$price   = $this->data['Member']['credit'];
			$balance = $this->data['Member']['creditable_balance'];
			if ($method == "credit") {
				if ($balance >= $price) {
					$this->Session->write('payment.method', 'credit');
					$this->redirect(array(
						'action' => 'paying_session/' . $paymentid
					));
				}
			} else if ($method == "paypal") {
				$this->Session->write('payment.method', 'paypal');
				$this->redirect(array(
					'action' => 'paying_session/' . $paymentid
				));
			}
		}
		$this->set('paymentid', $paymentid);
		$memberInfo = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			),
			'recursive' => -1
		));
		$paydata    = $this->PaymentHistory->find('first', array(
			'conditions' => array(
				'PaymentHistory.id' => $paymentid
			)
			
		));
		$this->set('memberInfo', $memberInfo);
		$this->set('paydata', $paydata);
		
		/*echo"<pre>";
		print_r($paydata);
		die;*/
	}
	
	function admin_mc() {
		$lists = $this->MailchimpApi->lists();
		
		echo '<pre>';
		print_r($lists);
		die;
		
		$this->set('lists', $lists);
	}
	
	
	function admin_mclist_view($id) {
		$lists = $this->MailchimpApi->listMembers($id);
		
		echo '<pre>';
		print_r($lists);
		die;
		
		$this->set('id', $id);
		$this->set('lists', $lists);
	}
	
	function admin_mc_remove($user_email, $id) {
		$remove = $this->MailchimpApi->remove($user_email, $id);
		if ($remove) {
			$this->Session->setFlash('Email successfully removed from your list.');
		} else {
			$this->Session->setFlash('Oops, something went wrong.  Email was not removed from the list.');
		}
		//  $this->redirect(array('action'=>'mclist_view', 'id'=> $id));
	}
	
	
	function admin_mc_add($id) {
		if (!empty($this->data)) {
			$first = $this->data['first'];
			$last  = $this->data['last'];
			$email = $this->data['email'];
			$id    = $this->data['id'];
			
			/*	echo '<pre>';
			print_r($this->data);
			die;*/
			
			$add = $this->MailchimpApi->addMembers($id, $email, $first, $last);
			
			if ($add) {
				$this->Session->setFlash('Successfully added user to your list.  They will not be reflected in your list until the user confirms their subscription.');
			} else {
				$this->Session->setFlash('Oops, something went wrong.  Email was not added to your user.');
			}
			//   $this->redirect(array('action'=>'memberview', 'id'=> $id));
		}
		
		
		else {
			$this->set('id', $id);
		}
	}
	
	function admin_mailchimpview() {
		$this->layout = 'admin';
		
		$this->set("mailClass", "selected"); //set main navigation class
		
		
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
			$this->render('mailchimpmembers');
		}
		
		
	}
	
	
	function admin_subscribe($id) {
		$this->layout = 'admin';
		
		$this->set("mailClass", "selected"); //set main navigation class
		
		$lists = $this->MailchimpApi->lists();
		
		$memberdata = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $id
			)
		));
		
		/*		echo '<pre>';
		print_r($lists);
		print_r($memberdata);
		
		die;
		*/
		
		$this->set('memberdata', $memberdata);
		
		$this->set('lists', $lists);
		
		
		if (!empty($this->data)) {
			$first = $this->data['first'];
			$last  = $this->data['last'];
			$email = $this->data['email'];
			$id    = $this->data['id'];
			
			$add = $this->MailchimpApi->addMembers($id, $email, $first, $last);
			
			if ($add) {
				$this->Session->setFlash('Successfully added user to your list.  They will not be reflected in your list until the user confirms their subscription.');
			} else {
				$this->Session->setFlash('Oops, something went wrong.  Email was not added to your user.');
			}
			$this->redirect(array(
				'action' => 'mailchimpview',
				'admin' => true
			));
		}
		
		
		
	}
	
	
	function causewithdrawal() {
		Configure::write('debug', 0);
		
		$getBalance = $this->Member->find('first', array(
			'fields' => array(
				'Member.creditable_balance'
			),
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			),
			'recursive' => -1
		));
		
		$amounts = array();
		
		$amounts['creditable'] = $getBalance['Member']['creditable_balance'];
		if ($amounts['creditable'] > 0) {
			$withdrawal                                               = array();
			$withdrawal['CauseWithdrawal']['request_id']              = uniqid();
			$withdrawal['CauseWithdrawal']['cause_id']                = $this->Session->read('Member.memberid');
			$withdrawal['CauseWithdrawal']['cause_creditable_amount'] = $amounts['creditable'];
			$withdrawal['CauseWithdrawal']['status']                  = 'Pending';
			
			$this->CauseWithdrawal->create();
			$this->CauseWithdrawal->save($withdrawal);
			
			$this->Member->updateAll(
				array(
				'Member.creditable_balance' => 0
				),
				array(
				'Member.id'=>$this->Session->read('Member.memberid')
				)
			);
			$this->Session->setFlash('Your Withdrawal Request has been sent to admin.');
			
			$this->redirect(array(
				'action' => 'cause_dashboard'
			));
		} else {
			$this->Session->setFlash('Insufficient balance for withdrawal');
			
			$this->redirect(array(
				'action' => 'cause_dashboard'
			));
			
		}
		
	}
	
	

	
	function check_student_email(){
		$studentEmail = $_REQUEST['data']['Member']['studentEmail'];
		$studentExist = $this->Member->find('count', array(
							'conditions' => array(
								'Member.email' => $studentEmail,
								'Member.group_id' => 8
							)
						));
		if($studentExist == 1){
			echo "true";
		} else {
			echo "false";
		}
		exit;
		
	}
//Approve Fund 
	function approve_fund($approvalId=null){
		Configure::write('debug', 0);

		$this->layout='frontend';
		$studentId = $this->Session->read('Member.memberid');
		if(isset($studentId) && !empty($studentId)){
			if(isset($approvalId) && !empty($approvalId)){
				$fundInfo = $this->AddFund->find(
					'first',
					array(
						'conditions' => array(
							'AddFund.varify_text'=>$approvalId,
						)
					)
				);
				if(isset($fundInfo['AddFund']['id'])){
					if($fundInfo['AddFund']['approval_status'] == 'Pending'){
						if($this->AddFund->updateAll(
							array(
								'AddFund.approval_status' => "'Verified'",
								'AddFund.student_id'	=> $this->Session->read('Member.memberid')
							),
							array(
								'AddFund.id'=>$fundInfo['AddFund']['id']
							)
						)){
							$this->Member->updateAll(
								array(
									'Member.creditable_balance' => 'Member.creditable_balance+'.$fundInfo['AddFund']['amount']
								),
								array(
									'Member.id'=>$this->Session->read('Member.memberid')
								)
							);
							$this->set('status','success');
						} else {
							$this->set('status','errorinquery');
						}
					} else {
						$this->set('status','alreadyVerified');
					}
				} else {
					$this->set('status','wrongcode');
				}
			} else {
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'index'
				));
			}
		} else {
			$this->set('status','login');

		}
	}
	
	    function facebookmutual($target=NULL)
	{
	
	Configure::write('debug', 0);
	
	
	
	App::import('Vendor', 'facebook', array(
	'file' => 'facebook/facebook.php'
	));
	
	$facebook1 = new Facebook(array(
	'appId'  => APPID ,
	'secret' => SECRET ,
	));
	
	$accesstoken = $facebook1->getAccessToken();
	
	if($accesstoken == '')
	{
	
	$this->redirect(array(
	'controller' => 'members',
	'action' => 'logout'
	));
	
	}
	
	
	$source = $this->Session->read('Member.id');
	
	$url = "https://api.facebook.com/method/friends.getMutualFriends?target_uid=$target&source_uid=$source&access_token=$accesstoken";
	
	$xml = simplexml_load_file($url);
	$myarray=get_object_vars($xml->children());
	$mutualid = $myarray['uid'];
	
	
	
	
	
	
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
	
	
	if(count($mutualid))
	{
	$mutualfriend = $this->Member->find('all',array('conditions'=>array(
														'Member.facebookId'=> $mutualid
														),
									'recursive'=> -1
									)
						);
	}
	
	foreach($mutualfriend  as $mf)
	{
	
	$mutualfid[] = $mf['Member']['id'];
	}
	
	
	
	
	
	if(count($mutualfid) && count($matchtutor) )
	{
	$mutualalltutor = array_intersect($mutualfid, $matchtutor);
	}
	
	
	/*echo '<pre>';
	echo APPID;
	echo SECRET;
    echo 'me'.$source.'<br>';
	echo 'target'.$target.'<br>';
	echo $accesstoken.'<br>';
	echo $url.'<br>';


	echo 'mutualid'.'<br>';
	print_r($mutualid);
	echo 'matchtutor'.'<br>';
	print_r($matchtutor);
	echo 'mutualfriends'.'<br>';
	print_r($mutualfriend);
	
	echo 'mutualfid';

	print_r($mutualfid);
	
	echo 'mutualalltutor';
	print_r($mutualalltutor);
	die;*/


	
	if(count($mutualalltutor) == 0 )
	{
	
	if($target)
	{
	
	$targetname = $this->Member->find('first',array('conditions'=>array('Member.facebookId'=> $target),
	'recursive'=> 0));
	
	$mutualname = $targetname['userMeta']['fname'].' '.$targetname['userMeta']['lname'];
	
	
	$msg = "There are no mutual tutor between you and $mutualname";
	
	/*
	echo '<pre>';
	print_r($targetname);
	
	
	echo $mutualname;
	
	echo $msg;
	
	die;
	*/
	
	$this->Session->setFlash($msg);
			$this->redirect(array(
			'controller' => 'members',
			'action' => 'tutorsearch'
			));
	
	}
	
	}
	
	
	if(!$this->RequestHandler->isAjax() && !isset($this->data) ) {
	
	//	$this->Session->delete('tutorsearch');
	$this->paginate['Member'] = array(
	'conditions' => array(
	'Member.id' => $mutualalltutor
	),
	'order'=>array(
	'Member.created DESC'
	),
	'limit' => 5
	);
	
	$filtertutor1 = $this->paginate('Member');
	
	$this->set('filtertutor1',$filtertutor1);
	
	
	}
	
	
	
	
}

function error()
{
	
	
}

	function tutor_awaiting_payment(){
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$this->tutor_element();
		$upcomingSession = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Accepted',
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid'),
				'PaymentHistory.booked_start_time >=' => date('Y-m-d H:i:s')
			),
			'recursive' => 2
		));
		$this->set('upcomingSession', $upcomingSession);
	}
	
	function returnBoldCount($count){
		if(!empty($count) && $count !==0){
			return " <b>(".$count.") </b>";
		}
	}
	
	function validZipForState(){
		$this->autoRender = false;
		$zipCode =  $_REQUEST['data']['userMeta']['zip'];
		$statesName= $this->State->find(
			'first',
			array(
				'conditions'=>array(
					'State.state_name' => $_REQUEST['state']
				)
			)
		);
		$state = $statesName['State']['state_code'];
		$allstates = array (
			"AK" => array ("9950099929"),
			"AL" => array ("3500036999"),
			"AR" => array ("7160072999", "7550275505"),
			"AZ" => array ("8500086599"),
			"CA" => array ("9000096199"),
			"CO" => array ("8000081699"),
			"CT" => array ("0600006999"),
			"DC" => array ("2000020099", "2020020599"),
			"DE" => array ("1970019999"),
			"FL" => array ("3200033999", "3410034999"),
			"GA" => array ("3000031999"),
			"HI" => array ("9670096798", "9680096899"),
			"IA" => array ("5000052999"),
			"ID" => array ("8320083899"),
			"IL" => array ("6000062999"),
			"IN" => array ("4600047999"),
			"KS" => array ("6600067999"),
			"KY" => array ("4000042799", "4527545275"),
			"LA" => array ("7000071499", "7174971749"),
			"MA" => array ("0100002799"),
			"MD" => array ("2033120331", "2060021999"),
			"ME" => array ("0380103801", "0380403804", "0390004999"),
			"MI" => array ("4800049999"),
			"MN" => array ("5500056799"),
			"MO" => array ("6300065899"),
			"MS" => array ("3860039799"),
			"MT" => array ("5900059999"),
			"NC" => array ("2700028999"),
			"ND" => array ("5800058899"),
			"NE" => array ("6800069399"),
			"NH" => array ("0300003803", "0380903899"),
			"NJ" => array ("0700008999"),
			"NM" => array ("8700088499"),
			"NV" => array ("8900089899"),
			"NY" => array ("0040000599", "0639006390", "0900014999"),
			"OH" => array ("4300045999"),
			"OK" => array ("7300073199", "7340074999"),
			"OR" => array ("9700097999"),
			"PA" => array ("1500019699"),
			"RI" => array ("0280002999", "0637906379"),
			"SC" => array ("2900029999"),
			"SD" => array ("5700057799"),
			"TN" => array ("3700038599", "7239572395"),
			"TX" => array ("7330073399", "7394973949", "7500079999", "8850188599"),
			"UT" => array ("8400084799"),
			"VA" => array ("2010520199", "2030120301", "2037020370", "2200024699"),
			"VT" => array ("0500005999"),
			"WA" => array ("9800099499"),
			"WI" => array ("4993649936", "5300054999"),
			"WV" => array ("2470026899"),
			"WY" => array ("8200083199")
		);

		if (isset($allstates[$state])) {
			foreach($allstates[$state] as $ziprange) {
				if (($zipCode >= substr($ziprange, 0, 5)) && ($zipCode <= substr($ziprange,5))) {
					$valid = "true";
					return $valid;
					exit;
				}
			}
		}
		$valid = "false"; 
		return $valid;
		exit;
	}
	
	function sendEmailAlert($to,$toName,$fromName,$subject,$message){
		$from = "xyz@xyz.com";
		$subject = "Tutor Cause ".$subject;
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= 'From:'.$from . "\r\n";
		$headers .= 'BCc: promatics.ajayendra@gmail.com' . "\r\n";
		$template = "<div>
			<p>Dear ".$toName."</p>
			<p>You have recieved a message from ".$fromName."</p>
			<p><b>Subject:</b>".$subject."</p>
			<p><b>Message:</b> ".$message."</p>
		</div>";
		echo $template;exit;
		@mail($to, $subject, $template, $headers);
	}
	
	function cause_search()
	{
		
		Configure::write('debug', 0);
	

		if(!$this->RequestHandler->isAjax() && !isset($this->data) ) {
			
			$this->Session->delete('causesearch');
			
			$this->paginate['Member'] = array(
			'conditions' => array(
				'Member.group_id' => '6'
			),
			'order'=>array(
				'Member.created DESC'
				),
			'limit' => 5
			);
			
			$defaultcause = $this->paginate('Member');
			
		}
		
		
		if (isset($this->data)) {
			$this->Session->write('causesearch.schoolid', $this->data['CauseSchool']['school_id']);
			
		} else {
			
			
		}
		
		
		$schoolid  = $this->Session->read('causesearch.schoolid');
				
		if ($schoolid) {
			
			$this->paginate['CauseSchool'] = array(
				'conditions' => array(
					'CauseSchool.school_id' => $schoolid,
				),
				'recursive' => 2,
				'limit' => 5
			);
			
			$filterbyschool = $this->paginate('CauseSchool');
			
		} 
		
		
		
		if(isset($defaultcause) && count($defaultcause))
		{
			
			$this->set('defaultcause',$defaultcause);
			
			
			if ($this->RequestHandler->isAjax()) {
				$this->layout = '';
				Configure::write('debug', 0);
				$this->AutoRender = false;
				$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
				$this->render('defaultcausesearch');
			}
			
		}
		else if(isset($filterbyschool) && count($filterbyschool))
		{
			
			$this->set('filterbyschool',$filterbyschool);
			
			if ($this->RequestHandler->isAjax()) {
				$this->layout = '';
				Configure::write('debug', 0);
				$this->AutoRender = false;
				$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
				$this->render('filtercauseschool');
			}
			
		}
		
		
		
	}
	
	
	function paypal_tutor($withdrawalid = NULL )
	{
		
$email = "promatics.jaswant@gmail.com";
		
		$header = "";
		
		$emailtext = "";		
		// PHP 4.1

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ( FSOCKET , 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
// check the payment_status is Completed
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct
// process payment
    
		foreach ($_POST as $key => $value) {
						$emailtext .= $key . " = " . $value . "\n\n";
					}
		mail($email, "verified", $emailtext . "\n\n" . $req);
					 

	if ($_POST['payment_status'] == 'Completed') {
			$existTxn = $this->TutorWithdrawal->find('count', array(
			'conditions' => array(
			'TutorWithdrawal.paypal_confirm_id' => $_POST['txn_id']
			),
			'recursive' => -1
			));
		
		
				if ($existTxn == 0) {
				$taxid         = $_POST['txn_id'];
				$email         = $_POST['payer_email'];
				$status        = 'complete';
				$amount        = $_POST['mc_gross'];
				$sessionstatus = 'Approved';
				$approvaldate = date("Y-m-d H:i:s", time());
				$paypal_date = $_POST['payment_date'];
				
				$this->TutorWithdrawal->updateAll(array(
				'TutorWithdrawal.paypal_amount' => "'" . $amount . "'",
				'TutorWithdrawal.paypal_status' => "'" . $status . "'",
				'TutorWithdrawal.paypal_email' => "'" . $email . "'",
				'TutorWithdrawal.paypal_confirm_id' => "'" . $taxid . "'",
				'TutorWithdrawal.status' => "'" . $sessionstatus . "'",
				'TutorWithdrawal.approval_date' => "'" . $approvaldate . "'",
				'TutorWithdrawal.paypal_date' => "'" . $paypal_date . "'",
					), array(
					'TutorWithdrawal.id' => $withdrawalid
					) 
				);
				
				
				$causedata = $this->TutorToCause->find('all', array(
				'conditions' => array(
				'TutorToCause.withdrawal_id' => $withdrawalid
				),
				'recursive' => 1
				));
				
					foreach ($causedata as $cd) {
					$causeCredit = 0;
					
					$getBalance = $this->Member->find('first', array(
					'fields' => array(
					'creditable_balance'
					),
					'conditions' => array(
					'Member.id' => $cd['TutorToCause']['cause_id']
					),
					'recursive' => -1
					));
					
					$causeCredit = $getBalance['Member']['creditable_balance'] + $cd['TutorToCause']['cause_amount'];
					
					$this->Member->updateAll(array(
					'Member.creditable_balance' => $causeCredit
					), array(
					'Member.id' => $cd['TutorToCause']['cause_id']
					));
					
					}
				
				
				/***		Sending Mail		***/
				
				
				
				
				/***		End Sending Mail		**/
				
				}
		
		
		
		}
	else if ($_POST['payment_status'] == 'Pending') {
		
	if($_POST['pending_reason'] == 'unilateral')
		{
		$this->payData['TutorWithdrawal']['id']     = $withdrawalid;
		$this->payData['TutorWithdrawal']['paypal_status']     = 'Tutor email not registered';
		$this->payData['TutorWithdrawal']['paypal_pending_reason']= 'Tutor email not registered';
		$this->payData['TutorWithdrawal']['paypal_email']      = '"' . $_POST['payer_email'] . '"';
		$this->payData['TutorWithdrawal']['paypal_confirm_id'] = '"' . $_POST['txn_id'] . '"';
		$this->payData['TutorWithdrawal']['paypal_date'] = '"' . $_POST['payment_date'] . '"';
		$this->TutorWithdrawal->save($this->payData);
		}
	
	}

		
	else if ($_POST['payment_status'] == 'Cancelled') {
		$this->payData['TutorWithdrawal']['id']     = $withdrawalid;
		$this->payData['TutorWithdrawal']['paypal_status']     = 'unable to process';
		$this->payData['TutorWithdrawal']['paypal_pending_reason']= 'unable to process';
		$this->payData['TutorWithdrawal']['paypal_email']      = '"' . $_POST['payer_email'] . '"';
		$this->payData['TutorWithdrawal']['paypal_confirm_id'] = '"' . $_POST['txn_id'] . '"';
		$this->payData['TutorWithdrawal']['paypal_date'] = '"' . $_POST['payment_date'] . '"';
		$this->TutorWithdrawal->save($this->payData);
		}





}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
foreach ($_POST as $key => $value) {
						$emailtext .= $key . " = " . $value . "\n\n";
					}
mail($email, "Live-INVALID IPN", $emailtext . "\n\n" . $req);



}
}
fclose ($fp);
}
		
		
	
	}
	
	function php_info()
	{
		
		phpinfo();
		
		die;
		
	}
	
		function parallel_paypal()
	{
		Configure::write('debug', 0);
		
			App::import('Vendor', 'paypal', array(
			'file' => 'paypal/paypalplatform.php'
		));
	}
	
	function parallel_payment()
	{
		Configure::write('debug', 0);
		
			App::import('Vendor', 'paypal', array(
			'file' => 'paypal/paypalplatform.php'
		));
		
	}
	
	
		function simple_pay()
	{
		Configure::write('debug', 0);
		
		
	}
		
	
	
	function paypal_cause($withdrawalid = NULL )
	{
		
$email = "promatics.jaswant@gmail.com";
		
		$header = "";
		
		$emailtext = "";		
		// PHP 4.1

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ( FSOCKET , 443, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
// check the payment_status is Completed
// check that txn_id has not been previously processed
// check that receiver_email is your Primary PayPal email
// check that payment_amount/payment_currency are correct
// process payment
    
		foreach ($_POST as $key => $value) {
						$emailtext .= $key . " = " . $value . "\n\n";
					}
		mail($email, "verified", $emailtext . "\n\n" . $req);
					 

	if ($_POST['payment_status'] == 'Completed') {
			$existTxn = $this->CauseWithdrawal->find('count', array(
			'conditions' => array(
			'CauseWithdrawal.paypal_confirm_id' => $_POST['txn_id']
			),
			'recursive' => -1
			));
			
				if ($existTxn == 0) {
				$status        = 'complete';
				$sessionstatus = 'Approved';
				$approvaldate = date("Y-m-d H:i:s", time());
				
				
				$this->CauseWithdrawal->updateAll(array(
				'CauseWithdrawal.paypal_amount' => "'" . $payment_amount . "'",
				'CauseWithdrawal.paypal_status' => "'" . $status . "'",
				'CauseWithdrawal.paypal_email' => "'" . $payer_email . "'",
				'CauseWithdrawal.paypal_confirm_id' => "'" . $txn_id . "'",
				'CauseWithdrawal.status' => "'" . $sessionstatus . "'",
				'CauseWithdrawal.approval_date' => "'" . $approvaldate . "'",
				'CauseWithdrawal.paypal_date' => "'" . $paypal_date . "'",
					), array(
					'CauseWithdrawal.id' => $withdrawalid
					) 
				);
				
				
				/***		Sending Mail		***/
				
				
				
				
				/***		End Sending Mail		**/
				
				}
		
		
		
		}
	else if ($_POST['payment_status'] == 'Pending') {
		
	if($_POST['pending_reason'] == 'unilateral')
		{
		
			$pending_reason = 'Invalid Paypal Eamil';
			$paypal_status = 'pending';
		
		
				$this->CauseWithdrawal->updateAll(array(
				'CauseWithdrawal.paypal_pending_reason' => "'" . $pending_reason . "'",
				'CauseWithdrawal.paypal_status' => "'" . $paypal_status . "'",
				'CauseWithdrawal.paypal_email' => "'" . $payer_email . "'",
				'CauseWithdrawal.paypal_confirm_id' => "'" . $txn_id . "'",
				'CauseWithdrawal.paypal_date' => "'" . $paypal_date . "'",
					), array(
					'CauseWithdrawal.id' => $withdrawalid
					) 
				);
	
		}
	
	}

		
	else if ($_POST['payment_status'] == 'Cancelled') {
		
				$pending_reason = 'unable to process';
				$paypal_status = 'unable to process';
			
		
				$this->CauseWithdrawal->updateAll(array(
				'CauseWithdrawal.paypal_pending_reason' => "'" . $pending_reason . "'",
				'CauseWithdrawal.paypal_status' => "'" . $paypal_status . "'",
				'CauseWithdrawal.paypal_email' => "'" . $payer_email . "'",
				'CauseWithdrawal.paypal_confirm_id' => "'" . $txn_id . "'",
				'CauseWithdrawal.paypal_date' => "'" . $paypal_date . "'",
					), array(
					'CauseWithdrawal.id' => $withdrawalid
					) 
				);
	
}





}
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
foreach ($_POST as $key => $value) {
						$emailtext .= $key . " = " . $value . "\n\n";
					}
mail($email, "Live-INVALID IPN", $emailtext . "\n\n" . $req);



}
}
fclose ($fp);
}

}


function cause($id = NULL) {
	
		$matchtutor = array();
		$school_id = array();
		
		$regId=explode('_',$id);
		$id=$regId[1];
		
//		$id = convert_uudecode(base64_decode($id));
		
		$this->set('picture', $this->getProfilePic1($id));
		
		$getBalance = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $id
			)
		));
		
		$this->set('getBalance', $getBalance);
		
		
		$session_id = $this->Session->read('Member.memberid');
		$group_id = $this->Session->read('Member.group_id');
		
		if($session_id)
		{
			
		if($group_id=='6')
		{
		
		$memberschools = $this->CauseSchool->find('first', array(
			'conditions' => array(
				'CauseSchool.cause_id' => $session_id
			)
		));
		
		if($memberschools['CauseSchool']['all']==1)
		{
			
		
		$allschool = $this->School->find('all',array('fields' => array('School.id'),
													 'recursive' => -1
													 )
										 );
		
		foreach($allschool as $as)
		{
			$school_id[] = $as['School']['id'];
		}
		
	/*	echo '<pre>';
		echo 'dfsdfsdfsd';
		print_r($allschool);
		print_r($school_id);
		die;*/
			
		}
		else if($memberschools['CauseSchool']['all']==0)
		{
		
			$memberschool = $this->CauseSchool->find('all', array(
			'conditions' => array(
			'CauseSchool.cause_id' => $session_id
			)
			));
			
			foreach($memberschool as $ms)
			{
				$school_id[] = $ms['CauseSchool']['school_id'];
			}
			
		}
		
		
		$tutorResult = $this->CauseTutor->find('all', array(
		'conditions' => array(
		'CauseTutor.status' => '1',
		'cause_id' => $id,
		),
		'recursive' => 2
		));
		
			foreach($tutorResult as $tr)
				{
					$matchtutor[] = $tr['CauseTutor']['tutor_id']; 
					$matchtutor = array_unique($matchtutor);
				}
				
				
		}
		else if($group_id=='7' || $group_id=='8')
		{
			
		
		$sessionmember = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $session_id
			)
		));
		
		$school_id = $sessionmember['Member']['school_id'];
		
	
		
		$tutorResult = $this->CauseTutor->find('all', array(
		'conditions' => array(
		'CauseTutor.status' => '1',
		'cause_id' => $id,
		),
		'recursive' => 2
		));
		
			foreach($tutorResult as $tr)
				{
					$matchtutor[] = $tr['CauseTutor']['tutor_id']; 
					$matchtutor = array_unique($matchtutor);
				}
				
				
		}
				
		
		$this->paginate['Member'] = array(
		'conditions' => array(
			'Member.id' => $matchtutor,
			'Member.school_id' => $school_id,
		),
		'order'=>array(
					'Member.created DESC'
			),
		'limit' => 10
		);
		
		$filtertutor1 = $this->paginate('Member');
		
		$this->set('filtertutor1', $filtertutor1);
		
		}
		else
			{
				
			$tutorResult = $this->CauseTutor->find('all', array(
			'conditions' => array(
			'CauseTutor.status' => '1',
			'cause_id' => $id
			),
			'recursive' => -1
			));
			
				foreach($tutorResult as $tr)
				{
					$matchtutor[] = $tr['CauseTutor']['tutor_id']; 
					$matchtutor = array_unique($matchtutor);
				}
				
				
			$this->paginate['Member'] = array(
			'conditions' => array(
			'Member.id' => $matchtutor
			),
			'order'=>array(
			'Member.created DESC'
			),
			'limit' => 10
			);
			
			$filtertutor1 = $this->paginate('Member');
			
			$this->set('filtertutor1', $filtertutor1);
				
			}
		
	/*	echo '<pre>';
		echo $session_id.'school'.$school_id;
		print_r($matchtutor);
		die;*/
		
		
			$alltutor = $this->TutorToCause->find('all', array(
			'conditions' => array(
				'TutorToCause.cause_id' => $id ,
				'TutorWithdrawal.status' => 'Approved'
			),
			'recursive' => 2
			
		));
		
		$this->set('alltutor', $alltutor);
		
	
			
	}
	
	function profiletutoravail($id = null) {
		$this->layout = 'frontend';
		
		$tutevent = $this->TutEvent->find('all', array(
			'conditions' => array(
				'TutEvent.tutor_id' => $id,
				'TutEvent.start_date >' => date('Y-m-d H:i:s')
			)
		));
		
		
		$this->set('tutevent', $tutevent);
		
	}
	
	function tutor_request()
	{
		
		Configure::write('debug', 2);
		$this->layout = 'frontend';
		
		$this->cause_element();
		
		$tutorResult = $this->TutorRequestCause->find('all', array(
			'conditions' => array(
				'TutorRequestCause.status' => '0',
				'cause_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		
	
		
		$this->set('tutorResult', $tutorResult);
		if (count($this->data)) {
			
			if (isset($this->data['Member']['accept'])) {
				
				echo "on";
				$this->TutorRequestCause->updateAll(array(
					'TutorRequestCause.status' => "'1'"
				), array(
					'TutorRequestCause.id' => $this->data['Member']['id']
				));
				
			 $TutorRequestdata = $this->TutorRequestCause->find('first',array('conditions'=>array(
													'TutorRequestCause.id' => $this->data['Member']['id']
																	  )
													  )
										);
			 
			 
			 $this->data['CauseTutor']['cause_id'] = $TutorRequestdata['TutorRequestCause']['cause_id'];
			 $this->data['CauseTutor']['tutor_id'] = $TutorRequestdata['TutorRequestCause']['tutor_id'];
			 $this->data['CauseTutor']['status'] = 1;
			 
			$alreadyrequest = $this->CauseTutor->find('all',array('conditions'=>
												 array('CauseTutor.cause_id'=> $this->data['CauseTutor']['cause_id'],
													   'CauseTutor.tutor_id'=> $this->data['CauseTutor']['tutor_id'],
													   )
												 )
									 );
			
			
			if(count($alreadyrequest)!=0)
			{
				$this->CauseTutor->updateAll(array(
					'CauseTutor.status' => "'1'"
				), array(
					'CauseTutor.id' => $alreadyrequest[0]['CauseTutor']['id']
				));
				
			}
			else
			{
				$this->CauseTutor->save($this->data);		
			}
			 
				
				$this->Session->setFlash('Accepted Successfully!');
				
				$this->redirect(array(
					'action' => 'tutor_request'
				));
				
			} else {
				
				$this->TutorRequestCause->delete($this->data['Member']['id']);
				$this->Session->setFlash('Deleted Successfully!');
				
				$this->redirect(array(
					'action' => 'tutor_request'
				));
				
			}
		}
		
		}
		
		
		function find_cause()
		{
			
		Configure::write('debug', 2);
		
		
		$matchcause = array();
		
		/*echo '<pre>';
		print_r($this->data);
		print_r($_POST);
		print_r($_SESSION);
		*/
		
	//	die;
		
/*	  $schoolid = $this->Member->find('first',array('conditions'=>
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
		
	
		$allfinalcause = $this->CauseSchool->find('all',array('conditions'=>
														 array(
															   'OR'=>array(
																'CauseSchool.school_id'=> $school_id,
																'CauseSchool.all'=> 1
																		   )
															   ),
														 'recursive' => -1,
														 )
											 );
		
		foreach($allfinalcause as $afc)
		{
			$matchcause[] = $afc['CauseSchool']['cause_id']; 
		}
		
		
			$matchcause = array_unique($matchcause);*/
			
		
			if(!$this->RequestHandler->isAjax() && !isset($this->data) ) {
				
			
			$this->Session->delete('findcause');
		
		
				$this->paginate['userMeta'] = array(
				'conditions' => array(
					'Member.group_id' => 6,
					'userMeta.cause_name !=' => ''
				),
				'recursive' => 2,
			
			);
			
			$filtercause = $this->paginate('userMeta');	
				
		
			
		/*	echo '<pre>';
			print_r($filtercause);
			die;*/
			
			
		}
		
		
		if (isset($this->data)) {
			$this->Session->write('findcause.schoolname', $this->data['CauseSchool']['schoolname']);
			
			$this->Session->write('findcause.causename', $this->data['CauseSchool']['causename']);
			
			$this->Session->write('findcause.selectRadio', $_POST['selectRadio']);
			
			$schoolname  = $this->Session->read('findcause.schoolname');
			$causename = $this->Session->read('findcause.causename');
			$selectRadio   = $this->Session->read('findcause.selectRadio');
		
			
		} else {
			
			
			
		}
		
		
		
	//	
		
		$requestedcause = array();
		
		$session_id = $this->Session->read('Member.memberid');
		
		if($session_id)
		{
		
		$causeResult = $this->CauseTutor->find('all', array(
		'conditions' => array(
		'CauseTutor.status' => '1',
		'tutor_id' => $session_id
		),
		'recursive' => -1
		));
		
		foreach($causeResult as $cr)
		{
			
			$requestedcause[] = $cr['CauseTutor']['cause_id'];
			
		}
		
		$this->set('requestedcause',$requestedcause);
		
		}
		
		
		
			if (isset($schoolname) && $schoolname!='') {
				
				$this->Session->delete('findcause.causename');
				
				$schooldata = $this->School->find('first',array('conditions'=>
												  array('School.school_name' => $schoolname)
												  )
									);
				
				$school_id = $schooldata['School']['id'];
				
				
				$causedata = $this->CauseSchool->find('all',array('conditions'=>
														 array(
															   'OR'=>array(
																'CauseSchool.school_id'=> $school_id,
																'CauseSchool.all'=> 1
																		   )
															   ),
														 'recursive' => 1,
														 )
											 );
				
				foreach($causedata as $cd)
				{
					
					$matchcause[] = $cd['CauseSchool']['cause_id'];
					
				}
				
				$matchcause = array_unique($matchcause);
				
				
				$this->paginate['userMeta'] = array(
					'conditions' => array(
						'userMeta.member_id' => $matchcause
					),
					'recursive' => 2,
					
				);
				
				$filtercause = $this->paginate('userMeta');
				
				
			/*	echo '<pre>';
				echo $school_id;
				print_r($_SESSION);
				print_r($causedata);
				print_r($filtertutor);
				die;*/
				
				
			}
			
			else if (isset($causename) && $causename!='') {
			
				$this->Session->delete('searchcause.schoolname');
				
				$this->paginate['userMeta'] = array(
					'conditions' => array(
						'userMeta.cause_name LIKE' => $causename,
						'Member.group_id' => 6
					),
					'recursive' => 2,
					
				);
				
				$filtercause = $this->paginate('userMeta');
				
			/*	echo '<pre>';
				print_r($filtertutor);
				die;*/
				
			}
			
		
		
		/*else{
		
		$this->paginate['userMeta'] = array('conditions'=> array(
		'userMeta.member_id' =>$this->Session->read('searchcause.tutorname'), 
		),	
		'recursive' => 2,
		'limit' => 2
		);
		
		$filtertutor = $this->paginate('userMeta');		
		}*/
		
		if (isset($filtercause)) {
			$this->set('filtercause', $filtercause);
			
		}
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 2);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
			$this->render('findcause');
		}
		
		
	}
	
	function send_request_cause($id = NULL)
	{
	
		$causeid = $id;
		$tutorid = $this->Session->read('Member.memberid');
		$groupid = $this->Session->read('Member.group_id');
		
		$status  = 0;
		
		$causename = $this->Member->find('first',array(
										 'conditions'=>
										  array('Member.id'=>$id)
										  )
							);
		
		$name = $causename['userMeta']['cause_name'];
		
		$request = "Your request has been send to $name";
		
	
		if (isset($id) && $groupid == 7) {
			$this->data['TutorRequestCause']['cause_id'] = $causeid;
			$this->data['TutorRequestCause']['tutor_id'] = $tutorid;
			$this->data['TutorRequestCause']['status']  = $status;
			$this->TutorRequestCause->save($this->data);
		}
		
		$this->Session->setFlash($request);
		$this->redirect(array(
			'controller' => 'members',
			'action' => 'tutor_dashboard'
		));
		
		
		}
		
		function getcauseProfile($id = NULL) {

		$data =  $this->UserImage->find('first', array(
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
		
		return $data;
	}
	
	function cause_amount_raised($id = NULL)
	{
		$causemoney = $this->TutorToCause->find('all', array(
			'conditions' => array(
				'TutorToCause.cause_id' => $id ,
				'TutorWithdrawal.status' => 'Approved'
			),
			'recursive' => 2
			
		));
		
		$causeamount = '';
		foreach($causemoney as $cm)
			{
			$causeamount =  $causeamount + $cm['TutorToCause']['cause_amount'];
			}
			
		return $causeamount;	
		
	}
	
	function cause_tutors() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$this->cause_element();
		$tutorResult = $this->CauseTutor->find('all', array(
			'conditions' => array(
				'CauseTutor.status' => '1',
				'cause_id' => $this->Session->read('Member.memberid')
			),
			'order' => array(
				'CauseTutor.grant DESC'
			),
			'recursive' => 2
		));
		//pr($tutorResult);exit;
		$this->set('tutorResult', $tutorResult);
		
	}
	
	
	function getTutorRequest() {
		return $this->TutorRequestCause->find('count', array(
			'conditions' => array(
				'cause_id' => $this->Session->read('Member.memberid'),
				'status' => 0
			)
		));
	}
	
	
	function admin_school_requests() {
		$this->layout = 'admin';
		$upcoming_user =  $this->UpcomingMember->find(
			'all'
		);
		
		$this->set("mailClass", "selected");

		if (isset($this->data)) {
			$this->Session->write('prntview.name', $this->data['UpcomingMember']['name']);
			$this->Session->write('prntview.email', $this->data['UpcomingMember']['email']);
			$this->Session->write('prntview.upcoming_school_id', $this->data['UpcomingMember']['upcoming_school_id']);
			$this->Session->write('prntview.perpage', $this->data['UpcomingMember']['perpage']);
			
			$this->data['UpcomingMember']['name']    = $this->Session->read('prntview.name');
			$this->data['UpcomingMember']['email']    = $this->Session->read('prntview.email');
			$this->data['UpcomingMember']['upcoming_school_id']   = $this->Session->read('prntview.upcoming_school_id');
			$this->data['UpcomingMember']['perpage']  = $this->Session->read('prntview.perpage');
			
		} else {
			$this->Session->delete('prntview');
		}
		
		if (strlen($this->Session->read('prntview.perpage')) > 0) {
			$this->data['UpcomingMember']['perpage'] = $this->Session->read('prntview.perpage');
		} else {
			$this->data['UpcomingMember']['perpage'] = 10;
		}
		
		$this->paginate['UpcomingMember'] = array(
			'conditions' => array(
				'AND' => array(
					'UpcomingMember.name  LIKE' => "%" . $this->data['UpcomingMember']['name'] . "%",
					'UpcomingMember.email  LIKE' => "%" . $this->data['UpcomingMember']['email'] . "%",
					'UpcomingMember.upcoming_school_id LIKE' => "%" .$this->data['UpcomingMember']['upcoming_school_id']. "%",
				)
			),
			'limit' => $this->data['UpcomingMember']['perpage']
		);
		$schools = $this->UpcomingSchool->find(
			'list',
			array(
				'fields' => array(
					'UpcomingSchool.id',
					'UpcomingSchool.school_name'
				)
			)
		);
		
		$this->set('schools',$schools);
		$members = $this->paginate('UpcomingMember');
		
		$this->set('members', $members);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'members';
			$this->render('upcominguser');
		}
	}
	
	function admin_member_subscribe($id=null) {
		$this->layout = 'admin';
		
		$this->set("mailClass", "selected"); //set main navigation class
		
		$lists = $this->MailchimpApi->lists();
		
		$memberdata = $this->UpcomingMember->find('first', array(
			'conditions' => array(
				'UpcomingMember.id' => $id
			)
		));
		$this->set('memberdata', $memberdata);
		$this->set('lists', $lists);
		if (!empty($this->data)) {
			$first = $this->data['first'];
			$email = $this->data['email'];
			$id    = $this->data['id'];
			$member_id = $this->data['member_id'];
			$update['UpcomingMember']['id'] = $member_id;
			$update['UpcomingMember']['status'] = 'subscribed';
			$add = $this->MailchimpApi->addMembers($id, $email, $first, $first);
			if ($add) {
				$this->UpcomingMember->save($update);
				$this->Session->setFlash('Successfully added user to your list.  They will not be reflected in your list until the user confirms their subscription.');
			} else {
				$this->Session->setFlash('Oops, something went wrong.  Email was not added to your user.');
			}
			$this->redirect(array(
				'action' => 'school_requests',
				'admin' => true
			));
		}
	}
}
?>