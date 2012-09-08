
<div id="header">
	<div class="logoLoginContainer">
		<div class="logo">
			<?php
			if($session->read('Member.id')){
				if($session->read('Member.group_id')==6)
				{
					echo $html->link($html->image('frontend/tutor_cause.png'),array('controller'=>'members', 'action'=>'cause_dashboard'),array('style'=>'color: #666666;','escape' => false));
					
				}
				else if($session->read('Member.group_id')==7)
				{
					echo $html->link($html->image('frontend/tutor_cause.png'),array('controller'=>'members', 'action'=>'tutor_dashboard') ,array('style'=>'color: #666666;','escape' => false));							
				}
				else if($session->read('Member.group_id')==8)
				{
					echo $html->link($html->image('frontend/tutor_cause.png'),array('controller'=>'members', 'action'=>'student_dashboard') ,array('style'=>'color: #666666;','escape' => false));							
				}
				else{
					echo $html->link($html->image('frontend/tutor_cause.png'),array('controller'=>'members', 'action'=>'select_type') ,array('style'=>'color: #666666;','escape' => false));
				}
			} else {
				echo $html->link($html->image('frontend/tutor_cause.png'),array('controller'=>'members', 'action'=>'index') ,array('style'=>'color: #666666;','escape' => false));
			}
			?>	
		</div>
		<div class="headerRgtCot">
			
			<!--<div class="srchMainCont">
				<div class="srchCont">
					<input type="text" value="Search" onclick="this.value=''" onblur="this.value=!this.value?'Search':this.value" id="search" />
					<input type="submit" style="width:25px; height:30px" />
				</div>
			</div>-->
			
			<?php 
		//	pr($_SESSION);
					if($session->read('Member.id')){
			?>
			
			<?php
			if($session->read('Member.group_id')==6)
			{
			
				echo $html->link('My Dashboard',array('controller'=>'members', 'action'=>'cause_dashboard'),array('style'=>'color: #666666;'));
				
			}
			else if($session->read('Member.group_id')==7)
			{
				echo $html->link('My Dashboard',array('controller'=>'members', 'action'=>'tutor_dashboard') ,array('style'=>'color: #666666;'));							
			}
			else if($session->read('Member.group_id')==8)
			{
				echo $html->link('My Dashboard',array('controller'=>'members', 'action'=>'student_dashboard') ,array('style'=>'color: #666666;'));							
			}
			else{
				echo $html->link('Select profile',array('controller'=>'members', 'action'=>'select_type') ,array('style'=>'color: #666666;'));		

			}
			?>
			&nbsp;|&nbsp;
			  <a href="<?php echo HTTP_ROOT.'members/logout'; ?>" style="color: #666666;">Logout</a>
							   
		<?php
		
		if (date_default_timezone_get()) {
			?>
        <br />    
	<iframe src="http://free.timeanddate.com/clock/i2r0hil8/n105/fs12/tct/pct/ahr/tt0/tw0/tm1/ts1/tb4" frameborder="0" width="75" height="32" allowTransparency="true"></iframe>
    <?php
}
		 }else{
		
	/*	if($this->action == "index"){	*/
		?>
		  <a class="facebookConnect" href="<?php echo $facebookURL; ?>"><img src="<?php echo FIMAGE;?>facebook_connect_white_large_long.gif" alt="Login with Facebook" style="float:right;" /></a>
		<?php /* } */ }?>
		</div>
	</div>
	<div class="navigation">
		<ul>
        
            <?php
        if($session->read('Member.id')){
			?>
            
            <li>
			<?php  
			if($this->Session->read('Member.group_id')==8)
			{
				 echo $html->link('Dashboard',array('controller'=>'members','action'=>'student_dashboard')); 
			}
			else if($this->Session->read('Member.group_id')==6)
			{
				 echo $html->link('Dashboard',array('controller'=>'members','action'=>'cause_dashboard')); 
			}
			else if($this->Session->read('Member.group_id')==7)
			{
				 echo $html->link('Dashboard',array('controller'=>'members','action'=>'tutor_dashboard')); 
			}
			else
			{
				 echo $html->link('Dashboard',array('controller'=>'members','action'=>'select_type')); 
			}
			
			?>	
			</li>
            <?php
		} else {
				?>
			
            <li class="navFirstActive"><a href="<?php echo HTTP_ROOT;?>">Home</a></li>
            <?php
			}
			?>
            
            <li>
			<?php  
			if($this->Session->read('Member.group_id')==8)
			{
				 echo $html->link('Find a Tutor', HTTP_ROOT.'members/tutorsearch'); 
			}
			else if($this->Session->read('Member.group_id')==6 )
			{
				 echo $html->link('Find a Tutor', HTTP_ROOT.'members/causesearch'); 
			}
			else if($this->Session->read('Member.group_id')==7)
			{
				 echo $html->link('Find a Cause', HTTP_ROOT.'members/find_cause'); 
			}
			?>	
			</li>
		
            
			<li><?php echo $html->link('About Us', HTTP_ROOT.'homes/about_us'); ?></li>
            <li><?php echo $html->link('Parents', HTTP_ROOT.'homes/parents'); ?></li>
			<?php /* <li><?php echo $html->link('Privacy Policy', HTTP_ROOT.'homes/privacy_policy',array('class'=>'footerBoxLink')); ?></li> */ ?>
			<li><?php echo $html->link('Support', 'http://support.tutorcause.com',array('class'=>'footerBoxLink')); ?></li>
			
			
			<li><!--<a href="javascript:void(0);">Ipsum </a>--></li>
			<li class="navLast"><!--<?php //echo $html->link('Contact', HTTP_ROOT.'homes/contact_us'); ?>--></li>
		</ul>
	</div>
 </div>