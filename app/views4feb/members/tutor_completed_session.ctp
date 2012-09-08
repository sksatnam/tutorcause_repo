<script type="text/javascript">
$(document).ready(function() {
	$('.rate1').rating('rating/?by=knowledge', {maxvalue:5});
	$('.rate2').rating('rating/?by=ability', {maxvalue:5});
});
</script>
<script type="text/javascript">	
$(document).ready(function () {
							
							
/*	$('#menu').tabify();
	$('#menu2').tabify();
*/	
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
/*	.dp_main{margin:15px 10px 15px 10px;border:1px solid #A0D7F3;background-color:#FAFDFE}
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

<div id="content-wrap" class="fontNew">
    <h1>View Completed</h1>
    <div id="tutor-wrap"> 
      
      <?php  echo $this->element('frontend/tutorLeftSidebar'); ?>
      
       <!--Center Column Begin Here-->
      <div class="center-col">
      
      		<div id="pagingDivParent">
                <?php echo $this->element('frontend/members/tutor_completed_session'); ?>
            </div>
            
        </div>
    <!--Center Column End Here-->            
  
        <?php echo $this->element('frontend/tutorRightSidebar'); ?>
        
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