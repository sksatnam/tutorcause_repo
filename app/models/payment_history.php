<?php
	class PaymentHistory extends AppModel
	{
		var $name='PaymentHistory';
		var $hasOne = array(
			'TutRating'=>array(
								'className'=>'TutRating',
								'foreignKey'=>'payment_id'
							));
		var $belongsTo=array(
							'student'=>array(
											'className'=>'Member',
											'foreignKey'=>'student_id'
											),
							'tutor'=>array(
												'className'=>'Member',
												'foreignKey'=>'tutor_id'
											),
							'TutEvent'=>array(
											  'className'=>'TutEvent',
											  'foreignKey'=>'tut_event_id'
											  )
								  
						);
	
	}
?>	