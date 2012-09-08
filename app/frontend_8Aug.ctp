<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<meta http-equiv="CACHE-CONTROL" content="Public"/>
<meta http-equiv="EXPIRES" content="max-age"/>
<?php // echo $this->Html->charset(); ?>
<title>TutorCause</title>
<?php //3aug2012 ?>
<?php 
echo $this->Html->meta('icon');
//	echo $html->css('frontend/look');

echo $html->css('frontend/stylesheet_min');
echo $html->css('frontend/look_min');
//   echo $html->css('frontend/stylesheet');


echo $html->css('jquery');
echo $html->css('frontend/autosuggest');

//	echo $html->css('frontend/autosuggest-org');

if($this->action=='calendar' || $this->action=='set_availability' || $this->action=='book_tutor_time' || $this->action=='profiletutoravail' )
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

if($this->action=='calendar' || $this->action=='set_availability' || $this->action=='book_tutor_time' || $this->action=='profiletutoravail')
{
echo $javascript->link('fullcalendar');	
}

if($this->action=='tutor_dashboard')
{
  echo $javascript->link('fullcalendarsmall');	
}


if($this->action=='add_fund' || $this->action=='parent_fund')
{
  echo $javascript->link('stripe');	
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
//  echo $javascript->link('tiny_mce/plugins/asciimath/js/ASCIIMathMLwFallback.js');
?>




<!-- TinyMCE -->

<?php echo $javascript->link('tiny_mce/tiny_mce.js'); ?>

<script type="text/javascript">
tinyMCE.init({ 
plugins : 'equation', 
mode : "specific_textareas",
editor_selector : "mceEditor",
theme : "advanced",
theme_advanced_buttons1 : 
  "bold,italic,equation",
theme_advanced_buttons2 : "",
theme_advanced_buttons3 : "",
theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : ""
});
</script>







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
<div id="main">
	<div id="mainCont">
    	<div id="container">
        	<?php 
				echo $this->element('frontend/header');
			?>
            
            <div id="middlecontent" style="float:left; width:940px; margin:15px 0; border:1px solid #ccc; border-radius:5px; -moz-border-radius:5px; padding: 20px;background-color:#FFF; min-height:350px;">
            
            <?php	
				echo $content_for_layout; 
			?>
            
            </div>
            
            <div class="clear"></div>
        </div>
    </div>
    <?php	
		echo $this->element('frontend/footer');
 	?>            
            
</div>
<div style="clear:both;"></div>

<?php

/*echo '<pre>';
print_r($_SESSION); 
print_r($_COOKIE);
echo '</pre>';
echo  $this->element('sql_dump');
*/

?>


<script id="IntercomSettingsScriptTag">
  var intercomSettings = {
    app_id: 'j90xa82f',
    email: '<?php echo $this->Session->read('Member.email');?>', // TODO: User's e-mail address
    created_at: <?php  echo strtotime($this->Session->read('Member.created')); ?>// TODO: User's sign-up date, Unix timestamp
  };
</script>
<script>
  (function() {
    function async_load() {
      var s = document.createElement('script');
      s.type = 'text/javascript'; s.async = true;
      s.src = 'https://api.intercom.io/api/js/library.js';
      var x = document.getElementsByTagName('script')[0];
      x.parentNode.insertBefore(s, x);
    }
    if (window.attachEvent) {
      window.attachEvent('onload', async_load);
    } else {
      window.addEventListener('load', async_load, false);
    }
  })();
</script>


</body>
</html>
