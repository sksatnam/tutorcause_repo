<?php
ob_start();
class MembersController extends AppController {
	var $name = 'members';
	var $layout = "frontend";
	var $helpers = array('Form','Html','Error','Javascript', 'Ajax','Paginator',);
	var $components = array('RequestHandler','Email','MailchimpApi','Ggapi','Cookie');
	var $uses = array('Member','State','userMeta','Group', 'School', 'Course', 'TutCourse','TutEvent','Page','CauseSchool','UserImage','CauseTutor','TutMessage','Privilege','TutRating','PaymentHistory','TutorWithdrawal','TutorToCause','AddFund','CauseWithdrawal','EmailTemplate','TutorRequestCause','UpcomingMember','UpcomingSchool','Charge','StdCourse','Notice','Wage','Api','ParentStudent','ParentFund','StudentFund','Timezone','Charges');
	
	// function executes before each action to execute 
	function beforeFilter() {
		
	//	parent::beforeFilter();
		
		$bypassPage = array(
			'index',
			'paypal',
			'select_type',
			'add_fund',
			'fund_add',
            'error',
			'paypal_tutor',
			'paypal_non_profit',
			'simple_pay',
			'profiletutoravail',
			'tutor',
			'non_profit',
			'testEmail',
			'first_data_sucess',
			'yourpay',
			'cronjob',
			'reviewcronjob',
			'stripe_pay',
			'stripe_sucess',
			'logout',
			'registration',
			'non_profit_amount_raised',
		);
		
		
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
	//Function for checking the existance of user's email in the database & used for validation
	function checkemail() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		$this->layout     = "";
		
		$email = $_REQUEST['data']['Member']['email'];
		
		$count = $this->Member->find('count', array(
			'conditions' => array(
				'email' => $email
			)
		));
		
		
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
			'order' => 'Member.created DESC',
			'limit' => '5'
		));
		
		
		
		$this->set('tutors', $tutors);
		$students = $this->Member->find('all', array(
			'conditions' => array(
				'Member.group_id' => '8'
			),
			'order' => 'Member.created DESC',
			'limit' => '5'
		));
		$this->set('students', $students);
		$causes = $this->Member->find('all', array(
			'conditions' => array(
				'Member.group_id' => '6'
			),
			'order' => 'Member.created DESC',
			'limit' => '5'
		));
		$this->set('causes', $causes);
		
		$courses = $this->Course->find('all', array(
			'limit' => '5',
			'order' => 'Course.created DESC'
		));
		$this->set('courses', $courses);
		
		
	}
	
	//function for the login of the backend user.
	function checkadminlogin() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		$this->layout     = "";
		
		if ($this->RequestHandler->isAjax()) {
			$username = $this->data['Member']['username'];
			$password = $this->data['Member']['pwd'];
			
			
			$groupId = array('1','2','3','4','5');
			
			
			$user = $this->Member->find('count', array(
				'conditions' => array(
					'Member.email' => $username,
					'Member.pwd' => md5($password),
					'Member.active' => '1',
					'Member.group_id' => $groupId,
				)
			));
			
			
			if ($user) {
				$getAdminData = $this->Member->find('first', array(
					'conditions' => array(
						'Member.email' => $username,
						'Member.pwd' => md5($password),
						'Member.active' => '1',
						'Member.group_id' => $groupId,
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
		
		$this->set("schoolname", $schoolname);
		
		if (!empty($this->data)) {
			$data['Member']['pwd']       = md5($this->data['Member']['pwd']);
			$data['Member']['email']     = $this->data['Member']['email'];
			$data['Member']['group_id']  = $this->data['Member']['group_id'];
		//	$data['Member']['active']    = $this->data['Member']['status'];
			$data['Member']['active']    = 1;
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
			
			
			
			
		/*	$memberData = $this->Member->find('first',array('conditions'=>array('Member.id'=>58),
															'recursive' => -1)
											  );
			
			
			if($memberData['Member']['group_id']==7 || $memberData['Member']['group_id']==8)
			{
			
				if(count($allMember))
					{
						$status = $allMember[0]['Member']['active'];
						if($status==1)
						{
							$statusMsg = 'Active';
						}
						else if($status==0)
						{
							$statusMsg = 'Un-Active';
						}
						else if($status==2)
						{
							$statusMsg = 'Block';
						}
						else if($status==4)
						{
							$statusMsg = 'Trash';
						}
						
						$sessionMsg = 'There is alredy one user with status '.$statusMsg;
						$this->Session->setFlash($sessionMsg);
						
						$this->redirect(array(
							'action' => 'member_view',
							'admin' => true
						));
						
					}
			
			}
		*/	
			
			/*echo '<pre>';
			print_r($this->data);
			echo $fbid;
			echo $sessionMsg;
			print_r($allMember);
			die;*/
			
			
			$data['Member']['stripeid']  = $this->data['Member']['stripeid'];
			$data['Member']['email']  = $this->data['Member']['email'];
			$data['Member']['group_id']  = $this->data['Member']['group_id'];
			$data['Member']['active']    = $this->data['Member']['status'];
			$data['Member']['id']        = $this->data['Member']['id'];
			$data['Member']['school_id'] = $this->data['Member']['school_id'];
			$data['Member']['fname']  = $this->data['userMeta']['fname'];
			$data['Member']['lname']  = $this->data['userMeta']['lname'];
			
			
			
			if($this->data['Member']['group_id']==8 || $this->data['Member']['group_id']==9)
			{
			
				if($this->data['Member']['creditable_balance'])
				{
					$data['Member']['creditable_balance'] = $this->data['Member']['creditable_balance'];
				}
			
			}
					
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
				
				if(is_array($user))
				{	
					$userMeta['userMeta']['id'] = $user['userMeta']['id'];
				}
				else
				{
					$userMeta['userMeta']['member_id'] = $this->data['Member']['id'];
				}
				
				
				
			
				
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
		
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('prntview');
		}
		
		if (isset($this->data)) {
			$this->Session->write('prntview.email', trim($this->data['Member']['email']));
			$this->Session->write('prntview.active', $this->data['Member']['active']);
			$this->Session->write('prntview.group_id', $this->data['Member']['group_id']);
			$this->Session->write('prntview.perpage', $this->data['Member']['perpage']);
			
			$this->data['Member']['email']    = $this->Session->read('prntview.email');
			$this->data['Member']['active']   = $this->Session->read('prntview.active');
			$this->data['Member']['group_id'] = $this->Session->read('prntview.group_id');
			$this->data['Member']['perpage']  = $this->Session->read('prntview.perpage');
			
		} else {
			
			$this->data['Member']['email']    = $this->Session->read('prntview.email');
			$this->data['Member']['active']   = $this->Session->read('prntview.active');
			$this->data['Member']['group_id'] = $this->Session->read('prntview.group_id');
			$this->data['Member']['perpage']  = $this->Session->read('prntview.perpage');

		}
		
		if (strlen($this->Session->read('prntview.perpage')) > 0) {
			$this->data['Member']['perpage'] = $this->Session->read('prntview.perpage');
		} else {
			$this->data['Member']['perpage'] = 10;
		}		
		
		
		if(!empty($this->data['Member']['email']) || !empty($this->data['Member']['active']) || !empty($this->data['Member']['group_id']) )
		{
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
		}
		else
		{
			$this->paginate['Member'] = array(
				'conditions' => array(
					'AND' => array(
						'Member.active !=' => 0
					)
				),
				'limit' => $this->data['Member']['perpage']
			);
			
			
		}
		
		
		
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		//$cities = Set::combine($alldata,'{n}.State.id','{n}.State.city');
		$this->set("states", $states);
	
		
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
		
		Configure::write('debug', 0);
		
		/*echo '<pre>';
		echo 'jaswnat';
		print_r($_SESSION);*/
		
		
	//	$logouturl = $this->Session->read('Member.logoutUrl');
		
		
		/*
		echo 'cakesessiondelete';
		print_r($_SESSION);*/
		
		$this->Session->delete('Member');
		$this->Session->delete('booktutor');
		
		
	//	session_destroy();
		
	/*	$username = $this->Cookie->read('username');
		$password = $this->Cookie->read('password');
		
		
		if($username!='' && $password!='')
		{
			$this->Cookie->delete('username');
			$this->Cookie->delete('password');
		}*/
		
		$this->redirect(array(
								  'controller' => 'members',
								  'action' => 'index'
			));
		
		
		/*echo 'php session delete';
		print_r($_SESSION);
		die;*/
		
	/*	if($logouturl)
		{
			$this->redirect("$logouturl");
		}
		else
		{
			$this->redirect(array(
								  'controller' => 'members',
								  'action' => 'index'
			));
			
		}*/
		
		
		//$this->redirect(array('controller'=>'members', 'action'=>'index'));
		/*		$this->Session->delete('Member.id');
		$this->Session->delete('Member.memberid');
		$this->Session->delete('Member.active');
		$this->Session->delete('Member.group_id');
		$logouturl =  $this->Session->read('Member.logoutUrl');
		$this->redirect("$logouturl");*/
	}
	
	
/*	function checkpercentage() {
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
			
			
			if (strlen($v) < 1 || $v == 'NULL') {
				$x++;
			}
			
		}
		return $x;
	}*/
	
	
	
	function regmember() {
		//$this->checkfacebooklogin();
		Configure::write('debug', 0);
		$this->layout = 'frontend';
//		$this->set('emailStatus','');
		$this->set('picture', $this->getProfilePic());
		
		
		$alltimes = $this->Timezone->find('all',array('order'=>array('Timezone.GMT ASC'))); //retireve all timezone
		
		$this->set('alltimes',$alltimes);
		
		
		$this->data = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid'),
				'Member.active !=' => 3
			)
		));
		$this->Session->write('userMeta.goal', $this->data['userMeta']['goal']);
		
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
		
		$allSchool = $this->School->find('all',array('conditions'=>array('School.status'=>'active'))); //retireve all states
		$schools  = Set::combine($allSchool, '{n}.School.id', '{n}.School.school_name');
		$this->set("schools", $schools);
		
		
		$causeSchools = $this->CauseSchool->find('list', array(
			'fields' => array(
				'school_id'
			),
			'conditions' => array(
				'CauseSchool.cause_id' => $this->Session->read('Member.memberid'),
				'CauseSchool.all' => 0
			)
		));
		$this->set('causeSchools', $causeSchools);
		
		
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		
		/*echo '<pre>';
		print_r($states);
		die;*/
		
		$this->set("states", $states);
		
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
			}  else if ($usertype['Member']['group_id'] == 9) {
				$user = 'parent';
				$this->set('user', $user);
			}
			$this->set('emailStatus','readonly');
			
		}*/
		
		
		
		
		
		
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
		
		/*echo '<pre>';
		print_r($_POST);
		die;
		*/
		
		
	/*	echo '<pre>';
		
		print_r($this->data['TutCourse']['course_id']);*/
		
		$uniquecourse = array_unique($this->data['TutCourse']['course_id']);
		
		$cntcourse = count($this->data['TutCourse']['course_id']);
		$cntunqcourse = count($uniquecourse);
		
		
		if($cntunqcourse < $cntcourse)
		{
			$this->Session->setFlash('There are duplicate courses.');
			$this->redirect($this->referer());
		}
		
		
		
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
				'action' => 'tutor_dashboard'
			));
		}
		
	}
	
	
	function getautocourse($id = NULL) {
		$this->layout     = '';
		$this->autoRender = false;
		Configure::write('debug', 0);
		//echo $id;
		//exit;
		
	//	print_r($_REQUEST);
		
		$data = $_REQUEST['q'];
		
		$myCourse = $this->TutCourse->find('all',array(
													   'conditions'=>array(
															'TutCourse.member_id'=> $this->Session->read('Member.memberid')			   
																		   ),
													   'recursive'=> -1
													   )
										   );
		$preCourse = array();
		
		foreach($myCourse as $mc)
		{
			$preCourse[] = $mc['TutCourse']['course_id'];
		}
		
	/*	echo '<pre>';
		print_r($myCourse);
		die;*/
		
		
		
		$returnList = $this->Course->find('all', array(
			'limit' => '10',
			'conditions' => array(
				'course_id LIKE ' => $data . "%",
				'school_id' => $id
			),
			'order' => array(
					'Course.course_id ASC'
				),
			'recursive' => -1
		));
		
		
		$dataList = array();
		foreach($returnList as  $rl)
		{
			if (!in_array($rl['Course']['course_id'], $preCourse)) {
				$dataList[] = $rl['Course']['course_id'];	
			}
		}
		
		/*$course = Set::combine($returnList, '{n}.Course.course_id');
		
		$dataList = array();
		
		foreach ($course as $id => $value) {
			$toReturn   = $value;
			$dataList[] = '<li id="' . $id . '">' . htmlentities($toReturn) .'</li>';
			// $i++;
		}*/
		
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
	
	function checkrepeatcourse()
	{
		$this->layout     = '';
		$this->autoRender = false;
		Configure::write('debug', 0);
		
		$data = trim($_REQUEST['courseId']);
		$id = $_REQUEST['schoolId'];
		
		$returnList = $this->Course->find('all', array(
			'conditions' => array(
				'course_id' => $data, 
				'school_id' => $id
			),
			'recursive' => -1
		));
		
		
		/*echo '<pre>';
		print_r($_REQUEST);
		print_r($returnList);
		echo count($returnList);*/
		
		
		if(count($returnList)>0)
		{
			echo "1";
			//echo 'true';	
		}
		else
		{
			echo "0";
		}
		
		
		die;
	
	}
	
	
	
	function addmember() {
		
		
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$memberOld = $this->Member->find('first',array(
													   'conditions'=>
													   array('Member.id'=>$this->Session->read('Member.memberid')),
													   'recursive' => -1
													  			)
										 
										 );
		
		$oldSchool = $memberOld['Member']['school_id'];
		
		/*echo '<pre>';
		print_r($memberOld);
		echo '</pre>';
		die;*/
		
		
		
		
		
		
		
		
		if (isset($this->data)) {
			
			$memberdata['Member']['id']     = $this->data['Member']['id'];
			$memberdata['Member']['email']  = $this->data['Member']['email'];
			$memberdata['Member']['fname']  = $this->data['userMeta']['fname'];
			$memberdata['Member']['lname']  = $this->data['userMeta']['lname'];
			
		//	$memberdata['Member']['active'] = 1;
		
		    if($this->data['Member']['facebookId'])
			{
				$memberdata['Member']['facebookId']  = $this->data['Member']['facebookId'];
			}
			
			
			if(!empty($this->data['Member']['timezone']))
			{
			
				$timezone = $this->Timezone->find('first',array('conditions'=>array(
																'Timezone.id'=>$this->data['Member']['timezone'])
																)
												  );
				
				$memberdata['Member']['timezone'] = $timezone['Timezone']['name'];
				$memberdata['Member']['offset'] = $timezone['Timezone']['GMT'];
				
				
				$this->Session->write('Member.timezone',$timezone['Timezone']['name']);
				$this->Session->write('Member.offset',$timezone['Timezone']['GMT']); 
			
			}
			
			
			
			
			
		/*	if (isset($this->data['Member']['group_id']) && $this->data['Member']['group_id'] != 'NULL') {
				$memberdata['Member']['group_id'] = $this->data['Member']['group_id'];
			}*/
			
			if($this->Session->read('Member.group_id')==7 || $this->Session->read('Member.group_id')==8)
			{
				$memberdata['Member']['school_id']  = $this->data['Member']['school_id'];
				
				if($oldSchool!=$this->data['Member']['school_id'])
				{
					$newschool = $this->data['Member']['school_id'];
					
					$newschoolname = $this->School->find('first',array(
																	   'conditions'=>array('School.id'=>$newschool),
																	   'recursive'=> -1,
																	   )
														 );
					
					$schoolname = $newschoolname['School']['school_name']; 
					
					$schoolMsg = "Your School has been changed to ".$schoolname;
					
					
					if($this->Session->read('Member.group_id')==7)
					{
						$this->TutCourse->deleteAll(array(
							'TutCourse.member_id' => $this->Session->read('Member.memberid')
						));
					}
					
					
					
					/*echo '<pre>';
					print_r($newschoolname);
					echo '</pre>';
					die;*/
					
					
				}
				
			}
			else if($this->Session->read('Member.group_id')==6)
			{
			 $allSchool =	$this->CauseSchool->find('all',array('conditions'=>
															 array('CauseSchool.cause_id'=>$this->Session->read('Member.memberid')),
															 'recursive'=> -1
															 )
												 );
			 
			 $mySchool = array();
			 $newSchool = array();
			 
			 foreach($allSchool as $as)
			 {
			   $mySchool[] = $as['CauseSchool']['school_id']; 
			 }
			 
			 /*echo '<pre>';
			 print_r($mySchool);*/
			 
			 sort( $mySchool );

			 foreach ($this->data['CauseSchool']['school_id'] as $key => $value)
			 {
			   $newSchool[] = $value; 
			 }
			 
			// print_r($newSchool);
			 
			 sort( $newSchool );
			 
			 if($mySchool==$newSchool)
			 {
				
			 }
			 else
			 {
				 
			  $newName = $this->School->find('all',array('conditions'=>
												 array('School.id'=> $newSchool),
												 'recursive'=> -1
												 )
									 );
			  
			  $schName = array();
			  foreach($newName as $nm)
			  {
				  $schName[] = $nm['School']['school_name'];
				  
			  }
			  
			  $comma_separated = implode(",", $schName);
	
			  
			  $schoolMsg = "Your School has been changed to ".$comma_separated;
			  
				 
				
			 }
			 
			    /*echo 'sortmyschool';
				print_r($mySchool);
				echo 'sortnewschool';
				print_r($newSchool);
				print_r($this->data['CauseSchool']['school_id']);
				echo '</pre>';
				die;*/
				
				
			$this->CauseSchool->deleteAll(array(
				'CauseSchool.cause_id' => $this->Session->read('Member.memberid')
			));

			foreach ($this->data['CauseSchool']['school_id'] as $key => $value) {
					$data['CauseSchool']['cause_id']  = $this->Session->read('Member.memberid');
					$data['CauseSchool']['school_id'] = $value;
					$this->CauseSchool->create();
					$this->CauseSchool->save($data);
				}

			}
			
		/*	echo '<pre>';
			print_r($_POST);
			print_r($memberdata);
			die;*/
			
			
			
			if ($this->Member->save($memberdata)) {
				
				if($this->Session->read('Member.group_id')==6)
				{
					$userMeta['userMeta']['cause_name']     = $this->data['userMeta']['cause_name'];
				}
				
				$userMeta['userMeta']['fname']     = $this->data['userMeta']['fname'];
				$userMeta['userMeta']['lname']     = $this->data['userMeta']['lname'];
				$userMeta['userMeta']['address']   = $this->data['userMeta']['address'];
				$userMeta['userMeta']['city']      = $this->data['userMeta']['city'];
				$userMeta['userMeta']['state']     = $this->data['userMeta']['state'];
				$userMeta['userMeta']['zip']       = $this->data['userMeta']['zip'];
				$userMeta['userMeta']['contact']   = $this->data['userMeta']['contact'];
				$userMeta['userMeta']['biography']   = $this->data['userMeta']['biography'];
				$userMeta['userMeta']['goal']   = $this->Session->read('userMeta.goal');
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
					
					if ($user['Member']['group_id'] == '6' && $user['Member']['active'] == '1') {
						
						if($schoolMsg)
						{
							$this->Session->setFlash($schoolMsg);
						}
						else
						{
							$this->Session->setFlash('Your profile has been updated successfully ');
						}
						
						$this->redirect(array(
							'controller' => 'members',
							'action' => 'non_profit_dashboard'
						));
					} else if ($user['Member']['group_id'] == '7' && $user['Member']['active'] == '1') {
						
						if($schoolMsg)
						{
							$this->Session->setFlash($schoolMsg);
						}
						else
						{
							$this->Session->setFlash('Your profile has been updated successfully ');
						}
						
						$this->redirect(array(
							'controller' => 'members',
							'action' => 'tutor_dashboard'
						));
					} else if ($user['Member']['group_id'] == '8' && $user['Member']['active'] == '1' ) {
						
						if($schoolMsg)
						{
							$this->Session->setFlash($schoolMsg);
						}
						else
						{
							$this->Session->setFlash('Your profile has been updated successfully ');
						}
						
						$this->redirect(array(
							'controller' => 'members',
							'action' => 'student_dashboard'
						));
					}   else if ($user['Member']['group_id'] == '9' && $user['Member']['active'] == '1' ) {
						
							$this->Session->setFlash('Your profile has been updated successfully');
												
						$this->redirect(array(
							'controller' => 'members',
							'action' => 'parent_dashboard'
						));
					}
					else if( $user['Member']['active'] == '0')  
					{
						
						/*	$this->welcome_email_template($user['Member']['id']);
							
							session_destroy();
							
							$this->redirect(array(
							'controller' => 'homes',
							'action' => 'welcome_user'
						));*/
						
					}
					else if( $user['Member']['active'] == '2')  
					{
					//	session_destroy();
						
						$this->redirect(array(
						'controller' => 'homes',
						'action' => 'block_user'
						));
						
					}
					
				}
			}
			
		}
	}
	
	function index() {
		
		
		$this->newcheckuserstep();
		
		Configure::write('debug', 0);
	
	/*	
	
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
		$this->set('schools',$schools);*/
		
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
				'Member.id !=' => $memberid,
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
	
	function non_profit_dashboard() {
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
		
		
		$tutevent = $this->TutEvent->find('all', array(
			'conditions' => array(
				'TutEvent.tutor_id' => $this->Session->read('Member.memberid'),
				'TutEvent.start_date >=' => date('Y-m-d'),
			),
			'order'=>array('TutEvent.start_date ASC'),
			'recursive' => -1
		));
		
		$this->set('tutevent',$tutevent);
		
		
		$seteventtime = $this->TutEvent->find('first', array(
			'conditions' => array(
				'TutEvent.tutor_id' => $this->Session->read('Member.memberid'),
				'TutEvent.start_date >=' => date('Y-m-d'),
				'TutEvent.title' => 'Booked'
			),
		'order'=>array('TutEvent.start_date ASC'),
		'recursive' => -1
		));
		
		
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
		
		return $this->TutorRequestCause->find('count', array(
			'conditions' => array(
				'tutor_id' => $this->Session->read('Member.memberid'),
				'req_cause' => 1,
				'status' => 0
			)
		));
	}
	
/*	
define in app_controller

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
	}*/
	
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
	
	function non_profit_request() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		$this->tutor_element();
		
		$this->set('CountRequest', $this->getCauseRequest());
		
		
		$causeResult = $this->TutorRequestCause->find('all', array(
			'conditions' => array(
				'TutorRequestCause.status' => '0',
				'TutorRequestCause.req_cause' => 1,
				'tutor_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		$this->set('causeResult', $causeResult);
		
		
		if (count($this->data)) {
			if (isset($this->data['Member']['accept'])) {
				echo "on";
				$this->TutorRequestCause->updateAll(array(
					'TutorRequestCause.status' => "'1'"
				), array(
					'TutorRequestCause.id' => $this->data['Member']['id']
				));
				
				
				 $data = $this->TutorRequestCause->find('first',array('conditions'=>array(
																'TutorRequestCause.id' => $this->data['Member']['id']
																		  ),
																'recursive'=>-1
														  )
											);
				 
				 
				 $causeid = $data['TutorRequestCause']['cause_id'];
				 $tutorid = $data['TutorRequestCause']['tutor_id'];
				 
				 $deleterequest = $this->TutorRequestCause->deleteAll(array(
						'TutorRequestCause.cause_id' => $causeid,
						'TutorRequestCause.tutor_id' => $tutorid,
						'TutorRequestCause.status' => 0,
					));
				
				
				$this->Session->setFlash('Accepted successfully!');
				$this->redirect(array(
					'action' => 'non_profit_request'
				));
			} else {
				$this->TutorRequestCause->delete($this->data['Member']['id']);
				$this->Session->setFlash('Deleted successfully!');
				$this->redirect(array(
					'action' => 'non_profit_request'
				));
			}
		}
	}
	
	function payment() {
		$this->layout = 'frontend';
	}
	
	
	
/*	function step2() {
		$this->data = $this->Member->find('first', array(
			'fields' => array(
				'Member.group_id'
			),
			'conditions' => array(
				'Member.facebookId' => $this->Session->read('Member.id')
			)
		));
	
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
		
		
		
		$x = $this->checkpercentage();
		$x = 70 - 10 * $x;
		$this->set('x', $x);
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
	} */
	
	
/*	function step3() {
		$this->data = $this->Member->find('first', array(
			'fields' => array(
				'Member.group_id'
			),
			'conditions' => array(
				'Member.facebookId' => $this->Session->read('Member.id')
			)
		));
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
	
		
		
		$x = $this->checkpercentage();
		$x = 70 - 10 * $x;
		$this->set('x', $x);
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
	}*/
	
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
		
		
		$memberdata = $this->Member->find('first',array(
												'conditions' => array('Member.id' => $this->Session->read('Member.memberid')),
												'recursive' => -1
														)
										  );
		
		
		$min_wage = $this->Wage->find('all',array(
													'conditions'=>array('Wage.id'=> '1'),
													)
									  );
		
		
		$tutcources = $this->TutCourse->find('all', array(
			'conditions' => array(
				'TutCourse.member_id' => $this->Session->read('Member.memberid')
			),
			'order'=>array('TutCourse.course_id ASC'),
		));
		
		$this->set('min_wage', $min_wage);
		
		$this->set('memberdata', $memberdata);
		
		$this->set('tutcources', $tutcources);
		
			
		
		
	}
	
	
	function dumyeditschool()
	{
		
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$schools      = $this->School->find('all');
		$this->set('schools', $schools);
		
		
		$memberdata = $this->Member->find('first',array(
												'conditions' => array('Member.id' => $this->Session->read('Member.memberid')),
												'recursive' => -1
														)
										  );
		
		
		$min_wage = $this->Wage->find('all',array(
													'conditions'=>array('Wage.id'=> '1'),
													)
									  );
		
		
		$tutcources = $this->TutCourse->find('all', array(
			'conditions' => array(
				'TutCourse.member_id' => $this->Session->read('Member.memberid')
			)
		));
		
		$this->set('min_wage', $min_wage);
		
		$this->set('memberdata', $memberdata);
		
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
	
	function deletecourse1() {
		$deleteCourse = $this->StdCourse->deleteAll(array(
			'StdCourse.member_id' => $this->Session->read('Member.memberid'),
			'StdCourse.id' => $_REQUEST['courseId']
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
				'Member.id' => $this->Session->read('Member.memberid'),
				'Member.active !=' => 3
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
		
	//	'fields' => array('CONVERT_TZ(TutorEvent.start,  "-05:00",  "'.$gmt.'" ) as created','TutorEvent.id'),		
	
		$offset = $this->Session->read('Member.offset'); 
		$timezone = $this->Session->read('Member.timezone'); 
		
		$currentdate = $this->cdate($timezone);
		
	/*	echo $currentdate;
		die;*/
		
/*		echo $offset;
		die;
*/		
		
		$tutevent = $this->TutEvent->find('all', array(
			'conditions' => array(
				'TutEvent.tutor_id' => $this->Session->read('Member.memberid'),
				'TutEvent.start_date >=' => $currentdate,
			),
			'fields' => array('CONVERT_TZ(TutEvent.start_date,  "-05:00",  "'.$offset.'" ) as start_date','CONVERT_TZ(TutEvent.end_date,  "-05:00",  "'.$offset.'" ) as end_date','TutEvent.id','TutEvent.title'),
			'order'=>array('TutEvent.start_date ASC'),
			'recursive' => -1
		));
		
	/*	echo '<pre>';
		print_r($tutevent);
		die;*/
		
		
		$seteventtime = $this->TutEvent->find('first', array(
			'conditions' => array(
				'TutEvent.tutor_id' => $this->Session->read('Member.memberid'),
				'TutEvent.start_date >=' => $currentdate,
				'TutEvent.title' => 'Booked'
			),
			'fields' => array('CONVERT_TZ(TutEvent.start_date,  "-05:00",  "'.$offset.'" ) as start_date'),
			'order'=>array('TutEvent.start_date ASC'),
			'recursive' => -1
		));
		
		
	/*	echo '<pre>';
		print_r($senteventtime);
		die;*/
		
		
		
		
		if($seteventtime[0]['start_date'])
	{
		  $startdate = $seteventtime[0]['start_date'];
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
	
	function copyschedule() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		/*	
		echo '<pre>';
		print_r($_POST);
		die;*/
		
		$offset = $this->Session->read('Member.offset');
		
		if (isset($this->data)) {
			
			
			$stime = date("H:i:s",strtotime($this->data['TutEvent']['starttime']));
			$etime = date("H:i:s",strtotime($this->data['TutEvent']['endtime']));
			
			
			if ($this->data['TutEvent']['spe_date']) {
				
				$sourcedate = date("Y-m-d", strtotime($this->data['TutEvent']['source_date']));		
				
				$alldaystime = date("Y-m-d H:i:s", strtotime("1 minutes",strtotime($this->data['TutEvent']['source_date'])));		
				
				$alldaystime = $this->tgmt($alldaystime,$this->Session->read('Member.timezone'));
				
				$alldayetime = date("Y-m-d H:i:s", strtotime("1439 minutes",strtotime($this->data['TutEvent']['source_date'])));
				
				$alldayetime = $this->tgmt($alldayetime,$this->Session->read('Member.timezone'));
				
				
			/*	echo 'allday start'.$alldaystime;
				
				echo 'allday end'.$alldayetime;
				
				die;*/
				
				
				
				$desdate = date('Y-m-d', strtotime($this->data['TutEvent']['spe_date']));
				
				
				$finalstime = $sourcedate.' '.$stime;
				
			//	echo 'finalstime'.$finalstime;
				
				$finalstime = $this->tgmt($finalstime,$this->Session->read('Member.timezone'));
				
			//	echo 'finalstimeGMT'.$finalstime;
				
				$finaletime = $sourcedate.' '.$etime;
				
			//	echo 'finaletime'.$finaletime;
				
				$finaletime = $this->tgmt($finaletime,$this->Session->read('Member.timezone'));
				
			//	echo 'finaletimeGMT'.$finaletime;
				
				
				if($this->data['TutEvent']['allday'])
				{
						$sourcetime = $this->TutEvent->find('all', array(
							'conditions' => array(
								'TutEvent.start_date >=' => $alldaystime,
								'TutEvent.end_date <=' => $alldayetime,
								'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
							),
							'fields' => array('CONVERT_TZ(TutEvent.start_date,  "-05:00",  "'.$offset.'" ) as start_date','CONVERT_TZ(TutEvent.end_date,  "-05:00",  "'.$offset.'" ) as end_date'),
							'recursive'=>-1
						));
						
						/*echo '<pre>';
						print_r($sourcetime);
						die;*/
						
						
				}
				else
				{
						$sourcetime = $this->TutEvent->find('all', array(
							'conditions' => array(
								'TutEvent.start_date >=' => $finalstime,
								'TutEvent.end_date <=' => $finaletime,
								'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
							),
							'fields' => array('CONVERT_TZ(TutEvent.start_date,  "-05:00",  "'.$offset.'" ) as start_date','CONVERT_TZ(TutEvent.end_date,  "-05:00",  "'.$offset.'" ) as end_date'),
							'recursive'=> -1
						));
				}
				
				for ($j = 0; $j < count($sourcetime); $j++) {
					$timestart = date('H:i:s', strtotime($sourcetime[$j][0]['start_date']));
					$timeend   = date('H:i:s', strtotime($sourcetime[$j][0]['end_date']));
					
					$finalstartdate = $desdate . ' ' . $timestart;
					
					$finalstartdate = $this->tgmt($finalstartdate,$this->Session->read('Member.timezone'));
					
					$finalenddate = $desdate . ' ' . $timeend;
					
					$finalenddate = $this->tgmt($finalenddate,$this->Session->read('Member.timezone'));
					
					$result = $this->collapseevent($finalstartdate , $finalenddate);
					
					if($result=='true')
					{
						continue;
					}
					
					
					$this->TutEvent->create();
					
					$this->copyevent['TutEvent']['start_date'] = $finalstartdate;
					
					$this->copyevent['TutEvent']['end_date'] = $finalenddate;
					
					$this->copyevent['TutEvent']['tutor_id'] = $this->Session->read('Member.memberid');
					
				/*	echo '<pre>';
					print_r($this->copyevent);
					print_r($this->data);
					print_r($sourcetime);*/
					
					$this->TutEvent->Save($this->copyevent);
					
				}
			
				
			} else {
				
				
			/*	echo '<pre>';
				print_r($this->data);
				die;*/
				
				
				$sourcedate = date("Y-m-d", strtotime($this->data['TutEvent']['source_date']));
				
				$alldaystime = date("Y-m-d H:i:s", strtotime("1 minutes",strtotime($this->data['TutEvent']['source_date'])));		
				
				$alldaystime = $this->tgmt($alldaystime,$this->Session->read('Member.timezone'));
				
				$alldayetime = date("Y-m-d H:i:s", strtotime("1439 minutes",strtotime($this->data['TutEvent']['source_date'])));
				
				$alldayetime = $this->tgmt($alldayetime,$this->Session->read('Member.timezone'));
				
				
				
				
				$startdate = date("Y-m-d", strtotime($this->data['TutEvent']['start_date']));
				
				$replacedate = $this->data['TutEvent']['end_date'];
				
				$desdate = date('Y-m-d', strtotime($replacedate));
				
				
				$finalstime = $startdate.' '.$stime;
				
				$finalstime = $this->tgmt($finalstime,$this->Session->read('Member.timezone'));
				
				$finaletime = $startdate.' '.$etime;
				
				$finaletime = $this->tgmt($finaletime,$this->Session->read('Member.timezone'));
				
				/*echo $finalstime;
				echo $finaletime;*/
				
				
				
				if($this->data['TutEvent']['allday'])
				{
					$sourcetime = $this->TutEvent->find('all', array(
						'conditions' => array(
								'TutEvent.start_date >=' => $alldaystime,
								'TutEvent.end_date <=' => $alldayetime,
								'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
							),
						'fields' => array('CONVERT_TZ(TutEvent.start_date,  "-05:00",  "'.$offset.'" ) as start_date','CONVERT_TZ(TutEvent.end_date,  "-05:00",  "'.$offset.'" ) as end_date'),
						'recursive'=>-1
					));
				}
				else
				{
					$sourcetime = $this->TutEvent->find('all', array(
						'conditions' => array(
							'TutEvent.start_date >=' => $finalstime,
							'TutEvent.end_date <=' => $finaletime,
							'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
						),
						'fields' => array('CONVERT_TZ(TutEvent.start_date,  "-05:00",  "'.$offset.'" ) as start_date','CONVERT_TZ(TutEvent.end_date,  "-05:00",  "'.$offset.'" ) as end_date'),
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
						$timestart = explode(' ', $sourcetime[$j][0]['start_date']);
						$timeend   = explode(' ', $sourcetime[$j][0]['end_date']);
						
						$finalstartdate = $srcplusone . ' ' . $timestart[1];
						
						$finalstartdate = $this->tgmt($finalstartdate,$this->Session->read('Member.timezone'));
						
						$finalenddate = $srcplusone . ' ' . $timeend[1];
						
						$finalenddate = $this->tgmt($finalenddate,$this->Session->read('Member.timezone'));						
						
						$result = $this->collapseevent($finalstartdate , $finalenddate);
					
						if($result=='true')
						{
							continue;
						}
						
						$this->TutEvent->create();
						
						$this->copyevent['TutEvent']['start_date'] = $finalstartdate;
						
						$this->copyevent['TutEvent']['end_date'] = $finalenddate;
						
						$this->copyevent['TutEvent']['tutor_id'] = $this->Session->read('Member.memberid');
						
					/*	echo '<pre>';
						print_r($this->copyevent);
						print_r($this->data);
						print_r($sourcetime);
						die;*/
						
						
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
		
	/*	echo '<pre>';
		print_r($_POST);*/
	
		
		$this->autoRender  = false;
		
		
		$offset = $this->Session->read('Member.offset');
		
		
		
		
	/*	$source_start_date = strtotime($this->data['TutEvent']['source_week_date']);
		$source_end_date   = strtotime(date("Y-m-d", $source_start_date) . " +7 days");
		
		
		$source_start_date = strtotime($this->data['TutEvent']['source_date']);
		$source_end_date   = $source_start_date;
		
		$start_on          = strtotime($this->data['TutEvent']['start_week_date']);
		$end_on            = strtotime($this->data['TutEvent']['end_week_date']);  */
		
		$endsRadio         = $this->data['TutEvent']['endsOn'];
		
		
	/*	$occur             = $this->data['TutEvent']['occur'];*/
		
		
	/*	echo '<pre>';
		print_r($this->data);
		die;*/
		
		
		
		
				$sourcedate = date("Y-m-d", strtotime($this->data['TutEvent']['source_date']));
				
			
				
				
				$stime = date("H:i:s",strtotime($this->data['TutEvent']['starttime']));
				$etime = date("H:i:s",strtotime($this->data['TutEvent']['endtime']));
				
				
				
				
				
		/*		$finalstime = $sourcedate.' '.$stime;
				$finaletime = $sourcedate.' '.$etime;*/
		
			
				$startdate = date("Y-m-d", strtotime($this->data['TutEvent']['start_week_date']));
				
				$alldaystime = date("Y-m-d H:i:s", strtotime("1 minutes",strtotime($this->data['TutEvent']['start_week_date'])));		
				
				$alldaystime = $this->tgmt($alldaystime,$this->Session->read('Member.timezone'));
				
				$alldayetime = date("Y-m-d H:i:s", strtotime("1439 minutes",strtotime($this->data['TutEvent']['start_week_date'])));
				
				$alldayetime = $this->tgmt($alldayetime,$this->Session->read('Member.timezone'));
				
				
				$replacedate = $this->data['TutEvent']['end_week_date'];
				
				$desdate = date('Y-m-d', strtotime($replacedate));
				
				
				$finalstime = $startdate.' '.$stime;
				
				$finalstime = $this->tgmt($finalstime,$this->Session->read('Member.timezone'));
				
				$finaletime = $startdate.' '.$etime;
				
				$finaletime = $this->tgmt($finaletime,$this->Session->read('Member.timezone'));
				
				/*echo $finalstime;
				echo $finaletime;*/
				
				
				
				if($this->data['TutEvent']['allday'])
				{
					$sourcetime = $this->TutEvent->find('all', array(
						'conditions' => array(
								'TutEvent.start_date >=' => $alldaystime,
								'TutEvent.end_date <=' => $alldayetime,
								'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
							),
						'fields' => array('CONVERT_TZ(TutEvent.start_date,  "-05:00",  "'.$offset.'" ) as start_date','CONVERT_TZ(TutEvent.end_date,  "-05:00",  "'.$offset.'" ) as end_date'),
						'recursive'=>-1
					));
				}
				else
				{
					$sourcetime = $this->TutEvent->find('all', array(
						'conditions' => array(
							'TutEvent.start_date >=' => $finalstime,
							'TutEvent.end_date <=' => $finaletime,
							'TutEvent.tutor_id' => $this->Session->read('Member.memberid')
						),
						'fields' => array('CONVERT_TZ(TutEvent.start_date,  "-05:00",  "'.$offset.'" ) as start_date','CONVERT_TZ(TutEvent.end_date,  "-05:00",  "'.$offset.'" ) as end_date'),
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
						$timestart = explode(' ', $sourcetime[$j][0]['start_date']);
						$timeend   = explode(' ', $sourcetime[$j][0]['end_date']);
						
						$finalstartdate = $srcplusone . ' ' . $timestart[1];
						
						$finalstartdate = $this->tgmt($finalstartdate,$this->Session->read('Member.timezone'));
						
						$finalenddate = $srcplusone . ' ' . $timeend[1];
						
						$finalenddate = $this->tgmt($finalenddate,$this->Session->read('Member.timezone'));
						
						$result = $this->collapseevent($finalstartdate , $finalenddate);
					
						if($result=='true')
						{
							continue;
						}
						
						$this->TutEvent->create();
						
						$this->copyevent['TutEvent']['start_date'] = $finalstartdate;
						
						$this->copyevent['TutEvent']['end_date'] = $finalenddate;
						
						$this->copyevent['TutEvent']['tutor_id'] = $this->Session->read('Member.memberid');
						
						/*echo '<pre>';
						print_r($this->copyevent);
						print_r($this->data);
						print_r($sourcetime);
						die;*/
						
						$this->TutEvent->Save($this->copyevent);
					}
				}
				
		

			
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'calendar'
			));
			
		
		
	}
	
	
	
	function selectaddevent() {
		$this->layout = "";
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$start = $_GET['var1'];
		$end   = $_GET['var2'];
		$allday   = $_GET['var3'];
		
//		echo $start.'lastdate'.$end.'allday'.$allday;
		
		
		$startexp = explode("GMT", $start);
		$endexp   = explode("GMT", $end);
		

		$start_formatted_date = date('Y-m-d H:i:s', strtotime($startexp[0]));
		
		$start_formatted_date = $this->tgmt($start_formatted_date,$this->Session->read('Member.timezone'));
		
		$end_formatted_date   = date('Y-m-d H:i:s', strtotime($endexp[0]));
		$end_formatted_date = $this->tgmt($end_formatted_date,$this->Session->read('Member.timezone'));
		
		
		
		$cookie_year = date('Y', strtotime($startexp[0]));
		$cookie_month = date('m', strtotime($startexp[0]));
		$cookie_day = date('d', strtotime($startexp[0]));
		
	     
		
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
		die;
		*/
	
		//$this->redirect(array('controller'=>'Members','action' => 'calendar'));
		
		
		$currentdate = date('Y-m-d H:i:s');
		
		$current_ts = strtotime($currentdate);
		
		$start_ts = strtotime($start_formatted_date);
		
		$end_ts = strtotime($end_formatted_date);
		
		$diffhours = $end_ts - $start_ts;
		
		$diffmin = round($diffhours / 60);
		
		$diff = $current_ts - $start_ts;
		
		
		/*	else if($diffmin <= 30 )
		{
		$z = -4;	 
		echo $z.','.$cookie_year.','.$cookie_month.','.$cookie_day;	
		}  */
		
		
		if($diff > 0 )
		{	
			$x= -2; 
			echo $x.','.$cookie_year.','.$cookie_month.','.$cookie_day;	
		}
		else
		{
			if($addedYet==""){
				$this->TutEvent->Save($this->addevent);
				$id = $this->TutEvent->id;
				echo $id.','.$cookie_year.','.$cookie_month.','.$cookie_day;
			}
			else{
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
	
	*/
	
	//Searching for the tutor
	
	
	function non_profit_search() {
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
		
		$causeResult = $this->TutorRequestCause->find('all', array(
		'conditions' => array(
		'status' => '1',
		'cause_id' => $session_id
		),
		'recursive' => -1
		));
		
		foreach($causeResult as $cr)
		{
			
			$requestedtutor[] = $cr['TutorRequestCause']['tutor_id'];
			
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
			$this->data['TutorRequestCause']['cause_id'] = $causeid;
			$this->data['TutorRequestCause']['tutor_id'] = $tutorid;
			$this->data['TutorRequestCause']['req_cause'] = 1;
			$this->data['TutorRequestCause']['status']   = $status;
			$this->TutorRequestCause->save($this->data);
			
		}
		
		$this->Session->setFlash($request);
		$this->redirect(array(
			'controller' => 'members',
			'action' => 'non_profit_dashboard'
		));
	}
	
	
	
	// Function for autocomplete
	
function get_course_id() {
		$this->layout = false;
		
		Configure::write('debug', 0);
		$memberid = $this->Session->read('Member.memberid');
		$stdcourse = array();
		$stdcourseDetails = $this->StdCourse->find("all",array("conditions" =>array('StdCourse.member_id'=>$memberid )));
	
		foreach($stdcourseDetails as $stdcourseDetail):
		$stdcourse[]=$stdcourseDetail['StdCourse']['course'];
		endforeach;
	//	pr($stdcourse);die;
		


		
		$course = $this->TutCourse->find("list", array(
			'limit' => '10',
			"conditions" => array(
			//	"TutCourse.course_id NOT "=> $stdcourse, //,"TutCourse.course_id NOT" => $_GET['q'] . "%"
				"TutCourse.course_id LIKE " =>$_GET['q']. "%"
			),
			"fields" => "TutCourse.course_id,TutCourse.course_id",
			"order" => "TutCourse.course_id Asc"
		));
	
		if (!empty($course)) {
			foreach ($course as $key => $value) {
				echo "$key|$value\n";
				
			}
			
			
		} else {
			//echo "No Results Found";
		}
		
		die;
	}
	
	
	/*function get_course_id() {
		$this->layout = false;
		
		Configure::write('debug', 0);
		$memberid = $this->Session->read('Member.memberid');
		$stdcourse = array();
		$stdcourseDetails = $this->StdCourse->find("all",array("conditions" =>array('StdCourse.member_id'=>$memberid )));
	
		foreach($stdcourseDetails as $stdcourseDetail):
		$stdcourse[]=$stdcourseDetail['StdCourse']['course'];
		endforeach;
		//pr($stdcourse);die;
		
		$course = $this->TutCourse->find("list", array(
			'limit' => '10',
			"conditions" => array(
				"TutCourse.course_id NOT "=> $stdcourse, //,"TutCourse.course_id NOT" => $_GET['q'] . "%"
				"TutCourse.course_id LIKE " =>$_GET['q']. "%"
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
	
	*/
	function get_non_profit_name() {
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
		
		$memberData = $this->Member->find('first',array(
														'conditions'=>
														array('Member.id'=> $this->Session->read('Member.memberid')),
														'recursive'=> -1 
														)
										 );
	/*	echo '<pre>';
		print_r($memberData);
		
		
		
		die;*/
		
		
		
		if (isset($this->data)) {
			$this->Member->updateAll(array(
				'Member.school_id' => "'" . $this->data['Member']['school_id'] . "'"
			), array(
				'Member.id' => $this->Session->read('Member.memberid')
			));
			
			$schoolData = $this->School->find('first',array('conditions'=>
											  array('School.id'=> $this->data['Member']['school_id']),
											  'recursive'=>-1
											  )
								);
			
			$schoolchanged = '"'.'Your School has been changed to '.$schoolData['School']['school_name'].'"';
			
			
			/*if($memberData['Member']['school_id'])
			{
				$schoolchanged = '"'.'Your School has been changed to successfully'.'"';    	
			}
			else
			{
				$schoolchanged = '"'.'Your School has been changed to'.'"';    	
			}*/
			
		
			$this->Session->setFlash($schoolchanged);
			
		}
		
		$this->redirect(array(
			'controller' => 'members',
			'action' => 'student_dashboard'
		));
		
	}
	
	
	function non_profit_schoolinfo() {
		Configure::write('debug', 0);
		
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
			$this->Session->setFlash('School info has been saved successfully');
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'non_profit_dashboard'
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
		$staticdatas = $this->Page->find('all',array('order'=>array('Page.id DESC')));
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
			$this->data = $this->Page->read();
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
			$this->EmailTemplate->updateAll(array('EmailTemplate.html_content' => "'".mysql_real_escape_string($this->data['EmailTemplate']['html_content'])."'" , 'EmailTemplate.title'=> "'". mysql_real_escape_string($this->data['EmailTemplate']['title']) ."'" , 'EmailTemplate.subject'=> "'". mysql_real_escape_string($this->data['EmailTemplate']['subject']) ."'" ),array('EmailTemplate.id'=>$this->data['Member']['staticid']));
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
	
	
	
	function admin_non_profit_view() {
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
	
	
	function admin_edit_non_profit_schoolinfo($id = NULL) {
		Configure::write('debug', 0);
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
			
			$data['Member']['email']  = $this->data['Member']['email'];
			$data['Member']['group_id']  = $this->data['Member']['group_id'];
			$data['Member']['active']    = $this->data['Member']['status'];
			$data['Member']['id']        = $this->data['Member']['id'];
			$data['Member']['school_id'] = $this->data['Member']['school_id'];
			$data['Member']['fname']  = $this->data['userMeta']['fname'];
			$data['Member']['lname']  = $this->data['userMeta']['lname'];
			
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
		
		$this->Session->delete('Member.group_id');
		
		/*if(!$this->Session->read('Member.memberid'))
		{
			$this->facebook_login();
		}*/
		
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
			
	/*		$this->Member->updateAll(array(
				'Member.group_id' => "'" . $id . "'"
			), array(
				'Member.facebookId' => $this->Session->read('Member.id'),
				'Member.active !=' => 3
			));*/
			
			
			$this->Session->write('Member.group_id', $id);
			
			$this->redirect(array(
				'controller' => 'homes',
				'action' => 'registration'
			));
			
		}
		
		
	}
	
	function img_upload() {
		
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
		
		
		
		
		$medHeight = '169';
		$medWidth  = '245';
		App::Import('Component', 'Upload');
		//print_r($_FILES);die;exit;
		
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
					
					
					$tmpimage = $newImgName . "." . $ext;
					
					$this->Member->updateAll(array('Member.image_name'=>"'".$tmpimage."'"),
												array('Member.id'=>$this->Session->read('Member.memberid'))
												);
					
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
						echo $newImgName . "." . $ext . "##success";
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
	
	function book_tutor_time($id = NULL ) {
		$this->layout = 'frontend';
		
		Configure::write('debug', 0);
		
	/*	if($this->Session->read('Member.memberid'))
		{
			
		$studentdata = $this->Member->find('first',array('conditions'=>array(
																			 'Member.id' => $this->Session->read('Member.memberid')
																			 )
														 )
										   );
		
		
		if($studentdata['Member']['creditable_balance']<=0)
			{
				
				$this->Session->setFlash('Insufficient balance please recharge you balance.');
				
				$this->redirect(array('controller'=>'members','action'=>'add_fund'));
				
			}	
			
		}*/
		
		
		
		$defaultCourse = $this->Session->read('tutorsearch.courseIdSelect');
		$this->set('defaultCourse',$defaultCourse);
		
		if($id)
		{
			
			$offset = $this->Session->read('Member.offset');
			
			$tutevent     = $this->TutEvent->find('all', array(
				'conditions' => array(
					'TutEvent.tutor_id' => $id,
					'TutEvent.start_date >=' => date('Y-m-d')
				),
				'fields' => array('CONVERT_TZ(TutEvent.start_date,  "-05:00",  "'.$offset.'" ) as start_date','CONVERT_TZ(TutEvent.end_date,  "-05:00",  "'.$offset.'" ) as end_date','TutEvent.id','TutEvent.title'),
				'order' => 'TutEvent.start_date ASC',
				'recursive' => -1
				
			));
			
			/*echo '<pre>';
			print_r($tutevent);
			die;*/
			
			
			if(!empty($tutevent))
			{
				  $startdate = $tutevent[0][0]['start_date'];
				  
				  $day = date("j", strtotime($startdate));
				  $month = date("n", strtotime($startdate));
				  $month = $month - 1;
				  $year = date("Y", strtotime($startdate));
				  
				  $this->set('day',$day);
				  $this->set('month',$month);
				  $this->set('year',$year);
			}

			
			/*$startarray = explode("-", $startdate);
			echo '<pre>';
			print_r($startarray);
			die;*/
			
			
			
		
			$this->set('tutevent', $tutevent);
			
				$tutorcourse = $this->TutCourse->find('all', array(
				'conditions' => array(
					'TutCourse.member_id' => $id
				),
				'order' => 'TutCourse.course_id ASC',
				'recursive' => -1
			));
				
	/*		echo '<pre>';
			print_r($tutorcourse);
			die;
			*/
		
			
			$this->set('tutorcourse', $tutorcourse);
			$charge = $this->Charge->find('first',array('conditions'=>array('Charge.id'=>1)));
			$this->set('charge',$charge);
		
			
			
			$this->Session->write('booktutor.tutorid', $id);
			
		}
		
	}
	
	function selecttutortime() {
		$this->layout     = "";
		$this->autoRender = false;
		Configure::write('debug', 0);
		
			if (isset($_REQUEST['courseid'])) {
			$courseid = $_REQUEST['courseid'];
			
			$tutcourse = $this->TutCourse->find('first', array(
				'conditions' => array(
					'TutCourse.id' => $courseid
				),
				'recursive' => -1
			));
			
			
			$charge = $this->Charge->find('first',array('conditions'=>array('Charge.id'=>1)));
			$this->set('charge',$charge);
			
			$this->Session->write('booktutor.coursename', $tutcourse['TutCourse']['course_id']);
			
			$course_rate = ($tutcourse['TutCourse']['rate']+(($tutcourse['TutCourse']['rate']*$charge['Charge']['tutorcause_charge'])/100));
			
			$this->Session->write('booktutor.rate', $course_rate);
			
		}
		
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
		
		die;
		
		
		
	}
	
	
	function fetch_tutor_hours() {
		
		
		$this->layout = '';
		
		$id = $_REQUEST['id'];
		
		/*	
		echo $id;
		die;
		
		echo $id;*/
		
		
		$offset = $this->Session->read('Member.offset');
		
		$bookedtime = $this->TutEvent->find('first', array(
			'conditions' => array(
				'TutEvent.id' => $id
			),
			'fields' => array('CONVERT_TZ(TutEvent.start_date,  "-05:00",  "'.$offset.'" ) as start_date','CONVERT_TZ(TutEvent.end_date,  "-05:00",  "'.$offset.'" ) as end_date','TutEvent.id','TutEvent.title'),
		));
		
		
		$start_ts = strtotime($bookedtime[0]['start_date']);
		
		$end_ts = strtotime($bookedtime[0]['end_date']);
		
		$diff = $end_ts - $start_ts;
		
		$diffhours = $diff / 3600;
		
		$count = $diffhours;
		
		$count = $count - 0.5;
		
		
		
		//	return round($diff / 86400);		
		
		$this->set('count', $count);
		
		$this->set('bookedtime', $bookedtime);
		
		
	}
	
	
	function send_session_request() {
		
		$this->layout     = "";
		$this->autoRender = false;
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
		
/*		if (isset($_POST['booked']) && $_POST['booked'] == 1) {
*/			
			$timezone = $this->Session->read('Member.timezone');
			
			$this->data['PaymentHistory']['student_id']          = $student_id;
			$this->data['PaymentHistory']['tutor_id']            = $tutor_id;
			$this->data['PaymentHistory']['booked_course']       = $booked_course;
			$this->data['PaymentHistory']['booked_start_time']   = date('Y-m-d H:i:s', $unix_start_time);
			
			$this->data['PaymentHistory']['booked_start_time'] = $this->tgmt($this->data['PaymentHistory']['booked_start_time'],$timezone);
			
			$this->data['PaymentHistory']['booked_end_time']     = date('Y-m-d H:i:s', $unix_end_time);
			
			$this->data['PaymentHistory']['booked_end_time'] = $this->tgmt($this->data['PaymentHistory']['booked_end_time'],$timezone);
			
			$this->data['PaymentHistory']['tutor_rate_per_hour'] = $tutor_rate_per_hour;
			$this->data['PaymentHistory']['tutoring_hours']      = $tutoring_hours;
			$this->data['PaymentHistory']['tut_event_id']        = $tut_event_id;
			$this->data['PaymentHistory']['session_status']      = 'Booked';
			$this->PaymentHistory->save($this->data);
			$paymentid = $this->PaymentHistory->id;
			$this->set('paymentid', $paymentid);
			
			$tutFees = $tutor_rate_per_hour * $tutoring_hours; 
			
			$tutFees = sprintf("%.2f", $tutFees );
			
			$requestMsg = "Your request has been sent to $tutName and amount charged is $tutFees.";
			
			$this->Session->setFlash($requestMsg);
			
			// To send a mail 
			
			$this->stdreq_email_template($paymentid);
			
			// End To send a mail 
			
			
			
		if($this->Session->read('Member.memberid'))
		{
			
			$studentdata = $this->Member->find('first',array('conditions'=>array(
																				 'Member.id' => $this->Session->read('Member.memberid')
																				 ),
															 'recursive'=> -1
															 )
											   );
			
		
		
			if(!empty($studentdata['Member']['stripeid']))
			{
				
					$this->redirect(array(
					'controller' => 'members',
					'action' => 'student_dashboard'
				));
				
				
			}
			else
			{
				
				$card_booking = $this->Page->find('first',array('conditions'=>array(
																					'Page.id'=>46
																					)
														)
												  );
				
				$phrase  = $card_booking['Page']['body'];
				$haystick = array("{[tutorname]}", "{[tutorfee]}");
				$replace   = array($tutName , $tutFees );
				
				$rechargeBal = str_replace($haystick, $replace, $phrase);
				
			/*	$rechargeBal =  "Before you can book a tutor we'll need to collect some payment information from you. TutorCause protects you by keeping the money safe until your session while avoiding the awkward exchange of money."."<br>".$bookedMsg; */
				
				$this->Session->setFlash($rechargeBal);
				
				$this->redirect(array('controller'=>'members','action'=>'add_fund'));
				
				
			
				
			}
			
		}
			
		die;	
			
		
		/*}*/
		
	}
	
		function stdreq_email_template($paymentid = null){
			
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;


	//	$this->PaymentHistory->unbindModel(array('belongsTo' => array('tutor','TutEvent')));
			
		$offsetdata = $this->PaymentHistory->find('first',array('conditions'=>
															 array('PaymentHistory.id'=> $paymentid),
															 'fields' => array('tutor.offset'),
															 )
											   );
		
		$offset = $offsetdata['tutor']['offset'];
		
		
		$paymentdata = $this->PaymentHistory->find('first',array('conditions'=>
															 array('PaymentHistory.id'=> $paymentid),
															 'fields' => array('tutor.email','student.fname','student.lname','tutor.fname','tutor.lname','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutoring_hours','PaymentHistory.tutor_rate_per_hour','student.email'),
															 )
											   );
		
		
	/*	echo '<pre>';
		print_r($paymentdata);
		die;*/

		
		$to	= $paymentdata['tutor']['email'];
		
		$this->Email->smtpOptions = array(
		'port'=>'465', 
		'timeout'=>'30',
		'auth' => true,
		'host' => 'ssl://smtp.sendgrid.net',
		'username'=>'tutorcause',
		'password'=>'fp9K81G16R1X84F',
		'client' => 'tutorcause.com' 
		);
		

		$this->set('smtp_errors', $this->Email->smtpError); 
		
		$this->Email->delivery = 'smtp';
	
	
		$email_template = $this->get_email_template(1);										
																							
		$this->Email->to = $to;
		
		$this->Email->replyTo = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->from = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->subject = $email_template['EmailTemplate']['subject'];
									
		$this->Email->sendAs = 'html';
		
		$this->Email->template = 1;
		
		
		$studentname = $paymentdata['student']['fname']. " " .$paymentdata['student']['lname'];
		$tutorname = $paymentdata['tutor']['fname']. " " .$paymentdata['tutor']['lname'];
		$starttime =  $paymentdata[0]['booked_start_time'];
		$formatstarttime = date('F j, Y @ h:i A',strtotime($starttime));
		$endtime =  $paymentdata[0]['booked_end_time'];
		$formatendtime = date('F j, Y @ h:i A',strtotime($endtime));
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
		$this->set('sendgrid', $to );
		$this->set('HTTP_ROOT', HTTP_ROOT );
		
		$email_template_content =  $this->render_email_template($email_template['EmailTemplate']['html_content']);
		
/*		echo '<pre>';
		print_r($email_template_content);
		die;
*/		
		$this->set('email_template_content',$email_template_content);	
		
		$this->Email->template = 'email_template';	
										
		$this->Email->send();
		
		
	
		
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
			echo "Message Sent";
			exit;
		}
	}
	
	
	
	function notices() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		if ($this->Session->read('Member.group_id') == 6) {
			$this->cause_element();
		} else if ($this->Session->read('Member.group_id') == 7) {
			$this->tutor_element();
		} else if ($this->Session->read('Member.group_id') == 8) {
			$this->student_element();
		} else if ($this->Session->read('Member.group_id') == 9) {
			$this->parent_element();
		}
		$this->paginate['Notice'] = array(
			'conditions' => array(
				'Notice.group_id  LIKE' => "%". $this->Session->read('Member.group_id') . "%"
				//'Notice.group_id' => $this->Session->read('Member.group_id')
			),
			'order' => array(
				'Notice.created DESC'
			),
			
			'limit' => 10
		);
		$noticeList	= $this->paginate('Notice');
		
		
	/*echo '<pre>';
	print_r($noticeList);
	die;*/
		
		
		$this->set('noticeList', $noticeList);
		if ($this->RequestHandler->isAjax()) {
			$this->layout     = '';
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
			$this->render('notice');
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
		} else if ($this->Session->read('Member.group_id') == 9) {
			$this->parent_element();
		}
		$this->paginate['TutMessage'] = array(
			'fields' => array(
				'*',
				'count(TutMessage.conversation_id) as conId',
				'min(TutMessage.status) as stas',
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
		
		
	/*echo '<pre>';
	print_r($msgList);
	die;*/
		
		
		$this->set('msgList', $msgList);
		if ($this->RequestHandler->isAjax()) {
			$this->layout     = '';
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
			$this->render('message');
		}
	}
	
	
	function outbox_message() {
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
		/*pr($msgList);
		die;*/
		
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
			),
			'order'=>array('TutMessage.datetime DESC'),
		));
		
		/*echo '<pre>';
		print_r($_REQUEST);
		print_r($content);
		die;
		*/
		
		$this->TutMessage->updateAll(array(
			'TutMessage.status' => "'1'"
		), array(
			'TutMessage.conversation_id' => $_REQUEST['conversation'],
			'TutMessage.to_id' => $this->Session->read('Member.memberid')
		));
		$this->set('content', $content);
	}
	
	function send_message() {
		
		
		$message =preg_replace("/AENUYTREBGF/","&",$_REQUEST['message']);
		//$message =str_replace("@1epo%","&",$message1);
		
		$data['TutMessage']['to_id']           = $_REQUEST['fromid'];
		$data['TutMessage']['from_id']         = $this->Session->read('Member.memberid');
		$data['TutMessage']['conversation_id'] = $_REQUEST['conversation'];
		$data['TutMessage']['subject']         = $_REQUEST['subject'];
		$data['TutMessage']['message']         = $message;
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
			echo "Message Sent";
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
					
					
					$this->redirect($this->referer());
					
					
			     //		$this->checkuserstep($this->Session->read('Member.id'));
					
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
				$TutRating['comments'] = $this->data['Member']['comments'];
				
				$this->TutRating->create();
				$this->TutRating->save($TutRating);
				$this->Session->delete('rating');
				

			
		$payment_id = $this->data['Member']['paymentId'];
		
		$rating = $this->TutRating->find('count',array(
													   'conditions'=>array('TutRating.payment_id'=>$payment_id),
													   'recursive'=> -1
													   )
										 );
		
		
		
		
			if($rating)
			{
				
			/*	echo $rating;
				die;*/
				
				$getAmount = $this->PaymentHistory->find('first', array(
				'conditions' => array('PaymentHistory.id' => $payment_id )
				));
				
				if ($this->PaymentHistory->updateAll(array(
					'PaymentHistory.session_status' => "'Completed'",
					'PaymentHistory.paypal_status' => "'complete'"
				), array(
					'PaymentHistory.id' => $getAmount['PaymentHistory']['id']
				))) {
					
				//	echo 'balance update';
					
					$this->Member->updateAll(array(
						'Member.creditable_balance' => ('Member.creditable_balance+' . $getAmount['PaymentHistory']['amount']),
						'Member.balance' => ('Member.balance-' . $getAmount['PaymentHistory']['amount'])
					), array(
						'Member.id' => $getAmount['PaymentHistory']['tutor_id']
					));
				}
				
			}
		
				
				$this->redirect($this->referer());
				
			} else {
				$this->Session->setFlash('Please rate both, knowledge and ability');
				$this->redirect($this->referer());
				
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
		
		$causeResult = $this->TutorRequestCause->find('all', array(
		'conditions' => array(
		'TutorRequestCause.status' => '1',
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
							
							
							$eventid = $this->PaymentHistory->find('first',array('conditions'=>array(
																							'PaymentHistory.id'=>$paymentid
																							)
																		 )
														   );
					
				
							$this->TutEvent->updateAll(array(
							'TutEvent.title' => "'Booked'",
							), array(
							'TutEvent.id' => $eventid['PaymentHistory']['tut_event_id']
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
					
					
				/*	$eventid = $this->PaymentHistory->find('first',array('conditions'=>array(
																							'PaymentHistory.id'=>$paymentid
																							)
																		 )
														   );
					
				
					$this->TutEvent->updateAll(array(
					'TutEvent.title' => "'Booked'",
					), array(
					'TutEvent.id' => $eventid['PaymentHistory']['tut_event_id']
					));*/
					
					
					$this->booked_event($paymentid);
					
					
					$this->Member->updateAll(array(
						'Member.creditable_balance' => "Member.creditable_balance-" . $amount
					), array(
						'Member.id' => $this->Session->read('Member.memberid')
					));
					$this->Session->delete('payment');
					$this->Session->setFlash('Payment successfully!');
					
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
		
		$offset = $this->Session->read('Member.offset'); 
		
		$paydata = $this->PaymentHistory->find('first', array(
			'conditions' => array(
				'PaymentHistory.id' => $paymentid
			),
			'fields'=>array('PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
		));
		
		$this->set('paydata', $paydata);
		
	}
	
	
	function stdcnfm_email_template($paymentid = null){
		
		
				Configure::write('debug', 0);
				$this->layout     = '';
				$this->AutoRender = false;
				
				$offsetdata = $this->PaymentHistory->find('first',array('conditions'=>
															 array('PaymentHistory.id'=> $paymentid),
															 'fields' => array('student.offset'),
															 )
											   );
		
				$offset = $offsetdata['student']['offset'];
				
				
				$paymentdata   = $this->PaymentHistory->find('first', array(
					'conditions' => array(
					'PaymentHistory.id' => $paymentid
					),
					'fields' => array('student.email','student.fname','student.lname','tutor.fname','tutor.lname','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutoring_hours','PaymentHistory.tutor_rate_per_hour','tutor.email'),
				));
				
				$to  = $paymentdata['student']['email'];
				
				$this->Email->smtpOptions = array(
				'port'=>'465', 
				'timeout'=>'30',
				'auth' => true,
				'host' => 'ssl://smtp.sendgrid.net',
				'username'=>'tutorcause',
				'password'=>'fp9K81G16R1X84F',
				'client' => 'tutorcause.com' 
				);
				
		
				$this->set('smtp_errors', $this->Email->smtpError); 
				
				$this->Email->delivery = 'smtp';		
		
			    $email_template = $this->get_email_template(2);										
																									
				$this->Email->to = $to;
				
				$this->Email->replyTo = "TutorCause<notifications@tutorcause.com>";
				
				$this->Email->from = "TutorCause<notifications@tutorcause.com>";
				
				$this->Email->subject = $email_template['EmailTemplate']['subject'];
											
				$this->Email->sendAs = 'html';
				
				$this->Email->template = 2;
	
		
		$studentname = $paymentdata['student']['fname']. " " .$paymentdata['student']['lname'];
		$tutorname = $paymentdata['tutor']['fname']. " " .$paymentdata['tutor']['lname'];
		$starttime =  $paymentdata[0]['booked_start_time'];
		$formatstarttime = date('F j, Y @ h:i A',strtotime($starttime));
		$endtime =  $paymentdata[0]['booked_end_time'];
		$formatendtime = date('F j, Y @ h:i A',strtotime($endtime));
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
		$this->set('sendgrid', $to );
		$this->set('HTTP_ROOT', HTTP_ROOT );
		
		$email_template_content =  $this->render_email_template($email_template['EmailTemplate']['html_content']);
		
		$this->set('email_template_content',$email_template_content);	
		
		$this->Email->template = 'email_template';		
		
	/*	echo '<pre>';
		echo $this->Email->to;
		print_r($email_template_content);
		print_r($paymentdata);
		die;*/
		
		$this->Email->send();		
		
	}
	
	function tutcnf_email_template($paymentid = null){
		
			Configure::write('debug', 0);
			$this->layout     = '';
			$this->AutoRender = false;
			
			
			$offsetdata = $this->PaymentHistory->find('first',array(
														'conditions'=>array('PaymentHistory.id'=> $paymentid),
														'fields' => array('tutor.offset'),
														)
													  );
			
			$offset = $offsetdata['tutor']['offset'];
			
		
			$paymentdata   = $this->PaymentHistory->find('first', array(
						'conditions' => array(
							'PaymentHistory.id' => $paymentid
						),
						'fields' => array('tutor.email','student.fname','student.lname','tutor.fname','tutor.lname','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutoring_hours','PaymentHistory.tutor_rate_per_hour','student.email'),
					));
		
			$to = $paymentdata['tutor']['email'];
			
			$this->Email->smtpOptions = array(
				'port'=>'465', 
				'timeout'=>'30',
				'auth' => true,
				'host' => 'ssl://smtp.sendgrid.net',
				'username'=>'tutorcause',
				'password'=>'fp9K81G16R1X84F',
				'client' => 'tutorcause.com' 
				);
				
		
			$this->set('smtp_errors', $this->Email->smtpError); 
			
			$this->Email->delivery = 'smtp';		
			
					
		//	$email_template = $this->get_email_template('tutor_confirmation');										
		
			$email_template = $this->get_email_template(4);										
			
			$this->Email->to = $to;
			
			$this->Email->replyTo = "TutorCause<notifications@tutorcause.com>";
			
			$this->Email->from = "TutorCause<notifications@tutorcause.com>";
			
			$this->Email->subject = $email_template['EmailTemplate']['subject'];
										
			$this->Email->sendAs = 'html';
			
			$this->Email->template = 4;
		
		
		$studentname = $paymentdata['student']['fname']. " " .$paymentdata['student']['lname'];
		$tutorname = $paymentdata['tutor']['fname']. " " .$paymentdata['tutor']['lname'];
		$starttime =  $paymentdata[0]['booked_start_time'];
		$formatstarttime = date('F j, Y @ h:i A',strtotime($starttime));
		$endtime =  $paymentdata[0]['booked_end_time'];
		$formatendtime = date('F j, Y @ h:i A',strtotime($endtime));
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
		$this->set('sendgrid', $to );
		$this->set('HTTP_ROOT', HTTP_ROOT );
		
		$email_template_content =  $this->render_email_template($email_template['EmailTemplate']['html_content']);
	
			
		$this->set('email_template_content',$email_template_content);	
		
		$this->Email->template = 'email_template';			
		
	/*	echo '<pre>';
		echo $this->Email->to;
		print_r($paymentdata);
		print_r($email_template_content);
		die;*/
									
		$this->Email->send();		
		
		
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
		
		$offset = $this->Session->read('Member.offset'); 
		
		$charge = $this->Charge->find('first',array('conditions'=>array('Charge.id'=>1)));
		$this->set('charge',$charge);
		
		
	//	$this->PaymentHistory->unbindModel(array('belongsTo' => array('tutor','TutEvent')));
		
		$sessionResult = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Booked',
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid'),
				'student.active' => 1
			),
			'fields'=>array('student.id','student.showImage','student.image_name','student.facebookId','student.fname','student.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
			'order'=>array('PaymentHistory.booked_start_time DESC'),
		  'recursive' => 2
		));

	/*	echo '<pre>';
		print_r($sessionResult);
		die;*/
	
		$this->set('sessionResult', $sessionResult);
		
		
		
	}
	
	
	function session_request_pay()
	{
		
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;

		
		App::import('Vendor', 'stripephp', array('file' => 'stripephp'.DS.'lib'.DS.'Stripe.php'));
		
		// set your secret key: remember to change this to your live secret key in production
		// see your keys here https://manage.stripe.com/account
		
		Stripe::setApiKey(STRIPEID);
		
		//live
	//	Stripe::setApiKey("STXx0V2iZwH17qPszOID8zCyItKRzWAH");
		// tesing
	//	Stripe::setApiKey("hzKG6oNLVXaJpipg5j2AWqv0gl90MQZi");
		
		
		if (count($this->data)) {
			
			
			if (isset($this->data['Member']['accept'])) {
				
			
			// To send email	
				
			$paymentid = $this->data['Member']['id'];
			
			
			$this->tutreq_email_template($paymentid);
	
			//End To send email
			
			
			$this->PaymentHistory->unbindModel(array('belongsTo' => array('tutor','TutEvent')));
		
			$amtpaymentdata = $this->PaymentHistory->find('first',array('conditions'=>
																 array('PaymentHistory.id'=> $paymentid),
																 'recursive'=> 2,
																 'fields'=>array('student.stripeid','student.creditable_balance','student.id','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours','PaymentHistory.tutor_id',)
																 )
												   );
			
			
			/*echo '<pre>';
			print_r($amtpaymentdata);
			die;*/
			$charge = $this->Charge->find('first',array('conditions'=>array('Charge.id'=>1)));
			$this->set('charge',$charge);
		
			$customerId = $amtpaymentdata['student']['stripeid'];
			$balance = $amtpaymentdata['student']['creditable_balance'];
			$studentId = $amtpaymentdata['student']['id'];
			$checkamount =  $amtpaymentdata['PaymentHistory']['tutor_rate_per_hour'];
			$amount =  $amtpaymentdata['PaymentHistory']['tutoring_hours'] * $amtpaymentdata['PaymentHistory']['tutor_rate_per_hour'];			
			$amount = sprintf("%.2f",$amount );
			
			$tut_net_rate = (($amtpaymentdata['PaymentHistory']['tutor_rate_per_hour']*100 )/((100+($charge['Charge']['tutorcause_charge']))));
			$amount1 = $tut_net_rate*$amtpaymentdata['PaymentHistory']['tutor_rate_per_hour'];
				
			
			/*$amtpaymentid = $this->data['Member']['id'];
			$amtpaymentdata = $this->PaymentHistory->find('first',array('conditions'=>
																 array('PaymentHistory.id'=> $amtpaymentid),
																 'recursive'=> 2
																 )
												   );
			
			$checkamount =  $amtpaymentdata['PaymentHistory']['tutor_rate_per_hour'];*/
			
			
			if($checkamount==0)
			{
				if($this->PaymentHistory->updateAll(array(
					'PaymentHistory.session_status' => "'Paided'"
				), array(
					'PaymentHistory.id' => $this->data['Member']['id']
				)))
				{
					
					
				/*	$eventid = $this->PaymentHistory->find('first',array('conditions'=>array(
																							'PaymentHistory.id'=>$paymentid
																							)
																		 )
														   );
					
				
					$this->TutEvent->updateAll(array(
					'TutEvent.title' => "'Booked'",
					), array(
					'TutEvent.id' => $eventid['PaymentHistory']['tut_event_id']
					));*/
					
					
					$this->booked_event($paymentid);
		
				
					$this->tutcnf_email_template($paymentid);
					
				
					$this->stdcnfm_email_template($paymentid);
				/*	
					$this->redirect(array(
						'action' => 'tutor_dashboard'
					));*/
					
					
				}
				
				$this->Session->setFlash('Accepted successfully!');
				
			}
			else if($balance >= $amount)
			{
				
					
				if ($this->PaymentHistory->updateAll(array(
					'PaymentHistory.amount' => "'" . $amount . "'",
					'PaymentHistory.paypal_status' => "'complete'",
					'PaymentHistory.session_status' => "'Paided'"
				), array(
					'PaymentHistory.id' => $paymentid
				))) {
					
					
				/*	$eventid = $this->PaymentHistory->find('first',array('conditions'=>array(
																							'PaymentHistory.id'=>$paymentid
																							)
																		 )
														   );
					
				
					$this->TutEvent->updateAll(array(
					'TutEvent.title' => "'Booked'",
					), array(
					'TutEvent.id' => $eventid['PaymentHistory']['tut_event_id']
					));*/
					
					$this->booked_event($paymentid);				
					
					
					$this->Member->updateAll(array(
						'Member.creditable_balance' => "Member.creditable_balance-" . $amount
					), array(
						'Member.id' => $studentId
					));
				
					$getAmount = $this->PaymentHistory->find('first', array(
						'fields' => array(
							'SUM(PaymentHistory.tutor_rate_per_hour*PaymentHistory.tutoring_hours) AS amount',
							'PaymentHistory.tutor_id'
						),
						'conditions' => array(
							'PaymentHistory.id' => $paymentid
						)
					));
					
					
					$tutor_get_paid=($getAmount[0]['amount']*100)/(100+($charge['Charge']['tutorcause_charge']));
					
					$this->Member->updateAll(array(
						'Member.balance' => ('Member.balance+' . $tutor_get_paid)
					), array(
						'Member.id' => $getAmount['PaymentHistory']['tutor_id']
					));
					
				
					$this->tutcnf_email_template($paymentid);
					
				
					$this->stdcnfm_email_template($paymentid);
				
					
					
				}
			
				
			}
			else if($balance == 0 && $customerId != '')
			{
				
					
				//	$customerId = $getAmount['student']['stripeid'];
					
					$cent = $amount * 100;
					
					// charge the Customer instead of the card
					Stripe_Charge::create(array(
					  "amount" => $cent, # amount in cents, again
					  "currency" => "usd",
					  "customer" => $customerId)
					);
					
				
				
					if ($this->PaymentHistory->updateAll(array(
					'PaymentHistory.amount' => "'" . $amount . "'",
					'PaymentHistory.paypal_status' => "'complete'",
					'PaymentHistory.session_status' => "'Paided'"
				), array(
					'PaymentHistory.id' => $paymentid
				))) {
					
					
				/*	$eventid = $this->PaymentHistory->find('first',array('conditions'=>array(
																							'PaymentHistory.id'=>$paymentid
																							)
																		 )
														   );
					
				
					$this->TutEvent->updateAll(array(
					'TutEvent.title' => "'Booked'",
					), array(
					'TutEvent.id' => $eventid['PaymentHistory']['tut_event_id']
					));*/
					
						
					$this->booked_event($paymentid);
				
					
					$this->Member->updateAll(array(
						'Member.balance' => ('Member.balance+' . $amount1)
					), array(
						'Member.id' => $amtpaymentdata['PaymentHistory']['tutor_id']
					));
					
				
					$this->tutcnf_email_template($paymentid);
					
				
					$this->stdcnfm_email_template($paymentid);
					
					
					$this->Session->setFlash('Accepted successfully!');
					
					
					}
					
			
				
			}
			else
			{	
				$this->PaymentHistory->updateAll(array(
					'PaymentHistory.session_status' => "'Accepted'"
				), array(
					'PaymentHistory.id' => $this->data['Member']['id']
				));
				
				$this->Session->setFlash('Accepted successfully!');
				
			}
			
			
			$twiddla_result = $this->create_twiddla_meet($paymentid);
			
			
			$this->redirect(array(
					'action' => 'session_request'
				));
			
			
				
			} else {
				$this->PaymentHistory->updateAll(array(
					'PaymentHistory.session_status' => "'Rejected'"
				), array(
					'PaymentHistory.id' => $this->data['Member']['id']
				));
				$this->Session->setFlash('Rejected successfully!');
				$this->redirect(array(
					'action' => 'session_request'
				));
			}
		}
		
		
		
		die;
		
	}
	
	
	function tutreq_email_template($paymentid){
		
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;
		
		
		
		
	   $offsetdata = $this->PaymentHistory->find('first',array(
													'conditions'=>array('PaymentHistory.id'=> $paymentid),
													'fields' => array('student.offset'),
													)
												  );
		
		/*echo '<pre>';
		print_r($offsetdata);
		die;*/
		
		
		$offset = $offsetdata['student']['offset'];
		
		
		
		
		
		$paymentdata = $this->PaymentHistory->find('first',array('conditions'=>
																 array('PaymentHistory.id'=> $paymentid),
																 'fields' => array('student.email','student.fname','student.lname','tutor.fname','tutor.lname','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutoring_hours','PaymentHistory.tutor_rate_per_hour','tutor.email'),
																 )
												   );
		
		
		$to	 = $paymentdata['student']['email'];
		
			$this->Email->smtpOptions = array(
				'port'=>'465', 
				'timeout'=>'30',
				'auth' => true,
				'host' => 'ssl://smtp.sendgrid.net',
				'username'=>'tutorcause',
				'password'=>'fp9K81G16R1X84F',
				'client' => 'tutorcause.com' 
				);
				
		
				$this->set('smtp_errors', $this->Email->smtpError); 
				
				$this->Email->delivery = 'smtp';	
		
		
			$email_template = $this->get_email_template(3);								
																								
			$this->Email->to = $to;
			
			$this->Email->replyTo = "TutorCause<notifications@tutorcause.com>";
			
			$this->Email->from = "TutorCause<notifications@tutorcause.com>";
			
			$this->Email->subject = $email_template['EmailTemplate']['subject'];
										
			$this->Email->sendAs = 'html';
			
			$this->Email->template = 3;
			
			$studentname = $paymentdata['student']['fname']. " " .$paymentdata['student']['lname'];
			$tutorname = $paymentdata['tutor']['fname']. " " .$paymentdata['tutor']['lname'];
			$starttime =  $paymentdata[0]['booked_start_time'];
			$formatstarttime = date('F j, Y @ h:i A',strtotime($starttime));
			$endtime =  $paymentdata[0]['booked_end_time'];
			$formatendtime = date('F j, Y @ h:i A',strtotime($endtime));
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
			$this->set('sendgrid', $to );
			$this->set('HTTP_ROOT', HTTP_ROOT );
			
			$email_template_content =  $this->render_email_template($email_template['EmailTemplate']['html_content']);
			
			$this->set('email_template_content',$email_template_content);	
			
			$this->Email->template = 'email_template';	
			
			
		/*	echo '<pre>';
			print_r($paymentdata);
			print_r($this->Email->to);
			print_r($email_template_content);
			die;*/
		
										
			$this->Email->send();		
		
	}
	
	
	function get_session_request($type, $userType) {
		return $this->PaymentHistory->find('count', array(
			'conditions' => array(
				'PaymentHistory.' . $userType => $this->Session->read('Member.memberid'),
				'PaymentHistory.session_status' => $type,
				'student.active' => 1,
				'tutor.active' => 1
			)
		));
	}
	function student_awaiting_approval() {
		Configure::write('debug', 0);
		if (isset($this->data)) {
			$this->PaymentHistory->deleteAll(array(
				'PaymentHistory.id' => $this->data['Member']['id']
			));
			$this->Session->setFlash('Session request cancelled successfully!');
			$this->redirect(array(
				'action' => 'student_awaiting_approval'
			));
		}
		$this->layout = 'frontend';
		$this->student_element();
		
		$offset = $this->Session->read('Member.offset'); 
		
		$approvalAwaiting = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Booked',
				'PaymentHistory.student_id' => $this->Session->read('Member.memberid'),
				'tutor.active' => 1
			),
			'fields'=>array('tutor.id','tutor.showImage','tutor.image_name','tutor.facebookId','tutor.fname','tutor.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
			'order' => array('PaymentHistory.booked_start_time DESC'),
		//	'recursive' => 2
		));
		
		/*echo '<pre>';
		print_r($approvalAwaiting);
		die;
		*/
		
		$this->set('approvalAwaiting', $approvalAwaiting);
		
		
	}
	
	
	function student_awaiting_payment() {
		Configure::write('debug', 0);
		if (isset($this->data)) {
			$this->PaymentHistory->deleteAll(array(
				'PaymentHistory.id' => $this->data['Member']['id']
			));
			$this->Session->setFlash('Session request cancelled successfully!');
			$this->redirect(array(
				'action' => 'student_awaiting_payment'
			));
		}
		$this->layout = 'frontend';
		
		$this->student_element();
		
		$offset = $this->Session->read('Member.offset'); 
		
		$payemntAwaiting = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Accepted',
				'PaymentHistory.student_id' => $this->Session->read('Member.memberid'),
				'tutor.active' => 1
			),
			'fields'=>array('tutor.id','tutor.showImage','tutor.image_name','tutor.facebookId','tutor.fname','tutor.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
			'order' => array('PaymentHistory.booked_start_time DESC'),
		//	'recursive' => 2
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
		
		$offset = $this->Session->read('Member.offset'); 
		
		$upcomingSession = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Paided',
				'PaymentHistory.student_id' => $this->Session->read('Member.memberid'),
				'tutor.active' => 1
			),
			'fields'=>array('tutor.id','tutor.showImage','tutor.image_name','tutor.facebookId','tutor.fname','tutor.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
			'order' => array('PaymentHistory.booked_start_time DESC'),
			//'recursive' => 2
		));
		$this->set('upcomingSession', $upcomingSession);
		
	}
	
	function student_review_session() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		$this->student_element();
		
		$offset = $this->Session->read('Member.offset'); 
		
		$review = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Review',
				'PaymentHistory.student_id' => $this->Session->read('Member.memberid'),
				'tutor.active' => 1
			),
			'fields'=>array('tutor.id','tutor.showImage','tutor.image_name','tutor.facebookId','tutor.fname','tutor.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
			'order' => array('PaymentHistory.booked_start_time DESC'),
			'recursive' => 2
		));
		
		
	/*	echo '<pre>';
		print_r($review);
		die;*/
		
		
		$this->set('review', $review);
		//pr($completed);exit;
	}
	
	
	
	function student_completed_session() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		$this->student_element();
		
		$offset = $this->Session->read('Member.offset'); 		
		
		$this->paginate['PaymentHistory'] = array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Completed',
				'PaymentHistory.student_id' => $this->Session->read('Member.memberid'),
				'tutor.active' => 1
			),
			'fields'=>array('tutor.id','tutor.showImage','tutor.image_name','tutor.facebookId','tutor.fname','tutor.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
			'order' => array('PaymentHistory.booked_start_time DESC'),
			'limit'=> 5,
			'recursive' => 2
		);
		
		$completed = $this->paginate('PaymentHistory');
		
		/*$completed = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Completed',
				'PaymentHistory.student_id' => $this->Session->read('Member.memberid'),
				'tutor.active' => 1
			),
			'recursive' => 2
		));*/
		
		
		$this->set('completed', $completed);
		
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout     = '';
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
			$this->render('student_completed_session');
		}
		
		
		
		//pr($completed);exit;
	}
	function get_school_name() {
		$this->layout = false;
		
		Configure::write('debug', 0);
		///aaaaaa
		$school = $this->School->find("list", array(
			'limit' => '10',
			"conditions" => array(
				"School.school_name LIKE" => $_GET['q'] . "%",
				"School.status"=>'active'
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
	
	function tutor_non_profit() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		$this->tutor_element();
		
		$causeResult = $this->TutorRequestCause->find('all', array(
			'conditions' => array(
				'status' => '1',
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
			$totalGrant = $this->TutorRequestCause->find('first', array(
				'fields' => array(
					'SUM(TutorRequestCause.grant) as totalGrant'
				),
				'conditions' => array(
					'TutorRequestCause.tutor_id' => $this->Session->read('Member.memberid')
				)
			));
			
		/*	echo '<pre>';
			print_r($this->data);
			print_r($totalGrant);
			die;*/
			
			$total      = ($totalGrant[0]['totalGrant'] + $this->data['Member']['grant']) - $this->data['Member']['default'];
			
			if ((100 - $total) >= 0) {
				$this->TutorRequestCause->updateAll(array(
					'TutorRequestCause.grant' => $this->data['Member']['grant']
				), array(
					'TutorRequestCause.id' => $this->data['Member']['ctId']
				));
				$this->Session->setFlash('Donation updated!');
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'tutor_non_profit'
				));
			} else {
				$this->Session->setFlash('Donation exceeded');
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'tutor_non_profit'
				));
			}
		} else {
			$this->Session->setFlash('Invalid data');
			$this->redirect(array(
				'controller' => 'members',
				'action' => 'tutor_non_profit'
			));
		}
	}
	
	
/*	function update_balance() {
		
		Configure::write('debug', 0);

		$getAmount = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.booked_end_time <' => date('Y-m-d H:i:s'),
				'PaymentHistory.session_status' => 'Paided',
			)
		));
		
		if(count($getAmount))
		{
		foreach($getAmount as $ga)
			{
				$this->PaymentHistory->updateAll(array(
							'PaymentHistory.session_status' => "'Review'",
						), array(
							'PaymentHistory.id' => $ga['PaymentHistory']['id']
						));
		
			}
		}

	}*/
	
	function tutor_element() {
		
		
		Configure::write('debug', 0);
		
	//	$this->set('picture', $this->getProfilePic());
		
		$this->set('CountRequest', $this->getCauseRequest());
		$this->set('SessionRequest', $this->get_session_request('Booked', 'tutor_id'));
		$this->set('upcomingRequest', $this->get_session_request('Paided', 'tutor_id'));
		$this->set('paymentAwaiting', $this->PaymentHistory->find('count', array(
			'conditions' => array(
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid'),
				'PaymentHistory.session_status' => 'Accepted',
				'student.active' => 1
			))));
		
		$this->set('sessionReview', $this->get_session_request('Review', 'tutor_id'));
		
	//	$this->set('completedRequest', $this->get_session_request('Completed', 'tutor_id'));
		
		$countMsg = $this->TutMessage->find('count', array(
			'conditions' => array(
				'to_id' => $this->Session->read('Member.memberid'),
				'status' => '0'
			)
		));
		
//		$this->Member->unbindModel(array('hasMany' => array('TutEvent','TutCourse'))); 
		
		$getBalance = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			),
			'fields' => array('Member.balance','Member.creditable_balance','Member.id','Member.showImage','Member.image_name','Member.facebookId','Member.fname','Member.lname'), 
			'recursive' => -1
		));
		
		/*echo '<pre>';
		print_r($getBalance);
		die;*/
    
		 
		$tutorCourse = $this->TutCourse->find('all', array(
			'fields' => array('TutCourse.course_id'), 
			'conditions' => array(
				'TutCourse.member_id' => $this->Session->read('Member.memberid')
			),
			'order' => array('TutCourse.course_id ASC'),
			'recursive'=> -1
			)
		);
		
		
		$withdrawalreq = $this->TutorWithdrawal->find('first', array(
			'conditions' => array(
				'TutorWithdrawal.tutor_id' => $this->Session->read('Member.memberid')
			),
			'order' => array('TutorWithdrawal.id DESC'),
			'fields'=> array('TutorWithdrawal.status'),
			'recursive' => -1
			
		));
		
		
/*		echo '<pre>';
		print_r($withdrawalreq);
		die;*/
		
		
		if ($withdrawalreq['TutorWithdrawal']['status'] == 'Pending') {
			$pendingrequest = 1;
			
			$this->set('pendingrequest', $this->returnBoldCount($pendingrequest));
		}
		
		$this->set('getBalance', $getBalance);
		$this->set('tutorCourse',$tutorCourse);
		$this->set('countMsg', $countMsg);
		
		
	   $this->TutorRequestCause->unbindModel(array('belongsTo' => array('Member'))); 
	   
		
		$causeResult = $this->TutorRequestCause->find('all', array(
		'conditions' => array(
			'TutorRequestCause.status' => '1',
			'tutor_id' => $this->Session->read('Member.memberid')
		),
	//	'fields'=> array('TutorRequestCause.id','Cause.id','Cause.image_name'),
		'recursive' => 2,
		
		));
		
		/*echo '<pre>';
		print_r($causeResult);
		die;*/
		
		
		$this->set('causeResult', $causeResult);
		
		
		
		
	}
	
	function student_element() {
		// student dashboard leftside bar 
		
//		$this->set('picture', $this->getProfilePic());
		
		
		$countMsg   = $this->TutMessage->find('count', array(
			'conditions' => array(
				'to_id' => $this->Session->read('Member.memberid'),
				'status' => '0'
			)
		));
		
		$this->Member->unbindModel(array('hasMany' => array('TutEvent','TutCourse','UserImage'))); 
		
		$getBalance = $this->Member->find('first', array(
			 'fields' => array('showImage','image_name','facebookId','fname','lname','creditable_balance','stripeid'), 
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			)
		));
		
		
		$mytutor = $this->PaymentHistory->find('all', array(
			'conditions' => array(
			'PaymentHistory.session_status' => 'Completed',
			'PaymentHistory.student_id' => $this->Session->read('Member.memberid')
			),
			'fields' => array('DISTINCT PaymentHistory.tutor_id'),
			'recursive' => -1
		));
		
		
	/*	echo '<pre>';
		print_r($getBalance);
		print_r($mytutor);
		die;*/
		
		foreach($mytutor as $mt)
		{
			$tutorid[] = $mt['PaymentHistory']['tutor_id'];
		}
		
	//	$this->Member->unbindModel(array('hasMany' => array('TutEvent','TutCourse'))); 
		
		if(!empty($tutorid))
		{
			$mytutordata = $this->Member->find('all',array('conditions'=>
														   array('Member.id'=>$tutorid,
																 'Member.active' => 1),
														   'fields'=>array('Member.id','Member.facebookId','Member.fname','Member.lname','Member.showImage','Member.image_name'),
														   'recursive' => -1
														   )
											   );
			
			$this->set('mytutordata', $mytutordata);
		}
		
	/*	echo '<pre>';
		print_r($tutorid);
		print_r($mytutordata);
		die;*/
		
		$this->set('parentrequest',$this->countparent_request());
		
		$this->set('awaitingRequest', $this->get_session_request('Booked', 'student_id'));
		$this->set('paymentRequest', $this->get_session_request('Accepted', 'student_id'));
		$this->set('upcomingRequest', $this->get_session_request('Paided', 'student_id'));
		$this->set('reviewRequest', $this->get_session_request('Review', 'student_id'));
		$this->set('completedRequest', $this->get_session_request('Completed', 'student_id'));
		
		$this->set('getBalance', $getBalance);
		$this->set('countMsg', $countMsg);
		
	
		
		// end student dashboard leftside bar 
		
		
	}
	
	function cause_element() {
		
		Configure::write('debug', 0);
		
		
	//	$this->set('picture', $this->getProfilePic());
		
		
		$this->set('CountRequest', $this->returnBoldCount($this->getTutorRequest()));
		
		$memberid = $this->Session->read('Member.memberid');
		
		$amountraised = $this->non_profit_amount_raised($memberid);
		
		$this->userMeta->updateAll(array(
		'userMeta.amount_raised' => "'" . $amountraised . "'"
		), array(
		'userMeta.member_id' => $this->Session->read('Member.memberid')
		) 
		);
		
	/*	$this->userMeta->updateAll(array(
				'userMeta.creditable_balance' => 0
			), array(
				'userMeta.id' => $this->Session->read('Member.memberid')
			));
		*/
		
		
		
		$countMsg   = $this->TutMessage->find('count', array(
			'conditions' => array(
				'to_id' => $this->Session->read('Member.memberid'),
				'status' => '0'
			)
		));
		
		
		$this->Member->unbindModel(array('hasMany' => array('TutCourse','TutEvent','UserImage')));
		
		$getBalance = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid'),				
			),
			'fields'=> array('Member.id','Member.showImage','Member.image_name','Member.creditable_balance','userMeta.cause_name','userMeta.amount_raised','userMeta.goal'),
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
		
		
	/*	echo '<pre>';
		print_r($getBalance);
		print_r($withdrawalreq);
		die;*/
		
		
		
		if ($withdrawalreq['CauseWithdrawal']['status'] == 'Pending') {
			$pendingrequest = 1;
			
			$this->set('pendingrequest', $this->returnBoldCount($pendingrequest));
		}
		
		
		$this->TutorRequestCause->unbindModel(array('belongsTo' => array('Cause'))); 
		
		$tutorAmount = $this->TutorRequestCause->find('all', array(
			'conditions' => array(
				'status' => '1',
				'cause_id' => $this->Session->read('Member.memberid')
			),
			'fields' => array('TutorRequestCause.cause_id','TutorRequestCause.tutor_id','Member.id','Member.facebookId','Member.fname','Member.lname','Member.showImage','Member.image_name'),
			'recursive' => 1
		));
		
	/*	echo '<pre>';
		print_r($tutorAmount);
		die;*/
		
		$this->set('tutorAmount', $tutorAmount);
		
		
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
		
		$tutorcausefee = $this->Charge->find('first',array('conditions'=>
									array('Charge.id' => '1')
									)
							  );
		
		/*echo '<pre>';
		print_r($tutorcausefee);
		die;*/
		
		$charge = $tutorcausefee['Charge']['tutorcause_charge'];
		$charge_percent =  $tutorcausefee['Charge']['tutorcause_charge']/100;
		
	
		
		
		$this->set('charge',$charge);
		
		$amounts = array();
		
		$amounts['creditable']   = sprintf("%.2f",$getBalance['Member']['creditable_balance']);
		$amounts['adminAmount']  = $getBalance['Member']['creditable_balance'] * $charge_percent;
		$amounts['adminAmount'] = sprintf("%.2f",$amounts['adminAmount']);
		$amounts['actualAmonut'] = $getBalance['Member']['creditable_balance'] - $amounts['adminAmount'];
		$amounts['actualAmonut'] = sprintf("%.2f",$amounts['actualAmonut']);
		
		
	/*		echo 'tutorcause fee'.$charge.'<br>';
			echo $amounts['creditable'].'<br>';
			echo $amounts['adminAmount'].'<br>';
			echo $amounts['actualAmonut'].'<br>'; 
		die;*/
		
		
		//pr($amounts);exit;
		$this->set('amounts', $amounts);
		
		if (isset($this->data) && $amounts['creditable'] > 0) {
			$totalGrant = $this->TutorRequestCause->find('all', array(
				/*	'fields'=>array(
				'*',
				'(CauseTutor.grant/100*'.$amounts['actualAmonut'].") as CauseAmount"
				),*/
				'conditions' => array(
					'TutorRequestCause.tutor_id' => $this->Session->read('Member.memberid'),
					'TutorRequestCause.status' => 1,
					'TutorRequestCause.grant !=' => 0
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
				$causegrant['TutorToCause']['cause_id']      = $grantTotal['TutorRequestCause']['cause_id'];
				$causegrant['TutorToCause']['cause_grant']   = $grantTotal['TutorRequestCause']['grant'];
				$causeAmount = ($grantTotal['TutorRequestCause']['grant'] / 100) * $amounts['actualAmonut'];				
			/*	echo $causeAmount;
				die;*/				
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
		$totalGrant = $this->TutorRequestCause->find('all', array(
			/*	'fields'=>array(
			'*',
			'(CauseTutor.grant/100*'.$amounts['actualAmonut'].") as CauseAmount"
			),*/
			'conditions' => array(
				'TutorRequestCause.tutor_id' => $this->Session->read('Member.memberid'),
				'TutorRequestCause.status' => 1,
				'TutorRequestCause.grant !=' => 0
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
		
	/*	echo '<pre>';
		echo 'requestid'.$_REQUEST['requestId'];
		print_r($withdrawal);
		die;*/
		
		
		$tutorcausefee = $this->Charge->find('first',array('conditions'=>
								array('Charge.id' => '1')
								)
						  );
	
		/*echo '<pre>';
		print_r($tutorcausefee);
		die;*/
		
		$charge = $tutorcausefee['Charge']['tutorcause_charge'];
		$charge_percent =  $tutorcausefee['Charge']['tutorcause_charge']/100;
		
		$this->set('charge',$charge);
		$this->set('charge_percent',$charge_percent);
		
		
		
		
		
		
		$withdrawalCharity = $this->TutorToCause->find('all', array(
			'conditions' => array(
				'TutorToCause.withdrawal_id' => $requestId
			),
			'recursive'=> 2
		));
		
		
	//	echo"<pre>";print_r($withdrawalCharity);exit;
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
	function add_fund() {
		
		
		Configure::write('debug', 0);
		$this->set('myoldUrl',$_SERVER['HTTP_REFERER']);
		
		// for live https 
		/*if ($_SERVER['SERVER_PORT']!=443) {
			
			$securelink = HTTP_ROOTS.'members/add_fund';			
			$this->redirect($securelink);
		}*/
		
		
		
		$cms_add_fund_data = $this->Page->find('first',array('conditions'=>array('Page.id'=>'50')));
		$this->set('cms_add_fund_data',$cms_add_fund_data);
		
		if($this->Session->read('Member.memberid'))
		{
			$studentdata =  $this->Member->find('first',array('conditions'=>array(
														 'Member.id'=> $this->Session->read('Member.memberid')
																				  )
															  )
												);
	
			
			if(!empty($studentdata['Member']['stripeid']))
			{
				
				$securelink2 = HTTP_ROOTS.'members/add_fund2';			
				$this->redirect($securelink2);
				
			}
			
			
			
			$this->set('studentdata',$studentdata);
			
			
		}
		
		
		
		}
		
		
		function parent_fund()
		{
			
		// for live https 
		/*if ($_SERVER['SERVER_PORT']!=443) {
			
			$securelink = HTTP_ROOTS.'members/parent_fund';			
			$this->redirect($securelink);
		}*/

	
		Configure::write('debug', 0);
		
	
		
		
		$cms_add_fund_data = $this->Page->find('first',array('conditions'=>array('Page.id'=>'50')));
		$this->set('cms_add_fund_data',$cms_add_fund_data);
		
		$parentdata =  $this->Member->find('first',array('conditions'=>array(
														 'Member.id'=> $this->Session->read('Member.memberid')
																			  ),
														 'recursive'=> -1 
														  )
											);
		
		
		if(!empty($parentdata['Member']['stripeid']))
		{
			
			$securelink2 = HTTP_ROOTS.'members/parent_fund2';			
			$this->redirect($securelink2);
	
			
		}
		
			
		$this->set('parentdata',$parentdata);
			
			
		}
		
		function parent_fund2()
		{
			
			
		
		// for live https 
		/*if ($_SERVER['SERVER_PORT']!=443) {
			
			$securelink = HTTP_ROOTS.'members/parent_fund2';			
			$this->redirect($securelink);
		}*/
		
		
		
		Configure::write('debug', 0);
		
		$cms_add_fund_data = $this->Page->find('first',array('conditions'=>array('Page.id'=>'50')));
		$this->set('cms_add_fund_data',$cms_add_fund_data);
		
		
			if($this->Session->read('Member.memberid'))
				{
					$studentdata =  $this->Member->find('first',array('conditions'=>array(
																 'Member.id'=> $this->Session->read('Member.memberid')
																						  )
																	  )
														);
					
					$this->set('studentdata',$studentdata);
					
				}
			
			
		}
		
		
		
		function parent_stripe_sucess()
		{
			
			Configure::write('debug', 0);
			
			App::import('Vendor', 'stripephp', array('file' => 'stripephp'.DS.'lib'.DS.'Stripe.php'));
			
			// set your secret key: remember to change this to your live secret key in production
			// see your keys here https://manage.stripe.com/account
			
			// STRIPEID define in core.php this 
			
			Stripe::setApiKey(STRIPEID);
			
			/*echo $stripeid;
			die;*/
			
			//live
		//	Stripe::setApiKey("STXx0V2iZwH17qPszOID8zCyItKRzWAH");
			// tesing
		//	Stripe::setApiKey("hzKG6oNLVXaJpipg5j2AWqv0gl90MQZi");
			
			$token = $_POST['stripeToken'];	
			$amount = $_POST['amount'];
			$cent = $amount * 100;
			$card_type = $_POST['card_type'];
			
			if($token)
			{
				
			$addfund = array();
			
			/*if($stdemail)
			{
			$addfund['AddFund']['student_email'] = $stdemail;
			}
			else
			{
				
			}*/
			
			$parentEmail = $this->Member->find('first',array(
					'conditions'=>array(
					'Member.id' =>$this->Session->read('Member.memberid')
					),
				'recursive'=>-1
				));
			
			$addfund['ParentFund']['parent_id'] = $parentEmail['Member']['id'];
			$addfund['ParentFund']['amount'] = $amount;
			$addfund['ParentFund']['card_type'] = $card_type;
			$addfund['ParentFund']['payment_status']  = 'pending';

			$this->ParentFund->create();
			$this->ParentFund->save($addfund);
			$lastid = $this->ParentFund->getLastInsertId();
			
		/*	echo '<pre>';
			echo $paymentid;
			print_r($_POST);
			die;
				*/
				
			
			
				   
				$customerEmail = $parentEmail['Member']['email'];
				
				// get the credit card details submitted by the form
				// create a Customer
				$customer = Stripe_Customer::create(array(
				  "card" => $token,
				  "description" => $customerEmail)
				);
				
				// charge the Customer instead of the card
				Stripe_Charge::create(array(
				  "amount" => $cent, # amount in cents, again
				  "currency" => "usd",
				  "customer" => $customer->id)
				);
				
				
				// save the customer ID in your database so you can use it later
			//	saveStripeCustomerId($user, $customer->id);
				
				// later
			//	$customerId = getStripeCustomerId($user);
				
				$customerId = $customer->id;
				
				$this->Member->updateAll(array(
						'Member.stripeid' => "'" . $customerId . "'",
					), array(
						'Member.id' => $this->Session->read('Member.memberid')
					) //(conditions) where userid=schoolid
				);
				
			/*	$sucess_status = 'Sucess';
				
				$sucess_msg = "Status: $sucess_status  Customer Id: $customerId";
				
				$this->Session->setFlash($sucess_msg);*/
				
			
				//Update Table
				$confirmId  = "'" . $customerId . "'";
				$status	 = "'complete'";
				$id = $lastid;
				
				$this->ParentFund->updateAll(array(
				'ParentFund.stripe_id' => $confirmId,
				'ParentFund.payment_status' => $status,
				), array(
				'ParentFund.id' => $id
				));
				
				// email to student to claim money
				
			//	$this->verify_email_template($id,$name,$amount,$varifyText);
			
		/*		$this->AddFund->updateAll(
					array(
						'AddFund.approval_status' => "'Verified'",
						'AddFund.student_id'	=> $this->Session->read('Member.memberid')
					),
					array(
						'AddFund.id'=>$id
					)
				);*/
				
				$this->Member->updateAll(
						array(
							'Member.creditable_balance' => 'Member.creditable_balance+'.$amount
						),
						array(
							'Member.id'=>$this->Session->read('Member.memberid')
						)
					);
				
				
				$this->redirect(array(
								'controller' => 'homes',
								'action' => 'global_gateway_sucess'
							));
				
				
		/*		Stripe_Charge::create(array(
					"amount" => 3500, # $15.00 this time
					"currency" => "usd",
					"customer" => $customerId)
				);
				   
				   */
				   
					
				
			
			
			
			}
			else
			{
				
					$this->redirect(array(
						'controller' => 'homes',
						'action' => 'global_gateway_failure'
					));
				
				
			}
			
			
		
			
		
			
		}
		
		
		function parent_stripe_sucess2()
		{
		
		
		Configure::write('debug', 0);
		
		App::import('Vendor', 'stripephp', array('file' => 'stripephp'.DS.'lib'.DS.'Stripe.php'));
		
		// set your secret key: remember to change this to your live secret key in production
		// see your keys here https://manage.stripe.com/account
		
		Stripe::setApiKey(STRIPEID);
		
		//live
	//	Stripe::setApiKey("STXx0V2iZwH17qPszOID8zCyItKRzWAH");
		// tesing
	//	Stripe::setApiKey("hzKG6oNLVXaJpipg5j2AWqv0gl90MQZi");
		
//		$token = $_POST['stripeToken'];	
		$amount = $_POST['amount'];
		$cent = $amount * 100;
		
//		$buyer_name = $_POST['parentname'];
//		$stdemail = $_POST['studentemail'];
			
		$addfund = array();
		
		$parentEmail = $this->Member->find('first',array(
			'conditions'=>array(
			'Member.id' =>$this->Session->read('Member.memberid'),
			'Member.active' => 1
			),
		'recursive'=>-1
		));
		
		
	/*	echo '<pre>';
		print_r($studentEmail);
		print_r($_REQUEST);
		die;*/
		
		$addfund['ParentFund']['parent_id'] = $parentEmail['Member']['id'];
		$addfund['ParentFund']['amount'] = $amount;
		$addfund['ParentFund']['payment_status']  = 'pending';

		$this->ParentFund->create();
		$this->ParentFund->save($addfund);
		$lastid = $this->ParentFund->getLastInsertId();
		
		/*echo '<pre>';
		echo $paymentid;
		print_r($_POST);
		die;*/
		
		$customerId = $parentEmail['Member']['stripeid'];
		
			
			// charge the Customer instead of the card
			Stripe_Charge::create(array(
			  "amount" => $cent, # amount in cents, again
			  "currency" => "usd",
			  "customer" => $customerId)
			);
			
			
			// save the customer ID in your database so you can use it later
		//	saveStripeCustomerId($user, $customer->id);
			
			// later
		//	$customerId = getStripeCustomerId($user);
			
		/*	$sucess_status = 'Sucess';
			
			$sucess_msg = "Status: $sucess_status  Customer Id: $customerId";
			
			$this->Session->setFlash($sucess_msg);*/
			
		
			//Update Table
			$confirmId  = "'" . $customerId . "'";
			$saveamount	 = "'" . $amount  . "'";
			$status	 = "'complete'";
		//	$id = $addfundid;
			
			$this->ParentFund->updateAll(array(
			'ParentFund.stripe_id' => $confirmId,
			'ParentFund.amount' => $saveamount,
			'ParentFund.payment_status' => $status,
			), array(
			'ParentFund.id' => $lastid
			));
			
			// email to student to claim money
			
	//		$this->verify_email_template($id,$name,$amount,$varifyText);
	
			
			$this->Member->updateAll(
					array(
						'Member.creditable_balance' => 'Member.creditable_balance+'.$amount
					),
					array(
						'Member.id'=>$this->Session->read('Member.memberid')
					)
				);
			
			$this->redirect(array(
							'controller' => 'homes',
							'action' => 'global_gateway_sucess'
						));
			
			
	/*		Stripe_Charge::create(array(
				"amount" => 3500, # $15.00 this time
				"currency" => "usd",
				"customer" => $customerId)
			);
			   
			   */
		
	}
		
		
		
		
		
		function add_fund2()
		{
		
		// for live https
		/*if ($_SERVER['SERVER_PORT']!=443) {
			
			$securelink = HTTP_ROOTS.'members/add_fund2';			
			$this->redirect($securelink);
		}*/
		
		
		
		Configure::write('debug', 0);
		
		$cms_add_fund_data = $this->Page->find('first',array('conditions'=>array('Page.id'=>'50')));
		$this->set('cms_add_fund_data',$cms_add_fund_data);
		
		
			if($this->Session->read('Member.memberid'))
				{
					$studentdata =  $this->Member->find('first',array('conditions'=>array(
																 'Member.id'=> $this->Session->read('Member.memberid')
																						  )
																	  )
														);
					
					$this->set('studentdata',$studentdata);
					
				}
		
		}
	
	function fund_add($id = NULL) {
		
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
	
	function verify_email_template($id = NULL ,$parentname = NULL,$amount = NULL,$verifyCode = NULL){
		
		
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;
		
		
		$studentInfo = $this->AddFund->find('first',array(
									'conditions'=>array(
										'AddFund.id' => $id
									),
									'fields' => array('AddFund.student_email'),
								)
							);
		
	
		
		
		
		$to	  = $studentInfo['AddFund']['student_email'];
		
		
		$this->Email->smtpOptions = array(
			'port'=>'465', 
			'timeout'=>'30',
			'auth' => true,
			'host' => 'ssl://smtp.sendgrid.net',
			'username'=>'tutorcause',
			'password'=>'fp9K81G16R1X84F',
			'client' => 'tutorcause.com' 
			);
			
	
			$this->set('smtp_errors', $this->Email->smtpError); 
			
			$this->Email->delivery = 'smtp';	
		
		
		$email_template = $this->get_email_template(5);										
																									
		$this->Email->to = $to;
		
		$this->Email->replyTo = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->from = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->subject = $email_template['EmailTemplate']['subject'];
									
		$this->Email->sendAs = 'html';
		
		$this->Email->template = '5';
		
		$this->set('amount', $amount );
		$this->set('parentname', $parentname );
		$this->set('verifyCode', $verifyCode );
		$this->set('sendgrid', $to );
		$this->set('HTTP_ROOT', HTTP_ROOT );
		
		$email_template_content =  $this->render_email_template($email_template['EmailTemplate']['html_content']);
			
		$this->set('email_template_content',$email_template_content);	
		
		$this->Email->template = 'email_template';	
		
/*		echo '<pre>';
		print_r($studentInfo);
		echo $this->Email->to;
		print_r($email_template_content);		
		die;
*/									
		$this->Email->send();
		
	}
	
	
	
	
	function tutor_upcoming_session() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$this->tutor_element();
		
		
		$offset = $this->Session->read('Member.offset'); 
		
		$upcomingSession = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Paided',
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid'),
				'student.active' => 1
			),
			'fields'=>array('student.id','student.showImage','student.image_name','student.facebookId','student.fname','student.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
			'order'=>array('PaymentHistory.booked_start_time DESC'),
		//	'recursive' => 2
		));
		
	/*	echo '<pre>';
		print_r($upcomingSession);exit;*/
		
		$this->set('upcomingSession', $upcomingSession);
		
		
	}
	function non_profit_get_statement() {
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
		
		$offset = $this->Session->read('Member.offset'); 
		
		$this->paginate['PaymentHistory'] = array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Completed',
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid'),
				'student.active' => 1
			),
			'fields'=>array('student.id','student.showImage','student.image_name','student.facebookId','student.fname','student.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
			'order'=>array('PaymentHistory.booked_start_time DESC'),
			'limit'=> 5,
			'recursive' => 2
		);
		
		$completed = $this->paginate('PaymentHistory');
		
	/*	$completed = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Completed',
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid'),
				'student.active' => 1
			),
			'order'=>array('PaymentHistory.booked_start_time DESC'),
			'recursive' => 2
		));*/
		
		$this->set('completed', $completed);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout     = '';
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
			$this->render('tutor_completed_session');
		}
		
		
		
	}
	
	function tutor_review_session() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$this->tutor_element();
		
		$this->PaymentHistory->unbindModel(array('belongsTo' => array('tutor','TutEvent')));
		
		$offset = $this->Session->read('Member.offset'); 
		
		$review = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Review',
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid')
			),
			'order'=>array('PaymentHistory.booked_start_time ASC'),
			'fields'=>array('student.id','student.showImage','student.image_name','student.facebookId','student.fname','student.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
			'recursive' => 2
		));
		
	/*	echo '<pre>';
		print_r($review);
		die;*/
		
		$this->set('review', $review);
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
		
		
	/*	$memberInfo = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			),
			'recursive' => -1
		));*/
		
		$offset = $this->Session->read('Member.offset'); 
		
		$paydata    = $this->PaymentHistory->find('first', array(
			'conditions' => array(
				'PaymentHistory.id' => $paymentid
			),
			'fields'=>array('student.creditable_balance','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
			
		));
		
	//	$this->set('memberInfo', $memberInfo);
		
		$this->set('paydata', $paydata);
		
	/*	echo"<pre>";
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
			$this->Session->setFlash('Oops, something went wrong.  email was not removed from the list.');
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
				$this->Session->setFlash('Successfully added user to your list.  they will not be reflected in your list until the user confirms their subscription.');
			} else {
				$this->Session->setFlash('Oops, something went wrong.  email was not added to your user.');
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
				$this->Session->setFlash('Successfully added user to your list.  they will not be reflected in your list until the user confirms their subscription.');
			} else {
				$this->Session->setFlash('Oops, something went wrong.  email was not added to your user.');
			}
			$this->redirect(array(
				'action' => 'mailchimpview',
				'admin' => true
			));
		}
		
		
		
	}
	
	
	function non_profit_withdrawal() {
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
			$this->Session->setFlash('Your withdrawal request has been sent to admin.');
			
			$this->redirect(array(
				'action' => 'non_profit_dashboard'
			));
		} else {
			$this->Session->setFlash('Insufficient balance for withdrawal');
			
			$this->redirect(array(
				'action' => 'non_profit_dashboard'
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
	
	
	$source = $this->Session->read('Member.facebook_id');
	
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
														'Member.facebookId'=> $mutualid,
														'Member.active !=' => 3
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
	
	$targetname = $this->Member->find('first',array('conditions'=>array('Member.facebookId'=> $target,
																		'Member.active !=' => 3),
	'recursive'=> 0));
	
	$mutualname = $targetname['userMeta']['fname'].' '.$targetname['userMeta']['lname'];
	
	
	$msg = "There are no mutual friends between you and $mutualname";
	
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
		
	//	$this->PaymentHistory->unbindModel(array('belongsTo' => array('tutor','TutEvent')));
	
		$offset = $this->Session->read('Member.offset'); 
		
		$paymentAwaiting1 = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.session_status' => 'Accepted',
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid'),				
				'student.active' => 1
			),
			'fields'=>array('student.id','student.showImage','student.image_name','student.facebookId','student.fname','student.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutor_rate_per_hour','PaymentHistory.tutoring_hours'),
			'order'=>array('PaymentHistory.booked_start_time DESC'),
		//	'recursive' => 2
		));
		
		
	/*	echo '<pre>';
		print_r($paymentAwaiting1);
		die;*/
		
		
		
		$this->set('paymentAwaiting1', $paymentAwaiting1);
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
	
	function sendEmailAlert($to = NULL ,$toName = NULL ,$fromName = NULL ,$subject = NULL ,$message = NULL){
		
		
/*		$from = "Tutorcause notifications@tutorcause.com";
		$subject = "Tutor Cause ".$subject;
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= 'From:'.$from . "\r\n";
		//$headers .= 'BCc: promatics.ajayendra@gmail.com' . "\r\n";
		$template = "<div>
			<p>Dear ".$toName."</p>
			<p>You have recieved a message from ".$fromName."</p>
			<p><b>Subject:</b>".$subject."</p>
			<p><b>Message:</b> ".$message."</p>
			<a href='http://www.tutorcause.com/members/messages' target='_blank'>View this Message</a>
			</div>";
		//echo $template;exit;
		@mail($to, $subject, $template, $headers);*/
		
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;
	
			$this->Email->smtpOptions = array(
			'port'=>'465', 
			'timeout'=>'30',
			'auth' => true,
			'host' => 'ssl://smtp.sendgrid.net',
			'username'=>'tutorcause',
			'password'=>'fp9K81G16R1X84F',
			'client' => 'tutorcause.com' 
			);
			
			
			$this->set('smtp_errors', $this->Email->smtpError); 
			
			$this->Email->delivery = 'smtp';
	
	
		$email_template = $this->get_email_template(10);										
																							
		$this->Email->to = $to;
		
		$this->Email->replyTo = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->from = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->subject = $subject;
									
		$this->Email->sendAs = 'html';
		
		$this->Email->template = 10;
		
		$this->set('toName', $toName );
		$this->set('fromName', $fromName );
		$this->set('subject', $subject );
		$this->set('message', $message );
		$this->set('sendgrid', $to );
		$this->set('HTTP_ROOT', HTTP_ROOT );
		
		$email_template_content =  $this->render_email_template($email_template['EmailTemplate']['html_content']);
			
		$this->set('email_template_content',$email_template_content);	
		
		$this->Email->template = 'email_template';	
		
	/*	echo '<pre>';
		echo $this->Email->to;
		echo $this->Email->subject;
		print_r($email_template_content);
		echo '</pre>';
		die;*/
										
		$this->Email->send();
		
	}
	
	function nonprofit_search()
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
		
/*		date_default_timezone_set('America/Los_Angeles');

$script_tz = date_default_timezone_get();

if (strcmp($script_tz, ini_get('date.timezone'))){
    echo 'Script timezone differs from ini-set timezone.';
} else {
    echo 'Script timezone and ini-set timezone match.';
}
		
		
		
echo '<pre>';
$timezone_abbreviations = DateTimeZone::listAbbreviations();
print_r($timezone_abbreviations["acst"]);
die;*/

		
		
		
/*		Configure::write('debug', 0);
			
		echo Inflector::pluralize('search_engine');
		
		die;
*/		
		echo 'jaswant';
		
		
		echo '<pre>';
		
		print_r($_SESSION);
		
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
		
	
	
	function paypal_non_profit($withdrawalid = NULL )
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


function non_profit($id = NULL) {
	
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
			
			
			$tutorResult = $this->TutorRequestCause->find('all', array(
			'conditions' => array(
			'TutorRequestCause.status' => '1',
			'TutorRequestCause.cause_id' => $id,
			),
			'recursive' => 2
			));
			
				foreach($tutorResult as $tr)
					{
						$matchtutor[] = $tr['TutorRequestCause']['tutor_id']; 
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
			
		
			
			$tutorResult = $this->TutorRequestCause->find('all', array(
			'conditions' => array(
			'TutorRequestCause.status' => '1',
			'TutorRequestCause.cause_id' => $id,
			),
			'recursive' => 2
			));
			
				foreach($tutorResult as $tr)
					{
						$matchtutor[] = $tr['TutorRequestCause']['tutor_id']; 
						$matchtutor = array_unique($matchtutor);
					}
					
					
			}
				
		
			$this->paginate['Member'] = array(
			'conditions' => array(
				'Member.id' => $matchtutor,
			//	'Member.school_id' => $school_id,
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
				
			$tutorResult = $this->TutorRequestCause->find('all', array(
			'conditions' => array(
			'TutorRequestCause.status' => '1',
			'TutorRequestCause.cause_id' => $id
			),
			'recursive' => -1
			));
			
				foreach($tutorResult as $tr)
				{
					$matchtutor[] = $tr['TutorRequestCause']['tutor_id']; 
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
		
		// To calculate total amount raised
		
	/*		$alltutor = $this->TutorToCause->find('all', array(
			'conditions' => array(
				'TutorToCause.cause_id' => $id ,
				'TutorWithdrawal.status' => 'Approved'
			),
			'recursive' => 2
			
		));
		
		$this->set('alltutor', $alltutor);*/
		
	
			
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
		
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		$this->cause_element();
		
		$this->paginate['TutorRequestCause'] = array(
			'conditions' => array(
				'TutorRequestCause.status' => '0',
				'cause_id' => $this->Session->read('Member.memberid'),
				'req_tutor' => 1,
				'Member.active'=> 1
			),
			'limit'=> 5,
			'recursive' => 2
		);
		
		$tutorResult = $this->paginate('TutorRequestCause');
		
	/*	$tutorResult = $this->TutorRequestCause->find('all', array(
			'conditions' => array(
				'TutorRequestCause.status' => '0',
				'cause_id' => $this->Session->read('Member.memberid'),
				'Member.active'=> 1
			),
			'recursive' => 2
		));
		*/
		/*echo '<pre>';
		print_r($tutorResult);
		die;
		*/
		
		$this->set('tutorResult', $tutorResult);
		
		
		
		
		
		if (count($this->data)) {
		
			
			if (isset($this->data['Member']['accept'])) {
				
				$this->TutorRequestCause->updateAll(array(
					'TutorRequestCause.status' => "'1'"
				), array(
					'TutorRequestCause.id' => $this->data['Member']['id']
				));
				
				
				$data = $this->TutorRequestCause->find('first',array('conditions'=>array(
																'TutorRequestCause.id' => $this->data['Member']['id']
																		  ),
																'recursive'=>-1
														  )
											);
				 
				 
				 $causeid = $data['TutorRequestCause']['cause_id'];
				 $tutorid = $data['TutorRequestCause']['tutor_id'];
				 
				 $deleterequest = $this->TutorRequestCause->deleteAll(array(
						'TutorRequestCause.cause_id' => $causeid,
						'TutorRequestCause.tutor_id' => $tutorid,
						'TutorRequestCause.status' => 0,
					));
				 
				
				 
				 
				
			/*			
			
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
			
			*/
			 
				
				$this->Session->setFlash('Accepted successfully!');
				
				$this->redirect(array(
					'action' => 'tutor_request'
				));
				
			} else {
				
				$this->TutorRequestCause->delete($this->data['Member']['id']);
				$this->Session->setFlash('Deleted successfully!');
				
				$this->redirect(array(
					'action' => 'tutor_request'
				));
				
			}
		}
		
		
		
		if ($this->RequestHandler->isAjax()) {
		$this->layout     = '';
		$this->AutoRender = false;
		$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
		$this->render('tutor_request');
		}
		
		
		
		
		
		}
		
		
		
	
	function send_request_non_profit($id = NULL)
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
		
		$request = "Your request has been sent to $name";
		
	
		if (isset($id) && $groupid == 7) {
			$this->data['TutorRequestCause']['cause_id'] = $causeid;
			$this->data['TutorRequestCause']['tutor_id'] = $tutorid;
			$this->data['TutorRequestCause']['req_tutor'] = 1;
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
	
	function non_profit_amount_raised($id = NULL)
	{
	//	$this->TutorToCause->unbindModel(array('belongsTo' => array('Member','Tutor')));
		
		$causemoney = $this->TutorToCause->find('all', array(
			'conditions' => array(
				'TutorToCause.cause_id' => $id ,
				'TutorWithdrawal.status' => 'Approved'
			),
			'fields'=>array('TutorToCause.cause_amount'),
		));
		
		
		/*echo '<pre>';
		print_r($causemoney);
		die;*/
		
		
		$causeamount = 0;
		foreach($causemoney as $cm)
			{
			$causeamount =  $causeamount + $cm['TutorToCause']['cause_amount'];
			}
			
		return $causeamount;	
		
	}
	
	function tutor_give_non_profit($tutorid = NULL, $causeid = NULL )
	{
		
	//	$this->TutorToCause->unbindModel(array('belongsTo' => array('Member','Tutor')));
		
		$causemoney = $this->TutorToCause->find('all', array(
		'conditions' => array(
			'TutorToCause.cause_id' => $causeid ,
			'TutorToCause.tutor_id' => $tutorid ,
			'TutorWithdrawal.status' => 'Approved'
		),
		'fields'=>array('TutorToCause.cause_amount'),
//		'recursive' => 1
		
		));
		
		
		$causeamount = '';
		foreach($causemoney as $cm)
			{
			$causeamount =  $causeamount + $cm['TutorToCause']['cause_amount'];
			}
			
			
		/*echo '<pre>';
		echo $causeamount;
		echo 'jaswant';
		print_r($causemoney);
		die;*/
			
		return $causeamount;
		
	}
	
	
	
	function non_profit_tutors() {
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		$this->cause_element();
		$tutorResult = $this->TutorRequestCause->find('all', array(
			'conditions' => array(
				'TutorRequestCause.status' => '1',
				'cause_id' => $this->Session->read('Member.memberid')
			),
			'order' => array(
				'TutorRequestCause.grant DESC'
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
				'req_tutor' => 1,
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
				),
				'order' => array(
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
				$this->Session->setFlash('Successfully added user to your list.  they will not be reflected in your list until the user confirms their subscription.');
			} else {
				$this->Session->setFlash('Oops, something went wrong.  email was not added to your user.');
			}
			$this->redirect(array(
				'action' => 'school_requests',
				'admin' => true
			));
		}
	}
	
	
	function getMutualFriends($facebook, $uid1, $uid2){
    try {
        $param  =   array(
                    'method'  => 'friends.getMutualFriends',
                    'source_uid'    => $uid1,
                    'target_uid'  => $uid2,
                    'callback'=> ''
                );
        $mutualFriends   =   $facebook->api($param);
        return $mutualFriends;
    }
    catch(Exception $o) {
        //print_r($o);
    }
 
    return '';
}
	function facebookmutual1($target=NULL){
		Configure::write('debug', 0);
		$this->layout = false;
		//$this->AutoRender = false;
		App::import('Vendor', 'facebook', array('file' => 'facebook/facebook.php'));
		$facebook1 = new Facebook(array('appId'	=>	APPID,'secret' => SECRET ,));
		$accesstoken = $facebook1->getAccessToken();
		if($accesstoken == '') {
			$this->redirect(
				array(
					'controller' => 'members',
					'action' => 'logout'
				)
			);
		}
		$source = $this->Session->read('Member.facebook_id');
		$url = "https://api.facebook.com/method/friends.getMutualFriends?target_uid=$target&source_uid=$source&access_token=$accesstoken";
		
		$this->set('url',$url);
		$xml = simplexml_load_file($url);
		

		$myarray = get_object_vars($xml->children());
		//pr($myarray);exit;
		$uidList = array();
		if(isset($myarray['uid'])){
			if(count($myarray['uid'])==1){
				//$uidList[] = $myarray['uid'];
				$userinfo = file_get_contents('https://graph.facebook.com/'.$myarray['uid']);
				$user2array = json_decode($userinfo, true);
				$uidList[] = $user2array;
				//print_r($user2array);exit;
			} else {
				foreach($myarray['uid'] as $key => $value){
					$userinfo = file_get_contents('https://graph.facebook.com/'.$value);
					$user2array = json_decode($userinfo, true);
					$uidList[] = $user2array;
				}
				//$uidList = $myarray['uid'];
			}
			//pr($uidList);exit;
			$this->set('mutualfriends', $uidList);
		}
		
		unset($xml);  
		
		$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
		$this->render('mutual_friends');
	}
	
	
	
	function countfacebookmutual1($target=NULL){
		Configure::write('debug', 0);
		$this->layout = false;
		//$this->AutoRender = false;
		App::import('Vendor', 'facebook', array('file' => 'facebook/facebook.php'));
		$facebook1 = new Facebook(array('appId'	=>	APPID,'secret' => SECRET ,));
		$accesstoken = $facebook1->getAccessToken();
		if($accesstoken == '') {
			$this->redirect(
				array(
					'controller' => 'members',
					'action' => 'logout'
				)
			);
		}
		$source = $this->Session->read('Member.facebook_id');
		$url = "https://api.facebook.com/method/friends.getMutualFriends?target_uid=$target&source_uid=$source&access_token=$accesstoken";
		$xml = simplexml_load_file($url);
		$myarray = get_object_vars($xml->children());
		//pr($myarray);exit;
		$uidList = array();
		if(isset($myarray['uid'])){
			if(count($myarray['uid'])==1){
				//$uidList[] = $myarray['uid'];
				$userinfo = file_get_contents('https://graph.facebook.com/'.$myarray['uid']);
				$user2array = json_decode($userinfo, true);
				$uidList[] = $user2array;
				//print_r($user2array);exit;
			} else {
				foreach($myarray['uid'] as $key => $value){
					$userinfo = file_get_contents('https://graph.facebook.com/'.$value);
					$user2array = json_decode($userinfo, true);
					$uidList[] = $user2array;
				}
				//$uidList = $myarray['uid'];
			}
			//pr($uidList);exit;
			$this->set('mutualfriends', $uidList);
		}
		
		$num_mutual = count($uidList);
		
		return $num_mutual;
	/*	$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
		$this->render('mutual_friends');*/
	}
	
	
	
	
	function deletetutorscause($id = NULL)
	{
		Configure::write('debug', 0);
		$this->layout = false;
		
		$causedata =  $this->TutorRequestCause->find('first',array('conditions'=>
											  array('TutorRequestCause.id' => $id),
											  'recursive' => 2
											  )
								);
		
		$causename = $causedata['Cause']['userMeta']['cause_name'].' Successfully removed.';
		
		if($this->TutorRequestCause->delete($id))
		{
			$this->Session->setFlash($causename);
		}
		
		$this->redirect(array(
			'action' => 'tutor_non_profit',			
		));
		
	}
	
	function admin_allsession($memberid = NULL )
	{
		
		Configure::write('debug', 0);
		
		$id = convert_uudecode(base64_decode($memberid));
		
		$memberdata = $this->Member->find('first',array(
														'conditions'=>array('Member.id'=>$id)
																			)
										  );
		
		
		$this->layout = 'admin';
		
		$this->set("parentClass", "selected"); //set main navigation class
		
		
		if (isset($this->data)) {
		/*	$this->Session->write('tutorsession.tutorname', $this->data['PaymentHistory']['tutorname']);
			$this->Session->write('tutorsession.studentname', $this->data['PaymentHistory']['studentname']);
		*/	$this->Session->write('tutorsession.status', $this->data['PaymentHistory']['session_status']);
		
			$this->Session->write('tutorsession.perpage', $this->data['PaymentHistory']['perpage']);
			
			/*$this->data['PaymentHistory']['tutorname']    = $this->Session->read('tutorsession.tutorname');
			$this->data['PaymentHistory']['studentname']   = $this->Session->read('tutorsession.studentname');
			*/$this->data['PaymentHistory']['session_status']   = $this->Session->read('tutorsession.status');
		
			$this->data['PaymentHistory']['perpage']  = $this->Session->read('tutorsession.perpage');
			
		} else {
		//	$this->Session->delete('tutorsession');
		}
		
		if (strlen($this->Session->read('tutorsession.perpage')) > 0) {
			$this->data['PaymentHistory']['perpage'] = $this->Session->read('tutorsession.perpage');
		} else {
			$this->data['PaymentHistory']['perpage'] = 10;
		}
		
		$conditions = array();
		
		if(isset($this->data['PaymentHistory']['session_status']) && $this->data['PaymentHistory']['session_status']!='')
		{
			$conditions = array_merge($conditions, array(
				'PaymentHistory.session_status' => $this->data['PaymentHistory']['session_status'],
			));
		}
		
		
		/*if(isset($this->data['PaymentHistory']['tutorname']) && $this->data['PaymentHistory']['tutorname']!='')
		{
			$conditions = array_merge($conditions, array(
				'tutor.userMeta.fname like' => '%'.$this->data['PaymentHistory']['tutorname'].'%',
			));
		}
		
			if(isset($this->data['PaymentHistory']['studentname']) && $this->data['PaymentHistory']['studentname']!='')
		{
			$conditions = array_merge($conditions, array(
				'student.userMeta.fname like' => '%'.$this->data['PaymentHistory']['studentname'].'%',
			));
		}
		*/
		
		
		
		if($memberdata['Member']['group_id']==7)
		{
			$conditions = array_merge($conditions, array(
			'PaymentHistory.tutor_id' => $id
		));
		}
		else if($memberdata['Member']['group_id']==8)
		{
			$conditions = array_merge($conditions, array(
			'PaymentHistory.student_id' => $id
		));
			
		}
		
		$this->paginate['PaymentHistory'] = array(
			'conditions' => $conditions,
			'order' => array('PaymentHistory.session_status ASC'),
			'limit' => $this->data['PaymentHistory']['perpage'],
			'recursive' => 2
		);
		
		
	
		$tutoringsession = $this->paginate('PaymentHistory');
		
/*		echo '<pre>';
	    echo 'jaswant'.$id;
		print_r($memberdata);
		print_r($conditions);
		die;
*/		
		
		$this->set('tutoringsession', $tutoringsession);
		//pr($members); die;
		
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'members';
			$this->render('allsession');
		}
		
		
	}
	function delete() {
		
	/*	Configure::write('debug', 0);
		$this->autoRender = false;
		$this->layout = "";
		
		echo "deleted";*/
		
		$this->autoRender = false;
		$this->layout     = "";
		
		Configure::write('debug', 0);
		
		$id = $this->Session->read('Member.memberid');
		
		// id 4 means trash
		
		$activeid = 4;
			$this->Member->updateAll(array(
				'Member.active' => "'" . $activeid . "'"
			), array(
				'Member.id' => $id
			));
		
		echo "deleted";
			
	
	/*	if ($id) {
			
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
			
			
		} */
		
		
	
	
	}
	
	function admin_session_rating($id = NULL)
	{
		$this->layout = "admin";
		
		Configure::write('debug', 0);
		
		$rating = $this->PaymentHistory->find('first', array(
		'conditions' => array(
			'PaymentHistory.session_status' => 'Completed',				  
			'PaymentHistory.id' => $id
		),
		'recursive' => 2
		));
			
		$this->set('rating', $rating);
		
	}
	
function student_course()
	{
		Configure::write('debug', 0);
		
		$this->layout = 'frontend';
		$this->student_element();
		
			 $studentcourse1 =  $this->StdCourse->find('all',array('conditions'=>array(
																 'StdCourse.member_id'=> $this->Session->read('Member.memberid'),
																 ),
																 'recursive'=> -1
											 )
								 );
			 
			 foreach($studentcourse1 as $sc)
			 {
			    $courseArray[] = $sc['StdCourse']['course'];
			    
				 
			 }
		
		
		
		
		if(isset($this->data))
		{
			$course = $this->data['StdCourse']['course'];
		
			if (in_array($course, $courseArray)) {
				//$this->Session->setFlash('course already added');
			}
			else
			{
				$this->data['StdCourse']['member_id'] = $this->Session->read('Member.memberid');
				$this->StdCourse->save($this->data);
				$this->Session->setFlash('course added successfully');
			}
			
			
			
			
		}
		
		
		 $studentcourse =  $this->StdCourse->find('all',array('conditions'=>array(
																 'StdCourse.member_id'=> $this->Session->read('Member.memberid'),
																 ),
																 'recursive'=> -1
											 )
								 );
		
		
		
		
	
		 $this->set('studentcourse',$studentcourse);
		 

		
	}
	function selected_course($course = NULL )
	{
		
		if($course)
		{
			 $this->Session->write('tutorsearch.course_id', $course);	
		}
		
		if($_POST['course'])
		{
			$course_code = $_POST['course'];
			 $this->Session->write('tutorsearch.course_id', $course_code);		
		}
		
			 
			 $this->redirect(array(
						'controller' => 'members',
						'action' => 'tutorsearch'
					));
			 
	}
	
	
	function selecteditevent()
	{
		
		
	/*	echo '<pre>';
		print_r($_REQUEST);
		die;*/
		
	
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
														'TutEvent.tutor_id' => $this->Session->read('Member.memberid')),
												  	  'recursive' => -1
												  ));
		
		
		$compareend =	$this->TutEvent->find('all',array('conditions' =>
											  array(
													'TutEvent.id !='=>$id,
													'TutEvent.end_date between ? and ?' => array($start_formatted_date,$end_formatted_date),
													'TutEvent.tutor_id' => $this->Session->read('Member.memberid')),
											  		
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
	
	function checkcourseid()
	{
		
		
		
		$courseid = $_REQUEST['courseCode'];
		
		
		$course = $this->Course->find('all',array('conditions'=>array(
															'Course.course_id LIKE' => $courseid ."%",
															)
										)
							);
		
		if(count($course))
		{
			echo 'ok';
		}
		else
		{
			echo 'error';
		}
		
		die;
		
	}
	
	function search_tutor()
	{
		
		$this->Session->delete('tutorsearch');
		
		$this->redirect(array(
						'controller' => 'members',
						'action' => 'tutorsearch'
					));
		
	/*	$this->redirect(array(
						'controller' => 'members',
						'action' => 'designsearch'
					));
		*/
		
		
		
	}
	
	function yourpay()
	{
				
		
		Configure::write('debug', 0);
		
		
	/*	App::import('Vendor', 'globalpayment', array(
			'file' => 'globalpayment/lphp.php'
		));*/
		
/*
<!---------------------------------------------------------------------------------
* PHP_FORM_MIN.php - A form processing example showing the minimum 
* number of possible fields for a credit card SALE transaction.
*
* This script processes form data passed in from PHP_FORM_MIN.html
*
*
* Copyright 2003 LinkPoint International, Inc. All Rights Reserved.
* 
* This software is the proprietary information of LinkPoint International, Inc.  
* Use is subject to license terms.
*

		This program is based on the sample SALE_MININFO.php
		
		Depending on your server setup, this script may need to
		be placed in the cgi-bin directory, and the path in the
		calling file PHP_FORM_MIN.html may need to be adjusted
		accordingly.

		NOTE: older versions of PHP and in cases where the PHP.INI
		entry is NOT "register_globals = Off", form data can be
		accessed simply by using the form-field name as a varaible
		name, eg. $myorder["host"] = $host, instead of using the 
		global $_POST[] array as we do here. Passing form fields 
		as demonstrated here provides a higher level of security.

------------------------------------------------------------------------------------>
*/

//	include"lphp.php";
	
	App::Import('Component', 'Lphp');
	
	$mylphp=new LphpComponent();

	# constants
/*	$myorder["host"]       = "secure.linkpt.net";
	$myorder["port"]       = "1129";
	$myorder["keyfile"]    = "./YOURCERT.pem"; # Change this to the name and location of your certificate file 
	$myorder["configfile"] = "1234567";        # Change this to your store number 
*/	
	
	$myorder["host"]       = "staging.linkpt.net";
	$myorder["port"]       = "1129";
	
	// client first data
	$myorder["keyfile"]    = "1909551419.pem"; # Change this to the name and location of your certificate file 
	$myorder["configfile"] = "1909551419";        # Change this to your store number 
	
// jaswant first data
//	$myorder["keyfile"]    = "1909078235.pem"; # Change this to the name and location of your certificate file 
//	$myorder["configfile"] = "1909078235";        # Change this to your store number 
	
	
    
	/*echo '<pre>';
	print_r($this->data);
	die;*/
	
	$addfund = array();
	
	
	if($this->data['global']['studentEmail'])
	{
	$addfund['AddFund']['student_email'] = $this->data['global']['studentEmail'];
	}
	else
	{
		$studentEmail = $this->Member->find('first',array(
			'conditions'=>array(
			'Member.id' =>$this->Session->read('Member.memberid')
			),
		'recursive'=>-1
		));
		
		$addfund['AddFund']['student_email'] = $studentEmail['Member']['email'];		
	}
	$addfund['AddFund']['request_id']      = uniqid();
	$addfund['AddFund']['amount']          = $this->data['global']['chargetotal'];
	$addfund['AddFund']['payment_status']  = 'pending';
	$addfund['AddFund']['approval_status'] = 'Pending';
	$this->AddFund->create();
	$this->AddFund->save($addfund);
//	$this->Session->write('payment.amount', $this->data['Member']['amount']);
	$paymentid = $this->AddFund->getLastInsertId();
	
	
	/*echo $paymentid;
	die;*/
	
	

	# form data
	$myorder["cardnumber"]    = $this->data['global']['cardnumber'];
	$myorder["cardexpmonth"]  = $this->data['global']['cardexpmonth'];
	$myorder["cardexpyear"]   = $this->data['global']['cardexpyear'];
	$myorder["chargetotal"]   = $this->data['global']['chargetotal'];
	$myorder["ordertype"]     = $this->data['global']['ordertype'];
	$myorder["zip"]      = $this->data['global']['bzip'];	
	$myorder["name"]  = $this->data['global']['bname'];
	$myorder["oid"]   = $paymentid;
	
	$buyer_name = $this->data['global']['bname'];
	$ammount = $this->data['global']['chargetotal'];
	
/*	if($this->data['global']['cvmnotpres'])
	{
	$myorder["cvmindicator"] = 'not_provided';
	$myorder["cvmvalue"]     = $this->data['global']['cvm'];
	}
	else
	{
	$myorder["cvmindicator"] = 'provided';
	$myorder["cvmvalue"]     = $this->data['global']['cvm'];
	}
	
	*/
	
	

	/*if ($_POST["debugging"])
		$myorder["debugging"]="true";*/

  # Send transaction. Use one of two possible methods  #
//	$result = $mylphp->process($myorder);       # use shared library model
	$result = $mylphp->curl_process($myorder);  # use curl methods
	
	/*echo '<pre>';
	print_r($result);
	die;*/
	
	
	
	
	if ($result["r_approved"] != "APPROVED")    // transaction failed, print the reason
	{
		
	/*	print "Status:  $result[r_approved]<br>\n";
		print "Error:  $result[r_error]<br><br>\n";
	die;*/
		
		$fail_status = $result[r_approved];
		$fail_error = $result[r_error];
		
		$fail_msg = "Status: $fail_status  Error: $fail_error";
		
		$this->Session->setFlash($fail_msg);
		
		//Update Table
		$confirmId  = '"' . $fail_error . '"';
		$status	 = "'unable to process'"; 
		$id = $paymentid; 
		
		$this->AddFund->updateAll(array(
		'AddFund.paypal_confirm_id' => $confirmId,
		'AddFund.payment_status' => $status,
		), array(
		'AddFund.id' => $id
		));
		
		$this->redirect(array(
					'controller' => 'homes',
					'action' => 'global_gateway_failure'
				));
		
	}
	else	// success
	{		
	
	/*	print "Status: $result[r_approved]<br>\n";
		print "Transaction Code: $result[r_code]<br><br>\n";
		die;*/
		
		$sucess_status = $result[r_approved];
	//	$transaction_code = $result[r_code];
		$order_num = $result[r_ordernum];
		
		$sucess_msg = "Status: $sucess_status  Order Number: $order_num";
		
		$this->Session->setFlash($sucess_msg);
		
			
		//Update Table
		$confirmId  = "'" . $order_num . "'";
		$amount	 = "'" . $ammount  . "'";
		$name	   = "'" . $buyer_name  . "'";
		$status	 = "'complete'";
		$varifyText =md5(uniqid());
		$id = $paymentid;
		
		
		$this->AddFund->updateAll(array(
		'AddFund.paypal_confirm_id' => $confirmId,
		'AddFund.amount' => $amount,
		'AddFund.name' => $name,
		'AddFund.payment_status' => $status,
		'AddFund.varify_text' => "'".$varifyText."'"
		), array(
		'AddFund.id' => $id
		));
		
		// email to student to claim money
		
		$this->verify_email_template($id,$name,$amount,$varifyText);
		
		
		$this->Session->delete('payment');
		
    	
		$this->redirect(array(
						'controller' => 'homes',
						'action' => 'global_gateway_sucess'
					));
	
	}

# if verbose output has been checked,
# print complete server response to a table
	if ($_POST["verbose"])
	{
		echo "<table border=1>";

		while (list($key, $value) = each($result))
		{
			# print the returned hash 
			echo "<tr>";
			echo "<td>" . htmlspecialchars($key) . "</td>";
			echo "<td><b>" . htmlspecialchars($value) . "</b></td>";
			echo "</tr>";
		}	
			
		echo "</TABLE><br>\n";
	}
		
		
		
		
	}

	
	
	
	
	
	// unused functions 
	
	function global_payment()
	{
				
		Configure::write('debug', 0);	
		
	$data = $_POST;	
		
/*	echo '<pre>';
	echo 'post array';
	print_r($_POST);*/
	
	
	
	
	
		
	// attempt the charge (array $data, boolean $testing)
	$response = $this->Ggapi->ggProcess($data, true);
	
	
	echo 'response array from webserver';
	print_r($response);
	die;
	
	
	

	// update the order table with the response
	if ($response) {
		if ($response['r_approved'] == 'APPROVED') {
			// merge the response data with the order data
			$this->data['Order'] = array_merge($this->data['Order'], $response);
		} else {
			// card was DECLINED
			$error = explode(':', $response['r_error']);
			$this->Session->setFlash(
				'Your credit card was declined. The message was: '.$error[1],
				'modal',
				array('class' => 'modal error')
			);
			$this->redirect(array('controller' => 'members', 'action' => 'checkout'));
		}
	} else {
		// no response from the gateway
		$this->Session->setFlash(
			'There was a problem connecting to our payment gateway, please try again.',
			'modal',
			array('class' => 'modal error')
		);
		$this->redirect(array('controller' => 'members', 'action' => 'checkout'));
	}
	
	}
	
	function checkout()
	{
		

		
		
		
	}
	
	function first_data_payment()
	{
		
	
	
	
	}
	
	
	function first_data_sucess()
	{
		
	   /*$fundid =  $this->Session->read('payment.fundId');
	    $student_email =  $this->Session->read('payment.student_email');*/
		
		Configure::write('debug', 0);
		
	/*	echo '<pre>';
		print_r($_SESSION);
		die;
		*/
		
		
	    $ammount =  $this->Session->read('payment.amount');
		$id =  $this->Session->read('payment.paymentId');
		
						if (isset($id) && $id!='') {
								
								//Update Table
								$status	 = "'complete'";
								$varifyText =md5(uniqid());
								
								//End
								$this->AddFund->updateAll(array(
									'AddFund.paypal_confirm_id' => "'Global_Gateway'",
									'AddFund.payment_status' => $status,
									'AddFund.varify_text' => "'".$varifyText."'"
								), array(
									'AddFund.id' => $id
								));
								
								// email to student to claim money
								
								$this->verify_email_template($id,'name',$ammount,$varifyText);
								
								// end email to student to claim money
								
								
								$this->Session->delete('payment');
							
						}
				
					$this->redirect(array('controller'=>'homes','action'=>'success'));	
						
	}
	

	
	
		// designer function 
	
	function tutorsearch()
	{
		
	/*	echo '<pre>';
		print_r($_POST);
		die;*/
		
		
		Configure::write('debug', 0);
		
		$charge = $this->Charge->find('first',array('conditions'=>array('Charge.id'=>1)));
		$this->set('charge',$charge);
		
		
		$schoolid = $this->Member->find('first',array('conditions'=>
												  array(
														'Member.id'=>$this->Session->read('Member.memberid')
													),
												  'fields'=>array('Member.school_id'),
												  'recursive'=> -1
												  )
									);
		
		$school_id = $schoolid['Member']['school_id']; 
		
		$link = HTTP_ROOT.'members/student_schoolinfo';

		$selectMsg = "<a href=\"$link\" style=\"color: #1B8FD8; text-decoration:underline;\">Select your school</a>";
	
		if(!$school_id)
		{
			$this->Session->setFlash($selectMsg);
		}
		
		
			
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
																	'DISTINCT TutEvent.tutor_id',
																	),
													'conditions'=>array('TutEvent.start_date >'=> date('Y-m-d H:i:s')),
													'order'=>'TutEvent.start_date DESC'
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
		//pr($allfinaltutor);
		//die;
		
		
		foreach($allfinaltutor as $aft)
		{
			$matchtutor[] = $aft['Member']['id']; 
			
		}
		
		
		
	/*	echo '<pre>';
		echo $school_id;
		print_r($alltutorevent);
	
		print_r($uniquealltutor);
	
		print_r($allfinaltutor);
		print_r($matchtutor);

		echo '</pre>';			
		die;
		
		*/
	
	
	
	
		
		
		
		
		
		
		
		if (isset($this->data)) {
			$this->Session->write('tutorsearch.course_id', $this->data['TutCourse']['course_id']);	
			$this->Session->write('tutorsearch.sun', $this->data['TutCourse']['sun']);			
			$this->Session->write('tutorsearch.mon', $this->data['TutCourse']['mon']);			
			$this->Session->write('tutorsearch.tue', $this->data['TutCourse']['tue']);			
			$this->Session->write('tutorsearch.wed', $this->data['TutCourse']['wed']);			
			$this->Session->write('tutorsearch.thu', $this->data['TutCourse']['thu']);			
			$this->Session->write('tutorsearch.fri', $this->data['TutCourse']['fri']);			
			$this->Session->write('tutorsearch.sat', $this->data['TutCourse']['sat']);			
			
		/*	echo '<pre>';
			print_r($this->data);
			die;*/
		} else {
			
			
		}
		
		
		for($i=0;$i<7;$i++)
			{
				
			 $d = date("d-m-y",strtotime("+$i day")); 
			 $w= date("l", strtotime("+$i day")) ;
			 
			switch ($w)
				{
				case 'Sunday':
				$this->set('Sunday',$d);
				break;	
				case 'Monday':
				$this->set('Monday',$d);
				break;
				case 'Tuesday':
				$this->set('Tuesday',$d);
				break;
				case 'Wednesday':
				$this->set('Wednesday',$d);
				break;
				case 'Thursday':
				$this->set('Thursday',$d);
				break;
				case 'Friday':
				$this->set('Friday',$d);
				break;
				case 'Saturday':
				$this->set('Saturday',$d);
				break;
				}
		
			}
		
		
		
		
		$courseid  = $this->Session->read('tutorsearch.course_id');
		
		$sun = $this->Session->read('tutorsearch.sun');
		$mon = $this->Session->read('tutorsearch.mon');
		$tue = $this->Session->read('tutorsearch.tue');
		$wed = $this->Session->read('tutorsearch.wed');
		$thu = $this->Session->read('tutorsearch.thu');		
		$fri = $this->Session->read('tutorsearch.fri');
		$sat = $this->Session->read('tutorsearch.sat');
		
		$alldays = array($sun,$mon,$tue,$wed,$thu,$fri,$sat);
		$filteralldays = array_filter($alldays);
		
		/*
		echo '<pre>';
		print_r($alldays);
		print_r(array_filter($alldays));
		die;*/
		
		
	 
		
		if ($courseid!='' || count($filteralldays)>0 ) {
			
			$this->Session->write('tutorsearch.courseIdSelect',$courseid);
			
		/*	$date_array = getdate(); // no argument passed so today's date will be used
			foreach ( $date_array as $key => $val ) {
			print "$key = $val<br/>";
			}*/
			
		//	$day =  $date_array['weekday'];
		//	echo 'day'.$day;
		
			
		//	$date = date("Y-m-d");// current date
			
		//	echo "<pre>";print_r($startTime);exit;
			
			$tutorid = $this->TutEvent->find('all', array(
				'order' =>'TutEvent.start_date ASC',
				'conditions' => array(
					'TutEvent.tutor_id' => $matchtutor,	
					'TutEvent.title' => 'Available',	
					'TutEvent.start_date >' => date('Y-m-d H:i:s'),				  
					"DATE_FORMAT(TutEvent.start_date,'%d-%m-%y')" => $filteralldays ,
				),
				'fields'=>array('DISTINCT TutEvent.tutor_id')
			));
			
	

			
/*			
			$this->paginate['TutCourse'] = array(
				'conditions' => array(
					'TutCourse.course_id' => $courseid,
					'TutCourse.member_id' => $matchtutor
				),
				'fields'=>array(
								'DISTINCT TutCourse.member_id',
								),
				'recursive' => -1,				
			);
			
			$filtertutor = $this->paginate('TutCourse');
*/			
			$filtertutor = $this->TutCourse->find('all',array('conditions'=>array(
														'TutCourse.course_id' => $courseid,
														'TutCourse.member_id' => $matchtutor
																			 ),
														'fields'=>array('DISTINCT TutCourse.member_id'),
														'recursive'=> -1
														)
												  );
			
			
			$searchtutor = array();
			foreach($tutorid as $td)
			{
			
			$searchtutor1[] = $td['TutEvent']['tutor_id'];
			
			}
			
			foreach($filtertutor as $ft)
			{
				
			$searchtutor2[] = $ft['TutCourse']['member_id'];
			
			}
			
			if(count($searchtutor1)==0 && count($searchtutor2)>0)
			{ 
				
			//  $searchtutor = array_push($searchtutor2); 	
				$searchtutor = $searchtutor2; 	
			}
			else if(count($searchtutor2)==0 && count($searchtutor1)>0)
			{
  			//  $searchtutor = array_push($searchtutor1); 	
			  $searchtutor = $searchtutor1; 	
			  
			}
			else if(count($searchtutor1)>0 && count($searchtutor2)>0)
			{
			$searchtutor = array_intersect($searchtutor1, $searchtutor2);
			}
			
			$searchtutor = array_unique($searchtutor);
			
	/*		echo '<pre>';
			echo 'searchtuttor1';
			print_r($searchtutor1);
			echo 'searchtuttor2';
			print_r($searchtutor2);
			echo 'searchtuttor';
			print_r($searchtutor);
			die;
			*/
			
		/*	echo '<pre>';
			print_r($filtertutor);
			print_r($searchcourse);
			die;*/
			
			$this->Member->unbindModel(array('hasMany' => array('TutEvent')),false);
			
			$this->paginate['Member'] = array(
			'conditions' => array(
				'Member.id' => $searchtutor,
				'Member.active' => 1
			),
			
			'fields'=>array('Member.id','Member.facebookId','Member.showImage','School.school_name','userMeta.fname','userMeta.lname','userMeta.biography'),
			'limit' => 5,
			'recursive'=>1
			);
			
						
			$filtertutor1 = $this->paginate('Member');
			
			
			
			
			if(count($filtertutor1)==0)
			{
				$this->Session->setFlash('No Tutor found.');
			}
			
		}
		else
		{
			
			
			$this->Member->unbindModel(array('hasMany' => array('TutEvent')),false);
			
			$this->paginate['Member'] = array(
			'conditions' => array(
				'Member.id' => $matchtutor,
				'Member.active' => 1
			),
			
			'fields'=>array('Member.id','Member.facebookId','Member.showImage','School.school_name','userMeta.fname','userMeta.lname','userMeta.biography'),
			'limit' => 5,
			'recursive'=>1
			
			
			);
			
			$filtertutor1 = $this->paginate('Member');

		}
		
		
		$this->Member->unbindModel(array('hasMany' => array('TutEvent')));
		
			
		if($_REQUEST['tutorid'])
		{
			
			$id = $_REQUEST['tutorid'];
			
			
			$watchtutor =  $this->Member->find('first',array(
									'conditions'=>array(
														'Member.id'=>$id,
														'Member.active' => 1),
									'fields'=>array('Member.id','Member.facebookId','Member.showImage','School.school_name','userMeta.fname','userMeta.lname','userMeta.biography'),
									'recursive'=>1					 
															  )
								);
			
			
			
		
		$total = 0;
	
		$allcourse = $this->TutCourse->find('all',array(
										   'conditions'=> array('TutCourse.member_id'=>$id),
										   'fields'=>array('TutCourse.rate'),
										   ));
		
		
		
		
		$count = count($allcourse); //total numbers in array
	
		foreach ($allcourse as $value) {
		$total = $total + $value['TutCourse']['rate']; // total value of array numbers
		}
		$average = ($total/$count); // get average value
		
		$average = (integer)$average;
		
		
		$this->set('average',$average);
			
		}
		else
		{
			
			$id = $filtertutor1[0]['Member']['id'];
			
			$watchtutor =  $this->Member->find('first',array(
												'conditions'=>array('Member.id'=>$id,
																	'Member.active' => 1),
												'fields'=>array('Member.id','Member.facebookId','Member.showImage','School.school_name','userMeta.fname','userMeta.lname','userMeta.biography'),
												'recursive'=>1					 
																				 
																  )
								);
			
			
   		$total = 0;
	
		$allcourse = $this->TutCourse->find('all',array(
										   'conditions'=> array('TutCourse.member_id'=>$id),
										   'fields'=>array('TutCourse.rate'),
										   ));
		
		
		
		
		$count = count($allcourse); //total numbers in array
	
		foreach ($allcourse as $value) {
		$total = $total + $value['TutCourse']['rate']; // total value of array numbers
		}
		$average = ($total/$count); // get average value
		
		$average = (integer)$average;
		
		
		$this->set('average',$average);
			
			
		}
		
		
		
	/*	echo '<pre>';
		print_r($filtertutor1);
		print_r($watchtutor);
		die;*/
		
		$this->set('watchtutor',$watchtutor);
		
		$this->set('filtertutor1',$filtertutor1);
	
		
			if ($this->RequestHandler->isAjax()) {
				$this->layout = '';
				Configure::write('debug', 0);
				$this->AutoRender = false;
				$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
				$this->render('newtutorsearch');
			}
			
	}
	
	
/*	function design_search_session($id = NULL )
	{
		$this->Session->write('tutorsearch.tutor_id', $id );
		
		$this->redirect(array(
						'controller' => 'members',
						'action' => 'designsearch'
					));
		
		
		
	}*/
	
	function tutor_search_avgcourse($id = NULL)
	{
		
		$list = array();
		$total = 0;
		$rating_abl = 0;
		$rating_know = 0;
	
		$allcourse = $this->TutCourse->find('all',array(
										   'conditions'=> array('TutCourse.member_id'=>$id),
										   'fields'=>array('TutCourse.rate'),
										   ));
		
		
		
		
		$count = count($allcourse); //total numbers in array
	
		foreach ($allcourse as $value) {
		$total = $total + $value['TutCourse']['rate']; // total value of array numbers
		}
		$average = ($total/$count); // get average value
		
		
		/*echo '<pre>';
		print_r($allcourse);
		echo $total;
		echo $count;
		echo $average;
		die;*/
		
		
		$list['avg'] = (integer)$average;
		
		
		$rating = $this->TutRating->find('all',array(
													 'conditions'=> array('TutRating.tutor_id'=>$id),
													 'fields'=>array('TutRating.ability','TutRating.knowledge'),
													 )
										 );
		
		$ratingcount = count($rating); //total numbers in array
		
		
		
		if($ratingcount)
		{
		
		foreach ($rating as $rt) {
		$rating_abl = $rating_abl + $rt['TutRating']['ability']; // total value of array numbers
		$rating_know = $rating_know + $rt['TutRating']['knowledge']; // total value of array numbers
		}
		
		$average_abl = ($rating_abl/$ratingcount); // get average value
		$rating_know = ($rating_know/$ratingcount); // get average value
		
		$list['abl'] = (integer)$average_abl;
		$list['know'] = (integer)$rating_know;
		
		}
		else
		{
			$list['abl'] = 0;
			$list['know'] = 0;
		}
		
	//	$list=array("one", "two", "three");
	
	/*echo '<pre>';
	print_r($rating);
	echo count($rating);
	print_r($list);
	die;*/
		return $list;
		die;
		
	}
	
	
	
	
	
	function design_tdash()
	{
		
		
		
		
	}
	
	function design_sdash()
	{
		
		
		
		
	}
	
	function find_non_profit()
	{
			
		Configure::write('debug', 0);
		
		$matchcause = array();
		
		
		$allschool = $this->School->find('all',array(
													 'recursive'=> -1,
													 'fields'=> array('School.id','School.school_name')
													 )
													 );
		
		
		$this->set('allschool',$allschool);
		
		
		
		
		
		/*
		echo '<pre>';
		print_r($allschool);
		die;
		*/
		
		
	
		
		
		if(!$this->RequestHandler->isAjax() && !isset($this->data) ) {
		
		$this->Session->delete('findcause');
		
	
		
		}
		
		
		if (isset($this->data)) {
			
			$this->Session->write('findcause.schoolid', $this->data['CauseSchool']['schoolid']);			
			$this->Session->write('findcause.causename', $this->data['CauseSchool']['causename']);
			
			
			
		/*	$schoolid  = $this->data['CauseSchool']['schoolid'];
			$causename = $this->data['CauseSchool']['causename'];*/
			
		} else {
			
			
		}
		
		
		$schoolid  = $this->Session->read('findcause.schoolid');
		$causename = $this->Session->read('findcause.causename');
		
		
	//	
		
		$requestedcause = array();
		
		$session_id = $this->Session->read('Member.memberid');
		
		if($session_id)
		{
		
		$causeResult = $this->TutorRequestCause->find('all', array(
		'conditions' => array(
		'status' => '1',
		'tutor_id' => $session_id
		),
		'recursive' => -1
		));
		
		foreach($causeResult as $cr)
		{
			
			$requestedcause[] = $cr['TutorRequestCause']['cause_id'];
			
		}
		
		$this->set('requestedcause',$requestedcause);
		
		}
		
			if ($schoolid!='' || $causename!='') {
				
			//	$this->Session->delete('findcause.causename');
				
/*				$schooldata = $this->School->find('first',array('conditions'=>
												  array('School.school_name' => $schoolname)
												  )
									);
				
				$school_id = $schooldata['School']['id'];*/
				
				
			    $matchcause1 = array();
				$matchcause2 = array();
				$uniqueallcause = array();
				
				
				if($schoolid)
				{
					$causedata = $this->CauseSchool->find('all',array('conditions'=>
															 array(
																   'OR'=>array(
																	'CauseSchool.school_id'=> $schoolid,
																	'CauseSchool.all'=> 1
																			   )
																   ),
															 'recursive' => 1,
															 )
												 );
					
					foreach($causedata as $cd)
					{
						$matchcause1[] = $cd['CauseSchool']['cause_id'];
					}
						$matchcause1 = array_unique($matchcause1);
				}
				
				
				if($causename)
				{
						
					$causefind = $this->userMeta->find('all',array(
												'conditions' => array(
																		'userMeta.cause_name LIKE' => $causename,
																		'Member.group_id' => 6
																	)
												)
													   );
													   
					foreach($causefind as $cf)								   
					{
					  $matchcause2[] = $cf['userMeta']['member_id'];
					}	
				
				}
				
				
				
				if(count($matchcause1)==0 && count($matchcause2)>0)
				{ 
			//	echo 'first'.'<br>';
				$uniqueallcause = $matchcause2; 	
				}
				else if(count($matchcause2)==0 && count($matchcause1)>0)
				{
			//	echo 'second'.'<br>';
				$uniqueallcause = $matchcause1; 	
				}
				else if(count($matchcause1)>0 && count($matchcause2)>0)
				{
			//	echo 'third'.'<br>';
					$uniqueallcause = array_intersect($matchcause1, $matchcause2);	
				}
				
			//	$searchtutor = array_unique($searchtutor);
			
		/*	echo '<pre>';
			print_r($matchcause1);
			print_r($matchcause2);
			print_r($uniqueallcause);
			print_r($_SESSION);
			print_r($_POST);
			echo $schoolid;
			echo $causename;
			print_r($causedata);
			die;
			*/
			
				
				$this->paginate['userMeta'] = array(
					'conditions' => array(
						'userMeta.member_id' => $uniqueallcause,
						'userMeta.cause_name !=' => ''
					),
					'recursive' => 1,
					'limit'=> 5
					
				);
				
				$filtercause = $this->paginate('userMeta');
				
				
		/*		echo '<pre>';
		
				print_r($filtercause);
				die;*/
				
				
			}
			else
			{
				$this->paginate['userMeta'] = array(
				'conditions' => array(
				'Member.group_id' => 6,
				'userMeta.cause_name !=' => ''
				),
				'recursive' => 2,
				'limit' => 5
				
				);
		
				$filtercause = $this->paginate('userMeta');	
				
			}
			
			
			
		if($_REQUEST['causeid'])
		{
		
			$id = $_REQUEST['causeid'];
			
			$watchcause =  $this->userMeta->find('first',array('conditions'=>array('userMeta.member_id'=>$id),
																  )
								);
		
		}
		else
		{
			
			$causeId = $filtercause[0]['Member']['id'];
			
			$watchcause =  $this->userMeta->find('first',array('conditions'=>array('userMeta.member_id'=>$causeId),
																  )
								);
			
		}
		
		
		if(count($filtercause)==0)
			{
				$this->Session->setFlash('No Non-Profit found.');
			}
		
		
		
		
		$this->set('watchcause',$watchcause);
		$this->set('filtercause', $filtercause);
	
		
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
			$this->render('newfindcause');
		}
		
		
	
		
		
		
		
	}
	
	

	
	
	
	function cronjob()
	{
		
/*$to = "promatics.jaswant@gmail.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "someonelse@example.com";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
*/
		
		
		
		Configure::write('debug', 0);
		
		$getAmount = $this->PaymentHistory->find('all', array(
		'conditions' => array(
			'PaymentHistory.booked_end_time <' => date('Y-m-d H:i:s'),
			'PaymentHistory.session_status' => 'Paided',
		)
		));
		
		if(count($getAmount))
		{
		foreach($getAmount as $ga)
			{
				$this->PaymentHistory->updateAll(array(
							'PaymentHistory.session_status' => "'Review'",
						), array(
							'PaymentHistory.id' => $ga['PaymentHistory']['id']
						));
		
			}
		}
		
		
		$start_formatted_date = date('Y-m-d H:i:s');
		$end_formatted_date = date("Y-m-d H:i:s",strtotime("-3 day"));
		
		$completedsession = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.booked_end_time <' => $end_formatted_date,				  
				'PaymentHistory.session_status' => 'Review',
			),
			'recursive'=> -1
		));

		
		foreach($completedsession as $cs)
		{
			
				if ($this->PaymentHistory->updateAll(array(
					'PaymentHistory.session_status' => "'Completed'",
					'PaymentHistory.paypal_status' => "'complete'"
				), array(
					'PaymentHistory.id' => $cs['PaymentHistory']['id']
				))) {
					
				//	echo 'first balance update';
					
					$this->Member->updateAll(array(
						'Member.creditable_balance' => ('Member.creditable_balance+' . $cs['PaymentHistory']['amount']),
						'Member.balance' => ('Member.balance-' . $cs['PaymentHistory']['amount'])
					), array(
						'Member.id' => $cs['PaymentHistory']['tutor_id']
					));
				}
			
		
		}
		
		
		$eight_hours_before = date("Y-m-d H:i:s",strtotime("-8 hours"));
		
		$rejectedSession = $this->PaymentHistory->find('all', array(
			'conditions' => array(
				'PaymentHistory.booked_start_time <' => $eight_hours_before,				  
				'PaymentHistory.session_status' => 'Booked',
			),
			'recursive'=> -1
		));
		
		
		if(count($rejectedSession))
		{
		foreach($rejectedSession as $rs)
			{
				$this->PaymentHistory->updateAll(array(
							'PaymentHistory.session_status' => "'Rejected'",
						), array(
							'PaymentHistory.id' => $rs['PaymentHistory']['id']
						));
		
			}
		}
		
		
	/*	echo 'start date'.$start_formatted_date;
		echo 'eight hours before date'.$eight_hours_before;
		echo '<pre>';
		print_r($rejectedSession);
		echo '</pre>';
		die;*/
		
		
		
		
		
		
		
	
	
		die;		
		
	}
	
	
	function reviewcronjob()
	{
		
		$start_formatted_date = date('Y-m-d H:i:s');
		$end_formatted_date = date("Y-m-d H:i:s",strtotime("-3 day"));
		
		$reviewtutor = $this->PaymentHistory->find('all', array(
		'conditions' => array(
			'PaymentHistory.booked_end_time between ? and ?' => array($end_formatted_date,$start_formatted_date),				  
			'PaymentHistory.session_status' => 'Review',
		),
		'recursive'=> -1
		));
	
		
		foreach($reviewtutor as $rt)
		{
			
			
		$payment_id = $rt['PaymentHistory']['id'];	
		
		$rating = $this->TutRating->find('count',array(
													   'conditions'=>array('TutRating.payment_id'=>$payment_id),
													   'recursive'=> -1
													   )
										 );
		
			if($rating==0)
			{
				
			// To send a mail 
				
				$this->revtutor_email_template($payment_id);
			
		    //	echo 'mail send';
				
			// End To send a mail 
				
			}
	/*		else
			{
				
				$getAmount = $this->PaymentHistory->find('first', array(
				'conditions' => array('PaymentHistory.id' => $payment_id )
				));
				
				if ($this->PaymentHistory->updateAll(array(
					'PaymentHistory.session_status' => "'Completed'",
					'PaymentHistory.paypal_status' => "'complete'"
				), array(
					'PaymentHistory.id' => $getAmount['PaymentHistory']['id']
				))) {
					
					
					$this->Member->updateAll(array(
						'Member.creditable_balance' => ('Member.creditable_balance+' . $getAmount['PaymentHistory']['amount']),
						'Member.balance' => ('Member.balance-' . $getAmount['PaymentHistory']['amount'])
					), array(
						'Member.id' => $getAmount['PaymentHistory']['tutor_id']
					));
				}
				
			}*/
		
		
		}
		
		$day = date("D", time());
		
		if($day=='Wed')
		{
			
			$causeData = $this->Member->find('all',array('conditions'=>array(
																	'Member.group_id'=>6,
																	'Member.active'=>1,),
														 'recursive' => -1,
														 'fields'=>array('Member.id','Member.creditable_balance'),
														 )
											 );
			
			foreach($causeData as $cd)
			{
				
				$causeid = $cd['Member']['id'];
				
				$this->weekly_report($causeid);
			}
			
		}
		
		
		die;
		
		
		}
	
	
	
	
	
	
	function revtutor_email_template($paymentid = null){
		
				Configure::write('debug', 0);
				$this->layout     = '';
				$this->AutoRender = false;
				
				
				$offsetdata = $this->PaymentHistory->find('first',array('conditions'=>
															 array('PaymentHistory.id'=> $paymentid),
															 'fields' => array('tutor.offset'),
															 )
											   );
		
				$offset = $offsetdata['tutor']['offset'];
				
		
				$paymentdata   = $this->PaymentHistory->find('first', array(
					'conditions' => array(
					'PaymentHistory.id' => $paymentid
					),
					'fields' => array('student.email','student.fname','student.lname','tutor.fname','tutor.lname','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.tutoring_hours','PaymentHistory.tutor_rate_per_hour','tutor.email')
				));
				
				
						
				$to  = $paymentdata['student']['email'];				
				
				$this->Email->smtpOptions = array(
				'port'=>'465', 
				'timeout'=>'30',
				'auth' => true,
				'host' => 'ssl://smtp.sendgrid.net',
				'username'=>'tutorcause',
				'password'=>'fp9K81G16R1X84F',
				'client' => 'tutorcause.com' 
				);
				
				
				$this->set('smtp_errors', $this->Email->smtpError); 
				
				$this->Email->delivery = 'smtp';
				
						
		
			    $email_template = $this->get_email_template(6);										
																									
				$this->Email->to = $to;
				
				$this->Email->replyTo = "TutorCause<notifications@tutorcause.com>";
				
				$this->Email->from = "TutorCause<notifications@tutorcause.com>";
				
				$this->Email->subject = $email_template['EmailTemplate']['subject'];
											
				$this->Email->sendAs = 'html';
				
				$this->Email->template = 2;
			
	
	
		
		$studentname = $paymentdata['student']['fname']. " " .$paymentdata['student']['lname'];
		$tutorname = $paymentdata['tutor']['fname']. " " .$paymentdata['tutor']['lname'];
		$starttime =  $paymentdata[0]['booked_start_time'];
		$formatstarttime = date('F j, Y @ h:i A',strtotime($starttime));
		$endtime =  $paymentdata[0]['booked_end_time'];
		$formatendtime = date('F j, Y @ h:i A',strtotime($endtime));
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
		$this->set('sendgrid', $to );
		$this->set('HTTP_ROOT', HTTP_ROOT );

		
		$email_template_content =  $this->render_email_template($email_template['EmailTemplate']['html_content']);		
			
		$this->set('email_template_content',$email_template_content);	
		
		$this->Email->template = 'email_template';	
		
	/*	echo '<pre>';
		print_r($paymentdata);
		echo $this->Email->to;
		print_r($email_template_content);
		die;*/
		
		$this->Email->send();
		
	}
	
	
	
	
	
	
	function update_amount_raised()
	{
		
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;
		
		/*echo '<pre>';
		print_r($_REQUEST);
		die;*/
		
		$goal = $_REQUEST['goal'];
		
		if(is_numeric($goal))
		{
			$this->userMeta->updateAll(array(
			'userMeta.goal' => "'" . $goal . "'"
			), array(
			'userMeta.member_id' => $this->Session->read('Member.memberid')
			) 
			);
			
			$this->Session->setFlash('Non-Profit goal updated.');
			
			echo 'true';
			
		}
		else
		{
			echo 'false';
		}
		
		
		die;
		
		
	}
	
	
	function stripe_pay()
	{
		
	
	
		
	}
	
	
	function stripe_sucess()
	{
		
		Configure::write('debug', 0);
		
		App::import('Vendor', 'stripephp', array('file' => 'stripephp'.DS.'lib'.DS.'Stripe.php'));
		
		// set your secret key: remember to change this to your live secret key in production
		// see your keys here https://manage.stripe.com/account
		
		// STRIPEID define in core.php this 
		
		Stripe::setApiKey(STRIPEID);
		
		/*echo $stripeid;
		die;*/
		
		//live
	//	Stripe::setApiKey("STXx0V2iZwH17qPszOID8zCyItKRzWAH");
		// tesing
	//	Stripe::setApiKey("hzKG6oNLVXaJpipg5j2AWqv0gl90MQZi");
		
		$token = $_POST['stripeToken'];	
		$amount = $_POST['amount'];
		$cent = $amount * 100;
		$buyer_name = $_POST['parentname'];
		$stdemail = $_POST['studentemail'];
		$card_type = $_POST['card_type'];
		
		
		if($token)
		{
			
			
		$addfund = array();
		
		if($stdemail)
		{
		$addfund['AddFund']['student_email'] = $stdemail;
		}
		else
		{
			$studentEmail = $this->Member->find('first',array(
				'conditions'=>array(
				'Member.id' =>$this->Session->read('Member.memberid')
				),
			'recursive'=>-1
			));
			
			$addfund['AddFund']['student_email'] = $studentEmail['Member']['email'];		
		}
		$addfund['AddFund']['request_id']      = uniqid();
		$addfund['AddFund']['amount']          = $amount;
		$addfund['AddFund']['card_type']          = $card_type;
		$addfund['AddFund']['payment_status']  = 'pending';
		$addfund['AddFund']['approval_status'] = 'Pending';
		$this->AddFund->create();
		$this->AddFund->save($addfund);
		$paymentid = $this->AddFund->getLastInsertId();
		
	/*	echo '<pre>';
		echo $paymentid;
		print_r($_POST);
		die;
			*/
			
		
		if($this->Session->read('Member.memberid'))
			{
			   
			$customerEmail = $addfund['AddFund']['student_email'];
			
			// get the credit card details submitted by the form
			// create a Customer
			$customer = Stripe_Customer::create(array(
			  "card" => $token,
			  "description" => $customerEmail)
			);
			
			// charge the Customer instead of the card
			Stripe_Charge::create(array(
			  "amount" => $cent, # amount in cents, again
			  "currency" => "usd",
			  "customer" => $customer->id)
			);
			
			
			// save the customer ID in your database so you can use it later
		//	saveStripeCustomerId($user, $customer->id);
			
			// later
		//	$customerId = getStripeCustomerId($user);
			
			$customerId = $customer->id;
			
			$this->Member->updateAll(array(
					'Member.stripeid' => "'" . $customerId . "'",
				), array(
					'Member.id' => $this->Session->read('Member.memberid')
				) //(conditions) where userid=schoolid
			);
			
		/*	$sucess_status = 'Sucess';
			
			$sucess_msg = "Status: $sucess_status  Customer Id: $customerId";
			
			$this->Session->setFlash($sucess_msg);*/
			
		
			//Update Table
			$confirmId  = "'" . $customerId . "'";
			$saveamount	 = "'" . $amount  . "'";
			$name	   = "'" . $buyer_name  . "'";
			$card_type1 = "'" . $card_type  . "'";
			$status	 = "'complete'";
			$varifyText =md5(uniqid());
			$id = $paymentid;
			
			
			$this->AddFund->updateAll(array(
			'AddFund.paypal_confirm_id' => $confirmId,
			'AddFund.amount' => $saveamount,
			'AddFund.name' => $name,
			'AddFund.card_type'=> $card_type1,
			'AddFund.payment_status' => $status,
			'AddFund.varify_text' => "'".$varifyText."'"
			), array(
			'AddFund.id' => $id
			));
			
			// email to student to claim money
			
		//	$this->verify_email_template($id,$name,$amount,$varifyText);
		
			$this->AddFund->updateAll(
				array(
					'AddFund.approval_status' => "'Verified'",
					'AddFund.student_id'	=> $this->Session->read('Member.memberid')
				),
				array(
					'AddFund.id'=>$id
				)
			);
			
			$this->Member->updateAll(
					array(
						'Member.creditable_balance' => 'Member.creditable_balance+'.$amount
					),
					array(
						'Member.id'=>$this->Session->read('Member.memberid')
					)
				);
			
			
			$this->redirect(array(
							'controller' => 'homes',
							'action' => 'global_gateway_sucess'
						));
			
			
	/*		Stripe_Charge::create(array(
				"amount" => 3500, # $15.00 this time
				"currency" => "usd",
				"customer" => $customerId)
			);
			   
			   */
			   
				
			}
		else
			{
				$description = $buyer_name.'_'.$paymentid;
				
				Stripe_Charge::create(array( "amount" => $cent, 
									"currency" => "usd",
									"card" => $token, // obtained with stripe.js 
									"description" => $description) ); 
						
	
				$sucess_status = 'Sucess';
				
				$sucess_msg = "Status: $sucess_status  Token Number: $token";
				
			//	$this->Session->setFlash($sucess_msg);
				
					
				//Update Table
				$confirmId  = "'" . $token . "'";
				$amount	 = "'" . $amount  . "'";
				$name	   = "'" . $buyer_name  . "'";
				$status	 = "'complete'";
				$card_type = "'" . $card_type  . "'";
				$varifyText =md5(uniqid());
				$id = $paymentid;
				
				
				$this->AddFund->updateAll(array(
				'AddFund.paypal_confirm_id' => $confirmId,
				'AddFund.amount' => $amount,
				'AddFund.name' => $name,
				'AddFund.card_type' => $card_type,
				'AddFund.payment_status' => $status,
				'AddFund.varify_text' => "'".$varifyText."'"
				), array(
				'AddFund.id' => $id
				));
				
				// email to student to claim money
				
				$this->verify_email_template($id,$name,$amount,$varifyText);
				
				$this->redirect(array(
								'controller' => 'homes',
								'action' => 'global_gateway_sucess'
							));
				
				
			}
		
		
		}
		else
		{
			
				$this->redirect(array(
					'controller' => 'homes',
					'action' => 'global_gateway_failure'
				));
			
			
		}
		
		
	
		
	
		
	}
	
	
	function stripe_sucess2()
	{
		
		
		Configure::write('debug', 0);
		
		App::import('Vendor', 'stripephp', array('file' => 'stripephp'.DS.'lib'.DS.'Stripe.php'));
		
		// set your secret key: remember to change this to your live secret key in production
		// see your keys here https://manage.stripe.com/account
		
		Stripe::setApiKey(STRIPEID);
		
		//live
	//	Stripe::setApiKey("STXx0V2iZwH17qPszOID8zCyItKRzWAH");
		// tesing
	//	Stripe::setApiKey("hzKG6oNLVXaJpipg5j2AWqv0gl90MQZi");
		
//		$token = $_POST['stripeToken'];	
		$amount = $_POST['amount'];
		$cent = $amount * 100;
		$buyer_name = $_POST['parentname'];
//		$stdemail = $_POST['studentemail'];
			
		$addfund = array();
		
		$studentEmail = $this->Member->find('first',array(
			'conditions'=>array(
			'Member.id' =>$this->Session->read('Member.memberid'),
			'Member.active' => 1
			),
		'recursive'=>-1
		));
		
		
	/*	echo '<pre>';
		print_r($studentEmail);
		print_r($_REQUEST);
		die;*/
		
		
		$addfund['AddFund']['student_email'] = $studentEmail['Member']['email'];		
		
		$addfund['AddFund']['request_id']      = uniqid();
		$addfund['AddFund']['amount']          = $amount;
		$addfund['AddFund']['payment_status']  = 'pending';
		$addfund['AddFund']['approval_status'] = 'Pending';
		$this->AddFund->create();
		$this->AddFund->save($addfund);
		$addfundid = $this->AddFund->getLastInsertId();
		
		/*echo '<pre>';
		echo $paymentid;
		print_r($_POST);
		die;*/
		
		$customerId = $studentEmail['Member']['stripeid'];
		
			
			// charge the Customer instead of the card
			Stripe_Charge::create(array(
			  "amount" => $cent, # amount in cents, again
			  "currency" => "usd",
			  "customer" => $customerId)
			);
			
			
			// save the customer ID in your database so you can use it later
		//	saveStripeCustomerId($user, $customer->id);
			
			// later
		//	$customerId = getStripeCustomerId($user);
			
		/*	$sucess_status = 'Sucess';
			
			$sucess_msg = "Status: $sucess_status  Customer Id: $customerId";
			
			$this->Session->setFlash($sucess_msg);*/
			
		
			//Update Table
			$confirmId  = "'" . $customerId . "'";
			$saveamount	 = "'" . $amount  . "'";
			$name	   = "'" . $buyer_name  . "'";
			$status	 = "'complete'";
			$varifyText =md5(uniqid());
		//	$id = $addfundid;
			
			
			$this->AddFund->updateAll(array(
			'AddFund.paypal_confirm_id' => $confirmId,
			'AddFund.amount' => $saveamount,
			'AddFund.name' => $name,
			'AddFund.payment_status' => $status,
			'AddFund.varify_text' => "'".$varifyText."'"
			), array(
			'AddFund.id' => $addfundid
			));
			
			// email to student to claim money
			
	//		$this->verify_email_template($id,$name,$amount,$varifyText);
	
			$this->AddFund->updateAll(
				array(
					'AddFund.approval_status' => "'Verified'",
					'AddFund.student_id'	=> $this->Session->read('Member.memberid')
				),
				array(
					'AddFund.id'=>$addfundid
				)
			);
			
			$this->Member->updateAll(
					array(
						'Member.creditable_balance' => 'Member.creditable_balance+'.$amount
					),
					array(
						'Member.id'=>$this->Session->read('Member.memberid')
					)
				);
			
			$this->redirect(array(
							'controller' => 'homes',
							'action' => 'global_gateway_sucess'
						));
			
			
	/*		Stripe_Charge::create(array(
				"amount" => 3500, # $15.00 this time
				"currency" => "usd",
				"customer" => $customerId)
			);
			   
			   */
		
	}
	
	function welcome_email_template($memberid = NULL){
		
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;
		
		
		$memberData = $this->Member->find('first', array(
												'conditions' => array(
													'Member.id' => $memberid,
												//	'Member.active' => 0
												),
												'fields' => array('Member.email','Member.fname','Member.lname','Member.activation_key'),
												'recursive' => -1
										));
		
		$to	= $memberData['Member']['email'];
		$name = $memberData['Member']['fname'].' '.$memberData['Member']['lname'];
		$activecode = $memberData['Member']['activation_key'];
		
	
			$this->Email->smtpOptions = array(
			'port'=>'465', 
			'timeout'=>'30',
			'auth' => true,
			'host' => 'ssl://smtp.sendgrid.net',
			'username'=>'tutorcause',
			'password'=>'fp9K81G16R1X84F',
			'client' => 'tutorcause.com' 
			);
			
			
			$this->set('smtp_errors', $this->Email->smtpError); 
			
			$this->Email->delivery = 'smtp';
	
	
		$email_template = $this->get_email_template(7);										
																							
		$this->Email->to = $to;
		
		$this->Email->replyTo = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->from = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->subject = $email_template['EmailTemplate']['subject'];
									
		$this->Email->sendAs = 'html';
		
		$this->Email->template = 7;
		
		$this->set('name', $name );
		$this->set('memberid', $memberid );
		$this->set('activecode', $activecode );
		$this->set('sendgrid', $to );
		$this->set('HTTP_ROOT', HTTP_ROOT );

		
		$email_template_content =  $this->render_email_template($email_template['EmailTemplate']['html_content']);
			
		$this->set('email_template_content',$email_template_content);	
		
		$this->Email->template = 'email_template';	
		
	/*	echo '<pre>';
		echo $this->Email->to;
		print_r($memberData);
		print_r($email_template['EmailTemplate']['html_content']);
	    print_r($email_template_content);
		echo '</pre>';
		
		die;*/
										
		$this->Email->send();
	
		
	}
	
	function show_image()
	{
		
		if($this->Session->read('Member.memberid'))
			{
				$image = 1;
				
				$this->Member->updateAll(array('Member.showImage' => "'" . $image . "'"),
										array('Member.id' => $this->Session->read('Member.memberid'))
										);
				
				$this->Session->setFlash('Profile image is showing.');
				
				$this->redirect($this->referer());
				
			}
		
	}
	
	
	function hide_image()
	{
	
		if($this->Session->read('Member.memberid'))
			{
				$image = 0;
				
				$this->Member->updateAll(array('Member.showImage' => "'" . $image . "'"),
										array('Member.id' => $this->Session->read('Member.memberid'))
										);
				
				$this->Session->setFlash('Profile image is hidden.');
				
				$this->redirect($this->referer());
				
			}
		
	}
	
	
	
	function change_password()
	{
		
	Configure::write('debug', 0);
		$this->layout = 'frontend';
		
		if ($this->Session->read('Member.group_id') == 6) {
			$this->cause_element();
		} else if ($this->Session->read('Member.group_id') == 7) {
			$this->tutor_element();
		} else if ($this->Session->read('Member.group_id') == 8) {
			$this->student_element();
		} else if ($this->Session->read('Member.group_id') == 9) {
			$this->parent_element();
		}
		
	if($this->data)
	{
	
		/*echo '<pre>';
		print_r($this->data);
		die;*/
		
		
		$memberid = $this->Session->read('Member.memberid');
		
		$this->Member->updateAll(array(
			'Member.pwd' => "'" . md5($this->data['Member']['pwd']) . "'",
		), array(
			'Member.id' => $memberid
		) 
		);
		
		$this->Session->setFlash('Password changed successfully');
		
	}
	
	
	}
	
	
	function savefbid()
	{
		
		Configure::write('debug', 0);
		
		
		if($_REQUEST['id'])
		{
			$memberid = $this->Session->read('Member.memberid');
			
			$fbId = $_REQUEST['id'];
			
			$count = $this->Member->find('count', array(
			'conditions' => array(
			'Member.facebookId' => $fbId,
			'Member.id !=' => $memberid,
			'Member.active !=' => 3
			),
			'recursive' => -1
			));
			//	echo $count;
			
			if ($count > 0) {
			echo "false";
			} else {
			$this->Session->write('Member.facebook_id',$fbId);
			
			$this->Member->updateAll(array(
			'Member.facebookId' => $fbId,
			), array(
			'Member.id' => $memberid
			));
			
			echo "true";
			}
			
		 /*	$this->Cookie->delete('fbs_226449800757981');
			
			setcookie("fbs_226449800757981", "", time()-3600);*/
			
			
		}
		
		
	//	$this->redirect($this->referer());
		
		die;
		
	}
	
	
	
	
	function facebook_link_account()
	{
		
		
		
	}
	
	
	function getdate_event() {
		$id = $_GET['eventid'];
		
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$offset = $this->Session->read('Member.offset'); 
		
		$eventData = $this->TutEvent->find('first',array('conditions'=>
													array('TutEvent.id'=>$id),
													'fields'=>array('CONVERT_TZ(TutEvent.start_date,  "-05:00",  "'.$offset.'" ) as start_date','CONVERT_TZ(TutEvent.end_date,  "-05:00",  "'.$offset.'" ) as end_date'),
													'recursive'=>-1
																		)
									  );
		
		
		$startDate = date("d-M-Y",strtotime($eventData[0]['start_date']));
		
		$startTime = date("h:i A",strtotime($eventData[0]['start_date']));
		
		$endTime = date("h:i A",strtotime($eventData[0]['end_date']));
		
		
		$dateTime = "$startDate,$startTime,$endTime";
		
		
		/*echo '<pre>';
		print_r($eventData);
		echo '</pre>';*/
		
		echo $dateTime;
		
		
	}
	
	function collapseevent($start,$end)
	{
		
		
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		
	
		$comparestart =	$this->TutEvent->find('all',array('conditions' =>
												  array(
														'TutEvent.start_date between ? and ?' => array($start,$end),
														'TutEvent.tutor_id' => $this->Session->read('Member.memberid')),
												  	  'recursive' => -1
												  ));
		
		
		$compareend =	$this->TutEvent->find('all',array('conditions' =>
											  array(
													'TutEvent.end_date between ? and ?' => array($start,$end),
													'TutEvent.tutor_id' => $this->Session->read('Member.memberid')),
											  		
											  'recursive' => -1
											  ));
		
		
		$comparemid = $this->TutEvent->find('all',array('conditions' =>
											  array(
													'TutEvent.start_date <=' => $start,
													'TutEvent.end_date >=' => $end,
													'TutEvent.tutor_id' => $this->Session->read('Member.memberid')),
											  		
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
	
	
	
	
	function collapseeventid($start=NULL,$end=NULL,$id=NULL)
	{
				
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		
	//	echo 'start'.$start.'end'.$end.'id'.$id;
	
		
		
	
		$comparestart =	$this->TutEvent->find('all',array('conditions' =>
												  array(
														'TutEvent.start_date between ? and ?' => array($start,$end),
														'TutEvent.tutor_id' => $this->Session->read('Member.memberid'),
														'TutEvent.id !=' => $id   ),
												        
												  	  'recursive' => -1
												  ));
		
		
		$compareend =	$this->TutEvent->find('all',array('conditions' =>
											  array(
													'TutEvent.end_date between ? and ?' => array($start,$end),
													'TutEvent.tutor_id' => $this->Session->read('Member.memberid'),
													'TutEvent.id !=' => $id),
											  		
											  'recursive' => -1
											  ));
		
		
		$comparemid = $this->TutEvent->find('all',array('conditions' =>
											  array(
													'TutEvent.start_date >=' => $start,
													'TutEvent.end_date <=' => $end,
													'TutEvent.tutor_id' => $this->Session->read('Member.memberid'),
													'TutEvent.id !=' => $id ),
											  		
											  'recursive' => -1
											  ));
		
		
		
	/*	echo '<pre>';
		print_r($comparestart);
		print_r($compareend);
		print_r($comparemid);
		die;
		*/
		
		
		
		
		if(count($comparestart) > 0 || count($compareend) > 0 || count($comparemid) > 0 )
		{
				 return 'true';
		}
		else
		{	
				return 'false';
		}
			
			
	
		
	}
	
	
	
	
	function editschedule()
	{
		
	/*	echo '<pre>';
		print_r($_REQUEST);
		*/
		
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
			
			$finalstartdate = $this->tgmt($finalstartdate,$this->Session->read('Member.timezone'));
			
			$finalenddate = $desdate . ' ' . $timeend;
			
			$finalenddate = $this->tgmt($finalenddate,$this->Session->read('Member.timezone'));
		
		
		//	echo 'finalstartdate'.$finalstartdate.'finalenddate'.$finalenddate;
			
		//	die;
		
			
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
	
	function permanently_delete()
	{
		
		$this->autoRender = false;
		$this->layout     = "";
		
		Configure::write('debug', 0);
		
		$id = $this->Session->read('Member.memberid');
		
		// id 3 means delete
		
		$activeid = 3;
			$this->Member->updateAll(array(
				'Member.active' => "'" . $activeid . "'"
			), array(
				'Member.id' => $id
			));
		
		echo "deleted";
		
	}
	
	
	
	function myclass()
	{
		
		Configure::write('debug', 0);
		$this->layout = 'frontend';		
		
		
	/*	$timezone = 'America/Indiana/Indianapolis';
		
		$date =  $this->ctime($timezone);
		echo $date;
		die;*/
		
		
	//	$currentdate = date('Y-m-d H:i:s');
	
	
		$offset = $this->Session->read('Member.offset'); 
		
		
		if ($this->Session->read('Member.group_id') == 7) {
			
			$this->tutor_element();
			
			$offset = $this->Session->read('Member.offset'); 
			
			$this->paginate['PaymentHistory'] = array(
			'conditions' => array(
				'PaymentHistory.tutor_id' => $this->Session->read('Member.memberid'),
				'PaymentHistory.session_status' => 'Paided',
				'PaymentHistory.booked_end_time >=' => date('Y-m-d H:i:s') 
				
			),
			'order' => array(
				'PaymentHistory.booked_start_time ASC'
			),
			'fields'=>array('student.showImage','student.image_name','student.facebookId','student.fname','student.lname','tutor.id','tutor.showImage','tutor.image_name','tutor.facebookId','tutor.fname','tutor.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.amount'),
			'limit' => 5,
		//	'recursive' => 2
		);
		
			
			
			
		} else if ($this->Session->read('Member.group_id') == 8) {
			$this->student_element();
			
		
			
			
		$this->paginate['PaymentHistory'] = array(
			'conditions' => array(
				'PaymentHistory.student_id' => $this->Session->read('Member.memberid'),
				'PaymentHistory.session_status' => 'Paided',
				'PaymentHistory.booked_end_time >=' => date('Y-m-d H:i:s') 
			),
			'order' => array(
				'PaymentHistory.booked_start_time ASC'
			),
			'fields'=>array('student.showImage','student.image_name','student.facebookId','student.fname','student.lname','tutor.id','tutor.showImage','tutor.image_name','tutor.facebookId','tutor.fname','tutor.lname','PaymentHistory.id','CONVERT_TZ(PaymentHistory.booked_start_time,  "-05:00",  "'.$offset.'" ) as booked_start_time','CONVERT_TZ(PaymentHistory.booked_end_time,  "-05:00",  "'.$offset.'" ) as booked_end_time','PaymentHistory.booked_course','PaymentHistory.amount'),
			'limit' => 5,
		//	'recursive' => 2
		);
		
			
		}
		
		
		
	
		$upcomingclass	= $this->paginate('PaymentHistory');
		
		
	/*	echo '<pre>';
		print_r($upcomingclass);
		die;*/
		
		
		
		$this->set('upcomingclass', $upcomingclass);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout     = '';
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'frontend' . DS . 'members';
			$this->render('element_myclass');
		}
	
		
		
	
	
	
	}
	
	
	
	
	function booked_event($id=NULL)
	{
		
		Configure::write('debug', 0);
		$this->layout     = "";
		$this->autoRender = false;
		
		$paymentData = $this->PaymentHistory->find('first',array('conditions'=>
																 array('PaymentHistory.id'=>$id),
																 'recursive'=> -1 
																 )
														   );
		
		
		if(!empty($paymentData))
		{
		
			$tutorid = $paymentData['PaymentHistory']['tutor_id'];
			$startsave = $paymentData['PaymentHistory']['booked_start_time'];
			$endsave = $paymentData['PaymentHistory']['booked_end_time'];
			
			/*$startsave = "January 11, 2012 12:30:00";
			$endsave = "January 11, 2012 19:00:00";*/
			
			$startcon = strtotime($startsave);
			$endcon = strtotime($endsave);
			
			$tutevent =	$this->TutEvent->find('first',array('conditions' =>
																array(
																'TutEvent.start_date <=' => $startsave,
																'TutEvent.end_date >=' => $endsave,
																'TutEvent.tutor_id' => $tutorid,			
																),
															'recursive' => -1
															)
											  );
											
			/*echo '<pre>';
			echo 'jaswant';
			print_r($tutevent);
			die;*/					  
			
			$eventStart = strtotime($tutevent['TutEvent']['start_date']);
			$eventEnd = strtotime($tutevent['TutEvent']['end_date']);
			$eventId = $tutevent['TutEvent']['id'];
			
			if(!empty($tutevent))
			{
			
			if($startcon == $eventStart && $endcon < $eventEnd )
				{
					
					$time_mod =  strtotime($endsave) + 60;
					$date_mod = date("Y-m-d H:i:s", $time_mod);					
					
					$this->TutEvent->updateAll(array(
					'TutEvent.end_date' => "'".$endsave."'",
					'TutEvent.title' => "'Booked'",
					), array(
					'TutEvent.id' => $eventId
					));
					
					
					$this->data['TutEvent']['tutor_id'] = $tutevent['TutEvent']['tutor_id'];
				//	$this->data['TutEvent']['start_date'] = $endsave;
					$this->data['TutEvent']['start_date'] = $date_mod;
					$this->data['TutEvent']['end_date'] = $tutevent['TutEvent']['end_date'];
					$this->data['TutEvent']['title'] = 'Available';
					$this->TutEvent->save($this->data);			
					
				}
			else if($startcon > $eventStart && $endcon < $eventEnd )
				{
					
					$time_mod =  strtotime($startsave) - 60;
					$date_mod = date("Y-m-d H:i:s", $time_mod);
					
					$time_mod1 =  strtotime($endsave) + 60;
					$date_mod1 = date("Y-m-d H:i:s", $time_mod1);
					
					$this->TutEvent->updateAll(array(
					'TutEvent.start_date' => "'".$startsave."'",								 
					'TutEvent.end_date' => "'".$endsave."'",
					'TutEvent.title' => "'Booked'",
					), array(
					'TutEvent.id' => $eventId
					));
					
					$this->data['TutEvent']['tutor_id'] = $tutevent['TutEvent']['tutor_id'];
					$this->data['TutEvent']['start_date'] = $tutevent['TutEvent']['start_date'];
				//	$this->data['TutEvent']['end_date'] = $startsave;
					$this->data['TutEvent']['end_date'] = $date_mod;
					$this->data['TutEvent']['title'] = 'Available';
					$this->TutEvent->create();
					$this->TutEvent->save($this->data);	
					
					$this->dataend['TutEvent']['tutor_id'] = $tutevent['TutEvent']['tutor_id'];
				//	$this->dataend['TutEvent']['start_date'] = $endsave;
					$this->dataend['TutEvent']['start_date'] = $date_mod1;
					$this->dataend['TutEvent']['end_date'] = $tutevent['TutEvent']['end_date'];
					$this->dataend['TutEvent']['title'] = 'Available';
					$this->TutEvent->create();
					$this->TutEvent->save($this->dataend);			
					
				}
			else if($startcon > $eventStart && $endcon == $eventEnd )
				{
					
					$time_mod =  strtotime($startsave) - 60;
					$date_mod = date("Y-m-d H:i:s", $time_mod);
					
					$this->TutEvent->updateAll(array(
					'TutEvent.start_date' => "'".$startsave."'",								 
					'TutEvent.title' => "'Booked'",
					), array(
					'TutEvent.id' => $eventId
					));
					
					$this->data['TutEvent']['tutor_id'] = $tutevent['TutEvent']['tutor_id'];
					$this->data['TutEvent']['start_date'] = $tutevent['TutEvent']['start_date'];
			//		$this->data['TutEvent']['end_date'] = $startsave;
					$this->data['TutEvent']['end_date'] = $date_mod;
					$this->data['TutEvent']['title'] = 'Available';
				
					
					$this->TutEvent->save($this->data);	
					
				}
			else if($startcon == $eventStart && $endcon == $eventEnd )
				{
					
					$this->TutEvent->updateAll(array(
					'TutEvent.title' => "'Booked'",
					), array(
					'TutEvent.id' => $eventId
					));
					
				}
			
				return true;
			
			}
			else
			{
				return false;			
			}
		}
		
		die;
	
	}
	
	
	function update_fname()
	{
	
   	
		
	  $userMeta =  $this->userMeta->find('all',array('recursive'=>-1));
	  
	  
	  foreach($userMeta as $um)
	  {
		  $this->Member->updateAll(array(
					'Member.fname' => "'".$um['userMeta']['fname']."'",		
					'Member.lname' => "'".$um['userMeta']['lname']."'",		
					), array(
					'Member.id' => $um['userMeta']['member_id']
					));
		  
	  }
	  
	  $userImage =  $this->UserImage->find('all',array('conditions'=>array('UserImage.active'=> 1),
													   'recursive'=>-1)
										   );
	  
	  
	   foreach($userImage as $ui)
	  {
		  $this->Member->updateAll(array(
					'Member.image_name' => "'".$ui['UserImage']['image_name']."'",		
					), array(
					'Member.id' => $ui['UserImage']['user_id']
					));
		  
	  }
	  
	  echo '<pre>';
	  print_r($userMeta);
	  print_r($userImage);
	  die;
		
	}
	
	function create_twiddla_meet($paymentId = NULL)
	{
		
		$this->layout = '';
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$paymentData  =	$this->PaymentHistory->find('first',array('conditions'=>array('PaymentHistory.id'=>$paymentId),
														  )
											);
		
		
		
		$start_formatted_date = $paymentData['PaymentHistory']['booked_start_time'];
		$end_formatted_date =  $paymentData['PaymentHistory']['booked_end_time'];
		
		$checkconflict = $this->PaymentHistory->find('first',array('conditions'=>array(
														'OR'=>array(							 
														'PaymentHistory.booked_start_time between ? and ?' => array($start_formatted_date,$end_formatted_date),
														'PaymentHistory.booked_end_time between ? and ?' => array($start_formatted_date,$end_formatted_date),
														),
														'PaymentHistory.id !=' => $paymentId,
														'PaymentHistory.session_status' => 'Paided',
														'PaymentHistory.twiddla !=' => ''
																					),
																 'recursive' => -1
																)
													);
		
	
		
		
		if(!empty($checkconflict))
		{
	//		echo 'checkconflict'.'<br>';
			
			$apiData = $this->Api->find('first',array('conditions'=>array('Api.id'=>2)));
			
			$tokbox = $this->Api->find('first',array('conditions'=>array('Api.id'=>4)));
		}
		else
		{
			
			$apiData = $this->Api->find('first',array('conditions'=>array('Api.id'=>1)));
			
			$tokbox = $this->Api->find('first',array('conditions'=>array('Api.id'=>3)));
			
		}
		
		
	/*		
		echo '<pre>';		
		print_r($checkconflict);
		print_r($paymentData);
		die;
		
		*/
		
		
		
		
		$tokkey = $tokbox['Api']['username'];
		$username = $apiData['Api']['username'];
		$password = convert_uudecode(base64_decode($apiData['Api']['password']));
		
		$meetingTitle = $paymentData['tutor']['fname'].'_'.$paymentData['student']['fname'];
		
	/*	echo $meetingTitle;		
		echo '<pre>';
		print_r($apiData);
		print_r($paymentData);*/
		
		$XPost=array('username'=>$username,'password'=>$password,'meetingtitle'=>$meetingTitle);

		/*echo '<pre>';
		print_r($XPost);
		die;*/



		$url = "http://www.twiddla.com/new.aspx";
 
            $ch = curl_init();    // initialize curl handle
            curl_setopt($ch, CURLOPT_URL,$url); // set url to post to
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
            curl_setopt($ch, CURLOPT_TIMEOUT, 60); // times out after 4s
            curl_setopt($ch, CURLOPT_POSTFIELDS, $XPost); // add POST fields
            $result = curl_exec($ch); // run the whole process
           // var_dump($result); //contains response from server (Will certainly be FALSE)
		   
		   	//	$result = "-1 bad username or password";
		
		//	$result = "728442";
			
			$resArry = (explode(" ",$result));
				
				if($resArry[0]!=-1)
				{	
						$mettingId = $resArry[0];
					
						$this->PaymentHistory->updateAll(array(
						'PaymentHistory.twiddla' => "'" . $mettingId . "'",
						'PaymentHistory.tokbox' => "'" . $tokkey . "'"
						), array(
						'PaymentHistory.id' => $paymentId
						) 
						);
				}
			
			
			$result = 'true';
				
			return $result;	
				
			die;
			
	}
	
	function parent_dashboard()
	{
		
		Configure::write('debug', 0);
		$this->layout = 'frontend';
		// student dashboard leftside bar 
		
		
		$parentnotice = $this->Notice->find('all', array('conditions'=>
														  array('Notice.group_id LIKE'=> "%"."9"."%")
														  )
											 );
		
	
		$this->set('parentnotice',$parentnotice);
		
		$this->parent_element();
		
		// end student dashboard leftside bar 
		
	}
	
	function parent_element()
	{
		
		
	/*	$this->set('picture', $this->getProfilePic());
		$this->set('CountRequest', $this->returnBoldCount($this->getTutorRequest()));*/
		
		
		$countMsg   = $this->TutMessage->find('count', array(
			'conditions' => array(
				'to_id' => $this->Session->read('Member.memberid'),
				'status' => '0'
			)
		));
		$getBalance = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $this->Session->read('Member.memberid')
			)
		));
		//echo "<pre>";print_r($getBalance);exit;
		$this->set('getBalance', $getBalance);
		$this->set('countMsg', $countMsg);
		
		
		$studentrequest = $this->countparent_request();
		
		$this->set('studentrequest',$studentrequest);
		
		$mystudent = $this->ParentStudent->find('all',array('conditions'=> array(
																   'ParentStudent.parent_id'=>$this->Session->read('Member.memberid'),
																   'ParentStudent.status'=>1
																	 				 ),
															'fields' => array("ParentStudent.student_id"),
															'recursive' => 2
																)
											   );
		
		
		$this->set('mystudent',$mystudent);
		
		
		
		
	/*	$withdrawalreq = $this->CauseWithdrawal->find('first', array(
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
		
		
		$this->CauseTutor->unbindModel(array('belongsTo' => array('Cause'))); 
		
		$tutorAmount = $this->CauseTutor->find('all', array(
			'conditions' => array(
				'CauseTutor.status' => '1',
				'cause_id' => $this->Session->read('Member.memberid')
			),
			'recursive' => 2
		));
		
		
		$this->set('tutorAmount', $tutorAmount);*/
		
		
	
		
		
	
	
	}
	
	function add_student()
	{
		
		Configure::write('debug', 0);
		
		$this->parent_element();
		
		if($this->data['Member']['email']!="")
			{
			 	if($this->isValidEmail($this->data['Member']['email'])=="false")
				{
					$errors  = "Email is not correct\n";
				}
				
			}
		$this->Session->write('errmsg',$errors);
		$error =$this->Session->read('errmsg');
	
		if(!empty($this->data))
		{
			
		/*	echo '<pre>';
			print_r($this->data);
			die;*/
			
		  $email = trim($this->data['Member']['email']); 
			
		  $memberData =	$this->Member->find('first',array('conditions'=>array(
																		  'Member.email'=>$email,
																		  'Member.active'=>1,
																		  'Member.group_id'=>8
																		  ),
														  'recursive'=>1
													  )
										);
		  
		  
		
/*			echo '<pre>';
			print_r($memberData['Member']['id']);
			die;
*/			
			$memberid = $memberData['Member']['id'];
		  
		  
		  	$alreadystudent = $this->ParentStudent->find('all',array('conditions'=>
															array(
																  'ParentStudent.parent_id'=>$this->Session->read('Member.memberid'),
																  'ParentStudent.student_id'=>$memberid,
																  'ParentStudent.status'=>1
																  ),
															'recursive'=>-1,
															)
												);
			
			
			$this->set('alreadystudent',$alreadystudent);
		  
		 	$this->set('memberData',$memberData);
			
			
		}
		
		
		
		
	}
	
	
	function isValidEmail($email)
			{
				$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
			$ret="false";
				if (eregi($pattern, $email))
				{
				$ret="true";
				}
				return($ret);
			}
	
	function get_student_email()
	{
		
		$this->layout = false;
		Configure::write('debug', 0);
		
		
		$mystudent = $this->ParentStudent->find('all',array('conditions'=>
															array(
																  'ParentStudent.parent_id'=>$this->Session->read('Member.memberid'),
																  'ParentStudent.req_parent'=>1
																  ),
															'fields'=> array('ParentStudent.student_id'),
															'recursive'=>-1,
															)
												);
												
	/*	pr($mystudent);
		die;*/
		$liststudent = array();
		
		
		foreach($mystudent as $ms)
		{
			$liststudent[] = $ms['ParentStudent']['student_id'];
		}
		
		
		
		
		if(!empty($liststudent))
		{
			
			if(count($liststudent)==1)
			{
				
				$onlystudent = $liststudent[0];
				//echo $onlystudent;
				
				$email = $this->Member->find("list", array(
					'limit' => '10',
					"conditions" => array(
						"Member.email LIKE " =>$_GET['q']. "%",
						"Member.group_id" => 8,
						"Member.active"=>1,
						"Member.id NOT"=> $onlystudent,
					),
					"fields" => "Member.id,Member.email",
					"order" => "Member.email ASC"
				));
			}
			else
			{
				
				$email = $this->Member->find("list", array(
					'limit' => '10',
					"conditions" => array(
						"Member.email LIKE " =>$_GET['q']. "%",
						"Member.group_id" => 8,
						"Member.active"=>1,
						"Member.id NOT"=> $liststudent,
					),
					"fields" => "Member.id,Member.email",
					"order" => "Member.email ASC"
				));
				
			}
			
		}
		else
		{
			
				$email = $this->Member->find("list", array(
					'limit' => '10',
					"conditions" => array(
						"Member.email LIKE " =>$_GET['q']. "%",
						"Member.group_id" => 8,
						"Member.active"=>1,
					),
					"fields" => "Member.id,Member.email",
					"order" => "Member.email ASC"
				));
			
		}
	
	
			/*$email = $this->Member->find("list", array(
					'limit' => '10',
					"conditions" => array(
						"Member.email LIKE " =>$_GET['q']. "%",
						"Member.group_id" => 8,
						"Member.active"=>1,
					),
					"fields" => "Member.id,Member.email",
					"order" => "Member.email ASC"
				));*/
	
	
	
	
		
		
	//	$mystudent = array_values($mystudent);
	//		array_push($mystudent,'');
		
		
	/*	echo '<pre>';
		print_r($email);
		echo count($liststudent);
		die;
		*/
		
		
//echo <pre>
		if (!empty($email)) {
			foreach ($email as $key => $value) {
				
			//	$value = trim($value);
				
				echo "$value\n";				
			}			
			
		} 
		
		die;
		
	}
	
	function parent_req_student($id=NULL)
	{
		
		if(!empty($id))
		{
				
			$this->data['ParentStudent']['parent_id'] = $this->Session->read('Member.memberid');
			$this->data['ParentStudent']['student_id'] = $id;
			$this->data['ParentStudent']['req_parent'] = 1;
			$this->ParentStudent->save($this->data);
		
			$memberData = $this->Member->find('first',array('conditions'=>array('Member.id'=>$id),
															'recursive'=> -1
															)
											  );
			
			$studentname = $memberData['Member']['fname'].' '.$memberData['Member']['lname'];
			
			$msg = "Your request has been sent to $studentname";
			
			$this->Session->setFlash($msg);
			
		}
		
			$this->redirect(array(
							'controller' => 'members',
							'action' => 'parent_dashboard'
							));
		
	}
	
	function add_parent()
	{
		
		Configure::write('debug', 0);
		
		$this->student_element();
		
		if(!empty($this->data))
		{
			
		/*	echo '<pre>';
			print_r($this->data);
			die;*/
			
		  $email = trim($this->data['Member']['email']); 
			
		  $memberData =	$this->Member->find('first',array('conditions'=>array(
																		  'Member.email'=>$email,
																		  'Member.active'=>1,
																		  'Member.group_id'=>9
																		  ),
														  'recursive'=>1
													  )
										);
		  
		  
		  	$memberid = $memberData['Member']['id'];
		  
		  
		  	$alreadyparent = $this->ParentStudent->find('all',array('conditions'=>
															array(
																  'ParentStudent.student_id'=>$this->Session->read('Member.memberid'),
																  'ParentStudent.parent_id'=>$memberid,
																  'ParentStudent.status'=>1
																  ),
															'recursive'=>-1,
															)
												);
			
			
			$this->set('alreadyparent',$alreadyparent);
		  
		    $this->set('memberData',$memberData);
			
			
		}
		
		
		
		
	}
	
	function get_parent_email()
	{
		
		$this->layout = false;
		Configure::write('debug', 0);
		
		$myparent = $this->ParentStudent->find('all',array('conditions'=>
															array(
																  'ParentStudent.student_id'=>$this->Session->read('Member.memberid'),
																  'ParentStudent.req_student'=>1
																  ),
															'fields'=> array('ParentStudent.parent_id'),
															'recursive'=>-1,
															)
												);
		
		$listparent = array();
	
		
		foreach($myparent as $mp)
		{
			$listparent[] = $mp['ParentStudent']['parent_id'];
		}
		
		
		
		
		if(!empty($listparent))
		{
			
			if(count($listparent)==1)
			{
				
				$onlyparent = $listparent[0];
				
				$email = $this->Member->find("list", array(
					'limit' => '10',
					"conditions" => array(
						"Member.email LIKE " =>$_GET['q']. "%",
						"Member.group_id" => 9,
						"Member.active"=>1,
						"Member.id NOT"=> $onlyparent,
					),
					"fields" => "Member.id,Member.email",
					"order" => "Member.email ASC"
				));
			}
			else
			{
				
				$email = $this->Member->find("list", array(
					'limit' => '10',
					"conditions" => array(
						"Member.email LIKE " =>$_GET['q']. "%",
						"Member.group_id" => 9,
						"Member.active"=>1,
						"Member.id NOT"=> $listparent,
					),
					"fields" => "Member.id,Member.email",
					"order" => "Member.email ASC"
				));
				
			}
			
		}
		else
		{
			
				$email = $this->Member->find("list", array(
					'limit' => '10',
					"conditions" => array(
						"Member.email LIKE " =>$_GET['q']. "%",
						"Member.group_id" => 9,
						"Member.active"=>1,
					),
					"fields" => "Member.id,Member.email",
					"order" => "Member.email ASC"
				));
			
		}
		
		
		
			/*	$email = $this->Member->find("list", array(
					'limit' => '10',
					"conditions" => array(
						"Member.email LIKE " =>$_GET['q']. "%",
						"Member.group_id" => 9,
						"Member.active"=>1,
					),
					"fields" => "Member.id,Member.email",
					"order" => "Member.email ASC"
				));
		*/
		
		
		
		
	//	$mystudent = array_values($mystudent);
	//		array_push($mystudent,'');
		
		
	/*	echo '<pre>';
		print_r($email);
		echo count($liststudent);
		die;
		*/
		
		
		
	
		
	//	print_r($email);
		
		if (!empty($email)) {
			foreach ($email as $key => $value) {
				
		//		$value = trim($value);
				
				echo "$value\n";				
			}			
			
		} 
		
		die;
		
	
	
	/*	$this->layout = false;
		Configure::write('debug', 0);
		
		$email = $this->Member->find("list", array(
			'limit' => '10',
			"conditions" => array(
				"Member.email LIKE " =>$_GET['q']. "%",
				"Member.group_id" => 9
			),
			"fields" => "Member.id,Member.email",
			"order" => "Member.email ASC"
		));
		
	
		
		if (!empty($email)) {
			foreach ($email as $key => $value) {
				echo "$value\n";				
			}			
			
		} 
		
		die;*/
		
		
		
	}
	
	
	
	function student_req_parent($id=NULL)
	{
		
		
		if(!empty($id))
		{
				
			$this->data['ParentStudent']['student_id'] = $this->Session->read('Member.memberid');
			$this->data['ParentStudent']['parent_id'] = $id;
			$this->data['ParentStudent']['req_student'] = 1;
			$this->ParentStudent->save($this->data);
		
			$memberData = $this->Member->find('first',array('conditions'=>array('Member.id'=>$id),
															'recursive'=> -1
															)
											  );
			
			$studentname = $memberData['Member']['fname'].' '.$memberData['Member']['lname'];
			
			$msg = "Your request has been sent to $studentname";
			
			$this->Session->setFlash($msg);
			
		}
		
			$this->redirect(array(
							'controller' => 'members',
							'action' => 'student_dashboard'
							));
		
	}
	
	
	
	
	function countparent_request()
	{
		
		$memberid = $this->Session->read('Member.memberid');
		
		
		if($this->Session->read('Member.group_id')==8)
		{
		
		$count = $this->ParentStudent->find('count',array('conditions'=>array(
																			 'ParentStudent.student_id'=>$memberid,
																			 'ParentStudent.req_parent'=>1,
																			 'ParentStudent.status'=>0,
																			 
																			 ),
														'recursive'=> -1
														 )
										   );
		
		
		}
		else if($this->Session->read('Member.group_id')==9)
		{
			
		$count = $this->ParentStudent->find('count',array('conditions'=>array(
																 'ParentStudent.parent_id'=>$memberid,
																 'ParentStudent.req_student'=>1,
																 'ParentStudent.status'=>0,
																 ),
											 'recursive' => -1
											 )
							   );
		
			
		}
		
		if(empty($count))
			{
			
			return 0;
				
			}
		else
			{
			
			return $count;
			
			}
		
	}
	
	function parent_pending_request()
	{
		Configure::write('debug', 0);
		
		$this->student_element();
		
		$parentResult = $this->ParentStudent->find('all',array('conditions'=> array(
																   'ParentStudent.student_id'=>$this->Session->read('Member.memberid'),
																   'ParentStudent.req_parent'=>1,
																   'ParentStudent.status'=>0
															   ),
															   'recursive'=>2
															   )
												   );
		
		
		$this->set('parentResult',$parentResult);
		
		if(!empty($this->data))
		{
			
			if (isset($this->data['Member']['accept'])) {
				
				$this->ParentStudent->updateAll(array(
					'ParentStudent.status' => "'1'"
				), array(
					'ParentStudent.id' => $this->data['Member']['id']
				));
				
				 $data = $this->ParentStudent->find('first',array('conditions'=>array(
																'ParentStudent.id' => $this->data['Member']['id']
																		  ),
																'recursive'=>-1
														  )
											);
				 
				 
				 $parentid = $data['ParentStudent']['parent_id'];
				 $studentid = $data['ParentStudent']['student_id'];
				 
				 $deleterequest = $this->ParentStudent->deleteAll(array(
						'ParentStudent.parent_id' => $parentid,
						'ParentStudent.student_id' => $studentid,
						'ParentStudent.status' => 0,
					));
				 
				// $delete  = $this->ParentStudent->delete($del_id);
				
				$this->Session->setFlash('Accepted successfully!');
				
				$this->redirect($this->referer());
				
				
			} else {
				
				$this->ParentStudent->delete($this->data['Member']['id']);
				$this->Session->setFlash('Deleted successfully!');
				
				$this->redirect($this->referer());
				
			}
			
		}
		
		
		
		
		
	}
	
	function student_pending_request()
	{
		Configure::write('debug', 0);
		
		$this->parent_element();
		
		$studentResult = $this->ParentStudent->find('all',array('conditions'=> array(
															   'ParentStudent.parent_id'=>$this->Session->read('Member.memberid'),
															   'ParentStudent.req_student'=>1,
															   'ParentStudent.status'=>0
														   ),
														   'recursive'=>2
														   )
											   );
		
		
		$this->set('studentResult',$studentResult);
		
		
		
		if(!empty($this->data))
		{
			
			if (isset($this->data['Member']['accept'])) {
				
				$this->ParentStudent->updateAll(array(
					'ParentStudent.status' => "'1'"
				), array(
					'ParentStudent.id' => $this->data['Member']['id']
				));
				
				 $data = $this->ParentStudent->find('first',array('conditions'=>array(
																'ParentStudent.id' => $this->data['Member']['id']
																		  ),
																'recursive'=>-1
														  )
											);
				 
				 
				 $parentid = $data['ParentStudent']['parent_id'];
				 $studentid = $data['ParentStudent']['student_id'];
				 
				 $deleterequest = $this->ParentStudent->deleteAll(array(
						'ParentStudent.parent_id' => $parentid,
						'ParentStudent.student_id' => $studentid,
						'ParentStudent.status' => 0,
					));
				 
				// $delete  = $this->ParentStudent->delete($del_id);
				
				$this->Session->setFlash('Accepted successfully!');
				
				$this->redirect($this->referer());
				
				
			} else {
				
				$this->ParentStudent->delete($this->data['Member']['id']);
				$this->Session->setFlash('Deleted successfully!');
				
				$this->redirect($this->referer());
				
			}
			
		}
		
	}
	
	
	function my_parent()
	{
		
		Configure::write('debug', 0);
		
		$this->student_element();
		
		$myparent = $this->ParentStudent->find('all',array('conditions'=> array(
																   'ParentStudent.student_id'=>$this->Session->read('Member.memberid'),
																   'ParentStudent.status'=>1
															   ),
															   'recursive'=>2
															   )
												   );
		
		
		$this->set('myparent',$myparent);
		
		if(!empty($this->data))
		{
			
			if (!empty($this->data['Member']['id'])) {
				
				$this->ParentStudent->delete($this->data['Member']['id']);
				$this->Session->setFlash('Deleted successfully!');
				
				$this->redirect($this->referer());
				
			}
			
		}
		
		
	}
	
	function remove_student()
	{
		
		Configure::write('debug', 0);
		
		$this->parent_element();
		
		$mystudent = $this->ParentStudent->find('all',array('conditions'=> array(
															   'ParentStudent.parent_id'=>$this->Session->read('Member.memberid'),
															   'ParentStudent.status'=>1
														   ),
														   'recursive'=>2
														   )
											   );
		
		
		$this->set('mystudent',$mystudent);
		
		
		
		if(!empty($this->data))
		{
			
			if (isset($this->data['Member']['id'])){
				
				$this->ParentStudent->delete($this->data['Member']['id']);
				$this->Session->setFlash('Deleted successfully!');
				
				$this->redirect($this->referer());
				
			}
			
		}
		
	
		
		
		
	}
	
	function view_session_student($id=NULL)
	{
		Configure::write('debug', 0);
		
		$this->parent_element();
		
		if(!empty($id))
		{
		
			$upcomingSession = $this->PaymentHistory->find('all', array(
				'conditions' => array(
					'PaymentHistory.session_status' => 'Paided',
					'PaymentHistory.student_id' => $id,
					'tutor.active' => 1
				),
				'order' => array('PaymentHistory.booked_start_time DESC'),
				'recursive' => 2
			));
			$this->set('upcomingSession', $upcomingSession);
			
		}
		
	}
	
	
	
	
	function view_awaiting_session($id=NULL)
	{
		Configure::write('debug', 0);
		
		$this->parent_element();
		
		if(!empty($id))
		{
		
			$paymentAwaiting = $this->PaymentHistory->find('all', array(
				'conditions' => array(
					'PaymentHistory.session_status' => 'Accepted',
					'PaymentHistory.student_id' => $id,
					'tutor.active' => 1
				),
				'order' => array('PaymentHistory.booked_start_time DESC'),
				'recursive' => 2
			));
			$this->set('paymentAwaiting', $paymentAwaiting);
			
		}
		
	}
	
	
	
	
	
	function view_session_all()
	{
		
		Configure::write('debug', 0);
		
		$this->parent_element();
		
		$mystudent = $this->ParentStudent->find('all',array('conditions'=> array(
															   'ParentStudent.parent_id'=>$this->Session->read('Member.memberid'),
															   'ParentStudent.status'=>1
														   ),
														   'recursive'=>2
														   )
											   );
		
		
		$this->set('mystudent',$mystudent);

		
		
		
	}
	
	
	function pay_session_student()
	{
	/*	echo '<pre>';
		print_r($_POST);
		die;*/
		
/*		$PaymentMethod = $this->Session->read('payment.method');
		if (isset($PaymentMethod)) {
			$this->set('method', $PaymentMethod);
		} else {
			$this->redirect(array(
				'action' => 'student_dashboard'
			));
		}
*/		
		
		
		if (!empty($this->data)) {
			
			$amount    = $this->data['PaymentHistory']['amount'];
			$paymentid = $this->data['PaymentHistory']['id'];
			
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
					
					
				/*	$eventid = $this->PaymentHistory->find('first',array('conditions'=>array(
																							'PaymentHistory.id'=>$paymentid
																							)
																		 )
														   );
					
				
					$this->TutEvent->updateAll(array(
					'TutEvent.title' => "'Booked'",
					), array(
					'TutEvent.id' => $eventid['PaymentHistory']['tut_event_id']
					));*/
					
					
					$this->booked_event($paymentid);
					
					
					$this->Member->updateAll(array(
						'Member.creditable_balance' => "Member.creditable_balance-" . $amount
					), array(
						'Member.id' => $this->Session->read('Member.memberid')
					));
					
					/*$this->Session->delete('payment');
					$this->Session->setFlash('Payment successfully!');*/
					
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
						'controller' => 'homes',
						'action' => 'global_gateway_sucess'
					));
					
					
				}
			}
			else
			{
				$this->Session->setFlash('Insufficient Funds');
				
					$this->redirect(array(
						'controller' => 'members',
						'action' => 'parent_fund'
					));
				
			}
		}
		
		
	/*	$this->set('paymentid', $paymentid);
		$paydata = $this->PaymentHistory->find('first', array(
			'conditions' => array(
				'PaymentHistory.id' => $paymentid
			)
		));
		
		$this->set('paydata', $paydata);*/
		
	
		
	}
	
	function add_fund_student($id=NULL)
	{
		
		Configure::write('debug', 0);
		
		
		// for live https 
		/*if ($_SERVER['SERVER_PORT']!=443) {
			
			$securelink = HTTP_ROOTS.'members/add_fund_student/'.$id;			
			$this->redirect($securelink);
		}*/
		
		
		
		
		$cms_add_fund_data = $this->Page->find('first',array('conditions'=>array('Page.id'=>'50')));
		$this->set('cms_add_fund_data',$cms_add_fund_data);
	
		$mystudent = $this->Member->find('first',array('conditions'=>array(
																		   'Member.id'=>$id,
																		   'Member.active'=>1
																		   ),
													   'recursive'=>-1
													   )
										 );
		
		
		/*echo '<pre>';
		print_r($mystudent);
		die;*/
		
		$this->set('mystudent',$mystudent);
		
	}
	
	function parent_fund_student()
	{
		
		
		
		
		
		
		
		$amount = $_POST['amount'];
		$student_id = $_POST['studentid'];
		
		$memberData = $this->Member->find('first',array('conditions'=>array(
																			'Member.id'=>$this->Session->read('Member.memberid'),
																			'Member.active'=> 1
																			),
														'recursive'=>-1
														)
										  );
		
		$parent_id = $memberData['Member']['id'];
		
		
		if($memberData['Member']['creditable_balance'] > $amount)
		{
			
/*			echo '<pre>';
			print_r($memberData);
			die;
*/		
			$this->Member->updateAll(array(
						'Member.creditable_balance' => ('Member.creditable_balance-' . $amount),
					), array(
						'Member.id' => $parent_id
					));
			
			
			$this->Member->updateAll(array(
				'Member.creditable_balance' => ('Member.creditable_balance+' . $amount),
			), array(
				'Member.id' => $student_id
			));
			
			$this->data['StudentFund']['parent_id'] = $parent_id;
			$this->data['StudentFund']['student_id'] = $student_id;
			$this->data['StudentFund']['amount'] = $amount;
			$this->StudentFund->save($this->data);
			
			
			$securelink = HTTP_ROOTS.'homes/global_gateway_sucess/';
			$this->redirect($securelink);
			
			
/*			$this->redirect(array(
						'controller' => 'homes',
						'action' => 'global_gateway_sucess'
					));
*/			
		
/*			echo '<pre>';
			print_r($_POST);
			die;*/
		
			
		}
		else
		{
			
			$this->Session->setFlash('Insufficient Funds');
			
			$this->redirect($this->referer());
			
		}
		
		
		
								 
	
								 
								 
	}
	
	
	function admin_approve_tutor()
	{
		
		
		$this->layout = 'admin';
		
		$this->set("parentClass", "selected"); //set main navigation class
		
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('prntview');
		}
		
		if (isset($this->data)) {
			
		/*	echo '<pre>';
			print_r($this->data);
			die;*/
			
			$this->Session->write('prntview.email', trim($this->data['Member']['email']));
			
			$this->Session->write('prntview.name', trim($this->data['Member']['name']));
			
			$this->Session->write('prntview.school_id', trim($this->data['Member']['school_id']));
			
			$this->Session->write('prntview.perpage', $this->data['Member']['perpage']);
			
			$this->data['Member']['school_id']    = $this->Session->read('prntview.school_id');
			
			$this->data['Member']['name']    = $this->Session->read('prntview.name');
			
			$this->data['Member']['email']    = $this->Session->read('prntview.email');
			
			$this->data['Member']['perpage']  = $this->Session->read('prntview.perpage');
			
		} else {
			
			$this->data['Member']['school_id']    = $this->Session->read('prntview.school_id');
			
			$this->data['Member']['name']    = $this->Session->read('prntview.name');
			
			$this->data['Member']['email']    = $this->Session->read('prntview.email');
			
			$this->data['Member']['perpage']  = $this->Session->read('prntview.perpage');

		}
		
		if (strlen($this->Session->read('prntview.perpage')) > 0) {
			$this->data['Member']['perpage'] = $this->Session->read('prntview.perpage');
		} else {
			$this->data['Member']['perpage'] = 10;
		}		
		
		/*echo '<pre>';
		print_r($this->data);
		die;*/
		
		
		$conditions = array();
		
		//$conditions=array_merge($conditions,array('Member.school_id' => $schoolid));
		$conditions = array_merge($conditions, array(
			'Member.active' => 5
		));
		
		if ($this->data['Member']['email']) {
			$conditions = array_merge($conditions, array(
				'Member.email  LIKE' => $this->data['Member']['email'] . "%"
			));
			
		}
		
		if ($this->data['Member']['name']) {
			$conditions = array_merge($conditions, array(
				'OR' => array(										 
				'Member.fname  LIKE' => "%" . trim($this->data['Member']['name']) . "%",
				'Member.lname  LIKE' => "%" . trim($this->data['Member']['name']) . "%",
				)
			));
			
		}
		
		
		if ($this->data['Member']['school_id']) {
			$conditions = array_merge($conditions, array(
				'Member.school_id' => $this->data['Member']['school_id']
			));
			
		}
		
		$this->paginate['Member'] = array(
			'conditions' => $conditions,
			'limit' => $this->data['Member']['perpage']
		);
		
		/*if(!empty($this->data['Member']['email']) || !empty($this->data['Member']['name']) || !empty($this->data['Member']['school_id']))
		{
			$this->paginate['Member'] = array(
				'conditions' => array(
					'AND' => array(
						'Member.email  LIKE' => "%" . trim($this->data['Member']['email']) . "%",
						'Member.fname  LIKE' => "%" . trim($this->data['Member']['name']) . "%",
						'Member.lname  LIKE' => "%" . trim($this->data['Member']['name']) . "%",
						'Member.school_id' => $this->data['Member']['school_id'],
						'Member.active' => 5
					)
				),
				'limit' => $this->data['Member']['perpage']
			);
		}
		else
		{
			$this->paginate['Member'] = array(
				'conditions' => array(
					'AND' => array(
						'Member.active' => 5
					)
				),
				'limit' => $this->data['Member']['perpage']
			);
		}*/
		
		
		$alldata    = $this->School->find('all');
		$schoolname = Set::combine($alldata, '{n}.School.id', '{n}.School.school_name');
		$this->set("schoolname", $schoolname);		
		
		$members = $this->paginate('Member');
		
		$this->set('members', $members);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'members';
			$this->render('approve_tutor');
		}
		
		
	}
	
	
	function admin_tutor_approve($id = NULL)
	{
		
		
	/*	if($_POST)
		{
			echo '<pre>';
			print_r($_POST);
			die;
		}*/
		
		
		
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
			
			if (!empty($this->data['Member']['accept'])) {
				
				
		/*		echo '<pre>';
				print_r($_REQUEST);
				die;*/
				
				
				$activeid = 1;
				$id = $this->data['Member']['id'];
				$this->Member->updateAll(array(
					'Member.active' => "'" . $activeid . "'"
						), array(
					'Member.id' => $id
					));
				
				$this->Session->setFlash('Tutor Approved Sucessfully.');
				
				
				
			}
			else
			{
				
			/*	echo '<pre>';
				print_r($_REQUEST);
				die;*/
				
				
				$activeid = 3;
				$id = $this->data['Member']['id'];
				$this->Member->updateAll(array(
					'Member.active' => "'" . $activeid . "'"
						), array(
					'Member.id' => $id
					));
				
				$this->Session->setFlash('Tutor Rejected.');
				
			}
			
			
			$this->redirect(array('action'=>'approve_tutor'));
			
			
		}
		
		
		$admindata = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $id
			)
		));
		
		$this->set('admindata', $admindata);
		
		
	}
	
	
	function weekly_report($memberid = NULL){
		
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;
		
		
		$memberData = $this->Member->find('first', array(
												'conditions' => array(
													'Member.id' => $memberid,
												//	'Member.active' => 0
												),
												'fields' => array('Member.email','Member.fname','Member.lname','Member.creditable_balance'),
												'recursive' => -1
										));
		
		$to	= $memberData['Member']['email'];
		$name = $memberData['Member']['fname'].' '.$memberData['Member']['lname'];
		$balance = $memberData['Member']['creditable_balance'];
		
	
			$this->Email->smtpOptions = array(
			'port'=>'465', 
			'timeout'=>'30',
			'auth' => true,
			'host' => 'ssl://smtp.sendgrid.net',
			'username'=>'tutorcause',
			'password'=>'fp9K81G16R1X84F',
			'client' => 'tutorcause.com' 
			);
			
			
			$this->set('smtp_errors', $this->Email->smtpError); 
			
			$this->Email->delivery = 'smtp';
	
	
		$email_template = $this->get_email_template(9);										
																							
		$this->Email->to = $to;
		
		$this->Email->replyTo = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->from = "TutorCause<notifications@tutorcause.com>";
		
		$this->Email->subject = $email_template['EmailTemplate']['subject'];
									
		$this->Email->sendAs = 'html';
		
		$this->Email->template = 9;
		
		$this->set('name', $name );
		$this->set('balance', $balance );
		$this->set('sendgrid', $to );
		$this->set('HTTP_ROOT', HTTP_ROOT );

		
		$email_template_content =  $this->render_email_template($email_template['EmailTemplate']['html_content']);
			
		$this->set('email_template_content',$email_template_content);	
		
		$this->Email->template = 'email_template';	
		
/*		echo '<pre>';
		echo $this->Email->to;
		print_r($memberData);
		print_r($email_template['EmailTemplate']['html_content']);
	    print_r($email_template_content);
		echo '</pre>';
*/		
	
		$this->Email->send();
	
		
	}
	
	
	function cron_weekly()
	{
		Configure::write('debug', 0);
		$this->layout     = '';
		$this->AutoRender = false;

        /*for($i=1;$i<=7;$i++)
		{
		  	echo date('D', strtotime("+$i days"));
		}
		
		die;*/
		
	//	WedThuFriSatSunMonTue
	//	$todayDate = date("Y-m-d",time());
		$day = date("D", time());
		
		if($day=='Wed')
		{
			
			$causeData = $this->Member->find('all',array('conditions'=>array(
																	'Member.group_id'=>6,
																	'Member.active'=>1,),
														 'recursive' => -1,
														 'fields'=>array('Member.id','Member.creditable_balance'),
														 )
											 );
			
			foreach($causeData as $cd)
			{
				
				$causeid = $cd['Member']['id'];
				
				$this->weekly_report($causeid);
			}
			
		}
		
		
	}
	
	
	
	
	
	
	// dumy testing function 
	
	function dumytesting()
	{
		
$inipath = php_ini_loaded_file();

if ($inipath) {
    echo 'Loaded php.ini: ' . $inipath;
} else {
    echo 'A php.ini file is not loaded';
}

phpinfo();

ini_set("upload_max_filesize", "5M");


phpinfo();



die;
		
		
		
		$email = "someone@example.c";

if(!filter_var($email, FILTER_VALIDATE_EMAIL))
  {
  echo "E-mail is not valid";
  }
else
  {
  echo "E-mail is valid";
  }
		
		
		
		
			$memberData = $this->Member->find('first', array(
					'conditions' => array(
						'Member.id' => '58',
						//'Member.active' => 0
					),
					'recursive'=>0
				));
			
			echo '<pre>';
			print_r($memberData);
			die;
			
		
		
		
		echo '<pre>';
		$array = array(' dingo',' dingokajfkdja  ', 'wombat          ', 'platypus' );
		echo 'first';
		print_r($array);
		
		$secondarray = $this->array_trim( $array );
		echo 'second';
		print_r($secondarray);
	
		die;
		
	}
	
	
	
	// unused old function 
		
	function tutorpay()
	{
		
		Configure::write('debug', 0);
		
		
	/*	App::import('Vendor', 'globalpayment', array(
			'file' => 'globalpayment/lphp.php'
		));*/
		
/*
<!---------------------------------------------------------------------------------
* PHP_FORM_MIN.php - A form processing example showing the minimum 
* number of possible fields for a credit card SALE transaction.
*
* This script processes form data passed in from PHP_FORM_MIN.html
*
*
* Copyright 2003 LinkPoint International, Inc. All Rights Reserved.
* 
* This software is the proprietary information of LinkPoint International, Inc.  
* Use is subject to license terms.
*

		This program is based on the sample SALE_MININFO.php
		
		Depending on your server setup, this script may need to
		be placed in the cgi-bin directory, and the path in the
		calling file PHP_FORM_MIN.html may need to be adjusted
		accordingly.

		NOTE: older versions of PHP and in cases where the PHP.INI
		entry is NOT "register_globals = Off", form data can be
		accessed simply by using the form-field name as a varaible
		name, eg. $myorder["host"] = $host, instead of using the 
		global $_POST[] array as we do here. Passing form fields 
		as demonstrated here provides a higher level of security.

------------------------------------------------------------------------------------>
*/

//	include"lphp.php";
	
	App::Import('Component', 'Lphp');
	
	$mylphp=new LphpComponent();

	# constants
/*	$myorder["host"]       = "secure.linkpt.net";
	$myorder["port"]       = "1129";
	$myorder["keyfile"]    = "./YOURCERT.pem"; # Change this to the name and location of your certificate file 
	$myorder["configfile"] = "1234567";        # Change this to your store number 
*/	
	
	$myorder["host"]       = "staging.linkpt.net";
	$myorder["port"]       = "1129";
	
	// client first data
	$myorder["keyfile"]    = "1909551419.pem"; # Change this to the name and location of your certificate file 
	$myorder["configfile"] = "1909551419";        # Change this to your store number 
	
// jaswant first data
//	$myorder["keyfile"]    = "1909078235.pem"; # Change this to the name and location of your certificate file 
//	$myorder["configfile"] = "1909078235";        # Change this to your store number 
	
	
    
	/*echo '<pre>';
	print_r($this->data);
	die;*/
	
	/*$addfund = array();	
	
	if($this->data['global']['studentEmail'])
	{
	$addfund['AddFund']['student_email'] = $this->data['global']['studentEmail'];
	}
	else
	{
		$studentEmail = $this->Member->find('first',array(
			'conditions'=>array(
			'Member.id' =>$this->Session->read('Member.memberid')
			),
		'recursive'=>-1
		));
		
		$addfund['AddFund']['student_email'] = $studentEmail['Member']['email'];		
	}
	$addfund['AddFund']['request_id']      = uniqid();
	$addfund['AddFund']['amount']          = $this->data['global']['chargetotal'];
	$addfund['AddFund']['payment_status']  = 'pending';
	$addfund['AddFund']['approval_status'] = 'Pending';
	$this->AddFund->create();
	$this->AddFund->save($addfund);
	$paymentid = $this->AddFund->getLastInsertId();
	*/
	
	/*echo $paymentid;
	die;*/
	

	# form data
	
	$myorder["cardnumber"]    = $this->data['global']['cardnumber'];
	$myorder["cardexpmonth"]  = $this->data['global']['cardexpmonth'];
	$myorder["cardexpyear"]   = $this->data['global']['cardexpyear'];
	$myorder["chargetotal"]   = $this->data['global']['chargetotal'];
	$myorder["ordertype"]     = $this->data['global']['ordertype'];
	$myorder["zip"]      = $this->data['global']['bzip'];	
	$myorder["name"]  = $this->data['global']['bname'];
	$myorder["oid"]   = $this->data['global']['paymentid'];
	
	$buyer_name = $this->data['global']['bname'];
	$ammount = $this->data['global']['chargetotal'];
	$paymentid = $this->data['global']['paymentid'];
	
	$currentdate = date('Y-m-d H:i:s');
	
/*	
	echo '<pre>';
	print_r($_POST);
	die;
	*/
	
	
	
/*	if($this->data['global']['cvmnotpres'])
	{
	$myorder["cvmindicator"] = 'not_provided';
	$myorder["cvmvalue"]     = $this->data['global']['cvm'];
	}
	else
	{
	$myorder["cvmindicator"] = 'provided';
	$myorder["cvmvalue"]     = $this->data['global']['cvm'];
	}
	
	*/
	
	

	/*if ($_POST["debugging"])
		$myorder["debugging"]="true";*/

  # Send transaction. Use one of two possible methods  #
//	$result = $mylphp->process($myorder);       # use shared library model
	$result = $mylphp->curl_process($myorder);  # use curl methods
	
	/*echo '<pre>';
	print_r($result);
	die;*/
	
	
	
	
	if ($result["r_approved"] != "APPROVED")    // transaction failed, print the reason
	{
		
	/*	print "Status:  $result[r_approved]<br>\n";
		print "Error:  $result[r_error]<br><br>\n";
	die;*/
		
		$fail_status = $result[r_approved];
		$fail_error = $result[r_error];
		
		$fail_msg = "Status: $fail_status  Error: $fail_error";
		
		$this->Session->setFlash($fail_msg);
		
		/*$this->payData['PaymentHistory']['paypal_status']     = 'unable to process';
		$this->payData['PaymentHistory']['paypal_email']      = '"' . $_POST['payer_email'] . '"';
		$this->payData['PaymentHistory']['paypal_confirm_id'] = '"' . $_POST['txn_id'] . '"';
		$this->payData['PaymentHistory']['paypal_date'] = '"' . $_POST['payment_date'] . '"';
		$this->PaymentHistory->save($this->payData);*/
		
		
		//Update Table
		$confirmId  = '"' . $fail_error . '"';
		$status	 = "'unable to process'"; 
	//	$id = $paymentid; 
		
		$this->PaymentHistory->updateAll(array(
		'PaymentHistory.paypal_confirm_id' => $confirmId,
		'PaymentHistory.paypal_status' => $status,
		), array(
		'PaymentHistory.id' => $paymentid
		));
		
		$this->redirect(array(
					'controller' => 'homes',
					'action' => 'global_gateway_failure'
				));
		
	}
	else	// success
	{		
	
	/*	print "Status: $result[r_approved]<br>\n";
		print "Transaction Code: $result[r_code]<br><br>\n";
		die;*/
		
		$sucess_status = $result[r_approved];
	//	$transaction_code = $result[r_code];
		$order_num = $result[r_ordernum];
		
		$sucess_msg = "Status: $sucess_status  Order Number: $order_num";
		
		$this->Session->setFlash($sucess_msg);
		
							
							$taxid         = $order_num;
							//$email         = $_POST['payer_email'];
							$status        = 'complete';
							$amount        = $ammount;
							$sessionstatus = 'Paided';
							$paymentdate = $currentdate;
							
							$this->PaymentHistory->updateAll(array(
								'PaymentHistory.amount' => "'" . $amount . "'",
								'PaymentHistory.paypal_status' => "'" . $status . "'",
							//	'PaymentHistory.paypal_email' => "'" . $email . "'",
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
							
							
							$eventid = $this->PaymentHistory->find('first',array('conditions'=>array(
																							'PaymentHistory.id'=>$paymentid
																							)
																		 )
														   );
					
				
							$this->TutEvent->updateAll(array(
							'TutEvent.title' => "'Booked'",
							), array(
							'TutEvent.id' => $eventid['PaymentHistory']['tut_event_id']
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
	
		
		
		$this->Session->delete('payment');
		
    	
		$this->redirect(array(
						'controller' => 'homes',
						'action' => 'global_gateway_sucess'
					));
	
	}

# if verbose output has been checked,
# print complete server response to a table
	if ($_POST["verbose"])
	{
		echo "<table border=1>";

		while (list($key, $value) = each($result))
		{
			# print the returned hash 
			echo "<tr>";
			echo "<td>" . htmlspecialchars($key) . "</td>";
			echo "<td><b>" . htmlspecialchars($value) . "</b></td>";
			echo "</tr>";
		}	
			
		echo "</TABLE><br>\n";
	}
		
		
		
		
	}
	
		function design_cdash()
	{
		
		
	
	
		
	}


	
	
	
	
	
	
	
	
	
	
}
?>