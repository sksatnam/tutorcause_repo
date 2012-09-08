<?php
if($countMsg>0){
	$countMsg = "(".$countMsg.")";
} else {
	$countMsg = "";
}
?>
<script type="text/javascript">	
$(document).ready(function () {
	$('#menu').tabify();
	$('#menu2').tabify();
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
	$(".sendMessage").click(function() {
			$('#toTutName').html($(this).parent().next().next().val());
			$('#toTutId').val($(this).parent().next().val());
			var subject = $(this).parent().next().next().next().val();
			$('.StudentSubbject').html(subject);
			$('#subject').val(subject);
			$("#dialog-form1").dialog("open");
	});
	
	$("#coursetext").autocomplete(ajax_url+"/members/get_course_id",{
				delay:10,
				minChars:1,
				matchSubset:1,
				matchContains:1,
				cacheLength:0,
				autoFill:false
			});
			
			$('.delete').live("click",function() {
								   	$(this).parent().remove();
								   });
								   
								   
								   
			$('.delete').click(function(){
			var thisRow = $(this);
			var courseId = $(this).parent().find('.hidCourse').val();
			//alert(courseId);
			$.ajax({
			   type: "POST",
			   url: ajax_url+"/members/deletecourse1",
			   data: "&courseId="+courseId,
			   success: function(msg){
				   if(msg==1){
					   thisRow.parent().remove();
				   } else {
					   alert(msg);
				   }
			 }
			 });
		});
		
		
	
		
	/*$('#addcourse1').click(function () {
        checkCourseName(function (response) {
            if (response) {
			
				var courseName = $('#coursetext').val();
		        var allCources = $('#allCources').val();
				var numbFound=(allCources.indexOf(','+courseName+','));
				if(numbFound>-1){
					$('#courseTitleMsg').text("course name");
					return false;
				}
				else
				{
					$('#CourseAddForm').submit();
				 }
            }
        });
    
	return false;
	});*/
		
	});
		
		
		
	/*function checkCourseName() {
        var dataurl = ajax_url + "/Members/checkcoursename/";
        var courseName = $('#coursetext').val();
        var allCources = $('#allCources').val();		
        if (courseName === "") {
            $('#courseTitleMsg').text("Please enter course name");
			return false;
        } else if('hello'=='hello'){
			//alert(courseName);
			//alert(allCources);
			//alert(','+courseName+',');
			var numbFound=(allCources.indexOf(','+courseName+','));
			if(numbFound>-1){
				$('#courseTitleMsg').text("course name");
				return false;
			}
			//return false;
		
		} else {
            $.ajax({
                type: "POST",
                url: dataurl,
                data: "&courseCode=" + courseName,
                success: function (response) {
                    if (parseInt(response,10) > 0) {
                        $('#courseTitleMsg').text("Course name already exist");
                        return false;
                    } else {
                        //callback(response)
                    }
                }
            });
        }
    }*/
	
	



	
$(document).ready(function(){
	$('.cancelRequest').click(function(){
		var request = $(this);
		$('#dialogCancel').dialog({
		autoOpen: true,
		title:"Cancel Request",
		width: 600,
		modal:true,
		buttons: {
			"Yes": function() {
				request.parent().parent().parent('form').submit();
				$(this).dialog("close");
			},
			"No": function() {
				$(this).dialog("close");
				return false;
			}
		}
	});
	return false;
	});
});
</script>
<style type="text/css" media="screen">
	/*.dp_main{margin:15px 10px 15px 10px;border:1px solid #A0D7F3;background-color:#FAFDFE}
	.dp_img{float:left;margin:12px;border:1px solid #CcC;padding:2px;background-color:#FFF}
	.dp_img img{max-width:100px;max-height:120px}
	.dp_right{float:left;width:300px;margin:8px;background-color:#FFF}
	.dp_info{height:auto;border:1px solid #CcC}
	.dp_info li{list-style:none;margin:4px 2px 2px 15px}
	.dp_action{margin-top:10px;}
	.dp_action input{border:auto}
	.dp_action span{margin-left:10px}*/
	
	.modal_conatiner{padding:20px 10px;}
	.modal_conatiner ul{padding:0px;margin:0px;}
	.modal_conatiner ul li{margin:10px 5px;list-style:none;}
	.modal_left{width:65px;text-align:right;font-weight:bold;float:left}
	.modal_right{margin-left:10px;float:left;width:235px;}
	.modal_text,.modal_area{width:230px;padding:1px;border:1px solid #3E89C1}
	.modal_text{height:20px;}
	.modal_area{height:90px;}
	.modal_msg{text-align:center;border:1px solid #3E89C1;background-color:#EFF5FA;height:20px;padding:3px;color:#265679;font-weight:bold;display:none;margin-top:10px}
	.clear{clear:both}
	#dialog-form1{display:none;}
</style>
<div id="content-wrap"  class="fontNew">
  <?php	echo $this->Session->flash(); ?>
  <h1>My Courses</h1>
  <div id="tutor-wrap"> 
    
    	<?php echo $this->element('frontend/studentLeftSidebar') ?>
        
          <!--Center Column Begin Here-->
    <div class="center-col">
    
    <!--Display Profile-->
		    <div class="dp_main_cont" style="border:none;">
           
           <?php 
            echo $form->create('Member', array("url"=>array('controller'=>'members', 'action'=>'student_course'))); 
			?>
				<input type="hidden" value="<?php echo $this->Session->read('Member.memberid')?>" name="data[Member][id]" id="Memberid" style="color:#F00" />
           
            	<div class="dp_main_cont_fields">
                	<div class="dp_main_cont_Lfields">
                    Course Name:<span class="red" >*</span>
                    </div>
                    <div class="dp_main_cont_Mfields">
                    	<input type="text" name="data[StdCourse][course]" value="" id="coursetext" maxlength="25" class="alpha_num required">	
                    </div>
                    <div class="dp_main_cont_Rfields">
                    	<input type="submit"  value="Add" id="addcourse1">
                    </div>
                </div>
                
                <?php $form->end(); ?>
                
                
                <div class="dp_main_cont_fields">
                	<div class="dp_main_cont_Lfields">
                    	List of courses :
                    </div>
                    <div class="dp_main_cont_Mfields" style="margin-top:6px;">
                    <?php 
					$allCources=",";
					foreach($studentcourse as $sc)
					{
					$allCources=$allCources . $sc['StdCourse']['course'] . ","; 
					?>	
					
					
					<div style="padding-top:2px;">
					 <input type="hidden" class="hidCourse" value="<?php echo $sc['StdCourse']['id']?>" />
					<a href="<?php echo HTTP_ROOT.'members/selected_course/'.$sc['StdCourse']['course'];?>"><?php echo $sc['StdCourse']['course']; ?></a>	
					  <a align ='right' href='javascript:void(0);' class="delete delete5"><img src="<?php echo FIMAGE;?>/images4.png" alt='' title='Remove this set' style="padding-top: 2px;"/></a>
					  <br/>
					  </div>
                    <?php 
					   
					}
					?>
					<input id="allCources" type="hidden" value="<?php echo $allCources;?>" />
                    </div>
                </div>
            </div>
            
            
            
             </div>
    <!--Center Column End Here-->
		
        
    <?php  echo $this->element('frontend/studentRightSidebar'); ?>
    
    
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
				<div class="modal_left">Subject:</div>
				<div class="modal_right"><label class="StudentSubbject"></label>
					<input type="hidden" class="modal_text" id="subject" />
				</div>
				<div class="clear"><input type="hidden" id="tutor" /></div>
			</li>
			<li>
				<div class="modal_left">Message:</div>
				<div class="modal_right"><textarea class="modal_area" id="message"></textarea></div>
				<div class="clear"></div>
			</li>
			
		</ul>
	</div>
	<div class="modal_msg" title="Message Sent"></div>
</div>
<div id="dialogCancel" title="Dialog Title" style="display:none;">
	<p>Click on Yes to <span style="color:#F00" >Cancel</span> Request </p>
</div>