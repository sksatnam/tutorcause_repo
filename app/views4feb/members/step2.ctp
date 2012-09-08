<?php 
//if($this->data['Member']['group_id']==6 || $this->data['Member']['group_id']==8){
//$x = $x+25;
//}else{
//$x;
//}
?>

<style>
.probar
{
	background:url(<?php echo FIMAGE?>/progress_bar_bg.png) repeat-x;
	float:left;
	
	min-width:<?php echo $x*2;?>px;
	
	height:30px;
}
</style>
   
     
            <div align="center">
            
            
            <div id="topCheckStep" style="float:left;width:100%"> 
            		<div class="progressBarOutr" style="float:none;">
									<?php 
                                    //if($this->data['Member']['group_id']==7){
                                    ?>
                                        <div class="progressbar">
                                        
                                            <label class="probar"></label>
                                        
                                        </div>
                                        <div class="progressNum">
                                            <span>Your profile <?php echo $x;?>% completed</span>
                                        </div>
                                    
                                    <?php // }
                                    
                                //	if($this->data['Member']['group_id']==6 || $this->data['Member']['group_id']==8){
                                    ?>
                                    
                                  
                                    
                    </div>
            </div>
            
            
            <div id="downCheckStep" style="float:left;width:100%;padding-bottom:100px;">
            	<span style="float:right;width:52%;">
                	<a class="button regSuccBtn" href="<?php echo HTTP_ROOT.'members/tutor_payment';?>">
                    	<span></span>
                    	<label>Go to Payment info</label>
                    </a>
                </span>
                         
               <span style="float:right;padding-left:0px;"> 
               		<a class="button regSuccBtn" href="<?php echo HTTP_ROOT.'members/tutor_dashboard';?>">
                		<span></span>
                		<label>Go To Dashboard</label>
                	</a>
                </span>	
            </div>
            
            
            
            	
            
             
            </div>
            
      
       
    