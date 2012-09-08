<div id="content">
	<div id="content-top">
    <h2>Schools</h2>
      
      <span class="clearFix">&nbsp;</span>
      </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	  	<div id="mid-col">    	
			<div class="box">
				<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Add Course</h4>
				<div id="userAddPanel"style="float:left; width:735px;">
				
                <div style="padding-left:30px;" id="flashmsg"><b><?php echo $session->flash();?></b></div>
                
                		 <?php echo $this->Form->create('school', array('action' => 'course_add','admin'=> true ,'enctype' => 'multipart/form-data', "id"=>"SchoolCourseAddForm")); ?>
                  
                    <div class="paddinSet">
						   <fieldset style="margin:0px; float:left;" id="personal-info">
                            <legend>Course Info</legend>
                            <div class="innerContainerInsideFieldset">
                            
                            <label for="School Name" class="dpkLab">School Name : </label>
								 <select name="data[Course][school_id]" class="required" style="width:205px;" id="courseaddschoolId">
                                 <option value="">Select School</option>

								<?php
                                foreach ( $schoolname as $key => $val ) {
								  echo  "<option value=\"$key\">$val</option>";
								}	
                                ?>
                                </select>&nbsp;&nbsp;<span style="color:red;" id="schoolMsg"></span>
	                                 <br /><br />
                            
                             <label class="dpkLab" for="CourseCode" class="field-title">Course Code : </label><?php echo $form->input('Course.course_id',array('label'=>'','div' => '','class'=>'required',"type"=>"text",'style'=>'width:200px;','id'=>'courseCode')); ?>&nbsp;&nbsp;<span style="color:red;" id="courseCodeMsg"></span><br /><br />
                             
                             <label class="dpkLab" for="CourseTitle" class="field-title">Course Title : </label><?php echo $form->input('Course.course_title',array('label'=>'','div' => '','class'=>'required','style'=>'width:200px;','id'=>'course_title')); ?>&nbsp;&nbsp;<span style="color:red;" id="courseTitleMsg"></span><br /><br />  
                       		</div>
                        </fieldset>
                            <div id="submit-buttons">
                                <?php  //echo $form->submit('Save',array('div' => false)); ?>
								<input type="button" id="formsubmitbutton" value="Save" />
                                <input type="reset" value="Reset" />
                            </div>
                            <?php echo $form->end(); ?>
                     	</div>
                        
                        <h1 style="font-size:22px; text-align:center;"> OR</h1>
                        <h1 style="font-size:16px; text-align:center;"> To enter multiple courses use import to excel feature.   </h1>

                        <?php /*?>For the ctp import from excel<?php */?>
                        <br/>
                     
                    
					<?php echo $form->create('',array('id'=>'uploads',"url" => $html->url(array('controller'=>'schools','action'=>'importcoursecsv','admin' => true),true),'enctype'=>'multipart/form-data'))?>
					<div class="paddinSet">
                   
                    
                 		<fieldset style="margin:0px; float:left;">
							<legend style="width:185px;"> Import From Excel Course File</legend>
                            
							<div class="innerContainerInsideFieldset">
 
					<?php /*?>	 <?php echo $session->read('flash'); echo $session->delete('flash'); ?><?php */?>
					  
                        <br/>        
							  <!--startAccountinfocontainer-->
							  <div class="startAccountOuterfocontainer">
                              
                               		<!--startAccountinfocontainer-->
									<div class="startpersonalinfocontainer">
                                    <label for="School Name" class="dpkLab">School Name : </label>
								 <select name="data[Course][school_id]" class="required" style="width:205px;">
                                 <option value="">Select School</option>
                                 

								<?php
                                foreach ( $schoolname as $key => $val ) {
								  echo  "<option value=\"$key\">$val</option>";
								}	
                                ?>
                                </select>
                                <br/>
                                <br/>
									<label class="dpkLab" for="SchoolName" class="field-title">Select File : </label>
									<input type="file" name="action_file" class="regFormInput required" />
                                  
									</div>
								</div>
							</div>
                    	</fieldset>
					</div>
					<div id="submit-buttons" style="padding-left:42px">
						<?php  echo $form->submit('Upload',array('div' => false,'name'=>"adminSubmit")); ?>
                        
						<input type="reset" value="Reset"/>
                        
					</div>
					<?php echo $form->end(); ?>         

                    
                 	</div>
				</div>
			</div>

		</div><!-- end of div#mid-col -->
      
      <span class="clearFix">&nbsp;</span>     
</div>