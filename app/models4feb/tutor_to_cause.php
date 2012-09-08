<?php 
class TutorToCause extends AppModel {
	
	var $name = 'TutorToCause';
	
	var $belongsTo = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'cause_id'
		),
		
	/*	'CauseInfo' => array(
			'className' => 'userMeta',
			'foreignKey' => '',
			'conditions' => array(
				'CauseInfo.member_id = TutorToCause.cause_id'
			)
		),*/
		
		'Tutor' => array(
			'className' => 'Member',
			'foreignKey' => 'tutor_id'
		),
		'TutorWithdrawal' => array(
			'className' => 'TutorWithdrawal',
			'foreignKey' => 'withdrawal_id'
		),
	);
	
	
	/*
	var $belongsTo = array(
		'TutorWithdrawal' => array(
			'className' => 'TutorWithdrawal',
			'foreignKey' => 'withdrawal_id'
		),
		'Cause' => array(
			'className' => 'Member',
			'foreignKey' => 'cause_id'
		),
		'CauseInfo' => array(
			'className' => 'userMeta',
			'foreignKey' => '',
			'conditions' => array(
				'TutorToCause.cause_id=CauseInfo.member_id'
			)
		)
	); 
	*/
}
?> 