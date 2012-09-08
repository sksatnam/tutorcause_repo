<?php //pr($this->data);?>
<div id="content">
	<div id="content-top">
    	<h2>MailChimp Subscribe</h2>
       <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	<div id="mid-col">    	
		<div class="box">
        <?
      //  echo '<pre>';
		//print_r($_SESSION);
		?>
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Mail Chimp Subscribe</h4>
			<div id="userAddPanel" style="min-height:520px;">
            
             <div id="flashmsg" style="float:left; padding-left:10px; padding-bottom:10px;"><b><?php echo $this->Session->flash(); ?></b></div><br />
                 <?php echo $form->create('member', array('action' => 'member_subscribe','admin'=> true,'id'=>'subscribe')); ?>
			     
				<div class="paddinSet">
					<fieldset id="personal-info">
						<legend>Subscribe Form.</legend>
						<div class="innerContainerInsideFieldset">
                        
                        <label class="dpkLab" for="Useremail" class="field-title">Mail chimp Lists : </label>
                        <select name="data[id]">
                        <?php 
						foreach($lists[data] as $lt)
						{
						?>	
						<option value="<?php echo $lt['id'];?>"><?php echo $lt['name'];?></option>	
						<?	
						}
						?></select>
                        <br /><br />
							<label class="dpkLab" for="Useremail" class="field-title">Email : </label>
							<input name="data[email]" type="text" maxlength="50" value="<?php echo $memberdata['UpcomingMember']['email'] ?>" />
							<br /><br />
                            
							<label class="dpkLab" for="UserPassword" class="field-title">Name :</label>
							<input type="text" name="data[first]" value="<?php echo $memberdata['UpcomingMember']['name'] ?>" />
							<br /><br />
							<input type="hidden" name="data[member_id]" value="<?php echo $memberdata['UpcomingMember']['id'] ?>" />
						</div>
					</fieldset>
					<div id="submit-buttons" style="padding-top:10px;">
							<?php  echo $form->submit('Submit',array('div' => false)); ?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- end of div#mid-col -->
   <span class="clearFix">&nbsp;</span>     
</div>