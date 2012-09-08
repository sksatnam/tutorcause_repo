
<?php
/*echo '<pre>';
print_r($paymentData);
print_r($uploadFile);
die;
*/
?>


<script type="text/javascript">

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
		var endsessionurl = '<?php echo HTTP_ROOT;?>members/myclass';
		window.location = endsessionurl;
		
        },
        "No": function() {
			
			$(this).dialog("close");
			
		},
	   }
    });	
}


</script>


    <div id="content-wrap">
              <h1>Video Tutoring</h1>
              
              <?php 
			  		$paymentId = base64_encode(convert_uuencode($paymentData['PaymentHistory']['id']));
					
			  ?>
              
              <input type="hidden" name="paymentId"  value="<?php echo $paymentId; ?>" id="paymentId" />
              
              <div id="tutor-wrap">
              
              
                <div id="tutor-content"> 
                
                
                  <?php
					 if($paymentData['PaymentHistory']['twiddla'])
					 {
						 $twiddla = $paymentData['PaymentHistory']['twiddla'];
				  ?>	 
					 <iframe src="http://www.twiddla.com/api/start.aspx?sessionid=<?php echo $twiddla;?>&hide=chat,bottomtray" frameborder="0" width="897" height="525"  style="margin-bottom:25px; border:1px solid #AAAAAA;"></iframe>
				    	 
				  <?php	 
					 }
				  ?>
                
                  
                  <!--Tutoring Left Column Begin Here-->
                  <div class="tutoring-left">
                    <div class="tutoring-video">
                      <div class="tutoring-heading">Start video Chat with your tutor here</div>
                      <div class="video-chat">
                      
                 <?php /*?>     <img src="<?php echo FIMAGE;?>tokbox.png" width="350" height="265" alt="tokbox"/>	<?php */?>
                        
         			 <?php
					 if($paymentData['PaymentHistory']['tokbox'])
					 {
						 $tokbox = $paymentData['PaymentHistory']['tokbox'];
				  	 ?>
                     
                      <iframe id="videoEmbed" src="http://api.opentok.com/hl/embed/<?php echo $tokbox;?>" width="350" height="265" style="border:none" frameborder="0"></iframe>
                     
                     <?php
					 }
					 else
					 {
					 ?>	 
					  <img src="<?php echo FIMAGE;?>tokbox.png" width="350" height="265" alt="tokbox"/>	
					 <?php	 
					  }
					 ?>
                      
                       
                      </div>
                    </div>
                    <div class="tutoring-chat">
                    
                      <div class="tutoring-heading">Discuss with your tutor through text chat</div>
                      <div class="text-chat">
                      
                        <div id="pagingDivChat">
                        
                        <?php echo $this->element('frontend/livechat'); ?>
                        
                        </div>
                        
                        <div class="type-messages">
                        
                   		    <textarea id="elm1" class="mceEditor" style="width:100%;"></textarea>                    
                            
                                   
                            <div class="send-messages"> 
                            
                            <span id="chaterr" style="color:#F00; display:none;">Please enter some text.</span>                         
                           
                            
                                    <input type="image" src="<?php echo FIMAGE;?>send-btn.png" onclick="javascript:savechat();" />
                            </div>
                        
                        </div>                     
                     
                        
                        
                      </div>
                    </div>
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
                      
                      
                      <?php 
					  if($this->Session->read('Member.group_id')==8)
					  {
					  ?> 	  
                        <div class="tutoring-widget">
                          <div class="widget-heading">Tutor Profile</div>
                          <div class="widget-bg">
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
							   	echo $paymentData['tutor']['fname'].' '.$paymentData['tutor']['lname'];   
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
                       <div class="tutoring-widget">
                          <div class="widget-heading">Student Profile</div>
                          <div class="widget-bg">
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
							   	echo $paymentData['student']['fname'].' '.$paymentData['student']['lname'];   
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
                        
                        
                        <div class="tutoring-widget">
                          <div class="widget-heading">Live Timer & Billing Info</div>
                          <div class="widget-bg">
                          
                          
                          <div class="live-timer"> 
                          
                          
                    
                          
                          
                     <iframe src="http://free.timeanddate.com/clock/i2xal8s4/n105/szw110/szh110/hoc000/hbw6/hfceee/cf100/hncccc/hcw2/fdi76/mqc000/mql10/mqw4/mqd98/mhc000/mhl13/mhw4/mhd98/mmc000/mml10/mmw1/mmd98/hhs2/hms2" frameborder="0" width="112" height="112"></iframe>



                            
                           
                            
                            <div class="live-time">
                            
                           <iframe src="http://free.timeanddate.com/clock/i2xajt6e/n105/fs15/fc2aafea/tct/pct/ftb/tt0/tw0/tm1/ts1/tb2" frameborder="0" width="158" height="20" allowTransparency="true"></iframe>


							</div>
                            
                            
                            <?php /*?><div class="live-timer"> 
                            <img src="<?php echo FIMAGE;?>watch-icon.png" width="96" height="86" alt=""/>
                              <div class="live-time">10:05 PM 14/12/2011</div><?php */?>
                              
                            </div>
                            
                            
                          </div>
                        </div>
                        <a href="http://support.tutorcause.com/customer/portal/emails/new" class="report-issue"></a>
                        <a href="javascript:deleteaccount();" class="end-session"></a> </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
<div id="dialogdelete" title="Dialog Title" style="display:none;">
            <p>Do you really want to end session ? </p>
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




            
            
            

