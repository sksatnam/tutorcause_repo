<?php 
class TutMessage extends AppModel {
  var $name = 'TutMessage';
  var $belongsTo = array(
							'userMeta' => array(
								'className' => 'userMeta',
								'foreignKey' => '',
								'conditions'=>'userMeta.member_id=TutMessage.from_id'
					         ),
							 'Member' => array(
								'className' => 'Member',
								'foreignKey' => 'from_id'
					         ),
							 'UserImage' => array(
								'className' => 'UserImage',
								'foreignKey' => '',
								'conditions'=>array(
									'UserImage.user_id=TutMessage.from_id',
									"UserImage.active= '1'"
								)
					         )
						);
						
	function paginateCount($conditions = null, $recursive = 0, $extra = array()) {
		$parameters = compact('conditions');
		$this->recursive = $recursive;
		$count = $this->find('count', array_merge($parameters, $extra));
		if (isset($extra['group'])) {
			$count = $this->getAffectedRows();
		}
		return $count;
	}
}
?>