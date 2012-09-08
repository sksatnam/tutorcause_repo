<?php //pr($this->data);die;?>
<div id="content">
	<div id="content-top">
    <h2>Edit Email Template</h2>
      <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
      <?php  echo $this->element('adminElements/left-sidebar'); ?>
	  <!-- start of div#mid-col -->
	<div id="mid-col">    	
		<div class="box">
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners"><?php echo $this->data['EmailTemplate']['title']; ?> Update Form</h4>
			<div id="articleAddPanel">
			<div id="flashmsg"><b><?php $session->flash();?></b></div>
			<?php /*?><div id="content-top">
			  <a href="#" id="topLink">Back To Other Pages</a> 
			  <span class="clearFix">&nbsp;</span>
			 </div><?php */?>
			<div id="loading" class="fixedCenter">	<?php //echo $html->image('loading.gif'); ?>
				<?php  //echo $html->image('spinner.gif'); ?>
			</div>
			<div style="clear:both"></div>
			<?php  echo $form->create('Member',array('class' => 'middle-forms',"url" => $html->url(array('controller'=>'members','action'=>'edit_email_template',"admin" => true, $id ), true))); ?>
			
			
			<!--<label for="FaqQuestion" >Static Text :</label>-->
				<br /><br /><label><?php echo $this->data['EmailTemplate']['title']; ?> </label>
				<br /><label><?php echo $this->data['EmailTemplate']['html_content']; ?> </label> <br />
                
				<hr />
					<label style="color:#FF0000; font-weight:bold;">
						Please Do not change these variables : &nbsp;</label><br /><br />
					<label style="color:#FF0000; font-weight:normal;">
					<?php echo $this->data['EmailTemplate']['allowed_vars']; ?>
					</label>
					<br clear="all"/><br /><br />                  
				<label for="ArticleTitle" >Title :</label> <?php echo $this->data['EmailTemplate']['title']; ?>
			    <br clear="all"/>  <br />                             
            	<label for="ArticleTitle" >Subject :</label><?php 
																		echo $form->input('EmailTemplate.subject',array('type'=>'text','label'=>'','div' => 'inputbox','class'=>'required txtbox-long'));
																		
													 ?>                                         
			<div><h1><b>Body</b></h1>
			
				<div align="center">
                
                  	<?php echo $form->input('EmailTemplate.title', array('type'=>'hidden')); ?>
					<?php echo $form->input('staticid', array('type'=>'hidden', 'value'=> $id)); ?>
					<?php  echo $form->textarea('EmailTemplate.html_content',array('class'=>'tinymce','label'=>'','div' => 'entryField')); ?>
				</div><br />
			</div>
			<div id="submit-buttons">
					<?php  echo $form->submit('Submit',array('div' => false)); ?>
				</div>
			</div>
		</div>
	</div>
<!-- end of div#mid-col -->
    <span class="clearFix">&nbsp;</span>     
</div>


