<?php 
class userMeta extends AppModel {
  var $name = 'userMeta';
  
  var $belongsTo = array(
							'Member' => array(
							'className' => 'Member',
							'foreignKey' => 'member_id'
					         )
						); 
  
}
?> 