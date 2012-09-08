<?php
class Notice extends AppModel {

	var $name = 'Notice';
	var $belongsTo = array(
							'Group' => array(
							'className' => 'Group',
							'foreignKey' => 'group_id'
					         )
							);


}
?>