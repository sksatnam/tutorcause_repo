<?php 
/*echo '<pre>';
print_r($this->data);
die;
*/?>
<div id="content">
	<div id="content-top">
    <h2>CMS PAGES</h2>
      <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
      <?php  echo $this->element('adminElements/left-sidebar'); ?>
	  <!-- start of div#mid-col -->
	<div id="mid-col">    	
		<div class="box">
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners"><?php echo $this->data['Page']['name']; ?> Update Form</h4>
			<div id="articleAddPanel">
			<div id="flashmsg"><b><?php $session->flash();?></b></div>
			
			<?php  echo $form->create('Member',array('class' => 'middle-forms',"url" => $html->url(array('controller'=>'members','action'=>'static_page_edit',"admin" => true, $id ), true))); ?>
			
			
			<!--<label for="FaqQuestion" >Static Text :</label>-->
				<br /><br /><label><?php echo $this->data['Page']['name']; ?> </label>
				<br /><label><?php echo $this->data['Page']['body']; ?> </label> <br />
				<?php if($this->data['Page']['allowed_vars']){?><hr />
					<label style="color:#FF0000; font-weight:bold;">
						Please Do not change these variables : &nbsp;</label><br /><br />
					<label style="color:#FF0000; font-weight:normal;">
						<?php echo $this->data['Page']['allowed_vars']?> <br />
					</label>
					<br /><br /><br /><br /><br />
				<?php } 
				?>
			<label for="ArticleTitle" >Title :</label><?php 
			echo $form->input('Page.name',array('type'=>'text','label'=>'','div' => 'inputbox','class'=>'required txtbox-long'));
			 ?>
			<div><h1><b>Body</b></h1>
			
				<div align="center">
					<?php echo $form->input('staticid', array('type'=>'hidden', 'value'=> $id)); ?>
					<?php  echo $form->textarea('Page.body',array('class'=>'tinymce','label'=>'','div' => 'entryField')); ?>
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