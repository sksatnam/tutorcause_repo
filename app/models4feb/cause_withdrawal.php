<?php 
class CauseWithdrawal extends AppModel {
	var $name = 'CauseWithdrawal';

		var $belongsTo = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'cause_id'
		),
		'Admin' => array(
			'className' => 'Member',
			'foreignKey' => 'admin_id'
		)
		);
	
	 
	/*
	var $belongsTo = array(
		'Tutor' => array(
			'className' => 'Member',
			'foreignKey' => '',
			'conditions' => array(
				'TutorWithdrawal.tutor_id=Tutor.id'
			)
		),
		'TutorInfo' => array(
			'className' => 'userMeta',
			'foreignKey' => '',
			'conditions' => array(
				'TutorWithdrawal.tutor_id=TutorInfo.member_id'
			)
		)
	); 
	*/
}
?> 