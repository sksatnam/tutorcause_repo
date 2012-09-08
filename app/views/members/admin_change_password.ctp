<?php //pr($this->data);?>
<div id="content">
	<div id="content-top">
    	<h2>Manage</h2>
       <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	<div id="mid-col">    	
		<div class="box">
    
       
        
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Change Password</h4>
			<div id="userAddPanel" style="min-height:520px;">
            
             <div id="flashmsg" style="float:left; padding-left:10px; padding-bottom:10px;"><b><?php echo $this->Session->flash(); ?></b></div><br />
            
						
                
                 <?php echo $form->create('member', array('action' => 'change_password','admin'=> true,'id'=>'ChangePasswordForm')); ?>
			     
				<div class="paddinSet">
					<fieldset id="personal-info">
						<legend>Change Info.</legend>
						<div class="innerContainerInsideFieldset">
							<label class="dpkLab" for="Useremail" class="field-title">Email : </label><?php echo $form->input('Member.email',array('label'=>'','readonly'=>'true','div' => '','value' => $session->read('Admin.email'))); ?><br /><br />
							<label class="dpkLab" for="UserPassword" class="field-title">Password :</label><?php echo $form->input('Member.pwd',array('label'=>'','div' => '','id'=>'AdminPassword1' , 'type' => 'password')); ?><br /><br />
							<label class="dpkLab" for="UserConfirmPassword" class="field-title">Confirm Password : </label><?php echo $form->input('Member.cPassword',array('label'=>'','div' => '','type' =>'password','id'=>'Admincpassword')); ?><br /><br />
						</div>
					</fieldset>
					<div id="submit-buttons" style="padding-top:10px;">
							<?php  echo $form->submit('Submit',array('div' => false)); ?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- end of div#mid-col -->
   <span class="clearFix">&nbsp;</span>     
</div>
<?php //3aug2012 ?>