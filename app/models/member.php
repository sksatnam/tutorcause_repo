<?php 
class Member extends AppModel {
  var $name = 'Member';
  var $hasOne = array(
						    'userMeta' => array(
							'className' => 'userMeta',
							'foreignKey' => 'member_id'
											)
						);
	var $belongsTo = array(
							'Group' => array(
							'className' => 'Group',
							'foreignKey' => 'group_id'
					         ),
							'School' => array(
							'className' => 'School',
							'foreignKey' => 'school_id'
					         ),
/*							'Timezone' => array(
							'className' => 'Timezone',
							'foreignKey' => 'timezone_id'
					         ),
*/						  ); 
	
	 var $hasMany = array(
						'TutCourse' => array(
						'className' => 'TutCourse',
						'foreignKey' => 'member_id'
						),
						'TutEvent' => array(
						'className' => 'TutEvent',
						'foreignKey' => 'tutor_id'
						),
							'UserImage' => array(
							'className' => 'UserImage',
							'foreignKey' => 'user_id'
											)
						);
	
	
	
	/*var $belongsTo = array(
							'School' => array(
							'className' => 'School',
							'foreignKey' => 'school_id'
					         )
						  ); 
	*/
//	var $hasMany = array('userImage');
 /*	var $actsAs = array(
    'image' => array(
        'max_size' => '4 Mb'
    	)
	);*/
 	
}
?> 