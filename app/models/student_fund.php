<?php
class StudentFund extends AppModel{
	var $name =  'StudentFund';
	var $belongsTo = array(
		'Parent' => array(
			'className' => 'Member',
			'foreignKey' => 'parent_id'
		),
		'Student' => array(
			'className' => 'Member',
			'foreignKey' => 'student_id'
		)
	);
}
?>