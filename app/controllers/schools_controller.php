<?php
ob_start();
class SchoolsController extends AppController {
	var $name = 'Schools';
	var $layout = 'frontend';
	var $helpers = array('Form', 'Html', 'Error', 'Javascript', 'Ajax', 'Paginator');
	var $components = array('RequestHandler', 'Email');
	var $uses = array('School', 'Member', 'State', 'userMeta', 'Group', 'Course', 'TutCourse', 'Privilege','UpcomingSchool','UpcomingMember','Timezone');
	
	// function executes before each action to execute 
	function beforeFilter() {
		
		parent::beforeFilter();
		
		//echo "<pre>"; print_r($this->params);exit;
		//echo "<pre>"; print_r($this->Session->read());
		//echo $this->action;exit;
		
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
		} else if ((!isset($this->params['admin']) && $this->params['action'] == 'checkadminlogin') || $this->action == "index") {
			//echo "<pre> index";print_r($this->Session->read());exit;
		} else {
			if (!$this->checkPrivilege($this->action, $this->Session->read(), false)) {
				$this->redirect(array(
					'controller' => 'members',
					'action' => 'index'
				));
			}
		}
		
	}
	
	
	//function for adding the new school. controller=>school,action=>admin_add
	function admin_add() {
		$this->layout = "admin";
		Configure::write('debug', 0);
		$this->set("secondClass", "selected");
		
		 //set main navigation class
		 
		$alltimes = $this->Timezone->find('all',array('order'=>array('Timezone.GMT ASC'))); //retireve all timezone
		
		$this->set('alltimes',$alltimes);
		
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		$this->set("states", $states);
		
		
		if (!empty($this->data)) {
			
			
			if (is_uploaded_file($this->data['School']['file']['tmp_name'])) {
				$fileName = $this->data['School']['file']['name'];
				
				$ext = $this->getImgExt($fileName);
				
				$this->data['School']['school_logo'] = 'School' . time() . '.' . $ext;
				
				App::import('Component', 'resize');
				$image = new ImageResize();
				
				$image->resize($this->data['School']['file']['tmp_name'], 'img/school/school_logo/' . $this->data['School']['school_logo'], 'aspect_fill', 100, 118, 0, 0, 0, 0);
				
			}
			
			if (is_uploaded_file($this->data['School']['file1']['tmp_name'])) {
				$fileSponsor = $this->data['School']['file1']['name'];
				
				$ext = $this->getImgExt($fileSponsor);
				
				$this->data['School']['sponsoring_org_logo'] = 'Sponsor' . time() . '.' . $ext;
				
				App::import('Component', 'resize');
				$imagesponsor = new ImageResize();
				
				$imagesponsor->resize($this->data['School']['file1']['tmp_name'], 'img/school/sponsor_logo/' . $this->data['School']['sponsoring_org_logo'], 'aspect_fill', 100, 118, 0, 0, 0, 0);
				
			}
			
			if(!empty($this->data['School']['timezone']))
			{
			
				$timezone = $this->Timezone->find('first',array('conditions'=>array(
																'Timezone.id'=>$this->data['School']['timezone'])
																)
												  );
				
				$this->data['School']['timezone'] = $timezone['Timezone']['name'];
				$this->data['School']['offset'] = $timezone['Timezone']['GMT'];
				
				
				$this->Session->write('School.timezone',$timezone['Timezone']['name']);
				$this->Session->write('School.offset',$timezone['Timezone']['GMT']); 
			
			}
			
			
			$this->School->save($this->data);
			
			$this->Session->setFlash('New School has been added successfully');
			
			$this->redirect(array(
				'action' => 'view',
				'admin' => true
			));
			
			
		}
		
		
		
		
		
		
		
		
	}
	
	
		function admin_update_school_status($id = null) {
		$id     = convert_uudecode(base64_decode($id));
		$getRec = $this->School->find('all', array(
			'conditions' => array(
				'School.id' => $id
			)
		));
		
		$field  = array();
		if (!empty($getRec)) {
			if ($getRec[0]['School']['status'] == 'inactive') {
				$this->School->id  = $id;
				$field['School']['status'] = 'active';
				$this->School->save($field);
				if ($this->RequestHandler->isAjax()) {
					echo "activated";
					exit;
				}
			} else {
				$this->School->id          = $id;
				$field['School']['status'] = 'inactive';
				$this->School->save($field);
				if ($this->RequestHandler->isAjax()) {
					echo "deactivated";
					exit;
				}
			}
		}
		$this->redirect(array(
			'controller' => 'schools',
			'action' => 'view',
			'admin' => true
		));
	}
	
	
	//function for adding the Edit school. controller=>school,action=>admin_edit
	function admin_edit($id = NULL) {
		$id           = convert_uudecode(base64_decode($id));
		$this->layout = "admin";
		Configure::write('debug', 0);
		$this->set("secondClass", "selected"); //set main navigation class
		
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		$this->set("states", $states);
		
		
		if (!empty($this->data)) {
			/*	echo '<pre>';
			print_r($this->data);
			print_r($_POST);
			die;*/
			
			if (is_uploaded_file($this->data['School']['file']['tmp_name'])) {
				$fileName = $this->data['School']['file']['name'];
				
				$ext = $this->getImgExt($fileName);
				
				$this->data['School']['school_logo'] = 'School' . time() . '.' . $ext;
				
				App::import('Component', 'resize');
				$image = new ImageResize();
				
				$image->resize($this->data['School']['file']['tmp_name'], 'img/school/school_logo/' . $this->data['School']['school_logo'], 'aspect_fill', 100, 118, 0, 0, 0, 0);
				
				
				if (file_exists(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'school_logo' . DS . $_POST['hiddenschlogo'])) {
					unlink(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'school_logo' . DS . $_POST['hiddenschlogo']);
				}
				
			}
			
			if (is_uploaded_file($this->data['School']['file1']['tmp_name'])) {
				$fileSponsor = $this->data['School']['file1']['name'];
				
				$ext = $this->getImgExt($fileSponsor);
				
				$this->data['School']['sponsoring_org_logo'] = 'Sponsor' . time() . '.' . $ext;
				
				App::import('Component', 'resize');
				$imagesponsor = new ImageResize();
				
				$imagesponsor->resize($this->data['School']['file1']['tmp_name'], 'img/school/sponsor_logo/' . $this->data['School']['sponsoring_org_logo'], 'aspect_fill', 100, 118, 0, 0, 0, 0);
				
				
				if (file_exists(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'sponsor_logo' . DS . $_POST['hiddenschorglogo'])) {
					unlink(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'sponsor_logo' . DS . $_POST['hiddenschorglogo']);
				}
				
				
				
			}
			
			$this->data['School']['id'] = $_POST['schoolid'];
			
			$this->School->save($this->data);
			
			$this->Session->setFlash('School has been edited successfully');
			
			$this->redirect($this->referer());
			
		}
		
		
		$this->data = $this->School->find('first', array(
			'conditions' => array(
				'School.id' => $id
			)
		));
		
		
		
		
		
		
		
		
		
		
		
		
	}
	
	
	function admin_view() {
		$this->layout = 'admin';
		Configure::write('debug', 2);
		
		$this->set("secondClass", "selected"); //set main navigation class
		
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('schoolview');
			//	echo 'jaswant';
			//	die;
			
		}
		
		
		if (isset($this->data)) {
			$this->Session->write('schoolview.school_name', $this->data['School']['school_name']);
			//$this->Session->write('schoolview.sponsoring_organization', $this->data['School']['sponsoring_organization']);
			$this->Session->write('schoolview.address', $this->data['School']['address']);
			$this->Session->write('schoolview.perpage', $this->data['School']['perpage']);
			
			$this->data['School']['school_name'] = $this->Session->read('schoolview.school_name');
			//$this->data['School']['sponsoring_organization']=$this->Session->read('schoolview.sponsoring_organization');
			$this->data['School']['address']     = $this->Session->read('schoolview.address');
			$this->data['School']['perpage']     = $this->Session->read('schoolview.perpage');
			
		} else {
			$this->data['School']['school_name'] = $this->Session->read('schoolview.school_name');
			//$this->data['School']['sponsoring_organization']=$this->Session->read('schoolview.sponsoring_organization');
			$this->data['School']['address']     = $this->Session->read('schoolview.address');
			
		}
		
		
		if (strlen($this->Session->read('schoolview.perpage')) > 0) {
			$this->data['School']['perpage'] = $this->Session->read('schoolview.perpage');
		} else {
			$this->data['School']['perpage'] = 10;
		}
		
		
		$conditions = array();
		
		
		if ($this->data['School']['school_name']) {
			$conditions = array_merge($conditions, array(
				'School.school_name  LIKE' => "%" . $this->data['School']['school_name'] . "%"
			));
			
			
		}
		
		
		if ($this->data['School']['address']) {
			$address = split(" ", $this->data['School']['address']);
			//print_r($address);echo "hi";
			
			foreach ($address as $address) {
				//echo $address;die;
				$con               = array(
					"OR" => array(
						'School.address LIKE' => "%" . $address . "%",
						'School.city LIKE' => "%" . $address . "%",
						'School.state LIKE' => "%" . $address . "%",
						'School.zip LIKE' => "%" . $address . "%"
						
					)
				);
				$conditions['AND'] = array_merge($conditions, $con);
			}
			//print_r($conditions);die;
		}
		
		$this->paginate['School'] = array(
			'limit' => $this->data['School']['perpage'],
			'order' => array(
				'School.created' => 'desc'
			)
		);
		
		
		
		
		
		$schools = $this->paginate('School', $conditions);
		
		/*echo '<pre>';
		print_r($this->data);
		print_r($schools);
		print_r($conditions);
		die;
		
*/		
		
		
		
		$this->set('schools', $schools);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 2);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'schools';
			$this->render('viewschool');
		}
		
		
	}
	
	function admin_delete($id = NULL) {
		$this->autoRender = false;
		
		Configure::write('debug', 0);
		
		if ($this->RequestHandler->isAjax() && !$id) {
			$this->layout = "";
			foreach ($this->data['School']['id'] as $del_id):
				$delete[] = $this->School->delete($del_id);
			endforeach;
			if (!empty($delete)) {
				echo "deleted";
			} else {
				return false;
			}
		} else if ($this->RequestHandler->isAjax() && $id) {
			$delete       = $this->School->delete($id);
			$this->layout = "";
			if ($delete) {
				
				$course = $this->Course->deleteAll(array(
					'Course.school_id' => $id
				));
				
				echo "deleted";
			}
		}
	}
	
	
	function admin_checkslug() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$slug = $_REQUEST['data']['School']['slug'];
		
		$count = $this->School->find('count', array(
			'conditions' => array(
				'School.slug' => $slug
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
	
	
	function admin_checkname() {
		
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$schoolname = $_REQUEST['data']['School']['school_name'];
		
		$countschool = $this->School->find('count', array(
			'conditions' => array(
				'School.school_name' => $schoolname
			)
		));
		
	/*	echo '<pre>';
		echo $schoolname;
		print_r($countschool);			
		die;  
		*/
		if ($countschool > 0) {
			echo "false";
		} else {
			echo "true";
		}
		
		
		
	}
	
	function checkcourseid() {
		$courseid = $_REQUEST['courseCode'];
		$schoolid = $_REQUEST['schoolId'];
		$j        = $this->Course->find('count', array(
			'conditions' => array(
				'Course.course_id' => $courseid,
				'School.id !=' => $schoolid
			)
		));
		echo $j;
		die;
	}
	
	function checkcoursename() {
		$coursename = $_REQUEST['courseCode'];
		$schoolid   = $_REQUEST['schoolId'];
		$j          = $this->Course->find('count', array(
			'conditions' => array(
				'Course.course_title' => $coursename,
				'School.id !=' => $schoolid
			)
		));
		echo $j;
		die;
	}
	
	
	
	
	function checkeditcourseid() {
		$courseid = $_REQUEST['data']['Course']['course_id'];
		$schoolid = $_REQUEST['schoolId'];
		
		$j = $this->Course->find('count', array(
			'conditions' => array(
				'Course.course_id' => $courseid,
				'School.id !=' => $schoolid
			)
		));
		/*echo $count;
		die;*/
		if ($j > 0) {
			echo "false";
		} else {
			echo "true";
		}
		die;
		
	}
	
	function checkeditcoursename() {
		$coursename = $_REQUEST['data']['Course']['course_title'];
		$schoolid   = $_REQUEST['schoolId'];
		
		$j = $this->Course->find('count', array(
			'conditions' => array(
				'Course.course_title' => $coursename,
				'School.id !=' => $schoolid
			)
		));
		/*echo $count;
		die;*/
		if ($j > 0) {
			echo "false";
		} else {
			echo "true";
		}
		die;
		
	}
	
	
	
	
	
	function admin_checkeditslug() {
		$slug     = $_REQUEST['data']['School']['slug'];
		$schoolid = $_REQUEST['schoolId'];
		
		/*echo $officerId;
		print_r($_REQUEST);
		die;*/
		
		$j = $this->School->find('count', array(
			'conditions' => array(
				'School.slug' => $slug,
				'School.id !=' => $schoolid
			)
		));
		
		if ($j > 0) {
			echo 'false';
		} else {
			echo 'true';
		}
		
		die;
		
		
	}
	
	function admin_checkeditname() {
		$schoolname = $_REQUEST['data']['School']['school_name'];
		$schoolid   = $_REQUEST['schoolId'];
		
		
		$j = $this->School->find('count', array(
			'conditions' => array(
				'School.school_name' => $schoolname,
				'School.id !=' => $schoolid
			)
		));
		
		if ($j > 0) {
			echo 'false';
		} else {
			echo 'true';
		}
		
		die;
		
		
	}
	
	
	
	// 11 july girish 	
	function admin_course_view($id = NULL) {
		$this->set("id", $id);
		
		//	echo $id;
		
		//	$id=convert_uudecode(base64_decode($id));
		
		/*	echo $id;
		
		die;
		*/
		$this->layout = 'admin';
		
		$this->set("secondClass", "selected"); //set main navigation class
		
		Configure::write('debug', 0);
		/*$this->set("course_id",$this->data['Course']['course_id']);
		
		$this->set("course_title",$this->data['Course']['course_title']);
		$this->set("pages",$this->data['Course']['perpage']);
		$this->Session->delete('courseview');
		*/
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('courseview');
			//	echo 'jaswant';
			//	die;
			
		}
		
		
		
		if (isset($this->data)) {
			$this->Session->write('courseview.course_id', $this->data['Course']['course_id']);
			$this->Session->write('courseview.course_title', $this->data['Course']['course_title']);
			$this->Session->write('courseview.school_name', $this->data['School']['school_name']);
			$this->Session->write('courseview.perpage', $this->data['Course']['perpage']);
			
			$this->data['Course']['course_id']    = $this->Session->read('courseview.course_id');
			$this->data['Course']['course_title'] = $this->Session->read('courseview.course_title');
			$this->data['School']['school_name']  = $this->Session->read('courseview.school_name');
			$this->data['Course']['perpage']      = $this->Session->read('courseview.perpage');
			
		} else {
			$this->data['Course']['course_id']    = $this->Session->read('courseview.course_id');
			$this->data['Course']['course_title'] = $this->Session->read('courseview.course_title');
			$this->data['School']['school_name']  = $this->Session->read('courseview.school_name');
			
		}
		
		
		if (strlen($this->Session->read('courseview.perpage')) > 0) {
			$this->data['Course']['perpage'] = $this->Session->read('courseview.perpage');
		} else {
			$this->data['Course']['perpage'] = '10';
		}
		
		
		$conditions = array();
		
		$conditions = array_merge($conditions, array(
			'Course.school_id' => $id
		));
		
		
		if ($this->data['Course']['course_id']) {
			$conditions = array_merge($conditions, array(
				'Course.course_id  LIKE' => $this->data['Course']['course_id'] . "%"
			));
			
		}
		
		if ($this->data['Course']['course_title']) {
			$conditions = array_merge($conditions, array(
				'Course.course_title  LIKE' => "%" . $this->data['Course']['course_title'] . "%"
			));
			
		}
		if ($this->data['School']['school_name']) {
			$conditions = array_merge($conditions, array(
				'School.school_name  LIKE' => "%" . $this->data['Course']['school_name'] . "%"
			));
			
		}
		
		
		$this->paginate['Course'] = array(
			'limit' => $this->data['Course']['perpage'],
			'order' => array(
				'Course.id' => 'desc'
			),
			'recursive' => 2
		);
		
		
		/*   $this->paginate['Course'] = array(
		'conditions'=>array(
		'Course.school_id' => $id
		)
		);
		
		$courses = $this->paginate('Course');*/
		
		
		
		$courses = $this->paginate('Course', $conditions);
		
		/*
		echo '<pre>';
		
		print_r($courses);
		die;
		
		*/
		
		$this->set('courses', $courses);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'schools';
			$this->render('viewcourse');
			
			
		}
	}
	
	function admin_course_add() {
		$this->layout = "admin";
		Configure::write('debug', 0);
		
		
		$this->set("secondClass", "selected"); //set main navigation class
		
		$alldata    = $this->School->find('all'); //retireve all school
		$schoolname = Set::combine($alldata, '{n}.School.id', '{n}.School.school_name');
		$this->set("schoolname", $schoolname);
		
		
		/*
		$alldata = $this->State->find('all');//retireve all states
		$states = Set::combine($alldata,'{n}.State.state_code','{n}.State.state_name');
		$this->set("states",$states);*/
		
		/*	echo '<pre>';
		print_r($this->data);
		die;
		*/
		
		if (!empty($this->data)) {
			$this->Course->save($this->data);
			
			
			$this->Session->setFlash('New Course has been added successfully');
			
			$this->redirect(array(
				'action' => 'all_course_view',
				'admin' => true
			));
			
			
		}
	}
	function admin_course_edit($id = NULL) {
		//	$id=convert_uudecode(base64_decode($id));
		$this->layout = "admin";
		Configure::write('debug', 0);
		$this->set("secondClass", "selected"); //set main navigation class
		
		if (!empty($this->data)) {
			$this->data['Course']['id'] = $_POST['courseid'];
			
			$this->Course->save($this->data);
			
			$this->Session->setFlash('Course has been edited successfully');
			
			$this->redirect($this->referer());
			
			
			
		}
		
		
		$this->data = $this->Course->find('first', array(
			'conditions' => array(
				'Course.id' => $id
			)
		));
		
		
		
		
		
		
		$alldata    = $this->School->find('all'); //retireve all school
		$schoolname = Set::combine($alldata, '{n}.School.id', '{n}.School.school_name');
		$this->set("schoolname", $schoolname);
		
		
		
		/*
		echo '<pre>';
		print_r($this->data);
		print_r($_POST);
		die;
		*/
	}
	
	function admin_course_delete($id = NULL) {
		$this->autoRender = false;
		
		Configure::write('debug', 0);
		
		if ($this->RequestHandler->isAjax() && !$id) {
			$this->layout = "";
			foreach ($this->data['Course']['id'] as $del_id):
				$delete[] = $this->Course->delete($del_id);
			endforeach;
			if (!empty($delete)) {
				echo "deleted";
			} else {
				return false;
			}
		} else if ($this->RequestHandler->isAjax() && $id) {
			$delete       = $this->Course->delete($id);
			$this->layout = "";
			if ($delete) {
				echo "deleted";
			}
		}
	}
	
	function admin_all_course_view() {
		$this->layout = 'admin';
		
		$this->set("secondClass", "selected"); //set main navigation class
		
		Configure::write('debug', 0);
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('courseview');
		}
		
		if (isset($this->data)) {
			$this->Session->write('courseview.course_id', $this->data['Course']['course_id']);
			$this->Session->write('courseview.course_title', $this->data['Course']['course_title']);
			$this->Session->write('courseview.school_name', $this->data['School']['school_name']);
			$this->Session->write('courseview.perpage', $this->data['Course']['perpage']);
			
			$this->data['Course']['course_id']    = $this->Session->read('courseview.course_id');
			$this->data['Course']['course_title'] = $this->Session->read('courseview.course_title');
			$this->data['School']['school_name']  = $this->Session->read('courseview.school_name');
			$this->data['Course']['perpage']      = $this->Session->read('courseview.perpage');
			
		} else {
			$this->data['Course']['course_id']    = $this->Session->read('courseview.course_id');
			$this->data['Course']['course_title'] = $this->Session->read('courseview.course_title');
			$this->data['School']['school_name']  = $this->Session->read('courseview.school_name');
			
		}
		
		
		if (strlen($this->Session->read('courseview.perpage')) > 0) {
			$this->data['Course']['perpage'] = $this->Session->read('courseview.perpage');
		} else {
			$this->data['Course']['perpage'] = '10';
		}
		
		
		$conditions = array();
		
		if ($this->data['Course']['course_id']) {
			$conditions = array_merge($conditions, array(
				'Course.course_id  LIKE' => $this->data['Course']['course_id'] . "%"
			));
			
		}
		
		if ($this->data['Course']['course_title']) {
			$conditions = array_merge($conditions, array(
				'Course.course_title  LIKE' => "%" . $this->data['Course']['course_title'] . "%"
			));
			
		}
		if ($this->data['School']['school_name']) {
			$conditions = array_merge($conditions, array(
				'School.school_name  LIKE' => "%" . $this->data['School']['school_name'] . "%"
			));
			
		}
		
		
		$this->paginate['Course'] = array(
			'limit' => $this->data['Course']['perpage'],
			'order' => array(
				'Course.id' => 'desc'
			)
		);
		
		$courses = $this->paginate('Course', $conditions);
		
		
		/*	echo '<pre>';
		print_r($this->data);
		print_r($conditions);
		print_r($courses);
		die;*/
		
		
		
		$this->set('courses', $courses);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'schools';
			$this->render('allcourseview');
			
			
		}
	}
	
	// end 11 july girish
	
	function admin_edit_assign_school($school_id = NULL) {
		//$school_id=convert_uudecode(base64_decode($school_id));
		$this->layout = "admin";
		Configure::write('debug', 0);
		$this->set("secondClass", "selected"); //set main navigation class
		
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		$this->set("states", $states);
		
		
		if (!empty($this->data)) {
			if (is_uploaded_file($this->data['School']['file']['tmp_name'])) {
				$fileName = $this->data['School']['file']['name'];
				
				$ext = $this->getImgExt($fileName);
				
				$this->data['School']['school_logo'] = 'School' . time() . '.' . $ext;
				
				App::import('Component', 'resize');
				$image = new ImageResize();
				
				$image->resize($this->data['School']['file']['tmp_name'], 'img/school/school_logo/' . $this->data['School']['school_logo'], 'aspect_fill', 100, 118, 0, 0, 0, 0);
				
				
				if (file_exists(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'school_logo' . DS . $_POST['hiddenschlogo'])) {
					unlink(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'school_logo' . DS . $_POST['hiddenschlogo']);
				}
				
			}
			
			if (is_uploaded_file($this->data['School']['file1']['tmp_name'])) {
				$fileSponsor = $this->data['School']['file1']['name'];
				
				$ext = $this->getImgExt($fileSponsor);
				
				$this->data['School']['sponsoring_org_logo'] = 'Sponsor' . time() . '.' . $ext;
				
				App::import('Component', 'resize');
				$imagesponsor = new ImageResize();
				
				$imagesponsor->resize($this->data['School']['file1']['tmp_name'], 'img/school/sponsor_logo/' . $this->data['School']['sponsoring_org_logo'], 'aspect_fill', 100, 118, 0, 0, 0, 0);
				
				
				if (file_exists(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'sponsor_logo' . DS . $_POST['hiddenschorglogo'])) {
					unlink(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'sponsor_logo' . DS . $_POST['hiddenschorglogo']);
				}
				
				
				
			}
			
			$this->data['School']['id'] = $_POST['school_id'];
			
			$this->School->save($this->data);
			
			
			$this->Session->setFlash('School has been edited successfully');
			
			$this->redirect($this->referer());
			
		}
		
		
		$this->data = $this->School->find('first', array(
			'conditions' => array(
				'School.id' => $school_id
			)
		));
		
	}
	
	
	
	function admin_add_assign_course() {
		$this->layout = "admin";
		Configure::write('debug', 0);
		
		$this->set("secondClass", "selected");
		
		$schooldata = $this->School->find('first', array(
			'conditions' => array(
				'School.id' => $this->Session->read('Admin.school_id')
			)
		));
		
		$schoolname = $schooldata['School']['school_name'];
		$this->set("schoolname", $schoolname);
		
		
		if (!empty($this->data)) {
			$this->data['Course']['school_id'] = $this->Session->read('Admin.school_id');
			$this->Course->save($this->data);
			
			$this->Session->setFlash('New Course has been added successfully');
			
			$this->redirect(array(
				'action' => 'view_assign_course',
				'admin' => true
			));
			
			
		}
		
	}
	
	
	
	
	
	function admin_view_assign_course() {
		$this->set("school_id", $school_id);
		
		//echo $id;
		
		//	$id=convert_uudecode(base64_decode($id));
		
		//echo $id;
		
		//die;
		
		$this->layout = 'admin';
		
		$this->set("secondClass", "selected");
		
		Configure::write('debug', 0);
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('courseview');
			//	echo 'jaswant';
			//	die;
			
		}
		
		
		
		if (isset($this->data)) {
			$this->Session->write('courseview.course_id', $this->data['Course']['course_id']);
			$this->Session->write('courseview.course_title', $this->data['Course']['course_title']);
			//$this->Session->write('courseview.school_name', $this->data['School']['school_name']);
			$this->Session->write('courseview.perpage', $this->data['Course']['perpage']);
			
			$this->data['Course']['course_id']    = $this->Session->read('courseview.course_id');
			$this->data['Course']['course_title'] = $this->Session->read('courseview.course_title');
			$this->data['School']['school_name']  = $this->Session->read('courseview.school_name');
			$this->data['Course']['perpage']      = $this->Session->read('courseview.perpage');
			
		} else {
			$this->data['Course']['course_id']    = $this->Session->read('courseview.course_id');
			$this->data['Course']['course_title'] = $this->Session->read('courseview.course_title');
			$this->data['School']['school_name']  = $this->Session->read('courseview.school_name');
			
		}
		
		
		if (strlen($this->Session->read('courseview.perpage')) > 0) {
			$this->data['Course']['perpage'] = $this->Session->read('courseview.perpage');
		} else {
			$this->data['Course']['perpage'] = '10';
		}
		
		
		$conditions = array();
		
		$conditions = array_merge($conditions, array(
			'Course.school_id' => $this->Session->read('Admin.school_id')
		));
		
		if ($this->data['Course']['course_id']) {
			$conditions = array_merge($conditions, array(
				'Course.course_id  LIKE' => $this->data['Course']['course_id'] . "%"
			));
			
		}
		
		if ($this->data['Course']['course_title']) {
			$conditions = array_merge($conditions, array(
				'Course.course_title  LIKE' => "%" . $this->data['Course']['course_title'] . "%"
			));
			
		}
		/*if($this->data['School']['school_name'])
		{
		$conditions=array_merge($conditions,array('School.school_name  LIKE'=> "%" . $this->data['Course']['school_name'] . "%"));
		
		}
		*/
		
		$this->paginate['Course'] = array(
			'limit' => $this->data['Course']['perpage'],
			'order' => array(
				'Course.id' => 'desc'
			),
			'recursive' => 2
		);
		
		
		
		$courses = $this->paginate('Course', $conditions);
		
		$this->set('courses', $courses);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'schools';
			$this->render('viewassigncourse');
			
			
		}
		
		
	}
	
	
	/*function admin_upload_action_item()
	{
	$this->layout="admin";
	$alldata = $this->School->find('all');//retireve all school
	$schoolname = Set::combine($alldata,'{n}.School.id','{n}.School.school_name');
	$this->set("schoolname",$schoolname);
	
	}
	*/
	
	
	function admin_importassigncoursecsv() {
		Configure::write('debug', 0);
		
		if (!empty($_FILES)) {
			if (!empty($_FILES) && $_FILES['action_file']['size'] != 0) {
				App::Import('Component', 'Upload'); //import image upload component
				$upload   = new UploadComponent();
				$fileName = pathinfo($_FILES['action_file']['name']);
				$ext      = $fileName['extension'];
				if ($ext == "xls") {
					$tempFile    = $_FILES['action_file']['tmp_name'];
					$destination = realpath('../../app/webroot/files') . '/';
					$file        = $_FILES['action_file'];
					$name        = str_replace(" ", "", microtime() . "." . $ext);
					$result      = $upload->upload($file, $destination, $name, NULL, array(
						'xls'
					));
					//	echo $destination; die;
					if ($result) {
						App::import('Vendor', 'reader', array(
							'file' => 'Excel/reader.php'
						));
						$data = new Spreadsheet_Excel_Reader();
						$data->setOutputEncoding('CP1251');
						$data->read('files/' . $name);
						$unlin = unlink('files/' . $name);
						if ($unlin) {
							//echo ("Yes $name");  die;
						} else {
							unlink('files/' . $name);
							//echo ("else $name"); die;
						}
						
						$masterData = $data->sheets[0]["cells"];
						//pr($masterData);die;
							{
							for ($i = 2; $i < count($masterData); $i++) {
								if (isset($masterData[$i][1]) && $masterData[$i][1] != "") {
									$this->data['Course']['course_id'] = $masterData[$i][1];
								} else {
									$this->data['Course']['course_id'] = "";
								}
								
								
								if (isset($masterData[$i][2]) && $masterData[$i][2] != "") {
									$this->data['Course']['course_title'] = $masterData[$i][2];
								} else {
									$this->data['Course']['course_title'] = "";
								}
								$this->data['Course']['school_id'] = $this->Session->read('Admin.school_id');
								$this->Course->create();
								$this->Course->save($this->data);
								$this->Session->setFlash('New Courses uploaded  successfully');
							}
						}
						
					}
					//this->Session->write('Action Items uploaded successfully!!');
				} else {
					$this->Session->write("flash", 'File type is not valid, Please select xls file !!');
				}
				
			} else {
				$this->Session->write("flash", ' Please Select File !!');
			}
		} else {
			$this->Session->setFlash('Select  Course file');
		}
		$this->redirect(array(
			'action' => 'view_assign_course',
			'admin' => true
		));
		
	}
	
	
	
	
	function admin_importcoursecsv() {
		Configure::write('debug', 0);
		
		/*		echo '<pre>';
		print_r($_FILES);
		die;*/
		
		
		if (!empty($_FILES)) {
			if (!empty($_FILES) && $_FILES['action_file']['size'] != 0) {
				App::Import('Component', 'Upload'); //import image upload component
				$upload   = new UploadComponent();
				$fileName = pathinfo($_FILES['action_file']['name']);
				$ext      = $fileName['extension'];
				if ($ext == "xls") {
					$tempFile    = $_FILES['action_file']['tmp_name'];
					$destination = realpath('../../app/webroot/files') . '/';
					$file        = $_FILES['action_file'];
					$name        = str_replace(" ", "", microtime() . "." . $ext);
					$result      = $upload->upload($file, $destination, $name, NULL, array(
						'xls'
					));
					
					/*echo $result;
					echo $destination; die;*/
					
					if ($result) {
						App::import('Vendor', 'reader', array(
							'file' => 'Excel/reader.php'
						));
						$data = new Spreadsheet_Excel_Reader();
						$data->setOutputEncoding('CP1251');
						$data->read('files/' . $name);
						$unlin = unlink('files/' . $name);
						if ($unlin) {
							//echo ("Yes $name");  die;
						} else {
							unlink('files/' . $name);
							//echo ("else $name"); die;
						}
						
						$masterData = $data->sheets[0]["cells"];
						//	print_r($masterData);die;
							{
							for ($i = 2; $i < count($masterData); $i++) {
								if (isset($masterData[$i][1]) && $masterData[$i][1] != "") {
									$this->data['Course']['course_id'] = $masterData[$i][1];
								} else {
									$this->data['Course']['course_id'] = "";
								}
								
								
								if (isset($masterData[$i][2]) && $masterData[$i][2] != "") {
									$this->data['Course']['course_title'] = $masterData[$i][2];
								} else {
									$this->data['Course']['course_title'] = "";
								}
								
								$this->Course->create();
								$this->Course->save($this->data);
								$this->Session->setFlash('New Courses uploaded  successfully');
							}
						}
						
					}
					//$this->Session->write('Action Items uploaded successfully!!');
				} else {
					$this->Session->write("flash", 'File type is not valid, Please select xls file !!');
				}
				
			} else {
				$this->Session->write("flash", ' Please Select File !!');
			}
		} else {
			$this->Session->setFlash('Select  Course file');
		}
		$this->redirect(array(
			'action' => 'all_course_view',
			'admin' => true
		));
		
	}
	
	
	
	
	
	
	function admin_tutor_view($schoolid = NULL) {
		$this->set("schoolid", $schoolid);
		
		//	echo $id;
		
		//	$id=convert_uudecode(base64_decode($id));
		
		/*echo $id;
		
		die;*/
		
		
		$this->layout = 'admin';
		
		$this->set("secondClass", "selected"); //set main navigation class
		
		Configure::write('debug', 0);
		/*$this->set("course_id",$this->data['Course']['course_id']);
		
		$this->set("course_title",$this->data['Course']['course_title']);
		$this->set("pages",$this->data['Course']['perpage']);
		$this->Session->delete('courseview');
		*/
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('tutorview');
			//	echo 'jaswant';
			//	die;
			
		}
		
		
		if (isset($this->data)) {
			$this->Session->write('tutorview.email', $this->data['Member']['email']);
			$this->Session->write('tutorview.active', $this->data['Member']['active']);
			$this->Session->write('tutorview.address', $this->data['userMeta']['address']);
			$this->Session->write('tutorview.perpage', $this->data['Member']['perpage']);
			
			
			$this->data['Member']['email']     = $this->Session->read('tutorview.email');
			$this->data['Member']['active']    = $this->Session->read('tutorview.active');
			$this->data['userMeta']['address'] = $this->Session->read('tutorview.address');
			$this->data['Member']['perpage']   = $this->Session->read('tutorview.perpage');
			
		} else {
			$this->data['Member']['email']     = $this->Session->read('tutorview.email');
			$this->data['Member']['active']    = $this->Session->read('tutorview.active');
			$this->data['userMeta']['address'] = $this->Session->read('tutorview.address');
			
			
		}
		
		
		if (strlen($this->Session->read('tutorview.perpage')) > 0) {
			$this->data['Member']['perpage'] = $this->Session->read('tutorview.perpage');
		} else {
			$this->data['Member']['perpage'] = '10';
		}
		
		
		
		$conditions = array();
		
		$conditions = array_merge($conditions, array(
			'Member.school_id' => $schoolid
		));
		$conditions = array_merge($conditions, array(
			'Member.group_id' => '7'
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
				'userMeta.zip LIKE' => "%" . $this->data['userMeta']['address'] . "%"
			));
		}
		
		
		/*	echo '<pre>';
		print_r($conditions);
		die;*/
		
		

		
		
		$this->paginate['Member'] = array(
			'limit' => $this->data['Member']['perpage'],
			// 'order' => array('Course.id' => 'desc' ),
			'recursive' => 0
		);
		
		
		/*   $this->paginate['Course'] = array(
		'conditions'=>array(
		'Course.school_id' => $id
		)
		);
		
		$courses = $this->paginate('Course');*/
		
		
	//	$this->Member->unbindModel(array('hasMany' => array('TutEvent','TutCourse'))); 
		
		$tutors = $this->paginate('Member', $conditions);
		
		
	/*	echo '<pre>';
	    print_r($this->data);
		print_r($conditions);
		print_r($tutors);
		die;*/
		
		
		
		$this->set('tutors', $tutors);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'schools';
			$this->render('viewtutor');
			
			
		}
	}
	
	
	function admin_student_view($schoolid = NULL) {
		$this->set("schoolid", $schoolid);
		
		//	echo $id;
		
		//	$id=convert_uudecode(base64_decode($id));
		
		/*echo $id;
		
		die;*/
		
		
		$this->layout = 'admin';
		
		$this->set("secondClass", "selected"); //set main navigation class
		
		Configure::write('debug', 0);
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('tutorview');
			
		}
		
		
		if (isset($this->data)) {
			$this->Session->write('tutorview.email', $this->data['Member']['email']);
			$this->Session->write('tutorview.active', $this->data['Member']['active']);
			$this->Session->write('tutorview.address', $this->data['userMeta']['address']);
			$this->Session->write('tutorview.perpage', $this->data['Member']['perpage']);
			
			
			$this->data['Member']['email']     = $this->Session->read('tutorview.email');
			$this->data['Member']['active']    = $this->Session->read('tutorview.active');
			$this->data['userMeta']['address'] = $this->Session->read('tutorview.address');
			$this->data['Member']['perpage']   = $this->Session->read('tutorview.perpage');
			
		} else {
			$this->data['Member']['email']     = $this->Session->read('tutorview.email');
			$this->data['Member']['active']    = $this->Session->read('tutorview.active');
			$this->data['userMeta']['address'] = $this->Session->read('tutorview.address');
			
			
		}
		
		
		if (strlen($this->Session->read('tutorview.perpage')) > 0) {
			$this->data['Member']['perpage'] = $this->Session->read('tutorview.perpage');
		} else {
			$this->data['Member']['perpage'] = '10';
		}
		
		
		
		$conditions = array();
		
		$conditions = array_merge($conditions, array(
			'Member.school_id' => $schoolid
		));
		$conditions = array_merge($conditions, array(
			'Member.group_id' => '8'
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
		
		
		
		$tutors = $this->paginate('Member', $conditions);
		
		
		
		$this->set('tutors', $tutors);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'schools';
			$this->render('viewschoolstudent');
			
			
		}
	}
	
	
	
	
	function admin_tutor_edit($id = NULL) {
		$this->layout = "admin";
		Configure::write('debug', 0);
		$this->set("secondClass", "selected"); //set main navigation class
		
		
		//$id=convert_uudecode(base64_decode($id));
		
		
		$admindata = $this->Member->find('first', array(
			'conditions' => array(
				'Member.id' => $id
			)
		));
		/*echo '<pre>';
		print_r($admindata);
		die;*/
		$this->set('admindata', $admindata);
		
		
		
		
		
		if (!empty($this->data)) {
			//$data['Member']['group_id'] = $this->data['Member']['group_id'];
			$data['Member']['active'] = $this->data['Member']['status'];
			$data['Member']['email']  = $this->data['Member']['email'];
			
			$this->Member->create();
			$db = $this->Member->getDataSource();
			
			if ($this->Member->save($data)) {
				$userMeta['userMeta']['fname']     = $this->data['userMeta']['fname'];
				$userMeta['userMeta']['lname']     = $this->data['userMeta']['lname'];
				$userMeta['userMeta']['address']   = $this->data['userMeta']['address'];
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
	
	
	function admin_exporttutorcsv($schoolId) {
		$this->set("schoolId", $schoolId);
		
		
		/*$Page=$this->Member->find('all',array(
		'conditions'=>array(
		'Member.active !='=>'0'),
		'order'=>array(
		'Member.created'=>'desc')
		)
		);*/
		
		$Page = $this->Member->find('all', array(
			'conditions' => array(
				'Member.school_id' => $schoolId,
				'Member.group_id' => '7'
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
		header("Content-Disposition:attachment;filename=Tutor(" . date('m/d/Y') . ").csv");
		die();
	}
	
	
	
	
	//Function For Exporting the data in Excel
	
	function admin_exportstudentcsv($schoolId) {
		$this->set("schoolId", $schoolId);
		
		
		/*$Page=$this->Member->find('all',array(
		'conditions'=>array(
		'Member.active !='=>'0'),
		'order'=>array(
		'Member.created'=>'desc')
		)
		);*/
		
		$Page = $this->Member->find('all', array(
			'conditions' => array(
				'Member.school_id' => $schoolId,
				'Member.group_id' => '8'
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
		header("Content-Disposition:attachment;filename=Tutor(" . date('m/d/Y') . ").csv");
		die();
	}
	
	
	/*********** Add Upcoming Schools , 04, Oct 2011************/
	//function for adding the new school. controller=>school,action=>admin_upcoming_add
	function admin_upcoming_add() {
		$this->layout = "admin";
		Configure::write('debug', 0);
		$this->set("secondClass", "selected"); //set main navigation class
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		$this->set("states", $states);
		if (!empty($this->data)) {
			if (is_uploaded_file($this->data['UpcomingSchool']['file']['tmp_name'])) {
				$fileName = $this->data['UpcomingSchool']['file']['name'];
				
				$ext = $this->getImgExt($fileName);
				
				$this->data['UpcomingSchool']['school_logo'] = 'UpcomingSchool' . time() . '.' . $ext;
				
				App::import('Component', 'resize');
				$image = new ImageResize();
				
				$image->resize($this->data['UpcomingSchool']['file']['tmp_name'], 'img/school/school_logo/' . $this->data['UpcomingSchool']['school_logo'], 'aspect_fill', 100, 118, 0, 0, 0, 0);
				
			}
			
			if (is_uploaded_file($this->data['UpcomingSchool']['file1']['tmp_name'])) {
				$fileSponsor = $this->data['UpcomingSchool']['file1']['name'];
				
				$ext = $this->getImgExt($fileSponsor);
				
				$this->data['UpcomingSchool']['sponsoring_org_logo'] = 'Sponsor' . time() . '.' . $ext;
				
				App::import('Component', 'resize');
				$imagesponsor = new ImageResize();
				
				$imagesponsor->resize($this->data['UpcomingSchool']['file1']['tmp_name'], 'img/school/sponsor_logo/' . $this->data['UpcomingSchool']['sponsoring_org_logo'], 'aspect_fill', 100, 118, 0, 0, 0, 0);
				
			}
			$this->UpcomingSchool->save($this->data);
			
			$this->Session->setFlash('Upcoming School has been added successfully');
			
			$this->redirect(array(
				'action' => 'upcoming_view',
				'admin' => true
			));	
		}	
	}
	//Done by Aj
	
	//function for adding the Edit school. controller=>school,action=>admin_edit
	function admin_upcoming_edit($id = NULL) {
		$id           = convert_uudecode(base64_decode($id));
		$this->layout = "admin";
		Configure::write('debug', 0);
		$this->set("secondClass", "selected"); //set main navigation class
		
		$alldata = $this->State->find('all'); //retireve all states
		$states  = Set::combine($alldata, '{n}.State.state_code', '{n}.State.state_name');
		$this->set("states", $states);
		
		
		if (!empty($this->data)) {
			/*	echo '<pre>';
			print_r($this->data);
			print_r($_POST);
			die;*/
			
			if (is_uploaded_file($this->data['UpcomingSchool']['file']['tmp_name'])) {
				$fileName = $this->data['UpcomingSchool']['file']['name'];
				
				$ext = $this->getImgExt($fileName);
				
				$this->data['UpcomingSchool']['school_logo'] = 'UpcomingSchool' . time() . '.' . $ext;
				
				App::import('Component', 'resize');
				$image = new ImageResize();
				
				$image->resize($this->data['UpcomingSchool']['file']['tmp_name'], 'img/school/school_logo/' . $this->data['UpcomingSchool']['school_logo'], 'aspect_fill', 100, 118, 0, 0, 0, 0);
				
				
				if (file_exists(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'school_logo' . DS . $_POST['hiddenschlogo'])) {
					unlink(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'school_logo' . DS . $_POST['hiddenschlogo']);
				}
				
			}
			
			if (is_uploaded_file($this->data['UpcomingSchool']['file1']['tmp_name'])) {
				$fileSponsor = $this->data['UpcomingSchool']['file1']['name'];
				
				$ext = $this->getImgExt($fileSponsor);
				
				$this->data['UpcomingSchool']['sponsoring_org_logo'] = 'Sponsor' . time() . '.' . $ext;
				
				App::import('Component', 'resize');
				$imagesponsor = new ImageResize();
				
				$imagesponsor->resize($this->data['UpcomingSchool']['file1']['tmp_name'], 'img/school/sponsor_logo/' . $this->data['UpcomingSchool']['sponsoring_org_logo'], 'aspect_fill', 100, 118, 0, 0, 0, 0);
				
				
				if (file_exists(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'sponsor_logo' . DS . $_POST['hiddenschorglogo'])) {
					unlink(ROOT . DS . 'app' . DS . 'webroot' . DS . 'img' . DS . 'school' . DS . 'sponsor_logo' . DS . $_POST['hiddenschorglogo']);
				}
				
				
				
			}
			
			$this->data['UpcomingSchool']['id'] = $_POST['schoolid'];
			
			$this->UpcomingSchool->save($this->data);
			
			$this->Session->setFlash('School has been edited successfully');
			
			$this->redirect($this->referer());
			
		}
		
		
		$this->data = $this->UpcomingSchool->find('first', array(
			'conditions' => array(
				'UpcomingSchool.id' => $id
			)
		));
	}
	
	
	function admin_upcoming_view() {
		$this->layout = 'admin';
		Configure::write('debug', 0);
		
		$this->set("secondClass", "selected"); //set main navigation class
		
		
		if (!$this->RequestHandler->isAjax() && !isset($this->data)) {
			$this->Session->delete('schoolview');
			//	echo 'jaswant';
			//	die;
			
		}
		
		
		if (isset($this->data)) {
			$this->Session->write('schoolview.school_name', $this->data['UpcomingSchool']['school_name']);
			//$this->Session->write('schoolview.sponsoring_organization', $this->data['UpcomingSchool']['sponsoring_organization']);
			$this->Session->write('schoolview.address', $this->data['UpcomingSchool']['address']);
			$this->Session->write('schoolview.perpage', $this->data['UpcomingSchool']['perpage']);
			
			$this->data['UpcomingSchool']['school_name'] = $this->Session->read('schoolview.school_name');
			//$this->data['UpcomingSchool']['sponsoring_organization']=$this->Session->read('schoolview.sponsoring_organization');
			$this->data['UpcomingSchool']['address']     = $this->Session->read('schoolview.address');
			$this->data['UpcomingSchool']['perpage']     = $this->Session->read('schoolview.perpage');
			
		} else {
			$this->data['UpcomingSchool']['school_name'] = $this->Session->read('schoolview.school_name');
			//$this->data['UpcomingSchool']['sponsoring_organization']=$this->Session->read('schoolview.sponsoring_organization');
			$this->data['UpcomingSchool']['address']     = $this->Session->read('schoolview.address');
			
		}
		
		
		if (strlen($this->Session->read('schoolview.perpage')) > 0) {
			$this->data['UpcomingSchool']['perpage'] = $this->Session->read('schoolview.perpage');
		} else {
			$this->data['UpcomingSchool']['perpage'] = 10;
		}
		
		
		$conditions = array();
		
		
		if ($this->data['UpcomingSchool']['school_name']) {
			$conditions = array_merge($conditions, array(
				'UpcomingSchool.school_name  LIKE' => "%" . $this->data['UpcomingSchool']['school_name'] . "%"
			));
			
			
		}
		
		
		if ($this->data['UpcomingSchool']['address']) {
			$address = split(" ", $this->data['UpcomingSchool']['address']);
			//print_r($address);echo "hi";
			
			foreach ($address as $address) {
				//echo $address;die;
				$con               = array(
					"OR" => array(
						'UpcomingSchool.address LIKE' => "%" . $address . "%",
						'UpcomingSchool.city LIKE' => "%" . $address . "%",
						'UpcomingSchool.state LIKE' => "%" . $address . "%",
						'UpcomingSchool.zip LIKE' => "%" . $address . "%"
						
					)
				);
				$conditions['AND'] = array_merge($conditions, $con);
			}
			//print_r($conditions);die;
		}
		
		$this->paginate['UpcomingSchool'] = array(
			'limit' => $this->data['UpcomingSchool']['perpage'],
			'order' => array(
				'UpcomingSchool.created' => 'desc'
			)
		);
		
		$schools = $this->paginate('UpcomingSchool', $conditions);
		$this->set('schools', $schools);
		
		if ($this->RequestHandler->isAjax()) {
			$this->layout = '';
			Configure::write('debug', 0);
			$this->AutoRender = false;
			$this->viewPath   = 'elements' . DS . 'adminElements' . DS . 'schools';
			$this->render('view_upcoming_school');
		}
		
		
	}
	
	function admin_upcoming_delete($id = NULL) {
		$this->autoRender = false;
		Configure::write('debug', 0);
		if ($this->RequestHandler->isAjax() && $id) {
			$delete      = $this->UpcomingSchool->delete($id);
			$this->layout = false;
			if ($delete) {
				echo "deleted";
			}
		}
	}
	
	
	function admin_tutor_rate($id = null)
	{
		$this->layout = 'admin';
		
		Configure::write('debug', 0);
		
		if($this->data)
		{
			$tutorCourse = $this->data['TutCourse'];
			
			if(count($tutorCourse))
			{
				
				foreach($tutorCourse as $key=>$value)
				{
					
					$Courseid = $key;
			
					$rate = $value;
					
				//	echo $Courseid.' '.$rate;
				
					if($this->TutCourse->updateAll(array(
					'TutCourse.rate' => "'" . $rate . "'"
					), array(
					'TutCourse.id' => $Courseid
					) 
					))
					{
					
					$this->Session->setFlash('Tutor course rate is updated successfully');
						
					}
					
					
					
				//	die;
				
					
				}
			
			}
			
		/*	echo '<pre>';
			print_r($this->data);
			print_r($tutorCourse);
			die;*/
			
			}
		
		
		
		$tutorId = convert_uudecode(base64_decode($id));
		
		
		
		$this->Member->unbindModel(array('hasMany' => array('TutEvent'))); 
		
		$memberData = $this->Member->find('first',array('conditions'=> array('Member.id'=>$tutorId),
									       		 				   
													   )
										);
		$this->set('memberData',$memberData);
		
		
		
		/*echo $tutorId;
		echo '<pre>';
		print_r($memberData);
		die;*/
	
	}

}
?>