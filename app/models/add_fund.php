<?php
class AddFund extends AppModel{
	var $name =  'AddFund';
	var $belongsTo = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'student_id'
		),
		'UserInfo' => array(
			'className' => 'userMeta',
			'foreignKey' => '',
			'conditions' => array(
				'UserInfo.member_id = AddFund.student_id'
			)
		)
	);
}
?>