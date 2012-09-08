<?php
/*echo '<pre>';
print_r($memberData);
die;
*/
?>
<script type="text/javascript">
	$(document).ready(function(){
					if($("#paymentChoose").val()=='Mailed Check')
					{
						$("#paypalLink").hide();
						$("#mailAddress").slideDown();
						$("#mailAdd").addClass("required");	
					}
					else
					{
						$("#mailAdd").removeClass("required");
					}
					  });
</script>
<style type="text/css">
/*.error{
	padding-left:269px;
	}
*/
.stepFormRow
{
	width:900px;
}
/*.stepFormRow label
{
	width:210px;
}
*/</style>

<div id="content">


            	<div class="stepsHeadingNew">
                
<?php
if(!isset($profile))
{
?>
    <div class="newProgressBarOuter">
        <div class="proBarsSection1">
            <span class="spanNo">1</span>
            <span class="spanOnHover">Registration</span>

        </div>
        <div class="proBarsSection2">
            <span class="spanNo">2</span>
            <span class="spanOnHover">Tutor Payment</span>
        </div>
        <div class="proBarsSection3">
            <span class="spanNo">3</span>
            <span class="spanOnHover">Set Availablity</span>

        </div>
        <div class="proBarsSection3">
            <span class="spanNo">4</span>
            <span class="spanOnHover">Add Courses</span>
        </div>
    </div>
    
     <h1>Tutor Payment Info</h1>
<?php
}
else if(isset($profile) && $profile=='edit')
{
	    echo '<h1>Edit Payment Detail</h1>';
}
?>
                   
                </div>
                
                 
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
            
            