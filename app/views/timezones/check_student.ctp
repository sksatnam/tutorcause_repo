<?php //3aug2012 ?><?php
function tgmt($cdate,$timezone)
		{	
			$date = new DateTime($cdate, new DateTimeZone($timezone));
			$date->setTimezone(new DateTimeZone('Europe/London'));
			return $date->format('Y-m-d H:i:s'); 
		}
		
		
		function fgmt($fdate,$timezone)
		{
			$date = new DateTime($fdate, new DateTimeZone('Europe/London'));
			$date->setTimezone(new DateTimeZone($timezone));
			return $date->format('Y-m-d H:i:s'); 
		}
?>        


<?php

	echo '<pre>';
	print_r($tutorevent);
	echo fgmt($tutorevent[0]['TutorEvent']['start'],$timezone);
	die;
	
	
?>	
	
