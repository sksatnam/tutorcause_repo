<?php //pr($users);die;//$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>
<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;" border="0">
	<tr>
		<td><b>S.No.</b></td>
        <td class="sort"><b><?php echo $paginator->sort('Name','userMeta.fname',array('class'=>'sort'));?></b></td>
		<td class="sort"><b><?php echo $paginator->sort('User Email','Member.email',array('class'=>'sort'));?></b></td>
        <td class="sort"><b><?php echo $paginator->sort('School','School.school_name',array('class'=>'sort'));?></b></td>
        <td class="sort"><b><?php echo $paginator->sort('Registered','Member.created',array('class'=>'sort'));?></b></td>
		<td><b><?php echo 'Action';?></b></td>
	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php foreach($members as $member){?>
	<tr class="odd">
		<td class="col-first"><?php echo $snum?></td>
        <td class="col-first"><?php echo $member['userMeta']['fname'].' '.$member['userMeta']['lname'];?></td>
		<td class="col-first"><?php echo $member['Member']['email'];?></td>
        <td class="col-first" style="width:550px;"><?php echo $member['School']['school_name'];?></td>
        
		<td class="col-first">
			<?php $datetime = strtotime($member['Member']['created']);echo date("F d, Y", $datetime);  ?>
		</td>
		
		<?php   if($member['Member']['group_id']==7)
        {
        ?>
            <td class="row-nav-user" style="white-space:nowrap;">
            <?php 
			 echo $html->link('', array('action'=>'tutor_approve', base64_encode(convert_uuencode($member['Member']['id'])),'admin' => true), array('class'=>'table-view-link','title' => 'View')); ?>
            </td>
        <?php
        }
        ?>
      
	  
	</tr>
	<?php $snum=$snum+1;}
	if(count($members)==0)
	{
	?>
    <tr class="odd">
		<td class="col-chk1" colspan="6" style="text-align:center">No Record found</td>	
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