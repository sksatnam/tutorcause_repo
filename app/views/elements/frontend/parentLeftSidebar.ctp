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




<div class="left-sidebar">
    <div class="student-profile">
    
    <div class="student-profile-img" style="position:relative;">
        
        <div class="profileAjaxImage">
				<?php
						//print_r($picture);exit;
						
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
    
    </div>
    <div class="student-profile-info">
    <div class="student">
    <?php
		  $parentname = $getBalance['Member']['fname'].' '.$getBalance['Member']['lname'];
    	  echo $parentname;
	?>
    </div>
    </div>
    <div class="student-profile-info">
    <div class="student">
    <div class="student-bal">Balance: <span>$<?php echo $getBalance['Member']['creditable_balance'];?></span></div>
    
    <?php
		if(!empty($getBalance['Member']['stripeid']))
			{
			
				$securelinkparent = HTTP_ROOTS.'members/parent_fund2';	
			
			}
		else
			{
				$securelinkparent = HTTP_ROOTS.'members/parent_fund';	
			}
	?>
    
    
    <div class="center-view"><a href="<?php echo $securelinkparent;?>">Add More</a></div>
    </div>
    </div>
    </div>
    <div id="accordian">
        <div class="container">
        <h2 class="acc_trigger active"><a href="#">Account settings</a></h2>
            <div class="acc_container" style="display: none; ">
            <div class="block">
            <ul class="account-links">
            <li><a href="<?php echo HTTP_ROOT.'members/regmember';?>">Edit Profile</a></li>
            <li><a href="<?php echo HTTP_ROOT.'members/change_password';?>">Change Password</a></li>
            <li><a href="http://support.tutorcause.com/customer/portal/emails/new">Report An Issue</a></li>                  
			<li class="last"><a href="javascript:deleteaccount();">Delete Account</a></li>                  
        <!--    
            <li><a href="#">Link Comes Here</a></li>
            <li><a href="#">Link Comes Here</a></li>
            <li><a href="#">Link Comes Here</a></li>
            <li><a href="#">Link Comes Here</a></li>            
            <li class="last"><a href="#">Link Comes Here</a></li>
            -->
            
            </ul>
            </div>
            </div>
        <h2 class="acc_trigger"><a href="#">My students</a></h2>
            <div class="acc_container" style="display: block; ">
            <div class="block">
                <ul id="my-tutor">
                
					<?php
                    foreach($mystudent as $ms)
                    {
                    ?>
                
                    <li>
                        <div class="profile-wrap">
                            <div class="student-info">
                            <div class="profile-pic"><?php
							if($ms['Student']['showImage'])
							{
								if(!empty($ms['Student']['image_name'])){
									echo $html->image("members/thumb/".$ms['Student']['image_name'],array('height'=>58,'width'=>57));
								} else {
								?>
                                <img src="https://graph.facebook.com/<?php echo $ms['Student']['facebookId']; ?>/picture?type=large" style="height:58px; width:57px;"   />
								<?php }
							}
							else
							{
								echo $html->image("profile-photo.png",array('height'=>58,'width'=>57));
							}
							?></div>
                            <div class="profile-info">
                                <div class="name-price">
                                <h4 class="profile-name" style="width:158px; word-wrap:break-word;"><?php echo $ms['Student']['fname'].' '.$ms['Student']['lname'];?></h4>
                                <p class="student-text"> <?php
								if(!empty($ms['Student']['userMeta']['biography']))
								{
									
									if(strlen($ms['Student']['userMeta']['biography'])>44)
									{
										echo substr($ms['Student']['userMeta']['biography'],0,44).'...';	
									}
									else
									{
										echo $ms['Student']['userMeta']['biography'];
									}
								}
								?></p>
                                </div>
                            </div>
                            </div> 
                            <div class="student-btns">
                            <div class="add-funds"><a href="<?php echo HTTP_ROOTS.'members/add_fund_student/'.$ms['Student']['id'];?>">Add Funds</a></div>
                            <div class="pay-session"><a href="<?php echo HTTP_ROOT.'members/view_awaiting_session/'.$ms['Student']['id'];?>">View & Pay Session</a></div>
                            </div>
                        </div>
                    </li>
                    
                    <?php
					}
					if(empty($mystudent))
					{
					?>	
					<li>
					<p style="font-family:Myriad Pro; color:rgb(24, 73, 122); font-size:16px; padding-left:13px; padding-top:33px;">
					There are currently no student for this parent.
					</p>
					</li>
					<?php 
					}
					?>
                    
                </ul>
            </div>
            </div>
        </div>
    </div>
</div>


<div id="dialogdelete" title="Dialog Title" style="display:none;">
            <p>Click on appropriate button. </p>
</div>
<?php //3aug2012 ?>