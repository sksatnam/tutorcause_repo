<br />
<?php $marginTop = ($session->read('Admin.id') && $session->read('Admin.username')) ? '' : 'margin-top:120px;'; ?>

<div id="full-login" style="width:50%;margin-left:auto;margin-right:auto;<?php echo $marginTop; ?>">
      
      	<div class="box">      
      		<h4 style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Welcome to Tutor Cause Admin Panel</h4>
        <div style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;" class="box-container rounded_by_jQuery_corners">
        
        
         <div id="loading" class="fixedTop" style="font-size:14px">
             Loading..
         </div>
                  
                   
        
      		<?php echo $form->create('Member',array('class' => 'middle-forms',"id"=>"AdminLogin",'url' => '/admin/members/login')); ?>
            
                <h3>Admin Login</h3>
                <div id="loginAlert" class="loginAlert" style="display:none; color:#78501B; font-weight:bold; width:360px;"></div>
                
             
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
                        
                         
						
						<li class="even">
                       <label for="adminuser" style="margin-right:38px;"> <b>E-mail</b> </label>
                    
						<?php  echo $form->input('username',array('class'=>'txtbox-long required','style'=> 'margin-right:35px','id'=>'adminuser','label' =>''));?>
							<?php //echo $html->input('User/username', array('size' => '60'));
								// display an error message if data doesn't validate
							?>
						
                            
						</li>
                        
                        <li class="even">
                        
                         <label for="pass"> <b>Password </b> </label>
                         
							<?php echo $form->input('pwd',array('class'=>'txtbox-long required','style'=> 'margin-right:35px','text'=>'password ','id'=>'pass','label' =>'', 'type' => 'password'));?>
						
						</li>
                        						
						<br />
						
						</ol>
						<div class="align-right">
						<?php echo $form->submit('login.png', array('style'=>'margin: 0px 5px;'));?> 
					<?php // echo $form->submit('Log In',array('class'=>'loginbutton'));?>	
					<?php //echo $form->end();?>			
				</div>
					 </fieldset>
				
        </div><!-- end of div.box-container -->
      	</div><!-- end of div.box -->

</div>  <!--  full-login end -->
		