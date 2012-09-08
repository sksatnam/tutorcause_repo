<?php
/*echo '<pre>';
print_r($charityInfo);
die;*/
?>


<?php $totalCharity="";?>
<script type="text/javascript">	
$(document).ready(function () {
	$('#menu').tabify();
	$('#menu2').tabify();
});
</script>
<style type="text/css" media="screen">
/*	body { font: 0.8em Arial, sans-serif; }*/
	.amountLeft{width:200px;padding:3px 6px;height:20px;float:left;font-weight:bold;}
	.amountCenter{width:40px;padding:3px 2px;float:left;text-align:right;}
	.amountRight{width:70px;padding:3px 2px;float:left;}
	.clear{clear:both;}
	.payDiv ul li{list-style:none;margin-left:180px;}
	.PayCharity{padding:5px 10px;margin-left:10px;}
	.PayCharity ul{}
	.liLeft,.liRight,.liMiddle{list-style:none;border-bottom:1px solid #CCC;float:left;padding:3px;text-align:center;}
/*	.liHead{background:#CCC;color:#FFF;font-weight:bold;}*/
	.liHead{font-weight: normal;
	font-size: 13px;
	color: #039;
	background: #b9c9fe;}
	
	
	
	.liLeft{width:300px; color:blue;}
	.liMiddle{width:85px;color:blue;}
	.liRight{width:100px;color:blue;}
	
	
	
	
	#rounded-corner
{
	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
	font-size: 12px;
	margin: 20px;
	width: 588px;
	text-align: left;
	border-collapse: collapse;
}
#rounded-corner thead th.rounded-company
{
	background: #b9c9fe url('table-images/left.png') left -1px no-repeat;
}
#rounded-corner thead th.rounded-q4
{
	background: #b9c9fe url('table-images/right.png') right -1px no-repeat;
}
#rounded-corner th
{
	padding: 8px;
	font-weight: normal;
	font-size: 13px;
	color: #039;
	background: #b9c9fe;
}
#rounded-corner td
{
	padding: 8px;
	background: #e8edff;
	border-top: 1px solid #fff;
	color: #669;
}
#rounded-corner tfoot td.rounded-foot-left
{
	background: #e8edff url('table-images/botleft.png') left bottom no-repeat;
}
#rounded-corner tfoot td.rounded-foot-right
{
	background: #e8edff url('table-images/botright.png') right bottom no-repeat;
}
/*#rounded-corner tbody tr:hover td
{
	background: #d0dafd;
}*/
</style>


<div id="content-wrap" class="fontNew">

<?php	echo $this->Session->flash(); ?>

    <h1>Payment Statement</h1>
    <div id="tutor-wrap"> 
      
      <?php  echo $this->element('frontend/tutorLeftSidebar'); ?>
      
       <!--Center Column Begin Here-->
      <div class="center-col" style="width:auto">
      
      
      			<fieldset style="width:588px;margin:20px;text-align:right; background: #e8edff; color: #669;">
				<div style="padding:5px 10px;" class="payDiv">
					
					<ul>
						<li>
							<div class="amountLeft"> Account Balance</div>
							<div class="amountCenter">&nbsp;</div>
							<div class="amountRight">$<?php echo $amounts['creditable'];?></div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="amountLeft">Tutor Non-Profit Fees</div>
							<div class="amountCenter"><?php echo $charge;?>%</div>
							<div class="amountRight">$<?php echo $amounts['adminAmount'];?></div>
							<div class="clear"></div></li>
						<li>
							<div class="amountLeft">Grand Total Amount</div>
							<div class="amountCenter">&nbsp;</div>
							<div class="amountRight">$<?php echo $amounts['actualAmonut'];?></div>
							<div class="clear"></div></li>
						</li>
					</ul>
					
				</div>
				<?php if(!empty($charityInfo)){  ?>
				<div class="PayCharity">
					<ul>
						<li class="liLeft liHead">Charity Name</li>
						<li class="liMiddle liHead">Grant %</li>
						<li class="liRight liHead">Amount</li>
						<br class="clear"/>
					</ul>
					<?php foreach($charityInfo as $charity){ ?>
					<ul>
						<li class="liLeft">
						<?php if(!empty($charity['Cause']['userMeta']['cause_name'])) { echo $charity['Cause']['userMeta']['cause_name']; } else { echo $charity['Cause']['userMeta']['fname']." ".$charity['Cause']['userMeta']['lname']; }?></li>
						<li class="liMiddle"><?php echo $charity['TutorRequestCause']['grant'];?> %</li>
						<li class="liRight"><?php 
						
						$causeAmount = ($charity['TutorRequestCause']['grant']/100)*$amounts['actualAmonut'];
						$causeAmount = sprintf("%.2f",$causeAmount);
						echo '$ '.$causeAmount;
						
						?></li>
						<br class="clear"/>
					</ul>
					<?php $totalCharity = $totalCharity+$causeAmount; } ?>
				</div>
				<div style="padding:5px 10px;" class="payDiv">
					<ul>
						<li>
							<div class="amountLeft">Total Charity Amount</div>
							<div class="amountCenter">&nbsp;</div>
							<div class="amountRight">$ <?php
							$totalCharity = sprintf("%.2f",$totalCharity);
							echo $totalCharity;?></div>
							<div class="clear"></div>
						</li>
						<li>
							<div class="amountLeft">Left Amount</div>
							<div class="amountCenter">&nbsp;</div>
							<div class="amountRight">$ <?php 
							$leftamount = $amounts['actualAmonut']-$totalCharity;
							$leftamount = sprintf("%.2f",$leftamount);
							echo $leftamount;?></div>
							<div class="clear"></div>
						</li>
					</ul>
				</div>
				<?php } ?>
				<?php if($amounts['creditable']>0){ ?>
				<?php echo $this->Form->create('Member'); ?>
				<input type="hidden" name="data[Member][default]" value="true" />
				<input type="hidden" name="data[Member][tutorAmount]" value="<?php echo $amounts['actualAmonut']-$totalCharity;?>" />
				<div style="padding:5px 10px;margin-right:30px;" class="payDiv">
			
						
						<input type="submit" class="imageChange" value="Withdrawal Request" style="float:right; margin-right:26px; width:200px;" />
				
				</div>
				<?php echo $this->Form->end(); } ?>
			</fieldset>
            

        </div>
    <!--Center Column End Here-->        
                  
        
        <?php // echo $this->element('frontend/tutorRightSidebar'); ?>
    </div>
</div>