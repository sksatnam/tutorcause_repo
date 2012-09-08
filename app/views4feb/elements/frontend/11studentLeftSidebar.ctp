<div class="public_profile_cointainer_Ist">
	<div style="margin:20px 5px 5px 20px;text-align:left;">
		<div style="clear:both"></div>
		<div class="profileImage" style="padding:1px;border:1px solid #ACDFFB;height:auto;margin-bottom:10px;">
			<?php
				//print_r($picture);exit;
				if(isset($picture) && !empty($picture)){
					echo $html->image("members/".$picture['UserImage']['image_name'],array('style'=>'margin:0;float:none;width:auto;max-width:180px;'));
				} else {
					?>
						 <img src="https://graph.facebook.com/<?php echo $this->Session->read('Member.id'); ?>/picture?type=large" style="margin:0;float:none;width:auto;max-width:180px;" />
				 <?php        
				}
			?>
		</div>
		<div style="clear:both"></div>
		<div id="errorMsg"></div>
		<div class="imageChange">Change Profile Picture</div>
	</div>
	<!--<a href="#" >Send Message </a><br />-->
	<div class="leftSideDiv">
		<ul>
			<li>
				<div class="sideFirst">
					<?php echo $html->image('frontend/message.jpg',array('style'=>'width:20px;height:20px;'))?>
				</div>
				<div class="sideSecond">
					<?php echo $html->link('Message ('.$countMsg.')',array('controller'=>'members', 'action'=>'messages'));?>
				</div>
				<div class="clear"></div>
			</li>
			
			<li>
				<div class="sideFirst">
					<?php echo $html->image('frontend/edit_profile.png',array('style'=>'width:20px;height:20px;'))?>
				</div>
				<div class="sideSecond">
					<?php echo $html->link('Edit Profile',array('controller'=>'members', 'action'=>'regmember',$this->Session->read('Member.memberid')));?>
				</div>
				<div class="clear"></div>
			</li>
			
			<li>
				<div class="sideFirst">
					<?php echo $html->image('frontend/school_icon.gif',array('style'=>'width:20px;height:20px;'))?>
				</div>
				<div class="sideSecond">
					<?php echo $html->link('Change School',array('controller'=>'members', 'action'=>'student_schoolinfo'));?>
				</div>
				<div class="clear"></div>
			</li>
			
			<li>
				<div class="sideFirst">
					<?php echo $html->image('frontend/approval.jpg',array('style'=>'width:20px;height:20px;'))?>
				</div>
				<div class="sideSecond">
					<?php echo $html->link('Awaiting Approval  ('.$awaitingRequest.')',array('controller'=>'members', 'action'=>'student_approval_awaiting'));?>
				</div>
				<div class="clear"></div>
			</li>
			
			<li>
				<div class="sideFirst">
					<?php echo $html->image('frontend/payment_icon.gif',array('style'=>'width:20px;height:20px;'))?>
				</div>
				<div class="sideSecond">
					<?php echo $html->link('Awaiting Payment ('.$paymentRequest.')',array('controller'=>'members', 'action'=>'student_payment_awaiting'));?>
				</div>
				<div class="clear"></div>
			</li>
			
			<li>
				<div class="sideFirst">
					<?php echo $html->image('frontend/session.png',array('style'=>'width:20px;height:20px;'))?>
				</div>
				<div class="sideSecond">
					<?php echo $html->link('Upcoming Sessions ('.$upcomingRequest.')',array('controller'=>'members', 'action'=>'student_upcoming_session'));?>
				</div>
				<div class="clear"></div>
			</li>
			
			<li>
				<div class="sideFirst">
					<?php echo $html->image('frontend/completed.png',array('style'=>'width:20px;height:20px;'))?>
				</div>
				<div class="sideSecond">
					<?php echo $html->link('Completed Sessions ('.$completedRequest.')',array('controller'=>'members', 'action'=>'student_completed_session'));?>
				</div>
				<div class="clear"></div>
			</li>
		</ul>
	</div>
</div>