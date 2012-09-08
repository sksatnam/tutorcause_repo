<?php
foreach($msgList as $lists){
	if($lists['TutMessage']['status']==0){
		$msg_type = "unread";
	} else {
		$msg_type = "read";
	}
?>
<div class="msg-container">
	<div class="msg-image">
		<?php
			if(isset($lists['UserImage']['image_name'])){
				echo $html->image("members/".$lists['UserImage']['image_name'],array('class'=>'profile-img-class','style'=>'max-width:60px;max-height:50px'));
			} else {
				echo '<img src="https://graph.facebook.com/'.$lists['Member']['facebookId'].'/picture" />';
			}
		?>
	</div>
	<div class="msg-content">
		<div class="msg-title">
			<div style="width:auto; float:left; color:#0C6189;">
				<b><a href="#"><?php echo $lists['userMeta']['fname'];?></a>
				<label title="Conversation"><?php if($lists[0]['conId']>1){ echo " (".$lists[0]['conId'].")";}?></label></b>
			</div>
			<div style="width:auto; float:right; color:#8d8d8d;font-size:11px;">
				<?php echo date('d-M-y h:i a',strtotime($lists['TutMessage']['datetime']));?>
				<input type="hidden" class="conversation" value="<?php echo $lists['TutMessage']['conversation_id'];?>" />
				<input type="hidden" class="confromid" value="<?php echo $lists['TutMessage']['from_id'];?>" />
			</div>
		</div>
		<br class="clear" />
		<div class="msg-body <?php echo $msg_type; ?>">
			<span class="msg_subject"><?php echo htmlspecialchars($lists['TutMessage']['subject']);?></span><br /><?php echo htmlspecialchars($lists['TutMessage']['message']);?>
		</div>
	</div>
	<div class="clear"></div>
</div>
<?php } ?>
<!-- pagination starts -->
<div class="paging" id="users-paging-view" style="text-align:center;">
	<?php echo $paginator->prev('<< '.__('Previous', true), array(), null, array('class'=>'disabled'));?>
	<?php echo $paginator->numbers(array('separator' => false));?>
	<?php echo $paginator->next(__('Next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div style="background-color:#F0F0EE;border:1px solid grey;text-align:center;"><a><?php echo $paginator->counter(array('format' => '<b>Currently showing</b> %start%-%end%, <b>Total Pages</b> = %pages%, <b>Total results</b> = %count%'));?> </a></div>	
<!-- pagination ends -->