<?php //pr($users);die;//$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>

<?php 
if(isset($course_id)) {
	
	$paginator->options(array('url' => array($id,$course_id,$course_title,$pages,'admin' => true)));
}else{
$paginator->options(array('url' => array($id,'admin' => true)));
} ?>
<table class="table-short" style="width:100%;" border="0">
	<tr id="header">
		<td><b>S.No.</b></td>
        <td style="color:#00F; padding-left:15px"><b><?php echo 'School Name';?></b></td>
        <td style="color:#00F; padding-left:30px"><b><?php  echo $paginator->sort('Course Code','Course.course_id');?></b></td>
        <td style="color:#00F; padding-left:15px"><b><?php echo $paginator->sort('Course Title','Course.course_title');?></b></td>
        <td style="color:#00F;"><b><?php echo 'Action';?></b></td>
        
        
        
		
	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php 
	if(!empty($courses)) {
	
	foreach($courses as $course){?>
	<tr class="odd">
		<td ><?php echo $snum?></td>
        <td style="padding-left:15px;"><?php echo $course['School']['school_name'];?></td>
        <td style="padding-left:30px;"><?php echo $course['Course']['course_id'];?></td>
        <td style="padding-left:15px;"><?php echo $course['Course']['course_title'];?></td>
       <td style="width:50px;">
			<?php echo $html->link('', array('action'=>'course_edit',$course['Course']['id'],'admin' => true), array('class'=>'table-edit-link','title' => 'Edit')); ?>
			
         <?php echo $html->link('', 'javascript:void(0);', array("title" => "delete",'class' => 'table-delete-link delete-single-course','id' => "del_".$course['Course']['id']), false); ?> 
            	
             
              					
		</td>
	</tr>
	<?php $snum=$snum+1;}
	}
	if(count($courses)==0)
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