	<?php foreach($completed as $result){?>
    <div class="dp_main">
        <div class="dp_img">
            <?php
            if($result['student']['showImage'])
            {
                
                $countImg = count($result['student']['UserImage'])-1;
                if(count($result['student']['UserImage'])){
                    echo $html->image("members/thumb/".$result['student']['UserImage'][$countImg]['image_name']);
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
            <div style="padding:2px;margin:0px 2px;font-weight:bold;font-size:14px"><?php echo $result['student']['userMeta']['fname']."&nbsp;&nbsp;".$result['student']['userMeta']['lname'];?></div>
            <div class="dp_info">
                <ul>
                    <li></li>
                    <li><a href="http://facebook.com/profile.php?id=<?php echo $result['student']['facebookId'];?>" target="_blank">Facebook Profile</a></li>
                    <li><b>Location:</b> <?php echo $result['student']['userMeta']['city'];?> , <?php echo $result['student']['userMeta']['state'];?></li>
                    <li><b>Course:</b> <?php echo $result['PaymentHistory']['booked_course'];?></li>
                    
                     <li><b>Hourly Rate:</b> $ </b><?php echo $result['PaymentHistory']['tutor_rate_per_hour'];?></li>
                    <?php
                    $nettime = $result['PaymentHistory']['tutoring_hours'];
                    $netrate = $result['PaymentHistory']['tutor_rate_per_hour']; 
                    $netprice = $nettime * $netrate;
                    ?>
                    <li><b>Total Session Cost:</b> $ <?php printf("%.2f", $netprice ); ?></li>
                    
                    
                <li><b>Time:</b><label > <?php echo date('F j, Y @ h:i A',strtotime($result['PaymentHistory']['booked_start_time']));?><br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>to</b> <?php echo date('F j, Y @ h:i A',strtotime($result['PaymentHistory']['booked_end_time']));?></label></li>
                    
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
                <input type="hidden" class="studentName" value="<?php echo $result['student']['userMeta']['fname']." ".$result['student']['userMeta']['lname'];?>" />
                <input type="hidden" class="sendSubject" value="Session Request Course : <?php echo $result['PaymentHistory']['booked_course'];?>" />
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
	
    
    
    		
    
    