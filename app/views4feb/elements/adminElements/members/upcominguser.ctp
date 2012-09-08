<?php //pr($users);die;//$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>
<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;" border="0">
	<tr id="">
		<td><b>S.No.</b></td>
        <td><b><?php echo $paginator->sort('Name','UpcomingMember.name');?></b></td>
		<td><b><?php echo $paginator->sort('Email','UpcomingMember.email');?></b></td>
        <td><b><?php echo $paginator->sort('School','UpcomingSchool.school_name');?></b></td>
		<td><b><?php echo $paginator->sort('Subscribed','UpcomingMember.created');?></b></td>
		<td><b><?php echo 'Action';?></b></td>
	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php foreach($members as $member){?>
	<tr class="odd">
		<td class="col-chk1"><?php echo $snum?></td>
        <td class="col-first"><?php echo $member['UpcomingMember']['name']; ?></td>
		<td class="col-first"><?php echo $member['UpcomingMember']['email'];?></td>
        <td class="col-first"><?php echo $member['UpcomingSchool']['school_name'];?></td>
		<td class="col-first">
			<?php $datetime = strtotime($member['UpcomingMember']['created']);echo date("F d, Y", $datetime);  ?>
		</td>
		<td class="row-nav-user" style="white-space:nowrap;">
			<?php if($member['UpcomingMember']['status'] == null){ ?>
			<?php echo $html->link('subscribe', array('action'=>'member_subscribe', $member['UpcomingMember']['id'],'admin' => true)); ?>
			<?php } else { echo "Subscribed"; } ?>
		</td>
      
	</tr>
	<?php $snum=$snum+1;}
	if(count($members)==0)
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
