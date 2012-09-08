<?php //3aug2012 ?><div class="forgetPasswordCont">

<?php	echo $this->Session->flash(); ?>


	<h2>Forgotten your password?</h2>
    <div class="forgotText">To reset your password, type the full email address in the textbox below:</div>
    
    
    <?php echo $form->create('Member',array("id"=>"MemberForgetPassword",'url' => '/homes/forget_password')); ?>
    
    
    <div class="forgotEmailOutr">
    	<label>Email Address:</label>
        <input type="text" name="data[Member][email]" value="" class="required email"/>
    </div>
    <div class="forgotPasswrdButton button">
          <span></span>
          <input type="submit" value="Submit"/>
      </div>
      
      <?php echo $this->Form->end(); ?> 
      
      
</div>