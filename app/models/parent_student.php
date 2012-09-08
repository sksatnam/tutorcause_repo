<?php
class ParentStudent extends AppModel{
	var $name =  'ParentStudent';
	var $belongsTo = array(
	   'Parent' => array(
			'className' => 'Member',
			'foreignKey' => 'parent_id',
		),
		'Student' => array(
			'className' => 'Member',
			'foreignKey' => 'student_id',
		),
						   
	  );
}
?>