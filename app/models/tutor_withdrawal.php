<?php 
class TutorWithdrawal extends AppModel {
	var $name = 'TutorWithdrawal';
	var $hasMany = array(
		'TutorToCause'=>array(
			'className' => 'TutorToCause',
			'foreignKey' => 'withdrawal_id'
		)
	);
		var $belongsTo = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'tutor_id'
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