  
    <!--Display Profile-->
			<?php foreach($completed as $result){?>
			<div class="dp_main">
				<div class="dp_img">
					<?php
					if($result['tutor']['showImage'])
					{
					
					$countImg = count($result['tutor']['UserImage'])-1;
					if(count($result['tutor']['UserImage'])){
						echo $html->image("members/thumb/".$result['tutor']['UserImage'][$countImg]['image_name']);
					} else {
						?><img src="https://graph.facebook.com/<?php echo $result['tutor']['facebookId']; ?>/picture?type=large"  />
					<?php }
					}
					else
					{
						echo $html->image("profile-photo.png");
					}
					?>
				</div>
				<div class="dp_right">
					<div style="padding:2px;margin:0px 2px;font-weight:bold;font-size:14px">
					
					<?php 
					 $tutorname = $result['tutor']['userMeta']['fname'].' '.$result['tutor']['userMeta']['lname'];
                                $urltutor=str_replace(' ','-',$tutorname);
                                $urltutor=str_replace('_','-',$urltutor);
                                $urltutor=$urltutor . '_' . $result['tutor']['id'];
							?>
								 <?php echo $html->link($tutorname ,array('controller'=>'members', 'action'=>'tutor', $urltutor), array('title' => $result['tutor']['userMeta']['fname'] ,'style'=>'color:#1D5894'));?>  
					<?php // echo $result['tutor']['userMeta']['fname']."&nbsp;&nbsp;".$result['tutor']['userMeta']['lname'];?></div>
					<div class="dp_info">
						<ul>
							<li></li>
							<li><a href="http://facebook.com/profile.php?id=<?php echo $result['tutor']['facebookId'];?>" target="_blank">Facebook Profile</a></li>
							<?php /*?><li><b>Location:</b> <?php echo $result['tutor']['userMeta']['city'];?> , <?php echo $result['tutor']['userMeta']['state'];?></li><?php */?>
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
							<li><div style="float:left;"><b style="padding-right: 28px;">Ability:</b></div>
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
                            
                            
                            
                            
							
							<?php } else { ?>
							<li><div style="float:left;"><b>Knowledge:</b></div>
								<div class="rating rate1" style="clear:none;">
									<?php for($i=1;$i<=5;$i++){ ?>
									<div class="star">
										<a title="Give it <?php echo $i;?>" href="#<?php echo $i;?>" style="width: 100%;"><?php echo $i;?></a>
									</div>
									<?php } ?>
								</div>
								<div class="clear"></div>
							</li>
							<li><div style="float:left;"><b  style="padding-right: 28px;">Ability:</b></div>
								<div class="rating rate2">
									<?php for($j=1; $j<=5; $j++){ ?>
									<div class="star">
										<a title="Give it <?php echo $j;?>" href="#<?php echo $j;?>" style="width: 100%;"><?php echo $j;?></a>
									</div>
									<?php } ?>
								</div>
								<div class="clear"></div>
							</li>
							<?php echo $this->Form->create('member',array('action' => 'save_rating')); ?>
                            
                           <li><div style="float:left;"><b>Comments:</b></div>
						     <textarea name="data[Member][comments]" value="" style="height:70px; margin-top:5px;"></textarea>
								<div class="clear"></div>
							</li>
                            
                            
							<li style="text-align:center;margin:2px 10px 2px 2px">
								<input type="hidden" value="<?php echo $result['PaymentHistory']['id'];?>" name="data[Member][paymentId]" />
								<input type="hidden" value="<?php echo $result['PaymentHistory']['tutor_id'];?>" name="data[Member][tutorId]" />
                                
                                
								<input type="submit" value="Submit" />
							</li>
							<?php echo $this->Form->end(); ?>
							<?php } ?>
							
						</ul>
					</div>
					<?php echo $this->Form->create('Member'); ?>
					<div class="dp_action">
						<input type="hidden" name="data[Member][id]"  value="<?php echo $result['PaymentHistory']['id'];?>"  />
						<span><label style="color:#1D5894;cursor:pointer" class="sendMessage">Send Message</label></span>
						<input type="hidden" class="studentId" value="<?php echo $result['tutor']['id']; ?>" />
						<input type="hidden" class="studentName" value="<?php echo $result['tutor']['userMeta']['fname']." ".$result['tutor']['userMeta']['lname'];?>" />
						<input type="hidden" class="sendSubject" value="Session Request - Course : <?php echo $result['PaymentHistory']['booked_course'];?>" />
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
				<div style="clear:both"></div>
			</div>
            
            
         
			<?php
			} 
			if(count($completed)==0)
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