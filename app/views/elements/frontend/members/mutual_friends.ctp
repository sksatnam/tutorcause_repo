<div style="border:1px solid #CCC;color:#3B5998;padding:10px;width:350px;text-align:center;overflow:auto;font-size:11px;">
	<?php if(isset($mutualfriends)){ ?>
		<?php foreach($mutualfriends as $mutualfriend){ ?>
			<div style="float:left;width:auto;height:auto;margin:5px;" class="mutualfriend">
				<div style="width:50px;height:50px;border:1px solid #CCC;height:50px;overflow:hidden;padding:2px;">
					<!-- Image here -->
					<a href="<?php echo "http://facebook.com/".$mutualfriend['id']; ?>">
						<?php echo $this->Html->image('https://graph.facebook.com/'.$mutualfriend['id'].'/picture'); ?>
					</a>
				</div>
				<strong>
					<a href="<?php echo "http://facebook.com/".$mutualfriend['id']; ?>" style="color:#3B5998;text-decoration:none;">
						<?php echo $mutualfriend['first_name'];?>
					</a>
				</strong>
			</div>
		<?php } ?>
	<div style="clear:both;"></div>
	<?php } else { ?>
	<div style="background:#CED8EC;height:20px;padding:5px 10px;text-align:center;border:1px solid #6987C5;color:#213254;">
		No mutual friend found
	</div>
	<?php } ?>
    
<input type="hidden" name="url" value="<?php echo $url;?>"     />
</div>