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


<div id="content-wrap">

<?php	echo $this->Session->flash(); ?>

              <h1>My Tutors</h1>
              <div id="tutor-wrap"> 
              
              <?php echo $this->element('frontend/causeLeftSidebar'); ?>
                    
                <!--Center Column Begin Here-->
                <div class="center-col">
                  
                  	<?php foreach($tutorResult as $result){?>
			<div class="dp_main">
				<div class="dp_img">
					 <?php
					  if($result['Member']['showImage'])
					{
					$countImg = count($result['Member']['UserImage'])-1;
					if(count($result['Member']['UserImage'])){
						echo $html->image("members/thumb/".$result['Member']['UserImage'][$countImg]['image_name'], array('width'=>50,'height'=>50));
					} else {
						?><img src="https://graph.facebook.com/<?php echo $result['Member']['facebookId']; ?>/picture"  />
					<?php }
					}
					else
					{
						echo $html->image("profile-photo.png",array('width'=>50,'height'=>50));
					}
					?>
				</div>
				<div class="dp_right">
                
            	<div style="padding:2px;margin:0px 2px;font-weight:bold;font-size:14px"><?php
				
					$findname = $result['Member']['userMeta']['fname'].' '.$result['Member']['userMeta']['lname'];
					$urlName=str_replace(' ','-',$findname);
					$urlName=str_replace('_','-',$urlName);
					$urlName=$urlName . '_' . $result['Member']['id'];
					
					 ?>
					   <label class="tutorSearchResult-name-disc2" style="padding-left:10px;"><?php echo $html->link($findname, array('controller'=>'members', 'action'=>'tutor', $urlName), array('title' => $findname,'target' => '_blank' )); ?></label>
					</div>
				
					<div class="dp_info">
						<ul>
                        	
							<li><a href="http://facebook.com/profile.php?id=<?php echo $result['Member']['facebookId'];?>" target="_blank">Facebook Profile</a></li>
                            
                            <?php
                            if($result['Member']['userMeta']['city']!='' || $result['Member']['userMeta']['state']!='' )
                            {
                            ?>
                            	
							<li><b>Location:</b><?php 
							if($result['Member']['userMeta']['city'])
							{
							echo $result['Member']['userMeta']['city'].',';
							}?> 
                            <?php echo $result['Member']['userMeta']['state'];?></li>
                              
							  <?php
                                }
                              ?>
                            
							<li>
								<b>Donation :</b>
								<label class="grantLavel"><?php echo $result['CauseTutor']['grant']; ?>%</label>
								<?php
									//$currentMoney = ($getBalance['Member']['creditable_balance']* $result['CauseTutor']['grant'])/100;
									//echo $currentMoney;
								?>
							</li>
						</ul>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<?php }  if(count($tutorResult)==0)
			{
			?>
		<p style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px;padding-top: 5px; padding-left: 5px; text-align:center;"><b>No Record Found</b></p>
			<?php
			}
			?>
            
            
            
                </div>
                <!--Center Column End Here--> 
                
                
                 <?php echo $this->element('frontend/causeRightSidebar');?>    
           
                
  </div>
</div>