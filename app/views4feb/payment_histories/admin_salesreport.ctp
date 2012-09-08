
  <script type="text/javascript">
	$(document).ready(function() {
							   
			$('#mid-col').css('width','');
			$('#left-col').hide();
			
			$('#mid-col').attr('class','addWidth').css('width','100%').show(//"clip", { direction: "horizontal" }, 2000
			);
							   	
							/*	$('tr#header td a').live("click",function() {
																	
																   var actUrl=$(this).attr("href");
																   
																   $.ajax({
																		  	type:"post",
																			url:actUrl,
																			success:function(msg) {
																				$('#pagingDivParent').html(msg);
																			}
																		  });
													return false;
													})*/
								
								
								
							   });
	
	
	function resetcourse()
	{
		document.getElementById('DateFrom').value = '';
		document.getElementById('DateTo').value = '';
		document.getElementById('perpage').value = 10;
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
        
        
        	<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">View Payments<a href="javascript:void(0);" class="expandGrid">EXPAND GRID</a></h4>
        
            
			<div id="userAddPanel" >
			
			<div class="slide_toggle" style="background-color: rgb(229, 238, 204); margin:0px;width:auto; padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px; font-weight:bold; font-size:14px; " >Filter data (click to show)</div>
			
			<div class="slide" style="background-color:#F1F1F1;">
            
            
		 <?php echo $this->Form->create('payment_histories', array("url" => $html->url(array('action'=>'salesreport',"admin" => true), true))); ?>

						<table class="table-filter" style="width: 100%; float: left; border-bottom: 2px solid;">
							<tr class="">
								<td style="text-align:right;" class=""><b>Paypal From Date :</b></td>
								<td style="text-align:left; padding-left:10px; "> <?php echo $form->input('PaymentHistory.dateFrom',array('id'=>'DateFrom','label'=>false, 'class'=>'datepicker')); ?></td>

                                <td style="text-align:right;" class=""><b>Paypal To Date :</b></td>
								<td style="text-align:left; padding-left:10px; "> <?php echo $form->input('PaymentHistory.dateTo',array('id'=>'DateTo','label'=>false, 'class'=>'datepicker')); ?></td>
  								
                              
							</tr>
                            
                            <tr class="">
								
                                	<td style="text-align:right;" class=""><b>Results Per Page :</b></td>
								<td style="text-align:left; padding-left:10px; "><?php echo $form->select('PaymentHistory.perpage',array('5'=>'5','10'=>'10','20'=>'20','30'=>'30','50'=>'50','100'=>'100'),null,array("id"=>'perpage'),false); ?> </td>
                      			
							<td></td>
                            <td></td>	
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
<input type="reset" value="Reset"  style="width:100px; margin-left:20px; background-color:#B3BBC2; color:#FFFFFF" />
							
									</div>
								</td>
                                
                                      
                            
						
                                
							</tr>							
						</table>
			
			<?php echo $form->end(); ?>	
			</div>
            
            <div style="-moz-border-radius-bottomleft: 5px;-moz-border-radius-bottomright: 5px;" class="box-container rounded_by_jQuery_corners">
			
		
					<?php echo $form->input('pagingStatus',array('type' => 'hidden','value'=>HTTP_ROOT.'admin/payment_histories/salesreport/','id' => 'pagingStatus')); ?>
					&nbsp;&nbsp;&nbsp;
                     <div align="right"><?php echo $html->link("Export to Excel",array('controller'=>'payment_histories', 'action'=>'exportpaymentcsv','admin' => true)); ?></div>
				  	
                
				<div class="box">
						<div id="flashmsg" style="float:left; padding-left:10px; padding-bottom:10px;"><b><?php echo $this->Session->flash(); ?></b></div>
                		
						<div id="pagingDivParent">
							<?php echo $this->element('adminElements/payments/payment_history_paging'); ?>
						</div>
                        
                 </div>       
                        
                        
				
				</div>
				
			</div>
		</div>  	
    
    
    

        
       	</div>			<!-- end of div#mid-col -->
    <span class="clearFix">&nbsp;</span>     
</div> 