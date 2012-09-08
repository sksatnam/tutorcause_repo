<?php
$causeamount = '';
foreach($alltutor as $tr)
{
	$causeamount =  $causeamount + $tr['TutorToCause']['cause_amount'];
}


/*echo '<pre>';
print_r($filtertutor1);
die;

*/


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
	$(".sendMessage").click(function() {
			$('#toTutId').val($(this).parent().find('.resultId').val());
			$('#toTutName').html($(this).parent().find('.resultName').val());
			$("#dialog-form1").dialog("open");
	});
	
		$('#dialogmsg1').dialog({
        autoOpen: false,
        title:"Confirm your request",
        width: 450,
        modal:true,
        buttons: {
        "Ok": function() {
            $(this).dialog("close");
        }
        }
    });
	
	
	$('#dialogmsg2').dialog({
        autoOpen: false,
        title:"Confirm your request",
        width: 450,
        modal:true,
        buttons: {
        "Ok": function() {
            $(this).dialog("close");
        }
        }
    });
	
	
	$( "#showMutualFriend" ).dialog({
				autoOpen: false,width: 400,modal: true,buttons:{
					Cancel: function() {
						$( this ).dialog("close");
					}
				}
			});
			
	
	
	$('.click2showMutual').live("click",function(){
				var fb_id = $(this).attr('rel');
				$.ajax({
					type: "POST",
					url: ajax_url+'/members/facebookmutual1/'+fb_id,
					data: '&fb_id='+fb_id,
					success: function (html) {
						$("#showMutualFriend").html(html);
						$("#showMutualFriend").dialog("open");
					}
				});
			});
});

function dialogmsg1(){
		$("#dialogmsg1").dialog("open");
		return false;
 }
 
 
 function dialogmsg2(){
		$("#dialogmsg2").dialog("open");
		return false;
 }
</script>
<style type="text/css" media="screen">

	body { font: 0.8em Arial, sans-serif; }	
	
	.profileContent .li1 {
						font-weight: bold;
						text-align: left;
						width: 100px;
						}
						
	
</style>


<div class="public_profile_main_cointainer">
<?php	echo $this->Session->flash(); ?>
	<div class="public_profile_cointainer">
    <?php  echo $this->element('frontend/causeProfile'); ?>
        <div class="public_profile_cointainer_IInd" style="width:710px">
        	<ul id="menu" class="menu">
			<li class="active"><a href="#description">Cause Profile</a></li>
			<li><a href="#usage"> Tutors</a></li>
		<!--	<li><a href="#download">Limerick Three</a></li>
            <li><a href="#four">Limerick four</a></li>-->
		</ul>
		<div id="description" class="content" style="width:670px">
			<h2 style="color:#219eda; font-size:32px; width:670px; word-wrap:break-word; "><?php echo $getBalance['userMeta']['cause_name'];?></h2>
             
			
            <div class="profileContent" >
				<li class="li1">Name</li>
				<li class="li2"><?php echo $getBalance['userMeta']['cause_name']?> &nbsp;</li>
				<br class="clear" />
                
                <li class="li1">Amount Raised</li>
				<li class="li2">$ <?php echo $causeamount;?> &nbsp;</li>
				<br class="clear" />
                
                
                <li class="li1">About Me</li>
				<li class="li2">
					<?php echo $getBalance['userMeta']['biography']; ?>&nbsp;
				</li>
				<br class="clear" />
			</div>
            
          
            
		</div>
		<div id="usage" class="content" style="width:670px;">
        
        <h2 style="color:#219eda; font-size:32px; width:670px; word-wrap:break-word; "><?php echo $getBalance['userMeta']['cause_name'];?>Tutor's</h2>
        
        
           <div class="tutorSearchResultCauseOuter">
          <?php  foreach($filtertutor1 as $ft){?>
			
         
              <div class="tutorSearchResultCause">	<!--tutorSearchResult-->
                        <div class="tutorSearchResult-img">	<!--tutorSearchResult-img-->
                       <?php
                       if($ft['Member']['facebookId'])
                       {
                           $fbimage = 'https://graph.facebook.com/'.$ft['Member']['facebookId'].'/picture';
                           echo  $this->Html->image($fbimage);
                       }
                       else
                       {
                           echo  $this->Html->image('frontend/user_img.png', array('height'=> '50px', 'width' => '50px') );
                       }
                       ?>
                        
                       
                        </div>	<!--tutorSearchResult-img-->
                        <div class="tutorSearchResult-nameAndDiscCause">	<!--tutorSearchResult-nameCauseAndDiscCause-->
                            <div class="tutorSearchResult-nameCause">	<!--tutorSearchResult-nameCause-->
                                <div class="tutorSearchResult-nameCause-discCause1">	<!--tutorSearchResult-nameCause-discCause1-->
                                    <label>Name:</label>
                                </div>	<!--tutorSearchResult-nameCause-discCause1-->
                                <div class="tutorSearchResult-nameCause-disc2">
                                    <!--tutorSearchResult-nameCause-disc2-->
                                    <?php
						/*			
									echo '<pre>';
									print_r($ft);
									die;
									*/
									
                                   $findname = $ft['userMeta']['fname'].' '.$ft['userMeta']['lname'];
						           $urlName=str_replace(' ','-',$findname);
                                   $urlName=str_replace('_','-',$urlName);
                                   $urlName=$urlName . '_' . $ft['Member']['id'];
                                   
                                   ?>
                                    <label class="tutorSearchResult-name-disc2" style="width:167px;"><?php echo $html->link($findname, array('controller'=>'members', 'action'=>'tutor', $urlName), array('title' => $findname,'target' => '_blank' )); ?></label>
                                </div>	<!--tutorSearchResult-nameCause-disc2-->
                            </div>	<!--tutorSearchResult-nameCause-->
                          
                            <div class="tutorSearchResult-nameCause">	<!--tutorSearchResult-nameCause-->
                                <div class="tutorSearchResult-nameCause-discCause1">	<!--tutorSearchResult-nameCause-discCause1-->
                                    <label>Availability:</label>
                                </div>	<!--tutorSearchResult-nameCause-discCause1-->
                               <?php
                               if(count($ft['TutEvent']))
                               {
                                ?>   
                                   <div class="tutorSearchResult-nameCause-disc2">	<!--tutorSearchResult-nameCause-disc2-->
                                    <label><span style="color:#096;"><b>Available</b></span> (<a href="<?php echo HTTP_ROOT.'Members/profiletutoravail/'.$ft['Member']['id'];?>" style="color:#339;">see availability</a>)</label>
                                    
                                </div>	<!--tutorSearchResult-nameCause-disc2-->
                                   
                                <?php   
                                }
                                else
                                {
                                ?>	
                                
                                <div class="tutorSearchResult-nameCause-disc2">	<!--tutorSearchResult-nameCause-disc2-->
                                    <label style="color:#F00">N/A</label> 
                      
                  
                                </div>	<!--tutorSearchResult-nameCause-disc2-->
                                
                                    
                                <?php	
                                }
                                ?>
                               
                               
                               
                                
                            </div>	<!--tutorSearchResult-nameCause-->
                            
                            <div class="tutorSearchResult-nameCause">	<!--tutorSearchResult-nameCause-->
                                <div class="tutorSearchResult-nameCause-discCause1">	<!--tutorSearchResult-nameCause-discCause1-->
                                    <label>Courses($Price):</label>
                                </div>	<!--tutorSearchResult-nameCause-discCause1-->
                                <div class="tutorSearchResult-nameCause-disc2">	<!--tutorSearchResult-nameCause-disc2-->
                                    <label><?php
                                    if(count($ft['TutCourse']))
                                        {
                                        foreach($ft['TutCourse'] as $memtutcourse )
                                            {
                                                echo $memtutcourse['course_id'].'<b>($ '.$memtutcourse['rate'].' / Hour)</b>'.', ';
                                            }
                                        }
                                    else
                                    {
                                    ?>	
                                    <div class="tutorSearchResult-nameCause-disc2">	<!--tutorSearchResult-nameCause-disc2-->
                                    <label style="color:#F00">N/A</label>
                                    </div>	<!--tutorSearchResult-nameCause-disc2-->
                                    <?php 	
                                    }
                                    ?></label>
                                </div>	<!--tutorSearchResult-nameCause-disc2-->
                            </div>	<!--tutorSearchResult-nameCause-->
                            
                            
                           <?php 
                            /*<div class="tutorSearchResult-nameCause">	<!--tutorSearchResult-nameCause-->
                                <div class="tutorSearchResult-nameCause-discCause1">	<!--tutorSearchResult-nameCause-discCause1-->
                                    <label>About me:</label>
                                </div>	<!--tutorSearchResult-nameCause-discCause1-->
                                <div class="tutorSearchResult-nameCause-disc2">	<!--tutorSearchResult-nameCause-disc2-->
                                    <label>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</label>
                                </div>	<!--tutorSearchResult-nameCause-disc2-->
                            </div>*/  ?>	<!--tutorSearchResult-nameCause-->
                        </div>	<!--tutorSearchResult-nameCauseAndDiscCause-->
                        <div class="tutorSearchResult-personalInfo2">	<!--tutorSearchResult-personalInfo-->
                            <ul>
                                <?php if($ft['userMeta']['fb_allow']==1) { ?>
                                <li style="padding-left:5px;width:240px;">
                                    <div class="searchResultLeft">
                                    <?php
                                        echo $html->image("frontend/facebook_20_20_icon.jpg",array('style'=>'width:20px;height:20px;'));
                                    ?>
                                    </div>
                                    
                                    <div class="searchResultCenter">
                                        <a href="http://www.facebook.com/profile.php?id=<?php echo $ft['Member']['facebookId']; ?>" target="_blank">View Facebook Profile</a>
                                    </div>
                                    <div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
                                </li>
                                <?php } ?>
                                
                                
                              <?php if($this->Session->read('Member.id'))
                                    {
                              ?>
                                
                                <li style="padding-left:5px;width:240px;">
                                    <div class="searchResultLeft">
                                    <?php
                                        echo $html->image("frontend/mutual_friends.jpg",array('style'=>'width:20px;height:20px;'));
                                    ?>
                                    </div>
                                    <div class="searchResultCenter">
                                     <?php /*?>   <a href="<?php echo HTTP_ROOT.'Members/facebookmutual/'.$ft['Member']['facebookId']; ?>">View Mutual Friends</a>
										
										<?php */?>
										<a href="javascript:void(0)" class="click2showMutual" rel="<?php echo $ft['Member']['facebookId']; ?>"><p>View Mutual Friends 
                                <?php 
             				    $mutualurl = '/members/countfacebookmutual1/'.$ft['Member']['facebookId'];
                               /* $countmutual = $this->requestAction($mutualurl);
								echo '('.$countmutual.')';*/
								?>
                                </p>&nbsp;</a>
										
										
										
                                    </div>
                                    <div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
                                </li>
                                
                                <?php
									}
								?>
                              
                                <li style="padding-left:5px;width:240px;">
                                    <div class="searchResultLeft">
                                    <?php
                                        echo $html->image("frontend/lock.png",array('style'=>'width:20px;height:20px;'));
                                    ?>
                                    </div>
                                    <div class="searchResultCenter">
									
									<?php if($this->Session->read('Member.memberid'))
											{
												if($ft['Member']['group_id']==8)
												{
											?>
												 <a href="<?php echo HTTP_ROOT.'Members/book_tutor_course/'.$ft['Member']['id']; ?>">Book Now</a>
												 <?php
												 }
												 else
												 {
												 ?>
												 <a href="javascript:void(0);" onclick="dialogmsg2();return false;" >Book Now</a>
												 
												<?php
												}
												
											}
											else
											{
											?>
											
											<a href="javascript:void(0);" onclick="dialogmsg1();return false;" >Book Now</a>
											<?php
											}
											?>
                                        
                                    </div>
                                    <div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
                                </li>
								
                                   <?php if($this->Session->read('Member.id'))
                                    {
                              ?>
							 
                                <li style="padding-left:5px;width:240px;">
                                    <div class="searchResultLeft">
                                    <?php
                                        echo $html->image("frontend/send_message.png",array('style'=>'width:18px;height:18px;'));
                                    ?>
                                    </div>
                                    <div class="searchResultCenter">
                                        <a class="sendMessage" href="#" onclick="return false;">Send Message</a>
                                        <input type="hidden" class="resultId" value="<?php echo $ft['Member']['id'];?>" />
                                        <input type="hidden" class="resultName" value="<?php echo $ft['userMeta']['fname'].' '.$ft['userMeta']['lname'];?>" />
                                    </div>
                                    <div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
                                </li>
                                <?php 
									}
								?>
                                
                                
                                
                            </ul>
                        </div>	<!--tutorSearchResult-personalInfo-->
                    </div>
            
			<?php } 
			if(count($filtertutor1)==0)
				{
				?>
				 <div style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px; text-align:center;"> <b>There are currently no tutors for this cause</b></div>
				 <?php
				 
				}
				?>
				
                </div>
		</div>
        
        <!--

		<div id="download" class="content">
			<h2 style="color:#219eda; font-size:32px;">Limerick Three</h2>
			Hickere, Dickere Dock,<br />
		    A Mouse ran up the Clock,<br />
		    The Clock Struck One,<br />
		    The Mouse fell down,<br />

		    And Hickere Dickere Dock.
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
		</div>
        <div id="four" class="content">
			<h2 style="color:#219eda; font-size:32px;">Limerick four</h2>
			<p>

				Let my viciousness be emptied,<br />
			    Desire and lust banished,<br />
			    Charity and patience,<br />
			    Humility and obedience,<br />
			    And all the virtues increased.
			</p>
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
		</div>-->
		
		
        </div>
        <?php //echo $this->element('frontend/tutorRightSidebar');?>
    </div>
</div>
<div id="dialog-form1" title="Send Message">
	<div class="modal_conatiner">
		<ul>
			<li>
				<div class="modal_left">To:</div>
				<div class="modal_right" id="toTutName"></div>
				<div class="clear"><input type="hidden" id="toTutId" /></div>
			</li>
			<li>
				<div class="modal_left">Subject:</div>
				<div class="modal_right"><input type="text" class="modal_text" id="subject" /></div>
				<div class="clear"><input type="hidden" id="tutor" /></div>
			</li>
			<li>
				<div class="modal_left">Message:</div>
				<div class="modal_right"><textarea class="modal_area" id="message"></textarea></div>
				<div class="clear"></div>
			</li>
			
		</ul>
	</div>
	<div class="modal_msg" title="Message Sent"></div>
</div>



<div id="dialogmsg2" title="Dialog Title" style="display:none;">
            <p style="margin-left:15px;">You should be student to book a tutor</p>
</div> 

<div id="dialogmsg1" title="Dialog Title" style="display:none;">
            <p style="margin-left:15px;">Please login to student for book a tutor</p>
</div> 

<div id="showMutualFriend" title="Mutual Friends"></div>