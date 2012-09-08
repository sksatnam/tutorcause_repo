<?php
/*echo '<pre>';
print_r($tutorcausefee);
die;
*/?>
<div id="content">
	<div id="content-top">
    	<h2>Payments
  </h2>
       <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	<div id="mid-col">    	
		<div class="box">
        <?
      //  echo '<pre>';
		//print_r($_SESSION);
		?>
        
       
        
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">TutorCause fee</h4>
			<div id="userAddPanel" style="min-height:520px;">
            
             <div id="flashmsg" style="float:left; padding-left:10px; padding-bottom:10px;"><b><?php echo $this->Session->flash(); ?></b></div><br />
            
						
                <?php echo $form->create('PaymentHistory',array('id'=>'tutorcausefee' , "url" => $html->url(array('action'=>'charges',"admin" => true), true)));
				
				$fees = $tutorcausefee['Charge']['tutorcause_charge'];
				?>
                 
				<div class="paddinSet">
					<fieldset id="personal-info">
						<legend>TutorCause fee</legend>
						<div class="innerContainerInsideFieldset">
							<label class="dpkLab" for="charges" class="field-title">Charges % : </label><?php 
							echo $form->input('Charge.tutorcause_charge',array('label'=>'','div' => '','value' => $fees )); ?><br /><br />						
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