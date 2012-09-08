<?php
class Course extends AppModel{
	var $name =  'Course';
	
	var $belongsTo = array(
							'School' => array(
							'className' => 'School',
							'foreignKey' => 'school_id'
					         )
						  );
	
	
	}

?>