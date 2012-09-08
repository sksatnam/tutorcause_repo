<?php
/*echo '<pre>';
print_r($causeResult);
die;*/

?>


<script type="text/javascript">	
$(document).ready(function () {
	$('#menu').tabify();
	$('#menu2').tabify();
	//Diolog Box
	$( "#dialog-form1" ).dialog({
		autoOpen: false,width: 400,modal: true,buttons:{
			"Send Message": function() {
				sendMessage();
			},
			Cancel: function() {
				$( this ).dialog("close");
			}
		}
	});
	
	/* $(".sendMessage").click(function() {
			$('#toTutName').html($(this).parent().next().next().val());
			$('#toTutId').val($(this).parent().next().val());
			var subject = $(this).parent().next().next().next().val();
			$('.StudentSubbject').html(subject);
			$('#subject').val(subject);
			$("#dialog-form1").dialog("open");
	}); */
	
	$('.grantChange').click(function(){
		if($(this).text()=='Change'){
			$(this).parent().find('.grantLavel').hide();
			$(this).parent().find('.grantValue').show();
			$(this).text('Update');
		} else {
			$(this).parent().submit();
		}
	});
});

/* function sendMessage(){
	var queryString = "&tutorId="+ $('#toTutId').val()+"&subject="+$('#subject').val()+"&message="+$('#message').val();
	$.ajax({
		type: "POST",
		url: "sendMsgToTutor",
		data: queryString,
		success: function(response){
			$("#dialog-form1").dialog("close");
			$('.modal_msg').html(response);
			$(".modal_msg").dialog({
				autoOpen: false,width: 400,modal: true,buttons:{
					"Ok": function(){
						$( this ).dialog("close");
					}
				}
			});
			$(".modal_msg").dialog("open");
		}
	});
} */
</script>
<style type="text/css" media="screen">
/*	body { font: 0.8em Arial, sans-serif; }*/
	
</style>


<div id="content-wrap" class="fontNew">

<?php	echo $this->Session->flash(); ?>

    <h1>My Non-Profit</h1>
    <div id="tutor-wrap"> 
      
      <?php  echo $this->element('frontend/tutorLeftSidebar'); ?>
      
       <!--Center Column Begin Here-->
      <div class="center-col">
      
         <!--Display Profile-->
			<?php foreach($causeResult as $result){?>
			<div class="dp_main">
				<div class="dp_img">
					<?php
					$countImg = count($result['Cause']['UserImage'])-1;
					if(count($result['Cause']['UserImage'])){
						echo $html->image("members/thumb/".$result['Cause']['UserImage'][$countImg]['image_name'],array('width'=>50,'height'=>50));
					} else {
						echo $html->image("frontend/cause-logo.gif",array('width'=>50,'height'=>50));
					 }
					?>
				</div>
				<div class="dp_right" style="width:280px;">
					<div style="margin:0px 2px;font-weight:bold;font-size:14px"><?php
					
					 $findname = $result['Cause']['userMeta']['cause_name'];
					 $urlName=$findname . '_' . $result['Cause']['id'];
					 ?>
					   <label class="tutorSearchResult-name-disc2" style="padding-left:15px;" ><?php 
					   
					   if(!empty($findname))
					   {
					   echo $html->link($findname, array('controller'=>'members', 'action'=>'non_profit', $urlName), array('title' => $result['Cause']['userMeta']['cause_name'],'target' => '_blank' ));
					   }
					   else
					   {
						   echo 'N/A';
					   }
					   ?></label>
					</div>
                    
                    
                    
                    
					<div class="dp_info">
                    	<ul>
                        
							<?php
                            if($result['Cause']['userMeta']['city']!='' || $result['Cause']['userMeta']['state']!='' )
                            {
                            ?>
                            	
							<li><b>Location:</b><?php 
							if($result['Cause']['userMeta']['city'])
							{
							echo $result['Cause']['userMeta']['city'].',';
							}?> 
                            <?php echo $result['Cause']['userMeta']['state'];?></li>
                              
							  <?php
                                }
                              ?>
                              
                              
							<li>
								<?php echo $this->Form->create('Member',array('action'=>'grant')); ?>
								<b>Donation :</b>
								<label class="grantLavel"><?php echo $result['TutorRequestCause']['grant']; ?>%</label>
								<span class="grantValue" style="display:none">
								<input type="text" name="data[Member][grant]" style="width:40px;font-size:10px;border:1px solid #CCC;padding:1px" maxlength="3" value="<?php echo $result['TutorRequestCause']['grant']; ?>" /> %
								
								<input type="hidden" name="data[Member][default]" value="<?php echo $result['TutorRequestCause']['grant']; ?>" />
								
								<input type="hidden" name="data[Member][ctId]" value="<?php echo $result['TutorRequestCause']['id']; ?>" />
								</span>
								<span style="margin-left:20px;color:blue;cursor:pointer;" class="grantChange">Change</span>
                                
                                <a href="<?php echo HTTP_ROOT.'members/deletetutorscause/'.$result['TutorRequestCause']['id']?>"><span style="margin-left:20px;color:blue;cursor:pointer;">Remove</span></a>
                                          
								<?php echo $this->Form->end(); ?>
                                
                               <!-- <span style="margin-left:20px;color:blue;cursor:pointer;" class="grantChange">Change</span>-->
                                
								<?php
									$currentMoney = ($getBalance['Member']['creditable_balance']* $result['TutorRequestCause']['grant'])/100;
									//echo $currentMoney;
								?>
                                
							</li>
                            
                         
                            
                            
						</ul>
					</div>
                    
                    
				</div>
				<div style="clear:both"></div>
			</div>
			<?php }  if(count($causeResult)==0)
			{
			?>
				<p style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px;padding-top: 5px; padding-left: 5px; text-align:center;"><b>No Record Found</b></p>
			<?php
			}
			?>
            
                     </div>
    <!--Center Column End Here-->        
                  
            

        <?php echo $this->element('frontend/tutorRightSidebar'); ?>
        
    </div>
</div>
<!--<div id="dialog-form1" title="Send Message">
	<div class="modal_conatiner">
		<ul>
			<li>
				<div class="modal_left">To:</div>
				<div class="modal_right" id="toTutName"></div>
				<div class="clear"><input type="hidden" id="toTutId" /></div>
			</li>
			<li>
				<div class="modal_left">Subject:</div>
				<div class="modal_right"><label class="StudentSubbject"></label>
					<input type="hidden" class="modal_text" id="subject" />
				</div>
				<div class="clear"><input type="hidden" id="tutor" /></div>
			</li>
			<li>
				<div class="modal_left">Message:</div>
				<div class="modal_right"><textarea class="modal_area" id="message"></textarea></div>
				<div class="clear"></div>
			</li>
			
		</ul>
	</div>
	<div class="modal_msg" title="Messege Sent"></div>
</div>-->