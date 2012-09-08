<?php //pr($users);die;//$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>
<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;" border="0">
	<tr id="header">
		<td><b>S.No.</b></td>
   <td style="color:#00F;"><b><?php echo $paginator->sort('School Name','UpcomingSchool.school_name');?></b></td>
        <td style="color:#00F;"><b><?php echo $paginator->sort('Address','UpcomingSchool.address');?></b></td>
        
		<td style="color:#00F;"><b><?php echo 'Action';?></b></td>
	</tr>
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php foreach($schools as $school){?>
	<tr class="odd">
		<td><?php echo $snum?></td>
        <td><?php echo $school['UpcomingSchool']['school_name'];?></td>
        <td><?php echo $school['UpcomingSchool']['address'].' '.$school['UpcomingSchool']['city'].' '.$school['UpcomingSchool']['state'].' '.$school['UpcomingSchool']['zip'];?></td>
		<td style="width:130px;">
			<?php echo $html->link('', array('action'=>'upcoming_edit', base64_encode(convert_uuencode($school['UpcomingSchool']['id'])),'admin' => true), array('class'=>'table-edit-link','title' => 'Edit')); ?>
            
            <?php echo $html->link('', 'javascript:void(0);', array("title" => "delete",'class' => 'table-delete-link delete-single-school1','id' => "del_".$school['UpcomingSchool']['id']),false); ?>
		</td>
	</tr>
	<?php $snum=$snum+1;}
	if(count($schools)==0)
	{
	?>
    <tr class="odd">
		<td class="col-chk1" colspan="7">No Record found</td>	
    </tr>    
     <?   
	}
	?>			
</table>
<!-- pagination starts -->
<div class="paging" id="users-paging-view" style="width:50%; float:left;">
	<?php //$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner'));?>
	<?php echo $paginator->prev('<< '.__('Previous', true), array(), null, array('class'=>'disabled')); ?>
	<?php echo $paginator->numbers(array('separator' => false));?>
	<?php echo $paginator->next(__('Next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div style="float:right;background-color:#F0F0EE;border:1px solid grey;"><a><?php echo $paginator->counter(array('format' => '<b>Currently showing</b> %start%-%end%, <b>Total Pages</b> = %pages%, <b>Total results</b> = %count%'));?> </a></div>	
<!-- pagination ends -->