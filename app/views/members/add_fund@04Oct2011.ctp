<style type="text/css">
.error{padding-left:269px;}
.dp_main{margin:15px 10px 15px 10px;border:1px solid #A0D7F3;background-color:#FAFDFE}
.dp_img{float:left;margin:12px;border:1px solid #CcC;padding:2px;background-color:#FFF;min-width:30px;min-height:30px;}
.dp_img img{max-width:100px;max-height:120px}
.dp_right{float:left;width:283px;margin:12px;background-color:#FFF}
.dp_info{height:80px;border:1px solid #CcC}
.dp_info li{list-style:none;margin:4px 2px 2px 15px}
.dp_action{margin-top:10px;}
</style>
<div id="content">
	<?php echo $this->Session->flash(); ?>
	<div class="stepsHeadingNew">
		<div class="newProgressBarOuter">
			<div class="<?php if($step=="step1"){ echo "proBarsSection3"; } else { echo "proBarsSection1"; } ?>">
				<span class="spanNo">1</span>
				<span class="spanOnHover">Student Info</span>
			</div>
			<!--<div class="proBarsSection3">
				<span class="spanNo">2</span>
				<span class="spanOnHover">Verify Student</span>
			</div>-->
			<div class="<?php if($step=="step2"){ echo "proBarsSection3"; } else { echo "proBarsSection1"; } ?>" style="width:250px;">
				<span class="spanNo">2</span>
				<span class="spanOnHover">Select Price & Payement Method</span>
			</div>
			<div class="<?php if($step == "step3"){ echo "proBarsSection3"; } else { echo "proBarsSection1"; } ?>">
				<span class="spanNo">3</span>
				<span class="spanOnHover">Payment</span>
			</div>
		</div>
	</div>
	<?php if($step == "step1"){ ?>
		<h1>Student Info</h1>
		<div class="stepForm">
			<?php echo $this->Form->create('Member',array('id'=>'MemberStep1','action'=>'add_fund/'.$step)); ?>
			<div class="stepFormRow">
				<label>Student Email</label>
				<input class="textInStepFrm required email" type="text" name="data[Member][studentEmail]" id="studentEmail" />
			</div>
			<div class="stepFormContButton button" style="margin:0px 0px 0px 440px;">
				<span></span>
				<input type="submit" value="Continue" /> 
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	<?php }	else if ($step =="step2"){ ?>
		<h1>Select Price & Payement Method</h1>
		<div class="stepForm">
		<?php echo $this->Form->create('Member',array('id'=>'MemberStep3','action'=>'add_fund/'.$step)); ?>
			<div class="stepFormRow">
				<label>Ammount (USD)</label>
				<input class="textInStepFrm digits" type="text" name="data[Member][amount]" />
			</div>
			<div class="stepFormRow">
				<label>Choose Payment Method</label>
				<select id="paymentChoose" class="selectStepFrm" name="data[Member][method]">
					<option>Paypal</option>
				</select>
			</div>
			<div class="stepFormContButton button" style="margin:0px 0px 0px 440px;">
				<span></span>
				<input type="submit" value="Continue" /> 
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	<?php } else if($step=="step3"){ ?>
		<h1>Payment</h1>
		<div class="stepForm">
			<div class="stepFormRow">
				<label>Amount: </label>
				<label style="text-align:left;"><?php echo $this->Session->read('payment.amount');?> USD</label>
				
			</div>
			<div style="margin-left:300px;">
			<form action="<?php echo PAYPALURL;?>" method="post" id="payPalForm">
				<input type="hidden" name="cmd" value="_xclick" />
                <input type="hidden" name="cpp_header_image" value="<?php echo HTTP_ROOT;?>app/webroot/img/frontend/tutor_cause.png" ?>"			<input type="hidden" name="item_name" value="Tutoring">
				<input type="hidden" name="no_note" value="1" />
				<input type="hidden" name="business" value="<?php echo PAYPALEMAIL;?>" />
				<input type="hidden" name="currency_code" value="USD" />
				<input name="amount" type="hidden" id="amount" size="45" value="<?php echo $this->Session->read('payment.amount');?>" />
				<?php
					$url = HTTP_ROOT.'members/fund_add/'.$this->Session->read('payment.paymentId');
				?>
				<input type="hidden" name="notify_url" value="<?php echo $url;?>" />
				<input type="hidden" name="return" value="<?php echo HTTP_ROOT?>homes/success" />
				<input type="hidden" name="cancel_return" value="<?php echo HTTP_ROOT?>homes/failure" />
				<input type="image" src="<?php echo PAYPALINPUT;?>" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" />
				<img alt="" border="0" src="<?php echo PAYPALIMG;?>" width="1" height="1" />
			</form>
			</div>
		</div>
<?php } ?>
</div>        