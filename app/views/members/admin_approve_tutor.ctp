<style type="text/css">
.resetschview
{
/*	width:150px;*/
}

</style>

<script type="text/javascript">

	$(document).ready(function() {
							   
			$('#mid-col').css('width','');
			$('#left-col').hide();
			
			$('#mid-col').attr('class','addWidth').css('width','100%').show(//"clip", { direction: "horizontal" }, 2000
			);
								
							   });
	

function clearall()
	{
		document.getElementById('MemberEmail').value = '';
		document.getElementById('MemberName').value = '';
		document.getElementById('chooseschool').value = '';
		document.getElementById('perpage').value = '10';
	}

</script>

    <?
	//echo '<pre>';
	//print_r($_SESSION);
	//die;
	?>
    
    <div id="loading" class="fixedTop" style="font-size:14px">
             Loading..
    </div>
         
         
  <div id="content">
	<div id="content-top">
		<h2>Approve Tutor</h2>
        
                       <div id="flashmsg" style="float:left; padding-left:50px; margin-top:10px;"><b><?php echo $this->Session->flash(); ?></b></div><br />
        
        
        

        
     
      <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
    <?php echo $this->element('adminElements/left-sidebar'); ?>
	 	 <!--start of div#mid-col -->
	<div id="mid-col">    	
		<div class="box">
			
            	<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Approve Tutor<a href="javascript:void(0);" class="expandGrid">SHRINK GRID</a></h4>
            
            
			<div id="userAddPanel">
            
			
			<div class="slide_toggle" style="background-color: rgb(229, 238, 204); margin:0px;width:auto; padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px; font-weight:bold; font-size:14px; " >Filter data (click to show)</div>
			
			<div class="slide" style="background-color:#F1F1F1;">
			<?php //pr($this->data);?>
				<?php echo $form->create('Member',array("url" => $html->url(array('action'=>'approve_tutor',"admin" => true), true)));?>
						<table class="table-filter" style="width: 100%; float: left; border-bottom: 2px solid;">
							<tr class="">
								<td style="text-align:right;" class=""><b>Email :</b></td>
								<td style="text-align:left; padding-left:10px; ">  <?php echo $form->input('email',array('label'=>false)); ?></td>
                                
                                <td style="text-align:right;" class=""><b>Name :</b></td>
								
                                 <td style="text-align:left; padding-left:10px;">
                                    <?php echo $form->input('name',array('label'=>false)); ?>
                                    </td>
								
								
							</tr>
							
							<tr class="">
                            
                         
                                <td style="text-align:right;" class="col-chk2"><b>School :</b></td>
								
                                <td style="text-align:left; padding-left:10px;">
                                
                                 <select name="data[Member][school_id]" id="chooseschool" style="width:285px;">
                                 <option value=""  >Select School</option>
								<?php
                                foreach ( $schoolname as $key => $value ) {
									if($admindata['Member']['school_id']==$key)
									{
										echo "<option value=\"$key\" selected=\"selected\" >$value</option>";	
									}
									else
									{
										echo "<option value=\"$key\" >$value</option>";	
									}
								}
								?>
                                </select>
                                
                                
                                
                                

                            	</td>
                            
                            
                            
								<td style="text-align:right;" class=""><b>Results Per Page :</b></td>
								<td style="text-align:left; padding-left:10px;"><?php echo $form->select('perpage',array('5'=>'5','10'=>'10','20'=>'20','30'=>'30','50'=>'50','100'=>'100'),null,array("id"=>'perpage'),false); ?> </td>
                                
                                    
                                  
                                    
                                    
							</tr>	
							<tr class="">
								<td ><div class="resetschview">&nbsp;</div></td>
								<td >
									<div class="resetschview">
										<input type="submit" value = "Filter" style="background-color:#B3BBC2; color:#FFFFFF"/> 
									</div>
								</td>
								<td>
									<div class="resetschview">
										<input type="button"  value="Clear All"  style="margin-left:20px; background-color:#B3BBC2; color:#FFFFFF" onclick="clearall();" />
							
									</div>
								</td>
                                
                                   <td>
									<div class="resetschview">
<input type="reset" value="Reset"  style="margin-left:20px; background-color:#B3BBC2; color:#FFFFFF" />
							
									</div>
								</td>
                                
                                
                                
							</tr>							
						</table>
			
			<?php echo $form->end(); ?>	
			</div>
            
            	<div style="-moz-border-radius-bottomleft: 5px;-moz-border-radius-bottomright: 5px;" class="box-container rounded_by_jQuery_corners">
                

					<?php echo $form->input('pagingStatus',array('type' => 'hidden','value'=>HTTP_ROOT.'admin/members/approve_tutor/page:1','id' => 'pagingStatus')); ?>
					&nbsp;&nbsp; <b>Icons used :</b>	
					<?php echo $html->image('icon-view.gif');?> &nbsp; Approve Tutor 
 
                    
                    <br />
                    
                    

                    
				
				<div class="box">
		
						<div id="pagingDivParent">
							<?php echo $this->element('adminElements/members/approve_tutor'); ?>
						</div>
                        
                        
					</div>
				</div>
												
			</div>
		</div>
	</div>			<!-- end of div#mid-col -->
    <span class="clearFix">&nbsp;</span>     
</div>