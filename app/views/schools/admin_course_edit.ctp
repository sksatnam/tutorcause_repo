<?php //3aug2012 ?>
<div id="content">
	<div id="content-top">
    <h2>Schools</h2>
      
      <span class="clearFix">&nbsp;</span>
      </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	  	<div id="mid-col">    	
			<div class="box">
				<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Edit Course</h4>
				<div id="userAddPanel" style="float:left; width:735px;">
				
                <div style="padding-left:30px;" id="flashmsg"><b><?php echo $session->flash();?></b></div>
           
                
                		 <?php echo $this->Form->create('school', array('action' => 'course_edit','admin'=> true ,'enctype' => 'multipart/form-data')); ?>
                         
                         
                      <input type="hidden" name="courseid" id="courseid" value="<?php echo $this->data['Course']['id'];?>"   />
                      <input type="hidden" name="schoolid" id="schoolid" value="<?php echo $this->data['School']['id'];?>"   />
			
                    <div class="paddinSet">
						   <fieldset style="margin:0px; float:left;" id="personal-info">
                            <legend>Course Info</legend>
                            <div class="innerContainerInsideFieldset">
                            
                                <label for="School Name" class="dpkLab">School Name : </label>
								 <select name="data[Course][school_id]" class="required" style="width:205px;">
                                 <option value="" selected="selected">Select School</option>

								<?php
                                foreach ( $schoolname as $key => $val ) {
									if($key==$this->data['Course']['school_id'])
									{
									  echo  "<option value=\"$key\" selected=\"selected\">$val</option>";			    			}
									  else
									  {
										  echo  "<option value=\"$key\">$val</option>";
										  }
								}	
                                ?>
                                </select>
                                
                                 <br /><br />
                            
                            
                            
                            
                             <label class="dpkLab" for="UserFirstname" class="field-title">Course Code : </label><?php echo $form->input('Course.course_id',array('label'=>'','div' => '','class'=>'required',"type"=>"text")); ?><br /><br />
                            
                            
                                <label class="dpkLab" for="UserFirstname" class="field-title">Course Title : </label><?php echo $form->input('Course.course_title',array('label'=>'','div' => '','class'=>'required ')); ?><br /><br />
                                  
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