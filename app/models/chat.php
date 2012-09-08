<?php
class Chat extends AppModel {
	
      var $name = 'Chat';
	 
	  var $belongsTo = array(
								'Member' => array(
								'className' => 'Member',
								'foreignKey' => 'from_id'
								)
							); 	
	
}
?>