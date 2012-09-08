<?php 
/*echo '<pre>';
print_r($admindata);die;
*/
?>


<div id="content">
	<div id="content-top">
    <h2>Approve</h2>
      
      <span class="clearFix">&nbsp;</span>
      </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	  	<div id="mid-col">    	
			<div class="box">
            
				<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Approve</h4>
				<div id="userAddPanel" style="float:left; width:735px;">
                
                  <div style="padding-left:30px;" id="flashmsg"><b><?php echo $session->flash();?></b></div>
		        	 
                  <div class="paddinSet">
                        <fieldset style="margin:0px; float:left;">
						    <legend>School info</legend>
                            <div class="innerContainerInsideFieldset">
                              
                              
                                <div class="fieldContainerByDpkMahendru">
                                 
                                <div class="fieldContainerByDpkMahendru" > 
                                
                                
                            	 <div id="schoolname">                                                      
                                  <label for="SchoolName" class="dpkLab">School Name : </label>
                                  
                                  <input type="text" style="width: 200px;" readonly="readonly" value="<?php echo $admindata['School']['school_name']; ?>"  />
                                  
                                </div>
                                </div>
                                
                                
                                <div class="fieldContainerByDpkMahendru">
                                 
                                <div class="fieldContainerByDpkMahendru" > 
                                
                                
                            	 <div id="schoolname">                                                      
                                  <label for="SchoolName" class="dpkLab">Courses  : </label>
                                  
                                  <div class="input text" style="width:300px; float:left; padding-top:8px;">
                                  <?php 
								  $countcourse = count($admindata['TutCourse']); 
								  $i = 1;
								  
								  foreach($admindata['TutCourse'] as $tc)
								  {
									  
									  echo $tc['course_id'].' ( $ '.$tc['rate'].' / Hour ) ';
									 /* if($i<$countcourse)
									  {
									  	
									  }*/
									  
									  if($i%2==0)
									  {  
										echo '<br>';
									  }
									  else
									  {
										echo '&nbsp;&nbsp;,&nbsp;&nbsp;';
									  }
									  
									  $i++;
									  
									  
								  }
								  
								  if(empty($admindata['TutCourse']))
								  {
										echo 'N/A';
								  }
								  ?>
                                  </div>
                                  
                                </div>
                                </div>
                                
                                
                                
                                
							    
							</div>
                            </fieldset>
                  	</div>
                    
			
                    <div class="paddinSet">
						   <fieldset style="margin:0px; float:left;" id="personal-info">
                            <legend>Personal Info</legend>
                            
                            
                            <div class="innerContainerInsideFieldset">
                            <label class="dpkLab" for="UserFirstname" class="field-title">Email : </label><?php echo $form->input('Member.email',array('label'=>'','div' => '','class'=>'required','value'=>$admindata['Member']['email'],'readonly'=>true)); ?><br /><br />
                            
                            
                            
                                <label class="dpkLab" for="UserFirstname" class="field-title">First Name : </label><?php echo $form->input('userMeta.fname',array('label'=>'','div' => '','class'=>'required','value'=>$admindata['userMeta']['fname'],'readonly'=>true)); ?><br /><br />
                                <label class="dpkLab" for="UserLastname" class="field-title">Last Name :</label><?php echo $form->input('userMeta.lname',array('label'=>'','div' => '','class'=>'required','value'=>$admindata['userMeta']['lname'],'readonly'=>true)); ?><br /><br />
                                
                                <label class="dpkLab" for="UserPhone" class="dpkLab20">Phone :</label><?php echo $form->input('userMeta.contact',array('label'=>'','div' => '','maxlength'=>'14','value'=>$admindata['userMeta']['contact'],'readonly'=>true)); ?><br /><br />
                                
                                <label class="dpkLab" for="UserAddress1" class="field-title">Street Address : </label><?php echo $form->input('userMeta.address',array('label'=>'','div' => '','class'=>'','value'=>$admindata['userMeta']['address'],'readonly'=>true)); ?><br /><br />
                               
                                <label for="UserCity" class="dpkLab">City :</label><?php echo $form->input('userMeta.city',array('label'=>false,'id'=>'UserCity','class'=>'','value'=>$admindata['userMeta']['city'],'readonly'=>true)); ?><?php //echo $form->select('userMeta.city',array(''=>'Select City'),$this->data['userMeta']['city'],array('id' =>'UserCity'),false); ?>
                                <br/>
                                                                                          
                                
                                 <label for="UserState" class="dpkLab">State : </label>
                                 
                     	         <div class="input text"><input type="text" maxlength="30" value="" class="" id="UserState" readonly="readonly" name="data[userMeta][state]"></div>
                                 
                                 	<br />
                                 
                                
                                <label class="dpkLab dpkLab20" for="UserZipcode">Zip Code :</label>
								<?php echo $form->input('userMeta.zip',array('label'=>'','div' => 'entryField','numeric'=>'integer','class'=>'','maxlength'=>'10','value'=>$admindata['userMeta']['zip'],'readonly'=>true)); ?>
								<br /><br />
                              
                                
                                
                                
                       		</div>
                        </fieldset>
                        
                        
                         <?php echo $form->create('Member',array('class' => 'middle-forms',"id"=>"Membertutorapprove","url" => $html->url(array('action' => 'admin_tutor_approve' , "admin" => true), true))); ?>
                         
                         
                           <input type="hidden" name="data[Member][id]" value="<?php echo $admindata['Member']['id']; ?>"  />
                        
                            <div id="submit-buttons">
                            
                                <span><input type="submit" name="data[Member][accept]" value="Approved" /></span>
								<span><input type="submit" name="data[Member][denied]" value="Denied" /></span>
                                
                            </div>
                            
                            <?php echo $form->end(); ?>
                            
                          
                     	</div>

                    
                 	</div>
                    
                      
                    
				</div> <!--end of box-->
			</div> <!--end of midcol-->

		</div><!-- end of div#mid-col -->
        <span class="clearFix">&nbsp;</span>     