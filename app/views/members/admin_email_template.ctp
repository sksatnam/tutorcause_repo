<script type="text/javascript">
	
$(document).ready(function() {
							   
			$('#mid-col').css('width','');
			$('#left-col').hide();
			
			$('#mid-col').attr('class','addWidth').css('width','100%').show(//"clip", { direction: "horizontal" }, 2000
			);
							   	
							
								
							   });
</script>
	

<div id="content">
	<?php //pr($staticdatas);die; ?>
	<div id="content-top">
		<h2>View Template</h2>
      <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
    <?php echo $this->element('adminElements/left-sidebar'); ?>
	 	 <!--start of div#mid-col -->
	<div id="mid-col">    	
		<div class="box">
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Email Template<a href="javascript:void(0);" class="expandGrid">SHRINK GRID</a></h4>
			<div id="userAddPanel" >
				<div id="savingStatus">
				<?php $session->flash(); ?></div>				
				<?php echo $form->create('Member',array('class' => 'middle-forms','id' => 'UserViewForm',"url" => $html->url(array("admin" => true), true))); ?>
				<div class="box">
					
					<div style="-moz-border-radius-bottomleft: 5px;-moz-border-radius-bottomright: 5px;" class="box-container rounded_by_jQuery_corners">
						<div id="bulk-selection" style="float:left; width:95%; padding-top:8px; padding-bottom:5px; padding-left:10px;">
							<b>Icons used :</b>	&nbsp;&nbsp;
							<?php echo $html->image('icon-edit.gif');?>Edit &nbsp;&nbsp;&nbsp;&nbsp;
							
						</div>
						<div id="flashmsg"><b><?php $session->flash();?></b></div><br />
						<div style="clear:both"></div>
						<div id="pagingDivParent">
						<div style="clear:both"></div>
							<table class="table-short" style="width:100%;" border="0">
								<tr id="">
									<td style="width:100px;"><b>S.No.</b></td>
									<td><b>Title</b></td>
									<td><b>Description</b></td>
									<td><b>Action</b></td>
								</tr>	
								<?php $snum=1;
									foreach($staticdatas as $staticdata){
								?>
								
								<tr class="odd">
									<td class="col-chk1"><?php echo $snum; ?></td>
									<td class="col-chk3"><?php echo $staticdata['EmailTemplate']['title']; ?></td>
									<td class="col-chk3"><?php if(strlen($staticdata['EmailTemplate']['desc']) >30){
																	$body=substr(strip_tags($staticdata['EmailTemplate']['desc']),0,30) . "...";
																	echo $body;
																}else {
																	echo strip_tags($staticdata['EmailTemplate']['desc']); 
																}?>
									</td>
									<td class="col-first"> 
										<?php echo $html->link($html->image('icon-edit.gif'),array('controller'=>'members', 'action'=>'edit_email_template','admin'=>true, $staticdata['EmailTemplate']['id']),array('escape' => false));?>
										
									</td>
								</tr>
								<?php $snum=$snum+1;} ?>
								
							</table>
						</div>
					</div>
				</div>
				<?php echo $form->end(); ?>													
			</div>
		</div>
	</div>			
    <span class="clearFix">&nbsp;</span>     
</div>
