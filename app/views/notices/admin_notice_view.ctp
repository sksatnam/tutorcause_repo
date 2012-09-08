<script type="text/javascript">
	
	$(document).ready(function() {
							   
			$('#mid-col').css('width','');
			$('#left-col').hide();
			
			$('#mid-col').attr('class','addWidth').css('width','100%').show(//"clip", { direction: "horizontal" }, 2000
			);
							   	
							
								
							   });
	
</script>
    
    <div id="loading" class="fixedTop" style="font-size:14px">
             Loading..
    </div>
         
         
  <div id="content">
	<div id="content-top">
   
      <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
    <?php echo $this->element('adminElements/left-sidebar'); ?>
	 	 <!--start of div#mid-col -->
	<div id="mid-col">  
    
    <div class="box">
        
        
        	<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">View Notices<a href="javascript:void(0);" class="expandGrid">SHRINK GRID</a></h4>
        
            
			<div id="userAddPanel" >
			
			<div class="slide_toggle" style="background-color: rgb(229, 238, 204); margin:0px;width:auto; padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px; font-weight:bold; font-size:14px; " >Filter data (click to show)</div>
			
			<div class="slide" style="background-color:#F1F1F1;">
			<?php //pr($this->data);?>
			<?php echo $form->create('Notice',array('class' => 'middle-forms','id' =>'ParentFaqViewForm',"url" => $html->url(array("admin" => true), true))); ?>
			<table class="table-filter" style="width: 100%; float: left; border-bottom: 2px solid;">
							<tr class="">
								 <td style="text-align:right;" class="col-chk2"><b>User Type :</b></td>
                                 
                                 
                                    <td>
                                             <input type="checkbox" name="data[Notice][group_id6]" value="6" 
                                             <?php
                                             if ($this->data['Notice']['group_id6']) {
                                             echo "checked=\"checked\"";
											 }
                                             ?>  />Non-Profit                                    
                                              <input type="checkbox" name="data[Notice][group_id7]" value="7"
                                             <?php
                                             if ($this->data['Notice']['group_id7']) {
                                             echo "checked=\"checked\"";
											 }
                                             ?>  />Tutor                                 
                                            <input type="checkbox" name="data[Notice][group_id8]" value="8"
                                            <?php
                                            if ($this->data['Notice']['group_id8']) {
                                             echo "checked=\"checked\"";
											 }
                                             ?> />Student
                                             <input type="checkbox" name="data[Notice][group_id9]" value="9"
                                            <?php
                                            if ($this->data['Notice']['group_id9']) {
                                             echo "checked=\"checked\"";
											 }
                                             ?> />Parent
                                 
                                    </td>
                                
           <td style="text-align:right;" class=""><b>Results Per Page :</b></td>
								<td style="text-align:left; padding-left:10px; "><?php echo $form->select('perpage',array('5'=>'5','10'=>'10','20'=>'20','30'=>'30','50'=>'50','100'=>'100'),null,array("id"=>'perpage'),false); ?> </td>                     
        </tr>
        
        <tr class="">
								<td ></td>
								<td >
									<div class="searchBut">
										<input type="submit" value = "Filter" style=" width:100px; background-color:#B3BBC2; color:#FFFFFF"/> 
									</div>
								</td>
							
                                
                                   <td>
									<div class="resetschview">
<input type="reset" value="Reset"  style=" width:100px; margin-left:20px; background-color:#B3BBC2; color:#FFFFFF" />
							
									</div>
								</td>
                                
                                
                                
							</tr>
        
        </table>
            <?php echo $form->end(); ?>	
			</div>
                           
           
           
            
					<?php /*?><?php echo $form->create('Faq',array('class' => 'middle-forms','id' =>'ParentFaqViewForm',"url" => $html->url(array("admin" => true), true))); ?><?php */?>
			<div id="bulk-selection" style="float:left; width:97%; padding-top:8px; padding-bottom:5px; padding-left:10px;">
						<!--<b>Bulk Delete:</b><?php //echo $form->select('bulkAction',array(''=>'With Selected','delete' => 'Delete Selected'),null,array(),false); ?>-->
						
						<input type="hidden" id="pagingStatus" value="<?php echo HTTP_ROOT.'admin/notices/notice_view/';?>" />
						
							<?php // echo $form->input('pagingStatus',array('type' => 'hidden','value'=>'http://' . $_SERVER['HTTP_HOST'] . '/tutor/admin/notices/notice_view/','id' => 'pagingStatus')); ?>
					 <b>Icons used :</b>	
						<?php echo $html->image('icon-edit.gif');?>Edit &nbsp;&nbsp;&nbsp;&nbsp;
						<?php echo $html->image('icon-delete.gif');?>Delete &nbsp; &nbsp;&nbsp;&nbsp; 
						<?php //echo $html->image('edit_profile.png');?> &nbsp;&nbsp;&nbsp;&nbsp;
						<?php //echo $html->image('User Icon.jpg', array('height'=> 20,'width'=> 20));?>
						
					</div>
				
			
				<div class="box">
					
					<div id="flashmsg" style="text-align:center;"><b><?php echo $session->flash();?></b></div>
                    
                <?php /*?>    <center><div id="flashmsg" style= padding-left:10px; padding-bottom:10px;"><b><?php echo $this->Session->flash(); ?></b></div></center><?php */?>
                    
                    <div style="-moz-border-radius-bottomleft: 5px;-moz-border-radius-bottomright: 5px;" class="box-container rounded_by_jQuery_corners">
						<?php /*?><div id="flashmsg"><b><?php $session->flash();?></b></div><br /><?php */?>
                     <div id="flashmsg" style="float:left; padding-left:10px; padding-bottom:10px;"><b><?php echo $this->Session->flash(); ?></b></div>   
                        
						<div style="clear:both"></div>
						<div id="pagingDivParent" >
							<?php echo $this->element('adminElements/notice_paging'); ?> 
						</div>
					
					</div>
				</div>	
				<?php echo $form->end(); ?>				
			</div>
		</div>
	</div>			<!-- end of div#mid-col -->
    <span class="clearFix">&nbsp;</span>     
</div>