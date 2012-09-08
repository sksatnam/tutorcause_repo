<?php
/*echo '<pre>';
print_r($memberData);
die;
*/
?>
<script type="text/javascript">
			$(document).ready(function(){
				  $("#paymentChoose").change(function () {
					if($("#paymentChoose").val()=='Mailed Check')
					{
						//alert('hi');	
						$("#paypalLink").hide();
						$("#mailAddress").slideDown();
						$("#mailAdd").addClass("required");	
						$("#paypalmail").removeClass("required");	
					}
					else
					{
						//alert('hi');
						$("#mailAdd").removeClass("required");
						$("#paypalmail").addClass("required");	
					}
					  });
					});
</script>
<style type="text/css">
/*
.stepFormRow
{
	width:897px;;
}
.error{
	padding-left:269px;
	}
.stepFormRow label
{
	width:210px;
}
*/
</style>



<div id="content-wrap" >
            	
			<?php  echo $this->Session->flash();?>
           
            <h1>Edit Payment Detail</h1>
                    
           
           <div id="tutor-wrap">      
           
           		 <?php echo $this->Form->create('Member', array('id' => 'tutorPaypal' , 'action' => 'tutor_paypal_detial' )); ?>
                 
                 <input type="hidden" name="data[edit][profile]" value="<?php
				 if(isset($profile) && $profile!='')
				 {
				    echo $profile;	 
				 }
				 ?>" />
             
                <div class="stepForm">
                	<div class="stepFormRow">
                    	<label><b>Payment:<span class="red" >*</span></b></label>   
                        <select id="paymentChoose" class="selectStepFrm" name="data[Member][payment]">
                            <option value="">Please select</option>
                        	<option value="Paypal" 
                            <?php if($memberData['Member']['paypalEmail'])
							echo 'selected=\"selected\"';?>
						    >Paypal</option>
                        	<option value="Mailed Check"
                            <?php if($memberData['Member']['mailedCheck'])
							echo 'selected=\"selected\"';?>
                             >Mailed Check</option>
                        </select>
                    </div>

                    <div id="paypalLink" class="stepFormRow">
                    	<label><b>Paypal Email:<span class="red" >*</span></b></label> 
                        <input class="textInStepFrm" type="text" name="data[Member][paypalEmail]" id="paypalmail" class="required email" value="<?php echo $memberData['Member']['paypalEmail']; ?>" maxlength="75" /> 
                    </div>
                    <div id="mailAddress" class="stepFormRow">
                    	<label><b>Mail Address:<span class="red" >*</span></b></label> 
                        <textarea class="textInStepFrm" name="data[Member][mailedCheck]" id="mailAdd"><?php echo $memberData['Member']['mailedCheck']; ?></textarea>
                        <span class="error" htmlfor="mailAdd" generated="true" style="margin-left: 269px;"></span>
                    </div>
                	<div class="stepFormRow">
                    	<label><b>Payment Frequency:<span class="red" >*</span></b></label>
                        <select class="selectStepFrm" name="data[Member][paymentFrequency]">
                            <option value="">Please select</option> 
                        	<option value="Bi-Monthly" 
                            <?php if($memberData['Member']['paymentFrequency']=='Bi-Monthly')
							echo 'selected=\"selected\"';?> >Bi-Monthly</option>
                            <option value="Monthly"
                            <?php if($memberData['Member']['paymentFrequency']=='Monthly')
							echo 'selected=\"selected\"';?> >Monthly</option>
                        	<option value="Once/Semester" 
                            <?php if($memberData['Member']['paymentFrequency']=='Once/Semester')
							echo 'selected=\"selected\"';?> >Once/Semester</option>
                        	<option value="Annually"
                            <?php if($memberData['Member']['paymentFrequency']=='Annually')
							echo 'selected=\"selected\"';?> >Annually</option>
                        </select>
                    </div>
                    
                      <div class="stepFormContButton button" style="margin:0px 0px 0px 440px;">
                    	<span></span>
                    	<input type="submit" value="Submit" /> 
                        </div>
                   
                   
                </div>
                
                <?php echo $this->Form->end(); ?>
             
  
      
            </div>                   
            
 </div>
 <?php //3aug2012 ?>