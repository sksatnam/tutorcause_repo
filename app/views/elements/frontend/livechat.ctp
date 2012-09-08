<!-- /TinyMCE -->
<?php $paginator->__defaultModel="Chat";?>
<?php $snum=$paginator->counter(array('format' => '%start%')); ?>	
<?php //pr($Replies);?>


<div class="text-messages" style="position:relative;">
                        
                        <?php
						if(!empty($chatMsg))
						{
							
							foreach($chatMsg as $cm)
							{
								if($cm['Chat']['from_id']==$this->Session->read('Member.memberid'))
								{
									$chatClass = 'user-message';	
								}
								else
								{
								   $chatClass = 'guest-message';									
								}
						?>	
                            <div class="<?php echo $chatClass;?>">
                            
                            
                                <div class="message-wrap">
                                  <div class="message-pic">
                                  
                                  <div class="tutor-pic">
                                  <?php
                                    if($cm['Member']['showImage'])
                                    {
                                    if(!empty($cm['Member']['image_name'])){
                                    echo $html->image("members/thumb/".$cm['Member']['image_name'],array('class'=>'profile-img-chat'));
                                    } else {
                                    ?><img src="https://graph.facebook.com/<?php echo $cm['Member']['facebookId']; ?>/picture?type=large" class="profile-img-chat"  />
                                    <?php }
                                    }
                                    else
                                    {
                                    echo $html->image("profile-photo.png",array('class'=>'profile-img-chat'));
                                    }
                                    ?>
                                  </div>
                                  
                                  
                               <?php /*?>   <img src="<?php echo FIMAGE;?>guest-pic.jpg" width="44" height="44" alt=""/><?php */?>
                                  
                                  
                                  </div>
                                  
                                  <div class="message-text"><?php echo stripslashes($cm['Chat']['message']);?></div>
                                </div>
                            </div>
                            
                            
						<?php
							}
						}
						else
						{
						?>
                            <div class="user-message">
                                <div class="message-wrap">
                                  No chat message.
                                </div>
                            </div>
                        <?php    
						}
						?>
                        
                        
               <?php /*?>           <div class="user-message">
                            <div class="message-wrap">
                              <div class="message-pic"><img src="<?php echo FIMAGE;?>user-pic.jpg" width="44" height="44" alt=""/></div>
                              <div class="message-text">Hello!! Are you there?</div>
                            </div>
                          </div>
                          <div class="guest-message">
                            <div class="message-wrap">
                              <div class="message-pic"><img src="<?php echo FIMAGE;?>guest-pic.jpg" width="44" height="44" alt=""/></div>
                              <div class="message-text">Yes, I am here.</div>
                            </div>
                          </div>
                          <div class="user-message">
                            <div class="message-wrap">
                              <div class="message-pic"><img src="<?php echo FIMAGE;?>user-pic.jpg" width="44" height="44" alt=""/></div>
                              <div class="message-text">How are you?</div>
                            </div>
                          </div>
                          <div class="guest-message">
                            <div class="message-wrap">
                              <div class="message-pic"><img src="<?php echo FIMAGE;?>guest-pic.jpg" width="44" height="44" alt=""/></div>
                              <div class="message-text"><p>kfdjkfds <strong>dksjafkdsj</strong> <span class="AM">`sqrt(ab)`</span></p></div>
                            </div>
                          </div>
                          <?php */?>
                          
                          
<div class="chatAjaxImage">
<?php echo $html->image("frontend/ajax-loader.gif") ?>
</div>
                          
                          
                          
                        </div>



<?php        
if(!empty($chatMsg))
{	
?>

<input type="hidden" name="chatcnt" id="chatcnt" value="<?php echo $countChat;?>"  />


<div class="pagingChat">
	<?php $paginator->options(array('url' => array('controller'=>'classes','action'=>'getchat',$encode,'admin' => false))); ?>
    
	<?php echo $paginator->prev(' '.__('Prev', true), array(), null, array('class'=>'disabled'));?> 
  
    
    <span style="float:left; margin-right: 2px; padding: 3px 4px;">|</span>
        
  
	<?php echo $paginator->next(__('Next', true).' ', array(), null, array('class' => 'disabled'));?>
</div>


<?php
}
else
{
?>	
<input type="hidden" name="chatcnt" id="chatcnt" value="<?php echo $countChat;?>"  />	
<?php     
}
?>
                        
                        
                        
