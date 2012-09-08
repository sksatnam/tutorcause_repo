<?php
class ParentFund extends AppModel{
	var $name =  'ParentFund';
	var $belongsTo = array(
		'Parent' => array(
			'className' => 'Member',
			'foreignKey' => 'parent_id'
		)
	);
}
?>