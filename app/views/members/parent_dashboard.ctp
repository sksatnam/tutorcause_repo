<pre>
<?php
/*print_r($parentnotice);
print_r($getBalance);
print_r($countMsg);
echo $countMsg;
die;*/
?>

</pre>




<?php
/*if($countMsg>0){
	$countMsg = $countMsg;
} else {
	$countMsg = "";
}*/
?>


 <div id="content-wrap">
 
 <?php	echo $this->Session->flash(); ?>
 
              <h1>Parent Dashboard</h1>
              <div id="tutor-wrap"> 
                
                <!--Left Sidebar Begin Here-->
                <?php  echo $this->element('frontend/parentLeftSidebar'); ?>
                <!--Left Sidebar End Here--> 
                
                <!--Center Column Begin Here-->
                <div class="center-col">
                  <div class="center-row">
                    <div class="center-content">
                      <div id="messages">
                        <div class="center-heading">
                          <h2>You have
							<?php if($countMsg>0)
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
                          <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/messages';?>">Go to inbox</a></div>
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
                            foreach($parentnotice as $pn)
                            {
                            ?>
                            <div class="notice"> <span><?php echo $pn['Notice']['notice_head'];?></span>
                            <p><?php echo $pn['Notice']['notice_text'];?></p>
                            </div>
                            <?php
                            }
                            ?>
                        
                        
                        
                    <!--    <div class="notice"> <span>Lorem Ipsum is simply dummy text</span>
                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy 			text ever since.</p>
                        </div>
                        <div class="notice"> <span>Lorem Ipsum is simply dummy text</span>
                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy 			text ever since.</p>
                        </div>
                        <div class="notice"> <span>Lorem Ipsum is simply dummy text</span>
                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy 			text ever since.</p>
                        </div>-->
                        
                        
                        
                        
                      </div>
                    </div>
                  </div>
                </div>
                <!--Center Column End Here--> 
                
                <!--Right Sidebar Begin Here-->
                <?php  echo $this->element('frontend/parentRightSidebar'); ?>
                <!--Right Sidebar End Here--> 
                
              </div>
 </div>