<?php
class TutorRequestCause extends AppModel{
	var $name =  'TutorRequestCause';
	var $belongsTo = array(
	   'Cause' => array(
			'className' => 'Member',
			'foreignKey' => 'cause_id',
		),
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'tutor_id',
		),
						   
	  );
}
?>