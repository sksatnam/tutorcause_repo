<?php
ob_start();
class FileUploadsController extends AppController {
	var $name = 'file_uploads';
	var $layout = "frontend";
	var $helpers = array('Form','Html','Error','Javascript', 'Ajax','Paginator',);
	var $components = array('RequestHandler','Email','MailchimpApi','Ggapi','Cookie');
	var $uses = array('Member','State','userMeta','Group', 'School', 'Course', 'TutCourse','TutEvent','Page','CauseSchool','UserImage','CauseTutor','TutMessage','Privilege','TutRating','PaymentHistory','TutorWithdrawal','TutorToCause','AddFund','CauseWithdrawal','EmailTemplate','TutorRequestCause','UpcomingMember','UpcomingSchool','Charge','StdCourse','Notice','Wage','FileUpload');
	
	// function executes before each action to execute 
	function beforeFilter() {
		
	//	parent::beforeFilter();
		
		
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
		} else if ((!isset($this->params['admin']) && $this->params['action'] == 'checkadminlogin') || $this->action == "index") {
			//echo "<pre> index";print_r($this->Session->read());exit;
		} else {
			if (!$this->checkPrivilege($this->action, $this->Session->read(), false)) {
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'logout'
				));
			}
		}
		
		
		
	}
	
	
	
?>	