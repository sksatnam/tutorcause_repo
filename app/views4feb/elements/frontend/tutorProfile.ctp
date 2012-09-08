<script type="text/javascript">
jQuery(document).ready(function() {

$('#dialogmsg').dialog({
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
	
	
	$('#dialogmsg3').dialog({
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
	
	
	$('#dialogmsg4').dialog({
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
	
	
	$('#dialogmsg5').dialog({
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
	
 });
 
 function dialogmsg(){
		$("#dialogmsg").dialog("open");
		return false;
 }
function dialogmsg1(){
		$("#dialogmsg1").dialog("open");
		return false;
 }
 
 
 function dialogmsg2(){
		$("#dialogmsg2").dialog("open");
		return false;
 }
 
 function dialogmsg3(){
		$("#dialogmsg3").dialog("open");
		return false;
 }
 
 
 function dialogmsg4(){
		$("#dialogmsg4").dialog("open");
		return false;
 }
 
  function dialogmsg5(){
		$("#dialogmsg5").dialog("open");
		return false;
 }

 

</script>
<div class="public_profile_cointainer_Ist">


	<div style="margin:20px 5px 5px 20px;text-align:left;">
		<div style="clear:both"></div>
		<div class="profileImage" style="padding:1px;border:1px solid #ACDFFB;height:auto;margin-bottom:10px;">
			<?php
				if($getBalance['Member']['showImage'])
				{
			
					if(isset($picture) && !empty($picture)){
						echo $html->image("members/".$picture['UserImage']['image_name'],array('style'=>'margin:0;float:none;width:auto;max-width:180px;'));
					} else {
						?>
							 <img src="https://graph.facebook.com/<?php echo $getBalance['Member']['facebookId']; ?>/picture?type=large" style="margin:0;float:none;width:auto;max-width:180px;" />
					 <?php        
					}
				}
				else
				{
					echo $html->image("profile-photo.png",array('style'=>'margin:0;float:none;width:auto;max-width:180px;'));
				}
			?>
		</div>
		<div style="clear:both"></div>
		
	</div>
	<br />
    
    <div class="leftSideDiv">
		<ul>
        
			<li>
				<div class="sideFirst">
					<?php echo $html->image('frontend/message.jpg',array('style'=>'width:20px;height:20px;'))?>
				</div>
				<div class="sideSecond">
				
				<?php if( $this->Session->read('Member.memberid'))
			{
			?>
			
				<?php if($getBalance['Member']['id'] != $this->Session->read('Member.memberid'))
		{
		?>
		<a class="sendMessage" href="#" onclick="return false;">Send Message</a>
		<?php
		}
		else
		{
		?>
		<a href="javascript:void(0);" onclick="dialogmsg();return false;" >Send Message</a>
		<?php
		}
		?>
		
		<input type="hidden" class="resultId" value="<?php echo $getBalance['Member']['id'];?>" />
		<input type="hidden" class="resultName" value="<?php echo $getBalance['userMeta']['fname'].' '.$getBalance['userMeta']['lname'];?>" />
	</div>
				<div class="clear"></div>
			</li>
       <?php
		}
		else
		{
		
	   ?>
	   		<a href="javascript:void(0);" onclick="dialogmsg5();return false;" >Send Message</a>
		<?php
		}
		?>
         	
			<li>
				<div class="sideFirst">
					<?php echo $html->image('frontend/facebook_20_20_icon.jpg',array('style'=>'width:20px;height:20px;'))?>
				</div>
				<div class="sideSecond">
					   <a href="http://www.facebook.com/profile.php?id=<?php echo $getBalance['Member']['facebookId']; ?>" target="_blank">Facebook Profile</a> 
				</div>
				<div class="clear"></div>
			</li>
			
			<li>
				<div class="sideFirst">
					<?php echo $html->image('frontend/availability_icon.gif',array('style'=>'width:20px;height:20px;'))?>
				</div>
				<div class="sideSecond">
		<?php if($this->Session->read('Member.group_id')!= $getBalance['Member']['group_id'] )
											{
												if($this->Session->read('Member.group_id')==8)
												{
											?>
												 <?php echo $html->link('Availablity',array('controller'=>'members', 'action'=>'book_tutor_time',$getBalance['Member']['id']));?>
												 <?php
												 }
												 else
												 {
												 ?>
												 <a href="javascript:void(0);" onclick="dialogmsg1();return false;" >Availablity</a>
												 
												<?php
												}
												
											}
											else
											{
											?>
											
											<a href="javascript:void(0);" onclick="dialogmsg2();return false;" >Availablity</a>
											<?php
											}
											?>
				</div>
				<div class="clear"></div>
			</li>
            
            <li >
                    <div class="sideFirst">
                    <?php
                        echo $html->image("frontend/lock.png",array('style'=>'width:20px;height:20px;'));
                    ?>
                    </div>
                    <div class="sideSecond">
					<?php if($this->Session->read('Member.group_id')!= $getBalance['Member']['group_id'] )
											{
												if($this->Session->read('Member.group_id')==8)
												{
											?>
												  <a href="<?php echo HTTP_ROOT.'members/book_tutor_time/'.$getBalance['Member']['id']; ?>">Book Now</a>
												 <?php
												 }
												 else
												 {
												 ?>
												 <a href="javascript:void(0);" onclick="dialogmsg3();return false;" >Book Now</a>
												 
												<?php
												}
												
												}
											else
											{
											?>
											
											<a href="javascript:void(0);" onclick="dialogmsg4();return false;" >Book Now</a>
											<?php
											}
											?>
					
                    </div>
                    
                    <div class="clear"></div>
               
			</li>
           
		</ul>
	</div>
    
  
</div> 
<div id="dialogmsg" title="Dialog Title" style="display:none;">
            <p style="margin-left:15px;">You can not send  &nbsp;&nbsp;<span style="color:#F00" >Message</span>&nbsp;&nbsp;yourself</p>
</div>

<div id="dialogmsg5" title="Dialog Title" style="display:none;">
            <p style="margin-left:15px;">Please login to  send a message  </p>
</div>


<div id="dialogmsg2" title="Dialog Title" style="display:none;">
            <p style="margin-left:15px;">You should be student to availablity a tutor</p>
</div> 

<div id="dialogmsg1" title="Dialog Title" style="display:none;">
            <p style="margin-left:15px;">Please login to student for availablity a tutor</p>
</div> 


<div id="dialogmsg3" title="Dialog Title" style="display:none;">
            <p style="margin-left:15px;">Please login to student for book a tutor </p>
</div> 

<div id="dialogmsg4" title="Dialog Title" style="display:none;">
            <p style="margin-left:15px;">You should be student to book a tutor</p>
</div> 
