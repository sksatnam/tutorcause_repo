
   <div class="searchTutors">	<!--searchTutors-->
        	<h1 style="color:#58b9e9;"> Search Results </h1>
        	<div class="tutorSearchResult-outer"
            <?php
            if(count($filtercause))
            {
            ?>
            style="border-bottom:none";
            <?php
            }
            ?> >	<!--tutorSearchResult-outer-->
            <?php
            foreach($filtercause as $ft)
            {	
			?>	
            
            <div class="tutorSearchResult">	<!--tutorSearchResult-->
            	<div class="tutorSearchResult-img">	<!--tutorSearchResult-img-->
            	<?php			
				$causeimage = $this->requestAction('members/getcauseProfile/'.$ft['userMeta']['member_id']); 
				
			/*	echo '<pre>';
				print_r($causeresult);
				die;
				*/
					if(count($causeimage['UserImage'])){
						echo $html->image("members/thumb/".$causeimage['UserImage']['image_name'],array('width'=>50,'height'=>50));
					} else {
						echo $html->image("frontend/cause-logo.gif",array('width'=>50,'height'=>50));
					 }
					 
			   ?>
		    </div>	<!--tutorSearchResult-img-->
                <div class="tutorSearchResult-nameAndDisc">	<!--tutorSearchResult-nameAndDisc-->
                    <div class="tutorSearchResult-name">	<!--tutorSearchResult-name-->
                        <div class="tutorSearchResult-name-disc1">	<!--tutorSearchResult-name-disc1-->
                            <label>Name:</label>
                        </div>	<!--tutorSearchResult-name-disc1-->
                        <div class="tutorSearchResult-name-disc2">	<!--tutorSearchResult-name-disc2-->
                         <?php
						 
							 $findname = $ft['userMeta']['cause_name'];
							 $urlName=$findname . '_' . $ft['Member']['id'];
						 	 echo $html->link($findname ,array('controller'=>'members', 'action'=>'tutor', $urlName), array('title' => $ft['userMeta']['cause_name'] ,'style'=>'color:#1D5894'));?>
						
                            <label class="tutorurl">
							<?php echo $html->link($findname, array('controller'=>'members', 'action'=>'cause', $urlName), array('title' => $findname)); ?></label>
                        </div>	<!--tutorSearchResult-name-disc2-->
                    </div>	<!--tutorSearchResult-name-->
                    
                    
                    
                    <div class="tutorSearchResult-name">	<!--tutorSearchResult-name-->
                        <div class="tutorSearchResult-name-disc1">	<!--tutorSearchResult-name-disc1-->
                            <label>Amount Raised:</label>
                        </div>	<!--tutorSearchResult-name-disc1-->
                    
                        <div class="tutorSearchResult-name-disc2">	<!--tutorSearchResult-name-disc2-->
                           <?php
						   $amount_raised = $this->requestAction('members/cause_amount_raised/'.$ft['userMeta']['member_id']); 
						   if($amount_raised)
							{
							 ?>  
							 <label><?php echo '$ '.$amount_raised;?> </label>  
                            <?php   
							}
							else
							{
							?>	
							<label>N/A</label>	
							<?php	
							}
						   ?>
                           
                           
                          
                        </div>	<!--tutorSearchResult-name-disc2-->
                        
                    </div>	<!--tutorSearchResult-name-->
                    
                    	<!--tutorSearchResult-name-->
                    
                    
                </div>	<!--tutorSearchResult-nameAndDisc-->
                <div class="tutorSearchResult-personalInfo">	<!--tutorSearchResult-personalInfo-->
                	<ul>
						
						
                        <?php
						if(!in_array($ft['Member']['id'],$requestedcause))
						{
						?>
                        <li style="padding-left:5px;width:240px;">
							<div class="searchResultLeft">
							<?php
								echo $html->image("frontend/lock.png",array('style'=>'width:20px;height:20px;'));
							?>
							</div>
							<div class="searchResultCenter">
								<a href="<?php echo HTTP_ROOT.'members/send_request_cause/'.$ft['Member']['id']; ?>">Tutor for this Cause</a>
							</div>
							<div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
						</li>
                        
                        <?php
						}
						?>
                        
                        
						<li style="padding-left:5px;width:240px;">
							<div class="searchResultLeft">
							<?php
								echo $html->image("frontend/send_message.png",array('style'=>'width:18px;height:18px;'));
							?>
							</div>
							<div class="searchResultCenter">
								<a class="sendMessage" href="#" onclick="return false;">Send Message</a>
								<input type="hidden" class="resultId" value="<?php echo $ft['Member']['id'];?>" />
								<input type="hidden" class="resultName" value="<?php echo $ft['Member']['userMeta']['cause_name'];?>" />
							</div>
							<div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
						</li>
                        
                    </ul>
                </div>	<!--tutorSearchResult-personalInfo-->
                </div>
            <?php
            }
			if(count($filtercause)==0)
			{
				echo 'No Record Found';
			}
		    ?>
            	<!--tutorSearchResult-personalInfo-->
            
            
            
<?php                
 if(count($filtercause))
 {
 ?>
<!-- pagination starts -->
<div class="paging" id="users-paging-view">
    
	<?php echo $paginator->prev(' '.__('Prev Page', true), array(), null, array('class'=>'disabled'));?> 
   
    
    <span style="float:left; margin-right: 2px; padding: 3px 4px;">|</span>
        
    
	<?php echo $paginator->next(__('Next Page', true).' ', array(), null, array('class' => 'disabled'));?>
   
</div>
	
<!-- pagination ends -->
<?php 
 }
 ?>
    
                
                
                
            
                
                         	
            </div>	<!--tutorSearchResult-->
            
               
              
            
            
            
            
            </div>	<!--tutorSearchResult-outer-->