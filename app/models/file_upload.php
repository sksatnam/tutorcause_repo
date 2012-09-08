<?php
	class FileUpload extends AppModel
	{
		var $name='FileUpload';

		var $belongsTo=array(
							'Member'=>array(
											'className'=>'Member',
											'foreignKey'=>'member_id'
											),
							'PaymentHistory'=>array(
												'className'=>'PaymentHistory',
												'foreignKey'=>'payment_id'
											)
						);
	
	}
?>	