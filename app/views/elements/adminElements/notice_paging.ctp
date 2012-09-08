
<?php //$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner','url' => array('admin' => true))); ?>
<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;">
	<tr>
		<td><b>S.No.</b></td>
		<td><?php //echo $form->checkbox('bulk'); ?></td>
		<td><b>Notice Heading<?php //echo  $paginator->sort('Question','Notice.question');?></b></td>
		<!--<td><b><?php //echo $paginator->sort('Body','Faq.answer');?></b></td>-->
        <td><b>Type<?php // echo $paginator->sort('Type','Group.id');?></b></td>	
		<td><b>Created<?php // echo $paginator->sort('Created','Notice.created');?></b></td>	
  		<td><b><?php echo 'Actions';?></b></td>
	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php //pr($questions);?>
	<?php foreach($noticedata as $np){?>
	<tr class="odd">
		<td class="col-chk1"><?php echo $snum?></td>
		<td>&nbsp;<?php //echo $form->checkbox('Faq.id.'.$np['Notice']['id'], array('value' => $np['Notice']['id'])); ?></td>
		<td class="col-first" style="font-size:14px;color:#F2AC47;padding-right:10px;">
			<?php if (strlen($np['Notice']['notice_head'])>60)
			{
				$notice_headName=substr(strip_tags($np['Notice']['notice_head']),0,60) . "...";
				echo $html->link($notice_headName, array('controller'=>'notices', 'action'=>'notice_add', base64_encode(convert_uuencode($np['Notice']['id'])),'admin' => true), array('title' => $np['Notice']['notice_head']));
				//echo substr(($notice_head['notice_head']['notice_head']),0,30) . "...";
			}
			else
			{
				$notice_headName=strip_tags($np['Notice']['notice_head']);
				echo $html->link($notice_headName, array('controller'=>'notices', 'action'=>'notice_add', base64_encode(convert_uuencode($np['Notice']['id'])),'admin' => true), array('title' => $np['Notice']['notice_head']));
			}
			?>
		</td>
		<!--<td class="col-first" style="font-size:14px;color:#F2AC47;padding-right:10px;">
			<?php /* if (strlen($article['Article']['body'])>30)
			{
				$questionName=substr(($article['Article']['body']),0,30) . "...";
				echo $html->link($questionName, array('controller'=>'Articles', 'action'=>'edit', base64_encode(convert_uuencode($article['Article']['id'])),'admin' => true));
				//echo substr(($question['Question']['question']),0,30) . "...";
			}
			else
			{
				$questionName=($article['Article']['body']);
				echo $html->link($questionName, array('controller'=>'Articles', 'action'=>'edit', base64_encode(convert_uuencode($article['Article']['id'])),'admin' => true));
			}*/
			?>
		</td>-->
        
         <td class="col-third"> <?php 
		 $allgroup = $np['Notice']['group_id'];
		 $group = explode(",", $allgroup);
		 
		 
		 if (in_array("6", $group)) {
		 
			echo ' Non-Profit ';	 
		 }
		 if (in_array("7", $group)) {
		 
			echo ' Tutor '; 
		 }
		 if (in_array("8", $group)) {
		 
			echo ' Student '; 
		 }
		 if (in_array("9", $group)) {
		 
			echo ' Parent '; 
		 }
		 
		?></td>
        
		<td class="col-second">
			<?php 
				$strstartdat=$np['Notice']['created'];
				$stringArray = explode(" ", $strstartdat);$stringArray2 = explode("-", $stringArray[0]);
				if ($stringArray2[1]==0 && $stringArray2[0]==0 && $stringArray2[2]==0)
				{
					$enddate="Not Mentioned";
				}
				else
				{
					$enddate=date("d-M-Y",mktime(0,0,0,$stringArray2[1],$stringArray2[2],$stringArray2[0]));
				}
				echo $enddate;
				?>
				<?php //echo $question['Question']['created']?>
		 </td>
         
        
      
      
        
		<td class="row-nav">
			<?php echo $html->link('', array('controller'=>'notices', 'action'=>'notice_add', base64_encode(convert_uuencode($np['Notice']['id'])),'admin' => true), array("title" => "Edit NOTICE",'class'=>'table-edit-link')); ?>
			<?php //echo $html->link('Reply', array('controller'=>'questions', 'action'=>'quesreply', base64_encode(convert_uuencode($question['Question']['id'])), array('class'=>'table-reply-link', 'id'=>'_id')); ?>
			 <?php echo $html->link('', 'javascript:void(0);', array("title" => "delete",'class' => 'table-delete-link delete-single-notice','id' => "del_".$np['Notice']['id']),false); ?>
			<?php //echo $html->link('', array('controller'=>'faqs','action'=>'parent','admin' => false), array('class'=>'front-edit-link','target'=>'_blank','title' => 'View On Front Panel')); ?>
											<?php //echo $html->link('Delete',array('action'=>'delete', base64_encode(convert_uuencode($post['Post']['id']))),null,'Are you sure?')?>
			<?php //echo $html->link($html->image('User Icon.jpg',array('height'=> 20,'width'=> 20)), array('controller'=>'faqs','action'=>'parent','admin' => false), array('class'=>'','target'=>'_blank','title' => 'View On Front Panel','escape'=>false)); ?>
			
		</td>
	</tr>
	<?php $snum=$snum+1;} ?>			
</table>


<!-- pagination starts -->

<div class="paging" id="article-view-panel" style="width:50%; float:left;">
	<?php //$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner'));?>
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	<?php echo $paginator->numbers(array('separator' => false));?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div style="float:right;background-color:#F0F0EE;border:1px solid grey;"><a><?php echo $paginator->counter(array('format' => '<b>Currently showing</b> %start%-%end%, <b>Total Pages</b> = %pages%, <b>Total results</b> = %count%'));?> </a></div>	
<!-- pagination ends -->

<?php //3aug2012 ?>