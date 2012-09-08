<?php //3aug2012 ?><div id="content">
	<div id="content-top">
    <h2>Schools</h2>
      
      <span class="clearFix">&nbsp;</span>
      </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	  	<div id="mid-col">    	
			<div class="box">
				<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Edit Tutor</h4>
				<div id="userAddPanel" style="float:left; width:735px;">
				
                <div style="padding-left:30px;" id="flashmsg"><b><?php echo $session->flash();?></b></div>
           
                
                		 <?php echo $this->Form->create('school', array('action' => 'tutor_edit','admin'=> true ,'enctype' => 'multipart/form-data')); ?>
                         
                         
                      <input type="hidden" name="courseid" id="courseid" value="<?php echo $this->data['Member']['id'];?>"   />
			
                    <div class="paddinSet">
						   <fieldset style="margin:0px; float:left;" id="personal-info">
                            <legend>Tutor Info</legend>
                             <div class="fieldContainerByDpkMahendru">
                                    <label for="UserStatus" class="field-title dpkLab20">User Status : </label>
									
									<input type="radio" name="data[Member][status]" id="MemberStatus1" value="1" 
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
									?>  /> Deactive                               
                                    
                                </div>
                            
                       
                             <label class="dpkLab" for="UserFirstname" class="field-title">First Name : </label><?php echo $form->input('userMeta.fname',array('label'=>'','div' => '','class'=>'required',"type"=>"text")); ?><br /><br />
                             <label class="dpkLab" for="UserLastname" class="field-title">Last Name : </label><?php echo $form->input('userMeta.lname',array('label'=>'','div' => '','class'=>'required',"type"=>"text")); ?><br /><br />

                             <label class="dpkLab" for="UserLastname" class="field-title">Address : </label><?php echo $form->input('userMeta.address',array('label'=>'','div' => '','class'=>'required',"type"=>"text")); ?><br /><br />
                             <label class="dpkLab" for="UserLastname" class="field-title">City : </label><?php echo $form->input('userMeta.city',array('label'=>'','div' => '','class'=>'required',"type"=>"text")); ?><br /><br />
                             <label class="dpkLab" for="UserLastname" class="field-title">State : </label><?php echo $form->input('userMeta.state',array('label'=>'','div' => '','class'=>'required',"type"=>"text")); ?><br /><br />
                             <label class="dpkLab" for="UserLastname" class="field-title">Country : </label><?php echo $form->input('userMeta.country',array('label'=>'','div' => '','class'=>'required',"type"=>"text")); ?><br /><br />
                             <label class="dpkLab" for="UserLastname" class="field-title">Zip : </label><?php echo $form->input('userMeta.zip',array('label'=>'','div' => '','class'=>'required',"type"=>"text")); ?><br /><br />
                     
                                <label class="dpkLab" for="UserFirstname" class="field-title">Contact No : </label><?php echo $form->input('Member.contact',array('label'=>'','div' => '','class'=>'required ')); ?><br /><br />
                                
                                
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