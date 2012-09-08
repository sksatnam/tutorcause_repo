<?php //3aug2012 ?><div class="forgetPasswordCont">

<?php	echo $this->Session->flash(); ?>

	<h2>Change your password?</h2>
 <!--   <div class="forgotText">To change your password :</div>-->
    
    
    <?php echo $form->create('Member',array("id"=>"MemberNewPassword",'url' => '/homes/new_password')); ?>
    
    
    <input type="hidden" name="data[Member][id]" value="<?php echo $memberid;?>"  />
    <input type="hidden" name="data[Member][email]" value="<?php echo $md5email;?>"  />
    
    
    <div class="forgotEmailOutr">
    	<label>Password:</label>
        <input type="password" name="data[Member][pwd]" id="userPassword" value="" class="required"/>
    </div>
    
    
    <div class="forgotEmailOutr">
    	<label>Confirm Password:</label>
        <input type="password" name="data[Member][cPassword]" value="" class="required"/>
    </div>
    
    <div class="forgotPasswrdButton button">
          <span></span>
          <input type="submit" value="Submit"/>
      </div>
      
      <?php echo $this->Form->end(); ?> 
      
      
</div>