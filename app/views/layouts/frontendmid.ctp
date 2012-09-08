<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php // echo $this->Html->charset(); ?>
<title>TutorCause</title>
<?php 
echo $this->Html->meta('icon');
//	echo $html->css('frontend/look');
echo $html->css('frontend/look_min');
//   echo $html->css('frontend/stylesheet');
echo $html->css('frontend/stylesheet_min');

echo $html->css('jquery');
echo $html->css('frontend/autosuggest');

//	echo $html->css('frontend/autosuggest-org');

if($this->action=='calendar' || $this->action=='set_availability' || $this->action=='book_tutor_time' )
{
echo $html->css('frontend/fullcalendar');
}

if($this->action=='tutor_dashboard')
{
echo $html->css('frontend/fullcalendarorg');
}

echo $html->css('frontend/rating');
//echo $html->css('frontend/fullcalendar.print');
//	echo $html->css('frontend/datetime.css');
echo $html->css('frontend/jquery-ui-1.8.14.custom');
echo $html->css('jquery.autocomplete');

echo $html->css('frontend/jquery.countdown');





echo $javascript->link('jquery-1.4.2.min');	
//	echo  $html->css('frontend/cupertino/theme');
//	echo $javascript->link('jquery-1.6.min');
echo $javascript->link('jquery-ui-min.js');
//	echo $javascript->link('jquery.validate');
echo $javascript->link('jquery.validatefull');
echo $javascript->link('jquery.rating');
echo $javascript->link('common.js');
//	echo $javascript->link('common_min.js');

//	echo $javascript->link('jquery.ausu-autosuggest');

//	echo $javascript->link('jquery.ausu-autosuggest-org');

//	echo $javascript->link('fullcalendar.min');	

if($this->action=='calendar' || $this->action=='set_availability' || $this->action=='book_tutor_time')
{
echo $javascript->link('fullcalendar');	
}

if($this->action=='tutor_dashboard')
{
  echo $javascript->link('fullcalendarsmall');	
}

echo $javascript->link('datetime.js');
//	echo $javascript->link('jquery.maskedinput');
echo $javascript->link('jquery.maskedinput_min');




echo $javascript->link('dynamicDate.js');
//	echo $javascript->link('bugherd');
//echo $javascript->link('fullcalendar');
//	echo $javascript->link('jquery');
echo $javascript->link('jquery.tabify');
echo $javascript->link('imgUpload');
echo $javascript->link('jquery.autocomplete.js');

if($this->Session->read('Member.group_id')==6)
{	
//	echo $javascript->link('jquery.flip.js');
echo $javascript->link('jquery.flip_min.js');
}

echo $javascript->link('jquery.countdown');



//echo $javascript->link('jquery.ui.core');
//jquery-1.6.min
/*
Api key -> a8d25ac00f5e034add37c542c58bc7b5
Api Secret -> 0300b8dc61eb8f63e90717b72b7a373a
*/
echo $javascript->link('tiny_mce/plugins/asciimath/js/ASCIIMathMLwFallback.js');
?>



<script type="text/javascript">
var AMTcgiloc = "http://www.imathas.com/cgi-bin/mimetex.cgi";  		//change me
</script>

<!-- TinyMCE -->

<?php echo $javascript->link('tiny_mce/tiny_mce.js'); ?>


<script type="text/javascript">
tinyMCE.init({
				 
    mode : "textareas",
    theme : "advanced",
    theme_advanced_buttons1 : "bold,separator,italic,separator,asciimath,asciimathcharmap,separator,",
    theme_advanced_buttons2 : "",
    theme_advanced_buttons3 : "",
    theme_advanced_fonts : "Arial=arial,helvetica,sans-serif,Courier New=courier new,courier,monospace,Georgia=georgia,times new roman,times,serif,Tahoma=tahoma,arial,helvetica,sans-serif,Times=times new roman,times,serif,Verdana=verdana,arial,helvetica,sans-serif",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "",
    plugins : 'asciimath,asciisvg,table,inlinepopups,media',
   
    AScgiloc : 'http://www.imathas.com/editordemo/php/svgimg.php',			      //change me  
    ASdloc : 'http://www.imathas.com/editordemo/jscripts/tiny_mce/plugins/asciisvg/js/d.svg',  //change me  	
        
    content_css : "css/tinymce_math/content.css"
});

</script>
<!-- /TinyMCE -->

<link rel="shortcut icon" href="<?php echo $html->url('/favicon.ico'); ?>" />
<?php echo $scripts_for_layout; ?>
</head>
<body>
<?php    
if($this->action!='live_start')
{
?>	
<div id="loading" class="fixedTop"></div>
<?php
}
?>
<?php	
		echo $content_for_layout; 
		
?>
</body>
</html>