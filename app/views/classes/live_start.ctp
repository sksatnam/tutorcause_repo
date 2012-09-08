<?php //3aug2012 ?><?php
/*echo $secondleft;
die;
*/?>


<?php
/*echo '<pre>';
print_r($paymentData);
print_r($uploadFile);
die;
*/
?>


<?php
	$tutorrate = $paymentData['PaymentHistory']['tutor_rate_per_hour'];
	$extendleft =  $secondleft - 300;
?>




<script type="text/javascript">


function serverTime() { 
    var time = null; 
    $.ajax({url: ajax_url+"/classes/server_time", 
        async: false, dataType: 'text', 
        success: function(text) { 
            time = new Date(text); 
        }, error: function(http, message, exc) { 
            time = new Date(); 
    }}); 
    return time; 
}

function reloadPage()
{
	window.location.reload()
}


function extendlastfive()
{

	document.getElementById('extmsg').innerHTML = 'Last 5 minutes left in session Please select minutes to extend session  ?';
	extendtutoring();
	
}



function myTimestamp(){    tstmp = new Date();        return tstmp.getTime();} 

var refreshId = setInterval(function()
{
	checkupload();
}, 10000);



var refreshchatId = setInterval(function()
{
	checkchat();
}, 4000);


$(document).ready(function(){
						   
			$('#liveCountdown').countdown({ 
			until: +<?php echo $secondleft;?>, serverSync: serverTime , onExpiry: reloadPage }); 
			
			
			
			
			<?php
			if($this->Session->read('Member.group_id')==8)
				{
				?>	
				
					$('#extendCountdown').countdown({ 
					until: +<?php echo $extendleft;?>, serverSync: serverTime , onExpiry: extendlastfive }); 
				
				<?php
				}
			?>
						   
						   
			// start uploading ajax data for pagination
			
			$("div.pagingUpload a").live('click',function(){
														  
				$('.files-wrap').css('opacity','0.4');
				$('.uploadAjaxImage').show();										  
														  
														  
				url =  $(this).attr("href");											  
				
				$.get(url,{},function(data){ 
									  
				$("div#pagingDivUpload").html(data);
				
				$('.files-wrap').css('opacity','1');
				$('.uploadAjaxImage').hide()
				
				});										  
															  
				
				//	loadData({href : $(this).attr("href"),divName : "#pagingDivUpload"});
				
				return false;
			});
			
			$("div.pagingChat a").live('click',function(){	
			
			$('.text-messages').css('opacity','0.4');
			$('.chatAjaxImage').show();		
			
			chaturl =  $(this).attr("href");											  
														  
			$.get(chaturl,{},function(data){ 
									  
			$("div#pagingDivChat").html(data);
			
			$('.text-messages').css('opacity','1');
			$('.chatAjaxImage').hide()
			
			
			});		
														
			//var divId2 = $(this).parents('div').parents('div').attr('id');
			
			//loadData({href : $(this).attr("href"),divName : "#"+divId2});
			
		//	loadData({href : $(this).attr("href"),divName : "#pagingDivChat"});
			
			return false;
			});
			// end uploading ajax data
			
			
			loadupload();
			loadchat();
			
			
						   
		//	$("#biography").hide();
			$(".sendMessage").live("click",function() {
			$('#subject').val('');
			$('#message').val('');				
			$('#toTutId').val($(this).parent().find('.resultId').val());
			$('#toTutName').html($(this).parent().find('.resultName').val());
			$("#dialog-form1").dialog("open");
			});	
			
			
		/*	$(".view").click(function()
					{
						$("#biographyall").hide();
						$("#biography").slideDown();
						
					});		   */
						   
			
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
			
});

	
$(function() {
		   
		 
		   
	var changeImage=$('.imageChange');
	var profileImage=$('.files-wrap');
	new AjaxUpload(changeImage,
	{
		
		action: ajax_url+"/classes/file_upload/"+$('#paymentId').val(),
		name: 'userImage',
		onSubmit: function(file, ext)
		{
			if (! (ext && /^(xlsx|xls|docx|doc|pptx|ppt|pdf)$/.test(ext)))
			{

				$('#uploaderr').fadeIn().delay(7000).fadeOut();
				
				return false;
			}
			
			$('.files-wrap').css('opacity','0.4');
			$('.profileAjaxImage2').show();
			
		},
		onComplete: function(file, response)
		{
			response = jQuery.trim(response);
			
			$('.files-wrap').css('opacity','1');
			$('.profileAjaxImage2').hide()
			
			if(response==="sizeError"){
				alert('Size must be less than 5 MB');
/*				errorMsg('Size must be less than 5 MB');*/
				return false;
			}
			else if(response=='ok')
			{
				loadupload();
			}
			else
			{
				errorMsg('An Error Occured');
				return false;
			}
		}
	});
});






/*function errorMsg(msg){
	$('#errorMsg').html(msg);
	$('#errorMsg').fadeIn().delay(3000).fadeOut();
}
*/



function loadupload()
{
	
	loaduploadurl = ajax_url+"/classes/getupload/"+$('#paymentId').val()+'/page:1'+'/'+myTimestamp();
	
	$.get(loaduploadurl,{},function(data){ 
			$("div#pagingDivUpload").html(data);
			});
	
	//  loaduploadurl = ajax_url+"/classes/getupload/"+$('#paymentId').val()+'/'+myTimestamp();
	 
	 // jQuery('#myDIV').load('/myurl/param_1/param_2/' + myTimestamp()); 
	
   //   $('#pagingDivUpload').fadeOut("slow").load(loaduploadurl).fadeIn("slow");
	
}


function loadchat()
{
	
	loadchaturl = ajax_url+"/classes/getchat/"+$('#paymentId').val()+'/page:1'+'/'+myTimestamp();
	
	$.get(loadchaturl,{},function(data){
			$("div#pagingDivChat").html(data);
			});
	
	
	//  loadchaturl = ajax_url+"/classes/getchat/"+$('#paymentId').val()+'/'+myTimestamp();
	 
	 // jQuery('#myDIV').load('/myurl/param_1/param_2/' + myTimestamp()); 
	 
   //  $('#pagingDivChat').fadeOut("slow").load(loadchaturl).fadeIn("slow");
	
}




function checkupload()
{
	
	var checklive = ajax_url+"/classes/check_upload/"+$('#uploadcnt').val()+'/'+$('#paymentId').val()+'/'+myTimestamp();
/*	var uploadcnt = $('#uploadcnt').val();
	var paymentId = $('#paymentId').val();
*/	
	$.ajax({
				   type: "GET",
				   url: checklive,
				   success: function(msg){
					   
					   
				//	   alert(msg);
					   
					   
					   msg = jQuery.trim(msg);
					   
					   if(msg=='true')
					   {
							loadupload();   
					   }
					   
					  // alert(msg);
					//    msg = jQuery.trim(msg);
					   
					   }
				 });	
	
}


function checkchat()
{
	
	var checklive = ajax_url+"/classes/check_chat/"+$('#chatcnt').val()+'/'+$('#paymentId').val()+'/'+myTimestamp();
/*	var uploadcnt = $('#uploadcnt').val();
	var paymentId = $('#paymentId').val();
*/	
	$.ajax({
				   type: "GET",
				   url: checklive,
				   success: function(msg){
					   
					   
				//	   alert(msg);
					   
					   
					   msg = jQuery.trim(msg);
					   
					   if(msg=='true')
					   {
							loadchat();   
					   }
					   
					  // alert(msg);
					//    msg = jQuery.trim(msg);
					   
					   }
				 });	
	
}



function savechat()
{
	
//var chattxt = tinyMCE.activeEditor.getContent({format : 'raw'});
  var chattxt = tinyMCE.activeEditor.getContent();
  
  var chaturl = ajax_url+"/classes/save_chat/";
  
  if(chattxt=='')
  {
//	alert('Please enter chat message.');
	
	$('#chaterr').fadeIn().delay(7000).fadeOut();
	
	return false;
  }
  
  
  
  
  
/*alert(chattxt);
  alert(tinyMCE.get('elm1').getContent());
  return false;
*/  
  
  $.post(chaturl, { id: $('#paymentId').val(), chat: chattxt },
   function(msg) {
	    
			   msg = jQuery.trim(msg);
			   if(msg=='true')
			   {
				  tinyMCE.getInstanceById('elm1').setContent('');
				  loadchat();   
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
        "Yes": function() {
			
		$(this).dialog("close");
		var endsessionurl = '<?php echo HTTP_ROOT;?>classes/end_session';
		window.location = endsessionurl;
		
        },
        "No": function() {
			
			$(this).dialog("close");
			
		},
	   }
    });	
}

function extendtutoring()
{
	
	$('#dialogextend').dialog({
        autoOpen: true,
        title:"Extend Tutoring Session",
        width: 600,
        modal:true,
        buttons: {
        "Yes": function() {
			
			
		//	var id = $("input[@name=extendmin]:checked").attr('id');
			
			var extdmin = $("input[@name=testGroup]:checked").val();
			
			if(extdmin)
			{	
			
				var extsession = ajax_url+"/classes/extend_session/"+extdmin+'/'+$('#paymentId').val()+'/'+myTimestamp();
				
				
				$.ajax({
					   type: "GET",
					   url: extsession,
					   success: function(msg){
						   
						   
						 /*  alert(msg);
						   return false;
						   */
						   
						   
								   msg = jQuery.trim(msg);
								   if(msg=='true')
								   {
										reloadPage();
								   }
								   else
								   {
										alert('Not enough account balance.');
								   }
								   
								   return false;
						   
						   }
					 });	

				
				
			}
			else
			{
				
				
				alert('Please Select minutes.')
				
				
				
			}
			
			
			return false;
			
			
		$(this).dialog("close");
		var endsessionurl = '<?php echo HTTP_ROOT;?>classes/end_session';
		window.location = endsessionurl;
		
        },
        "No": function() {
			
			$(this).dialog("close");
			
		},
	   }
    });	
}






</script>

<style type="text/css">
#liveCountdown { 
	width: 190px; 
	height: 45px;
	}
.extprice
{
	color:#21A7E3;
	margin-left:5px;
}
.extlabel
{
	margin-left:5px;
	margin-right:5px;
}
</style>



    <div id="content-wrap">
              <h1>Video Tutoring</h1>
              
              <?php 
			  		$paymentId = base64_encode(convert_uuencode($paymentData['PaymentHistory']['id']));
					
			  ?>
              
              <input type="hidden" name="paymentId"  value="<?php echo $paymentId; ?>" id="paymentId" />
              
              <div id="tutor-wrap">
              
              
                <div id="tutor-content"> 
                
                
                <!--Tutoring new Left Column Begin Here-->
                  <div class="tutoring-new-left">
                  
                  <div class="tutoring-video">
                      <div class="tutoring-video-heading">Start video Chat with your <?php
                      if($this->Session->read('Member.group_id')==7)
					  {
						  echo 'student';
					  }
					  else
					  {
						echo 'tutor';
					  }?> here</div>
                      <div class="video-chat">
                      
                 <?php /*?>     <img src="<?php echo FIMAGE;?>tokbox.png" width="350" height="265" alt="tokbox"/>	<?php */?>
                        
         			 <?php
					 if($paymentData['PaymentHistory']['tokbox'])
					 {
						 $tokbox = $paymentData['PaymentHistory']['tokbox'];
				  	 ?>
                     
                      <iframe id="videoEmbed" src="http://api.opentok.com/hl/embed/<?php echo $tokbox;?>" width="525" height="425" style="border:none" frameborder="0"></iframe>
                     
                     <?php
					 }
					 else
					 {
					 ?>	 
					  <img src="<?php echo FIMAGE;?>tokbox.png" width="525" height="425" alt="tokbox"/>	
					 <?php	 
					  }
					 ?>
                      
                       
                      </div>
                    </div>
                  
                   </div>
                  
                  <!--Tutoring new Left Column End Here-->
                  
                  
                  <!--Tutoring new Right Column Begin Here-->
                  
                    <div class="tutoring-new-right">  
                     
                    <div class="tutoring-chat">
                    
                      <div class="tutoring-heading">Discuss with your <?php
                      if($this->Session->read('Member.group_id')==7)
					  {
						  echo 'student';
					  }
					  else
					  {
						echo 'tutor';
					  }?> through text chat</div>
                      <div class="text-chat">
                      
                        <div id="pagingDivChat" style="height:229px;">
                        
                        <?php echo $this->element('frontend/livechat'); ?>
                        
                        </div>
                        
                        <div class="type-messages">
                        
                            <textarea id="elm1" class="mceEditor" style="width:350px;"></textarea>                    
                            
                                   
                            <div class="send-messages"> 
                            
                            <span id="chaterr" style="color:#F00; display:none;">Please enter some text.</span>                         
                           
                            
                                    <input type="image" src="<?php echo FIMAGE;?>send-btn.png" onclick="javascript:savechat();" />
                            </div>
                        
                        </div>                     
                     
                        
                        
                      </div>
                    </div>
                    
                    
                    </div>
                 <!--Tutoring new Right Column End Here-->
                
                
                
                 <!--Tutoring Middle Column Begin Here-->
                  <div class="tutoring-new-middle">
                
                
                  <?php
					 if($paymentData['PaymentHistory']['twiddla'])
					 {
						 $twiddla = $paymentData['PaymentHistory']['twiddla'];
				  ?>	 
					 <iframe src="http://www.twiddla.com/api/start.aspx?sessionid=<?php echo $twiddla;?>&hide=chat,bottomtray" frameborder="0" width="897" height="525"  style="margin-bottom:25px; border:1px solid #AAAAAA;"></iframe>
				    	 
				  <?php	 
					 }
				  ?>
                
                </div>
                
                <!--Tutoring Middle Column End Here-->
                
                
                
                  
                  <!--Tutoring Left Column Begin Here-->
                  <div class="tutoring-left">
                  
                    <?php 
					  if($this->Session->read('Member.group_id')==8)
					  {
					  ?> 	  
                        <div class="tutoring-profile-widget">
                          <div class="widget-profile-heading">Tutor Profile</div>
                          <div class="widget-profile-bg">
                            <div class="tutor-info">
                              <div class="tutor-pic">
                              <?php
                                if($paymentData['tutor']['showImage'])
                                {
                                if(!empty($paymentData['tutor']['image_name'])){
                                echo $html->image("members/thumb/".$paymentData['tutor']['image_name'],array('class'=>'profile-img-thumb'));
                                } else {
                                ?><img src="https://graph.facebook.com/<?php echo $paymentData['tutor']['facebookId']; ?>/picture?type=large" class="profile-img-thumb"  />
                                <?php }
                                }
                                else
                                {
                                echo $html->image("profile-photo.png",array('class'=>'profile-img-thumb'));
                                }
                                ?>
                              </div>
                              <div class="tutor-detail">
                              <?php
                              if(!empty($paymentData['tutor']['fname']))
							  {
							   	$tutorname = $paymentData['tutor']['fname'].' '.$paymentData['tutor']['lname'];  
								$tutorname = ucwords($tutorname);
								echo $tutorname;
							  }
							  ?>
                              </div>
                            </div>
                            <a href="javascript:void(0)" class="send-message sendMessage"></a>
                            <input type="hidden" class="resultId" value="<?php echo $paymentData['tutor']['id'];?>" />
                            <input type="hidden" class="resultName" value="<?php echo $paymentData['tutor']['fname'].' '.$paymentData['tutor']['lname'];?>" />
                            <a href="<?php echo HTTP_ROOT."members/book_tutor_time/".$paymentData['tutor']['id'];?>" class="book-tutor-again"></a> </div>
                        </div>
                      <?php
					  }
					  else if($this->Session->read('Member.group_id')==7)
					  {
					  ?>	
                       <div class="tutoring-profile-widget">
                          <div class="widget-profile-heading">Student Profile</div>
                          <div class="widget-profile-bg">
                            <div class="tutor-info">
                               <div class="tutor-pic">
                              <?php
                                if($paymentData['student']['showImage'])
                                {
                                if(!empty($paymentData['student']['image_name'])){
                                echo $html->image("members/thumb/".$paymentData['student']['image_name'],array('class'=>'profile-img-thumb'));
                                } else {
                                ?><img src="https://graph.facebook.com/<?php echo $paymentData['student']['facebookId']; ?>/picture?type=large" class="profile-img-thumb"  />
                                <?php }
                                }
                                else
                                {
                                echo $html->image("profile-photo.png",array('class'=>'profile-img-thumb'));
                                }
                                ?>
                              </div>
                              <div class="tutor-detail">
                              <?php
                              if(!empty($paymentData['student']['fname']))
							  {
							   	$studentname = $paymentData['student']['fname'].' '.$paymentData['student']['lname'];   
								$studentname = ucwords($studentname);
								echo $studentname;
								
							  }
							  ?>
                              </div>
                            </div>
                            <a href="javascript:void(0)" class="send-message sendMessage"></a>
                                <input type="hidden" class="resultId" value="<?php echo $paymentData['student']['id'];?>" />
                                <input type="hidden" class="resultName" value="<?php echo $paymentData['student']['fname'].' '.$paymentData['student']['lname'];?>" />
                            </div>
                        </div>
                      <?php	  
					  }
					  ?>
                    
                    
                    
                    
                    
                    
                  </div>
                  
                  <!--Tutoring Left Column End Here-->
                  
                  <div class="tutoring-right">
                  
           <?php /*?>       
 				  <div class="tutoring-app" style="display:none;">
                  <?php
					 if($paymentData['PaymentHistory']['twiddla'])
					 {
						 $twiddla = $paymentData['PaymentHistory']['twiddla'];
				  ?>	 
					 <iframe src="http://www.twiddla.com/api/start.aspx?sessionid=<?php echo $twiddla;?>&hide=chat,bottomtray,etherpad,documents&css=http://www.twiddla.com/demo/altskin.css" frameborder="0" width="525" height="425" scrolling="auto" style="margin-bottom:25px;"></iframe>
				    
                    	 
				  <?php	 
					 }
				  ?>
                  </div>
                  <?php */?>
                  
                    <div class="tutoring-features">
                      <div class="files-upload">
                        <div class="upload-heading">Upload the files here</div>
                        <div class="files-upload-wrap" style="position:relative;">
                          <div class="files-upload-btn">
                            <div class="files-upload-btn-wrap">
                              <p>Select file from your computer to upload</p>
                                    <div class="imageChange" style="width: 85px; margin-right: 168px; margin-top: 5px; margin-bottom: 5px;">Upload File</div>  
                                    
                                     <p class="ext" id="uploaderr" style="color:#F00; display:none; width:267px;" >You can upload PDF, Word, Powerpoint, or Excel files</p>
                                    
                            </div>
                          </div>
                         
                            <div id="pagingDivUpload">
                            
	                            <?php echo $this->element('frontend/liveupload'); ?>
                            
                            </div>
                          
                          
                        </div>
                      </div>
                      <div class="tutoring-widgets-wrap">
                      
                      
                    
                        
                        
                        <div class="tutoring-widget">
                          <div class="widget-heading">Live Timer & Billing Info</div>
                          <div class="widget-bg">
                          
                          
                          <div class="live-timer"> 
                          
                          
                            <div id="liveCountdown"></div> 
                            <div id="extendCountdown" style="display:none;"></div> 
                            
                        
                          
                          
                  <!--   <iframe src="http://free.timeanddate.com/clock/i2xal8s4/n105/szw110/szh110/hoc000/hbw6/hfceee/cf100/hncccc/hcw2/fdi76/mqc000/mql10/mqw4/mqd98/mhc000/mhl13/mhw4/mhd98/mmc000/mml10/mmw1/mmd98/hhs2/hms2" frameborder="0" width="112" height="112"></iframe>-->



                            
                           
                            
                            <div class="live-time">
                            
                         <!--  <iframe src="http://free.timeanddate.com/clock/i2xajt6e/n105/fs15/fc2aafea/tct/pct/ftb/tt0/tw0/tm1/ts1/tb2" frameborder="0" width="158" height="20" allowTransparency="true"></iframe>-->


							</div>
                            
                            
                            <?php /*?><div class="live-timer"> 
                            <img src="<?php echo FIMAGE;?>watch-icon.png" width="96" height="86" alt=""/>
                              <div class="live-time">10:05 PM 14/12/2011</div><?php */?>
                              
                            </div>
                            
                            
                          </div>
                        </div>
                        <a href="http://support.tutorcause.com/customer/portal/emails/new" class="report-issue"></a>
                        <a href="javascript:deleteaccount();" class="end-session"></a>   
                        
							<?php
                            if($this->Session->read('Member.group_id')==8)
								{
								?>	
									<a href="javascript:extendtutoring();" class="extend-session" style="margin-top:5px;"></a>
								<?php
								}
                            ?>
                        
                         </div>
                        
                       
                        
                        
                    </div>
                  </div>
                </div>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
              </div>
            </div>
<div id="dialogdelete" title="Dialog Title" style="display:none;">
            <p>Do you really want to end session ? </p>
</div>


<div id="dialogextend" title="Dialog Title" style="display:none;">
            <p style="padding:5px 0px;" id="extmsg">Please select minutes to extend session  ? </p>
            <div style="margin:10px 0px 10px 85px; float:left">
            
            
            <div class="extmin1" style="float:left; width:400px; margin-bottom:10px;">
            
            <div class="extrow1" style="float:left;">
                <input type="radio" name="extendmin" value="15" />
                <label class="extlabel">15 minutes 
				<span class="extprice"><?php $rate1 = (15/60) * $tutorrate; 
				$rate1 = sprintf("%.2f", $rate1 );
				echo '( $ '.$rate1.' )'; ?> </span>
				</label>
                
                
                
            </div>
            
            
            
            <div class="extrow1" style="float:right">
                <input type="radio" name="extendmin" value="30" />
                <label class="extlabel">30 minutes
                <span class="extprice"> <?php $rate2 = (30/60) * $tutorrate; 
				$rate2 = sprintf("%.2f", $rate2 );
				echo '( $ '.$rate2.' )'; ?> </span> 
                </label>
            </div>    
                
                
            </div>    
              
             
            <div class="extmin2" style="float:left; width:400px;">  
            
            
            	<div class="extrow2" style="float:left;" >    
                <input type="radio" name="extendmin" value="45" />
                <label class="extlabel">45 minutes
                <span class="extprice"> <?php $rate3 = (45/60) * $tutorrate; 
				$rate3 = sprintf("%.2f", $rate3 );
				echo '( $ '.$rate3.' )'; ?> </span> 
                </label>
                </div>
              
                <div class="extrow2" style="float:right;">
                <input type="radio" name="extendmin" value="60" /><label class="extlabel">60 minutes
                <span class="extprice"> <?php $rate4 = (60/60) * $tutorrate; 
				$rate4 = sprintf("%.2f", $rate4 );
				echo '( $ '.$rate4.' )'; ?> </span> 
                </label>
                </div>
                
            </div>    
              
                
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
				<div class="modal_left">Subject:<span class="red" style="color:#FF0000; margin-left:3px;">*</span></div>
				<div class="modal_right"><input type="text" class="modal_text" id="subject" /></div>
				<div class="clear"><input type="hidden" id="tutor" /></div>
			</li>
			<li>
				<div class="modal_left">Message:<span class="red" style="color:#FF0000; margin-left:3px;">*</span></div>
				<div class="modal_right"><textarea class="modal_area" id="message"></textarea></div>
				<div class="clear"></div>
			</li>
			
		</ul>
	</div>
	<div class="modal_msg" title="Message Sent"></div>
</div>




            
            
            

