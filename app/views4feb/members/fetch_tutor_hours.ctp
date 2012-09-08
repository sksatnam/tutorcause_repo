<option value="<?php 
//echo $bookedtime['TutEvent']['start_date'];
echo date('F d, Y H:i:s', strtotime($bookedtime['TutEvent']['start_date']));?>"><?php

echo date('F j, Y @ h:i A', strtotime($bookedtime['TutEvent']['start_date']));?></option>
<?php

 // print_r($bookedtime);

$startfrom = $bookedtime['TutEvent']['start_date'];

/*echo $startfrom;
echo $count;
die;*/



for($i=0;$i<$count;)
{
	
	$i = $i + 0.5;		
	
	$minute = $i * 60;
	
	$convert = strtotime("+$minute minutes",strtotime($startfrom));
	
//	$new_time = date('Y-m-d H:i:s', $convert);

	$new_time = date('F d, Y H:i:s', $convert);
	
	$formatedtime = date('F j, Y @ h:i A', $convert);
	
  
	
?>
<option value="<?php echo $new_time;?>"><?php
echo $formatedtime;?></option>				
<?php
}
?>
<option value="<?php echo date('F d, Y H:i:s', strtotime($bookedtime['TutEvent']['end_date']));?>"><?php
echo date('F j, Y @ h:i A', strtotime($bookedtime['TutEvent']['end_date']));?></option>