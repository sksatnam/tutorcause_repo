<?php
ob_start();
class TimezonesController extends AppController
	{
		var $name = 'timezones';
		var $layout = 'frontend';
		var $uses = array('Member','State','userMeta','Group', 'School', 'Course', 'TutCourse','TutEvent','Faq','Privilege','Notice','TutorEvent','Timezone');

		
		
		
		
function check_tutor()
{
	
	
	
		
	
	
	
	
	if(!empty($this->data))
	{
		
		
		
	/*	$offset = 5;
		
		echo $this->changetime($this->data['TutorEvent']['start'],$offset);
		print_r($this->data);
		die;
		*/
		
		$timezone = 'Asia/Calcutta';
		
		$this->data['TutorEvent']['start'] = date("Y-m-d H:i:s", strtotime($this->data['TutorEvent']['start']));
		
		$this->data['TutorEvent']['start'] = $this->tgmt($this->data['TutorEvent']['start'],$timezone);
		
		$this->data['TutorEvent']['end'] = date("Y-m-d H:i:s" , strtotime($this->data['TutorEvent']['end']));
		$this->data['TutorEvent']['end'] = $this->tgmt($this->data['TutorEvent']['end'],$timezone);
		
		$this->data['TutorEvent']['member_id'] = $this->Session->read('Member.memberid');
		$this->TutorEvent->save($this->data);
		
		
		
		
	}
	
	
	
}



function check_student()
{
	
	Configure::write('debug', 2);
	
	$timezone = 'Asia/Calcutta';
	
	$offset = $this->offset($timezone);
	
//	CONVERT_TZ(s_out,'+00:00','$gmt')

	echo $offset; 
	$gmt = '+05:30'; 
	
	$tutorevent = $this->TutorEvent->find('all',array('conditions'=>array('member_id'=>10),
	'fields' => array('CONVERT_TZ(TutorEvent.start,  "-05:00",  "'.$gmt.'" ) as created','TutorEvent.id'),
													  )
										  );
	echo '<pre>';print_r($tutorevent);die;
	
	$this->set('timezone',$timezone);
	$this->set('tutorevent',$tutorevent);
	
	
	
}



function view()
{
	
	
	echo '<pre>';
$zones_array = array();        
$timestamp = time();         
foreach (timezone_identifiers_list() as $key => $zone) {    
    date_default_timezone_set($zone);
    $zones_array[$key]['zone'] = $zone;
    $zones_array[$key]['diff_from_GMT'] = date('P', $timestamp);
}
print_r($zones_array);



/*foreach($zones_array as $za)
{
	
	$this->data['Timezone']['GMT'] = $za['diff_from_GMT'] ;
	$this->data['Timezone']['name'] = $za['zone'] ;
	$this->Timezone->create();
	$this->Timezone->save($this->data);
	
}

*/


	
	
	
	echo '<pre>';
	$timezone_abbreviations = DateTimeZone::listAbbreviations();
	print_r($timezone_abbreviations);
	die;
	
	
	
	
/*	$dateTime = new DateTime("now", new DateTimeZone('America/Indiana/Indianapolis'));
		echo $dateTime->format("Y-m-d H:i:s r O").'<br>';
*/		

//		$current = date("Y-m-d H:i:s",time());
		$current = '2012-03-16 11:40:10';
		
		$offset = 5.5;
		
		echo $current.'<br>';
	//	echo date("Y-m-d H:i:s", $current);
	
	
	//	$startdate = date("Y-m-d", strtotime($current->data['TutEvent']['start_date']));
	
		$gmtconvert = date('Y-m-d H:i:s r', strtotime("$offset hours", strtotime($current)));
		
		echo $gmtconvert;
		
		die;
	
/*		$gmtconvert = strtotime("$offset hours", strtotime($current));
		echo '<br>'.date("Y-m-d H:i:s", $gmtconvert);
		

		$dateTimeZone = new DateTimeZone('GMT');
		$dateTime->setTimezone($dateTimeZone);
		
		echo date_format($date, 'Y-m-d H:i:s');
		
		echo $dateTime->format("Y-m-d H:i:s r O");
*/
		
	
	
	
	$u_id = 1;
$gmt = '+8:00'; 

$sql1 ="SELECT 
                           TIME(CONVERT_TZ(s_out,'+00:00','$gmt')) AS time_out,
                           TIME(CONVERT_TZ(s_in,'+00:00','$gmt')) AS time_in                         
                           FROM sd_record WHERE user_id = '$u_id' ORDER BY id DESC LIMIT 1";

echo  $sql1;

echo '<hr>';

$sql ="SELECT 
                           TIME(CONVERT_TZ(s_out,'+00:00','+8:00')) AS time_out,
                           TIME(CONVERT_TZ(s_in,'+00:00','+8:00')) AS time_in                         
                           FROM sd_record WHERE user_id = '$u_id' ORDER BY id DESC LIMIT 1";

echo  $sql;
echo  '<br />';

$r = mysql_fetch_assoc(mysql_query($sql));
echo  $r['time_in'];  
	
	
	
	
}



function conver_to_time($conv_fr_zon=0,$conv_fr_time="",$conv_to_zon=0)
  {
   //echo $conv_fr_zon."<br>";
   $cd = strtotime($conv_fr_time);
   $gmdate = date('Y-m-d H:i:s', mktime(date('H',$cd)-$conv_fr_zon,date('i',$cd),date('s',$cd),date('m',$cd),date('d',$cd),date('Y',$cd)));
   //echo $gmdate."<br>";
   $gm_timestamp = strtotime($gmdate);
   $finaldate = date('Y-m-d H:i:s', mktime(date('H',$gm_timestamp )+$conv_to_zon,date('i',$gm_timestamp ),date('s',$gm_timestamp ),date('m',$gm_timestamp ),date('d',$gm_timestamp ),date('Y',$gm_timestamp )));
   return $finaldate;
  }
  
  
 







		
}
?>