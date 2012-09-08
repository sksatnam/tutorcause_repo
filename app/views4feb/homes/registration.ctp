<?php
/*echo '<pre>';
print_r($schools);
die;
live facebook api     229378733769669
testing facebook api  226449800757981


*/
?>

<div id="fb-root"></div>
<!--<h2>Updated JS SDK example</h2><br />
<div id="user-info"></div>
<p><button id="fb-auth">Login</button></p>
-->

<script type="text/javascript">
	
$(function() {		   
	var pathname = window.location.pathname;
	var changeImage=$('.imageChange');
	var profileImage=$('.profileAjaxImage');
	new AjaxUpload(changeImage,
	{
		action: ajax_url+"/homes/img_reg_upload",
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
			
			/*alert(response);
			return false;*/
			
			if(response==="sizeError"){
				
				alert('Size must be less than 5 MB');
/*				errorMsg('Size must be less than 5 MB');*/
				
			}
			else if(response.indexOf("##success")>-1)
			{
				
				$('#userUploadImg').load(pathname+" #newPic");
				
				/*alert('jazz');
				alert(getImageX[0]);return false;
				getImageX=response.split("##suc");
				var newImg = ajax_url+'/img/members/'+getImageX[0];
				$('.profileAjaxImage img').attr('src',newImg);*/

			}
			else
			{	
				errorMsg('An Error Occured');
			}
			
			return false;
			
		}
	});
	
	$("#optionalinfo").hide();
	$("#optional").click(function () {
								   
	   var x = document.getElementById("optional").innerHTML;
	   
	   if(x=='(Show)')
	   {
		   document.getElementById("optional").innerHTML = '(Hide)';
	   }
	   else
	   {
		   document.getElementById("optional").innerHTML = '(Show)';
	   }
									   
		$("#optionalinfo").toggle("slow");
	
    });
	
	
/*	$.validator.addMethod("letters", function(value, element) {
		return this.optional(element) || /^[a-zA-Z\s ]+$/.test(value);
	}, "Letters only please"); 
	*/
	
	$("#state").change(function(){
		//alert('hi');
		$("#zipcode").val('') ;
		$("#zipcode").removeClass('error');
		$(".stepThreeFormRow1 span").remove();
		//$("#zipcode").removeClass('form li input.error');*/
		 
		});

	
});



window.fbAsyncInit = function() {
  FB.init({ appId: '<?php echo APPID;?>', 
	    status: true, 
	    cookie: true,
	    xfbml: true,
	    oauth: true});
  
  $("#fb-auth").live("click",function() {
			
      FB.login(function(response) {
	  if (response.authResponse) {
            FB.api('/me', function(response) {
								   
/*	      var userInfo = document.getElementById('user-info');
	      userInfo.innerHTML = 
                '<img src="https://graph.facebook.com/' 
	        + response.id + '/picture" style="margin-right:5px"/>' 
	        + response.name;
*/			
			
			var saveurl = '<?php echo HTTP_ROOT;?>homes/savefbid';
			
			$.ajax({
			type: "GET",
			url: saveurl,
			data: '&id='+response.id+'&first='+response.first_name+'&last='+response.last_name+'&email='+response.email,
			success: function(msg){
			
			/*	alert(msg);
			return false;*/
			
			msg = jQuery.trim(msg);
			
			if(msg=='false')
			{
			alert('This facebook id is already in use.')  
			
			FB.logout(function(response) {
			// user is now logged out
			});
			
			/*	window.location.reload();*/
			
			
			}
			else if(msg=='true')
				{
				FB.logout(function(response) {
				// user is now logged out
				});
				
				window.location.reload();
				}
			}
			});	
			
			/*$('#fb_registration_form').submit();*/
			
			
	    });	   
          } else {
            //user cancelled login or did not grant authorization
          }
        }, {scope:'email'}); 
			
	});	
  
};
	
(function() {
  var e = document.createElement('script'); e.async = true;
  e.src = document.location.protocol 
    + '//connect.facebook.net/en_US/all.js';
  document.getElementById('fb-root').appendChild(e);
}());


function errorMsg(msg){
	$('#errorMsg').html('<span style="color:red;"><b>'+msg+'</b></span>');
	$('#errorMsg').fadeIn().delay(3000).fadeOut();
}




		
/*function checktos()
{
	
	if(document.getElementById('tos').checked)
	{
		document.getElementById('submitbutton').disabled = true;
	}

}
*/
</script>


<style type="text/css">
#optional:hover
{
	color:#555 !important;
}

span.error{
	/*	padding-left:153px;*/
	float:none;
}
.stepThreeFormRow
{
	min-height:50px;
	width:650px;
}
.stepThreeFormRow label
{
	width:160px;
}
span.red
{
	color:#F00;
}
/*.userUploadImg{margin-bottom:10px;}*/
.stepThreeFormRgtCont{
	margin-left: 10px;
    width: 166px;
	padding:8px;
	font-size:14px;
	margin-top:10px;
}
</style>

<div id="content">
	<div class="stepsHeadingNew">
    
    <?php /*?>
		<?php if(!isset($user))
			{
			?>  
			<div class="newProgressBarOuter">
				<div class="proBarsSection2">
					<span class="spanNo">1</span>
					<span class="spanOnHover">Registration</span>
				</div>
				<?php
				if($this->data['Member']['group_id']==7)
				{
				?>
				<!--<div class="proBarsSection3">
					<span class="spanNo">2</span>
					<span class="spanOnHover">Tutor Payment</span>
				</div>
				<div class="proBarsSection3">
					<span class="spanNo">3</span>
					<span class="spanOnHover">Set Availablity</span>

				</div>
				<div class="proBarsSection3">
					<span class="spanNo">4</span>
					<span class="spanOnHover">Add Courses</span>
				</div>-->
				<?php
				}
				?>
			</div>
		<?php
		}
		?>
        <?php */?>
        
        <div class="loginPage">
		<h2>Basic Information</h2>
        </div>
        
	</div>
	<div class="public_register_cointainer_IInd">
		<div id="registration">
			<div class="regLeftCont">
            
				<div class="student-profile-img" style="margin-left:10px;width:184px; position:relative;">
                
                    <!--<div class="userUploadImg" id="userUploadImg" style="border:1px solid #ACDFFB;width:auto;padding:1px;max-width:184px;">-->
                    
                    <div class="userUploadImg profileAjaxImage" id="userUploadImg" style="border:1px solid #ACDFFB;width:auto;padding:1px;max-width:184px;">
                    
					<?php /*?>	<?php
						if(isset($picture) && !empty($picture)){
							echo $html->image("members/".$picture['UserImage']['image_name'],array('style'=>'max-width:180px;'));
						} else {
						?>
						<img src="https://graph.facebook.com/<?php echo $this->Session->read('Member.id'); ?>/picture?type=large" style="margin:0;float:none;width:auto;max-width:180px;" />
						<?php        
						} ?><?php */?>
                        
                        <?php
						$tmpimage = $this->Session->read('Member.tmpimage');
						
						if($this->Session->read('Member.facebook_id'))
						{
						?>	
							<img src="https://graph.facebook.com/<?php echo $this->Session->read('Member.facebook_id'); ?>/picture?type=large" style="max-width:180px;" />
						<?php	
						}
						else
						{
							if($tmpimage)
							{
							echo $html->image("members/temp/".$tmpimage,array('style'=>'max-width:180px;','id'=>'newPic'));
							}
							else
							{
							echo $html->image("dumy-photo.png",array('style'=>'max-width:180px;'));	
							}
						}
						?>
                        
					</div>
                    
                    
                    <div class="profileAjaxImage2">
                    <?php echo $html->image("frontend/ajax-loader.gif") ?>
                    </div>
                    
                    
					<div style="clear:both"></div>
                    
					<div id="errorMsg" style="width:180px;"></div>
                    
					<div class="imageChange" style="width:180px;">Change Profile Picture</div>
                    
                   <div class="stepFormContButton button" style="margin-left: 0px; width: 188px; margin-top: 5px;">  
                    	<span></span>
                        <a href="javascript:void(0);"><input type="button" id="fb-auth" value="Link with Facebook" /></a>
                   </div>  
                    
<!--                    <div class="linkFacebook" style="width:180px;">Link with Facebook</div>-->
                    
				</div>
                
           <!--     <a href="javascript:void(0)" onclick="Login();">Link with Facebook</a>-->
           
           <form name="fb_registration_form" id="fb_registration_form" action="<?php echo HTTP_ROOT.'homes/savefbid';?>" method="post">
           
           <input type="hidden" name="data[Member][facebookId]" id="facebook_id_fb" value="" />
           <input type="hidden" name="data[Member][fname]" id="facebook_fname" value="" />
           <input type="hidden" name="data[Member][lname]" id="facebook_lname" value="" />
           <input type="hidden" name="data[Member][email]" id="facebook_email" value="" />
           
           </form>
           
           
                
                <div class="stepThreeFormRgtCont">
                    <div class="stepThreeFormRgtOtherCont">
                    
                   	 <?php echo $rightText['Page']['body'];?>
                     	
                    </div>
                </div>
                
                
                
			</div>
			<?php
			echo $form->create('Member', array("url"=>array('controller'=>'homes', 'action'=>'savemember'),'id'=>'HomeSaveMember')); 
			?>
            
            <input type="hidden" name="data[Member][facebookId]" id="facebook_id" value="<?php if($this->Session->read('Member.facebook_id'))
			{
				echo $this->Session->read('Member.facebook_id');	
			}?>" />
            
            <?php /*?>
			<input type="hidden" value="<?php echo $this->data['Member']['id']?>" name="data[Member][id]" id="Memberid" style="color:#F00" />
			<?php if(isset($user) && $user!='')
			{
			?> 
			<input type="hidden" value="<?php echo $user?>" name="data[Member][user]"  style="color:#F00" />
			<?php	 
			}
			?>
            <?php */?>
            
				<div class="stepFormThird">
                
                
					
						<div class="stepThreeFormRow">
                        
                        <div class="input text"><label for="userMetaFname"><b>First Name:<span class="red">*</span></b></label><input type="text" id="userMetaFname" maxlength="25" class="textInStepFrm required letters" name="data[userMeta][fname]" value="<?php if($this->Session->read('Member.fname'))
						{
						echo $this->Session->read('Member.fname');	
							}?>"></div>
                        
							<?php // echo $form->input('userMeta.fname',array( 'label'=>'<b>First Name:<span class="red" >*</span></b>','class'=>'textInStepFrm required letters'));?>
						</div>
						<div class="stepThreeFormRow">
                        
                        
                        <div class="input text"><label for="userMetaLname"><b>Last Name:<span class="red">*</span></b></label><input type="text" id="userMetaLname" maxlength="25" class="textInStepFrm field required letters" name="data[userMeta][lname]" value="<?php if($this->Session->read('Member.lname'))
						{
						echo $this->Session->read('Member.lname');	
							}?>"></div>
                        
							<?php // echo $form->input('userMeta.lname',array('label'=>'<b>Last Name:<span class="red" >*</span></b>','class'=>'textInStepFrm field required letters'));?>
						</div>
						<div class="stepThreeFormRow">
                        
                        <div class="input text"><label for="MemberEmail"><b>Email:<span class="red">*</span></b></label><input type="text" id="MemberEmail" maxlength="45" class="textInStepFrm field required email" name="data[Member][email]" value="<?php if($this->Session->read('Member.email'))
						{
						echo $this->Session->read('Member.email');	
							}?>"></div>
                        
							<?php // echo $form->input('email', array( 'label'=>'<b>Email:<span class="red" >*</span></b>','class'=>'textInStepFrm field required email'));?>
						</div>
                        
                        <div class="stepThreeFormRow">
                        <label><b>Password:<span class="red">*</span></b></label>
                        <input type="password" name="data[Member][pwd]" value="" id="MemberPwd" class="textInStepFrm required" />
                        
						<?php //echo $form->input('member.pwd', array( 'label'=>'<b>Password:<span class="red" >*</span></b>','class'=>'textInStepFrm field required'));?>
                        
						</div>
                        
                        <div class="stepThreeFormRow">
                        
                        <label><b>Confirm Password:<span class="red">*</span></b></label>
                        <input type="password" name="data[Member][cPassword]" value="" class="textInStepFrm required" />
                            
						</div>
                        
                        
                       <div class="stepThreeFormRow">
                        <label><b>School:<span class="red">*</span></b></label>
                        
                        <?php
						if($this->Session->read('Member.group_id')=='6')
						{
						?>
                        <select multiple="multiple" size="4" name="data[CauseSchool][school_id][]" id="schoolid" style="width: 22em;" class="required">
							<?php foreach($schools as $key=>$value){ ?>
                            <option value="<?php echo $key;?>"><?php echo $value;?></option>
                            <?php } ?>
                            </select>
                        <?php 
						}
						else
						{
						?>
                          <select id="schoolname" class="selectStepFrm required" name="data[Member][school_id]">
                                <option value="" >Please select</option>
                                <?php
                                foreach($schools as $key=>$value)
                                {
                                ?>	
                                    <option value="<?php echo $key;?>"><?php echo $value;?></option>	
                                    
                                <?php    
                                }
                                ?>
                            </select>
                        <?php
						}
						?>
                        
                        
                        
                        </div>
                        
                         <?php
						if($this->Session->read('Member.group_id')=='6')
						{
						?>
                        <div style="padding-left:188px;">
                        (Press Ctrl key to select multiple schools)
                        </div>
                        <?php
						}
						?>
                        
                        
						
						<div class="stepThreeFormRow" style="min-height:25px;">
							<h2><span style="color: rgb(33, 158, 218); opacity: 0.4; font-size: 18px;">Optional Information</span><span style="font-size: 10px; opacity: 12 ! important; float: left; color: rgb(27, 143, 216); padding-top: 6px; cursor:pointer;" id="optional">(Show)</span></h2>
						</div>
                        
                        
                        <div id="optionalinfo">
                        
                       <div class="stepThreeFormRow">
							<?php echo $form->input('userMeta.contact', array( 'label'=>'<b>Phone:</b>', 
						'class'=>"textInStepFrm field phoneUS"));?>
						</div>
                        
                        
                        
						<div class="stepThreeFormRow">
							<?php echo $form->input('userMeta.address', array('type'=>'textarea',  'rows'=>'3', 'cols'=>'48','label'=>'<b>Street Address:<span class="red" ></span></b>', 'class'=>'textInStepFrm field textAreaHere alpha_num'));?>
						</div>
						<div class="stepThreeFormRow">
							<?php echo $form->input('userMeta.city', array( 'label'=>'<b>City:<span class="red" ></span></b>', 
						'class'=>"textInStepFrm field letters"));?>
						</div>
						<div class="stepThreeFormRow">
							<div class="input text">
								<label for="state"><b>State<span class="red" ></span></b>:</label>
								<select class="selectStepFrm field" name="data[userMeta][state]" id="state">
									<option value="">Select State</option>
										<?php
										foreach ( $states as $key => $val ) {
										?>
									<option value="<?php echo $val; ?>"
										<?php
											if($this->data['userMeta']['state']==$val)
											echo "selected=\"selected\"";
										?>
									><?php echo $val; ?></option>
									<?php  
									}
									?>
								</select>
							</div>   
						</div>
                    <div class="stepThreeFormRow stepThreeFormRow1">   
					<?php echo $form->input('userMeta.zip', array( 'label'=>'<b>Zip:</b>', 
					'class'=>'textInStepFrm field postalcodeonly' ,'id'=>'zipcode'));?>
					
					</div>
                    <div class="stepThreeFormRow">
					<?php echo $form->input('userMeta.biography', array( 'label'=>'<b>About Me:<span class="red" ></span></b>', 
					'class'=>'textInStepFrm field'));?>
					</div>
				<?php /*<li>
						<label style="font-size:16px;font-weight:bold;">Allow Facebook?</label>
						<?php echo $form->input('userMeta.fb_allow', array( 'label'=>false,'style'=>'margin:2px auto 2px 23px;','type'=>'checkbox','div'=>false));?>
					</li> */
					?>
                    
                    
                    <div class="stepThreeFormRow">
						<label style="font-size:16px;font-weight:bold;">Allow Email?</label>
						<?php echo $form->input('userMeta.email_allow', array( 'label'=>false,'style'=>'margin:9px auto 2px 0px;','type'=>'checkbox','checked'=>true,'div'=>false));?>
					</div>
                    
                    
                    
			<?php /*?>		
                    <?php if(!isset($user))
						{
						?>
                  	 <li>
						<label style="font-size:16px;font-weight:bold;">Allow Email?</label>
						<?php echo $form->input('userMeta.email_allow', array( 'label'=>false,'style'=>'margin:2px auto 2px 56px;','type'=>'checkbox','checked'=>true,'div'=>false));?>
					</li>
                    <?php
						}
						else
						{
					?>
                    <li>
						<label style="font-size:16px;font-weight:bold;">Allow Email?</label>
						<?php echo $form->input('userMeta.email_allow', array( 'label'=>false,'style'=>'margin:2px auto 2px 56px;','type'=>'checkbox','div'=>false));?>
					</li>
                    <?php
						}
					?><?php */?>
                    
                    
                
                    
                    </div>
                    
                    
                    
                 
					
                         <div class="stepThreeFormRow">
                          <label style="width:330px;"><b>I agree to the TutorCause <a href="<?php echo HTTP_ROOT;?>homes/terms_of_service" style="color: #1B8FD8; text-decoration:underline;" target="_blank">Terms of Service</a></b></label>
                     
                          <input type="checkbox" name="tos" value="1" class="required" style="margin-top:10px;" />
                     
			              </div>
					
                    
      
            
                    
				
				 <div class="stepFormContButton button" id="submitbutton" style="margin-left:190px;">
						<span></span>
						<input type="submit"  value="<?php if($user=='')
						{
							echo 'Select Type';
						}
						else if($user == 6)
						{
							echo 'Join as Cause';
						}
						else if($user == 7)
						{
							echo 'Join as Tutor';
						}
						else if($user == 8)
						{
							echo 'Join as Student';
						}
						?>" /> 
							</div>
			</div>
		</div>

		<?php echo $form->end();?> 
		
	</div>
</div>