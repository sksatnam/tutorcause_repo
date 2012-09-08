<div>
<?php $paginator->options(array('url' => array('admin' => true))); ?>
<table class="table-short" style="width:100%;">
	<tr>
		<td><b>S.No.</b></td>
		<td><?php echo $form->checkbox('bulk'); ?></td>
		<td><b><?php echo $paginator->sort('Question','Faq.question');?></b></td>
		<!--<td><b><?php //echo $paginator->sort('Answer','Faq.body');?></b></td>-->
		<td><b><?php echo $paginator->sort('Created','Faq.created');?></b></td>						
		<td><b><?php echo 'Actions';?></b></td>
	</tr>	
	<?php $snum=$paginator->counter(array('format' => '%start%')); ?>
	<?php //pr($questions);?>
	<?php foreach($faqs as $faq){?>
	<tr class="odd">
		<td class="col-chk1"><?php echo $snum?></td>
		<td><?php echo $form->checkbox('Faq.id.'.$faq['Faq']['id'], array('value' => $faq['Faq']['id'])); ?></td>
		
		<td class="col-first" style="font-size:14px;color:#F2AC47;padding-right:10px;">
			<?php if (strlen($faq['Faq']['question'])>60)
			{
				$questionName=substr(strip_tags($faq['Faq']['question']),0,60) . "...";
				echo $html->link($questionName, array('controller'=>'faqs', 'action'=>'school_edit', base64_encode(convert_uuencode($faq['Faq']['id'])),'admin' => true), array('title' => $faq['Faq']['question']));
				//echo substr(($question['Question']['question']),0,30) . "...";
			}
			else
			{
				$questionName=strip_tags($faq['Faq']['question']);
				echo $html->link($questionName, array('controller'=>'faqs', 'action'=>'school_edit', base64_encode(convert_uuencode($faq['Faq']['id'])),'admin' => true), array('title' => $faq['Faq']['question']));
			}
			?>
		</td>
		<td class="col-second">
			<?php 
				$strstartdat=$faq['Faq']['created'];
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
			<?php echo $html->link('', array('controller'=>'faqs', 'action'=>'school_edit', base64_encode(convert_uuencode($faq['Faq']['id'])),'admin' => true), array("title" => "Edit FAQ",'class'=>'table-edit-link')); ?>
			<?php //echo $html->link('Reply', array('controller'=>'questions', 'action'=>'quesreply', base64_encode(convert_uuencode($question['Question']['id']))), array('class'=>'table-reply-link', 'id'=>'_id')); ?>
			<span class="hidden"> | </span> <?php echo $html->link('', array('action'=>'admin_school_delete', base64_encode(convert_uuencode($faq['Faq']['id'])),'admin' => true), array("title" => "Delete FAQ",'class'=>'table-delete-link'), 'Are you sure, you want to delete this question?'); ?>
			<?php //echo $html->link('', array('controller'=>'faqs','action'=>'school','admin' => false), array('class'=>'front-edit-link','target'=>'_blank','title' => 'View On Front Panel')); ?>
			<?php echo $html->link($html->image('User Icon.jpg',array('height'=> 20,'width'=> 20)), array('controller'=>'faqs','action'=>'school','admin' => false), array('class'=>'','target'=>'_blank','title' => 'View On Front Panel','escape'=>false)); ?>
		</td>
	</tr>
	<?php $snum=$snum+1;} ?>			
</table>


</div>
<div class="paging" id="article-view-panel" style="width:50%; float:left;">
	<?php //$paginator->options(array('update' => 'contenttable', 'indicator' => 'spinner'));?>
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
	<?php echo $paginator->numbers(array('separator' => false));?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div style="float:right;background-color:#F0F0EE;border:1px solid grey;"><a><?php echo $paginator->counter(array('format' => '<b>Currently showing</b> %start%-%end%, <b>Total Pages</b> = %pages%, <b>Total results</b> = %count%'));?> </a></div>	
<!-- pagination ends -->
<?php //3aug2012 ?>