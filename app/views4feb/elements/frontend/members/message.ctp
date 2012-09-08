<?php
/*echo '<pre>';
print_r($msgList);
die; 
*/
foreach($msgList as $lists){
	if($lists[0]['stas']==0){
		$msg_type = "unread";
	} else {
		$msg_type = "read";
	}
?>
<div class="msg-container">
	<div class="msg-image">
		<?php
		  if($lists['Member']['showImage'])
			{

				if(isset($lists['UserImage']['image_name'])){
					echo $html->image("members/".$lists['UserImage']['image_name'],array('class'=>'profile-img-class','style'=>'max-width:60px;max-height:50px'));
				} else {
				?>	
				<img src="https://graph.facebook.com/<?php echo $lists['Member']['facebookId'];?>/picture?type=large" style="max-width:60px; max-height:50px;"  />	
				<?php    
				}
			}
		  else
			{
				echo $html->image("profile-photo.png",array('class'=>'profile-img-class','style'=>'max-width:60px;max-height:50px'));
			}	 
			
		?>
	</div>
    
    
	<div class="msg-content">	
    	<div class="msg-title">
			<div style="width:auto; float:left; color:#0C6189;">
				<b><a href="#"><?php echo $lists['userMeta']['fname'];?></a>
				<label title="Conversation"><?php /*if($lists[0]['conId']>1){ */
				echo " (".$lists[0]['conId'].")";
				/*}*/?></label></b>
			</div>
			<div style="width:auto; float:right; color:#8d8d8d;font-size:11px;">
				<?php echo date('F j, Y @ h:i A',strtotime($lists['TutMessage']['datetime']));?>
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
<?php }
if(count($msgList))
{
?>
<!-- pagination starts -->
<div class="paging" id="users-paging-view">
    <?php // echo $paginator->first();?>
    
   <?php // echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>
    
	<?php echo $paginator->prev(' '.__('Prev Page', true), array(), null, array('class'=>'disabled'));?> 
   	<?php //  echo $paginator->numbers(array('separator' => false));?>
    
    <span style="float:left; margin-right: 2px; padding: 3px 4px;">|</span>
        
    <?php // echo $paginator->(array('separator' => '|'));?>
	<?php echo $paginator->next(__('Next Page', true).' ', array(), null, array('class' => 'disabled'));?>
    <?php // echo $paginator->last();?>
</div>

<?php
}
else
{
	echo 'No Message.';	
	
}

/*<div style="background-color:#F0F0EE;border:1px solid grey;text-align:center;"><a><?php echo $paginator->counter(array('format' => '<b>Currently showing</b> %start%-%end%, <b>Total Pages</b> = %pages%, <b>Total results</b> = %count%'));?> </a></div>	
*/
?>

<!-- pagination ends -->



