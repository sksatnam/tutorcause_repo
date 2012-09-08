<?php
class Faq extends AppModel {

	var $name = 'Faq';
	var $belongsTo = array(
							'Group' => array(
							'className' => 'Group',
							'foreignKey' => 'group_id'
					         )
							);


}
?>