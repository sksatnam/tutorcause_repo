<?php

/*echo '<pre>';
print_r($getBalance['TutCourse']);
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
	$(".sendMessage").click(function() {
			$('#toTutId').val($(this).parent().find('.resultId').val());
			$('#toTutName').html($(this).parent().find('.resultName').val());
			$("#dialog-form1").dialog("open");
	});
});
</script>
<style type="text/css" media="screen">
	body { font: 0.8em Arial, sans-serif; }
	.profileContent .li1
	 {
    font-weight: bold;
    text-align: left;
    width: 100px;
	}
	
</style>

<div class="public_profile_main_cointainer">
<?php	echo $this->Session->flash(); ?>
	<div class="public_profile_cointainer">
    <?php  echo $this->element('frontend/tutorProfile'); ?>
        <div class="public_profile_cointainer_IInd" style="width:710px">
        	<ul id="menu" class="menu">
			<li class="active"><a href="#description">Tutor Profile</a></li>
			<li><a href="#usage"> Causes</a></li>
			<li><a href="#course"> Courses </a></li>
           
		</ul>
		<div id="description" class="content" style="width:670px">
			<h2 style="color:#219eda; font-size:32px; width:670px; word-wrap:break-word;"><?php echo $getBalance['userMeta']['fname']." ".$getBalance['userMeta']['lname'];?></h2>
             
			<p style="font-size:16px;color:#111;">
				<?php echo $getBalance['Group']['name'];?>&nbsp;at&nbsp; <?php echo $getBalance['School']['school_name']; ?>
			</p>
            <div class="profileContent" >
				<li class="li1">Name</li>
				<li class="li2"><?php echo $getBalance['userMeta']['fname']." ".$getBalance['userMeta']['lname'];?> &nbsp;</li>
				<br class="clear" />
                
                
                <li class="li1">School Name</li>
				<li class="li2"><?php echo $getBalance['School']['school_name'];?> &nbsp;</li>
				<br class="clear" />
                
                <li class="li1">About Me</li>
				<li class="li2">
					<?php echo $getBalance['userMeta']['biography']; ?>&nbsp;
				</li>
				<br class="clear" />
			</div>
            
          
            
		</div>
        
		<div id="usage" class="content" style="width:670px;">
        
        <h2 style="color:#219eda; font-size:32px;">Causes</h2>
        
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
				<div class="dp_right">
					<div style="padding:2px;margin:0px 12px;font-weight:bold;font-size:14px"><?php
					
					 $findname = $result['Cause']['userMeta']['cause_name'];
					 $urlName=$findname . '_' . $result['Cause']['id'];
					 ?>
					   <label class="tutorSearchResult-name-disc2"><?php echo $html->link($findname, array('controller'=>'members', 'action'=>'cause', $urlName), array('title' => $result['Cause']['userMeta']['cause_name'],'target' => '_blank' )); ?></label>
					</div>
					<div class="dp_info">
						<ul>
							<li>
								<b>Donation :</b>
								<label class="grantLavel"><?php echo $result['CauseTutor']['grant']; ?>%</label>
							</li>
						</ul>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<?php }
			?>
			 
			 <?php
				if(count($causeResult)==0)
				{
				?>
				 <div class="tutorSearchResultCauseOuter" style="margin-top:5px;"> 
				 <div style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 18px; text-align:center;"> <b>There are currently no causes for this tutor</b></div>
				 
				 	</div>
				 <?php
				}
				?>
			
				
				</div>
        
        
        
        
        <div id="course" class="content" style="width:670px;">
        
        <h2 style="color:#219eda; font-size:32px;">Courses</h2>
        
        
        
            <div class="profileContent" >

            <li class="li1" style="text-align: left;  width: 104px;	font-weight:normal;"><b>Course Code</b></li>
            <li class="li2" style="width:75px;"><b>Price( $ )</b></li>
            <br class="clear" />
            
            
            
        
           <?php foreach($getBalance['TutCourse'] as $course){
			   
			/*   echo '<pre>';
			   print_r($course);
			   die;*/
			   
		   ?>
		 		<li class="li1" style="text-align: left;  width: 104px;	font-weight:normal;" ><?php echo $course['course_id'];?></li>
				<li class="li2" style="width:75px;"><?php echo '$ '.$course['rate'];?></li>
				<br class="clear" />
                
		<?php
           } ?>			 
	
			 <?php
				if(count($getBalance)==0)
				{
				?>
				<div class="tutorSearchResultCauseOuter" style="margin-top:5px;"> 
				 <div style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 18px; text-align:center;"> <b>There are currently no courses for this tutor</b></div>
				 </div>
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