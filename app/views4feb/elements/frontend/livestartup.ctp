<div class="files-wrap">
<?php
if(!empty($uploadFile))
	{
	foreach($uploadFile as $uf)
		{
			
			
			
			
			
		?>
		
		<div class="file-detail">
		<div class="file-icon"><img src="<?php
		
			$ext = explode('.',$uf['FileUpload']['file_name']);
			
			if($ext[1]=='xlsx' || $ext[1]=='xls')
			{
				 echo FIMAGE.'excel.png';
			}
			else if($ext[1]=='docx' || $ext[1]=='doc')
			{
				 echo FIMAGE.'word.png';
			}
			else if($ext[1]=='pptx' || $ext[1]=='ppt')
			{
				 echo FIMAGE.'ppt.png';
			}
			else if($ext[1]=='pdf')
			{
				 echo FIMAGE.'pdf.png';
			}
			else
			{
				 echo FIMAGE.'pdf-ion.jpg';
			}
			?>" width="48" height="48" alt=""/></div>
		<div class="file-text">
         <a href="<?php echo HTTP_ROOT.'files/upload/'.$uf['FileUpload']['file_name'];?>" target="_blank"> <h5><?php
   		$new_text = wordwrap($uf['FileUpload']['org_file_name'], 29, "<br/>\n", true);
		echo $new_text;?></h5></a>
		</div>
		</div>
		<?php
		}
}
else
{
	echo 'There are no uploaded file.';  
}
?>
</div>

<div class="profileAjaxImage2">
<?php echo $html->image("frontend/ajax-loader.gif") ?>
</div>

<?php        
if(!empty($uploadFile))
{
?>

<input type="hidden" name="uploadcnt" id="uploadcnt" value="<?php echo $countuploadFile;?>"  />

<!-- pagination starts -->
<div class="paging" id="users-paging-view">
    
	<?php echo $paginator->prev(' '.__('Prev Page', true), array(), null, array('class'=>'disabled'));?> 
  
    
    <span style="float:left; margin-right: 2px; padding: 3px 4px;">|</span>
        
  
	<?php echo $paginator->next(__('Next Page', true).' ', array(), null, array('class' => 'disabled'));?>
  
</div>
<!-- pagination ends -->



<?php
}
else
{
?>	
<input type="hidden" name="uploadcnt" id="uploadcnt" value="<?php echo $countuploadFile;;?>"  />	
<?php     
}
?>
