<script type="text/javascript">
function causewithreq()
{
	$('#causewithreq').dialog({
		autoOpen: true,
		title:"Withdrawal Request",
		width: 600,
		modal:true,
		buttons: {
			"Send": function() {
					$(this).dialog("close");	
							var sendurl = '<?php echo HTTP_ROOT;?>members/causewithdrawal';
							window.location = sendurl;
				},
			"Cancel": function() {
				$(this).dialog("close");
			}
		}
	});	

}
</script>



<div class="public_profile_cointainer_IIIrd">
        	<div style="border: 2px solid rgb(204, 204, 204); margin-bottom: 35px;">
				<div style="background-color: #168fd0; border-bottom: 2px solid rgb(204, 204, 204); color: rgb(238, 238, 238); font-family: verdana,tahoma,sans-serif; font-size: 14px; font-weight: bold; padding: 3px 15px; text-align: center;">Account Balance</div>
				<div style="background-color: rgb(238, 238, 238); color: rgb(0, 153, 0); font-family: verdana,tahoma,trebuchet MS,helvetica,sans-serif; font-size: 28px; padding: 5px;">
				  <div style="background-color: rgb(255, 255, 255); -moz-border-radius: 8px 8px 8px 8px; padding: 0px 5px 5px; text-align: center;">$<?php echo $getBalance['Member']['creditable_balance']?></div>
				</div>
                
                  <?php 
				if(isset($pendingrequest))
				{
				?>
                 <div style="margin:10px;text-align:center;"><span style="color:#666;" >Pending Request</span></div>
                
                <?php
				}
				else
				{
				?>
                 <div style="margin:10px;text-align:center;">
                 <?php echo $this->Html->link('Withdrawal Request', 'javascript:causewithreq();', array('style' => 'color:#1D5894')); ?>
                 </div>
               <?php
				}
			   ?>
                
                 
                 
			</div>
        	<!--<div class="public_profile_cointainer_add-1">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>
        	<div class="public_profile_cointainer_add-2">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>
        	<div class="public_profile_cointainer_add-3">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>
        	<div class="public_profile_cointainer_add-1">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>
        	<div class="public_profile_cointainer_add-2">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>
            <div class="public_profile_cointainer_add-3">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>-->
        </div>
        
             <div id="causewithreq" title="Dialog Title" style="display:none;">
            <p>Click on send button to withdrawal money</p>
</div>
        
        
        
        
<script type="text/javascript">
	$(document).ready(function () {
		$('#menu').tabify();
		$('#menu2').tabify();
	});
$(function() {
	var changeImage=$('.imageChange');
	var profileImage=$('.profileImage');
	new AjaxUpload(changeImage,
	{
		action: ajax_url+"/members/imgUpload",
		name: 'userImage',
		onSubmit: function(file, ext)
		{
			if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext)))
			{
				errorMsg('Invalid Image');
				return false;
			}
			$(profileImage).css('background-color','#FFF');
			$(profileImage).empty().append('<?php echo $html->image("loader.gif",array('alt'=>'Processing...','style'=>'width:16px;height:16px;')) ?>');
		},
		onComplete: function(file, response)
		{
			if(response==="success")
			{
				window.location = "<?php echo HTTP_ROOT."members/cause_dashboard";?>";
			}
			else
			{
				errorMsg('An Error Occured');
				return false;
			}
		}
	});
});
function errorMsg(msg){
	$('#errorMsg').html('<span style="color:red;"><b>'+msg+'</b></span>');
	$('#errorMsg').fadeIn().delay(3000).fadeOut();
}
</script>
