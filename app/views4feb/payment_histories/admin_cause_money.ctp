<script type="text/javascript">
function paypalsubmit()
{
	
	var selectVal = $('#withdrawalstatus :selected').val();
	
	var causeemail = $('#causepayemail').val();
	
	var causenotes = $('#causenotes').val();
	
	
	if (selectVal == "Approved"){
		
	
	if(causeemail!='')
	{
	  	document.forms["payPalForm"].submit(); 	
	}
	else
	{
		alert('Tutor Paypal email id not available.');	
	    return false;	
	}
	
	}
	else if(selectVal == "Cancelled"){
	
		document.forms["approveCauseWithdrawal"].submit();
	
	}
	
	return false;	
}
</script>


<div id="content">
	<div id="content-top">
    <h2>Payment</h2>
      
      <span class="clearFix">&nbsp;</span>
      </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	  	<div id="mid-col">    	
			<div class="box">
				<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Cause withdrawal</h4>
				<div id="userAddPanel" style="float:left; width:735px;">
                    
                    <?php
					if($causedata['CauseWithdrawal']['status']=='Pending')
					{
					?>
                    
                    <div class="paddinSet">
                    
                         <?php echo $form->create('payment_histories', array('action' => 'approve_cause_withdrawal','admin'=> true,'id'=>'approveCauseWithdrawal')); ?>
                         
                        <input type="hidden" name="data[CauseWithdrawal][id]" value="<?php echo $withdrawalid;?>"  />
                        <input type="hidden" name="data[Member][creditable_balance]" value="<?php
						$memberbalance = $causedata['CauseWithdrawal']['cause_creditable_amount'] + $causedata['Member']['creditable_balance'];
						echo $memberbalance;  ?>" />
                        <input type="hidden" name="data[Member][id]" value="<?php echo $causedata['CauseWithdrawal']['cause_id'];?>" />
                        
                        
                        
                    
					<fieldset id="personal-info">
						<legend>Approve Cause Request</legend>
						<div class="innerContainerInsideFieldset">
                        
                           <label class="dpkLab" for="Name" class="field-title">Cause Name : </label>
                         
                         <?php
                         $causename =  $causedata['Member']['userMeta']['cause_name'];
						 ?>
                          
                          <input type="text" name="name" readonly="readonly" value="<?php echo $causename ?>" />
                           <br /><br />
                           
                          <label class="dpkLab" for="Email" class="field-title">Cause Paypal Email : </label>
                          
                          <input type="text" name="email" readonly="readonly"  id="causepayemail" value="<?php  echo $causedata['Member']['paypalEmail'];?>" />
                           <br /><br />
                        
                        
                        
                          <label class="dpkLab" for="Useremail" class="field-title">Notes : </label>
                          
                          <input type="text" name="data[CauseWithdrawal][notes]" id="causenotes" />
                           <br /><br />
                         
							<label class="dpkLab" for="Useremail" class="field-title">Status : </label>
                            <select name="data[CauseWithdrawal][status]" id="withdrawalstatus" >
                            <option value="Approved">Approved</option>
                            <option value="Cancelled">Cancelled</option>
                            </select>
                            <br /><br />
						
						</div>
					</fieldset>
					<div id="submit-buttons" style="padding-top:10px;">
                    
				    <input type="button" value="Submit" onclick="javascript: paypalsubmit();" />
                    
					<?php echo $this->Form->end(); ?>
					</div>
                    
                    
                    <form action="<?php echo PAYPALURL;?>" method="post" id="payPalForm">
           
           <input type="hidden" name="paypaltutornotes" id="paypaltutornotes" value=""  />
				<input type="hidden" name="cmd" value="_xclick" />
                <input type="hidden" name="cpp_header_image" value="<?php echo HTTP_ROOT;?>app/webroot/img/frontend/tutor_cause.png" ?>"			<input type="hidden" name="item_name" value="Cause Money">
				<input type="hidden" name="no_note" value="1" />
				<input type="hidden" name="business" value="<?php echo $causedata['Member']['paypalEmail'];?>" />
				<input type="hidden" name="currency_code" value="USD" />
				<input name="amount" type="hidden" id="amount" size="45" value="<?php echo $causedata['CauseWithdrawal']['cause_creditable_amount'];?>" />
				<?php
					$url = HTTP_ROOT.'members/paypal_cause/'.$withdrawalid;
				?>
				<input type="hidden" name="notify_url" value="<?php echo $url;?>" />
				<input type="hidden" name="return" value="<?php echo HTTP_ROOT?>admin/homes/success" />
				<input type="hidden" name="cancel_return" value="<?php echo HTTP_ROOT?>admin/homes/failure" />			
			</form>
            
            
                    
                    
                    
                    
                    
				</div>
                
                    <?php 
					}
					?>
                    
                    

                    
                 	</div>
				</div>
			</div>

		</div><!-- end of div#mid-col -->
      
      <span class="clearFix">&nbsp;</span>     
</div>