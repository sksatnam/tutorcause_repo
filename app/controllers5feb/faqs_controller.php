<?php
ob_start();
class FaqsController extends AppController {
	var $name = 'Faqs';
	var $layout = "frontend";
	var $helpers = array('Form','Html','Error','Javascript', 'Ajax','Paginator',);
	var $components = array('RequestHandler','Email');
	var $uses = array('Member','State','userMeta','Group', 'School', 'Course', 'TutCourse','TutEvent','Faq','Privilege');
	
	
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
	function admin_faq_view() {
		$this->layout="admin";
		$this->set('faqClass','selected');
		if(!$this->RequestHandler->isAjax() && !isset($this->data) ){
			
		$this->Session->delete('faqview');
		}
			
		if (isset($this->data)){
			$this->Session->write('faqview.group_id', $this->data['Faq']['group_id']);
			$this->Session->write('faqview.perpage', $this->data['Faq']['perpage']);
		
			
			$this->data['Faq']['group_id']=$this->Session->read('faqview.group_id');
			$this->data['Faq']['perpage']=$this->Session->read('faqview.perpage');
			
			/*print_r($this->data);
		die;*/		
		}		
		else
		{
		//	$this->Session->delete('faqview');
		$this->data['Faq']['group_id']=$this->Session->read('faqview.group_id');
		
		
		}
				
		if (strlen($this->Session->read('faqview.perpage'))>0){
			
			//echo 'jaswnat';	die;
			$this->data['Faq']['perpage']=$this->Session->read('faqview.perpage');
		}
		else
		{
			$this->data['Faq']['perpage']= 10;
		}
	
			
		  $this->paginate['Faq'] =array(
										'conditions'=> array(
															 'Faq.group_id LIKE'=> "%" . $this->data['Faq']['group_id']
															 ),
										'limit' => $this->data['Faq']['perpage']);
				
	      $faqdata = $this->paginate('Faq');
		
		/*  
		  echo '<pre>';
			print_r($faqdata);
			die;
			*/
		 $this->set('faqdata',$faqdata);
	
			
			if($this->RequestHandler->isAjax()) {
				$this->layout="";
				Configure::write('debug', 0);
				$this->AutoRender=false;
				$this->viewPath = 'elements'.DS.'adminElements';
				$this->render('faqParentPaging');
			}
		}
	
	
		
	//function for adding the parent faq	
	function admin_faq_add() {
				$this->layout="admin";
				$this->set('faqClass','selected');
				//$data['Faq']['group_id'] = $this->data['Member']['group_id'];
		
			if (!empty($this->data)) {
				$data['Faq']['group_id'] = $this->data['Faq']['group_id'];
				$db = $this->Faq->getDataSource();
					
				$this->data['Faq']['created']=$db->expression("NOW()");
				
				if ($this->Faq->save($this->data)) {
					//$this->Session->setFlash(__('The Faq has been saved', true));
					$this->Session->setFlash('The Faq has been saved');
					$this->redirect(array('action'=>'faq_view','admin' => true));
				} else 
				{
				}
			}
	}
	
	//function for editing the parent faq
	function admin_faq_edit($id=NULL) {
		$id=convert_uudecode(base64_decode($id));
		$this->layout="admin";
		$this->set('faqClass','selected');
		//$this->Faq->id = $id;
			if (!empty($this->data)) {
				/*$this->data = $this->Faq->read();
			} else 
			{
				if (!empty($this->data)) {
				$db = $this->Faq->getDataSource();
					$this->data['Faq']['created'] = $db->expression("NOW()");*/
					$this->data['Faq']['id'] = $_POST['faqid'];
					/*print_r($this->data);
					die;*/
					$this->Faq->save($this->data);
					
					$this->Session->setFlash('The Faq has been edited successfully');
					//$this->Session->setFlash('The Faq has been edited successfully', true);
					$this->redirect(array('action'=>'faq_view','admin' => true));
					
			}
			else
			{
				$this->Session->setFlash('The Faq could not be saved. Please, try again.', true);
			}
			$this->data = $this->Faq->find('first',array('conditions' => array('Faq.id' => $id )));
		}


	
	//function for deleteing the parent faq
	function admin_faq_delete($id=NULL) {
		//$id=convert_uudecode(base64_decode($id));
		$this->layout=false;
		$this->autoRender = false;
		Configure::write('debug', 0);
		
		if ($this->RequestHandler->isAjax() && $id)
		{
			
			$delete = $this->Faq->delete($id);
			$this->layout="";
				if($delete){
				echo "deleted";die;
			
			}
	  }
	}
	
	
	function student()
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
	


		
}	
?>
