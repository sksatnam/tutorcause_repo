<?php //3aug2012 ?><script type="text/javascript">
	$(document).ready(function() {
							   
							   	$('#mid-col').css('width','');
								$('#left-col').hide();
			
								$('#mid-col').attr('class','addWidth').css('width','100%').show("clip", { direction: "horizontal" }, 2000);
							   	
							   	$('tr#header td a').live("click",function() {
																	
																   var actUrl=$(this).attr("href");
																   
																   $.ajax({
																		  	type:"post",
																			url:actUrl,
																			success:function(msg) {
																				$('#pagingDivParent').html(msg);
																			}
																		  });
													return false;
													})
							   });
	
	
	function resetcourse()
	{
		document.getElementById('CourseCourseId').value = '';
		document.getElementById('SchoolSchoolName').value = '';
		document.getElementById('CourseCourseTitle').value = '';
	}
	
	
</script>
    <div id="loading" class="fixedTop" style="font-size:14px">
             Loading..
    </div>
         
         
  <div id="content">
	<div id="content-top">
		<h2>Schools</h2>
     
      <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
    <?php echo $this->element('adminElements/left-sidebar'); ?>
	 	 <!--start of div#mid-col -->
	<div id="mid-col">    	
		<div class="box">
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">View Course<a href="javascript:void(0);" class="expandGrid">EXPAND GRID</a></h4>
            
			<div id="userAddPanel" >
						
			<div class="slide_toggle" style="background-color: rgb(229, 238, 204); margin:0px;width:auto; padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px; font-weight:bold; font-size:14px; " >Filter data (click to show)</div>
			
			<div class="slide" style="background-color:#F1F1F1;">
		 <?php 
		 echo $this->Form->create('school', array("url" => $html->url(array('action'=>'all_course_view',"admin" => true), true))); ?>
         

						<table class="table-filter" style="width: 100%; float: left; ">
                        
							<tr class="">
                                
                               <td style="text-align:right;" class=""><b>Course Code :</b></td>
								<td style="text-align:left; padding-left:10px; ">  <?php echo $form->input('Course.course_id',array('label'=>false,"type"=>"text")); ?></td>
                      										
								<td style="text-align:right;" class=""><b>School Name :</b></td>
								<td style="text-align:left; padding-left:10px; ">  <?php echo $form->input('School.school_name',array('label'=>false,"type"=>"text")); ?></td>
                                
                                    
								
							</tr>
                            
                            <tr class="">
								<td style="text-align:right;" class=""><b>Course Title :</b></td>
								<td style="text-align:left; padding-left:10px; ">  <?php echo $form->input('Course.course_title',array('label'=>false,"type"=>"text")); ?></td>
                               
                                	<td style="text-align:right;" class=""><b>Results Per Page :</b></td>
								<td style="text-align:left; padding-left:10px; "><?php echo $form->select('Course.perpage',array('5'=>'5','10'=>'10','20'=>'20','30'=>'30','50'=>'50','100'=>'100'),null,array("id"=>'perpage'),false); ?> </td>
                      			
								
							</tr>
                      		
							<tr class="">
                            
                            <td>&nbsp;
                            
                            </td>
								
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
	

					<?php echo $form->input('pagingStatus',array('type' => 'hidden','value'=>HTTP_ROOT.'admin/schools/all_course_view/','id' => 'pagingStatus')); ?>
                    
                    &nbsp;&nbsp; <b>Icons used :</b>	
					<?php echo $html->image('icon-edit.gif');?>Edit &nbsp;&nbsp;&nbsp;
					<?php echo $html->image('icon-delete.gif');?>Delete &nbsp; &nbsp;&nbsp;	
					<center><div id="flashmsg" style= padding-left:10px; padding-bottom:10px;"><b><?php echo $this->Session->flash(); ?></b></div></center>
				<div class="box">
						<div id="flashmsg" style="float:left; padding-left:10px; padding-bottom:10px;"><b><?php echo $this->Session->flash(); ?></b></div>
						
						<div id="pagingDivParent">
							<?php echo $this->element('adminElements/schools/allcourseview'); ?>
						</div>
                        
                        
					</div>
				</div>
				
			</div>
		</div>
	</div>			<!-- end of div#mid-col -->
    <span class="clearFix">&nbsp;</span>     
</div>