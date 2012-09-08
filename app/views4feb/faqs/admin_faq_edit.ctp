<script>
$(document).ready(function(){
	$('#submitBtn').click(function() {
		var content = tinyMCE.activeEditor.getContent();
		$('#tinyTextArea').val(content);
	}); 
 	$('#faqedit').validate({
		rules:
			{
				"data[Faq][question]":
						{
							required:true
						}					
			},
		messages:
			{
					"data[Faq][question]":
						{
							required:"Please Edit the question,You can't leave it blank"
						}
			}	
	});
});
</script>
<div id="content">
	<div id="content-top">
    <h2>Send Reply</h2>
     
      <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
      <?php  echo $this->element('adminElements/left-sidebar'); ?>
	  <!-- start of div#mid-col -->
	<div id="mid-col">    	
		<div class="box">
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">FAQ's &nbsp; Edit</h4>
			<div id="articleAddPanel">
			
			<br /><br />
			<?php  echo $form->create('Faq',array('class' => 'middle-forms','id'=>'faqedit',"url" => $html->url(array("admin" => true), true))); ?>
			<?php //echo $form->create('Member',array('class' => 'middle-forms',"id"=>"UserAddForm","url" => $html->url(array("admin" => true), true))); ?>
            
			<input type="hidden" name="faqid" id="faqid" value="<?php echo $this->data['Faq']['id'];?>"   />
			
			<label for="FaqQuestion" >Question :</label><?php echo $form->input('Faq.question',array('type'=>'text','label'=>'','div' => 'inputbox','class'=>'required txtbox-long')); ?><br /><br />
			<div><h1><b>Answer</b></h1>
				<div align="center">
					<?php  echo $form->textarea('Faq.answer',array('class'=>'tinymce required','label'=>'','div' => 'entryField','id'=>'tinyTextArea')); ?>
				</div><br />
				
			</div>
			<div id="submit-buttons">
			<?php  //echo $form->input( 'group_id', array( 'value' => 'group_id'  , 'type' => 'hidden') ); ?>
					<?php echo $form->input('id', array('type'=>'hidden')); ?>	
					<?php  echo $form->submit('Submit',array('div' => false,'id'=>'submitBtn')); ?>
				</div>
			</div>
		</div>
	</div>
<!-- end of div#mid-col -->
    <span class="clearFix">&nbsp;</span>     
</div>