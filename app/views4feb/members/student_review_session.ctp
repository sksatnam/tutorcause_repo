<script type="text/javascript">
$(document).ready(function() {
	$('.rate1').each(function(){
		$(this).rating('rating/?by=knowledge', {maxvalue:5});
	});
	$('.rate2').each(function(){
		$(this).rating('rating/?by=ability', {maxvalue:5});
	});
});
</script>
<script type="text/javascript">	
$(document).ready(function () {
	$('#menu').tabify();
	$('#menu2').tabify();
	//Diolog Box
	$( "#dialog-form1" ).dialog({
		autoOpen: false,width: 400,modal: true,buttons:{
			"Send Message": function() {
				sendMessage();
			},
			Cancel: function() {
				$( this ).dialog("close");
			}
		}
	});
	$(".sendMessage").click(function() {
			$('#toTutName').html($(this).parent().next().next().val());
			$('#toTutId').val($(this).parent().next().val());
			var subject = $(this).parent().next().next().next().val();
			$('.StudentSubbject').html(subject);
			$('#subject').val(subject);
			$("#dialog-form1").dialog("open");
	});
});
</script>
<style type="text/css" media="screen">
	/*.dp_main{margin:15px 10px 15px 10px;border:1px solid #A0D7F3;background-color:#FAFDFE}
	.dp_img{float:left;margin:12px;border:1px solid #CcC;padding:2px;background-color:#FFF}
	.dp_img img{max-width:100px;max-height:120px}
	.dp_right{float:left;width:300px;margin:8px;background-color:#FFF}
	.dp_info{height:auto;border:1px solid #CcC}
	.dp_info li{list-style:none;margin:4px 2px 2px 15px}
	.dp_action{margin-top:10px;}
	.dp_action input{border:auto}
	.dp_action span{margin-left:10px}*/
	
	.modal_conatiner{padding:20px 10px;}
	.modal_conatiner ul{padding:0px;margin:0px;}
	.modal_conatiner ul li{margin:10px 5px;list-style:none;}
	.modal_left{width:65px;text-align:right;font-weight:bold;float:left}
	.modal_right{margin-left:10px;float:left;width:235px;}
	.modal_text,.modal_area{width:230px;padding:1px;border:1px solid #3E89C1}
	.modal_text{height:20px;}
	.modal_area{height:90px;}
	.modal_msg{text-align:center;border:1px solid #3E89C1;background-color:#EFF5FA;height:20px;padding:3px;color:#265679;font-weight:bold;display:none;margin-top:10px}
	.clear{clear:both}
	#dialog-form1{display:none;}
	.rating{float:left;clear:none;margin-left:10px;}
</style>

<div id="content-wrap"  class="fontNew">
  <?php	echo $this->Session->flash(); ?>
  <h1>Awaiting Review</h1>
  <div id="tutor-wrap"> 
    
    <?php echo $this->element('frontend/studentLeftSidebar');?>
    
    <!--Center Column Begin Here-->
    <div class="center-col">
    
    <?php foreach($review as $result){?>
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
					</div>
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
                            
                            
							<li style="text-align:center;margin:5px 10px 2px 5px">
								<input type="hidden" value="<?php echo $result['PaymentHistory']['id'];?>" name="data[Member][paymentId]" />
								<input type="hidden" value="<?php echo $result['PaymentHistory']['tutor_id'];?>" name="data[Member][tutorId]" />
                                
                                
								<input type="submit" value="Rate & Release Funds" />
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
			<?php }
			if(count($review)==0)
			{
			?>
			<p style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px;padding-top: 5px; padding-left: 5px; text-align:center;"><b>No Record Found</b></p>
				
			<?php
			}
			
			
			?>
            
             
     </div>
    <!--Center Column End Here-->
        
        
        <?php echo $this->element('frontend/studentRightSidebar'); ?>
        
    </div>
</div>
<div id="dialog-form1" title="Send Message">
	<div class="modal_conatiner">
		<ul>
			<li>
				<div class="modal_left">To:</div>
				<div class="modal_right" id="toTutName"></div>
				<div class="clear"><input type="hidden" id="toTutId" /></div>
			</li>
			<li>
				<div class="modal_left">Subject:</div>
				<div class="modal_right"><label class="StudentSubbject"></label>
					<input type="hidden" class="modal_text" id="subject" />
				</div>
				<div class="clear"><input type="hidden" id="tutor" /></div>
			</li>
			<li>
				<div class="modal_left">Message:</div>
				<div class="modal_right"><textarea class="modal_area" id="message"></textarea></div>
				<div class="clear"></div>
			</li>
			
		</ul>
	</div>
	<div class="modal_msg" title="Message Sent"></div>
</div>