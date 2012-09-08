
<?php

if(count($min_wage))
	{
		$min_price = $min_wage[0]['Wage']['min_wage'];
		$max_price = $min_wage[0]['Wage']['max_wage'];
		if($min_wage[0]['Wage']['zero_allowed'])
		{
			$max_valid = "cmax=\"$max_price\" cmin=\"$min_price\"";
		}
		else
		{
			$max_valid = "max=\"$max_price\" min=\"$min_price\"";
		}
	}
	

 $universalCounter="0";?>			
<script>

$(document).ready( function(){
							
			
			
		/*	$('.only_course').each(function(){
											   var v = jQuery.trim($(this).val());
											    	//alert(v);
									  		 mycourse.push(v);
									 });*/				
							
				
			$('input[type=text]:last').live('keydown',function(e){ 
					// tab key was press up
					if(e.which==9)
					{
						$('#add_more').click();
					}
															 
					
			});				
			
				
$('.only_course').live("blur",function(){
									   
	var thiscourse = $(this);  								   
	var myInput = jQuery.trim($(this).val());
		
//	alert(myInput);
	
	var schoolId = $('#hidSchool').val();
			$.ajax({
			   type: "POST",
			   url: ajax_url+"/members/checkrepeatcourse",
			   data: "&courseId="+myInput+"&schoolId="+schoolId,
			   success: function(msg){
				   
					  if(msg==0)
					  {
						thiscourse.val('');  
					  }
					  
					  var course = [];
					  var filtercourse = [];
					  var blurcourse = [];
					  
					  $('.only_course').each(function(){
					   var v = jQuery.trim($(this).val());
					   //alert(v);
					   course.push(v);
					  });	
					  
						for (i=0;i<course.length;i++)
						{
							var k=course[i];
							if(k!='')
							{
							  filtercourse.push(k);
							}
						}
					
						var cnt = 0;		
							
						for(var i in filtercourse) {
						if(filtercourse[i] == myInput)
							{
								cnt = cnt+1;
							}
						} 	
					  
					  if(cnt>=2)
					  {
						 
						 thiscourse.val('');  
						 
					//	 alert('count'+filtercourse.length+'cnt'+cnt+'this'+myInput+'allcourse'+filtercourse);	
					  }
			
					  return false;
				   
				 
			 }
			 });
			
	return false;
	
/*	var finalList="#";

	$('.ac_results ul li').each(function(index){
					finalList = finalList + jQuery.trim($(this).text())+ '#';							  
	});
	
	if(finalList.indexOf('#'+myInput+'#')<0){
		$(this).val('');
	}
*/	


});							
							
							
$('.delete').live("click",function() {
								   	$(this).parent('td').parent('tr').remove();
								   });



							
 $("#TutCourseSchoolinfoForm").validate();	
 
 
 					$('.ausu-suggest').find('input[type=text]').autocomplete(ajax_url+"/members/getautocourse/"+$('#schoolname').val(),{
						delay:10,
						minChars:1,
						matchSubset:1,
						matchContains:1,
						cacheLength:0,
						autoFill:true
					});
 
 
 
 
 	 
		/*	var i=3;	
			
			i = 4;*/
			
			
			$('#add_more').live("click",function() {							  
				//alert('addmore');

				if($("#content table tr").last().children().last().children().is('a')) {
					//alert('last');

					var clone = $("#content table tr").last().clone(); // clone the last <tr>
					
					var input = clone.children('td').children('div').children('input');
					var input2 = clone.children('td').children('input');
					
					var rel = input.attr('rel')*1+1;
					input.attr('id','ad'+rel);
					input.attr('rel',rel);


					input2.attr('id','rt'+rel);

					$(clone).appendTo($("#content table"));
					$(clone).find('td a').click(function(){
						$(this).parent('td').parent('tr').remove();
					});
					clone.find('input[type=text]').val('');
					clone.find('span[class=error]').remove();
					
																					  
					clone.find('.ausu-suggest').find('input[type=text]').autocomplete(ajax_url+"/members/getautocourse/"+$('#schoolname').val(),{
						delay:10,
						minChars:1,
						matchSubset:1,
						matchContains:1,
						cacheLength:0,
						autoFill:true
					});
					
					
					
				/*	clone.find('.ausu-suggest').find('input[type=text]').autosugguest({
						className: 'ausu-suggest',
						methodType: 'POST',
						minChars: 1,
						rtnIDs: true,
					    // live:true,
						dataFile: ajax_url+"/members/getautocourse/"+$('#schoolname').val()
						// dataFile: 'data.php'
									
					});  */
					
					/*clone.find('select option:selected').removeAttr('selected');
					clone.find('select option:selected').removeProp('selected');*/
	
				}else{
					//alert('fisrt');
				var clone = $("#content table tr").last().clone();
					
										
					var img = $("<a align ='right' style='color:#D83F4A;  href='javascript:void(0);'><img src='"+ajax_url+"/app/webroot/img/frontend/delete_icon1.png'  title='Remove this set' style='margin-top:5px'/></a>");
					//$(clone).find('td:first').html('');
					$(clone).find('td').first().append(img);
					
					var input = clone.children('td').children('div').children('input');
					var rel = input.attr('rel')*1+1;
					input.attr('id','ad'+rel);
					input.attr('rel',rel);
					
					var input2 = clone.children('td').children('input');
					
					input2.attr('id','rt'+rel);
					
					
					$(clone).find('td a').click(function(){
						$(this).parent('td').parent('tr').remove();
					});
					
					$(clone).appendTo($("#content table"));
					
					clone.find('input[type=text]').val('');
					clone.find('span[class=error]').remove();
					
					clone.find('.ausu-suggest').find('input[type=text]').autocomplete(ajax_url+"/members/getautocourse/"+$('#schoolname').val(),{
						delay:10,
						minChars:1,
						matchSubset:1,
						matchContains:1,
						cacheLength:0,
						autoFill:true
					});
					
					
					
					/*clone.find('.ausu-suggest').find('input[type=text]').autosugguest({
							className: 'ausu-suggest',
							methodType: 'POST',
							minChars: 1,
							rtnIDs: true,
							// live:true,
							dataFile: ajax_url+"/members/getautocourse/"+$('#schoolname').val()
							// dataFile: 'data.php'
					});*/
					
				/*	clone.find('select option:selected').removeAttr('selected');
					clone.find('select option:selected').removeProp('selected');
				*/	
					
					clone.find('span').remove();
					clone.find('span').remove();
					clone.find('span').remove();
					clone.find('span').remove();
					clone.find('span').remove();
				}
			
		});
			
			
			
		$('.deleteRow').click(function(){
			var thisRow = $(this);
			var courseId = $(this).parent().find('.hidCourse').val();
			var schoolId = $('#hidSchool').val();
			$.ajax({
			   type: "POST",
			   url: ajax_url+"/members/deletecourse",
			   data: "&courseId="+courseId+"&schoolId="+schoolId,
			   success: function(msg){
				   if(msg==1){
					   thisRow.parent().remove();
				   } else {
					   alert(msg);
				   }
			 }
			 });
		});
			
	});

	

</script>



<style>

/* div				{margin: 10px; font-family: Arial, Helvetica, sans-serif; font-size:12px; }*/

	.ausu-suggestionsBox{z-index:12;}

	.ausu-suggest	{width: 280px;}
    #wrapper 		{margin-left: auto; position: relative; margin-right: auto; margin-top:75px ;width:  600px;}
    h3 				{font-size: 11px; text-align: center;}
/*	span 			{font-size: 11px; font-weight: bold}*/

	a:link			{color: #F06;text-decoration: none;}
	a:visited 		{text-decoration: none;color: #F06;}
	a:hover 		{text-decoration: underline;color: #09F;}
	a:active		{text-decoration: none;color: #09F;}
	
	span.req{
	display:inline;
	float:none;
	color:red !important;
	font-weight:bold;
	margin:0;
	font-size:
	padding:0;
	font-size:14px !important;
}

.stepFormRow label{
	width:155px;
	}

	
</style>

<div id="content-wrap" >
            	
                <?php  echo $this->Session->flash();?>
               
                    <h1>Edit Courses</h1>
                    
           
           <div id="tutor-wrap">      
             
           <?php
	//	   echo "<pre>";
//		 print_r($_SESSION);
		  
		   echo $form->create('TutCourse',array('url'=>array('controller'=>'members','action'=>'addcourse', $tutcources[0]['TutCourse']['id']),'id'=>'TutCourseSchoolinfoForm')); ?>   
               
                <div class="stepForm">
             <!--   <div align="center"> <div align="center" class="successmessage" id="flashmsg" style=" font-size:14px;color:#E92003; background:#EFEFEF; height:18px; width:350px;">
				
				
                
                </div>   -->
                
                
                </div>
                	<div class="stepFormRow">
                    
                    <input type="hidden" name="data[TutCourse][school_id]" id="schoolname" value="<?php echo $memberdata['Member']['school_id'];?>" >
                        <label style="margin-left:3px;">School Name:<span class="red" ><b>*</b></span></label>
                        <select class="selectStepFrm required" name="data[TutCourse][school_id]" id="schoolname1" disabled>
                        <option value="">Select School</option>
                        <?php
						foreach ($schools as $school ) {
						?>
                        <option value="<?php echo $school['School']['id']; ?>" 
							<?php
							  if($tutcources){
									  if($tutcources[0]['TutCourse']['school_id']==$school['School']['id']){
										echo "selected='selected'";
									}
								}
							  else if($memberdata['Member']['school_id']==$school['School']['id'])
							  {
								 echo "selected='selected'";
							  }	
							?>
                            
                            >
                       <?php echo $school['School']['school_name']; ?></option>
                        <?php  
						}
						?>
                        </select>
                        <input type="hidden" id="hidSchool" value="<?php echo ($tutcources[0]['TutCourse']['school_id'])?$tutcources[0]['TutCourse']['school_id']:$memberdata['Member']['school_id']; ?>" />
                        
                    </div>
             
                	<div id="addCourseOt" style="float:left; width:auto">
                       
                       
                       <?php if(count($tutcources)>0){
					
						?>   
						   <div class="stepFormRow" id="content">
                                  <table>
                                  <?php  $m=0;  foreach($tutcources as $tutcource){?>
                                  <tr>
                                  <td>
                                  
                                    <label>Add Course:<span class="red" ><b>*</b></span></label>
                                   
                                    <div class="ausu-suggest">
              							<input type="text" size="25" value="<?php echo $tutcource['TutCourse']['course_id']?>" name="data[TutCourse][course_id][]" id="ad<?php echo $m;?>" rel="<?php echo $m;?>" class="valids alpha_num only_course required" autocomplete="off" style="z-index:10;" />
                                        <input type="hidden" class="hidCourse" value="<?php echo $tutcource['TutCourse']['course_id']?>" />
            
           							</div>
                                    <label class="AddCorLabel">Rate Per Hour:<span class="red" ><b>*</b></span></label>
                                    
										<?php 
                                        $tutorcourse1 = $tutcource['TutCourse']['rate'];
                                        ?>
                                        <input class="textInStepFrm AddCorInput required number  valids " <?php echo $max_valid;?> value="<?php printf("%.2f",  $tutorcourse1);?>" type="text" id="rt<?php echo $m;?>" name="data[TutCourse][rate][]"  />
                                        
                                         <input type="hidden" class="hidRate" value="<?php echo $tutcource['TutCourse']['rate']?>" />
                                 	
                                <?php if($m>0){?>
                                
                                      <a align ='right' style='color:#D83F4A;' href='javascript:void(0);' class="delete"><img src="<?php echo FIMAGE;?>/delete_icon1.png" alt='' title='Remove this set' style="margin-top:5px" /></a>                                    <?php }?>
                                      
                               </td>
                                 </tr>
                                 <?php $m++;} ?>
                                 </table>
                                 
                                 
                                <div class="stepFormContButton button" style="margin-left:305px;">
                                <span></span>
                                <input type="submit" value="Submit" /> 
                                </div> 
                                
                                <div class="stepFormContButton button">  
                                <span></span>
                                <input type="button" value="Add more.." class="button" id="add_more" style="outline:none;" /> 
                                </div>  
                                
                                 </div>
						   
					   <?php 
					   }
					   
					   else{
					   ?>
                       
                     <div class="stepFormRow" id="content">
                                  <table>
                                 <tr>
                                  <td>
                                  
                                    <label>Add Course:<span class="red" ><b>*</b></span></label>
                                   
                                    <div class="ausu-suggest">
              							<input type="text" size="25" value="" name="data[TutCourse][course_id][]" rel="<?php echo $universalCounter;?>"
                                        id="ad<?php echo $universalCounter;?>" class="valids alpha_num only_course required" autocomplete="off" style="z-index:10;"/>
                                        <input type="hidden" class="hidCourse" value="" />
                                    
           							</div>
                                    <label class="AddCorLabel">Rate Per Hour:<span class="red" ><b>*</b></span></label>
                                    <?php 
                                    $tutorcourse1 = $tutcource['TutCourse']['rate'];
									?>
                                    <input class="textInStepFrm AddCorInput required number  valids " <?php echo $max_valid;?> value="<?php printf("%.2f",  $tutorcourse1);?>"  id="rt<?php echo $universalCounter;$universalCounter++;?>" type="text" name="data[TutCourse][rate][]"  />
                                     <input type="hidden" class="hidRate" value="" />
                                 
                                
                                      
                                       <?php if($universalCounter>1){?>
                                
                                      <a align ='right' style='color:#D83F4A;' href='javascript:void(0);' class="delete"><img src="<?php echo FIMAGE;?>/delete_icon1.png" alt='' title='Remove this set' style="margin-top:5px" /></a>
									  <?php }?>
                                      
                                      
                                                                       
                               </td>
                                 </tr>
                            </table>
                            
                                <div class="stepFormContButton button" style="margin-left:305px;">
                                <span></span>
                                <input type="submit" value="Submit" /> 
                                </div> 
                                
                                <div class="stepFormContButton button">  
                                <span></span>
                                <input type="button" value="Add more.." class="button" id="add_more" style="outline:none;" /> 
                                </div>  
                                
                                  
                                </div>
                     
                    <?php }?> 
          
                   </div> 
        
           
           <?php echo $form->end();?>
      
            </div>                   
            
 </div>   
            