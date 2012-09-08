 <?php //pr($users);die;//$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>
<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;" border="0" >
	<tr id="header" >
		<td><b>S.No.</b></td>
        <td><b><?php echo $paginator->sort('Student','userMeta.fname');?></b></td>
		<td><b><?php echo $paginator->sort('Tutor ','userMeta.fname');?></b> &nbsp;</td>
        <td><b><?php echo $paginator->sort('Course','PaymentHistory.booked_course');?></b>&nbsp;</td>
		<td><b><?php echo $paginator->sort('Hours','PaymentHistory.tutoring_hours');?></b>&nbsp;</td>
		<td><b><?php echo $paginator->sort('Amount','PaymentHistory.amount');?></b>&nbsp;</td>
        <td><b><?php echo $paginator->sort('Transaction Id','PaymentHistory.paypal_confirm_id');?></b></td>
        <td><b><?php echo $paginator->sort('PaypalDate','PaymentHistory.paypal_date');?></b></td>
	
	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php foreach($payments as $payment){?>
	<tr class="odd">
		<td><?php echo $snum?></td>
        <td><?php echo $payment ['student']['userMeta']['fname'].' '.$payment['student']['userMeta']['lname'];?></td>
        <td ><?php echo $payment ['tutor']['userMeta']['fname'].' '.$payment['tutor']['userMeta']['lname'];?></td>
		<td><?php echo $payment['PaymentHistory']['booked_course'];?></td>
        <td><?php echo $payment['PaymentHistory']['tutoring_hours'];?></td>
        <td><?php echo '$ '.$payment['PaymentHistory']['amount'];?></td>
        <td><?php echo $payment['PaymentHistory']['paypal_confirm_id'];?></td>
        <td><?php 
		if($payment['PaymentHistory']['paypal_date'])
		{
		echo date('d-M-y H:i a',strtotime($payment['PaymentHistory']['paypal_date']));
        }
        else
        {
        echo 'N/A';
        }?></td>
    
	</tr>
	<?php $snum=$snum+1;}
	if(count($payments)==0)
	{
	?>
    <tr class="odd">
		<td class="col-chk1"   colspan="8">No Record found</td>	
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