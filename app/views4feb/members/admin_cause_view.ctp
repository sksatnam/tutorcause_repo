<script type="text/javascript">
$(document).ready(function() {
	$('#mid-col').css('width','');
	$('#left-col').hide();
	$('#mid-col').attr('class','addWidth').css('width','100%').show(//"clip", { direction: "horizontal" }, 0
	);
});
function resetcourse()
	{
		document.getElementById('MemberEmail').value = '';
		document.getElementById('userMetaAddress').value = '';
		document.getElementById('group').value = '';
		document.getElementById('perpage').value = '10';
		
	}

</script>

    <?php
	//echo '<pre>';
	//print_r($_SESSION);
	//die;
/*	$schoolarry = $this->params['pass'];
	$schoolid = $schoolarry[0];
*/	
	?>
    
    
    
    
    <div id="loading" class="fixedTop" style="font-size:14px">
             Loading..
    </div>
         
         
  <div id="content">
	<div id="content-top">
		<h2>Users</h2>
     
      <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
    <?php echo $this->element('adminElements/left-sidebar'); ?>
	 	 <!--start of div#mid-col -->
	<div id="mid-col">    	
		<div class="box">
			
            	<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">View Cause<a href="javascript:void(0);" class="expandGrid">SHRINK GRID</a></h4>
            
            
			<div id="userAddPanel">
			
			<div class="slide_toggle" style="background-color: rgb(229, 238, 204); margin:0px;width:auto; padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px; font-weight:bold; font-size:14px; " >Filter data (click to show)</div>
			
			<div class="slide" style="background-color:#F1F1F1;">
			<?php //pr($this->data);?>
				<?php echo $form->create('member',array("url" => $html->url(array('action'=>'cause_view',"admin" => true), true)));?>
                
               
                
						<table class="table-filter" style="width: 100%; float: left; border-bottom: 2px solid;">
							<tr class="">
								<td style="text-align:right;" class=""><b>Email :</b></td>
								<td style="text-align:left; padding-left:10px; ">  <?php echo $form->input('Member.email',array('label'=>false)); ?></td>
                                
                                <td style="text-align:right;" class=""><b>Status :</b></td>
								<?php /*?><td style="text-align:left; padding-left:10px; "><?php echo $form->select('active',array(''=>'All','1'=>'Active','0'=>'De-Active'),null,array(),false); ?></td><?php */?>
                                 <td style="text-align:left; padding-left:10px;">
                                    <select name="data[Member][active]" id="group" style="width:150px";>
                                    
                                    <option value=""> Select Type</option>
                                    <option value="1" <?php  
									if(isset($_SESSION['causeview']['active'])){
										echo ($_SESSION['causeview']['active']=="1")?'selected="selected"':'';
									}
									?>>Active</option>
                                    <option value="0"  <?php  
									if(isset($_SESSION['causeview']['active'])){
										echo ($_SESSION['causeview']['active']=="0")?'selected="selected"':'';
									}
									?>>De-Active</option>
                                  
                                    </select>
                                    </td>
								
								
							</tr>
							
                            <tr class="">
								<td style="text-align:right;" class=""><b>Cause Address :</b></td>
								<td style="text-align:left; padding-left:10px; ">  <?php echo $form->input('userMeta.address',array('label'=>false)); ?></td>
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
										<input type="button"  value="Clear All"  style=" width:100px; margin-left:20px; background-color:#B3BBC2; color:#FFFFFF" onclick="resetcourse();" />
							
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
            
            	<div style="-moz-border-radius-bottomleft: 5px;-moz-border-radius-bottomright: 5px;" class="box-container rounded_by_jQuery_corners">
			
					<?php echo $form->input('pagingStatus',array('type' => 'hidden','value'=>HTTP_ROOT.'admin/members/cause_view/page:1','id' => 'pagingStatus')); ?>
					&nbsp;&nbsp; <b>Icons used :</b>	
					<?php echo $html->image('icon-edit.gif');?>Edit &nbsp;&nbsp;&nbsp;
					<?php echo $html->image('icon-delete.gif');?>Delete &nbsp; &nbsp;&nbsp;
                    <div align="right"><?php echo $html->link("Export to Excel",array('controller'=>'members', 'action'=>'exportcausecsv','admin' => true)); ?></div>
			
			
                   
                    <br/>
				
				<div class="box">
		
						<div id="pagingDivParent">
							<?php echo $this->element('adminElements/members/viewcause'); ?>
						</div>
                        
                        
					</div>
				</div>
												
			</div>
		</div>
	</div>			<!-- end of div#mid-col -->
    <span class="clearFix">&nbsp;</span>     
</div>