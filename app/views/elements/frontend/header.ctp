<div id="header">
	<div class="logoLoginContainer">
		<div class="logo">
			<?php
			if($session->read('Member.memberid')){
				if($session->read('Member.group_id')==6 && $session->read('Member.active')=='1') {
					echo $html->link($html->image('frontend/logonew.png',array('width'=>200,'height'=>85)),array('controller'=>'members', 'action'=>'non_profit_dashboard'),array('escape' => false));
				}
				else if($session->read('Member.group_id')==7 && $session->read('Member.active')=='1') {
					echo $html->link($html->image('frontend/logonew.png',array('width'=>200,'height'=>85)),array('controller'=>'members', 'action'=>'tutor_dashboard') ,array('escape' => false));							
				}
				else if($session->read('Member.group_id')==8 && $session->read('Member.active')=='1') {
					echo $html->link($html->image('frontend/logonew.png',array('width'=>200,'height'=>85)),array('controller'=>'members', 'action'=>'student_dashboard') ,array('escape' => false));							
				}
				else if($session->read('Member.group_id')==9 && $session->read('Member.active')=='1') {
					echo $html->link($html->image('frontend/logonew.png',array('width'=>200,'height'=>85)),array('controller'=>'members', 'action'=>'parent_dashboard') ,array('escape' => false));							
				}
				else {
					echo $html->link($html->image('frontend/logonew.png',array('width'=>200,'height'=>85)),array('controller'=>'members', 'action'=>'select_type') ,array('escape' => false));
				}
			} else {
				echo $html->link($html->image('frontend/logonew.png',array('width'=>200,'height'=>85)),array('controller'=>'members', 'action'=>'index') ,array('escape' => false));
			}
			?>	
		</div>
		<div class="headerRgtCot">
        	<div id="login-wrap">
            	
					<?php
						if($session->read('Member.memberid')){
							?>
							<div id="fb-logout">
                            
                            <a href="<?php echo HTTP_ROOT.'members/logout';?>">Logout</a>
							
							<?php
						/*	if($session->read('Member.group_id')==6) {
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
							} */
						//	echo $html->link('Logout',array('controller'=>'members','action'=>'logout'));
							
						
						// jaswant 18 oct ICLOCK is global variable function is defined in app controller (before filter).
						
						/*if (date_default_timezone_get()) {
							echo ICLOCK;
						} */
						?>
                        </div>
                        <?php
						} 
						else 
						{  ?>
                            <div id="fb-logout">
                            
                            <a href="<?php echo HTTP_ROOT.'homes/login';?>">Login</a>
                            
                         <?php //  echo $html->link('Login',array('controller'=>'homes','action'=>'login')); ?>
                            
                        <?php /*?>    
							<a class="facebookConnect" href="<?php echo $facebookURL; ?>">
								<?php echo $html->image('frontend/fb-login.jpg',array('alt' => 'Login with facebook')); ?>
							</a><?php */?>
                            </div>
						<?php	} ?>
                
                <div id="social-bg">
                	<a class="facebook" href="http://facebook.com/tutorcause">
						<?php echo $html->image('frontend/facebook_link.png', array('width'=>23,'height'=>22)) ?>
                    </a>
                    <a class="twitter" href="http://twitter.com/tutorcause">
                    	<?php echo $html->image('frontend/twitter_link.png', array('width'=>22,'height'=>22)) ?>
                    </a>
                </div>
            </div>
            <div class="navigation">
				<div id="nav-left"></div>
				<div id="nav-center">
					<ul id="nav">
						<?php
							if($session->read('Member.memberid')){
						?>
							<li>
							<?php
								if($this->Session->read('Member.group_id')==9 && $session->read('Member.active')=='1') {
								?>	
							   		<a href="<?php echo HTTP_ROOT.'members/parent_dashboard'?>">Dashboard</a>
                                <?php     
								}
								else if($this->Session->read('Member.group_id')==8 && $session->read('Member.active')=='1') {
								?>
                                	<a href="<?php echo HTTP_ROOT.'members/student_dashboard'?>">Dashboard</a>	
                                <?php     
								}
								else if($this->Session->read('Member.group_id')==6 && $session->read('Member.active')=='1') {
								?>
                                	<a href="<?php echo HTTP_ROOT.'members/non_profit_dashboard'?>">Dashboard</a>		
								<?php     
								}
								else if($this->Session->read('Member.group_id')==7 && $session->read('Member.active')=='1') {
								?>	
                                	<a href="<?php echo HTTP_ROOT.'members/tutor_dashboard'?>">Dashboard</a>		
								<?php     
								}
								else {
									?>
									<a href="<?php echo HTTP_ROOT;?>">Home</a>
                                <?php    
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
                        if($this->Session->read('Member.group_id')==8 && $session->read('Member.active')=='1')
							{
							echo $html->link('Find a Tutor', HTTP_ROOT.'members/search_tutor'); 
							}
                        else if($this->Session->read('Member.group_id')==6 && $session->read('Member.active')=='1' )
							{
							echo $html->link('Find a Tutor', HTTP_ROOT.'members/non_profit_search'); 
							}
                        else if($this->Session->read('Member.group_id')==7 && $session->read('Member.active')=='1')
							{
							echo $html->link('Help a Non-Profit', HTTP_ROOT.'members/find_non_profit'); 
							}
					    ?>	
						</li>
                        
                        <?php
                        	if($session->read('Member.memberid')=='' || $session->read('Member.group_id')=='' || $session->read('Member.active')!='1')
							{
						?>		
						<li>
							<?php echo $html->link('About Us', HTTP_ROOT.'about_us'); ?>
						</li>
						<li>
							<?php echo $html->link('Parents', HTTP_ROOT.'parents'); ?>
						</li>
                        <?php
							}
						?>
						
						<li>
							<?php echo $html->link('Support', 'http://support.tutorcause.com',array('class'=>'footerBoxLink')); ?>
						</li>
						<li class="last">
							<?php echo $html->link('Contact Us', HTTP_ROOT.'contact_us'); ?>
						</li>
					</ul>
				</div>
				<div id="nav-right"></div>
			</div>
		</div>
	</div>	
 </div>
 <?php //3aug2012 ?>