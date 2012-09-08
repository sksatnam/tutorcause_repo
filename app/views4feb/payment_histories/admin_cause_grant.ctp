<?php
/*echo '<pre>';
print_r($causedata);
echo 'tutordata';
print_r($tutordata);
die;
*/
?>


<script type="text/javascript">
function paypalsubmit()
{
	
	var selectVal = $('#withdrawalstatus :selected').val();
	
	var tutoremail = $('#tutorpayemail').val();
	
	var tutornotes = $('#tutornotes').val();
	
	
	if (selectVal == "Approved"){
		
	
	if(tutoremail!='')
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
	
		document.forms["approveTutorWithdrawal"].submit();
	
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
				<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Tutor withdrawal</h4>
				<div id="userAddPanel" style="float:left; width:735px;">
                
                
                <table class="table-filter" style="border-bottom-width:1px; width:100%; float:left;" border="0">
						<tr class="" style="height:10px;background-color:#B3BBC2">
								<td style="text-align:left; font-size:13px; padding-bottom:10px;" class="col-chk2"><b>Tutor</b></td>	<td></td>
								<td></td>
								<td></td>
                               	<td></td>
                                <td></td>
							
						</tr>	
						<tr class="" style="background-color:#E6E6E6;">
							<td class="col-chk2"><b>Tutor Name</b></td>
							<td class="col-chk2"><b>Tutor Email</b></td>
							<td class="col-chk2"><b>Request id</b></td>
                            <td class="col-chk2"><b>Creditable Balance</b></td>
                            <td class="col-chk2"><b>Tutor Cause Charge
                            <span style="color:#00F">
                            ( <?php $fees = $tutorcausefee['Charge']['tutorcause_charge'];
							 echo  $fees.' %';?> )</span></b></td>
                            <td class="col-chk2"><b>Amount</b></td>
						
						</tr>
					
                        <tr class="">
							<td class="col-chk2"><b><?php echo $tutordata['Member']['userMeta']['fname'].' '.$tutordata['Member']['userMeta']['lname'];?></b></td>
							<td class="col-chk2"><b><?php echo $tutordata['Member']['email'];?></b></td>
							<td class="col-chk2"><b><?php echo $tutordata['TutorWithdrawal']['request_id'];?></b></td>
							<td class="col-chk2"><b><?php echo '$ '.$tutordata['TutorWithdrawal']['tutor_creditable_amount'];?></b></td>
                            <td class="col-chk2"><b><?php 
							$charge = $tutordata['TutorWithdrawal']['tutor_creditable_amount']/100;
							
							$charge = $charge * $fees;
							$charge = sprintf("%.2f", $charge );
							echo '$ '.$charge;?></b></td>
                            <td class="col-chk2"><b><?php 
							$amount = $tutordata['TutorWithdrawal']['tutor_creditable_amount'] - $charge;
							$amount = sprintf("%.2f", $amount );
							echo '$ '.$amount;
							$paypalamount = $amount;
							?></b></td>
                            
						</tr>
                    	
						</tr>
					</table>
                
                
           <?php 
	       if(count($causedata)!=0)
           {
		   ?>	   
				
               <table class="table-filter" style="border-bottom-width:1px; width:100%; float:left;" border="0">
						<tr class="" style="height:10px;background-color:#B3BBC2">
								<td style="text-align:left; font-size:13px; padding-bottom:10px;" class="col-chk2"><b>Causes</b></td>
								<td></td>
								<td></td>
								<td></td>
							
						</tr>	
						<tr class="" style="background-color:#E6E6E6;">
							<td class="col-chk2"><b>Cause Name</b></td>
							<td class="col-chk2"><b>Cause Email</b></td>
							<td class="col-chk2"><b>Donation %</b></td>
							<td class="col-chk2"><b>Amount</b></td>
						
						</tr>
						
                        <?php 
						$causeamount = 0;
						foreach($causedata as $cd)
						{
						?>	
                        <tr class="">
							<td class="col-chk2"><b><?php echo $cd['Cause']['userMeta']['cause_name']?></b></td>
							<td class="col-chk2"><b><?php echo $cd['Cause']['email']?></b></td>
							<td class="col-chk2"><b><?php echo $cd['CauseTutor']['grant'].' %'?></b></td>
							<td class="col-chk2" style="font-size:12px; color: #C00;"><b><?php 
							$actualcausegrant =  $cd['CauseTutor']['grant']/100;
							$actualcause = $amount * $actualcausegrant;
							$causemoney = sprintf("%.2f", $actualcause );
							echo '$ '.$causemoney;
							?></b></td>
                       </tr>
                        <?php 
						$causeamount = $causemoney + $causeamount;
						$causeamount = sprintf("%.2f", $causeamount );
						}
						?>
                        
						
						<tr class="" style="background-color:#E6E6E6;">
							<td class="col-chk2"></td>
							<td class="col-chk2"></td>
							<td class="col-chk2"><b>Cause Total</b></td>
							<td class="col-chk2"><b><?php echo '$ '.$causeamount;?></b></td>
						
						</tr>
                        
                        <tr class="" style="background-color:#E6E6E6;">
                    	    <td class="col-chk2"></td>
							<td class="col-chk2"><b>Tutor Money</b></td>
							<td class="col-chk2"><b><?php echo '$ '.$amount.' - '.'$ '.$causeamount;?></b></td>
							<td class="col-chk2" style="font-size:12px; color: #C00;"><b><?php 
							$tutormoney = $amount - $causeamount;
							$tutormoney = sprintf("%.2f", $tutormoney );
							echo '$ '.$tutormoney;
							$paypalamount =  $tutormoney;
							?></b></td>
                            
						
						</tr>
                        
                        
					</table> 
                    <?php 
					   }
					?>
                    
                    
                    
                    <?php
					if($tutordata['TutorWithdrawal']['status']=='Pending')
					{
					?>
                    
                  
                  
                  
                    
                    <div class="paddinSet">
                    
                         <?php echo $form->create('payment_histories', array('action' => 'approve_tutor_withdrawal','admin'=> true,'id'=>'approveTutorWithdrawal')); ?>
                         
                         
                         
                        <input type="hidden" name="data[TutorWithdrawal][id]" value="<?php echo $withdrawalid;?>"  />
                        <input type="hidden" name="data[Member][creditable_balance]" value="<?php
						$memberbalance = $tutordata['TutorWithdrawal']['tutor_creditable_amount'] + $tutordata['Member']['creditable_balance'];
						echo $memberbalance;  ?>" />
                        <input type="hidden" name="data[Member][id]" value="<?php echo $tutordata['TutorWithdrawal']['tutor_id'];?>" />
                        
                    
					<fieldset id="personal-info">
						<legend>Approve Tutor Request</legend>
						<div class="innerContainerInsideFieldset">
                        
                        
                         <label class="dpkLab" for="Name" class="field-title">Tutor Name : </label>
                         
                         <?php
                         $tutorname =  $tutordata['Member']['userMeta']['fname']." ".$tutordata['Member']['userMeta']['lname'];
						 ?>
                          
                          <input type="text" name="name" readonly="readonly" value="<?php echo $tutorname ?>" />
                           <br /><br />
                           
                          <label class="dpkLab" for="Email" class="field-title">Tutor Paypal Email : </label>
                          
                          <input type="text" name="email" readonly="readonly"  id="tutorpayemail" value="<?php  echo $tutordata['Member']['paypalEmail'];?>" />
                           <br /><br />
                           
                        
                          <label class="dpkLab" for="Notes" class="field-title">Notes : </label>
                          
                          <input type="text" name="data[TutorWithdrawal][notes]" id="tutornotes" value="" />
                           <br /><br />
                         
                           
                         
							<label class="dpkLab" for="Useremail" class="field-title">Status : </label>
                            <select name="data[TutorWithdrawal][status]" id="withdrawalstatus">
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
				</div>
                
                
                
                        <div>
               <form action="<?php echo PAYPALURL;?>" method="post" id="payPalForm">
           
           <input type="hidden" name="paypaltutornotes" id="paypaltutornotes" value=""  />
				<input type="hidden" name="cmd" value="_xclick" />
                <input type="hidden" name="cpp_header_image" value="<?php echo HTTP_ROOT;?>app/webroot/img/frontend/tutor_cause.png" ?>"			<input type="hidden" name="item_name" value="Tutor Money">
				<input type="hidden" name="no_note" value="1" />
				<input type="hidden" name="business" value="<?php echo $tutordata['Member']['paypalEmail'];?>" />
				<input type="hidden" name="currency_code" value="USD" />
				<input name="amount" type="hidden" id="amount" size="45" value="<?php echo $paypalamount;?>" />
				<?php
					$url = HTTP_ROOT.'members/paypal_tutor/'.$withdrawalid;
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