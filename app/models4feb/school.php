<?php
class School extends AppModel{
	var $name = 'School';
	
	var $hasMany = array('Member'=>array(
											'className' => 'Member',
											'foreignKey'=> 'school_id'
											)
						);
	
}

?>