

<script type="text/javascript">

	$(document).ready(function() {
							   
			$('#mid-col').css('width','');
			$('#left-col').hide();
			
			$('#mid-col').attr('class','addWidth').css('width','100%').show(//"clip", { direction: "horizontal" }, 2000
			);
								
							   });
	

function resetdata()
	{
	/*	document.getElementById('tutorname').value = '';
		document.getElementById('studentname').value = '';*/
		document.getElementById('perpage').value = '';
		document.getElementById('status').value = '';
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
		<h2>Tutoring session
        
        <?php 
		$id = $this->params['pass'][0];?>
        </h2>
     
      <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
    <?php echo $this->element('adminElements/left-sidebar'); ?>
	 	 <!--start of div#mid-col -->
	<div id="mid-col">    	
		<div class="box">
			
            	<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Tutoring session<a href="javascript:void(0);" class="expandGrid">SHRINK GRID</a></h4>
            
            
			<div id="userAddPanel"> 
			
			<div class="slide_toggle" style="background-color: rgb(229, 238, 204); margin:0px;width:auto; padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px; font-weight:bold; font-size:14px; " >Filter data (click to show)</div>
			
			<div class="slide" style="background-color:#F1F1F1;">
			<?php //pr($this->data);?>
				<?php echo $form->create('member',array("url" => $html->url(array('action'=>'allsession',$id,"admin" => true), true)));?>
						<table class="table-filter" style="width: 100%; float: left; border-bottom: 2px solid;">
				<?php	/*		<tr class="">
								<td style="text-align:right;" class=""><b>Tutor name :</b></td>
								<td style="text-align:left; padding-left:10px; "> 
                                
                                 <?php echo $form->input('PaymentHistory.tutorname',array('id'=>'tutorname','label'=>false)); ?></td>
                                
                               <td style="text-align:right;" class=""><b>Student name :</b></td>
							   <td style="text-align:left; padding-left:10px; ">  <?php echo $form->input('PaymentHistory.studentname',array('id'=>'studentname','label'=>false)); ?></td>
                               
                              
								
							</tr>*/ ?>
							
							<tr class="">
								<td style="text-align:right;" class=""><b>Results Per Page :</b></td>
								<td style="text-align:left; padding-left:10px; "><?php echo $form->select('PaymentHistory.perpage',array('5'=>'5','10'=>'10','20'=>'20','30'=>'30','50'=>'50','100'=>'100'),null,array("id"=>'perpage'),false); ?> </td>
                                
                                <td style="text-align:right;" class="col-chk2"><b>Session Status :</b></td>
								
                                <td style="text-align:left; padding-left:10px;">
                                
                                <?php echo $form->select('PaymentHistory.session_status',array(''=>'Select Status','Booked'=>'Awaiting Approval','Accepted'=>'Awaiting Payment','Paided'=>'Upcoming Sessions','Completed'=>'Completed Sessions','Rejected'=>'Rejected Sessions','Refund'=>'Refund','Refunded'=>'Refunded'),null,array("id"=>'status'),false); ?>
                                
                                 <!--<select name="data[PaymentHistory][session_status]" id="groupid" style="width:150px";>
                                    <option value=""> Select Status</option>
                                    <option value="Booked">Awaiting Approval</option> 
                                    <option value="Accepted">Awaiting Payment</option>
                                    <option value="Paided">Upcoming Sessions</option>
                                    <option value="Completed">Completed Sessions</option>
                                    <option value="Rejected">Rejected Sessions</option>
                                    <option value="Refund">Refund Request</option>
                                    <option value="Refunded">Refunded</option>
                                    </select>-->
                                    
                                    </td>
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
										<input type="button"  value="Clear All"  style=" width:100px; margin-left:20px; background-color:#B3BBC2; color:#FFFFFF" onclick="resetdata();" />
							
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
			
					<?php echo $form->input('pagingStatus',array('type' => 'hidden','value'=>HTTP_ROOT.'admin/members/allsession/'.$id.'/page:1','id' => 'pagingStatus')); ?>
					&nbsp;&nbsp;
                   
                    <br/>
				
				<div class="box">
		
						<div id="pagingDivParent">
							<?php echo $this->element('adminElements/members/allsession'); ?>
						</div>
                        
                        
					</div>
				</div>
												
			</div>
		</div>
	</div>			<!-- end of div#mid-col -->
    <span class="clearFix">&nbsp;</span>     
</div>