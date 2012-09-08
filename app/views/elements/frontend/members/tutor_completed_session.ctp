	<?php foreach($completed as $result){?>
    <div class="dp_main">
        <div class="dp_img">
            <?php
            if($result['student']['showImage'])
            {
                
                if(!empty($result['student']['image_name'])){
                    echo $html->image("members/thumb/".$result['student']['image_name']);
                } else {
                    ?><img src="https://graph.facebook.com/<?php echo $result['student']['facebookId']; ?>/picture?type=large"  />
                <?php }
            }
            else
            {
                echo $html->image("profile-photo.png");
            }
            ?>
        </div>
        <div class="dp_right">
            
            <div class="dp_info">
                <ul>
                
                    <li class="dp_name"> 
                        	 <?php echo ucwords($result['student']['fname'])."&nbsp;&nbsp;".ucwords($result['student']['lname']);?>
                    </li>
                
                
                
                  	<?php
					if(!empty($result['student']['facebookId']))
					{
					?>
					<li><a href="http://facebook.com/profile.php?id=<?php echo $result['student']['facebookId'];?>" target="_blank">Facebook Profile</a></li>
					
					<?php
					}
					?>
                    
           <?php /*?>          <li><b>Location:</b> 
                            <?php
							if(!empty($result['student']['userMeta']['city']) && !empty($result['student']['userMeta']['state']))
							{
							 echo $result['student']['userMeta']['city'];?> , <?php echo $result['student']['userMeta']['state'];
                            }
							else
							{
								echo 'N/A';
							}
							?>
                            </li><?php */?>
                            
                    <li><b>Course:</b> <?php echo $result['PaymentHistory']['booked_course'];?></li>
                    
                     <?php $tut_net_rate = (($result['PaymentHistory']['tutor_rate_per_hour']*100 )/((100+($charge['Charge']['tutorcause_charge']))));
						?>
                             <li><b>Hourly Rate:</b> $ </b><?php echo $tut_net_rate;?></li>
                            <?php
							$nettime = $result['PaymentHistory']['tutoring_hours'];
							$netrate = $result['PaymentHistory']['tutor_rate_per_hour']; 
                           $tut_net_rate = (($result['PaymentHistory']['tutor_rate_per_hour']*100 )/((100+($charge['Charge']['tutorcause_charge']))));
                            $netprice = $nettime * $tut_net_rate;
							?>
                            <li><b>Total Session Cost:</b> $ <?php printf("%.2f", $netprice ); ?></li>
                    
                <li><b>Time:</b><label > <?php echo date('F j, Y @ h:i A',strtotime($result[0]['booked_start_time']));?><br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>to</b> <?php echo date('F j, Y @ h:i A',strtotime($result[0]['booked_end_time']));?></label></li>
                    
                    <?php if(isset($result['TutRating']['id'])){ ?>
                    <li><div style="float:left;"><b>Knowledge:</b></div>
                        <div class="rating" style="clear:none;">
                            <?php for($i=1;$i<=$result['TutRating']['knowledge'];$i++){ ?>
                            <div class="star on">
                                <a title="Give it 1" href="#1" style="width: 100%;">1</a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="clear"></div>
                    </li>
                    <li><div style="float:left;"><b>Ability:</b></div>
                        <div class="rating">
                            <?php for($i=1;$i<=$result['TutRating']['ability'];$i++){ ?>
                            <div class="star on">
                                <a title="Give it 1" href="#1" style="width: 100%;">1</a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="clear"></div>
                    </li>
                    
                    <li><div style="float:left;"><b>Comments:</b></div>
                    <div class="rating">
                    <?php echo $result['TutRating']['comments'];?>
                    </div>
                        <div class="clear"></div>
                    </li>
                    
                    
                    
                    <?php }?>
                </ul>
            </div>
            <?php echo $this->Form->create('Member'); ?>
            <div class="dp_action">
                <input type="hidden" name="data[Member][id]"  value="<?php echo $result['PaymentHistory']['id'];?>"  />
                <span><label style="color:#1D5894;cursor:pointer" class="sendMessage">Send Message</label></span>
                <input type="hidden" class="studentId" value="<?php echo $result['student']['id']; ?>" />
                <input type="hidden" class="studentName" value="<?php echo $result['student']['fname']." ".$result['student']['lname'];?>" />
                <input type="hidden" class="sendSubject" value="Course : <?php echo $result['PaymentHistory']['booked_course'];?>" />
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <div style="clear:both"></div>
    </div>
    <?php } 	if(count($completed)==0)
    {
    ?>
		<p style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px;padding-top: 5px; padding-left: 5px; text-align:center;"><b>No Record Found</b></p>
	<?php
    }
    else
	{
	?>	
	
        <!-- pagination starts -->
        <div class="paging" id="users-paging-view">
        <?php echo $paginator->prev(' '.__('Prev Page', true), array(), null, array('class'=>'disabled'));?> 
        <span style="float:left; margin-right: 2px; padding: 3px 4px;">|</span>
        <?php echo $paginator->next(__('Next Page', true).' ', array(), null, array('class' => 'disabled'));?>
        </div>
        <!-- pagination end -->	
		
	<?php	
	}
	?>
	
    
    
    		
    
    