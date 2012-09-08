<?php //pr($this->data);?>
<div id="content">
	<div id="content-top">
    	<h2>Payments</h2>
       <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	<div id="mid-col">    	
		<div class="box">
        <?
      //  echo '<pre>';
		//print_r($_SESSION);
		?>
        
       
        
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Twiddla Api</h4>
			<div id="userAddPanel" style="min-height:520px;">
            
             <div id="flashmsg" style="float:left; padding-left:10px; padding-bottom:10px;"><b><?php echo $this->Session->flash(); ?></b></div><br />
            
						
                
                <?php echo $form->create('PaymentHistory',array('id'=>'twiddla' , "url" => $html->url(array('action'=>'twiddla',"admin" => true), true)));	?>
			     
				<div class="paddinSet">
					<fieldset id="personal-info">
						<legend>Twiddla Api Info.</legend>
						<div class="innerContainerInsideFieldset">
							<label class="dpkLab" for="Useremail" class="field-title">Twiddla Username : </label>
							<?php echo $form->input('Api.username',array('class'=>'required','label'=>'','div' => '','value' => $apis['Api']['username'])); ?><br /><br />
							<label class="dpkLab" for="UserPassword" class="field-title">Password :</label>
							<?php echo $form->input('Api.pwd',array('label'=>'','div' => '','id'=>'Password1' , 'type' => 'password')); ?><br /><br />
							<label class="dpkLab" for="UserConfirmPassword" class="field-title">Confirm Password : </label>
							<?php echo $form->input('Api.cPassword',array('label'=>'','div' => '','type' =>'password','id'=>'cpassword')); ?><br /><br />
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