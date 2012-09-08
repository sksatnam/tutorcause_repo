
<div id="fb-root"></div>
      <script src="http://connect.facebook.net/en_US/all.js#appId=313967068620256"></script>
      <script>
	  	FB.init({ 
            appId:'313967068620256', cookie:true, 
            status:true, xfbml:true /*, oauth : true*/
         });
		 
		 FB.getLoginStatus(function(response) {//document.getElementById("response").innerHTML=response.toSource();
		 	
		  });
		 function faceLogin(){
        	FB.login(function(response) {
          	 // document.getElementById('fb_login_text').innerHTML = 'Logout';
		  	  if (response.session) {
                FB.api('/me', function(response) {
					
                   			$('input[id=facebook_login_fb]').val(response['id']);
							$('#fb_login_form').submit();
                });
            }
            else {
              //  document.getElementById('fb_login_text').innerHTML = 'Login with Facebook';
            }
        });
			};
    
		function Login() {
        	FB.login(function(response) {
							  
          	 // document.getElementById('fb_login_text').innerHTML = 'Logout';
		  	  if (response.session) {
                FB.api('/me', function(response) {
					var str;
                    str = response['id'] + ";\n" +
                            response['name'] + ";\n" +
                            response['first_name'] + ";\n" +
                            response['last_name'] + ";\n" +                            
                            response['birthday'] + ";\n" +
                            response['gender'] + ";\n" +
							response['phone'] + ";\n" +
                            response['email'];
                   			$('input[id=first_name_fb]').val(response['first_name']);
							$('input[id=last_name_fb]').val(response['last_name']);
							$('input[id=email_fb]').val(response['email']);
							$('input[id=facebook_id_fb]').val(response['id']);
							$('input[id=facebook_phone]').val(response['phone']);
							$('input[id=facebook_dob]').val(response['birthday']);
							$('input[id=facebook_gender]').val(response['gender']);
							$('#fb_registration_form').submit();
                });
            }
            else {
              //  document.getElementById('fb_login_text').innerHTML = 'Login with Facebook';
            }
        }, { perms: 'user_birthday,email' });
    };
      </script>       
<script type="text/javascript">		
	function doRegistration()
	{	
		showDivAtCenter('ajaxProcess');
	
		jAjax.sendRequest({
			'url'	:	"<?php echo HTTP_ROOT?>homes/register",
			'data'	:	jAjax.serializeForm(document.getElementById('registrationForm')),
			'method'	:	'post',
			'dataType'	:	'json',
			'callback'	:	function(resp)
							{					
								$('#ajaxProcess').hide();
								
								if(resp.fineMsg!='' && typeof(resp.fineMsg)!='undefined')
								{		
								
									setTimeout('location.href="'+resp.trgtURL+'";', 3000);
								}
								else
								{
									$('#errMsgTitle').html("Error");
									
									var htmlTxt="Your details could not be submitted due to "+resp.errMsg.length+" error(s).";
									
									htmlTxt+="<ul>";
									
									for(var i=0; i<resp.errMsg.length;i++)
									{
										htmlTxt+="<li>"+resp.errMsg[i]+"</li>";
									}
									
									htmlTxt+="</ul>";
									
									$('#errMsgDet').html(htmlTxt);
									
									showDivAtCenter('errMsgDiv');
								}
							}
		
		});
		return false;
	}
	$(document).ready(function(){
	   $("#lstName").blur(function(){
			partLastName=$("#lstName").val();					   
			screenName=$("#frstName").val()+' '+partLastName.substr(0,1)+'.';
			$("#scrName").val(screenName);
	   });
	});
	function doLogin()
	{	
		showDivAtCenter('ajaxProcess');
	
		jAjax.sendRequest({
			'url'	:	"<?php echo HTTP_ROOT?>members/login",
			'data'	:	jAjax.serializeForm(document.getElementById('loginForm')),
			'method'	:	'post',
			'dataType'	:	'json',
			'callback'	:	function(resp)
							{					
								$('#ajaxProcess').hide();
								
								if(resp.fineMsg!='' && typeof(resp.fineMsg)!='undefined')
								{											
									
									setTimeout('location.href="'+resp.trgtURL+'";', 3000);
								}
								else
								{
									$('#errMsgTitle').html("Error");
									
									var htmlTxt="Your details could not be submitted due to "+resp.errMsg.length+" error(s).";
									
									htmlTxt+="<ul>";
									
									for(var i=0; i<resp.errMsg.length;i++)
									{
										htmlTxt+="<li>"+resp.errMsg[i]+"</li>";
									}
									
									htmlTxt+="</ul>";
									
									$('#errMsgDet').html(htmlTxt);
									
									showDivAtCenter('errMsgDiv');
								}
							}
		
		});
		return false;
	}
	
</script>

  <div class="loginWidFb"><a href="#"><?php echo $html->image('frontEnd/sign_up_fb.png',array('onclick'=>'Login();'));?>jaswant</a></div>

