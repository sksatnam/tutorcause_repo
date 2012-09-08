<?php //pr($states);die;?>


<div id="content">
	<div id="content-top">
    <h2>Upcoming Schools</h2>
      
      <span class="clearFix">&nbsp;</span>
      </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	  	<div id="mid-col">    	
			<div class="box">
				<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Add Upcoming School</h4>
				<div id="userAddPanel" style="float:left; width:735px;">
				
                <div style="padding-left:30px;" id="flashmsg"><b><?php echo $session->flash();?></b></div>
                
                			 <?php echo $this->Form->create('UpcomingSchool', array("url" => $html->url(array('action' => 'upcoming_add', "admin" => true), true),'id'=>'SchoolAddForm','enctype' => 'multipart/form-data')); ?>
                    
			
                    <div class="paddinSet">
						   <fieldset style="margin:0px; float:left;" id="personal-info">
                            <legend>School Info</legend>
                            <div class="innerContainerInsideFieldset">
                            
                             <label class="dpkLab" for="UserFirstname" class="field-title">School Name : </label><?php echo $form->input('school_name',array('label'=>'','div' => '','class'=>'required')); ?><br /><br />
                            
                            
                                <label class="dpkLab" for="UserFirstname" class="field-title">School Website : </label><?php echo $form->input('url',array('label'=>'','div' => '','class'=>'required url')); ?><br /><br />
                                
                                <label class="dpkLab" for="UserLastname" class="field-title">Slug :</label><?php echo $form->input('slug',array('label'=>'','div' => '','class'=>'required')); ?><br /><br />
                                
                               
                                
                                <label class="dpkLab" for="UserAddress1" class="field-title">Address : </label><?php echo $form->input('address',array('label'=>'','div' => '','class'=>'required')); ?><br /><br />
                               
                                <label for="UserCity" class="dpkLab">City :</label><?php echo $form->input('city',array('label'=>false,'id'=>'UserCity','class'=>'required')); ?><?php //echo $form->select('userMeta.city',array(''=>'Select City'),$this->data['userMeta']['city'],array('id' =>'UserCity'),false); ?>
                                                                                          <br />
                                                                                          
                                 <label for="UserState" class="dpkLab">State : </label>
								 <select name="data[School][state]" class="required">
                                 <option value="">Select State</option>

								<?php
                                foreach ( $states as $key => $val ) {
								  echo  "<option value=\"$val\">$val</option>";
								}	
                                ?>
                                </select>
	                                 <br /><br />
                             
                                <label class="dpkLab" for="UserZipcode" class="dpkLab20">Zip :</label><?php echo $form->input('zip',array('label'=>'','div' => 'entryField','numeric'=>'integer','class'=>'number required','maxlength'=>'10')); ?><?php // echo $form->input('Member.zipcode',array('label'=>'','div' => '','numeric'=>'integer','class'=>'zipcode','maxlength'=>'10')); ?><br /><br />
                                  
                                
                                 
                                  <label class="dpkLab" for="UserPhone" class="dpkLab20"> Sponsoring Organization   :</label><?php echo $form->input('sponsoring_organization',array('label'=>'','div' => '','class'=>'required')); ?><br /><br />
                                  
                                  
                                   <label class="dpkLab" for="UserPhone" class="dpkLab20"> School Logo  :</label>
                                   <input type="file" name="data[UpcomingSchool][file]"  />
                                   <br /><br />
                                  
                                  <label class="dpkLab" for="UserPhone" class="dpkLab20"> Sponsoring Org Logo   :</label>
                                  <input type="file" name="data[UpcomingSchool][file1]"  /><br /><br />
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