<?php
	//$courses = "<option value=''>Select course</option>";
	foreach($course as $key=>$value){
	$courses .= "<option value=".$key."'>".$value."</option>";
	}
	/*	$courses .="<option value='a'>a</option>";
		$courses .="<option value='b'>b</option>";
		$courses .="<option value='c'>c</option>";*/
		echo $courses;
?>