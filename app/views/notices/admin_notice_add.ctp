<script>
$(document).ready(function(){
/*	$('#submitBtn').click(function() {
		var content = tinyMCE.activeEditor.getContent();
		$('#tinyTextArea').val(content);
	}); */
 	
});



function checkCheckBoxes(theForm) {
	
	if (!document.getElementById('group_id6').checked && !document.getElementById('group_id7').checked && !document.getElementById('group_id8').checked && !document.getElementById('group_id9').checked) 
	{
		$("#group_id9").addClass("required");
		return false;
	} else { 	
		return true;
	}
}



</script>
<div id="content">
	<div id="content-top">
   
    
      <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
      <?php  echo $this->element('adminElements/left-sidebar'); ?>
	  <!-- start of div#mid-col -->
	<div id="mid-col">
    
        
        	
		<div class="box">
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Manage Notice add </h4>
			<div id="articleAddPanel" style="min-height:520px;">
            
                           <div id="flashmsg" style="float:left; padding-left:10px; padding-bottom:10px;"><b><?php echo $this->Session->flash(); ?></b></div><br />



<form accept-charset="utf-8" action="<?php echo HTTP_ROOT.'admin/notices/notice_add';?>" method="post" id="noticeadd" class="middle-forms" onsubmit="return checkCheckBoxes(this);">
<?php
if($this->params['pass'][0])
{
?>
<input type="hidden" name="data[Notice][id]" value="<?php echo $this->params['pass'][0];?>"  />	
<?php	
}
?>




			<?php // echo $form->create('notice',array('class' => 'middle-forms','id'=>'noticeadd',"url" => $html->url(array("admin" => true), true))); ?>
            

            
			<?php //echo $form->create('Member',array('class' => 'middle-forms',"id"=>"UserAddForm","url" => $html->url(array("admin" => true), true))); ?>
            <div class="innerContainerInsideFieldset">
                                <div class="fieldContainerByDpkMahendru">
                                    <label for="UserGroup" class="field-title dpkLab20" >User Type : </label>
                                    
                                    <?php
									 $group = explode(",", $this->data['Notice']['group_id']);
									?>
                                             Non-Profit                                   
                                             <input type="checkbox" name="data[Notice][group_id6]" id="group_id6" value="6" 
                                             <?php
                                             if (in_array("6", $group)) {
                                             echo "checked=\"checked\"";
											 }
                                             ?>  />                                    
                                             Tutor
                                              <input type="checkbox" name="data[Notice][group_id7]" id="group_id7" value="7"
                                             <?php
                                             if (in_array("7", $group)) {
                                             echo "checked=\"checked\"";
											 }
                                             ?>  />                                 
                                             Student
                                            <input type="checkbox" name="data[Notice][group_id8]" id="group_id8" value="8"
                                            <?php
                                             if (in_array("8", $group)) {
                                             echo "checked=\"checked\"";
											 }
                                             ?> />
                                             Parent
                                            <input type="checkbox" name="data[Notice][group_id9]" id="group_id9" value="9"
                                            <?php
                                             if (in_array("9", $group)) {
                                             echo "checked=\"checked\"";
											 }
                                             ?> />
                                    </div>
                                      
                                      </div>
			<br/>
            <br/>
          
			
			<label for="NoticeQuestion" >Heading :</label><?php echo $form->input('Notice.notice_head',array('type'=>'text','label'=>'','div' => 'inputbox','class'=>'required txtbox-long')); ?><br /><br />
            
            <label for="NoticeQuestion" style="margin-right: 36px;" >Text :</label>
            
           
            
					<?php  echo $form->textarea('Notice.notice_text',array('class'=>'required','label'=>'','div' => 'entryField','id'=>'tinyTextArea','rows'=>'5','cols'=>'35')); ?>            
            
			
			<div id="submit-buttons" style="margin-left: 61px; margin-top: 22px; text-align:left;">
					<?php  echo $form->submit('Submit',array('div' => false,"id"=>"submitBtn")); ?>
			</div>
			</div>
		</div>
        
	</div>
<!-- end of div#mid-col -->
    <span class="clearFix">&nbsp;</span>     
</div>