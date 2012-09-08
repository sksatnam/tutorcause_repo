<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Admin</title>
	<?php echo $html->css('style');?>
	<?php echo $html->css('tinymce/content');?>
	<?php echo $html->css('tinymce/word');?>
    
    <?php  echo $javascript->link('jquery-1.4.2.min.js'); ?>
	<?php // echo $javascript->link('jquery-ui-1.8.2.custom.min.js'); ?>
    <?php // echo $javascript->link('jquery.autocomplete.js'); ?>
	
	<?php //  echo $javascript->link('jquery.min.js'); ?>
	<?php  echo $javascript->link('jquery.validate.js'); ?>
	<?php  echo $javascript->link('common.js'); ?>
	<?php //  echo $javascript->link('jquery.maskedinput'); ?>
	<?php  echo $javascript->link('tinymce/tiny_mce.js'); ?>
	
	<?php //  echo $javascript->link('main.js'); ?>

  <?php // echo $javascript->link('bugherd'); ?>


 <!--   <link rel="shortcut icon" href="favicon.ico">
	
	<link rel="icon" type="image/gif" href="animated_favicon1.gif">-->
<link rel="shortcut icon" href="<?php echo $html->url('/favicon.ico'); ?>" />

	<?php echo $scripts_for_layout; ?>
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>

	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "specific_textareas",
		theme : "advanced",
		editor_selector : 'tinymce',

		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		 theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontsizeselect,fullscreen,undo,redo,|,link,unlink,image,code,|,preview,|,forecolor,backcolor,styleprops,emotions,bullist,numlist,print",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		
		
		// Theme options
	/* 	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		  */
		
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	
	});
</script>
	<style type="text/css">
    span.error {color: red;}
  </style>
</head>
<body id="body">
<div id="container">
    <div id="header">
      <div id="top">
	  <?php //pr($session->read('Admin.loginStatus'));die;?>
		  <h1><?php echo $html->link('TUTOR CAUSE', '/admin/members/dashboard'); ?></h1>
		<?php if($session->read('Admin.id') && $session->read('Admin.email')): ?>
		  <p id="userbox">Hello <strong><?php e($session->read('Admin.email')); ?></strong> &nbsp;|  &nbsp;<?php echo $html->link('Logout', '/admin/members/logout'); ?> <br><small>Last Login: <?php $loginStatus = strtotime($session->read('Admin.loginStatus'));
		  if($loginStatus)
		  {
			echo date("F d, Y  g:i:s A", $loginStatus);  
		   }
		   else
		   {
			 echo 'N/A';  
		    }
		  
		   ?></small></p>
		  <span class="clearFix">&nbsp;</span>
		<?php endif; ?>
      </div>
	  <?php if($session->read('Admin.id') && $session->read('Admin.email')): ?> 
		<ul id="menu">
			<li class="<?php echo $dashBoard = isset($dashBoard) ? $dashBoard :'';?>"><?php echo $html->link('Dashboard', '/admin/members/dashboard'); ?></li>
			
            <?php if($session->read('Admin.group_id')=='1')
			{
            ?>
			<li class="<?php echo $parentClass =isset($parentClass) ? $parentClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Users <span>&nbsp;</span></a>
			  <ul style="display: none;">
				<li><?php echo $html->link('Add Users', '/admin/members/add'); ?></li>
				<?php /*?><li><?php echo $html->link('View Users', '/admin/members/view'); ?></li><?php */?>
				<li><?php echo $html->link('View User', '/admin/members/member_view'); ?></li>
			  </ul>
			</li>
            <li class="<?php echo $causeClass =isset($causeClass) ? $causeClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Causes <span>&nbsp;</span></a>
			  <ul style="display: none;">
				<?php /*?><li><?php echo $html->link('View Users', '/admin/members/view'); ?></li><?php */?>
				<li><?php echo $html->link('View Cause', '/admin/members/cause_view'); ?></li>
			  </ul>
			</li>
            
             <li class="<?php echo $faqClass =isset($faqClass) ? $faqClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">FAQ'S <span>&nbsp;</span></a>
            <ul style="display: none;">
              <li><?php echo $html->link('Add FAQs', '/admin/faqs/faq_add'); ?></li>
				<li><?php echo $html->link('View FAQs', '/admin/faqs/faq_view'); ?></li>
                
			  </ul>
              </li>
             
            
            <?php 
			}
			?>
            
            
            <li class="<?php echo $manageClass =isset($manageClass) ? $manageClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Manage<span>&nbsp;</span></a>
			  <ul style="display: none;">
              
              <?php if($session->read('Admin.group_id')=='1')
			{
            ?>
				<li ><?php echo $html->link('CMS Pages', '/admin/members/front_static_page'); ?></li>
                <li ><?php echo $html->link('Email Template', '/admin/members/email_template'); ?></l
              ><?php 
			}
			?>  
				<li ><?php echo $html->link('Change Password', '/admin/members/change_password'); ?></li>
				
			  </ul>
			</li>
            
            
            <?php if($session->read('Admin.group_id')=='3' || $session->read('Admin.group_id')=='1' )
			{
            ?>
			<li class="<?php echo $secondClass =isset($secondClass) ? $secondClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Schools <span>&nbsp;</span></a>
			  <ul style="display: none;">
				<li><?php echo $html->link('Add Schools', array('controller'=>'schools','action'=>'add','admin'=>'true')); ?></li>
				<?php /*?><li><?php echo $html->link('View Users', '/admin/members/view'); ?></li><?php */?>
				<li><?php echo $html->link('View Schools', array('controller'=>'schools','action'=>'view','admin'=>'true')); ?></li>
                
                <li><?php echo $html->link('Add Courses', array('controller'=>'schools','action'=>'course_add','admin'=>'true')); ?></li>
                <li><?php echo $html->link('View Courses', array('controller'=>'schools','action'=>'all_course_view','admin'=>'true')); ?></li>
			  </ul>
			</li>
            
            <?php 
			}
			?>
            
            
            
           <?php /*?> FOR THE  SCHOOL ADMINISTRATOR <?php */?>
           
           
            
             <?php if($session->read('Admin.group_id')=='4')
			{
            ?>
			<li class="<?php echo $secondClass =isset($secondClass) ? $secondClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Schools <span>&nbsp;</span></a>
			  <ul style="display: none;">
				<li><?php echo $html->link('Edit School', array('controller'=>'schools','action'=>'edit_assign_school',$session->read('Admin.school_id'),'admin'=>'true')); ?></li>
	                <li><?php echo $html->link('Add Courses', array('controller'=>'schools','action'=>'add_assign_course','admin'=>'true')); ?></li>
                <li><?php echo $html->link('View Courses', array('controller'=>'schools','action'=>'view_assign_course','admin'=>'true')); ?></li>
			  </ul>
			</li>
            
            <?php 
			}
			?>
            
             <?php if($session->read('Admin.group_id')=='1' || $session->read('Admin.group_id')=='2')
			 {
			 ?>
              <li class="<?php echo $paymentClass =isset($paymentClass) ? $paymentClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Payments <span>&nbsp;</span></a>
            <ul style="display: none;">
           <li><?php echo $html->link('View Payments', array('controller'=>'payment_histories','action'=>'salesreport','admin'=>'true')); ?></li>
             <li><?php echo $html->link('View Cause Withdrawal', array('controller'=>'payment_histories','action'=>'cause_withdrawal','admin'=>'true')); ?></li>
			<li><?php echo $html->link('View Tutor Withdrawal', array('controller'=>'payment_histories','action'=>'tutor_withdrawal','admin'=>'true')); ?></li>
			 <li><?php echo $html->link('Refund Requests', array('controller'=>'payment_histories','action'=>'refund_request','admin'=>'true')); ?></li>
			 <li><?php echo $html->link('Student Fund', array('controller'=>'payment_histories','action'=>'student_fund','admin'=>'true')); ?></li>
             
              <li><?php echo $html->link('TutorCause fee', array('controller'=>'payment_histories','action'=>'charges','admin'=>'true')); ?></li>
			
			  </ul>
              </li>
              
             <?php 
			 }
			 ?>
             
             
             <?php if($session->read('Admin.group_id')=='1')
			 {
			 ?>
              <li class="<?php echo $mailClass =isset($mailClass) ? $mailClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Mail Chimp <span>&nbsp;</span></a>
            <ul style="display: none;">
				<li><?php echo $html->link('Subscribers', array('controller'=>'members','action'=>'mailchimpview','admin'=>'true')); ?></li>
				<li><?php echo $html->link('School Requests', array('controller'=>'members','action'=>'school_requests','admin'=>'true')); ?></li>
             </ul>
              </li>
              
             <?php 
			 }
			 ?>
            
            
			<?php /* <li class="<?php echo $articleClass =isset($articleClass) ? $articleClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Classified <span>&nbsp;</span></a>
			  <ul style="display: none;">
				<li><?php echo $html->link('Add Classified', '/admin/articles/add'); ?></li>
				<li><?php echo $html->link('View Classified', '/admin/articles/view'); ?></li>
			  </ul>
			</li> 
			<li class="<?php echo $reviewsClass =isset($reviewsClass) ? $reviewsClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Reviews <span>&nbsp;</span></a>
			  <ul style="display: none;">
				<li><?php echo $html->link('View Reviews', '/admin/reviews/view'); ?></li>
			  </ul>
			</li>
			<li class="<?php echo $questClass =isset($questClass) ? $questClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Forums <span>&nbsp;</span></a>
			  <ul style="display: none;">
				<li><?php echo $html->link('School Forum View', '/admin/forums/schoolView'); ?></li>
				<li><?php echo $html->link('Parent Forum View', '/admin/forums/parentView'); ?></li>
				
			  </ul>
			</li> */?>
		
			
			
			<?php /*?><li class="<?php echo $adsClass =isset($adsClass) ? $adsClass : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Advertising <span>&nbsp;</span></a>
				<ul style="display: none;">
					<li><?php echo $html->link('Add Ads', '/admin/ads/add'); ?></li>
					<li><?php echo $html->link('Add Ads', '/admin/ads/view'); ?></li>
					<li><?php echo $html->link('Tracking', '/admin/ads/tracking'); ?></li>
			  </ul>
			</li><?php */?>
			<?php /* <li class="<?php echo $addprice =isset($addprice) ? $addprice : ''; ?>"><a style="background-position: 0px 0px;" class="top-level" href="#">Subscription <span>&nbsp;</span></a>
			  <ul style="display: none;">
				<li><?php echo $html->link('Add Subscription', '/admin/members/subscription'); ?></li>
				<li><?php echo $html->link('View Subscription', '/admin/members/subscriptionView'); ?></li>
				
			  </ul>
			</li> */?>
            
            
	
            
            
			
		  </ul>
          
          

      <span class="clearFix">&nbsp;</span>
	  <?php endif; ?>
    </div><!-- end of #header -->
<?php echo $content_for_layout ?>
<?php echo $this->element('adminElements/footer'); ?>

