<script type="text/javascript">
$(document).ready(function () {
	$('#menu').tabify();
	$('#menu2').tabify();
	
	
	$( "#dialog-form2" ).dialog({
		autoOpen: false,width: 400,modal: true,buttons:{
			Cancel: function() {
				$( this ).dialog("close");
			}
			}
	});
	
	

	
	$( "#dialog-form1" ).dialog({
		autoOpen: false,width: 400,modal: true,buttons:{
			"Reply": function() {
				sendMessage1();
				
			},
			Cancel: function() {
				$( this ).dialog("close");
			}
		}
	});
	
	$(".msg-content").live('click',function() {
//		$(this).parent().addClass('read');
         
		$(this).children('div:last').removeClass('unread').addClass('read'); 
		
/*		$(this).children('div:last').addClass('read');*/
		
		$('#replymessage').val("");
		
		
/*		alert($(this).children('div').children('div').children('input.conversation').val());
		return false;
*/
		
		$('#msg_con_id').val($(this).children('div').children('div').children('input.conversation').val());
		$('#msg_from_id').val($(this).children('div').children('div').children('input.confromid').val());
		$('.modal_subject').html($(this).find('.msg_subject').html());
		$('.modal_subject2').html($(this).find('.msg_subject').html());
		
		
		
		var msgFrom = $(this).children('div').children('div').children('input.confromid').val();
		
		
		
		/*alert(msgFrom);
		return false;*/
		
		
		
		
		
		
		/*$('#msg_from_id').val($(this).children('div').children('div').children('input.confromid').val());
		$('#msg_con_id').val($(this).parent().parent().find('.conversation').val());
		$('#msg_from_id').val($(this).parent().parent().find('.confromid').val());
		$('.modal_subject').html($(this).find('.msg_subject').html());*/
		
		$.ajax({
		   type: "POST",
		   url: ajax_url+"/members/conversation",
		   data: "conversation="+$('#msg_con_id').val(),
		   success: function(msg){
			$('#msg_con_box').html(msg);
			$('#msg_con_box2').html(msg);

		//	var msgBox = $('#msg_con_box');
			
				if(msgFrom=='1')
				{
					$("#dialog-form2").dialog("open");
				}
				else
				{
					$("#dialog-form1").dialog("open");
				}
		
			/*$("#dialog-form2").dialog("open");*/
			
			//msgBox.animate({ scrollTop: msgBox.attr("scrollHeight") - 200 }, 3000);
		   }
		 });
	});
});
function sendMessage1(){
	//var message = 
	
/*	var loadurl = ajax_url+"/members/messages";*/
	
	var originalContent = $('#replymessage').val().length;
	var afterStrip = $('#replymessage').stripTags().val().length;

	
	if(parseInt(afterStrip)!= parseInt(originalContent)){
		alert("HTML content not allowed!");
	}
	else if($.trim($('#replymessage').stripTags().val())===""){
		alert("Please enter message");
	} else {
		var my =$('#replymessage').val();
		var value = $("#replymessage").val();
		var my_data = value.replace(/&/g,'AENUYTREBGF');

		var queryString = "&fromid="+ $('#msg_from_id').val()+"&conversation="+$('#msg_con_id').val()+"&subject="+$('.modal_subject').html()+"&message="+my_data;
		//alert(queryString);
		
		$.ajax({
			type: "POST",
			url: "send_message",
			data: queryString,
			success: function(response){
				
			/*	$('.center-col').load(loadurl);*/
				
				$("#dialog-form1").dialog("close");
				$('.modal_msg').html(response);
				$( ".modal_msg" ).dialog({
					autoOpen: false,width: 400,modal: true,buttons:{
						"Ok": function(){
							$( this ).dialog("close");
							
						}
					}
				});
				$(".modal_msg").dialog("open");
			}
		});
	}
	
}
</script>
<style type="text/css" media="screen">
#dialog-form2{display:none;}
/*
	body { font: 0.8em Arial, sans-serif; }
	#dialog-form1{display:none;}
	.modal_conatiner{padding:20px 10px 0px 10px;}
	.modal_conatiner ul{padding:0px;margin:0px;}
	.modal_conatiner ul li{margin:5px 5px;list-style:none;padding:4px}
	.modal_left{width:65px;text-align:right;font-weight:bold;float:left}
	.modal_right{margin-left:10px;float:left;width:235px;}
	.modal_text,.modal_area{width:230px;padding:1px;border:1px solid #3E89C1}
	.modal_text{height:20px;}
	.modal_area{height:40px; width:304px;}
	.modal_msg{text-align:center;border:1px solid #3E89C1;background-color:#EFF5FA;height:20px;padding:3px;color:#265679;font-weight:bold;display:none;margin-top:10px}*/
	hr{color:#0F78AA; border:1px dashed #0F78AA;}
	.msg-container{background:#FBFEFF; border:1px solid #287BA4; padding:7px;margin:10px 0px;}
	.msg-image{max-width:60px;max-height:50px; border:1px solid #ccc; float:left;}
	.msg-content{width:250px; overflow:hidden;height:50px; float:left; margin-left:10px;}
	.msg-title{width:250px; float:left;}
	.msg-body{width:250px; float:left; }
	.unread{color:#282828; font-size:14px; font-family: Myriad Pro;}
	.read{color:#949494; font-size:14px;}
	.msg_subject{cursor:pointer;font-weight:bold;}
	#msg_con_box{height:200px;overflow:auto;margin:10px 0px 10px 0px}
	div .msg-form{width:395px; margin-left:5px;}
</style>


<div id="content-wrap"  class="fontNew">
<?php	echo $this->Session->flash(); ?>
  <h1> Inbox
  
   <?php
	
 /*   	if($this->Session->read('Member.group_id')==6)
		{
			echo 'Non-Profit Message';
		}
		else if($this->Session->read('Member.group_id')==7)
		{
			echo 'Tutor Message';
		}
		else if($this->Session->read('Member.group_id')==8)
		{
			echo 'Student Message';
		}
		else if($this->Session->read('Member.group_id')==9)
		{
			echo 'Parent Message';
		}
*/
?>
  </h1>
  <div id="tutor-wrap"> 
    <?php
	
    	if($this->Session->read('Member.group_id')==6)
		{
			echo $this->element('frontend/causeLeftSidebar');
		}
		else if($this->Session->read('Member.group_id')==7)
		{
			echo $this->element('frontend/tutorLeftSidebar');
		}
		else if($this->Session->read('Member.group_id')==8)
		{
			echo $this->element('frontend/studentLeftSidebar');
		}
		else if($this->Session->read('Member.group_id')==9)
		{
			echo $this->element('frontend/parentLeftSidebar');
		}
	?>
    
    
    <!--Center Column Begin Here-->
    <div class="center-col">
    
        <div class="msg-form">
            <div id="pagingDivParent">
                <?php echo $this->element('frontend/members/message'); ?>
            </div>
        </div>
    
    </div>
    <!--Center Column End Here-->

    
        
        <?php
    	if($this->Session->read('Member.group_id')==6)
		{
			echo $this->element('frontend/causeRightSidebar');
		}
		else if($this->Session->read('Member.group_id')==7)
		{
			echo $this->element('frontend/tutorRightSidebar');
		}
		else if($this->Session->read('Member.group_id')==8)
		{
			echo $this->element('frontend/studentRightSidebar');
		}
		else if($this->Session->read('Member.group_id')==9)
		{
			echo $this->element('frontend/parentRightSidebar');
		}
		?>
    </div>
</div>
<div id="dialog-form1" title="Conversation">
	<div class="modal_conatiner">
    <form action="members/send_message" id="messageid" method="post">
		<ul>
			<li style="margin:10px 0px; !important;">
				<div class="modal_left" style="width:47px !important;">Subject:</div>
				<div class="modal_right modal_subject">&nbsp;</div>
				<input type="hidden" id="msg_con_id" />
				<input type="hidden" id="msg_from_id" />
				<div class="clear"></div>
			</li>
			<hr/>
			<div id="msg_con_box" scrollHeight="1000">
			</div>
			<hr />
			<li style="margin:10px 0px; !important;">
				<div class="modal_left" style="width:37px !important;">Reply:</div>
				<div class="modal_right"><textarea class="modal_area" id="replymessage"></textarea></div>
				<div class="clear"></div>
			</li>
			
		</ul>
        </form>
	</div>
	<div class="modal_msg" title="Message Sent"></div>
</div>


<div id="dialog-form2" title="Welcome">
	<div class="modal_conatiner">
		<ul>
			<li style="margin:10px 0px; !important;">
				<div class="modal_left" style="width:47px !important;">Subject:</div>
				<div class="modal_right modal_subject2">&nbsp;</div>
				<div class="clear"></div>
			</li>
			<hr/>
			<div id="msg_con_box2" scrollHeight="1000">
			</div>
            <hr />
			
			
		</ul>
	</div>
	
</div>
<?php //3aug2012 ?>