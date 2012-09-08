 <?php //pr($users);die;//$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>
<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;" border="0" >
	<tr id="header" >
		<td><b>S.No.</b></td>
            <td><b><?php echo $paginator->sort('Request Id','TutorWithdrawal.request_id');?></b></td>
   		<td><b><?php echo $paginator->sort('Tutor email','Member.email');?></b> &nbsp;</td>
        <td><b><?php echo $paginator->sort('Tutor Name','userMeta.fname');?></b> &nbsp;</td>
        <td><b><?php echo $paginator->sort('Amount','TutorWithdrawal.tutor_creditable_amount');?></b>&nbsp;</td>
          <td><b><?php echo $paginator->sort('Status','TutorWithdrawal.status');?></b> &nbsp;</td>
       
        <td><b><?php echo $paginator->sort('Approve/Reject Date','TutorWithdrawal.approval_date');?></b> &nbsp;</td>
    
        <td><b><?php echo $paginator->sort('Request Date','TutorWithdrawal.created');?></b></td>
	
	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php foreach($tutorrequest as $tr){?>
	<tr class="odd">
		<td><?php echo $snum?></td>
          <td><?php echo $tr['TutorWithdrawal']['request_id'];?></td>
          
     	<td><?php echo $tr['Member']['email'];?></td>
        <td><?php echo $tr['Member']['userMeta']['fname'].' '.$tr['Member']['userMeta']['lname'];?></td>
        
        <td><?php echo '$ '.$tr['TutorWithdrawal']['tutor_creditable_amount'];?></td>
        <td><?php echo $tr['TutorWithdrawal']['status'];?></td>
    
        <td><?php
		if($tr['TutorWithdrawal']['approval_date']!='')
		{
		echo date('d-M-y H:i a',strtotime($tr['TutorWithdrawal']['approval_date']));
		} ?></td>
      
        <td><?php echo date('d-M-y H:i a',strtotime($tr['TutorWithdrawal']['created']));?></td>
        
        <td style="130px">    
            <?php echo $html->link('', array('action'=>'cause_grant', $tr['TutorWithdrawal']['id'],'admin' => true), array('class'=>'table-view-link','title' => 'View')); ?>
        </td>    
    
	</tr>
	<?php $snum=$snum+1;}
	if(count($tutorrequest)==0)
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
