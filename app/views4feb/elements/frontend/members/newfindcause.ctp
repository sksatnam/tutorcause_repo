<style type="text/css">
h4.cause-name {
    font-size: 14px;
    width: 156px;
    word-wrap: break-word;
}
</style>
    <!--Cause Search End Here-->
    <div id="tutor-content"> 
      
      <!--Left Sidebar Begin Here-->
      <div id="tutor-left">
      
        <ul>
        
		<?php
        if(count($filtercause))
        {
        $i = 1; 	
        foreach($filtercause as $fc)
			{
			?>
            
			  <li class="cause-bg"><a href="JavaScript:void(0);" onclick="showcause(<?php echo $fc['Member']['id']; ?>);" 
				<?php if($watchcause['Member']['id'] == $fc['Member']['id'])
					{
					?>	
					class="current"
					<?php
					}                
                ?>
              >
				<div class="profile-wrap">
				  <div class="profile-pic">
				 <?php	
				 if($fc['Member']['showImage'])
				{
				 
				$causeimage = $this->requestAction('members/getcauseProfile/'.$fc['userMeta']['member_id']); 
			
					if(count($causeimage['UserImage'])){
						echo $html->image("members/thumb/".$causeimage['UserImage']['image_name'],array('width'=>57,'height'=>58));
					} else {
						echo $html->image("frontend/cause-logo.gif",array('width'=>57,'height'=>58));
					 }
				}
				else
				{
					echo $html->image("profile-photo.png",array('width'=>57,'height'=>58));
				}
				?>
				  
				  <?php // echo $html->image("frontend/pic-1.jpg")?></div>
				  <div class="profile-info">
					<div class="name-price">
					  <h4 class="cause-name wordbreak"><?php echo $fc['userMeta']['cause_name'];?></h4>
					  <div class="amount-raised">
							<div class="amount-raised-text">Amount Raised:</div>
							<div class="raised-amt">
                             <?php
						   $amount_raised = $this->requestAction('members/cause_amount_raised/'.$fc['userMeta']['member_id']); 
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
                           </div>
					  </div>
					</div> 
				  </div>
				</div>
				</a></li>
				
				<?php	
				
				$i++;
				
				}	
            }
            ?>
            
            
        </ul>
      
        <!-- pagination starts -->
        <?php
        if(count($filtercause))                        
        {
        ?>
        <div class="paging" id="users-paging-view">
            <?php // echo $paginator->first();?>
            
           <?php // echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>
            
            <?php echo $paginator->prev(' '.__('Prev Page', true), array(), null, array('class'=>'disabled'));?> 
            <?php //  echo $paginator->numbers(array('separator' => false));?>
            
            <span style="float:left; margin-right: 2px; padding: 3px 4px;">|</span>
                
            <?php // echo $paginator->(array('separator' => '|'));?>
            <?php echo $paginator->next(__('Next Page', true).' ', array(), null, array('class' => 'disabled'));?>
            <?php // echo $paginator->last();?>
        </div>
        <?php
        }
        ?>
        
      </div>
      
      <!--Left Sidebar End Here-->
      
      
        <!--Center Column Begin Here-->
      <div id="cause-center">
        <div id="cause-detail">
          <div id="cause-pic">
		  <div style="text-align:center;">
           <?php
		    if($watchcause['Member']['showImage'])
				{
		   
				$causeimage1 = $this->requestAction('members/getcauseProfile/'.$watchcause['userMeta']['member_id']); 
			
					if(count($causeimage1['UserImage'])){
						echo $html->image("members/".$causeimage1['UserImage']['image_name'],array('width'=>'332px','height'=>'278px'));
					} else {
						echo $html->image("frontend/cause-logo.gif",array('width'=>'332px','height'=>'278px'));
					 }
				}
			else
				{
					echo $html->image("profile-photo.png",array('width'=>'332px','height'=>'278px'));
				}	 
		 ?>
            </div>
			
					<?php // echo $html->image("frontend/cause-pic.jpg")?></div>
				  <h2>                     
				  <?php
				 			 $findname = $watchcause['userMeta']['cause_name'];
							 $urlName=$findname . '_' . $watchcause['Member']['id'];
						 	 echo $html->link($findname ,array('controller'=>'members', 'action'=>'cause', $urlName), array('title' => $watchcause['userMeta']['cause_name'] ,'style'=>'color:#1D5894'));?>
					</h2>
			<?php 
								if(trim($watchcause['userMeta']['biography']))
								{
								?>
									<div><a class="view" href="JavaScript:myfunc();"></a></div>
								<?php
								
								}
								else
								{
								?>
								<!--<div><a class="view" href="javascript:void(0)"></a></div>-->
								<?php
								}
								?>
								<div style="clear:both"></div>
								<div id="biography" style="display:none; text-align:justify;">
								<p><?php echo $watchcause['userMeta']['biography'];?></p>  
                                </div>
			
			
			
			
			
			
 		 <?php /*?> <?php // echo $html->image("frontend/cause-pic.jpg")?></div>
          <h2><?php echo $watchcause['userMeta']['cause_name'];?></h2>                      
           <p><?php echo $watchcause['userMeta']['biography'];?></p>
          <?php
            $findname = $watchcause['userMeta']['cause_name'];
            $urlName=$findname . '_' . $watchcause['Member']['id'];
            ?>
          <a href="<?php echo HTTP_ROOT.'members/cause/'.$urlName;?>" class="view"></a> </div><?php */?>
      </div>
	  </div>
      <!--Center Column End Here--> 
      
      <!--Right Sidebar Begin Here-->
      <div id="cause-right">
        <div id="cause-price">
          <div id="cause-price-wrap">
            <h3><?php echo $watchcause['userMeta']['cause_name'];?></h3>
            <h5>Amount Raised - 
              <?php
			   $amount_raised = $this->requestAction('members/cause_amount_raised/'.$watchcause['userMeta']['member_id']); 
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
            </h5>
            <?php
						if(!in_array($watchcause['Member']['id'],$requestedcause))
						{
						?>
                           <a href="<?php echo HTTP_ROOT.'members/send_request_cause/'.$watchcause['Member']['id']; ?>" class="cause-btn"></a>
                        <?php
						}
						?>
            
			 </div>
        </div>
        <a href="JavaScript:void(0);" class="send-mesg sendMessage">&nbsp;</a>
        <input type="hidden" class="resultId" value="<?php echo $watchcause['Member']['id'];?>" />
		<input type="hidden" class="resultName" value="<?php echo $watchcause['userMeta']['cause_name'];?>" />
 
      </div>
      <!--Right Sidebar End Here-->
      
      
      
      
              
      
      
    </div>
    
