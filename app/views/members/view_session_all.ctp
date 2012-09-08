<?php
/*echo '<pre>';
print_r($mystudent);
die;*/

?>

<script type="text/javascript">
$(document).ready(function(){
						   
						   
			$(".sendMessage").live("click",function() {
													
			/*	alert($(this).parent().parent().find('.resultId').val());
				alert($(this).parent().parent().find('.resultName').val());
				
				return false;*/
													
													
			$('#subject').val('');
			$('#message').val('');				
			$('#toTutId').val($(this).parent().parent().find('.resultId').val());
			$('#toTutName').html($(this).parent().parent().find('.resultName').val());
			$("#dialog-form1").dialog("open");
			});	
			
			
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
			
						   
						   
						   
						   });
</script>
						   



 <div id="content-wrap">
 
 <?php	echo $this->Session->flash(); ?>
 
              <h1>View All Session</h1>
              <div id="tutor-wrap"> 
                
                <!--Left Sidebar Begin Here-->
                <?php  echo $this->element('frontend/parentLeftSidebar'); ?>
                <!--Left Sidebar End Here--> 
                
                <!--Center Column Begin Here-->
                <div class="center-col">
                
                <?php foreach($mystudent  as $result){?>
                <div class="dp_main">
                <div class="dp_img">
                
                <?php
                if($result['Student']['showImage'])
                {
                
                if($result['Student']['image_name']){
                echo $html->image("members/thumb/".$result['Student']['image_name']);
                } else {
                ?><img src="https://graph.facebook.com/<?php echo $result['Student']['facebookId']; ?>/picture?type=large"  />
                <?php }
                }
                else
                {
                echo $html->image("profile-photo.png");
                }
                ?>
                </div>
                <div class="dp_right">
                <div class="dp_info" style="height:auto;">
                <ul>
                    <li><b>Student Name:</b><?php echo $result['Student']['userMeta']['fname'].' '.$result['Student']['userMeta']['lname'];?></li>
                    <li><b>Location:</b><?php 
                    if($result['Student']['userMeta']['city'])
                    {
                    echo $result['Student']['userMeta']['city'].',';
                    }?>  <?php echo $result['Student']['userMeta']['state'];?></li>
                </ul>
                </div>
                
                <div class="student-btns">
                <div class="add-funds"><a href="<?php echo HTTP_ROOT.'members/view_session_student/'.$result['ParentStudent']['student_id'];?>">View Session</a></div>
                
                
                <div class="pay-session"><a href="#" class="sendMessage">Send Message</a></div>
                
                <input type="hidden" class="resultId" value="<?php echo $result['Student']['id'];?>" />
				<input type="hidden" class="resultName" value="<?php echo $result['Student']['fname'].' '.$result['Student']['lname'];?>" />
                
                
                </div>
                
                
                </div>
                <div style="clear:both"></div>
                </div>
                <?php } if(count($mystudent)==0)
                {
                ?>
                <p style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px;padding-top: 5px; padding-left: 5px; text-align:center;"><b>No Record Found</b></p>
                <?php
                }
                ?>  
                
                    
                
                </div>
                <!--Center Column End Here--> 
                
                <!--Right Sidebar Begin Here-->
                <?php  echo $this->element('frontend/parentRightSidebar'); ?>
                <!--Right Sidebar End Here--> 
                
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
				<div class="modal_left">Subject:<span class="red" style="color:#FF0000; margin-left:3px;" >*</div>
				<div class="modal_right"><input type="text" class="modal_text" id="subject" /></div>
				<div class="clear"><input type="hidden" id="tutor" /></div>
			</li>
			<li>
				<div class="modal_left">Message:<span class="red" style="color:#FF0000; margin-left:3px;" >*</div>
				<div class="modal_right"><textarea class="modal_area" id="message"></textarea></div>
				<div class="clear"></div>
			</li>
			
		</ul>
	</div>
	<div class="modal_msg" title="Message Sent"></div>
</div>
 
 
 
 