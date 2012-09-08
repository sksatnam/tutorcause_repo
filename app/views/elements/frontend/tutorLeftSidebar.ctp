<?php //3aug2012 ?><?php

/*echo 'jass';
	echo '<pre>';
		print_r($getBalance);
		echo '</pre>';
		die;*/

/*print_r($picture);
die;
*/
if($CountRequest>0){
	$CountRequest = $CountRequest;
} else {
	$CountRequest = "";
}
?>


<script type="text/javascript">
	$(document).ready(function () {
								
	/*	$('#menu').tabify();
		$('#menu2').tabify();*/
		
		
		
			$(".cause-bg").live("mouseenter",function() {
						
				//	alert('jazz')	;
				
					$(this).find('.raised-amt').addClass('raised-amt2');  
					$(this).find('.raised-amt').removeClass('raised-amt');  
				
				
			}).live("mouseleave",function() {
				
					$(this).find('.raised-amt2').addClass('raised-amt');  
					$(this).find('.raised-amt2').removeClass('raised-amt2');  
					
			});
		
		
		
		
		
		
		
		
		
		
		$("#tutortext").autocomplete(
		  ajax_url+"/members/get_non_profit_name",
		  {
				delay:10,
				minChars:1,
				matchSubset:1,
				matchContains:1,
				cacheLength:0,
				autoFill:false
			}
		);
		
		
		

	
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


	
//Set default open/close settings
$('.acc_container2').hide(); //Hide/close all containers
$('.acc_trigger2:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container

//On Click
$('.acc_trigger2').click(function(){
	if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
		$('.acc_trigger2').removeClass('active').next().slideUp(); //Remove all .acc_trigger classes and slide up the immediate next container
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
			
			response = jQuery.trim(response);
			
			$('.profileAjaxImage').css('opacity','1');
			$('.profileAjaxImage2').hide()
			
			//alert(response);return false;
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
		  if($getBalance['Member']['showImage'])
				{
					if(!empty($getBalance['Member']['image_name'])){
							echo $html->image("members/".$getBalance['Member']['image_name'],array('style'=>'margin:0;float:none;width:auto;max-width:243px;'));
					} else {
						?>
							 <img src="https://graph.facebook.com/<?php echo $getBalance['Member']['facebookId']; ?>/picture?type=large" style="margin:0;float:none;width:auto;max-width:243px;" />
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
		  
		  <?php // echo $html->image("frontend/profile-img.jpg")?>
          
          
          
          </div>
          <div class="student-name">
            <div class="student">
			  <?php
              $tutorname = $getBalance['Member']['fname'].' '.$getBalance['Member']['lname'];
              echo $tutorname;
              ?>
            </div>
          </div>
          <div class="student-profile-info">
            <div class="student">
              <div class="student-bal">Amount Earned : <span>$<?php echo $getBalance['Member']['balance'];?></span></div>
            </div>
          </div>
          <div class="student-profile-info">
            <div class="student">
              <div class="student-bal">Available Balance : <span>$<?php echo $getBalance['Member']['creditable_balance'];?></span></div>
            </div>
          </div>
          <div class="student-profile-info">
            <div class="student">
            
               <?php 
				if(isset($pendingrequest))
				{
				?>
                <div class="student-bal"><a href="javascript:void(0);">Pending Request</a></div>
                <?php
				}
				else
				{
				?>
                <div class="student-bal"><a href="<?php echo HTTP_ROOT.'members/get_statement/';?>">Withdrawal Balance</a></div>
			    <?php
                 }
                ?>
              
            </div>
          </div>
          
          <div class="student-profile-info">
            <div class="student">
              <div class="student-bal"><a href="<?php echo HTTP_ROOT.'members/tutor_withdrawal';?>">Financial History</a></div>
            </div>
          </div>
        </div>
        <div id="accordian">
          <div class="container">
            <h2 class="acc_trigger active"><a href="#">Account Settings</a></h2>
            <div class="acc_container" style="display: none; ">
              <div class="block">
                <ul class="account-links">
                  <li><a href="<?php echo HTTP_ROOT.'members/regmember';?>">Edit Profile</a></li>
                  <li><a href="<?php echo HTTP_ROOT.'members/regmember';?>">Change School</a></li>
                  <li><a href="<?php echo HTTP_ROOT.'members/tutor_payment/'.$this->Session->read('Member.memberid');?>">Edit Payment Details</a></li>
                  <li><a href="<?php echo HTTP_ROOT.'members/editschoolinfo/';?>">Edit Courses</a></li>   
    			  <li><a href="<?php echo HTTP_ROOT.'members/myclass';?>">My Class</a></li>               
                  <li><a href="<?php echo HTTP_ROOT.'members/tutor_non_profit/';?>">My Non-Profit</a></li>                  
                  <li><a href="<?php echo HTTP_ROOT.'members/non_profit_request/';?>"><?php echo 'Non-Profit Requests '.$CountRequest.'';?></a></li>  
                  
                   <?php
				   $findname = $getBalance['Member']['fname'].' '.$getBalance['Member']['lname'];
				   $urlName=str_replace(' ','-',$findname);
				   $urlName=str_replace('_','-',$urlName);
				   $urlName=$urlName . '_' . $getBalance['Member']['id'];
				  ?>
                  
                  <li><a href="<?php echo HTTP_ROOT.'members/tutor/'.$urlName;?>">Public Profile</a></li>     
                   
                 <?php /*?>               
                   <?php
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
                 
                  <li><a href="<?php echo HTTP_ROOT.'members/change_password';?>">Change Password</a></li>
                  
				  <li><a href="http://support.tutorcause.com/customer/portal/emails/new">Report An Issue</a></li>                  
					
				  <li class="last"><a href="javascript:deleteaccount();">Delete Account</a></li>                  
				  
                </ul>
              </div>
            </div>
            
            <h2 class="acc_trigger"><a href="#">My Non-Profits</a></h2>
            <div class="acc_container" style="display: block; ">
                    <div class="block">
                        <div id="tutor-left">
                <ul>
                <?php 
				foreach($causeResult as $cr)
				{
					 $findname = $cr['Cause']['userMeta']['cause_name'];
					 $causeurl=$findname . '_' . $cr['Cause']['id'];
				?>
                
                  <li class="cause-bg"><a href="<?php echo HTTP_ROOT.'members/non_profit/'.$causeurl;?>">
                    <div class="profile-wrap">
                      <div class="profile-pic">
						<?php			
                        $causeimage = $this->requestAction('members/getcauseProfile/'.$cr['TutorRequestCause']['cause_id']); 
                        if(count($causeimage['UserImage'])){
                            echo $html->image("members/thumb/".$causeimage['UserImage']['image_name'],array('width'=>57,'height'=>57));
                        } else {
                            echo $html->image("frontend/cause-logo.gif",array('width'=>57,'height'=>57));
                         }
                        ?>                      
                   </div>
                      <div class="profile-info">
                        <div class="name-price">
                          <h4 class="cause-name"><?php
						  if(!empty($cr['Cause']['userMeta']['cause_name']))
						  {
							  echo $cr['Cause']['userMeta']['cause_name'];
						  }
						  else
						  {
							  echo 'N/A';
						  }
						  ?>&nbsp;</h4>
                          <div class="amount-raised">
                                <div class="amount-raised-text">Amount Raised:</div>
                                <div class="raised-amt">
                                <?php 
								$requesturlcause = '/members/non_profit_amount_raised/'.$cr['TutorRequestCause']['cause_id'];
								$amountraised = $this->requestAction($requesturlcause);
								echo '$ '.$amountraised;
								?>
                                </div>
                          </div>
                        </div> 
                      </div>
                    </div>
                    </a>
                    </li>
                <?php
				}
				if(count($causeResult)==0)
				{
				?>	
                <li>
                    <p style="font-family:Myriad Pro; color:rgb(24, 73, 122); font-size:16px; padding-left:13px; padding-top:33px;">
                    There are currently no non-profit for this tutor.
                    </p>
                </li>
			    <?php 
				}
				?>
                </ul>
              </div>
                    </div>
                  </div>
             
            
            <h2 class="acc_trigger"><a href="#">Help a Non-Profit</a></h2>
            <div class="acc_container" style="display: none; ">
              <div class="block">
               <div class="cause-search">
               <form name="causesearch" id="causesearch" action="<?php echo HTTP_ROOT.'members/find_non_profit';?>" method="post" >
                  <label>Help a Non-Profit Here</label>
                  	<input type="text" name="data[CauseSchool][causename]" id="tutortext" value="" />
                  <input type="image" src="<?php echo FIMAGE.'search-btn.png';?>" />
               </form>   
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


            