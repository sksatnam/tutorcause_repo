<?php if(isset($content)){ ?>
<?php foreach($content as $contenty){
if($contenty['TutMessage']['to_id']==$this->Session->read('Member.memberid')){
	$liColor="background-color:#F0F8FB;border:1px solid #CAE7F0";
} else {
	 $liColor="background-color:#F5F5F5;border:1px solid #E2E2E2";
}
?>
<li style="<?php echo $liColor;?>">
	<div class="modal_left" style="max-height:50px !important; max-width:60px !important; text-laign:center">
		<?php
			if(isset($contenty['UserImage']['image_name'])){
				echo $html->image("members/thumb/".$contenty['UserImage']['image_name'],array('class'=>'profile-img-class','style'=>'max-width:60px;max-height:50px'));
			} else {
			?>	
			<img src="https://graph.facebook.com/<?php echo $contenty['Member']['facebookId'];?>/picture?type=large" style="max-width:60px; max-height:50px;"  />	
             <?php
			}
		?>
	</div>
	<div class="modal_right" style="width:240px !important;">
		<div style="color:#0F78AA;"><b><?php echo $contenty['userMeta']['fname'];?></b></div>
		<div style="color:#666;"><?php echo htmlspecialchars($contenty['TutMessage']['message']);?></div>
	</div>
	<div class="clear"></div>
</li>
<?php } } ?>