<div id="header">
	<div class="logoLoginContainer">
		<div class="logo">
			<?php
			if($session->read('Member.id')){
				if($session->read('Member.group_id')==6) {
					echo $html->link($html->image('frontend/logonew.png'),array('controller'=>'members', 'action'=>'cause_dashboard'),array('escape' => false));
				}
				else if($session->read('Member.group_id')==7) {
					echo $html->link($html->image('frontend/logonew.png'),array('controller'=>'members', 'action'=>'tutor_dashboard') ,array('escape' => false));							
				}
				else if($session->read('Member.group_id')==8) {
					echo $html->link($html->image('frontend/logonew.png'),array('controller'=>'members', 'action'=>'student_dashboard') ,array('escape' => false));							
				}
				else {
					echo $html->link($html->image('frontend/logonew.png'),array('controller'=>'members', 'action'=>'select_type') ,array('escape' => false));
				}
			} else {
				echo $html->link($html->image('frontend/logonew.png'),array('controller'=>'members', 'action'=>'index') ,array('escape' => false));
			}
			?>	
		</div>
		<div class="headerRgtCot">
        	<div id="login-wrap">
            	<div id="fb-login">
					<?php
						if($session->read('Member.id')){
							if($session->read('Member.group_id')==6) {
								echo $html->link('My Dashboard',array('controller'=>'members', 'action'=>'cause_dashboard'),array('style'=>'color: #fff;'));
							}
							else if($session->read('Member.group_id')==7) {
								echo $html->link('My Dashboard',array('controller'=>'members', 'action'=>'tutor_dashboard') ,array('style'=>'color: #fff;'));							
							}
							else if($session->read('Member.group_id')==8) {
								echo $html->link('My Dashboard',array('controller'=>'members', 'action'=>'student_dashboard') ,array('style'=>'color: #fff;'));							
							}
							else {
								echo $html->link('Select profile',array('controller'=>'members', 'action'=>'select_type') ,array('style'=>'color: #fff;'));
							}
							echo "&nbsp;|&nbsp;";
							echo $html->link('Logout',array('controller'=>'members','action'=>'logout'));
							
							
							if (date_default_timezone_get()) {
						?>
						<br />
                     <iframe src="http://free.timeanddate.com/clock/i2s79ufs/n105/fs12/fcfff/tct/pct/ahr/pt5/tt0/tw0/tm1/tb2" frameborder="0" width="146" height="21" allowTransparency="true"></iframe>

 
                        
               <!--         
                    <iframe src="http://free.timeanddate.com/clock/i2s76rrz/n105/fs12/fcfff/tct/pct/ahr/ftb/tt0/tw0/tm1/tb1" frameborder="0" width="151" height="17" allowTransparency="true"></iframe>-->

	<!--					<iframe src="http://free.timeanddate.com/clock/i2r0hil8/n105/fs12/tct/pct/ahr/tt0/tw0/tm1/ts1/tb4" frameborder="0" width="75" height="32" allowTransparency="true"></iframe>-->
						<?php
						}
						
						} 
						else {  ?>
							<a class="facebookConnect" href="<?php echo $facebookURL; ?>">
								<?php echo $html->image('frontend/fb-login.jpg',array('alt' => 'Login with facebook')); ?>
							</a>
				<?php	} ?>
                </div>
                <div id="social-bg">
                	<a class="facebook" href="http://facebook.com/tutorcause">
						<?php echo $html->image('frontend/facebook_link.png') ?>
                    </a>
                    <a class="twitter" href="http://twitter.com/tutorcause">
                    	<?php echo $html->image('frontend/twitter_link.png') ?>
                    </a>
                </div>
            </div>
            <div class="navigation">
				<div id="nav-left"></div>
				<div id="nav-center">
					<ul id="nav">
						<?php
							if($session->read('Member.id')){
						?>
							<li>
							<?php  
								if($this->Session->read('Member.group_id')==8) {
									 echo $html->link('Dashboard',array('controller'=>'members','action'=>'student_dashboard')); 
								}
								else if($this->Session->read('Member.group_id')==6) {
									 echo $html->link('Dashboard',array('controller'=>'members','action'=>'cause_dashboard')); 
								}
								else if($this->Session->read('Member.group_id')==7) {
									 echo $html->link('Dashboard',array('controller'=>'members','action'=>'tutor_dashboard')); 
								}
								else {
									 echo $html->link('Dashboard',array('controller'=>'members','action'=>'select_type')); 
								}
							?>	
							</li>
				<?php	} else {  ?>
							<li>
								<a href="<?php echo HTTP_ROOT;?>">Home</a>
							</li>
				<?php	} ?>
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
                        
                        <?php
                        	if($session->read('Member.id')=='')
							{
						?>		
						<li>
							<?php echo $html->link('About Us', HTTP_ROOT.'homes/about_us'); ?>
						</li>
						<li>
							<?php echo $html->link('Parents', HTTP_ROOT.'homes/parents'); ?>
						</li>
                        <?php
							}
						?>
						
						<li>
							<?php echo $html->link('Support', 'http://support.tutorcause.com',array('class'=>'footerBoxLink')); ?>
						</li>
						<li class="last">
							<?php echo $html->link('Contact Us', HTTP_ROOT.'homes/contact_us'); ?>
						</li>
					</ul>
				</div>
				<div id="nav-right"></div>
			</div>
		</div>
	</div>	
 </div>