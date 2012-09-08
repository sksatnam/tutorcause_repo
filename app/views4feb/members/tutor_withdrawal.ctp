<script type="text/javascript">	
$(document).ready(function () {
	$('#menu').tabify();
	$('#menu2').tabify();
});
$(function() {
	$('.closeDiv').live('click',function(){
		$('#Withdrawalsdetails').slideUp(100);
	});
	$('.getDetails').click(function(){
		$('#Withdrawalsdetails').load(ajax_url+'/members/tutor_withdrawal_details?requestId='+$(this).next().val(), function() {
			$('#Withdrawalsdetails').slideDown(100);
		});
	});
});
</script>
<style type="text/css" media="screen">
	/*body { font: 0.8em Arial, sans-serif; }*/
	/*.withdrawal{margin:20px 10px;border:1px solid;border-bottom:none;}
	.withdrawal ul{padding:0px;margin:0px;border-bottom:1px solid}
	.withdrawal ul li{list-style:none;width:120px;float:left;padding:3px 0px 2px 15px;border-right:1px dotted #CCC}
	.heading{background-color:#CCC;font-weight:bold;color:#FFF;}*/
	
	.amountLeft{width:142px;padding:1px 6px;height:20px;float:left;font-weight:bold;text-align:right}
	.amountCenter{width:40px;padding:1px 2px;float:left;text-align:right;}
	.amountRight{width:97px;padding:1px 2px;float:left;text-align:right}
	.clear{clear:both;}
/*	.payDiv{margin-left:140px;}*/
	.payDiv ul li{list-style:none;}
	.PayCharity{padding:5px 10px;margian-left:105px;}
	.PayCharity ul{}
	.liLeft,.liRight,.liMiddle{list-style:none;border-bottom:1px solid #CCC;float:left;padding:1px;text-align:center;}
	.liHead{background:#b9c9fe;color:#FFF;font-weight:bold;}
	.liLeft{width:110px; color:blue;}
	.liMiddle{width:85px; color:blue;}
	.liRight{width:100px; color:blue;}
	.closeDiv{color:red;cursor:pointer;}
	.getDetails{color:blue;cursor:pointer;}
	
	
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

    <h1>Withdrawal History</h1>
    <div id="tutor-wrap"> 
      
      <?php  echo $this->element('frontend/tutorLeftSidebar'); ?>
      
       <!--Center Column Begin Here-->
      <div class="center-col" style="width:auto">
      
      
      <table id="rounded-corner" summary="Tutorcause">
    <thead>
    	<tr>
        	<th scope="col" class="rounded-company">Date</th>
            <th scope="col" class="rounded-q1">Request ID</th>
            <th scope="col" class="rounded-q2">Amount</th>
            <th scope="col" class="rounded-q3">Status</th>
            <th scope="col" class="rounded-q4">Details</th>
        </tr>
    </thead>
        <tfoot>
    	<tr>
        	<td colspan="4" class="rounded-foot-left"><fieldset style="margin:10px 90px;display:none;" id="Withdrawalsdetails" >
			</fieldset></td>
        	<td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
    <tbody>
    
     <?php foreach($withdrawalDetail as $withdrawal){ ?>
    			  <tr>
				<td><?php echo date('F j, Y',strtotime($withdrawal['TutorWithdrawal']['created']));?></td>
					<td><?php echo $withdrawal['TutorWithdrawal']['request_id'];?></td>
					<td>$ <?php echo $withdrawal['TutorWithdrawal']['tutor_creditable_amount'];?></td>
					<td><?php echo $withdrawal['TutorWithdrawal']['status'];?></td>
                    <td>
						<label class="getDetails">Details</label>
						<input type="hidden" class="requestId" value="<?php echo $withdrawal['TutorWithdrawal']['id'];?>" />
					</td>
			    </tr>
				<?php }
				if(count($withdrawalDetail)==0)
				{
				echo '<tr><td colspan="5">No Record found</td></tr>';
				}
				?>
    
    </tbody>
</table>



            

        </div>
    <!--Center Column End Here-->        
                  
        
        <?php // echo $this->element('frontend/tutorRightSidebar'); ?>
    </div>
</div>

      
      
      


