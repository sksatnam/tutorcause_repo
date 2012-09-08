<?php
$checked = "";$checked2="";
if(count($schools)>0){
	$checked2 = "checked";
} else { $checked="checked";
}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#schoolid option').click(function(){
		$("#optional").attr('checked','checked');
		$("#all").removeAttr('checked');
	})
	$("input[name='data[CauseSchool][check]']").click(function(){
		if($("input[name='data[CauseSchool][check]']:checked").val() == 'all'){
			$('#schoolid option').removeAttr('selected');
			$('#schoolid option').removeProp('selected');
			$('#schoolid').attr('disabled','disabled');
		} else {
			$('#schoolid').removeAttr('disabled');
		}
	})
});
function checkOptions(){
	if ($("input[name='data[CauseSchool][check]']:checked").val() == 'all') {
		return true;
	}
	else {
		if($('#schoolid').val() == null){
			alert('Please select school');
			return false;
		}
		return true;
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
            
				<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Edit User</h4>
				<div id="userAddPanel" style="float:left; width:735px;">
				
                 <?php echo $form->create('member', array('action' => 'edit_non_profit_schoolinfo','admin'=> true, 'onSubmit'=>'return checkOptions();')); ?>
                	 
                    <input type="hidden" name="data[Member][id]" value="<?php echo $admindata['Member']['id']; ?>"   />
                     <input type="hidden" name= "data[Member][group_id]" value="<?php echo $admindata['Group']['id'];?>"  />
   
                        
					<div class="paddinSet">
                        <fieldset style="margin:0px; float:left;">
						    <legend>User Status</legend>
                            <div class="innerContainerInsideFieldset">
                                    <?php
                                       if($admindata['Member']['group_id']==6 || $admindata['Member']['group_id']==7 || $admindata['Member']['group_id']==8)
								{
									
								?>
                                
                                 <div class="fieldContainerByDpkMahendru">
                                    <label for="UserGroup" class="field-title dpkLab20">User Type : </label>
                                  	 <input id="MemberGroupId" type="text" style="width: 200px;" readonly="readonly"   value="<?php echo $admindata['Group']['name']; ?>">
                                    
                                
                                    
									  <?php /*?><select name="data[Member][group_id]" class="required" id="MemberGroupId">
                                                <option value=""></option>
                                                <option value="1" <?php
                                                if($admindata['Member']['group_id']==1)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                                ?> > Executive </option>
                                                <option value="3" <?php
                                                if($admindata['Member']['group_id']==3)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                                ?> > System Administrator </option>
                                                <option value="4" <?php
                                                if($admindata['Member']['group_id']==4)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                                ?> > School Administrator </option>
                                                <option value="6" <?php
                                                if($admindata['Member']['group_id']==6)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                                ?> > Cause </option>
                                                
                                                <option value="7" <?php
                                                if($admindata['Member']['group_id']==7)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                                ?> > Tutor </option>
                                                
                                                <option value="8" <?php
                                                if($admindata['Member']['group_id']==8)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                                ?> > Student </option>
                                                
                                                </select>                         
                            <?php */?>
                                </div>
                                <br/>
                                <br/>
                                
                                
                                <div class="fieldContainerByDpkMahendru">
                    			<div style="margin-left:105px; float:left" ><input type="radio"  name="data[CauseSchool][check]" id="all" value="all" <?php echo $checked; ?> /></div>
                              
                        		<div style="float:left; padding-left:80px"><label><h1><b>All Schools</b></h1></label></div>
                    			</div>
                   	 <div class="fieldContainerByDpkMahendru" style="padding-left:80px">
                        <label><b>OR</b></label>                    
                   	 </div>
                   
                        <div class="fieldContainerByDpkMahendru">
                        <div style="margin-left:105px; float:left">
                        <input type="radio"  name="data[CauseSchool][check]" id="optional" value="optional" <?php echo $checked2;?> />
                       </div>
                       <div style="float:left; padding-right:75px">
                       <label><b>Multiple Schools</b></label>
                       </div>
                        </div>
                         <div class="fieldContainerByDpkMahendru" style="margin-left:50px">
                    	<label style="font-size:12px; float:left; width:300px; padding-left:23px;"> (Press Ctrl key to select multiple schools)</label>
                    	
                        </div>
                       <br/>
                       <br/>
                       <div class="fieldContainerByDpkMahendru">
                       <div style="margin-left:105px;">
                        <select multiple="multiple" size="5" name="data[CauseSchool][school_id][]" id="schoolid">
                        <?php foreach($schoolname as $key=>$value){ ?>
				<option value="<?php echo $key;?>" <?php if(in_array($key,$schools)){ echo "selected"; } ?>><?php echo $value;?></option>
			<?php } ?>
                        </select>
                        </div>
                   		 </div>
                           <?php
							}
							?>
                       
                    
                                <div class="fieldContainerByDpkMahendru">
                                    
                                    <label for="UserStatus" class="field-title dpkLab20">User Status : </label>
                                    
                                    <select name="data[Member][status]" style="width:150px";>
                                    <option value="0" <?php  
									if(isset($admindata['Member']['active'])){
										echo ($admindata['Member']['active']=="0")?'selected="selected"':'';
									}
									?>>Un-Active</option>
                                    <option value="1"  <?php  
									if(isset($admindata['Member']['active'])){
										echo ($admindata['Member']['active']=="1")?'selected="selected"':'';
									}
									?>>Active</option>
                                    <option value="4"  <?php  
									if(isset($admindata['Member']['active'])){
										echo ($admindata['Member']['active']=="4")?'selected="selected"':'';
									}
									?>>Trash</option>
                                    <option value="2"  <?php  
									if(isset($admindata['Member']['active'])){
										echo ($admindata['Member']['active']=="2")?'selected="selected"':'';
									}
									?>>Blocked</option>
                                    <option value="3"  <?php  
									if(isset($admindata['Member']['active'])){
										echo ($admindata['Member']['active']=="3")?'selected="selected"':'';
									}
									?>>Deleted</option>
                                    </select>
                                    
									<?php /*?><input type="radio" name="data[Member][status]" id="MemberStatus1" value="1" 
                                    <?php
									if($admindata['Member']['active']==1)
									{
										echo "checked=\"checked\"";
									}
									?>
                                    /> Active 
                                    
                                    <input type="radio" name="data[Member][status]" id="MemberStatus0" value="0"
                                    <?php
									if($admindata['Member']['active']==0)
									{
										echo "checked=\"checked\"";
									}
									?>  /> Deactive                               <?php */?>
                                    
                                </div>
							    
							</div>
                            </fieldset>
                  	</div>
                    
			
                    <div class="paddinSet">
						   <fieldset style="margin:0px; float:left;" id="personal-info">
                            <legend>Personal Info</legend>
                            <div class="innerContainerInsideFieldset">
                            
                            
                            <label class="dpkLab" for="UserFirstname" class="field-title">Email : </label><?php echo $form->input('Member.email',array('label'=>'','div' => '','class'=>'required','value'=>$admindata['Member']['email'])); ?><br /><br />
                            
                            
                            
                                <label class="dpkLab" for="UserFirstname" class="field-title">First Name : </label><?php echo $form->input('userMeta.fname',array('label'=>'','div' => '','class'=>'required','value'=>$admindata['userMeta']['fname'])); ?><br /><br />
                                <label class="dpkLab" for="UserLastname" class="field-title">Last Name :</label><?php echo $form->input('userMeta.lname',array('label'=>'','div' => '','class'=>'required','value'=>$admindata['userMeta']['lname'])); ?><br /><br />
                                
                                <label class="dpkLab" for="UserPhone" class="dpkLab20">Phone :</label><?php echo $form->input('userMeta.contact',array('label'=>'','div' => '','maxlength'=>'14','class'=>'number required','value'=>$admindata['userMeta']['contact'])); ?><br /><br />
                                
                                <label class="dpkLab" for="UserAddress1" class="field-title">Street Address : </label><?php echo $form->input('userMeta.address',array('label'=>'','div' => '','class'=>'required','value'=>$admindata['userMeta']['address'])); ?><br /><br />
                               
                                <label for="UserCity" class="dpkLab">City :</label><?php echo $form->input('userMeta.city',array('label'=>false,'id'=>'UserCity','class'=>'required','value'=>$admindata['userMeta']['city'])); ?><?php //echo $form->select('userMeta.city',array(''=>'Select City'),$this->data['userMeta']['city'],array('id' =>'UserCity'),false); ?>
                                                                                          <br />
                                                                                          
                                 <label for="UserState" class="dpkLab">State : </label>  
                                 
                                 
                                 <select name="data[userMeta][state]" class="required" >
                                 <option value="" >Select State</option>

								<?php
                                foreach ( $states as $key => $val ) {
									if($admindata['userMeta']['state']==$val)
									{
								  		echo  "<option value=\"$val\" selected=\"selected\">$val</option>";
									}
									else
									{
										echo  "<option value=\"$val\">$val</option>";
									}
								}	
                                ?>
                                </select>  <br />  <br />
                                
                                <label class="dpkLab" for="UserZipcode" class="dpkLab20">Zip Code :</label><?php echo $form->input('userMeta.zip',array('label'=>'','div' => 'entryField','numeric'=>'integer','class'=>'number required','maxlength'=>'10','value'=>$admindata['userMeta']['zip'])); ?><?php // echo $form->input('Member.zipcode',array('label'=>'','div' => '','numeric'=>'integer','class'=>'zipcode','maxlength'=>'10')); ?><br /><br />
                                
                                
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