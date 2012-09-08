<style type="text/css">
.stepThreeFormRow label
{
	width:160px;
}
</style>

<div id="content">

<?php	echo $this->Session->flash(); ?>

            	<div class="stepsHeadingNew">
                    
                        <div class="newProgressBarOuter">
                        	<div class="proBarsSection1">
                            	<span class="spanNo">1</span>
                                <span class="spanOnHover">Select Course</span>

                            </div>
                            <div class="proBarsSection1">
                            	<span class="spanNo">2</span>
                                <span class="spanOnHover">Schedule Session</span>
                            </div>
                            <div class="proBarsSection2">
                            	<span class="spanNo">3</span>
                                <span class="spanOnHover">Confirm Request</span>
                            </div>
                             <div class="proBarsSection3">
                            	<span class="spanNo">4</span>
                                <span class="spanOnHover">Pay for Session</span>
                            </div>
                            
                        </div>
                    
                    <h1>Confirm Request</h1>
                </div>
                 
             	
                <div class="school-info-field">
                
                
                <div class="stepThreeFormRow">
                         <label style="font-weight:bold;">Course Code</label>
                         <label><?php echo $this->Session->read('booktutor.coursename');?></label> 
                 </div>
                 
                 <div class="stepThreeFormRow">
                         <label style="font-weight:bold;">Hourly Rate</label>
                         <label><?php echo '$ '.$this->Session->read('booktutor.rate');?></label> 
                 </div>                 
                 
                 
                 
                 <div class="stepThreeFormRow">
                         <label style="font-weight:bold;">Session Start</label>
                         <label style="width:auto;"><?php echo date('F d, Y @ G:i a',strtotime($this->Session->read('booktutor.starttime')));?></label> 
                 </div>
				 <div class="stepThreeFormRow">
                         <label style="font-weight:bold;">Session End</label>
                         <label style="width:auto;"><?php echo date('F d, Y @ G:i a',strtotime($this->Session->read('booktutor.endtime')));?></label> 
                 </div>
                 
               
                 <div class="stepThreeFormRow">
                         <label style="font-weight:bold;">Session Duration</label>
                         <label><?php echo $this->Session->read('booktutor.tuthours');?> Hours</label> 
                 </div>
                 <div class="stepThreeFormRow">
                         <label style="font-weight:bold;">Total Session Cost</label>
                         <label>
                        <?php
						 $netprice = $this->Session->read('booktutor.tuthours') * $this->Session->read('booktutor.rate');
						 ?>
						  $ <?php  printf("%.2f", $netprice ); ?>
                         </label>
                 </div>
                 
                     <?php echo $this->Form->create('member',array('action' => 'send_session_request')); ?>
                  <div class="stepThreeFormRow">
              
                  <input type="hidden" name="booked" value="1"  /> 
                
                      <div class="stepFormContButton button" style="margin-left:148px;">
                    	<span></span>
                    	<input type="submit" value="Confirm Request" /> 
                        </div>
                  
                    </div>
					
					<?php echo $this->Form->end();  ?>
              
                    
                </div>
                
                    
</div>