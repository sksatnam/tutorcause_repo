<?php
ob_start();
class PaymentHistoriesController extends AppController {
	var $name = 'payment_histories';
	var $layout = 'frontend';
	var $helpers = array('Form', 'Html', 'Error', 'Javascript', 'Ajax', 'Paginator');
	var $components = array('RequestHandler', 'Email');
	var $uses = array('School', 'Member', 'State', 'userMeta', 'Group', 'Course', 'TutCourse', 'Privilege', 'TutEvent', 'PaymentHistory', 'TutorWithdrawal', 'TutorToCause', 'CauseWithdrawal', 'AddFund','Charge','CauseTutor','Wage','Api');
	
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
	
	
	/*{
	
	$this->paginate=array(
	'limit'=>10,
	'recursive' => 2,
	);
	
	$Page = $this->paginate('PaymentHistory');
	
	
	$this->set('Page', $Page); 
	
	
	
	if(!$this->RequestHandler->isAjax()) 
	
	{
	
	$this->layout="admin";
	
	
	
	$this->set('paymentClass','selected');
	
	}	
	
	if($this->RequestHandler->isAjax()) 
	
	{
	
	$this->viewPath = 'elements'.DS.'adminElements';
	
	
	
	$this->render('payment_history_paging');            
	
	} 
	
	}*/
	
	function admin_salesreport() {
		$this->layout = 'admin';
		Configure::write('debug', 0);
		
		$this->set('paymentClass', 'selected'); //set main navigation class
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('paymentview');
			
		}
		
		if (isset($this->data)) {
			//pr($this->data);exit;
			$this->Session->write('paymentview.dateFrom', $this->data['PaymentHistory']['dateFrom']);
			$this->Session->write('paymentview.dateTo', $this->data['PaymentHistory']['dateTo']);
			
			$this->data['PaymentHistory']['dateFrom'] = $this->Session->read('paymentview.dateFrom');
			$this->data['PaymentHistory']['dateTo']   = $this->Session->read('paymentview.dateTo');
			
		} else {
			$this->data['PaymentHistory']['dateFrom'] = $this->Session->read('paymentview.dateFrom');
			$this->data['PaymentHistory']['dateTo']   = $this->Session->read('paymentview.dateTo');
			
		}
		
		
		/*
		if (strlen($this->Session->read('paymentview.dateTo'))>0){
		$this->data['PaymentHistory']['dateTo']=$this->Session->read('paymentview.dateTo');
		}
		else
		{
		/*$tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));*/
		//$this->data['PaymentHistory']['dateTo']=date('Y-m-d',+1 day);
		//echo date('Y-m-d',strtotime()+1day);exit;
		
		//}
		if (strlen($this->Session->read('paymentview.dateFrom')) > 0) {
			$this->data['PaymentHistory']['dateFrom'] = $this->Session->read('paymentview.dateFrom');
		} else {
			$this->data['PaymentHistory']['dateFrom'] = '';
			
		}
		
		/*$conditions=array();	
		$conditions =array_merge($conditions,array('date(PaymentHistory.paypal_date) BETWEEN ? AND ?' => array($this->data['PaymentHistory']['dateFrom'],$this->data['PaymentHistory']['dateTo'])));
		*/
		$conditions = array();
		
		$session_state = array('Paided','Completed');
		
		$conditions = array_merge($conditions, array(
			'PaymentHistory.session_status' => $session_state
		));
		
		if (isset($this->data['PaymentHistory']['dateFrom']) && $this->data['PaymentHistory']['dateFrom']!='' ) {
			$conditions = array_merge($conditions, array(
				'PaymentHistory.paypal_date >=' => $this->data['PaymentHistory']['dateFrom']
			));
			
		}
		if (isset($this->data['PaymentHistory']['dateTo']) && $this->data['PaymentHistory']['dateTo']!='' ) {
			$conditions = array_merge($conditions, array(
				'PaymentHistory.paypal_date <=' => $this->data['PaymentHistory']['dateTo']
			));
			
		}
		if (strlen($this->Session->read('paymentview.perpage')) > 0) {
			$this->data['PaymentHistory']['perpage'] = $this->Session->read('paymentview.perpage');
		} else {
			$this->data['PaymentHistory']['perpage'] = 10;
		}
		$this->paginate['PaymentHistory'] = array(
			'conditions' => $conditions,
			
			'limit' => $this->data['PaymentHistory']['perpage'],
			//'order' => array('student.userMeta.fname' => 'desc' ),
			'recursive' => 2
		);
		
		
		$payments = $this->paginate('PaymentHistory');
		
	/*	echo '<pre>';
		print_r($this->data);
		print_r($payments);
		print_r($conditions);
		die;*/
		
		
		$this->set('payments', $payments);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'payments';
			$this->render('payment_history_paging');
		}
		
	}
	
	function admin_exportpaymentcsv() {
		$this->paginate['PaymentHistory'] = array(
			//'limit' => $this->data['PaymentHistory']['perpage'],
			//'order' => array('student.userMeta.fname' => 'desc' ),
			'recursive' => 2
		);
		
		
		
		$Page = $this->paginate('PaymentHistory');
		
		/*echo "<pre>";print_r($Page);exit;*/
		$data = "S.No,Student Name,Tutor Name,Course,Hours,Amount,Email,Transaction Id\n";
		$i    = 1;
		foreach ($Page as $pages):
			$data .= $i . ",";
			
			$studentname = $pages['student']['userMeta']['fname'] . ' ' . $pages['student']['userMeta']['lname'];
			$data .= $studentname . ",";
			
			$tutorname = $pages['tutor']['userMeta']['fname'] . ' ' . $pages['tutor']['userMeta']['lname'];
			$data .= $tutorname . ",";
			
			$course = $pages['PaymentHistory']['booked_course'];
			$data .= $course . ",";
			
			$hour = $pages['PaymentHistory']['tutoring_hours'];
			$data .= $hour . ",";
			
			$amount = $pages['PaymentHistory']['amount'];
			$data .= $amount . ",";
			
			$email = $pages['PaymentHistory']['paypal_email'];
			$data .= $email . ",";
			
			$trancid = $pages['PaymentHistory']['paypal_confirm_id'];
			$data .= $trancid . "\n";
			
			$i++;
		endforeach;
		echo $data;
		header("Content-type:text/octect-stream");
		header("Content-Disposition:attachment;filename=Payments(" . date('m/d/Y') . ").csv");
		die();
	}
	
	function admin_tutor_withdrawal() {
		$this->layout = 'admin';
		Configure::write('debug', 0);
		
		$this->set('paymentClass', 'selected'); //set main navigation class
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('tutorMoney');
		}
		
		if (isset($this->data)) {
			//pr($this->data);exit;
			$this->Session->write('tutorMoney.dateFrom', $this->data['TutorWithdrawal']['dateFrom']);
			$this->Session->write('tutorMoney.dateTo', $this->data['TutorWithdrawal']['dateTo']);
			$this->Session->write('tutorMoney.email', $this->data['TutorWithdrawal']['email']);
			
			$this->data['TutorWithdrawal']['dateFrom'] = $this->Session->read('tutorMoney.dateFrom');
			$this->data['TutorWithdrawal']['dateTo']   = $this->Session->read('tutorMoney.dateTo');
			$this->data['TutorWithdrawal']['email']    = $this->Session->read('tutorMoney.email');
			
			
		} else {
			$this->data['TutorWithdrawal']['dateFrom'] = $this->Session->read('tutorMoney.dateFrom');
			$this->data['TutorWithdrawal']['dateTo']   = $this->Session->read('tutorMoney.dateTo');
			$this->data['TutorWithdrawal']['email']    = $this->Session->read('tutorMoney.email');
		}
		
		
		/*
		if (strlen($this->Session->read('paymentview.dateTo'))>0){
		$this->data['PaymentHistory']['dateTo']=$this->Session->read('paymentview.dateTo');
		}
		else
		{
		/*$tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));*/
		//$this->data['PaymentHistory']['dateTo']=date('Y-m-d',+1 day);
		//echo date('Y-m-d',strtotime()+1day);exit;
		
		//}
		
		if (strlen($this->Session->read('tutorMoney.dateFrom')) > 0) {
			$this->data['TutorWithdrawal']['dateFrom'] = $this->Session->read('tutorMoney.dateFrom');
		} else {
			$this->data['TutorWithdrawal']['dateFrom'] = '';
		}
		
		/*$conditions=array();	
		$conditions =array_merge($conditions,array('date(PaymentHistory.paypal_date) BETWEEN ? AND ?' => array($this->data['PaymentHistory']['dateFrom'],$this->data['PaymentHistory']['dateTo'])));
		*/
		$conditions = array();
		
		//	$conditions=array_merge($conditions,array('PaymentHistory.session_status' => 'Paided'));
		
		if (isset($this->data['TutorWithdrawal']['dateFrom']) && $this->data['TutorWithdrawal']['dateFrom'] != '') {
			$conditions = array_merge($conditions, array(
				'TutorWithdrawal.created >=' => $this->data['TutorWithdrawal']['dateFrom']
			));
			
		}
		if (isset($this->data['TutorWithdrawal']['dateTo']) && $this->data['TutorWithdrawal']['dateTo'] != '') {
			$conditions = array_merge($conditions, array(
				'TutorWithdrawal.created <=' => $this->data['TutorWithdrawal']['dateTo']
			));
			
		}
		if (isset($this->data['TutorWithdrawal']['email']) && $this->data['TutorWithdrawal']['email'] != '') {
			$conditions = array_merge($conditions, array(
				'Member.email' => $this->data['TutorWithdrawal']['email']
			));
			
		}
		if (strlen($this->Session->read('tutorMoney.perpage')) > 0) {
			$this->data['TutorWithdrawal']['perpage'] = $this->Session->read('tutorMoney.perpage');
		} else {
			$this->data['TutorWithdrawal']['perpage'] = 10;
		}
		$this->paginate['TutorWithdrawal'] = array(
			'conditions' => $conditions,
			'limit' => 10,
			'order' => array('TutorWithdrawal.id' => 'desc' ),
			'recursive' => 2
		);
		
		
		$tutorrequest = $this->paginate('TutorWithdrawal');
		
		/*echo '<pre>';
		print_r($this->data);
		print_r($conditions);
		print_r($tutorrequest);
		die;*/
		
		
		/*echo '<pre>';
		//print_r($this->data);
		//print_r($payments);
		print_r($conditions);
		die;
		*/
		
		$this->set('tutorrequest', $tutorrequest);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'payments';
			$this->render('tutor_withdrawal');
		}
		
	}
	
	function admin_cause_grant($id = NULL) {
		$this->layout = 'admin';
		Configure::write('debug', 0);
		
		$this->set('paymentClass', 'selected'); //set main navigation class
		
		
	/*	$causedata = $this->TutorToCause->find('all', array(
			'conditions' => array(
				'TutorToCause.withdrawal_id' => $id
			),
			'recursive' => 2
		));*/
		
		
		$tutordata = $this->TutorWithdrawal->find('first', array(
			'conditions' => array(
				'TutorWithdrawal.id' => $id
			),
			'recursive' => 2
		));
		
		
		$causedata = $this->CauseTutor->find('all', array(
			'conditions' => array(
			'CauseTutor.tutor_id' => $tutordata['TutorWithdrawal']['tutor_id'],
			'CauseTutor.status' => 1,
			'CauseTutor.grant !=' => 0
			),
			'recursive' => 2
		));
		
		
		$tutorcausefee = $this->Charge->find('first',array('conditions'=>
									array('Charge.id' => '1')
									)
							  );
		
		
		$this->set('causedata', $causedata);
		
		$this->set('tutorcausefee',$tutorcausefee);
		
		$this->set('tutordata', $tutordata);
		
		$this->set('withdrawalid', $id);
		
		
		
		
		/*	echo '<pre>';
		print_r($tutordata);
		
		echo $id;
		die;*/
		
		
	}
	
	
	
	
	function admin_refund_request() {
		$this->layout = 'admin';
		Configure::write('debug', 0);
		
		$this->set('paymentClass', 'selected'); //set main navigation class
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('paymentview');
			
		}
		
		if (isset($this->data)) {
			$data = $this->data;
			if (isset($data['PaymentHistory']['id'])) {
				if ($this->PaymentHistory->updateAll(array(
					'PaymentHistory.session_status' => "'Refunded'",
					'PaymentHistory.approval_date' => "'" . date("Y-m-d H:i:s") . "'"
				), array(
					'PaymentHistory.id' => $data['PaymentHistory']['id']
				))) {
					$this->Member->updateAll(array(
						'Member.balance' => 'Member.balance+' . $data['PaymentHistory']['amount']
					), array(
						'Member.id' => $data['PaymentHistory']['student_id']
					));
					$this->Member->updateAll(array(
						'Member.balance' => 'Member.balance-' . $data['PaymentHistory']['amount']
					), array(
						'Member.id' => $data['PaymentHistory']['tutor_id']
					));
					$this->Session->setFlash('Tutor Request is Refunded');
				}
				$this->redirect(array(
					'controller' => 'payment_histories',
					'action' => 'refund_request',
					'admin' => true
				));
				
			} else {
				//pr($this->data);exit;
				$this->Session->write('paymentview.dateFrom', $this->data['PaymentHistory']['dateFrom']);
				$this->Session->write('paymentview.dateTo', $this->data['PaymentHistory']['dateTo']);
				
				$this->data['PaymentHistory']['dateFrom'] = $this->Session->read('paymentview.dateFrom');
				$this->data['PaymentHistory']['dateTo']   = $this->Session->read('paymentview.dateTo');
			}
		} else {
			$this->data['PaymentHistory']['dateFrom'] = $this->Session->read('paymentview.dateFrom');
			$this->data['PaymentHistory']['dateTo']   = $this->Session->read('paymentview.dateTo');
			
		}
		
		
		/*
		if (strlen($this->Session->read('paymentview.dateTo'))>0){
		$this->data['PaymentHistory']['dateTo']=$this->Session->read('paymentview.dateTo');
		}
		else
		{
		/*$tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));*/
		//$this->data['PaymentHistory']['dateTo']=date('Y-m-d',+1 day);
		//echo date('Y-m-d',strtotime()+1day);exit;
		
		//}
		if (strlen($this->Session->read('paymentview.dateFrom')) > 0) {
			$this->data['PaymentHistory']['dateFrom'] = $this->Session->read('paymentview.dateFrom');
		} else {
			$this->data['PaymentHistory']['dateFrom'] = '';
			
		}
		
		/*$conditions=array();	
		$conditions =array_merge($conditions,array('date(PaymentHistory.paypal_date) BETWEEN ? AND ?' => array($this->data['PaymentHistory']['dateFrom'],$this->data['PaymentHistory']['dateTo'])));
		*/
		$conditions = array();
		
		$conditions = array_merge($conditions, array(
			'PaymentHistory.session_status' => array(
				'Refunded',
				'Refund'
			)
		));
		
		if (isset($this->data['PaymentHistory']['dateFrom'])) {
			$conditions = array_merge($conditions, array(
				'PaymentHistory.request_date >=' => $this->data['PaymentHistory']['dateFrom']
			));
			
		}
		if (isset($this->data['PaymentHistory']['dateTo'])) {
			$conditions = array_merge($conditions, array(
				'PaymentHistory.request_date <=' => $this->data['PaymentHistory']['dateTo']
			));
			
		}
		if (strlen($this->Session->read('paymentview.perpage')) > 0) {
			$this->data['PaymentHistory']['perpage'] = $this->Session->read('paymentview.perpage');
		} else {
			$this->data['PaymentHistory']['perpage'] = 10;
		}
		$this->paginate['PaymentHistory'] = array(
			'conditions' => $conditions,
			'limit' => $this->data['PaymentHistory']['perpage'],
			//'order' => array('student.userMeta.fname' => 'desc' ),
			'recursive' => 2
		);
		
		
		$payments = $this->paginate('PaymentHistory');
		
		/*echo '<pre>';
		//print_r($this->data);
		print_r($payments);
		die;
		*/
		
		
		$this->set('payments', $payments);
		/*echo '<pre>';
		//print_r($this->data);
		print_r($payments);
		die*/
		
		
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'payments';
			$this->render('refund_request');
		}
		
	}
	
	function admin_cause_withdrawal() {
		$this->layout = 'admin';
		Configure::write('debug', 0);
		
		$this->set('paymentClass', 'selected'); //set main navigation class
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('causeMoney');
		}
		
		if (isset($this->data)) {
			//pr($this->data);exit;
			$this->Session->write('causeMoney.dateFrom', $this->data['CauseWithdrawal']['dateFrom']);
			$this->Session->write('causeMoney.dateTo', $this->data['CauseWithdrawal']['dateTo']);
			$this->Session->write('causeMoney.email', $this->data['CauseWithdrawal']['email']);
			
			$this->data['CauseWithdrawal']['dateFrom'] = $this->Session->read('causeMoney.dateFrom');
			$this->data['CauseWithdrawal']['dateTo']   = $this->Session->read('causeMoney.dateTo');
			$this->data['CauseWithdrawal']['email']    = $this->Session->read('causeMoney.email');
			
			
		} else {
			$this->data['CauseWithdrawal']['dateFrom'] = $this->Session->read('causeMoney.dateFrom');
			$this->data['CauseWithdrawal']['dateTo']   = $this->Session->read('causeMoney.dateTo');
			$this->data['CauseWithdrawal']['email']    = $this->Session->read('causeMoney.email');
		}
		
		
		/*
		if (strlen($this->Session->read('paymentview.dateTo'))>0){
		$this->data['PaymentHistory']['dateTo']=$this->Session->read('paymentview.dateTo');
		}
		else
		{
		/*$tomorrow = mktime(0, 0, 0, date("m"), date("d")+1, date("y"));*/
		//$this->data['PaymentHistory']['dateTo']=date('Y-m-d',+1 day);
		//echo date('Y-m-d',strtotime()+1day);exit;
		
		//}
		
		if (strlen($this->Session->read('causeMoney.dateFrom')) > 0) {
			$this->data['CauseWithdrawal']['dateFrom'] = $this->Session->read('causeMoney.dateFrom');
		} else {
			$this->data['CauseWithdrawal']['dateFrom'] = '';
		}
		
		/*$conditions=array();	
		$conditions =array_merge($conditions,array('date(PaymentHistory.paypal_date) BETWEEN ? AND ?' => array($this->data['PaymentHistory']['dateFrom'],$this->data['PaymentHistory']['dateTo'])));
		*/
		$conditions = array();
		
		//	$conditions=array_merge($conditions,array('PaymentHistory.session_status' => 'Paided'));
		
		if (isset($this->data['CauseWithdrawal']['dateFrom']) && $this->data['CauseWithdrawal']['dateFrom'] != '') {
			$conditions = array_merge($conditions, array(
				'CauseWithdrawal.created >=' => $this->data['CauseWithdrawal']['dateFrom']
			));
			
		}
		if (isset($this->data['CauseWithdrawal']['dateTo']) && $this->data['CauseWithdrawal']['dateTo'] != '') {
			$conditions = array_merge($conditions, array(
				'CauseWithdrawal.created <=' => $this->data['CauseWithdrawal']['dateTo']
			));
			
		}
		if (isset($this->data['CauseWithdrawal']['email']) && $this->data['CauseWithdrawal']['email'] != '') {
			$conditions = array_merge($conditions, array(
				'Member.email' => $this->data['CauseWithdrawal']['email']
			));
			
		}
		if (strlen($this->Session->read('causeMoney.perpage')) > 0) {
			$this->data['CauseWithdrawal']['perpage'] = $this->Session->read('causeMoney.perpage');
		} else {
			$this->data['CauseWithdrawal']['perpage'] = 10;
		}
		$this->paginate['CauseWithdrawal'] = array(
			'conditions' => $conditions,
			'limit' => 10,
			'order' => array('CauseWithdrawal.id' => 'desc' ),
			'recursive' => 2
		);
		
		
		$causerequest = $this->paginate('CauseWithdrawal');
		
		/*echo '<pre>';
		print_r($this->data);
		print_r($conditions);
		print_r($tutorrequest);
		die;*/
		
		
		/*echo '<pre>';
		//print_r($this->data);
		//print_r($payments);
		print_r($conditions);
		die;
		*/
		
		$this->set('causerequest', $causerequest);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'payments';
			$this->render('cause_withdrawal');
		}
		
	}
	
	function admin_cause_money($id = NULL) {
		$this->layout = 'admin';
		Configure::write('debug', 0);
		
		$this->set('paymentClass', 'selected'); //set main navigation class
		
		$causedata = $this->CauseWithdrawal->find('first', array(
			'conditions' => array(
				'CauseWithdrawal.id' => $id
			),
			'recursive' => 2
		));
		
		
		/*	echo '<pre>';
		print_r($causedata);
		die;*/
		
		$this->set('causedata', $causedata);
		$this->set('withdrawalid', $id);
		
		
		/*	echo '<pre>';
		print_r($tutordata);
		
		echo $id;
		die;*/
		
		
	}
	function admin_approve_cause_withdrawal() {
		$this->layout = 'admin';
		Configure::write('debug', 0);
		
		/*	echo '<pre>';
		print_r($this->data);
		die;
		*/
		
		if (isset($this->data)) {
			
			
			if ($this->data['CauseWithdrawal']['status'] == 'Approved') {
				
				
				/*$this->data['CauseWithdrawal']['approval_date'] = date("Y-m-d H:i:s", time());
				
				$this->data['CauseWithdrawal']['admin_id'] = $this->Session->read('Admin.id');
				
				$this->CauseWithdrawal->save($this->data);
				
				
				$this->Session->setFlash('Cause Request is Approved');*/
				
				
				
				
			} else if ($this->data['CauseWithdrawal']['status'] == 'Cancelled') {
				$this->data['CauseWithdrawal']['admin_id'] = $this->Session->read('Admin.id');
				
				$this->data['CauseWithdrawal']['approval_date'] = date("Y-m-d H:i:s", time());
				
				$this->CauseWithdrawal->save($this->data);
				
				$this->Member->updateAll(array(
					'Member.creditable_balance' => $this->data['Member']['creditable_balance']
				), array(
					'Member.id' => $this->data['Member']['id']
				));
				
				$this->Session->setFlash('Cause Request is Cancelled');
			}
			
			$this->redirect(array(
				'controller' => 'payment_histories',
				'action' => 'cause_withdrawal',
				'admin' => true
			));
		}
	}
	
	function admin_student_fund() {
		$this->layout = 'admin';
		Configure::write('debug', 0);
		$this->set('paymentClass', 'selected');
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('paymentview');
		}
		if (isset($this->data)) {
			$data = $this->data;
			if (isset($data['PaymentHistory']['id'])) {
				if ($this->AddFund->updateAll(array(
					'AddFund.approval_status' => "'Approved'",
					'AddFund.approval_date' => "'" . date("Y-m-d H:i:s") . "'"
				), array(
					'AddFund.id' => $data['PaymentHistory']['id']
				))) {
					$this->Session->setFlash('Student Fund Approved');
				}
				$this->redirect(array(
					'controller' => 'payment_histories',
					'action' => 'student_fund',
					'admin' => true
				));
				
			} else {
				$this->Session->write('paymentview.dateFrom', $this->data['PaymentHistory']['dateFrom']);
				$this->Session->write('paymentview.dateTo', $this->data['PaymentHistory']['dateTo']);
				
				$this->data['PaymentHistory']['dateFrom'] = $this->Session->read('paymentview.dateFrom');
				$this->data['PaymentHistory']['dateTo']   = $this->Session->read('paymentview.dateTo');
			}
		} else {
			$this->data['PaymentHistory']['dateFrom'] = $this->Session->read('paymentview.dateFrom');
			$this->data['PaymentHistory']['dateTo']   = $this->Session->read('paymentview.dateTo');
			
		}
		
		if (strlen($this->Session->read('paymentview.dateFrom')) > 0) {
			$this->data['PaymentHistory']['dateFrom'] = $this->Session->read('paymentview.dateFrom');
		} else {
			$this->data['PaymentHistory']['dateFrom'] = '';
			
		}
		$conditions = array();
		$conditions = array_merge($conditions, array(
			'AddFund.payment_status' => 'complete'
		));
		
		if (isset($this->data['PaymentHistory']['dateFrom'])) {
			$conditions = array_merge($conditions, array(
				'AddFund.created >=' => $this->data['PaymentHistory']['dateFrom']
			));
			
		}
		if (isset($this->data['PaymentHistory']['dateTo'])) {
			$conditions = array_merge($conditions, array(
				'AddFund.created <=' => $this->data['PaymentHistory']['dateTo']
			));
			
		}
		if (strlen($this->Session->read('paymentview.perpage')) > 0) {
			$this->data['PaymentHistory']['perpage'] = $this->Session->read('paymentview.perpage');
		} else {
			$this->data['PaymentHistory']['perpage'] = 10;
		}
		$this->paginate['AddFund'] = array(
			'conditions' => $conditions,
			'limit' => $this->data['PaymentHistory']['perpage']
		);
		$payments                  = $this->paginate('AddFund');
		$this->set('payments', $payments);
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'payments';
			$this->render('student_fund');
		}
	}
	
	function admin_approve_tutor_withdrawal() {
		$this->layout = 'admin';
		Configure::write('debug', 0);
		
		
		if (isset($this->data)) {
			if ($this->data['TutorWithdrawal']['status'] == 'Approved') {
				
				
			/*	$this->data['TutorWithdrawal']['approval_date'] = date("Y-m-d H:i:s", time());
				
				$this->data['TutorWithdrawal']['admin_id'] = $this->Session->read('Admin.id');
				
				$this->TutorWithdrawal->save($this->data);
				
				
				$causedata = $this->TutorToCause->find('all', array(
					'conditions' => array(
						'TutorToCause.withdrawal_id' => $this->data['TutorWithdrawal']['id']
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
					
				}*/
				
				$this->Session->setFlash('Tutor Request is Approved');
				
				
			} else if ($this->data['TutorWithdrawal']['status'] == 'Cancelled') {
				
				
				$deletecausegrant = $this->TutorToCause->find('all', array(
					'conditions' => array(
						'TutorToCause.withdrawal_id' => $this->data['TutorWithdrawal']['id']
					)
				));
				
				
				foreach ($deletecausegrant as $dcg) {
					$this->TutorToCause->delete($dcg['TutorToCause']['id']);
				}
				
				$this->data['TutorWithdrawal']['admin_id'] = $this->Session->read('Admin.id');
				
				$this->data['TutorWithdrawal']['approval_date'] = date("Y-m-d H:i:s", time());
				
				$this->TutorWithdrawal->save($this->data);
				
				$this->Member->updateAll(array(
					'Member.creditable_balance' => $this->data['Member']['creditable_balance']
				), array(
					'Member.id' => $this->data['Member']['id']
				));
				
				$this->Session->setFlash('Tutor Request is Cancelled');
			}
			
			$this->redirect(array(
				'controller' => 'payment_histories',
				'action' => 'tutor_withdrawal',
				'admin' => true
			));
		}
		
		
		
	}
	
	function admin_charges()
	{
		$this->layout = 'admin';
		
		Configure::write('debug', 0);
		
		$this->set('paymentClass', 'selected');		
		
		if (isset($this->data)) {
			if ($this->data['Charge']['tutorcause_charge'] != '') {
				
				$this->Charge->updateAll(array(
					'Charge.tutorcause_charge' => "'".$this->data['Charge']['tutorcause_charge']."'"
				), array(
					'Charge.id' => '1'
				));
			
				$this->Session->setFlash('Sucessfully changed TutorCause Fees.');
			} 
			
		}
		
		$tutorcausefee = $this->Charge->find('first',array('conditions'=>
											array('Charge.id' => '1')
											)
									  );
		
		$this->set('tutorcausefee',$tutorcausefee);
		
		
	}
	
	function admin_minimum_wage()
	{
		
		$this->layout = 'admin';
		
		Configure::write('debug', 0);
		
		$this->set('paymentClass', 'selected');		
		
		if (isset($this->data)) {
			
			
		/*echo '<pre>';
		print_r($_POST);
		die;*/
			
			if ($this->data['Wage']['max_wage'] != '' && $this->data['Wage']['min_wage'] != '') {
				
				if(isset($this->data['Wage']['zero_allowed']))
				{
					$this->data['Wage']['zero_allowed'] = 1;
				}
				else
				{
					$this->data['Wage']['zero_allowed'] = 0;
				}
				
				
				$this->Wage->updateAll(array(
					'Wage.max_wage' => "'".$this->data['Wage']['max_wage']."'",
					'Wage.min_wage' => "'".$this->data['Wage']['min_wage']."'",
					'Wage.zero_allowed' => "'".$this->data['Wage']['zero_allowed']."'"
				), array(
					'Wage.id' => '1'
				));
			
				$this->Session->setFlash('Sucessfully changed minimum wage.');
			} 
			
		}
		
		$wages = $this->Wage->find('first',array('conditions'=>
											array('Wage.id' => '1')
											)
									  );
		
		$this->set('wages',$wages);
		
		
	}
	
	
	function admin_twiddla()
	{
		
		
		$this->layout = 'admin';
		
		Configure::write('debug', 0);
		
		$this->set('paymentClass', 'selected');		
		
		if (isset($this->data)) {
			
		$this->Api->updateAll(array(
			'Api.password' => "'" . base64_encode(convert_uuencode($this->data['Api']['pwd'])) . "'",
			'Api.username' => "'" . $this->data['Api']['username'] . "'"
			), array(
			'Api.id' => 1
			) 
			);
			
		$this->Session->setFlash('Twiddla login detail changed successfully');
			
		/*echo '<pre>';
		print_r($_POST);
		die;*/
		}
		
		$apis = $this->Api->find('first',array('conditions'=>
											array('Api.id' => '1')
											)
									  );
		
	/*	echo '<pre>';
		print_r($apis);
		die;*/
		
		
		$this->set('apis',$apis);
		
	}
	
	
	
	
	
}
?>