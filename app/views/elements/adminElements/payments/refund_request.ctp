<?php //pr($users);die;//$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>
<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;" border="0" >
	<tr id="header" >
		<td><b>S.No.</b></td>
        <td><b><?php echo $paginator->sort('Student Name','userMeta.fname');?></b> &nbsp;</td>
        <td><b><?php echo $paginator->sort('Tutor Name','userMeta.fname');?></b> &nbsp;</td>
        <td><b><?php echo $paginator->sort('Session Date','PaymentHistory.booked_start_time');?></b>&nbsp;</td>
        <td><b><?php echo $paginator->sort('Refund Date','PaymentHistory.request_date');?></b>&nbsp;</td>
        <td><b><?php echo $paginator->sort('Approval Date','PaymentHistory.approval_date');?></b>&nbsp;</td>
        <td><b><?php echo $paginator->sort('Status','PaymentHistory.session_status');?></b> &nbsp;</td>
        <td style="color:#00F;"><b><?php echo 'Action';?></b></td>
   
	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php foreach($payments as $tr){?>
	<tr class="odd">
		<td><?php echo $snum?></td>
         <td><?php echo $tr['student']['userMeta']['fname'].' '.$tr['student']['userMeta']['lname'];?></td>
         <td ><?php echo $tr['tutor']['userMeta']['fname'].' '.$tr['tutor']['userMeta']['lname'];?></td>
         <td><?php echo date('d-M-y h:i a',strtotime($tr['PaymentHistory']['booked_start_time']));?></td>
         <td><?php echo date('d-M-y h:i a',strtotime($tr['PaymentHistory']['request_date']));?></td>
         <td><?php
		 if($tr['PaymentHistory']['approval_date']!='')
		 {
		  echo date('d-M-y h:i a',strtotime($tr['PaymentHistory']['approval_date']));
		 } ?></td>
    
        <td><?php echo $tr['PaymentHistory']['session_status'];?></td>
        <td style="130px">
        <?php if($tr['PaymentHistory']['session_status']!='Refunded')
		{
        	 echo $form->create('paymenthistories',array("url" => $html->url(array('action'=>'refund_request',"admin" => true), true)));?>
             <input type="hidden"  value="<?php echo $tr['PaymentHistory']['id']; ?>" name="data[PaymentHistory][id]" />
             <input type="hidden"  value="<?php echo $tr['PaymentHistory']['student_id']; ?>" name="data[PaymentHistory][student_id]" />
              <input type="hidden"  value="<?php echo $tr['PaymentHistory']['tutor_id']; ?>" name="data[PaymentHistory][tutor_id]" />
             <input type="hidden"  value="<?php echo $tr['PaymentHistory']['amount']; ?>" name="data[PaymentHistory][amount]" />  
             <input type="submit"  value="Refund"  style=" width:100px; margin-left:20px; background-color:#B3BBC2; color:#FFFFFF" />     
          
           <?php echo $form->end(); 
		}?>	 
        </td>    
    
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