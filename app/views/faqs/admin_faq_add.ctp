<?php //3aug2012 ?><script>
$(document).ready(function(){
	$('#submitBtn').click(function() {
		var content = tinyMCE.activeEditor.getContent();
		$('#tinyTextArea').val(content);
	}); 
 	$('#faqadd').validate({
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
							required:"Please write the question"
						}
			}	
	});
});
</script>
<div id="content">
	<div id="content-top">
   
    
      <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
      <?php  echo $this->element('adminElements/left-sidebar'); ?>
	  <!-- start of div#mid-col -->
	<div id="mid-col">    	
		<div class="box">
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Add FAQ</h4>
			<div id="articleAddPanel" style="min-height:520px;">
			
			<br /><br />
			<?php  echo $form->create('Faq',array('class' => 'middle-forms','id'=>'faqadd',"url" => $html->url(array("admin" => true), true))); ?>
			<?php //echo $form->create('Member',array('class' => 'middle-forms',"id"=>"UserAddForm","url" => $html->url(array("admin" => true), true))); ?>
            <div class="innerContainerInsideFieldset">
                                <div class="fieldContainerByDpkMahendru">
                                    <label for="UserGroup" class="field-title dpkLab20" >User Type : </label>
                                    <select name="data[Faq][group_id]"   class="required" id="group" style="width:150px" onchange="schooladmin();">
                                    
                                    <option value=""> Select User Type</option>
                                    <option value="6">Cause</option>
                                    <option value="7">Tutor</option>
                                    <option value="8">Student</option>
                                    <option value="9">Parent</option>
                                    </select>
                                      </div>
                                      </div>
			<br/>
            <br/>
            <br/>
            <br/>
			
			<label for="faqQuestion" >Question :</label><?php echo $form->input('Faq.question',array('type'=>'text','label'=>'','div' => 'inputbox','class'=>'required txtbox-long')); ?><br /><br />
			<div><h1><b>Answer </b></h1>
				<div align="center">
					<?php  echo $form->textarea('answer',array('class'=>'tinymce required','label'=>'','div' => 'entryField','id'=>'tinyTextArea')); ?>
				</div><br />
				
			</div>
			<div id="submit-buttons">
<?php /*?>					<?php  echo $form->input( 'group_id', array( 'value' => '3'  , 'type' => 'hidden') ); ?>
<?php */?>					<?php  echo $form->submit('Submit',array('div' => false,"id"=>"submitBtn")); ?>
				</div>
			</div>
		</div>
	</div>
<!-- end of div#mid-col -->
    <span class="clearFix">&nbsp;</span>     
</div>