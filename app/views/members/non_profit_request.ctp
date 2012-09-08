<script type="text/javascript">	
$(document).ready(function () {
	$('#menu').tabify();
	$('#menu2').tabify();
	$('.deleteCause').click(function(){
		var request = $(this);
		$('#dialogdeleterequest').dialog({
			autoOpen: true,
			title:"Confirm your request",
			width: 600,
			modal:true,
			buttons: {
				"Yes": function() {
					//$('#form1').submit();
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
	/*body { font: 0.8em Arial, sans-serif; }

	.dp_main{margin:15px 10px 15px 10px;border:1px solid #A0D7F3;background-color:#FAFDFE}
	.dp_img{float:left;margin:12px;border:1px solid #CcC;padding:2px;background-color:#FFF}
	.dp_img img{max-width:100px;max-height:120px}
	.dp_right{float:left;width:283px;margin:12px;background-color:#FFF}
	.dp_info{height:80px;border:1px solid #CcC}
	.dp_info li{list-style:none;margin:4px 2px 2px 15px}
	.dp_action{margin-top:10px;}
	.dp_action input{border:auto}
	.dp_action span{margin-left:10px}*/
</style>

<div id="content-wrap" class="fontNew">
    <h1>Non-Profit Requests</h1>
    <div id="tutor-wrap"> 
      
      <?php  echo $this->element('frontend/tutorLeftSidebar'); ?>
      
       <!--Center Column Begin Here-->
      <div class="center-col">
      
         			<?php foreach($causeResult as $result){?>
			<div class="dp_main">
				<div class="dp_img">
					<?php
					$countImg = count($result['Cause']['UserImage'])-1;
					if(count($result['Cause']['UserImage'])){
						echo $html->image("members/thumb/".$result['Cause']['UserImage'][$countImg]['image_name'],array('width'=>50,'height'=>50));
					} else {
						echo $html->image("frontend/cause-logo.gif",array('width'=>50,'height'=>50));
					 }
					?>
				</div>
				<div class="dp_right">
					<div class="dp_info" style="height:auto;">
						<ul>
							<li><b>Cause Name:</b><?php echo $result['Cause']['userMeta']['cause_name'];?></li>
							
							<li><b>Location:</b><?php 
							if($result['Cause']['userMeta']['city'])
							{
							echo $result['Cause']['userMeta']['city'].',';
							}?>  <?php echo $result['Cause']['userMeta']['state'];?></li>
						</ul>
					</div>
					<?php echo $this->Form->create('Member',array('id'=>'form1')); ?>
					<div class="dp_action">
						<input type="hidden" name="data[Member][id]"  value="<?php echo $result['TutorRequestCause']['id'];?>" />
						<span><input type="submit" name="data[Member][accept]" value="Accept" /></span>
						<span><input type="button" name="data[Member][denied]" value="Denied" class="deleteCause"  /></span>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
				<div style="clear:both"></div>
			</div>
			<?php }  if(count($causeResult)==0)
			{
			?>
				<p style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px;padding-top: 5px; padding-left: 5px; text-align:center;"><b>No Record Found</b></p>
			<?php
				}
			?>
            
                     </div>
    <!--Center Column End Here-->   


        <?php echo $this->element('frontend/tutorRightSidebar');?>
        
    </div>
</div>
<div id="dialogdeleterequest" title="Dialog Title" style="display:none;">
	<p>Click on Yes to <span style="color:#F00" >Delete</span> Cause request </p>
</div>