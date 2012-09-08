


<script type="text/javascript">	
$(document).ready(function () {
	$('#menu').tabify();
	$('#menu2').tabify();
});
</script>
<style type="text/css" media="screen">
	body { font: 0.8em Arial, sans-serif; }
</style>
<div class="public_profile_main_cointainer">
	<div class="public_profile_cointainer">
    
    <?php   echo $this->element('frontend/studentLeftSidebar'); ?>
    	 
        <div id="contentRgt">
                    <h1>Student School Info</h1>
        		 <?php echo $this->Form->create('member', array('id' => 'Studentschool' , 'action' => 'studentschoolsave' )); ?>
             
                <div>
                	<div>
                    	<label>Schools</label>
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
                    
                      <div  style="margin:0px 0px 0px 440px;">
                    	<span></span>
                        
                    	<input type="submit" value="Submit" /> 
                        
                        </div>
                   
                   
                </div>
                
                <?php echo $this->Form->end(); ?>
        	
        </div>           
    </div>
</div>
