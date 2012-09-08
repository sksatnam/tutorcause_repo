
<div style="text-align:right;margin:4px 5px 0px 0px">
	<label class="closeDiv">Close</label>
</div>
<div style="padding:5px 10px;" class="payDiv">
	<ul>
		<li>
			<div class="amountLeft">Request ID</div>
			<div class="amountCenter">&nbsp;</div>
			<div class="amountRight"><?php echo $withdrawalDetail['TutorWithdrawal']['request_id'];?></div>
			<div class="clear"></div>
		</li>
		<li>
			<div class="amountLeft">Account Balance</div>
			<div class="amountCenter">&nbsp;</div>
			<div class="amountRight">$<?php echo $withdrawalDetail['TutorWithdrawal']['tutor_creditable_amount'];?></div>
			<div class="clear"></div>
		</li>
		<li>
			<div class="amountLeft">Tutor Cause Fees</div>
			<div class="amountCenter"><?php echo $charge;?>%</div>
			<div class="amountRight">$<?php echo $withdrawalDetail['TutorWithdrawal']['tutor_creditable_amount'] * $charge_percent;?></div>
			<div class="clear"></div></li>
		<li>
			<div class="amountLeft">Grand Total Amount</div>
			<div class="amountCenter">&nbsp;</div>
			<div class="amountRight">$<?php echo $withdrawalDetail['TutorWithdrawal']['tutor_creditable_amount']- ($withdrawalDetail['TutorWithdrawal']['tutor_creditable_amount']) * $charge_percent;?></div>
			<div class="clear"></div></li>
		</li>
	</ul>
	
</div>
<?php if(count($withdrawalCharity)>0){ $totalCharity=""; ?>
<div class="PayCharity">
	<ul>
		<li class="liLeft liHead">Charity Name</li>
		<li class="liMiddle liHead">Grant %</li>
		<li class="liRight liHead">Amount</li>
		<br class="clear"/>
	</ul>
	<?php foreach($withdrawalCharity as $charity){ ?>
	<ul>
		<li class="liLeft"><?php echo $charity['Member']['userMeta']['fname']."&nbsp;".$charity['Member']['userMeta']['lname'];?></li>
		<li class="liMiddle"><?php echo $charity['TutorToCause']['cause_grant'];?> %</li>
		<li class="liRight"><?php echo $charity['TutorToCause']['cause_amount'];?></li>
		<br class="clear"/>
	</ul>
	<?php $totalCharity = $totalCharity+$charity['TutorToCause']['cause_amount']; ?>
	<?php } ?>
</div>

<div style="padding:5px 10px;" class="payDiv">
	<ul>
		<li>
			<div class="amountLeft">Total Charity Amount</div>
			<div class="amountCenter">&nbsp;</div>
			<div class="amountRight">$<?php echo $totalCharity;?></div>
			<div class="clear"></div>
		</li>
		<li>
			<div class="amountLeft">Balance</div>
			<div class="amountCenter">&nbsp;</div>
			<div class="amountRight">$<?php echo $withdrawalDetail['TutorWithdrawal']['tutor_payable_amount']; ?></div>
			<div class="clear"></div>
		</li>
	</ul>
</div>
<?php } ?>