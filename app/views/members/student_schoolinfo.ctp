<?php
/*echo '<pre>';
print_r($schoolname);
die;
*/
?>

<div id="content">

            	<div class="stepsHeadingNew">
                    
                        <div class="newProgressBarOuter">
                        	<div class="proBarsSection1">
                            	<span class="spanNo">1</span>
                                <span class="spanOnHover">Registration</span>

                            </div>
                            <div class="proBarsSection2">
                            	<span class="spanNo">2</span>
                                <span class="spanOnHover">School info</span>
                            </div>
                            
                        </div>
                    
                    <h1>Student School Info</h1>
                </div>
                 
				 <?php echo $this->Form->create('member', array('id' => 'Studentschool' , 'action' => 'studentschoolsave' )); ?>
             
                <div class="stepForm">
                	<div class="stepFormRow">
                    	<label>School <span class="red" >*</span> </label> 
                        <select id="schoolname" class="selectStepFrm required" name="data[Member][school_id]">
                            <option value="" >Please select</option>
                            <?php
							foreach($schoolname as $key=>$value)
							{
							?>	
								<option value="<?php echo $key;?>"
                                <?php
                                if($memberdata['Member']['school_id']==$key)
								{
								   echo "selected=\"selected\"";
								}
                                ?> ><?php echo $value;?></option>	
                                
                            <?php    
							}
							?>
                        </select>
                    </div>
                    
                      <div class="stepFormContButton button" style="margin:0px 0px 0px 440px;">
                    	<span></span>
                        
                    	<input type="submit" value="Submit" /> 
                        
                        </div>
                   
                   
                </div>
                
                <?php echo $this->Form->end(); ?>
                
              
            </div>
            
            