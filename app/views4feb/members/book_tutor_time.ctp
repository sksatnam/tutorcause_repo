<?php
/*echo '<pre>';
print_r($_SESSION);
die;
*/?>

<script type="text/javascript">
$(document).ready(function(){
						   
	<?php
	if(count($tutevent))
	{
	?>	
	var dy = <?php echo $day;?>;
	var mt = <?php echo $month;?>;
	var ye = <?php echo $year;?>;
	setCookie('goTDay',dy);
	setCookie('goTMonth',mt);
	setCookie('goTYear',ye);
	<?php
	}
	?>
	
						   
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	
	var calendar = $('#calendar').fullCalendar({
    	
		theme: true,									   
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		editable: false,
		events: [<?php 
		foreach($tutevent as $te){
		?>
			{
				id: '<?php echo $te['TutEvent']['id'];?>' ,
				title: '<?php echo $te['TutEvent']['title'];?>' ,
				start: '<?php echo $te['TutEvent']['start_date'];?>',
				end: '<?php echo $te['TutEvent']['end_date'];?>',
				allDay: false,
				<?php 
					if($te['TutEvent']['title']=='Booked')
					{
					?>	
						backgroundColor: '#6D7B8D',
						borderColor: '#6D7B8D',
						editable: false,
					<?php	
					}
					else
					{
					?>
					url: 'javascript:fetchtutorhours(<?php echo $te['TutEvent']['id']?>)',
					<?php	
						}
					?>
					
			},
		<?php
		} 
		?>]
	});
	
	
/*	var view = calendar.fullCalendar('getView');
	setCookie('currentViewx',view.name,1);		*/
	
	
		 if (getCookie('goTYear')!=null && getCookie('goTYear')!=""){
			// alert('one');
			$("#calendar").fullCalendar('gotoDate',getCookie('goTYear'),getCookie('goTMonth'),getCookie('goTDay'));
						 setCookie('goTDay',"",-1);
						setCookie('goTMonth',"",-1);
						setCookie('goTYear',"",-1);
						
		 }
		 if (getCookie('currentViewx')!=null && getCookie('currentViewx')!=""){
			// alert('two');
				$('#calendar').fullCalendar('changeView',getCookie('currentViewx'));

						setCookie('currentViewx',"",-1);
		 }
		
	courserate();
	
});

function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name)
	{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
		{
			return unescape(y);
		}
	}
}


function fetchtutorhours(id)
{
	//	alert(id);
	
	
	
	if(id)
	{
		var url = '<?php echo HTTP_ROOT;?>members/fetch_tutor_hours';
		$.ajax({
			type: "GET",
			url: url,
			data: '&id='+id,
			success: function(resp){
				$('#startfrom').html(resp);
				$('#endto').html(resp);
				$('#dialogtime').dialog({
					autoOpen: true,
					title:"Book a Tutor",
					width: 600,
					modal:true,
					buttons: {
						"Book Tutor": function() {
							    
								var startfrom = document.getElementById('startfrom').value;
								var endto = document.getElementById('endto').value;
								
								var courserate = document.getElementById('coursecode').value;
								coursearray = courserate.split('_');
								
								var start=new Date(startfrom);
								var end=new Date(endto);
								var diff=end.getTime() - start.getTime();
								
								var hours = diff/3600000;
							//	alert(hours);
								
								if(hours < 0)
								{
								  alert('End time should be greater than start time.');
								}
								else if(hours == 0)
								{
								  alert('start time and end time could not be same.');
								}
								else if(!document.session.understand.checked)
								{
								   alert('Please click on check box.');	
								}
								else
								{
									
									var startfrom = document.getElementById('startfrom').value;
									var endto = document.getElementById('endto').value;
									
									var url = '<?php echo HTTP_ROOT;?>members/selecttutortime';
									$.ajax({
										type: "GET",
										url: url,
										data: '&tuteventid='+id+'&starttime='+startfrom+'&end='+endto+'&courseid='+coursearray[0],
										success: function(msg){
											
											$(this).dialog("close");	
											var sendurl = '<?php echo HTTP_ROOT;?>members/send_session_request';
											window.location = sendurl;
											
											// window.location.reload();
										}
									});
								}
							//    $(this).dialog("close");
						},
						"Return to Schedule": function() {
							$(this).dialog("close");
						}
					}
				});
			}
		});
	}


}


function testdate()
{
	
		var rate = document.getElementById('courseratehidden').value;
		
		var startfrom = document.getElementById('startfrom').value;
		var endto = document.getElementById('endto').value;
		
		var start=new Date(startfrom);
		var end=new Date(endto);
		var diff=end.getTime() - start.getTime();
		
		var hours = diff/3600000;
		
		var sessionmoney = rate * hours;
		
		var duration = hours+' Hours';
		var total = ' $ '+sessionmoney;
		
	//	alert(hours);
	
		if(rate == '')
		{
			alert('please choose course.')
			return false;
		}
		if(hours > 0)
		{
			document.getElementById('duration').innerHTML = duration;
			document.getElementById('total').innerHTML = total;
		}
		else
		{
			document.getElementById('duration').innerHTML = '';
			document.getElementById('total').innerHTML = '';
		}
		return false;
	
}

function courserate()
{
	var courserate = document.getElementById('coursecode').value;
	
	coursearray = courserate.split('_');
	
//	alert(coursearray);
	
	document.getElementById('courserate').innerHTML = coursearray[1];
	
	document.getElementById('courseratehidden').value = coursearray[1];
	
	testdate();
	
	
	
}
</script>
<style type='text/css'>
#calendar {
	width: 900px;
	margin: 0 auto;
}
</style>
<div id="content" style="padding-bottom:25px; padding-top:25px;">
<div class="stepsHeadingNew">
                    
                        <div class="newProgressBarOuter">
                        	<div class="proBarsSection2">
                            	<span class="spanNo">1</span>
                                <span class="spanOnHover">Schedule Session</span>
                            </div>
                            <div class="proBarsSection3">
                            	<span class="spanNo">2</span>
                                <span class="spanOnHover">Confirm Request</span>
                            </div>
                             <div class="proBarsSection3">
                            	<span class="spanNo">3</span>
                              <span class="spanOnHover">Pay for Session</span>
                            </div>
                        </div>
                    <h1>Schedule Session</h1>
                </div>
                   
                 
               <h1 style="text-align:center;">Availablity</h1>
			<br />
     <div id='calendar'></div>
<div id="dialogtime" title="Dialog Title" style="display:none;">
            <p>Select the duration of your tutoring session below</p>
            <div class="row-1" style="font-size:14px;">
		<table cellspacing="20">
			<tr>
				<th align="left">Start Time:</th>
				<td>
				 <select name="startfrom" class="selectStepFrm" style="width:245px;" id="startfrom" onchange="testdate();" >
				 
				 </select>
				</td>
			</tr>
			<tr>
				<th align="left">End Time:</th>
				<td>
				  <select name="endto" class="selectStepFrm" style="width:245px;" id="endto" onchange="testdate();" >
					  
				  </select>
				</td>
			</tr>
            <tr>
				<th align="left">Course Code:</th>
				<th align="left" >
                 <select name="coursecode" class="selectStepFrm" style="width:245px;" id="coursecode" onchange="courserate();" >
                 <?php 
					foreach($tutorcourse as $tc)
					{
						if($defaultCourse==$tc['TutCourse']['course_id'])
						{
						?>
                                            <option value="<?php echo $tc['TutCourse']['id'].'_'.$tc['TutCourse']['rate'];?>" selected="selected"><?php echo $tc['TutCourse']['course_id'];?></option>
                     	<?php	
						}
						else
						{
						?>	
                                        <option value="<?php echo $tc['TutCourse']['id'].'_'.$tc['TutCourse']['rate'];?>" ><?php echo $tc['TutCourse']['course_id'];?></option>
						<?php	
						}
					
					}
					?>
				  </select>
				</th>
			</tr>
            
            <tr>
				<th align="left">Hourly Rate:</th>
				<th align="left">
				  	$ <span id="courserate"></span>
                    <input type="hidden" name="courseratehidden" id="courseratehidden" value="" />
				</th>
			</tr>
            
            <tr>
				<th align="left">Session Length:</th>
				<th align="left" id="duration" >
				
				</th>
			</tr>
            <tr>
				<th align="left">Total Session Cost:</th>
				<th align="left" id="total" >
				
				</th>
			</tr>
            
          
            
            
		</table>
        
        <form name="session">

        <table>
          <tr>
          	<td style="padding-left:17px;"><input type="checkbox" name="understand" id="understand" /><span style="padding-left:5px;">I understand that my credit card will be charged by TutorCause once the tutor accepts the session if my account balance will not cover the amount.</span></td>
				</th>
			</tr>
        </table>
        </form>
        
        
        
        
        
	</div>           
</div>   
</div>