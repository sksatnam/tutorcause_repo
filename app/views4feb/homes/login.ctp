<div class="loginPage">
    <h2>Login</h2>
    <div class="loginLeftSide">
    	<div class="loginLeftHding">
        	&nbsp;
        </div>
        <div class="loginDespOutr">
        	<div class="loginDespInner">
            	<div class="loginDespPic">
                	<?php echo $html->image("frontend/login1.png")?>
                </div>
                <div class="loginDespRgt">
                	<h3><?php echo $html->image("frontend/tutor-txt.png")?></h3>
                    <p><a href="<?php echo HTTP_ROOT.'members/select_type/7';?>"></a></p>
                </div>
            </div>
            <div class="loginDespInner">
            	<div class="loginDespPic">
                	<?php echo $html->image("frontend/login2.png")?>
                </div>
                <div class="loginDespRgt">
                	<h3><?php echo $html->image("frontend/student-txt.png")?></h3>
                    <p><a href="<?php echo HTTP_ROOT.'members/select_type/8';?>"></a></p>
                </div>
            </div>
            <div class="loginDespInner">
            	<div class="loginDespPic">
                	<?php echo $html->image("frontend/login3.png")?>
                </div>
                <div class="loginDespRgt">
                	<h3><?php echo $html->image("frontend/cause-txt.png")?></h3>
                    <p><a href="<?php echo HTTP_ROOT.'members/select_type/6';?>"></a></p>
                </div>
            </div>
            <?php /*?><div class="loginDespInner">
            	<div class="loginDespPic">
                	<?php echo $html->image("frontend/login3.png")?>
                </div>
                <div class="loginDespRgt">
                	<h3><?php echo $html->image("frontend/cause-txt.png")?></h3>
                    <p><a href="<?php echo HTTP_ROOT.'members/select_type/9';?>"></a></p>
                </div>
            </div><?php */?>
        </div> <!--loginDespOutr-->
    </div> <!--loginLeftSide-->
    
    	<?php echo $form->create('Member',array('class' => 'middle-forms',"id"=>"MemberLogin",'url' => '/homes/login')); ?>
         
    
    <div class="LoginFldsOuter">
    	<h3>Login to your account</h3>
        
        
        <div class="logFldCont">
            <label for="frontendUser" style="width:auto;">Email Address :</label>
            <input type="text" name="data[Member][username]" id="frontendUser" value="" class="required" />
            
        </div>
        <div class="logFldCont">
            <label for="frontPass">Password :</label>
            <input type="password" value="" id="frontPass" name="data[Member][pwd]" class="required" />
        </div>
        <div class="rememberMe">
        	<input type="checkbox" name="data[Member][remember]" value="1"/><label>Remember me</label>
        </div>
        <div id="frontendloginAlert" class="frontendloginAlert" style="color: #DD4B39; display: none; line-height: 17px; margin: 0.5em 0 0; clear:both;"></div>
        
        
        
        <div class=" loginButtonOuter button">
        	<span></span>
            <input type="submit" value="Login"/>
        </div>
        <div class="forgotPasswrd"><a href="<?php echo HTTP_ROOT.'homes/forget_password';?>">Forgot Password?</a><span>|</span><a href="<?php echo HTTP_ROOT.'members/select_type';?>">Sign Up</a></div>
    </div>
    
    
    <?php echo $this->Form->end(); ?>
                
    
    
    
</div>