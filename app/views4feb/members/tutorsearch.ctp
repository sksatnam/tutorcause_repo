<?php

/*echo '<pre>';
print_r($watchtutor);
print_r($filtertutor1);
die;*/

?>

<style>
#middlecontent
{
	width:auto !important;
	padding:0 !important; 
}
</style>
<script type="text/javascript">
$(document).ready(function(){

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
			
			//Mutual Friend Div
			$( "#showMutualFriend" ).dialog({
				autoOpen: false,width: 400,modal: true,buttons:{
					Cancel: function() {
						$( this ).dialog("close");
					}
				}
			});
			
			
			$('.click2showMutual').live("click",function(){
				var fb_id = $(this).attr('rel');
				$.ajax({
					type: "POST",
					url: ajax_url+'/members/facebookmutual1/'+fb_id,
					data: '&fb_id='+fb_id,
					success: function (html) {
						$("#showMutualFriend").html(html);
						$("#showMutualFriend").dialog("open");
					}
				});
			});
			//		   
						   
						   
						   
		   	$("#coursetext").autocomplete(ajax_url+"/members/get_course_id",{
				delay:10,
				minChars:1,
				matchSubset:1,
				matchContains:1,
				cacheLength:0,
				autoFill:false
			});
			
			
			
			
			
		/*	
			$('.click2showMutual').click(function(){
													$("#tutor-content").load(ajax_url+"/members/designsearch/page:2/9");
												  }

			*/
		 });
		 
   /*function view_biography()
                        {
						$("#biographyall").hide();
						$("#biography").slideDown();
						 return false;
						}
*/

function myfunc()
{
	$(".view").hide();
 	$("#biography").slideDown(1000);
 
 
 //$("#biography").show();

}
	

function showtutor(id)
{
   url = document.getElementById('pagingStatus').value;
   loadurl = url+'?tutorid='+id;
   $("#pagingDivParent").load(loadurl);
   
   return false;
   
}


			
</script>

<input type="hidden" name="pagingStatus" id="pagingStatus" value="<?php echo HTTP_ROOT.'members/tutorsearch/page:1';?>"  />


<div id="main-wrap">
	<div id="white-top"></div>
   	<div id="white-center">
    	<div id="content-center">
        	<div id="content-wrap">
               <?php	echo $this->Session->flash(); ?>
            	<h1>Tutor Search</h1>
             
                
				<div id="tutor-wrap"> <!--Cause Search Begin Here-->
                
                  <form name="tutorsearch" id="tutorsearch" action="<?php echo HTTP_ROOT.'members/tutorsearch';?>" method="post" >
                
				<div id="search-wrap">
                	<div id="cause-search">
                        <label>Type the course code here:</label>
                        <input name="data[TutCourse][course_id]" type="text" id="coursetext" value="<?php echo $this->Session->read('tutorsearch.course_id');?>" />
                        <input type="image" src="<?php echo FIMAGE;?>search-btn.png" />
					</div>
                    <div id="availability">
                        <label>Select by Availability:</label>
                        <ul>
                            <li>
                                <span>SUN</span>
                                <input name="data[TutCourse][sun]" type="checkbox" value="<?php echo $Sunday;?>" 
                                <?php 
								if($this->Session->read('tutorsearch.sun'))
								echo "checked=\"checked\"";
								?>/>
                            </li>
                            <li>
                                <span>MON</span>
                                <input name="data[TutCourse][mon]" type="checkbox" value="<?php echo $Monday;?>"
                                <?php 
								if($this->Session->read('tutorsearch.mon'))
								echo "checked=\"checked\"";
								?> />
                            </li>
                            <li>
                                <span>TUE</span>
                                <input name="data[TutCourse][tue]" type="checkbox" value="<?php echo $Tuesday;?>"
                                <?php 
								if($this->Session->read('tutorsearch.tue'))
								echo "checked=\"checked\"";
								?> />
                            </li>
                            <li>
                                <span>WED</span>
                                <input name="data[TutCourse][wed]" type="checkbox" value="<?php echo $Wednesday;?>"
                                <?php 
								if($this->Session->read('tutorsearch.wed'))
								echo "checked=\"checked\"";
								?> />
                            </li>
                            <li>
                                <span>THU</span>
                                <input name="data[TutCourse][thu]" type="checkbox" value="<?php echo $Thursday;?>"
                                <?php 
								if($this->Session->read('tutorsearch.thu'))
								echo "checked=\"checked\"";
								?> />
                            </li>
                            <li>
                                <span>FRI</span>
                                <input name="data[TutCourse][fri]" type="checkbox" value="<?php echo $Friday;?>"
                                <?php 
								if($this->Session->read('tutorsearch.fri'))
								echo "checked=\"checked\"";
								?> />
                            </li>
                            <li>
                                <span>SAT</span>
                                <input name="data[TutCourse][sat]" type="checkbox" value="<?php echo $Saturday;?>"
                                <?php 
								if($this->Session->read('tutorsearch.sat'))
								echo "checked=\"checked\"";
								?> />
                            </li>
                        </ul>
                        </div>
                    </div>		<!--Cause Search End Here-->
                    
                    
                    </form>
                    
                    
                
        <div id="pagingDivParent">
        	
        
        <?php
        if(count($filtertutor1))
		{
			echo $this->element('frontend/members/newtutorsearch');
		}	
		?>
        </div>
                
                
                    
                
                
                
			</div>
		</div>
	</div>
</div>
</div>
<div id="showMutualFriend" title="Mutual Friends"></div>

<div id="dialog-form1" title="Send Message">
	<div class="modal_conatiner">
		<ul>
			<li>
				<div class="modal_left">To:</div>
				<div class="modal_right" id="toTutName"></div>
				<div class="clear"><input type="hidden" id="toTutId" /></div>
			</li>
			<li>
				<div class="modal_left">Subject:<span class="red" style="color:#FF0000; margin-left:3px;" >*</div>
				<div class="modal_right"><input type="text" class="modal_text" id="subject" /></div>
				<div class="clear"><input type="hidden" id="tutor" /></div>
			</li>
			<li>
				<div class="modal_left">Message:<span class="red" style="color:#FF0000; margin-left:3px;" >*</div>
				<div class="modal_right"><textarea class="modal_area" id="message"></textarea></div>
				<div class="clear"></div>
			</li>
			
		</ul>
	</div>
	<div class="modal_msg" title="Message Sent"></div>
</div>

<!--<img src="<?php //echo FIMAGE.'cause.png';?>">-->