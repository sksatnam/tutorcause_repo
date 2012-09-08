<?php
/*echo '<pre>';
print_r($payments);
die;*/
?>



<?php //pr($users);die;//$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>
<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;" border="0" >
	<tr id="header" >
		<td><b>S.No.</b></td>
        <td><b><?php echo $paginator->sort('Parent Name','Parent.fname');?></b> &nbsp;</td>
        <td><b><?php echo $paginator->sort('Student Name','Student.fname');?></b> &nbsp;</td>
        <td><b><?php echo $paginator->sort('Amount','StudentFund.amount');?></b>&nbsp;</td>
        <td><b><?php echo $paginator->sort('Transaction Date','StudentFund.created');?></b>&nbsp;</td>
  	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php foreach($payments as $tr){?>
	<tr class="odd">
		<td><?php echo $snum?></td>
         <td ><?php echo $tr['Parent']['fname'].' '.$tr['Parent']['lname']; ?></td>         
         <td ><?php echo $tr['Student']['fname'].' '.$tr['Student']['lname']; ?></td>         
         <td ><?php echo "$".$tr['StudentFund']['amount']; ?></td>
         <td><?php echo date('d-M-y h:i a',strtotime($tr['StudentFund']['created']));?></td>         
	</tr>
	<?php $snum=$snum+1;}
	if(count($payments)==0)
	{
	?>
    <tr class="odd">
		<td class="col-chk1"   colspan="5">No Record found</td>	
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