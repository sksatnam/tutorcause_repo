<?php

/*echo '<pre>';
print_r($tutorAmount);
die;
*/
?>



<script type="text/javascript">

$(document).ready(function(){
	
//Set default open/close settings
$('.acc_container').hide(); //Hide/close all containers
$('.acc_trigger:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container

//On Click
$('.acc_trigger').click(function(){
	if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
		$('.acc_trigger').removeClass('active').next().slideUp(); //Remove all .acc_trigger classes and slide up the immediate next container
		$(this).toggleClass('active').next().slideDown(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	}
	else
	{
		//$('.acc_trigger').removeClass('active').next().slideDown(); //Remove all .acc_trigger classes and slide up the immediate next container
		$(this).toggleClass('active').next().slideUp(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	}
	return false; //Prevent the browser jump to the link anchor
});

});


	
$(function() {
	var changeImage=$('.imageChange');
	var profileImage=$('.profileAjaxImage');
	new AjaxUpload(changeImage,
	{
		action: ajax_url+"/members/img_upload",
		name: 'userImage',
		onSubmit: function(file, ext)
		{
			if (! (ext && /^(jpg|png|gif)$/.test(ext)))
			{
				errorMsg('File type must be GIF, PNG, or JPG');
				return false;
			}
			
			$('.profileAjaxImage').css('opacity','0.4');
			$('.profileAjaxImage2').show();
			
		},
		onComplete: function(file, response)
		{
			//alert(response);return false;
			
			response = jQuery.trim(response);
			
			$('.profileAjaxImage').css('opacity','1');
			$('.profileAjaxImage2').hide()
			
			if(response==="sizeError"){
				alert('Size must be less than 5 MB');
				return false;
			}
			else if(response.indexOf("##success")>-1)
			{
				//alert('jazz');
				getImageX=response.split("##suc");
				
				var newImg = ajax_url+'/img/members/'+getImageX[0];
				
//				alert(getImageX[0]);return false;
				$('.profileAjaxImage img').attr('src',newImg);

			}
			else
			{
				errorMsg('An Error Occured');
				return false;
			}
		}
	});
});
function errorMsg(msg){
	$('#errorMsg').html('<span style="color:red;"><b>'+msg+'</b></span>');
	$('#errorMsg').fadeIn().delay(3000).fadeOut();
}







function causewithreq()
{
	$('#causewithreq').dialog({
		autoOpen: true,
		title:"Withdrawal Request",
		width: 600,
		modal:true,
		buttons: {
			"Send": function() {
					$(this).dialog("close");	
							var sendurl = '<?php echo HTTP_ROOT;?>members/causewithdrawal';
							window.location = sendurl;
				},
			"Cancel": function() {
				$(this).dialog("close");
			}
		}
	});	

}





function deleteaccount()
{
	
	$('#dialogdelete').dialog({
        autoOpen: true,
        title:"Confirm your request",
        width: 600,
        modal:true,
        buttons: {
        "Move to trash": function() {
			
			
				var where_to= confirm("Do you really want to move account to trash??");
				if (where_to== true)
				{
					
					var url = '<?php echo HTTP_ROOT;?>members/delete';
					
					var logouturl = '<?php echo HTTP_ROOT;?>members/logout';
					
					$.ajax({
					type: "GET",
					url: url,
					data: '&deleteid=',
					success: function(msg){
					
					var resp = jQuery.trim(msg);
					
					if(resp == 'deleted' )
					{
						window.location = logouturl;
					}
					
					}
					});
					$(this).dialog("close");
				}
				else
				{
					$(this).dialog("close");
				}

			
			
			
			
			
			
        },
        "Delete permanently": function() {
			
				var where_to= confirm("Do you really want to delete account permanently??");
				if (where_to== true)
				{
					
					var url = '<?php echo HTTP_ROOT;?>members/permanently_delete';
					
					var logouturl = '<?php echo HTTP_ROOT;?>members/logout';
					
					$.ajax({
					type: "GET",
					url: url,
					data: '&deleteid=',
					success: function(msg){
					
					var resp = jQuery.trim(msg);
					
					if(resp == 'deleted' )
					{
						window.location = logouturl;
					}
					
					}
					});
					$(this).dialog("close");
				}
				else
				{
					$(this).dialog("close");
				}
           
        },
		"Cancel": function() {
            $(this).dialog("close");
        },
		
        }
    });	
}
</script>





    <!--Left Sidebar Begin Here-->
    <div class="left-sidebar">
      <div class="student-profile">
        <div class="student-profile-img" style="position:relative;">
        
        <div class="profileAjaxImage">
        	<?php
					//print_r($picture);exit;
				if($getBalance['Member']['showImage'])
					{
					
						if(isset($picture) && !empty($picture)){
							echo $html->image("members/".$picture['UserImage']['image_name'],array('style'=>'margin:0;float:none;width:auto;max-width:243px;'));
						} else {
							?>
								 <img src="<?php echo FIMAGE.'cause-logo.gif'?>" style="margin:0;float:none;width:auto;max-width:243px;" />
						 <?php        
						}
					}
				else
				{
					echo $html->image("profile-photo.png",array('style'=>'margin:0;float:none;width:auto;max-width:243px;'));
				}
			?>
            
          </div>
          
          
        <div class="profileAjaxImage2">
        <?php echo $html->image("frontend/ajax-loader.gif") ?>
        </div>
            
        <div style="clear:both"></div>
		<div id="errorMsg"></div>
		<div class="imageChange">Change Profile Picture</div>    
          
        
      <!--  <img src="images/profile-img.jpg" width="245" height="169" />--> 
      </div>
        <div class="student-profile-info">
          <div class="student"><?php
					if(isset($getBalance['userMeta']['cause_name']) && !empty($getBalance['userMeta']['cause_name'])){
						echo $getBalance['userMeta']['cause_name'];
					} else {
						echo "<i>None</i>";
					} ?></div>
        </div>
        <div class="student-profile-info">
          <div class="student">
            <div class="student-bal">Account Balance: <span>$<?php echo $getBalance['Member']['creditable_balance']; ?></span></div>
          </div>
        </div>
      </div>
      <div id="accordian">
        <div class="container">
          <h2 class="acc_trigger active"><a href="#">Account settings</a></h2>
          <div class="acc_container" style="display: none; ">
            <div class="block">
              <ul class="account-links" >
                <li><a href="<?php echo HTTP_ROOT.'members/regmember/'.$this->Session->read('Member.memberid');?>">Edit Profile</a></li>
                <li><a href="<?php echo HTTP_ROOT.'members/regmember/'.$this->Session->read('Member.memberid');?>">Change School</a></li>
                <li><a href="<?php echo HTTP_ROOT.'members/causeget_statement';?>">Payment History</a></li>
                <li><a href="<?php echo HTTP_ROOT.'members/cause_tutors';?>">My Tutors</a></li>
                <li><a href="<?php echo HTTP_ROOT.'members/tutor_request';?>">Tutor Requests <?php echo $CountRequest;?></a></li>
                
        <?php /*?>        <?php
					if($getBalance['Member']['showImage'])
					{
					?>
					<li><a href="<?php echo HTTP_ROOT.'members/hide_image';?>">Hide Image</a></li>
					<?php
					}
					else
					{
					?>	
					<li><a href="<?php echo HTTP_ROOT.'members/show_image';?>">Show Image</a></li>
					<?php
					}
					?>
                <?php */?>
				<?php
				   $findname = $getBalance['userMeta']['cause_name'];
				   $urlName=str_replace(' ','-',$findname);
				   $urlName=str_replace('_','-',$urlName);
				   $urlName=$urlName . '_' . $getBalance['Member']['id'];
				   ?>
				
				
                <li><a href="<?php echo HTTP_ROOT.'members/cause/'.$urlName;?>">Public Profile</a></li>   
                <li><a href="<?php echo HTTP_ROOT.'members/change_password';?>">Change Password</a></li>  
                <li><a href="http://support.tutorcause.com/customer/portal/emails/new">Report An Issue</a></li>
                <li><a href="javascript:deleteaccount();">Delete Account</a></li>
				<?php 
                if(isset($pendingrequest))
                    {
                    ?>
                    <li class="last"><a href="javascript:void(0);" >Pending Request</a></li>
            
                    <?php
                    }
                else
                    {
                    ?>
                    <li class="last"><a href="javascript:causewithreq();" >Withdrawal Request</a></li>
                    <?php
                    }
                ?>
              </ul>
            </div>
          </div>
          <h2 class="acc_trigger"><a href="#">View Tutors</a></h2>
          <div class="acc_container" style="display: block;">
            <div class="block">
              <div id="tutor-left">
        <ul>
         
         
			<?php
		    foreach($tutorAmount as $tr)
            {
				$tutorName = $tr['Member']['userMeta']['fname'].' '.$tr['Member']['userMeta']['lname'];
				$urlName=str_replace(' ','-',$tutorName);
				$urlName=str_replace('_','-',$urlName);
				$urlName=$urlName . '_' . $tr['Member']['id'];
				
            ?>
          <li class="cause-bg"><a href="<?php echo HTTP_ROOT.'members/tutor/'.$urlName;?>" target="_blank">
            <div class="profile-wrap">
              <div class="profile-pic">
              <?php
			  		 if($tr['Member']['showImage'])
					{
			  
					$countImg = count($tr['Member']['UserImage'])-1;
					if(count($tr['Member']['UserImage'])){
						echo $html->image("members/thumb/".$tr['Member']['UserImage'][$countImg]['image_name'],array('width'=>57,'height'=>58));
					} else {
						?><img src="https://graph.facebook.com/<?php echo $tr['Member']['facebookId']; ?>/picture" width="57" height="58"  />
					<?php }
					}
					else
					{
						echo $html->image("profile-photo.png",array('width'=>57,'height'=>58));
					}
					?>
          <!--    <img src="images/pic-1.jpg" width="57" height="58" />--></div>
              <div class="profile-info">
                <div class="name-price">
                  <h4 class="cause-name"><?php echo $tutorName;
				  
				    $tutor_raised = $this->requestAction('members/tutor_give_cause/'.$tr['CauseTutor']['tutor_id'].'/'.$tr['CauseTutor']['cause_id']); 
				  
				  
				  ?></h4>
                  <div class="amount-raised">
                        <div class="amount-raised-text">Amount Raised:</div>
                        <div class="raised-amt"><?php
						if($tutor_raised)
						{
						  echo '$ '.$tutor_raised;	
						}
						else
						{
						  echo '$ 0';	
						}
						?></div>
                  </div>
                </div> 
              </div>
            </div>
            </a></li>
			<?php
            }
            if(count($tutorAmount)==0)
            {
			?>
              <li> <p style=" font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px; margin-left:20px; margin-top:25px;"><b>There are currently no tutors <br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;for this non-profit</b></p></li>
			 
			<?php
            }
            ?>
	 
        </ul>
      </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--Left Sidebar End Here--> 



<div id="dialogdelete" title="Dialog Title" style="display:none;">
            <p>Click on appropriate button. </p>
</div>