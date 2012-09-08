<?php
if($countMsg>0){
	$countMsg = "(".$countMsg.")";
} else {
	$countMsg = "";
}
?>
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
$(document).ready(function(){
	$('.requestRefund').click(function(){
		var request = $(this);
		$('#dialogCancel').dialog({
		autoOpen: true,
		title:"Cancel Request",
		width: 600,
		modal:true,
		buttons: {
			"Yes": function() {
				request.parent().parent().parent('form').submit();
				$(this).dialog("close");
			},
			"No": function() {
				$(this).dialog("close");
				return false;
			}
		}
	});
	return false;
	});
});
</script>
<style type="text/css" media="screen">
/*	.dp_main{margin:15px 10px 15px 10px;border:1px solid #A0D7F3;width:406px;}
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
</style>
    
  <div id="content-wrap"  class="fontNew">
  <?php	echo $this->Session->flash(); ?>
  <h1>Upcomming Session</h1>
  <div id="tutor-wrap"> 
    
    	<?php echo $this->element('frontend/studentLeftSidebar') ?>
        
          <!--Center Column Begin Here-->
    <div class="center-col">
    
    
			
			<!--Display Profile-->
			<?php foreach($upcomingSession as $result){?>
			<?php
				$dateDiff = intval((strtotime($result['PaymentHistory']['booked_start_time']) - time())/(60*60*24));
			?>
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
					<div style="padding:2px;margin:0px 2px;font-weight:bold;font-size:14px; color:#0066FF;" >
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
							<li><b>Location:</b> <?php echo $result['tutor']['userMeta']['city'];?> , <?php echo $result['tutor']['userMeta']['state'];?></li>
							<li><b>Course:</b> <?php echo $result['PaymentHistory']['booked_course'];?></li>
                            
                             <li><b>Hourly Rate:</b> $ </b><?php echo $result['PaymentHistory']['tutor_rate_per_hour'];?></li>
                            <?php
							$nettime = $result['PaymentHistory']['tutoring_hours'];
							$netrate = $result['PaymentHistory']['tutor_rate_per_hour']; 
                            $netprice = $nettime * $netrate;
							?>
                            <li><b>Total Session Cost:</b> $ <?php printf("%.2f", $netprice ); ?></li>
                            
                            
							<li><b>Time:</b><label > <?php echo date('F j, Y @ h:i A',strtotime($result['PaymentHistory']['booked_start_time']));?><br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>to</b> <?php echo date('F j, Y @ h:i A',strtotime($result['PaymentHistory']['booked_end_time']));?></label></li>
						</ul>
					</div>
					<?php echo $this->Form->create('Member',array('id'=>'form1')); ?>
					<div class="dp_action">
						<?php if($dateDiff>=3){ ?>
						<span><label style="color:#1D5894;cursor:pointer" class="requestRefund">Request Refund</label></span>&nbsp;&nbsp;&nbsp;
						<input type="hidden" name="data[Member][refund]" value="refund" />
						<?php } ?>
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
			if(count($upcomingSession)==0)
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
<div id="dialogCancel" title="Dialog Title" style="display:none;">
	<p>Click on Yes to <span style="color:#F00" >Cancel</span> Request </p>
</div>