<?php //pr($users);die;//$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>
<?php // $paginator->options(array('url' => array($id,'admin' => true))); ?>
<?php echo $paginator->options(array('url' => $this->passedArgs)); ?>

<table class="table-short" style="width:100%;" border="0">
	<tr id="">
		<td><b>S.No.</b></td>
        <td><b><?php echo 'Tutor Name';?></b></td>
		<td><b><?php echo 'Student Name';?></b></td>
        <td><b><?php echo 'Course Code';?></b></td>
		<td><b><?php echo 'Hourly Rate';?></b></td>
		<td><b><?php echo 'Session Start';?></b></td>
        <td><b><?php echo 'Session End';?></b></td>
        <td><b><?php echo 'Session Duration';?></b></td>
        <td><b><?php echo 'Total Session Cost';?></b></td>
        <td><b><?php echo 'Session Status';?></b></td>
	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php foreach($tutoringsession as $allsession){?>
	<tr class="odd">
    
		<td class="col-chk1"><?php echo $snum?></td>
        <td class="col-first"><?php echo $allsession['tutor']['userMeta']['fname'].' '.$allsession['tutor']['userMeta']['lname'];?></td>
        <td class="col-first"><?php 
		echo $allsession['student']['userMeta']['fname'].' '.$allsession['student']['userMeta']['lname'];?></td>
		<td class="col-first"><?php echo $allsession['PaymentHistory']['booked_course'];?></td>
		<td class="col-first"><?php echo '$'.$allsession['PaymentHistory']['tutor_rate_per_hour'];?></td>
        <td class="col-first"> <?php $starttime = strtotime($allsession['PaymentHistory']['booked_start_time']);echo date("F, d Y @ G:i a", $starttime);  ?> </td>
        <td class="col-first"> <?php $endtime = strtotime($allsession['PaymentHistory']['booked_end_time']);echo date("F, d Y @ G:i a", $endtime);  ?> </td>
        <td class="col-first"><?php echo $allsession['PaymentHistory']['tutoring_hours'];?></td>
        <td class="col-first"><?php 
		$sessionmoney = $allsession['PaymentHistory']['tutor_rate_per_hour'] * $allsession['PaymentHistory']['tutoring_hours'];
		echo '$'.$sessionmoney;
		?></td>
        
        
     <!--    <option value=""> Select Status</option>
                                    <option value="Booked">Awaiting Approval</option> 
                                    <option value="Accepted">Awaiting Payment</option>
                                    <option value="Paided">Upcoming Sessions</option>
                                    <option value="Completed">Completed Sessions</option>
                                    <option value="Rejected">Rejected Sessions</option>
                                    <option value="Refund">Refund Request</option>
                                    <option value="Refunded">Refunded</option>-->
        
        
        
        
        <td class="col-first"><?php 
		
		$sessionstatus = $allsession['PaymentHistory']['session_status'];
		if($sessionstatus=='Booked')
		{
		  echo 'Awaiting Approval';	
		}
		else if($sessionstatus=='Accepted')
		{
		  echo 'Awaiting Payment';	
		}
		else if($sessionstatus=='Paided')
		{
		  echo 'Upcoming Sessions';	
		}
		else if($sessionstatus=='Completed')
		{
		  echo 'Completed Sessions';	
		}
		else if($sessionstatus=='Rejected')
		{
		  echo 'Rejected Sessions';	
		}
		else if($sessionstatus=='Refund')
		{
		  echo 'Refund Request';	
		}
		else if($sessionstatus=='Refunded')
		{
		  echo 'Refunded';	
		}
		?></td>
	  
	</tr>
	<?php $snum=$snum+1;}
	if(count($tutoringsession)==0)
	{
	?>
    <tr class="odd">
		<td class="col-chk1" colspan="10">No Record found</td>	
    </tr>    
     <?php   
	}
	?>			
</table>
<!-- pagination starts -->
<div class="paging" id="users-paging-view" style="width:50%; float:left;">
	<?php //$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner'));?>
	<?php echo $paginator->prev('<< '.__('Previous', true), array(), null, array('class'=>'disabled'));?>
	<?php echo $paginator->numbers(array('separator' => false));?>
	<?php echo $paginator->next(__('Next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div style="float:right;background-color:#F0F0EE;border:1px solid grey;"><a><?php echo $paginator->counter(array('format' => '<b>Currently showing</b> %start%-%end%, <b>Total Pages</b> = %pages%, <b>Total results</b> = %count%'));?> </a></div>	
<!-- pagination ends -->
<?php //3aug2012 ?>