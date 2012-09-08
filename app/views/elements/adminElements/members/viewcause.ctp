<?php //pr($users);die;//$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>
<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;" border="0">
	<tr id="">
		<td><b>S.No.</b></td>
        <td><b><?php echo $paginator->sort('Name','userMeta.fname');?></b></td>
		<td><b><?php echo $paginator->sort('User Email','Member.email');?></b></td>
        <td><b><?php echo $paginator->sort('Address','userMeta.address');?></b></td>
		<td><b><?php echo $paginator->sort('Contact','userMeta.contact');?></b></td>
		<td><b><?php echo $paginator->sort('Status','Member.active');?></b></td>
		<td><b><?php echo 'Action';?></b></td>
	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php foreach($causes as $cause){?>
	<tr class="odd">
		<td class="col-chk1"><?php echo $snum?></td>
        <td class="col-first"><?php echo $cause['userMeta']['fname'].' '.$cause['userMeta']['lname'];?></td>
		<td class="col-first"><?php echo $cause['Member']['email'];?></td>
        <td class="col-first"><?php echo $cause['userMeta']['address'].' '.$cause['userMeta']['city'].' '.$cause['userMeta']['state'].' '.$cause['userMeta']['country'].' '.$cause['userMeta']['zip'];?></td>
        <td class="col-first"><?php echo $cause['userMeta']['contact'];?></td>
		<td class="col-first">
			<?php  if($cause['Member']['active'] == '0'){
						echo "Deactive";
					}else if($cause['Member']['active'] == '1'){
						echo "Active";
					}else if($cause['Member']['active'] == '2'){
						echo "Deleted";
					}
			?>
		</td>
		<td class="row-nav-user" style="white-space:nowrap;">
        <?php echo $html->link('', array('controller'=>'members','action'=>'edit_non_profit_schoolinfo', base64_encode(convert_uuencode($cause['Member']['id'])),'admin' => true), array('class'=>'table-edit-link','title' => 'Edit')); ?>
		
		  <?php echo $html->link('', 'javascript:void(0);', array("title" => "delete",'class' => 'table-delete-link delete-single-user','id' => "del_".$cause['Member']['id']), false); ?>
          
						
		</td>
	</tr>
	<?php $snum=$snum+1;}
	if(count($causes)==0)
	{
	?>
    <tr class="odd">
		<td class="col-chk1" colspan="7">No Record found</td>	
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