<div class="public_profile_cointainer_IIIrd">
	<div style="border: 2px solid rgb(204, 204, 204); margin-bottom: 35px;">
		<div style="background-color: #168fd0; border-bottom: 2px solid rgb(204, 204, 204); color: rgb(238, 238, 238); font-family: verdana,tahoma,sans-serif; font-size: 14px; font-weight: bold; padding: 3px 15px; text-align: center;">Account Balance</div>
		<div style="background-color: rgb(238, 238, 238); color: rgb(0, 153, 0); font-family: verdana,tahoma,trebuchet MS,helvetica,sans-serif; font-size: 28px; padding: 5px;">
		  <div style="background-color: rgb(255, 255, 255); -moz-border-radius: 8px 8px 8px 8px; padding: 0px 5px 5px; text-align: center;">$<?php echo $getBalance['Member']['creditable_balance'];?></div>
		</div>
		<div style="margin:10px;text-align:center;"><a href="<?php echo HTTP_ROOT?>members/add_fund" style="color:#1D5894">Add Funds</a></div>
	</div>
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
		action: ajax_url+"/Members/imgUpload",
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
				window.location = "<?php echo HTTP_ROOT."members/student_dashboard";?>";
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