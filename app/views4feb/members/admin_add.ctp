<script type="text/javascript">
	$(document).ready(function(){
							$("#schoolname").hide();
					  });
	function schooladmin()
	{
		 var x = document.getElementById('group').value;
		 
		 if(x==4)
		 {
			 $("#schoolname").show();
			 $("#chooseschool").addClass("required");
		 }
		 else
		 {
			 $("#schoolname").hide();
			 $("#chooseschool").removeClass("required");
		 }
}
	
	
</script>


<div id="content">
	<div id="content-top">
    <h2>Users</h2>
      
      <span class="clearFix">&nbsp;</span>
      </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	  	<div id="mid-col">    	
			<div class="box">
				<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Add User</h4>
				<div id="userAddPanel" style="float:left; width:735px;">
				
                <div style="padding-left:30px;" id="flashmsg"><b><?php echo $session->flash();?></b></div>
                
                		
                        <?php echo $form->create('Member',array('class' => 'middle-forms',"id"=>"UserAddForm","url" => $html->url(array("admin" => true), true))); ?>
                        
					<div class="paddinSet">
                        <fieldset style="margin:0px; float:left;">
						    <legend>User Status</legend>
                            <div class="innerContainerInsideFieldset">
                                <div class="fieldContainerByDpkMahendru">
                                    <label for="UserGroup" class="field-title dpkLab20" >User Type : </label>
                                    <select name="data[Member][group_id]" id="group" onchange="schooladmin();">
                                    
                                    <option value="">Select User Type</option>
                                    <option value="1">Executive</option>
                                    <option value="2">Billing Administrator</option>
                                    <option value="3">System Administrator</option>
                                    <option value="4">School Administrator</option>
                                    <option value="5">Cause Administrator</option>
                                    </select>
                                      </div>
                                      </div>
                     
								
                                 <div class="fieldContainerByDpkMahendru" >
                            	 <div id="schoolname">                                                      
                                 <label for="SchoolName" class="dpkLab">School Name : </label>
								 <select name="data[Member][school_id]" id="chooseschool" style="width:285px;">
                                 <option value="">Select School</option>
								 <?php
									foreach ( $schoolname as $key => $val ) {
									  echo  "<option value=\"$key\">$val</option>";
									}	
                                 ?>
                                 </select>
                                </div>
                                
                                <!--<div class="fieldContainerByDpkMahendru">
                                    <label for="UserStatus" class="field-title dpkLab20">User Status : </label>
                                    <select name="data[Member][status]" style="width:150px";>
                                    <option value="0">Un-Active</option>
                                    <option value="1">Active</option>
                                    <option value="2">Blocked</option>
                                    <option value="3">Deleted</option>
                                    </select>
                                </div>-->
							    
							</div>
                            </fieldset>
                  	</div>
                    
                    
                    <div class="paddinSet">
                     	<fieldset style="margin:0px; float:left;">
                            <legend>Account Info</legend>
                            <div class="innerContainerInsideFieldset">
                                <label class="dpkLab" for="UserEmail" class="field-title"> Email : </label><?php echo $form->input('Member.email',array('label'=>'','div' => '','class'=>'required email')); ?><br /><br />
                                <label class="dpkLab" for="UserPassword" class="field-title"> Password : </label><?php echo $form->input('Member.pwd',array('label'=>'','div' => '','class'=>'required','type' => 'password')); ?><br /><br />
                                <label class="dpkLab" for="UserCPassword" class="field-title"> Confirm Password : </label><?php echo $form->input('Member.cPassword',array('type'=>'password','label'=>'','div' => '')); ?><br /><br />
                   			</div>
                        </fieldset>
                            
                    </div>
                    
			
                    <div class="paddinSet">
						   <fieldset style="margin:0px; float:left;" id="personal-info">
                            <legend>Personal Info</legend>
                            <div class="innerContainerInsideFieldset">
                                <label class="dpkLab" for="UserFirstname" class="field-title">First Name : </label><?php echo $form->input('userMeta.fname',array('label'=>'','div' => '','class'=>'required')); ?><br /><br />
                                
                                <label class="dpkLab" for="UserLastname" class="field-title">Last Name :</label><?php echo $form->input('userMeta.lname',array('label'=>'','div' => '','class'=>'required')); ?><br /><br />
                                
                                <label class="dpkLab" for="UserPhone" class="dpkLab20">Phone :</label><?php echo $form->input('userMeta.contact',array('label'=>'','div' => '','maxlength'=>'14','class'=>'number required')); ?><br /><br />
                                
                                <label class="dpkLab" for="UserAddress1" class="field-title">Street Address : </label><?php echo $form->input('userMeta.address',array('label'=>'','div' => '','class'=>'required')); ?><br /><br />
                               
                                <label for="UserCity" class="dpkLab">City :</label><?php echo $form->input('userMeta.city',array('label'=>false,'id'=>'UserCity','class'=>'required')); ?><?php //echo $form->select('userMeta.city',array(''=>'Select City'),$this->data['userMeta']['city'],array('id' =>'UserCity'),false); ?>
                                                                                          <br />
                                                                                          
                                 <label for="UserState" class="dpkLab">State : </label>
								 <select name="data[userMeta][state]" class="required">
                                 <option value="">Select State</option>

								<?php
                                foreach ( $states as $key => $val ) {
								  echo  "<option value=\"$val\">$val</option>";
								}	
                                ?>
                                </select>
	                                 <br /><br />
                             
                                <label class="dpkLab" for="UserZipcode" class="dpkLab20">Zip Code :</label><?php echo $form->input('userMeta.zip',array('label'=>'','div' => 'entryField','numeric'=>'integer','class'=>'number required','maxlength'=>'10')); ?><?php // echo $form->input('Member.zipcode',array('label'=>'','div' => '','numeric'=>'integer','class'=>'zipcode','maxlength'=>'10')); ?><br /><br />
                             
                       		</div>
                        </fieldset>
                            <div id="submit-buttons">
                                <?php  echo $form->submit('Save',array('div' => false)); ?>
                                <input type="reset" value="Reset" />
                            </div>
                            <?php echo $form->end(); ?>
                     	</div>

                    
                 	</div>
				</div>
			</div>

		</div><!-- end of div#mid-col -->
      
      <span class="clearFix">&nbsp;</span>     
</div>