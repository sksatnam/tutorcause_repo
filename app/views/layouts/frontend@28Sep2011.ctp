<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TutorCause</title>
	<?php 
	echo $this->Html->meta('icon');
	echo $html->css('frontend/look');
    echo $html->css('frontend/stylesheet');
	echo $html->css('jquery');
	echo $html->css('frontend/autosuggest');
	echo $html->css('frontend/fullcalendar');
	echo $html->css('frontend/rating');
	//echo $html->css('frontend/fullcalendar.print');
//	echo $html->css('frontend/datetime.css');
	echo $html->css('frontend/jquery-ui-1.8.14.custom');
	echo $html->css('jquery.autocomplete');
	echo $javascript->link('jquery-1.4.2.min');	
 //	echo  $html->css('frontend/cupertino/theme');
//	echo $javascript->link('jquery-1.6.min');
	echo $javascript->link('jquery-ui-min.js');
	echo $javascript->link('jquery.validate');
	echo $javascript->link('jquery.rating');
	echo $javascript->link('common.js');
	echo $javascript->link('jquery.ausu-autosuggest');
//	echo $javascript->link('fullcalendar.min');	
	echo $javascript->link('fullcalendar');
	echo $javascript->link('datetime.js');
	echo $javascript->link('jquery.maskedinput');
	echo $javascript->link('dynamicDate.js');
//	echo $javascript->link('bugherd');
//echo $javascript->link('fullcalendar');
//	echo $javascript->link('jquery');
	echo $javascript->link('jquery.tabify');
	echo $javascript->link('imgUpload');
	echo $javascript->link('jquery.autocomplete.js');
	//echo $javascript->link('jquery.ui.core');
	//jquery-1.6.min
	/*
	Api key -> a8d25ac00f5e034add37c542c58bc7b5
	Api Secret -> 0300b8dc61eb8f63e90717b72b7a373a
	*/
	?>
<link rel="shortcut icon" href="<?php echo $html->url('/favicon.ico'); ?>" />
	<?php echo $scripts_for_layout; ?>
	<style type="text/css">
	#loading
	{
		width:110px;
		height:16px;
		padding:1px 3px 1px 3px;
		z-index:9999;
		background-image:url(<?php echo FIMAGE;?>/ajaxLoader.gif);
		
	}
	span.error {color: red;}
	</style>
</head>
<body>
    
<div id="loading" class="fixedTop"></div>
<div id="main">
	<div id="mainCont">
    	<div id="container">
        	<?php 
				echo $this->element('frontend/header');
				echo $content_for_layout; 
				echo $this->element('frontend/footer');
 			?>            
            
        </div>
    </div>
</div>
<div style="clear:both;"></div>
</body>

</html>