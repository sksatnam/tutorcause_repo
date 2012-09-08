<?php //pr($users);die;//$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>
<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;" border="0">
	<tr id="">
		<td><b>S.No.</b></td>
        <td><b><?php echo $paginator->sort('Name','userMeta.fname');?></b></td>
		<td><b><?php echo $paginator->sort('User Email','Member.email');?></b></td>
        <td><b><?php echo $paginator->sort('Type','Group.id');?></b></td>
		<td><b><?php echo $paginator->sort('Registered','Member.created');?></b></td>
		<td><b><?php echo $paginator->sort('Status','Member.active');?></b></td>
		<td><b><?php echo 'Action';?></b></td>
	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php foreach($members as $member){?>
	<tr class="odd">
		<td class="col-chk1"><?php echo $snum?></td>
        <td class="col-first"><?php echo $member['userMeta']['fname'].' '.$member['userMeta']['lname'];?></td>
		<td class="col-first"><?php echo $member['Member']['email'];?></td>
        <td class="col-first"><?php echo $member['Group']['name'];?></td>
		<td class="col-first">
			<?php $datetime = strtotime($member['Member']['created']);echo date("F d, Y", $datetime);  ?>
		</td>
		<td class="col-first">
			<?php  if($member['Member']['active'] == '0'){
						echo "Deactive";
					}else if($member['Member']['active'] == '1'){
						echo "Active";
					}else if($member['Member']['active'] == '2'){
						echo "Blocked";
					}else if($member['Member']['active'] == '3'){
						echo "Deleted";
					}else if($member['Member']['active'] == '4'){
						echo "Trash";
					}
			?>
		</td>
      <?php   if($member['Member']['group_id']==1 || $member['Member']['group_id']== 2|| $member['Member']['group_id']==3||$member['Member']['group_id']==4|| $member['Member']['group_id']== 5|| $member['Member']['group_id']==7 || $member['Member']['group_id']==8 || $member['Member']['group_id']==9)
	  {
		  ?>
		<td class="row-nav-user" style="white-space:nowrap;">
			<?php echo $html->link('', array('action'=>'edit', base64_encode(convert_uuencode($member['Member']['id'])),'admin' => true), array('class'=>'table-edit-link','title' => 'Edit')); ?>
			<?php echo $html->link('', 'javascript:void(0);', array("title" => "delete",'class' => 'table-delete-link delete-single-user','id' => "del_".$member['Member']['id']), false); ?>
            
            <?php
            if($member['Member']['group_id']==8 || $member['Member']['group_id']==7)
			{
				 echo $html->link('', array('action'=>'allsession', base64_encode(convert_uuencode($member['Member']['id'])),'admin' => true), array('class'=>'table-sessionview-link','title' => 'All Session')); 
			}
			?>
            
            
            
            
            <?php
			
			if($member['Member']['group_id']==7)
			{
             echo  $html->link('', array('controller'=>'schools','action'=>'tutor_rate', base64_encode(convert_uuencode($member['Member']['id'])),'admin' => true), array('class'=>'table-tutorrate-link','title' => 'Tutor Rate')); 
			 
			}
			 ?>
            
            
						
		</td>
        <?php
	  }
	  ?>
      <?php
	  if($member['Member']['group_id']==6 )
	  {
		  ?>
		  <td class="row-nav-user" style="white-space:nowrap;">
			<?php echo $html->link('', array('action'=>'edit_non_profit_schoolinfo', base64_encode(convert_uuencode($member['Member']['id'])),'admin' => true), array('class'=>'table-edit-link','title' => 'Edit')); ?>
            <?php echo $html->link('', 'javascript:void(0);', array("title" => "delete",'class' => 'table-delete-link delete-single-user','id' => "del_".$member['Member']['id']), false); ?>
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
