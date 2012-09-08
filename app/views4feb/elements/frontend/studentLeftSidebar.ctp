<?php

/*echo '<pre>';
print_r($mytutordata);
die;
*/
?>

<script type="text/javascript">

$(document).ready(function(){
	
//Set default open/close settings
$('.acc_container').hide(); //Hide/close all containers
$('.acc_trigger:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container

//$('.acc_trigger:last').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container

//On Click
$('.acc_trigger').click(function(){
	if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
		$('.acc_trigger').removeClass('active').next().slideUp(); //Remove all .acc_trigger classes and slide up the immediate next container
		$(this).toggleClass('active').next().slideDown(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	}
	else
	{
		$(this).toggleClass('active').next().slideUp();
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
		//	alert(response);return false;
			response = jQuery.trim(response);
			
			$('.profileAjaxImage').css('opacity','1');
			$('.profileAjaxImage2').hide()
			
			if(response==="sizeError"){
				alert('Size must be less than 5 MB');
/*				errorMsg('Size must be less than 5 MB');*/
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
						//print_r($picture);exit;
						
						if($getBalance['Member']['showImage'])
						{
						
						if(isset($picture) && !empty($picture)){
							echo $html->image("members/".$picture['UserImage']['image_name'],array('style'=>'margin:0;float:none;width:auto;max-width:243px;'));
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
        </div>
        <div class="student-profile-info">
          <div class="student">
          <?php
		  $studentname = $getBalance['userMeta']['fname'].' '.$getBalance['userMeta']['lname'];
    	  echo $studentname;
		  ?>
          </div>
        </div>
        <div class="student-profile-info">
          <div class="student">
            <div class="student-bal">Balance: <span>$<?php echo $getBalance['Member']['creditable_balance'];?></span></div>
            <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/add_fund';?>">Add More</a></div>
          </div>
        </div>
      </div>
      <div id="accordian">
        <div class="container">
          <h2 class="acc_trigger active"><a href="#">Account settings</a></h2>
          <div class="acc_container" style="display: none; ">
            <div class="block">
              <ul class="account-links">
                <li><a href="<?php echo HTTP_ROOT.'members/regmember/'.$this->Session->read('Member.memberid');?>">Edit Profile</a></li>
                <li><a href="<?php echo HTTP_ROOT.'members/regmember/'.$this->Session->read('Member.memberid');?>">Change School</a></li>
                <li><a href="<?php echo HTTP_ROOT.'members/myclass';?>">My Class</a></li>
                <li><a href="<?php echo HTTP_ROOT.'members/student_course';?>">Add Courses</a></li>
                
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
          <h2 class="acc_trigger"><a href="#">My Tutors</a></h2>
          <div class="acc_container" style="display: block; ">
            <div class="block">
              <ul id="my-tutor">
                
                <?php
				
				if(!empty($mytutordata))
					{
					foreach($mytutordata as $mtd)
						{
						?>
						<li>
						  <div class="profile-wrap">
							<div class="profile-pic">
							
							<?php
							if($mtd['Member']['showImage'])
							{
								$countImg = count($mtd['UserImage'])-1;
								if(count($mtd['UserImage'])){
									echo $html->image("members/thumb/".$mtd['UserImage'][$countImg]['image_name'],array('height'=>58,'width'=>57));
								} else {
									?><img src="https://graph.facebook.com/<?php echo $mtd['Member']['facebookId']; ?>/picture" style="height:58px; width:57px;"   />
								<?php }
							}
							else
							{
								
								echo $html->image("profile-photo.png",array('height'=>58,'width'=>57));
								
							}
							
							?>
							</div>
							
							<div class="profile-info">
							  <div class="name-price">
								<h4 class="profile-name">
								<?php 
								$requesturl = '/members/tutor_search_avgcourse/'.$mtd['Member']['id'];
								$request = $this->requestAction($requesturl);
								$tutorname = $mtd['userMeta']['fname'].' '.$mtd['userMeta']['lname'];
								echo $tutorname;
								?>
								</h4>
							  </div>
							  <div class="review">
								<div class="feedabck-cate">Ability:</div>
								<div class="feedabck">
								 <?php
								  $ablity = $request['abl'];
								  if($ablity)
								  {
									  for($i=1;$i<=$ablity;$i++)
									  {
									   ?>	  
										<img src="<?php echo FIMAGE;?>yellow-star.png" />  
									   <?php 
									  }
								  }
								 ?>
								</div>
							  </div>
							  <div class="review">
								<div class="feedabck-cate">Knowledge:</div>
								<div class="feedabck">
								  <?php
										  $know = $request['know'];
										  if($know)
										  {
											  for($i=1;$i<=$know;$i++)
											  {
											   ?>	  
												<img src="<?php echo FIMAGE;?>yellow-star.png" />  
											   <?php 
											  }
										  }
								 ?> 
								</div>
							  </div>
							  <div class="book-tutor">
								<div class="tutor-cost">
								<?php 
								
								echo '$'.$request['avg'].'/hr';
								?>
								</div>
								<div class="book-tutor2"><a href="<?php echo HTTP_ROOT."members/book_tutor_time/".$mtd['Member']['id'];?>">BOOk Now</a></div>
							  </div>
							</div>
							
							
						  </div>
						</li>
						<?php
						}
					}
				else
				{
				?>
				 <li> <p style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px;padding-top: 25px; padding-left: 15px;"><b>There are currently no tutors for this student</b></p></li>
				<?php
				}
				?>
               
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  <!--Left Sidebar End Here--> 





<div id="dialogdelete" title="Dialog Title" style="display:none;">
            <p>Click on appropriate button. </p>
</div>

