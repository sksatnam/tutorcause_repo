<style type="text/css">

/*#rounded-corner
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
*//*#rounded-corner tbody tr:hover td
{
	background: #d0dafd;
}*/


</style>


<div id="content-wrap">
              <h1>Payment History</h1>
              <div id="tutor-wrap"> 
              
              <?php echo $this->element('frontend/causeLeftSidebar'); ?>
                    
                <!--Center Column Begin Here-->
                <div class="center-col" style="width:auto;">
                
                
                <table id="rounded-corner" summary="Tutorcause">
    <thead>
    	<tr>
        	<th scope="col" class="rounded-company">Request Id</th>
            <th scope="col" class="rounded-q1">Tutor</th>
            <th scope="col" class="rounded-q2">Email</th>
            <th scope="col" class="rounded-q3">Approved Date</th>
            <th scope="col" class="rounded-q4">Amount</th>
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
    
    		   <?php foreach($alltutor as $tr){ ?>
    			  <tr>
				<td><?php echo $tr['TutorWithdrawal']['request_id'];?></td>
					<td><?php echo $tr['Tutor']['userMeta']['fname'].' '.$tr['Tutor']['userMeta']['lname'];?></td>
					<td><?php echo $tr['Tutor']['email'];?></td>
					<td><?php echo date('d-M-y H:i a',strtotime ($tr['TutorWithdrawal']['approval_date']));?></td>
                    <td><?php echo '$ '.$tr['TutorToCause']['cause_amount'];?></td>
			    </tr>
                <?php }
				if(count($alltutor)==0)
				{
				echo '<tr><td colspan="5">No Record found</td></tr>';
				}
				?>
    
    </tbody>
</table>
                  
                  
                  
                </div>
                <!--Center Column End Here--> 
                
             <?php // echo $this->element('frontend/causeRightSidebar');?>    
                
  </div>
</div>