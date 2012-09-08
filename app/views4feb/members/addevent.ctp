<script type="text/javascript">
$(document).ready(function(){
	$('#calendar1').datetimepicker({
		ampm: true
	});
	$('#calendar2').datetimepicker({
		ampm: true
	});
});
</script>
<div id="content" style="margin-bottom:25px;">
<div class="stepsHeadingNew">
                    
                        <div class="newProgressBarOuter">
                        	<div class="proBarsSection1">
                            	<span class="spanNo">1</span>
                                <span class="spanOnHover">Registration</span>

                            </div>
                            <div class="proBarsSection1">
                            	<span class="spanNo">2</span>
                                <span class="spanOnHover">Tutor Payment</span>
                            </div>
                            <div class="proBarsSection2">
                            	<span class="spanNo">3</span>
                                <span class="spanOnHover">Set Availablity</span>
      
                            </div>
                            <div class="proBarsSection3">
                            	<span class="spanNo">4</span>
                                <span class="spanOnHover">Add Courses</span>
                            </div>
                        </div>
                    
                    <h1> Set Availability </h1>
                    
                    
                    	<div class="stepFormContButton button">  
                    	<span></span>
                        <a href="<?php echo HTTP_ROOT.'members/calendar'?>"><input type="button" value="Preview" /></a>
                        </div>
                        
                        <div class="stepFormContButton button">  
                    	<span></span>
                        <a href="<?php echo HTTP_ROOT.'members/schoolinfo'?>"><input type="button" value="Submit" /></a>
                        </div> 
                    
                    
                </div>

            	               
                
              
              
			<!--stepFormRow-->
			<div class="stepFormRow">
				<div class="myJobsTable">
					<table width="960" cellspacing="0" >
						<tr class="tableBg1" >
							<th>S.No</th>
							<th>Start date</th>
							<th>End date</th>
							<th>Action</th>
						</tr>
						<?php 
						$i = 1;
						foreach($tutevent as $te)
						{
							if($i%2==0)
							{
								echo '<tr>' ;
							}
							else
							{
								echo "<tr style='background:#f1f1f1;'>";	 
							}
							?>	

							<td><?php echo $i;?></td>
							<td><?php echo date('d - m - Y h:i A',strtotime($te['TutEvent']['start_date']));?></td>
							<td><?php echo date('d - m - Y h:i A',strtotime($te['TutEvent']['end_date']));?></td>
							<td> <?php echo $html->link('Delete', array('action'=>'deleteEvent', $te['TutEvent']['id']), array('title' => 'Delete')); ?> </td>
							</tr>
							</tr>
					<?php	$i++; 
						}
						if(count($tutevent)==0)
						{
							?> 
							<tr style="background:#f1f1f1;">
							<td colspan="4">No Record Found</td>
							</tr>
				<?php	}	?>
					</table>
				</div>
			</div>
			<!--stepFormRow-->
            
            <?php echo $paginator->prev('<< '.__('Previous', true), array(), null, array('class'=>'disabled'));?>
	<?php echo $paginator->numbers(array('separator' => false));?>
	<?php echo $paginator->next(__('Next', true).' >>', array(), null, array('class' => 'disabled'));?>
                            
                
            </div>

