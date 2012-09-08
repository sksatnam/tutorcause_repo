<?php
class TutEvent extends AppModel
{
	var $name = 'TutEvent';
	
	var $belongsTo = array(
						'Member' => array(
						'className' => 'Member',
						'foreignKey' => 'tutor_id'
						 )
					  ); 
}
?>