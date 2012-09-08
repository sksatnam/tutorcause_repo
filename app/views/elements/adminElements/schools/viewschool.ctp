<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;" border="0">
	<tr id="header">
		<td><b>S.No.</b></td>
   <td style="color:#00F;"><b><?php echo $paginator->sort('School Name','School.school_name');?></b></td>
        <td style="color:#00F;"><b><?php echo $paginator->sort('Address','School.address');?></b></td>
        
		<td style="color:#00F;"><b><?php echo 'Action';?></b></td>
	</tr>	
    
    
        
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
    <?php 
	if(!empty($schools)) {
	foreach($schools as $school){?>
	<tr class="odd">
		<td><?php echo $snum?></td>
        <td><?php echo $school['School']['school_name'];?></td>
        <td><?php echo $school['School']['address'].' '.$school['School']['city'].' '.$school['School']['state'].' '.$school['School']['zip'];?></td>
       
		
		<td style="width:130px;">
			<?php echo $html->link('', array('action'=>'edit', base64_encode(convert_uuencode($school['School']['id'])),'admin' => true), array('class'=>'table-edit-link','title' => 'Edit')); ?>
            
            <?php echo $html->link('', array('action'=>'course_view', $school['School']['id'],'admin' => true), array('class'=>'table-view-link','title' => 'Course View')); ?>
            
            <?php echo $html->link('', 'javascript:void(0);', array("title" => "delete",'class' => 'table-delete-link delete-single-school','id' => "del_".$school['School']['id']),false); ?> 	
             <?php 
            if($this->Session->read('Admin.id')){	
			if($school['School']['status']=='inactive') {
				$activate = "display:none;";
				$deactivate = "";
			} else {
				$activate = "";
				$deactivate = "display:none;";
			}
            ?>
            
              <?php
			echo $html->link($html->image("frontend/deactivate.png", array('title'=>'Enable School')),array('controller' => 'schools','admin'=>true, 'action' => 'update_school_status',base64_encode(convert_uuencode($school['School']['id']))), array('escape' => false,'id'=>'activate','style'=>$deactivate,'onclick'=>"return likeUnlike('activate',this)"));
			
			echo $html->link($html->image("frontend/activate.png", array('title'=>'Disable School')),array('controller' => 'schools','admin'=>true, 'action' => 'update_school_status',base64_encode(convert_uuencode($school['School']['id']))), array('escape' => false,'id'=>'deactivate','style'=>$activate,'onclick'=>"return likeUnlike('deactivate',this)"));
		?>
        <?php
			}
			?>
            <?php
			
			
			 if($session->read('Admin.group_id')=='1')
			{
			if(count($school['Member']))
			{
				
				$showtutor = 0;
				$showstudent = 0;
				
				foreach($school['Member'] as $sm)
				{
					if($sm['group_id']==7)
					{
						$showtutor = 1;
					}
					
					if($sm['group_id']==8)
					{
						$showstudent = 1;
					}
				}
				
			if($showtutor)
				{
				echo $html->link('', array('action'=>'tutor_view', $school['School']['id'],'admin' => true), array('class'=>'table-tutorview-link','title' => 'Tutor View'));
				}
			
			if($showstudent)
				{
				echo $html->link('', array('action'=>'student_view', $school['School']['id'],'admin' => true), array('class'=>'table-studentview-link','title' => 'Student View')); 
				}
			}
			}
			
			
			?>
             
		</td>
	</tr>
	<?php $snum=$snum+1;}
	}
	$school_no = count($schools);
		if($school_no==0)
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
<?php //3aug2012 ?>