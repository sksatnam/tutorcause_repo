<?php
ob_start();
class NoticesController extends AppController {
	var $name = 'notices';
	var $layout = "frontend";
	var $helpers = array('Form','Html','Error','Javascript', 'Ajax','Paginator',);
	var $components = array('RequestHandler','Email');
	var $uses = array('Member','State','userMeta','Group', 'School', 'Course', 'TutCourse','TutEvent','Faq','Privilege','Notice');
	
	
	function beforeFilter(){
		
		parent::beforeFilter();
		
	/*	
		$states = $this->State->find('all');//retireve all states
		$states = $this->State->find('all',array('fields'=>array('State.state_code','State.state_name')));//retireve all states
		$states = Set::combine($states,'{n}.State.state_code','{n}.State.state_name');
		$this->set("states",$states);*/
		
		
		
		if(isset($this->params['admin']) && $this->params['action'] != 'admin_login'){
			if(!$this->checkPrivilege($this->action,$this->Session->read(),true)){
				$this->redirect(array('controller'=>'members','action' => 'login','admin' => true));
			}
		} else if(isset($this->params['admin']) && $this->params['action'] == 'admin_login'){
			if($this->checkPrivilege($this->action,$this->Session->read(),true)){
				$this->redirect(array('controller'=>'members','action' => 'dashboard','admin' => true));
			}
		} else if((!isset($this->params['admin']) && $this->params['action'] == 'checkadminlogin') || $this->action == "index"){
			//echo "<pre> index";print_r($this->Session->read());exit;
		}
		else {
			if(!$this->checkPrivilege($this->action,$this->Session->read(),false)){
			//	$this->redirect(array('controller'=>'members','action' => 'index'));
			}
		}
		
		
		// check session of users
		if($this->Session->read('Member.memberid')){
		/*	echo 'jaswnat';
			die;*/
		}
		else{
			
			/*echo 'facebook';
			die;*/
			
		App::import('Vendor', 'facebook', array(
			'file' => 'facebook/facebook.php'
		));
		
		$facebook = new Facebook(array(
     		'appId'  => '229378733769669',
			'secret' => 'b69ba074e4ff6b4f76a915c2f0f8e094',
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
		
		
		
		
	}
	
	// parents faqs operations start
	// view parents FAQ's with jquery pagination
	function admin_notice_view() {
		
		Configure::write('debug', 0);
		
		$this->layout="admin";
		$this->set('manageClass','selected');
		
		
		if(!$this->RequestHandler->isAjax() && !isset($this->data) ){
			
		$this->Session->delete('noticeview');
		}
			
		if (isset($this->data)){
			$this->Session->write('noticeview.group_id6', $this->data['Notice']['group_id6']);
			$this->Session->write('noticeview.group_id7', $this->data['Notice']['group_id7']);
			$this->Session->write('noticeview.group_id8', $this->data['Notice']['group_id8']);
			$this->Session->write('noticeview.perpage', $this->data['Notice']['perpage']);
		
		}		
		else
		{
		
		
		}
		
			$this->data['Notice']['group_id6']=$this->Session->read('noticeview.group_id6');
			$this->data['Notice']['group_id7']=$this->Session->read('noticeview.group_id7');
			$this->data['Notice']['group_id8']=$this->Session->read('noticeview.group_id8');
			$this->data['Notice']['perpage']=$this->Session->read('noticeview.perpage');
				
		if (strlen($this->Session->read('noticeview.perpage'))>0){
		
			$this->data['Notice']['perpage']=$this->Session->read('noticeview.perpage');
		}
		else
		{
			$this->data['Notice']['perpage']= 10;
		}
		
		
		$conditions = array();
		
		
		if (isset($this->data['Notice']['group_id6']) && $this->data['Notice']['group_id6']!='' ) {
			$conditions = array_merge($conditions, array(
				'Notice.group_id  LIKE' => "%". $this->data['Notice']['group_id6'] . "%"
			));
		}
		
		if (isset($this->data['Notice']['group_id7']) && $this->data['Notice']['group_id7']!='') {
			$conditions = array_merge($conditions, array(
				'Notice.group_id  LIKE' => "%". $this->data['Notice']['group_id7'] . "%"
			));
		}
		
		if (isset($this->data['Notice']['group_id8']) && $this->data['Notice']['group_id8']!='') {
			$conditions = array_merge($conditions, array(
				'Notice.group_id  LIKE' => "%". $this->data['Notice']['group_id8'] . "%"
			));
		}
		
	
		if(count($conditions))
		{
		  $this->paginate['Notice'] =array(
										'conditions'=> $conditions,
										'limit' => $this->data['Notice']['perpage'],
										'order' => array('Notice.id' => 'desc' ),
										);
		  
		}
		else
		{
		  $this->paginate['Notice'] =array(
									'limit' => $this->data['Notice']['perpage'],
									'order' => array('Notice.id' => 'desc' ),
									);
			
		}	
		
	/*	echo '<pre>';
		print_r($this->data);
		die;
		*/
		  	
	     $noticedata = $this->paginate('Notice');
		 
		/* echo '<pre>';
		 print_r($noticedata);
		 die;
		*/
	
		 $this->set('noticedata',$noticedata);
	
			
			if($this->RequestHandler->isAjax()) {
				
				$this->layout="";
				Configure::write('debug', 0);
				$this->AutoRender=false;
				$this->viewPath = 'elements'.DS.'adminElements';
				$this->render('notice_paging');
			}
		}
	
	
		
	//function for adding the notice	
	function admin_notice_add($id = null ) {
		
		Configure::write('debug', 0);
		
				$this->layout="admin";
				$this->set('manageClass','selected');
				//$data['Faq']['group_id'] = $this->data['Member']['group_id'];
		
		
			if (!empty($this->data)) {
				
				$group = array();
				
				if($this->data['Notice']['group_id6'])
				{
					$group[] = $this->data['Notice']['group_id6'];
				}
				
				if($this->data['Notice']['group_id7'])
				{
					$group[] = $this->data['Notice']['group_id7'];
				}
				
				if($this->data['Notice']['group_id8'])
				{
					$group[] = $this->data['Notice']['group_id8'];
				}
				
				$comma_separated = implode(",", $group);
				
				$this->data['Notice']['group_id'] = $comma_separated;
				
			/*	echo '<pre>';
				print_r($_POST);
				print_r($group);
				echo count($group);
				die;*/
				
				if(count($group)==0)
				{
					$this->Session->setFlash('Please check Usertype');
					$this->redirect($this->referer());
				}
				
				if($this->data['Notice']['id'])
				{
					
				//	$this->data['Notice']['id'] = $id;
					
					if ($this->Notice->save($this->data)) {
						$this->Session->setFlash('The Notice has been Edited');
						$this->redirect(array('action'=>'notice_view','admin' => true));
					}
					
				}
				else
				{
					if ($this->Notice->save($this->data)) {
						$this->Session->setFlash('The Notice has been saved');
						$this->redirect(array('action'=>'notice_view','admin' => true));
					}
				}
				
			}
			
			
				if($id)
				{
				$this->data = $this->Notice->find('first',array(
															'conditions'=>array('Notice.id'=>$id),
																				)
											  );
				
				}
				
			
			
	}
	
	
	
	//function for deleteing the Notice
	function admin_notice_delete($id=NULL) {
		//$id=convert_uudecode(base64_decode($id));
		$this->layout=false;
		$this->autoRender = false;
		Configure::write('debug', 0);
		
			if ($this->RequestHandler->isAjax() && $id)
			{
				
				$delete = $this->Notice->delete($id);
				$this->layout="";
					if($delete){
					echo "deleted";
					die;
					}
			}
	}
	
	
/*	function student()
	{
		
			$studentfaq = $this->Faq->find('all',array('conditions'=>array('Faq.group_id'=>8)));
			
			$this->set('studentfaq',$studentfaq);
	}
	
	function tutor()
	{
			$tutorfaq = $this->Faq->find('all',array('conditions'=>array('Faq.group_id'=>7)));
			
			$this->set('tutorfaq',$tutorfaq);
	}
	
	function cause()
	{
			$causefaq = $this->Faq->find('all',array('conditions'=>array('Faq.group_id'=>6)));
			
			$this->set('causefaq',$causefaq);
	}
	*/


		
}	
?>
