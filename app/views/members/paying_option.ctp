<style>
.proBarsSection2,.proBarsSection1{width:180px;}
</style>
<script type="text/javascript">
	function checkMethod(){
		var netPrice = parseInt($('#netPrice').val());
		var balance = parseInt($('#balance').val());
		var method = $('#selectMethod').val();
		if(method=="credit"){
			if(balance>=netPrice){
				$('#form1').submit();
			} else {
				$('#dialogCancel').dialog({
					autoOpen: true,
					width: 600,
					modal:true,
					buttons: {
						"Get Credit": function() {
							window.location=ajax_url+"/members/add_fund";
							$(this).dialog("close");
						},
						"Cancel": function() {
							$(this).dialog("close");
							return false;
						}
					}
				});
			}
		} else if(method=="paypal"){
			$('#form1').submit();
		}
	}
</script>
<div id="content">
	<div class="stepsHeadingNew">
		<div class="newProgressBarOuter">
			<div class="proBarsSection1">
				<span class="spanNo">1</span>
				<span class="spanOnHover">Schedule Session</span>
			</div>
			<div class="proBarsSection2">
				<span class="spanNo">2</span>
				<span class="spanOnHover">Payment Option</span>
			</div>
			<div class="proBarsSection3">
				<span class="spanNo">3</span>
				<span class="spanOnHover">Pay for Session</span>
			</div>
		</div>
		<h1>Payment Option</h1>
	</div>
	<div class="school-info-field">
		<div class="stepThreeFormRow">
			<label style="font-weight:bold;">Course Code</label>
			<label><?php echo $paydata['PaymentHistory']['booked_course'];?></label> 
		</div>
		<div class="stepThreeFormRow">
			<label style="font-weight:bold;">Hourly Rate</label>
			<label><?php echo '$ '.$paydata['PaymentHistory']['tutor_rate_per_hour'];?></label> 
		</div>
		<div class="stepThreeFormRow" style="width:650px;">
			<label style="font-weight:bold;">Session Start</label>
			<label style="width:auto;"><?php echo date('F, d Y @ G:i a',strtotime($paydata[0]['booked_start_time']));?></label> 
		</div>
		<div class="stepThreeFormRow" style="width:650px;">
			<label style="font-weight:bold;">Session End</label>
			<label style="width:auto;"><?php echo date('F, d Y @ G:i a',strtotime($paydata[0]['booked_end_time']));?></label> 
		</div>
		<div class="stepThreeFormRow">
			<label style="font-weight:bold;">Session Length</label>
			<label><?php echo $paydata['PaymentHistory']['tutoring_hours'];?> Hours</label> 
		</div>
		<div class="stepThreeFormRow">
			<label style="font-weight:bold;">Total Session Cost</label>
			<label>
			<?php
			$netprice = $paydata['PaymentHistory']['tutoring_hours'] * $paydata['PaymentHistory']['tutor_rate_per_hour'];
			echo '$ '.$netprice;
			?>
			</label>
		</div>
		<?php echo $this->Form->create('member',array('id'=>'form1','action'=>'paying_option/'.$paymentid)); ?>
		<div class="stepThreeFormRow">
			<label>Payment Option</label>
			<label>
				<select class="selectStepFrm" name="data[Member][method]" id="selectMethod">
					<option value="credit">Account Balance $&nbsp;<?php echo $paydata['student']['creditable_balance']; ?>&nbsp;</option>
				<!--	<option value="paypal">First data</option>-->
				</select>
				<input type="hidden" name="data[Member][credit]" id="netPrice" value="<?php echo $netprice; ?>" />
				<input type="hidden" name="data[Member][creditable_balance]" id="balance" value="<?php echo $paydata['student']['creditable_balance'];?>" />
			</label>
		</div>
		<div class="stepThreeFormRow">
			<div class="stepFormContButton button" style="width:200px;margin-left:147px;">
				<span></span>
				<input type="button" value="Continue" onclick="checkMethod();" /> 
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<div id="dialogCancel" title="Insufficient Balance" style="display:none;">
	<p>You have insufficient balance!</p>
</div>      