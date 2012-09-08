<?php 
/*echo '<pre>';
pr($admindata);die;
*/
?>
<?php //3aug2012 ?>

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
                
                  <div style="padding-left:30px;" id="flashmsg"><b><?php echo $session->flash();?></b></div>
		           
                 
                <?php echo $form->create('Member',array('class' => 'middle-forms',"id"=>"MemberEditForm","url" => $html->url(array('action' => 'edit' , "admin" => true), true))); ?>
                 
                	 
                    <input type="hidden" name="data[Member][id]" value="<?php echo $admindata['Member']['id']; ?>"   />
                    <input type="hidden" name= "data[Member][group_id]" value="<?php echo $admindata['Group']['id'];?>"     />
                        
					<div class="paddinSet">
                        <fieldset style="margin:0px; float:left;">
						    <legend>User Status</legend>
                            <div class="innerContainerInsideFieldset">
                              <?php   if($admindata['Member']['group_id']==1 || $admindata['Member']['group_id']==2 || $admindata['Member']['group_id']==3 || $admindata['Member']['group_id']==4 || $admindata['Member']['group_id']==5   ) { ?>
                                <div class="fieldContainerByDpkMahendru">
                                    <label for="UserGroup" class="field-title dpkLab20">User Type : </label>
                                    
									  <select name="data[Member][group_id]" class="required" id="MemberGroupId">
                                                <option value=""></option>
                                                <option value="1" <?php
                                                if($admindata['Member']['group_id']==1)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                                ?> > Executive </option>
                                                 <option value="2" <?php
                                                 if($admindata['Member']['group_id']==2)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                                ?> > Billing Administrator </option>
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
                                                 <option value="5" <?php
                                                if($admindata['Member']['group_id']==5)
                                                {
                                                    echo "selected=\"selected\"";
                                                }
                                                ?> > Cause Administrator </option>
                                                <?php /*?><option value="6" <?php
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
                                                ?> > Student </option><?php */?>
                                                
                                                </select>                         
                            
                                </div>
                                 <?php }
								 else
								 {
								?>	
                                <label for="UserGroup" class="field-title dpkLab20">User Type : </label>
                                <input id="MemberGroupId" type="text" style="width: 200px;" readonly="readonly" value="<?php echo $admindata['Group']['name']; ?>"  />
								<?php	 
								}
								 ?>
                                
                                
                                 <div class="fieldContainerByDpkMahendru">
                                 

                                
                                  <?php   if($admindata['Member']['group_id']==4 || $admindata['Member']['group_id']==7 || $admindata['Member']['group_id']==8 ) { ?>
                                
                                <div class="fieldContainerByDpkMahendru" > 
                                
                                
                            	 <div id="schoolname">                                                      
                                  <label for="SchoolName" class="dpkLab">School Name : </label>
								 <select name="data[Member][school_id]" id="chooseschool" style="width:285px;">
                                 <option value=""  >Select School</option>
								<?php
                                foreach ( $schoolname as $key => $value ) {
									if($admindata['Member']['school_id']==$key)
									{
										echo "<option value=\"$key\" selected=\"selected\" >$value</option>";	
									}
									else
									{
										echo "<option value=\"$key\" >$value</option>";	
									}
								}
								?>
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
                                
                                <label class="dpkLab" for="UserPhone" class="dpkLab20">Phone :</label><?php echo $form->input('userMeta.contact',array('label'=>'','div' => '','maxlength'=>'14','value'=>$admindata['userMeta']['contact'])); ?><br /><br />
                                
                                <label class="dpkLab" for="UserAddress1" class="field-title">Street Address : </label><?php echo $form->input('userMeta.address',array('label'=>'','div' => '','class'=>'','value'=>$admindata['userMeta']['address'])); ?><br /><br />
                               
                                <label for="UserCity" class="dpkLab">City :</label><?php echo $form->input('userMeta.city',array('label'=>false,'id'=>'UserCity','class'=>'','value'=>$admindata['userMeta']['city'])); ?><?php //echo $form->select('userMeta.city',array(''=>'Select City'),$this->data['userMeta']['city'],array('id' =>'UserCity'),false); ?>
                                                                                          <br/>
                                                                                          
                              <?php
							    if($admindata['Member']['group_id']==8)
								{
									
								?>
                                <label for="UserCity" class="dpkLab">Note :</label><?php echo $form->input('userMeta.note',array('label'=>false,'id'=>'UserCity','class'=>'','value'=>$admindata['userMeta']['note'])); ?>
                            <br/>
                                
                                <label for="UserCity" class="dpkLab">Balance :</label><?php echo $form->input('Member.creditable_balance',array('label'=>false,'id'=>'UserCity','class'=>'number','value'=>$admindata['Member']['creditable_balance'])); ?>
                                 <br />
                                <?php
								}
								?>
                                
                                  <?php
							    if($admindata['Member']['group_id']==7)
								{
									
								?>
                                <label for="UserCity" class="dpkLab">Accrued Amount :</label><?php echo $form->input('Member.creditable_balance',array('label'=>false,'id'=>'UserCity','class'=>'number','readonly'=>'true','value'=>$admindata['Member']['balance'])); ?>
                            <br/>
                                
                                <label for="UserCity" class="dpkLab">Account Balance :</label><?php echo $form->input('Member.creditable_balance',array('label'=>false,'id'=>'UserCity','class'=>'number','readonly'=>'true','value'=>$admindata['Member']['creditable_balance'])); ?>
                                 <br />
                                <?php
								}
								?>
                                
                                
                                <label class="dpkLab" for="UserFirstname" class="field-title">Stripe Id : </label><?php echo $form->input('Member.stripeid',array('label'=>'','div' => '','class'=>'','value'=>$admindata['Member']['stripeid'])); ?><br /><br />
                                
                                
                                                                          
                                 <label for="UserState" class="dpkLab">State : </label>  
                                 
                                 
                                 <select name="data[userMeta][state]" class="" >
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
                                
                                <label class="dpkLab dpkLab20" for="UserZipcode">Zip Code :</label>
								<?php echo $form->input('userMeta.zip',array('label'=>'','div' => 'entryField','numeric'=>'integer','class'=>'','maxlength'=>'10','value'=>$admindata['userMeta']['zip'])); ?>
								<br /><br />
                              
                                
                                
                                
                       		</div>
                        </fieldset>
                            <div id="submit-buttons">
                                <?php   echo $form->submit('Save',array('div' => false)); ?>
                                <input type="reset" value="Reset" />
                            </div>
                          
                     	</div>

                    
                 	</div>
                    
                      <?php echo $form->end(); ?>
                    
				</div> <!--end of box-->
			</div> <!--end of midcol-->

		</div><!-- end of div#mid-col -->
        <span class="clearFix">&nbsp;</span>     