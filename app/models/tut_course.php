<?php
class TutCourse extends AppModel{
	var $name =  'TutCourse';

	var $belongsTo = array(
						'Member' => array(
						'className' => 'Member',
						'foreignKey' => 'member_id'
						 )
					  ); 
}
?>