<?php
class CauseTutor extends AppModel{
	var $name =  'CauseTutor';
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