<div id="content">

            	<div class="stepsHeadingNew">
                    
                        <div class="newProgressBarOuter">
                        	<div class="proBarsSection2">
                            	<span class="spanNo">1</span>
                                <span class="spanOnHover">Select Course</span>

                            </div>
                            <div class="proBarsSection3">
                            	<span class="spanNo">2</span>
                                <span class="spanOnHover">Schedule Session</span>
                            </div>
                            <div class="proBarsSection3">
                            	<span class="spanNo">3</span>
                               <span class="spanOnHover">Confirm Request</span>
                            </div>
                             <div class="proBarsSection3">
                            	<span class="spanNo">4</span>
                              <span class="spanOnHover">Pay for Session</span>
                            </div>
                            
                        </div>
                    
                    <h1>Select Course Code</h1>
                </div>
                 
				 <?php echo $this->Form->create('member',array('action' => 'book_tutor_course')); ?>
                 
             	
                <div class="school-info-field">
                
                <div class="stepThreeFormRow" style="width:600px;">
                         <label>Course Code</label>
                         <select name="courseid" class="textInStepFrm required">
                         <option value="">Select Course</option>
						 <?php 
						 foreach($tutorcourse as $tc)
						 {
						  ?>	 
                          	<option value="<?php echo $tc['TutCourse']['id'];?>" <?php if($tc['TutCourse']['course_id'] == $defaultCourse){ echo "selected";} ?>><?php echo $tc['TutCourse']['course_id'];?></option>
						 <?php	 
                         }
                         ?>
                         </select> 
                 </div>
                 
                 <div class="stepFormContButton button" style="margin:0px 0px 20px 240px;">
                    <span></span>
                    <input type="submit" value="Submit" /> 
                  </div>
                  
                    
                </div>
                
                <?php echo $this->Form->end(); ?>
                
                
              
            </div>            