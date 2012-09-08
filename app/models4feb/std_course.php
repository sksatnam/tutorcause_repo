<?php
class StdCourse extends AppModel{
	var $name =  'StdCourse';

	var $belongsTo = array(
						'Member' => array(
						'className' => 'Member',
						'foreignKey' => 'member_id'
						 )
					  ); 
}
?>