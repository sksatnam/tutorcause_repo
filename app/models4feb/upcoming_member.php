<?php
class UpcomingMember extends AppModel {
	var $name = 'UpcomingMember';
	var $belongsTo = array(
		'UpcomingSchool' => array(
			'className' => 'UpcomingSchool',
			'foreignKey' => 'upcoming_school_id'
		)
	); 
}
?>