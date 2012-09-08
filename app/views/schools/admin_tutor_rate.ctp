<?php //3aug2012 ?>
<?php 
/*echo '<pre>';
pr($memberData);die;
*/
?>


<div id="content">
	<div id="content-top">
    <h2>Tutor Courses</h2>
      
      <span class="clearFix">&nbsp;</span>
      </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	  	<div id="mid-col">    	
			<div class="box">
            
				<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Tutor Courses</h4>
				<div id="userAddPanel" style="float:left; width:735px;">
                
                  <div style="padding-left:30px;" id="flashmsg"><b><?php echo $session->flash();?></b></div>
		           
                 
                <?php 
				
			    $encodedId = base64_encode(convert_uuencode($memberData['Member']['id']));
				
				echo $form->create('School',array('class' => 'middle-forms',"id"=>"TutorRateForm","url" => $html->url(array('action' => 'tutor_rate', $encodedId , "admin" => true), true))); ?>
                 
                	 
                    <input type="hidden" name="data[Member][id]" value="<?php echo $memberData['Member']['id']; ?>"   />
                    
                    <div class="paddinSet">
						   <fieldset style="margin:0px; float:left;" id="personal-info">
                            <legend>Tutor Courses</legend>
                            
                              <label class="dpkLab" for="UserFirstname" class="field-title" style="font-size:16px; font-weight:bold">Courses</label>
                              <span style="font-size:16px; font-weight:bold; line-height:30px;">Rate </span>
                            
                            
                            <div class="innerContainerInsideFieldset">
                            
                            
                            <?php
							if(count($memberData['TutCourse']))
							{
								foreach($memberData['TutCourse'] as $tc)
									{
									?>	
                                      
                                        <label class="dpkLab" for="UserFirstname" class="field-title"><?php echo $tc['course_id'];?></label>
                                        <input type="text" name="data[TutCourse][<?php echo $tc['id'];?>]" class="required number valids" max="100" min="0" value="<?php echo $tc['rate'];?>" maxlength="5"  /> <br /><br />
									<?php	
									}
							}
							?>  
                                
                       		</div>
                        </fieldset>
                            <div id="submit-buttons">
                                <?php   echo $form->submit('Save',array('div' => false)); ?>
                                <input type="reset" value="Reset" />
                            </div>
                          
                     	</div>

                        
					
                    
                      <?php echo $form->end(); ?>
                      
                      
                </div> <!--end of user panel-->
				</div> <!--end of box-->
			</div> <!--end of midcol-->

		</div><!-- end of div#mid-col -->
        <span class="clearFix">&nbsp;</span>     