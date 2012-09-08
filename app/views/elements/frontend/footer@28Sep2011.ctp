<div id="footer">
	<div class="footerBox">
		<h3>About Tutor Cause</h3>
		<?php echo $html->link('About Us', HTTP_ROOT.'homes/about_us',array('class'=>'footerBoxLink')); ?>
        <?php echo $html->link('Site Map', HTTP_ROOT.'homes/site_map',array('class'=>'footerBoxLink')); ?>
        <?php echo $html->link('Contact Us', HTTP_ROOT.'homes/contact_us',array('class'=>'footerBoxLink')); ?>
		
	</div>
	<div class="footerBox">
		<h3>Terms & Conditions</h3>
    	<?php echo $html->link('Privacy Policy', HTTP_ROOT.'homes/privacy_policy',array('class'=>'footerBoxLink')); ?>
        <?php // echo $html->link('Service Terms', HTTP_ROOT.'homes/service_terms',array('class'=>'footerBoxLink')); ?>
		<?php echo $html->link('Standard Terms', HTTP_ROOT.'homes/standard_terms',array('class'=>'footerBoxLink')); ?>
	
	</div>
	<div class="footerBox">
    &nbsp;
	<!--	<h3>FAQ </h3>-->
       
        <?php
  /*      echo $html->link('Cause Faqs',array('controller'=>'faqs', 'action'=>'cause'),array('class'=>'footerBoxLink'));
		echo $html->link('Tutor Faqs',array('controller'=>'faqs', 'action'=>'tutor'),array('class'=>'footerBoxLink'));
        echo $html->link('Student Faqs',array('controller'=>'faqs', 'action'=>'student'),array('class'=>'footerBoxLink'));
	*/	?>
	</div>
	<?php /*?>/*<div class="footerBox">
		<h3>Heading</h3>
		<a class="footerBoxLink" href="javascript:void(0);">Link Here</a>
		<a class="footerBoxLink" href="javascript:void(0);">Link Here</a>
		<a class="footerBoxLink" href="javascript:void(0);">Link Here</a>
	</div>*/?>
	<div class="footerBox">
		<h3>Connect With Us</h3> 
		<a class="socialLink" href="http://facebook.com/tutorcause"><img src="<?php echo FIMAGE;?>facebook.png" alt="Facebook" width="30" height="30" /></a>
		<a class="socialLink" href="http://twitter.com/tutorcause"><img src="<?php echo FIMAGE;?>twitter.png" alt="Twitter" width="30" height="30" /></a>
<!--		<a class="socialLink" href="javascript:void(0);"><img src="<?php // echo  FIMAGE;?>linked_in.png" alt="Linkdln" width="30" height="30" /></a>
-->	</div>
	<div class="PrivacyPolicy">&nbsp;</div>
	<?php /* <div class="PrivacyPolicy">Sed ut perspiciatis  <?php echo $html->link('About Us', HTTP_ROOT.'homes/about_us'); ?></div> */ ?>
	<div class="copyrgt">&copy; Copyright 2011 TutorCause, LLC</div>     
</div>