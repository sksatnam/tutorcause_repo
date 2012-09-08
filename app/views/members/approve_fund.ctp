<div class="middleContainer">
	 <div class="classifiedheading">
	 <div style="float:left; width:916px; margin:15px 0; border:1px solid #ccc; border-radius:5px; -moz-border-radius:5px; padding: 20px;">
		<h3>Approve Status</h3>
		<div style="clear: both;"></div>
		<div class="faqsx" style="width:900px;font-size:12px;">
			<div class="tinymcestaticdata">
				<?php $color ="red"; ?>
				<?php
				if($status == "login"){
					$text = "Currently you are not logged in. Please login and retry.";
				}else if($status == "wrongcode"){
					$text = "You have entered wrong activation key.";
				} else if($status == "errorinquery"){
					$text = "An Error Occured! Please try after some time.";
				} else if($status == "alreadyVerified"){
					$text = "Activation code is already verified! Please check your account balance.";
				} else if($status == "success"){
					$text = "You have successfully activated your amount.";
					$color ="blue";
				}
				?>
				<div style="width:100%;border:1px solid #CCC; padding:10px;font-size:14px;text-align:center;color:<?php echo $color; ?>;"><b><?php echo $text;?></b></div>
			</div>
		</div>
	</div>
	</div>
</div>