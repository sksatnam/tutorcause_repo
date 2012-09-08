<div id="content-wrap">

<?php	echo $this->Session->flash(); ?>

              <h1>Your Dashboard</h1>
              <div id="tutor-wrap"> 
              
              <?php echo $this->element('frontend/causeLeftSidebar'); ?>
                    
                <!--Center Column Begin Here-->
                <div class="center-col">
                
                
                <div class="center-row">
    <div class="center-content">
    <div id="messages">
    <div class="center-heading">
      <h2>You have <?php if($countMsg)
				{
				?>	
				<span><?php echo $countMsg;?></span>
                <?php	
				}
				else
				{
				echo 'no';
				}
				?> messages in your inbox</h2>
      <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/messages';?>">Go to Inbox</a></div>
	 
	   <?php /*?> <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/outbox_message';?>">Go to Outbox</a></div><?php */?>
    </div>
    </div>
    </div>
    </div>
    
                  
                  <div class="center-row2">
                    <div class="center-content">
                      <div id="notices">
                        <div class="center-heading">
                          <h2>Notice Board</h2>
                          <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/notices';?>">View all notices</a></div>
                        </div>
                        
						<?php
                        foreach($causeNotice as $cn)
							{
							?>
                                <div class="notice"> <span><?php echo $cn['Notice']['notice_head'];?></span>
                                <p><?php echo $cn['Notice']['notice_text'];?></p>
                                </div>
							<?php
							}
                        ?>
                        
                      </div>
                    </div>
                  </div>
                </div>
                <!--Center Column End Here--> 
                
                
                 <?php echo $this->element('frontend/causeRightSidebar');?>    
           
                
  </div>
</div>
            
            



