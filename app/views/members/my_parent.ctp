<?php
/*echo '<pre>';
print_r($parentResult);
die;*/

?>

<script type="text/javascript">	
$(document).ready(function () {
	
	$('.removeParent').live("click",function(){
		var request = $(this);
		$('#dialogdeleterequest').dialog({
			autoOpen: true,
			title:"Confirm your request",
			width: 600,
			modal:true,
			buttons: {
				"Yes": function() {
					//$('#form1').submit();
					request.parent().parent().parent().parent('form').submit();
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
	
			$(".sendMessage").live("click",function() {
													
			/*	alert($(this).parent().parent().find('.resultId').val());
				alert($(this).parent().parent().find('.resultName').val());
				
				return false;*/
													
													
			$('#subject').val('');
			$('#message').val('');				
			var abc = $('#toTutId').val($(this).prev().parent().parent().parent().find('.resultId').val());
			var abc1 = $('#toTutName').html($(this).prev().parent().parent().parent().find('.resultName').val());
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
 
              <h1>Parent Request</h1>
              <div id="tutor-wrap"> 
                
                <!--Left Sidebar Begin Here-->
                <?php  echo $this->element('frontend/studentLeftSidebar'); ?>
                <!--Left Sidebar End Here--> 
                
                <!--Center Column Begin Here-->
                <div class="center-col">
                
                <?php foreach($myparent  as $result){?>
                <div class="dp_main">
                <div class="dp_img">
                
                <?php
                if($result['Parent']['showImage'])
                {
                
                if($result['Parent']['image_name']){
                echo $html->image("members/thumb/".$result['Parent']['image_name']);
                } else {
                ?><img src="https://graph.facebook.com/<?php echo $result['Parent']['facebookId']; ?>/picture?type=large"  />
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
                <li><b>Parent Name:</b><?php echo $result['Parent']['fname'].' '.$result['Parent']['lname'];?></li>
                <li><b>Location:</b><?php 
                if($result['Parent']['userMeta']['city'])
                {
                echo $result['Parent']['userMeta']['city'].',';
                }?>  <?php echo $result['Parent']['userMeta']['state'];?></li>
                </ul>
                </div>
                <?php echo $this->Form->create('Member',array('id'=>'form1')); ?>
                <div class="dp_action">
                <input type="hidden" name="data[Member][id]"  value="<?php echo $result['ParentStudent']['id'];?>" />
                	<span><!--<input type="button" name="data[Member][remove]" value="Remove" class="removeParent"  />-->
                            <div  id="submitbutton" class="stepFormContButton button" style="margin-left:16px;">
                            <span style="width:10px;"></span>
                            <input type="button" value="Remove" name="data[Member][remove]" class="removeParent" style="padding-right:10px;"> 
                            </div>
                            </span>
                            
             			   <span><!--<input type="button" name="data[Member][sendmsg]" value="Send Message" class="sendMessage"  />-->
             			 	 <div  id="submitbutton" class="stepFormContButton button" style="margin-left:0px;">
								<span style="width:10px;"></span>
								<input type="button" value="Send Message" name="data[Member][sendmsg]" class="sendMessage" style="padding-right:10px;"> 
							</div></span>
                
                <input type="hidden" class="resultId" value="<?php echo $result['Parent']['id'];?>" />
				<input type="hidden" class="resultName" value="<?php echo $result['Parent']['fname'].' '.$result['Parent']['lname'];?>" />
                
                </div>
                <?php echo $this->Form->end(); ?>
                </div>
                <div style="clear:both"></div>
                </div>
                <?php } if(count($myparent)==0)
                {
                ?>
                <p style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px;padding-top: 5px; padding-left: 5px; text-align:center;"><b>No Record Found</b></p>
                <?php
                }
                ?>            
                
                </div>
                <!--Center Column End Here--> 
                
                <!--Right Sidebar Begin Here-->
                <?php  echo $this->element('frontend/studentRightSidebar'); ?>
                <!--Right Sidebar End Here--> 
                
              </div>
 </div>
 
<div id="dialogdeleterequest" title="Dialog Title" style="display:none;">
	<p>Click on Yes to <span style="color:#F00" >Remove</span> Parent </p>
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
<?php //3aug2012 ?>