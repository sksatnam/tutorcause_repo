<script type="text/javascript">
$(document).ready(function(){

	<?php
	if(isset($day))
	{
	?>	
	var dy = <?php echo $day;?>;
	var mt = <?php echo $month;?>;
	var ye = <?php echo $year;?>;
	
	if (!getCookie('goTDay')){
		setCookie('goTDay',dy);
		setCookie('goTMonth',mt);
		setCookie('goTYear',ye);
	}
	<?php
	}
	?>
	 
	
/*	$("#selectrepeat option[value='weekly']").attr('selected', 'selected');
	$('.daily').hide();
	$('.weekly').show();*/

/*   $('#calendar0').datepicker({
		dateFormat: 'dd-M-yy'
	});*/
/*	$('#calendar1').datepicker({
		dateFormat: 'dd-M-yy',
		minDate: +0	
	});*/
	$('#calendar2').datepicker({
		dateFormat: 'dd-M-yy',
		minDate: +0	
	});
	$('#calendar3').datepicker({
		dateFormat: 'dd-M-yy',
		minDate: +0	
	});
	// $('#calendar5').datepicker({
		// ampm: true
	// });
	/*$('#calendar7').datepicker({
		dateFormat: 'dd-M-yy',
		minDate: +0	
	});*/
	$('#calendar8').datepicker({
		dateFormat: 'dd-M-yy',
		minDate: +0	
	});
	$('#starttime').timepicker({
		ampm: true,
		timeFormat: 'hh:mm TT'
	});
	$('#endtime').timepicker({
		ampm: true,
		timeFormat: 'hh:mm TT'
	});
	
	$('#editstarttime').timepicker({
		ampm: true,
		timeFormat: 'hh:mm TT'
	});
	$('#editendtime').timepicker({
		ampm: true,
		timeFormat: 'hh:mm TT'
	});
	
	
	
	
	$("#selectrepeat").live("change",function(){
		if($('#selectrepeat').val()=='daily'){
			$('.daily').show();
			$('.weekly').hide();
		} else {
			$('.daily').hide();
			$('.weekly').show();
		}
	});
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		var calendar = $('#calendar').fullCalendar({
												   
			/*slotMinutes: 1,*/
            disableDragging: true,
			theme: true,									   
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			
			selectable: true,
			selectHelper: true,
			
			select: function(start, end, allDay) {
			
	/*			
		$('#dialog').dialog({
        autoOpen: true,
        title:"Confirm your request",
        width: 600,
        modal:true,
        buttons: {
        "Yes": function() {
          $(this).dialog("close");
		  
	*/	  
		  
			
				var titlename = 'Available';
				var url = '<?php echo HTTP_ROOT;?>members/selectaddevent';
				
				$.ajax({
				   type: "GET",
				   url: url,
				   data: '&var1='+start+'&var2='+end+'&var3='+allDay,
				   success: function(msg){
					   
					   
					//  alert(msg);
					   
					  var sCars = msg;
					  cookiedate = sCars.split(',');
					 
				//	  alert(cookiedate[1]+" "+cookiedate[2]+" "+cookiedate[3]);

					  
						setCookie('goTDay',cookiedate[3],1);
						setCookie('goTMonth',cookiedate[2]-1,1);
						setCookie('goTYear',cookiedate[1],1);
						
						var view = calendar.fullCalendar('getView');
						setCookie('currentViewx',view.name,1);
						

						
					   
					   if(cookiedate[0] == -2 )
					   {
							alert('You can not set availability for past time.')  
					   }
					   else if(cookiedate[0] == -3 )
					   {
						   	alert('There is already an availability  here.')  
					   }
					 /*  else if(cookiedate[0] == -4 )
					   {
						   	alert('please choose time more than 30 min.')  
					   } */
					   else
					   {
						   
						 window.location.reload();
						 
						/*calendar.fullCalendar('renderEvent',
								{
									title: titlename,
									start: start,
									end: end,
									allDay: allDay,
									url: 'javascript:deleteavail('+jQuery.trim(msg)+',this);'
								},
								false 
								// make the event "stick"
								
								
							);	   */
						
					   }
					   					  
					  
					   
				
					
				   }
				 });
			
			
    /*    },
        "No": function() {
            $(this).dialog("close");
        }
		
		
        }
    });	
		
		*/
			
			calendar.fullCalendar('unselect');
			},
			
		events: [<?php 
			 foreach($tutevent as $te)
			 {
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
					url: 'javascript:deleteavail(<?php echo $te['TutEvent']['id'];?>,this);',
					<?php	
						}
					?>
				 },
				 
			<?php
				
			 } 
			 ?>],
			
			editable: true,
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) {
			
				var editurl = '<?php echo HTTP_ROOT;?>members/selecteditevent';
				
				$.ajax({
				   type: "GET",
				   url: editurl,
				   data: '&id='+event.id+'&timediff='+minuteDelta,
				   success: function(msg){
					   
					   msg = jQuery.trim(msg);
					   
					    var sCars = msg;
					  	cookiedate = sCars.split(',');
					  
						setCookie('goTDay',cookiedate[3],1);
						setCookie('goTMonth',cookiedate[2]-1,1);
						setCookie('goTYear',cookiedate[1],1);
						
						var view = calendar.fullCalendar('getView');
						setCookie('currentViewx',view.name,1);
					   
					
					   if(cookiedate[0]=='allready')
					   {
						 alert('There is already an availability  here.')  
						 revertFunc();
						 
					   }
					   else if(cookiedate[0]=='ok')
					   {
						  window.location.reload();
					   }
				   }
				 });	
			
			
			
			
			
	
			
			
			}
			
			
			
			
			
		});
		
		

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
		 
			
		$(".getdate").live("click",function(){
			var start = $(".fc-header-title h2").html();
			//$('#calendar0').val(start);
			// $('#calendar5').val(start);
		});
	
});

function changedailystime(stime)
{
	$('.dailystarttime').val(stime);
	return false;
}
function changedailyetime(etime)
{
	$('.dailyendtime').val(etime);
	return false;
}

function checkallday()
{
  if(document.getElementById('allday').checked)
  {
	  $('.alldaycheck').val('1');  
	  $('#starttime').hide();
	  $('#endtime').hide();
	  $('#secondsdate').hide();
	  $('#dayto').hide();
	  
  }
  else
  {
	 $('.alldaycheck').val('0');
	 $('#starttime').show();
	 $('#endtime').show();
	 $('#secondsdate').show();
	 $('#dayto').show();
  }
 
  return false;
}





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


function deleteavail(id)
{
	
	$('#dialogdelete').dialog({
        autoOpen: true,
        title:"Confirm your request",
        width: 600,
        modal:true,
        buttons: {
		"Delete": function() {
            $(this).dialog("close");
			
				var url = '<?php echo HTTP_ROOT;?>members/delete_event';
				
				$.ajax({
				   type: "GET",
				   url: url,
				   data: '&deleteid='+id,
				   success: function(msg){
					  // window.location.reload();

					  $('#calendar').fullCalendar('removeEvents',id);
					 


					  
					 /* var calendar = $('#calendar').fullCalendar({
																 renderView: function(15);
																 
																 });*/
					  
					  
				   }
				 });
				
				
				
				
			
			
        },
        "Copy": function() {
            $(this).dialog("close");
			
			var url = '<?php echo HTTP_ROOT;?>members/getdate_event';
			
			$.ajax({
			   type: "GET",
			   url: url,
			   data: '&eventid='+id,
			   success: function(msg){
				  // window.location.reload();
				  
				   var alldates = msg;
				   alltime = alldates.split(',');
				   
				   
				   
				   copysch(alltime[0],alltime[1],alltime[2]);
				   
					/*alert(alltime[0]+" "+alltime[1]+" "+alltime[2])
					
					return false;*/

				
				 


				  
				 /* var calendar = $('#calendar').fullCalendar({
															 renderView: function(15);
															 
															 });*/
				  
				  
			   }
			 });
			
			
			
		/*	 return false;*/

			
			
			
        },
		"Edit": function() {
            $(this).dialog("close");
			
			
			var url = '<?php echo HTTP_ROOT;?>members/getdate_event';
			
			$.ajax({
			   type: "GET",
			   url: url,
			   data: '&eventid='+id,
			   success: function(msg){
				  // window.location.reload();
				  
				   var alldates = msg;
				   alltime = alldates.split(',');
				   
				   
				   
				   editsch(alltime[0],alltime[1],alltime[2],id);
				   
					/*alert(alltime[0]+" "+alltime[1]+" "+alltime[2])
					
					return false;*/

				
				 


				  
				 /* var calendar = $('#calendar').fullCalendar({
															 renderView: function(15);
															 
															 });*/
				  
				  
			   }
			 });
			
		/*	 return false;*/
		
        }
        }
    });	
}

function cmpDate(dat1, dat2) {
    // define local variables
    var day, mSec1, mSec2;
    // number of milliseconds in one day
    day = 1000 * 60 * 60 * 24;
    // define number of milliseconds for both dates
    mSec1 = (new Date(dat1.substring(6, 10), dat1.substring(3, 5) - 1, dat1.substring(0, 2))).getTime();
    mSec2 = (new Date(dat2.substring(6, 10), dat2.substring(3, 5) - 1, dat2.substring(0, 2))).getTime();
    // return number of days between dat1 and dat2
    return Math.ceil((mSec2 - mSec1) / day);
}

function dateinnum(date1)
{
	
	var mon1;
		
	switch (date1)
		{
		case 'Jan':
		mon1 = '01';
		break;
		case 'Feb':
		mon1 = '02';
		break;
		case 'Mar':
		mon1 = '03';
		break;
		case 'Apr':
		mon1 = '04';
		break;
		case 'May':
		mon1 = '05';
		break;
		case 'Jun':
		mon1 = '06';
		break;
		case 'Jul':
		mon1 = '07';
		break;
		case 'Aug':
		mon1 = '08';
		break;
		case 'Sep':
		mon1 = '09';
		break;
		case 'Oct':
		mon1 = '10';
		break;
		case 'Nov':
		mon1 = '11';
		break;
		case 'Dec':
		mon1 = '12';
		break;
		}
		
		mon1 = mon1 - 1 ;
	
	return mon1;
	
	}
								

function editsch(sdate,stime,etime,eventid)
{
	sdate = jQuery.trim(sdate);
	
	/*sdate = jQuery.trim(sdate);
	stime = jQuery.trim(stime);
	etime = jQuery.trim(etime);*/
	
	$('.editsdate').val(sdate);
	$('#editstarttime').val(stime);
	$('#editendtime').val(etime);
	$('#hiddeneventid').val(eventid);
	
	/*$('.dailystarttime').val(stime);
	$('.dailyendtime').val(etime);*/
	
	$('#editsch').dialog({
        autoOpen: true,
        title:"Edit Schedule",
        width: 600,
        modal:true,
        buttons: {
			"Save": function() {
				
				
				var editEventUrl = '<?php echo HTTP_ROOT;?>members/editschedule';
				
				var editstarttime = document.getElementById('editstarttime').value;
				var editendtime = document.getElementById('editendtime').value;
				var hiddeneventid = document.getElementById('hiddeneventid').value;
				
				
				$.ajax({
				   type: "GET",
				   url: editEventUrl,
				   data: '&id='+hiddeneventid+'&stime='+editstarttime+'&etime='+editendtime+'&sdate='+sdate,
				   success: function(msg){
					   
					 /*  alert(msg);
					   return false;*/
					   
					   msg = jQuery.trim(msg);
					   
					   	var sCars = msg;
						cookiedate = sCars.split(',');
						
						setCookie('goTDay',cookiedate[3],1);
						setCookie('goTMonth',cookiedate[2]-1,1);
						setCookie('goTYear',cookiedate[1],1);
						
						/*var view = calendar.fullCalendar('getView');
						setCookie('currentViewx',view.name,1);*/
					   
					   
					
					   if(cookiedate[0]=='allready')
					   {
						 alert('There is already an availability here.')  
						 return false;
						 
					   }
					   else if(cookiedate[0]=='ok')
					   {
						  $(this).dialog("close"); 
						  window.location.reload();
					   }
					   else if(cookiedate[0]=='greater')
					   {
						 alert('start time should be greater than end time.')
						 return false;
						}
					   else if(cookiedate[0]=='blank')
					   {
						 alert('Please enter starttime or endtime');  
						 return false;
					   }
					   
				   }
				 });	
			
				
				
		/*		
				if(document.getElementById('editstarttime').value=='' || document.getElementById('editstarttime').value=='')
				{
					alert('Please enter starttime or endtime');
				}
				else
				{
				  document.forms["editschedule"].submit();
				}*/
				
				
				
				},
			"Cancel": function() {
				
				$(this).dialog("close");
				
			}

        }
    });	
	
	
	
	
}



function copysch(sdate,stime,etime)
{
	
	sdate = jQuery.trim(sdate);
	
	/*sdate = jQuery.trim(sdate);
	stime = jQuery.trim(stime);
	etime = jQuery.trim(etime);*/
	
	
	
	
	$('.sdate').val(sdate);
	$('#starttime').val(stime);
	$('#endtime').val(etime);
	$('.dailystarttime').val(stime);
	$('.dailyendtime').val(etime);
	
	
/*alert('jazz'+$sdate+$stime+$etime);
return false;*/
	
	
	$('#copysch').dialog({
        autoOpen: true,
        title:"Copy Schedule",
        width: 600,
        modal:true,
        buttons: {
			"Copy": function() {
				if($('#selectrepeat').val()=='daily'){
					if(document.getElementById('calendar0').value=='')
					{
						alert('Please Enter Source date');
					}
					else if(document.getElementById('radio1').checked==false && document.getElementById('radio2').checked==false)
					{
						alert('Please Select radio button');
					}
					else if(document.getElementById('radio1').checked==true)
					{
						document.getElementById('calendar3').value = '';
						if(document.getElementById('calendar2').value=='')
						{
							
						alert('Please Enter end on date');
						}
						else
						{
						
					        	var daymilli ,dat1 , dat2 , date1 , date2 , month1 , month2 , dat3 , dat4 , dat5  ; 
						
								 // number of milliseconds in one day
							    daymilli = 1000 * 60 * 60 * 24;
								
								
								dat1 = $('#calendar1').val();
								dat2 = $('#calendar2').val();
								
						//		alert(dat1+dat2);
								
								date1 = dat1.split('-');
								date2 = dat2.split('-');
								
								month1 = dateinnum(date1[1]);
								
								month2 = dateinnum(date2[1]);
								

							    dat3 =	Date.parse(date1[2]+" "+month1+" "+date1[0]);
								dat4 =  Date.parse(date2[2]+" "+month2+" "+date2[0]);
								
													
								dat5 =  Math.ceil((dat4 - dat3) / daymilli);
								
							//	alert('date5'+dat5+'date4'+dat4+'date3'+dat3+'month1'+month1+'month2'+month2);
							
								
								if(dat5 < 0 )
								{
									alert('Ends on date should be greater than Start on date');	
								}
								else
								{
								
									document.forms["copyschedule"].submit();	
								
								}
						
						
						
							
							
							
					
						}
					}
					else if(document.getElementById('radio2').checked==true)
					{
						document.getElementById('calendar1').value = '';
						document.getElementById('calendar2').value = '';
						
						if(document.getElementById('calendar3').value=='')
						{
						alert('Please Enter Specific date');
						}
						else
						{
							document.forms["copyschedule"].submit();		
						}
					}
				}
				else {
					if($('#calendar7').val()==""){
						alert('Please enter start on date');
					}
					else if ($("input[name='data[TutEvent][endsOn]']:checked").val() == 'occ') {
						if($('#occurrence').val()==""){
							alert('Please enter occurrence');
						} else if(isNaN($('#occurrence').val())){
							alert('Invalid occurance');
						}
						else {
							document.forms["copyschedule2"].submit();
						}
					}
					else  if ($("input[name='data[TutEvent][endsOn]']:checked").val() == 'on'){
						if($('#calendar8').val()==""){
							alert('Please enter end on date');
						}
						else {
							
								var daymilli ,dat1 , dat2 , date1 , date2 , month1 , month2 , dat3 , dat4 , dat5  ;
								
								 // number of milliseconds in one day
							    daymilli = 1000 * 60 * 60 * 24;
								
								
								dat1 = $('#calendar7').val();
								dat2 = $('#calendar8').val();
								
								date1 = dat1.split('-');
								date2 = dat2.split('-');
								
								month1 = dateinnum(date1[1]);
								
								month2 = dateinnum(date2[1]);
								

							    dat3 =	Date.parse(date1[2]+" "+month1+" "+date1[0]);
								dat4 =  Date.parse(date2[2]+" "+month2+" "+date2[0]);
								
								dat5 =  Math.ceil((dat4 - dat3) / daymilli);
								
							//	alert('date5'+dat5+'date4'+dat4+'date3'+dat3+'month1'+month1+'month2'+month2);
								
								if(dat5 < 0 )
								{
									alert('Ends on date should be greater than Start on date');	
								}
								else
								{
									document.forms["copyschedule2"].submit();
								
								}
							
							
						}
					}
				}
			},
			"Cancel": function() {
				
				$(this).dialog("close");
				
			}
        }
    });	
	
	}





/* ends date time picker */

	function gradient(id, level)
{
	var box = document.getElementById(id);
	box.style.opacity = level;
	box.style.MozOpacity = level;
	box.style.KhtmlOpacity = level;
	box.style.filter = "alpha(opacity=" + level * 100 + ")";
	box.style.display="block";
	return;
}


function fadein(id) 
{
	var level = 0;
	while(level <= 1)
	{
		setTimeout( "gradient('" + id + "'," + level + ")", (level* 1000) + 10);
		level += 0.01;
	}
}


// Open the lightbox


function openbox(formtitle, fadin)
{
  var box = document.getElementById('box'); 
  document.getElementById('filter').style.display='block';

  var btitle = document.getElementById('boxtitle');
  btitle.innerHTML = formtitle;
  
  if(fadin)
  {
	 gradient("box", 0);
	 fadein("box");
  }
  else
  { 	
    box.style.display='block';
  }  	
}


// Close the lightbox


function checkendon()
{
	/*$("#calendar1").addClass("required");
	$("#calendar2").addClass("required");
	$("#calendar3").removeClass("required");*/
	document.getElementById('calendar3').value = '';
}
function checkspecific()
{
	/*$("#calendar1").removeClass("required");
	$("#calendar2").removeClass("required");
	$("#calendar3").addClass("required");*/
	document.getElementById('calendar1').value = '';
	document.getElementById('calendar2').value = '';
}

</script>


<style type='text/css'>




/* calendar style */
	#calendar {
		width: 897px;
		margin: 20px auto;
		float:left;
		}
/* end calendar style */


/*google cal css */
.ep-recl-dialog-content
{
	background-color: #FFFFFF;
    color: #333333;
    padding: 15px;
	width:520px;
}
#:1g.editordialog
{
	color: #333333;	
}
.ep-rec th {
    color: #222222;
    font-weight: bold;
    padding: 5px 10px 5px 0;
    text-align: right;
    white-space: nowrap;
}
.ep-rec td {
    padding: 5px 0;
	text-align:left;
	font-size:17px;
}
.stepFormRow {
	width:100%;
	
}
.stepFormRow .textInStepFrm
{
	width:200px;
}
.row-1
{
	float:left;
	width:450px;
	margin:15px 50px;
	font-size:16px;
}
.row-1 tr
{
	float:left;
	width:450px;
	padding:5px 0;
}
.row-1 th
{
	float:left;
	width:190px;
	text-align:right;
	padding-right:15px;
}
.row-1 td
{	
	float:left;
	width:180px;
}
.row-1 fieldset
{
	float:left;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	width:462px;
/*	width:inherit; */
}
.row-1 legend
{
	text-align:left;
/*	padding-left:2px;
	float:left; */
}
.table-d_textField
{
	float:left;
	border: 1px solid #DDDDDD; font-size:18px;	
	width:180px;
}
.radio-btn
{
	margin-bottom:-33px;
}
.btn-heading
{
	float:left;
	width:278px;
}
/*end google cal css */

</style>



<div id="content-wrap">

<?php //	echo $this->Session->flash(); ?>

              <h1>Update Availability</h1>
              <div id="tutor-wrap"> 
              
               <div class="button">  
                    	<span></span>
                        <a href="<?php echo HTTP_ROOT.'members/tutor_dashboard';?>"><input type="button" value="Go to Dashboard" /></a>
               </div>  
              
              
                   <div id='calendar'></div>
     
     <div id="dialog" title="Dialog Title" style="display:none;">
            <p>Click on Yes to add Availablity for this time block </p>
</div>


<div id="dialogdelete" title="Dialog Title" style="display:none;">
            <p>Click on <span style="color:#F00" >Delete</span> to delete this time block <br /> <span style="margin-left:95px;"> OR </span> <br /> Click on <span style="color: #00F" >Copy</span> to copy this time block <br />  <span style="margin-left:95px;"> OR </span> <br /> Click on <span style="color:#83D5FD" >Edit</span> to edit this time block </p>
</div>


<div id="editsch" title="Dialog Title" style="display:none;">
    <div class="row-1" style="font-size:14px;">
            <table>
            <tr>
            <form id="editschedule" name="editschedule" action="<?php echo HTTP_ROOT.'members/editschedule'?>" enctype="multipart/form-data" method="post" >
            <td style="width:500px;">
                <input type="text" name="data[TutEvent][sdate]" value="" class="editsdate" style="width:125px;" readonly="readonly" />
                <input type="text" name="data[TutEvent][editstarttime]" value="" id="editstarttime" style="width:70px;"  /> 
                <span id="editdayto" style="padding-left:10px; padding-right:10px;">to</span>
                <input type="text" name="data[TutEvent][editendtime]" value="" id="editendtime" style="width:70px;" /> 
                <input type="text" name="edate" value="" class="editsdate" style="width:125px;" readonly="readonly"  />
                
                <input type="hidden" name="data[TutEvent][hiddeneventid]" id="hiddeneventid" value="" />
                
                
            </td>
            </form>
            </tr>
            </table>
    </div>
</div>



<div id="copysch" title="Dialog Title" style="display:none;">
	<div class="row-1" style="font-size:14px;">
		<table>
        <tr>
        <td style="width:500px;">
            <input type="text" name="sdate" value="" class="sdate" style="width:125px;" readonly="readonly" id="calendar0" />
            <input type="text" name="sdate" value="" id="starttime" style="width:70px;" onblur="changedailystime($(this).val());" /> 
            <span id="dayto" style="padding-left:10px; padding-right:10px;">to</span>
            <input type="text" name="sdate" value="" id="endtime" style="width:70px;" onblur="changedailyetime($(this).val());" /> 
            <input type="text" name="sdate" value="" class="sdate" style="width:125px;" readonly="readonly" id="secondsdate" />
        </td>
        
        </tr>
        
        <tr>
         <td><input type="checkbox" name="allday" onclick="checkallday();" id="allday"  /><span>All day</span> </td>
         </tr>
        
			<tr>
            
            
            
				<th>Repeats:</th>
				<td>
					<select name="repeat" class="selectStepFrm" style="width:211px;" id="selectrepeat">
						<option value="daily" selected>Daily</option>
						<option value="weekly">Weekly</option>
					</select>
				</td>
			</tr>
			<form id="copyschedule" name="copyschedule" action="<?php echo HTTP_ROOT.'members/copyschedule'?>" enctype="multipart/form-data" method="post" >
			<tbody class="daily">
            
            <input type="hidden" name="data[TutEvent][source_date]" class="sdate"  />
            <input type="hidden" name="data[TutEvent][form1]" value="1" >
            <input type="hidden" name="data[TutEvent][allday]" value="0" class="alldaycheck" >
            <input type="hidden" name="data[TutEvent][starttime]" class="dailystarttime" />
            <input type="hidden" name="data[TutEvent][endtime]" class="dailyendtime" />
            
            
		<!--	<tr>
				<th>Source date:</th>
				<td >
					<input class="table-d_textField required" type="text" name="data[TutEvent][source_date]" readonly id="calendar0" value="" style="width:210px;" >
					
				</td>
			</tr>-->
			<tr>
				<th><fieldset style="padding:5px; margin-left:-10px;">
					<legend>Ends</legend>
					<table>
						<!--<tr style="background:#cdeef9; -moz-border-radius:5px 5px 0 0; -webkit-border-radius:5px 5px 0 0; border-radius:5px 5px 0 0;">
							<th><div style="float:left; margin:3px 0 0 5px;" align="center"><input type="radio" name="checkend" id="radio1" checked onclick="checkendon();"  /></div>Start on:</th>
							<td >
								<input class="table-d_textField" type="hidden" name="data[TutEvent][start_date]" readonly id="calendar1" value="" >
							</td>
						</tr>
                        -->
                        
						<tr style="background:#cdeef9; -moz-border-radius:0 0 5px 5px; -webkit-border-radius:0 0 5px 5px; border-radius:0 0 5px 5px;">
                        
                        <input type="hidden" name="data[TutEvent][start_date]" readonly id="calendar1" value="" class="sdate" >
                        
							<th><div style="float:left; margin:3px 0 0 10px;" align="center"><input type="radio" name="checkend" id="radio1" checked onclick="checkendon();"  /></div>End on:</th>
							<td >
								<input type="text" class="table-d_textField"  name="data[TutEvent][end_date]" readonly id="calendar2" value="" >
							</td>
						</tr>
						<tr style="font-size: 24px; padding-left: 59px; width: 390px;;">
							<th>or</th>
						</tr>
						<tr style="background:#cdeef9; -moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px;">
							<th><input type="radio" name="checkend" id="radio2" onclick="checkspecific()" style="float:left; margin-left:5px;" /> Copy to Specific date:</th>
							<td >
								<input class="table-d_textField" type="text"  name="data[TutEvent][spe_date]" readonly id="calendar3" value=""  >
							</td>
						</tr>
					</table>
					
					</fieldset>
				</th>
			</tr>
			</tbody>
			</form>
			<form id="copyschedule2" name="copyschedule2" action="<?php echo HTTP_ROOT.'members/copyweek'?>" enctype="multipart/form-data" method="post" >
			<tbody class="weekly" style="display:none;">
            
            <input type="hidden" name="data[TutEvent][source_date]" class="sdate"  />
            <input type="hidden" name="data[TutEvent][allday]" value="0" class="alldaycheck" >
            <input type="hidden" name="data[TutEvent][starttime]" class="dailystarttime" />
            <input type="hidden" name="data[TutEvent][endtime]" class="dailyendtime" />
            
           	<input class="table-d_textField required" type="hidden" name="data[TutEvent][source_week_date]" id="calendar5" value="" style="width:100px;" readonly >
			<input class="table-d_textField required" type="hidden"  id="calendar6" value="" style="width:100px;" readonly >
            
            
            
			<!--<tr>
				<th>Source Week:</th>
				<td style="width:220px;">
					<input class="table-d_textField required" type="text" name="data[TutEvent][source_week_date]" id="calendar5" value="" style="width:100px;" readonly ><label style="float:left"> - </label> 
					<input class="table-d_textField required" type="text"  id="calendar6" value="" style="width:100px;" readonly >
					
				</td>
			</tr>-->
            
			<tr>
				<th><fieldset style="padding:5px; margin-left:-10px;">
					<legend>Ends</legend>
					<table>
						<tr style="background:#cdeef9; -moz-border-radius:5px 5px 0 0; -webkit-border-radius:5px 5px 0 0; border-radius:5px 5px 0 0;">
							<th >Repeat on:</th>
							<td style="width:240px; float:left; ">
								<span style="float:left; padding-left:5px;" >
									<input checked="checked" name="data[TutEvent][checkdate][]" value="Sun" type="checkbox">
									<label>S</label>
								</span>
								<span style="float:left; padding-left:5px;">
									<input name="data[TutEvent][checkdate][]" value="Mon"  type="checkbox">
									<label>M</label>
								</span>
								<span style="float:left; padding-left:5px;" >
									<input name="data[TutEvent][checkdate][]" value="Tue" type="checkbox">
									<label>T</label>
								</span>
								<span style="float:left; padding-left:5px;" >
									<input name="data[TutEvent][checkdate][]" value="Wed" type="checkbox">
									<label>W</label>
								</span>
								<span style="float:left; padding-left:5px;" >
									<input name="data[TutEvent][checkdate][]" value="Thu" type="checkbox">
									<label>T</label>
								</span>
								<span style="float:left; padding-left:5px;" >
									<input name="data[TutEvent][checkdate][]" value="Fri" type="checkbox">
									<label>F</label>
								</span>
								<span style="float:left; padding-left:5px;" >
									<input name="data[TutEvent][checkdate][]" value="Sat" type="checkbox">
									<label>S</label>
								</span>
							</td>
						</tr>
                        
                        <input class="table-d_textField sdate" type="hidden" name="data[TutEvent][start_week_date]" readonly  id="calendar7" value="" />
                        
					<!--	<tr style="background:#cdeef9; -moz-border-radius: 0 0; -webkit-border-radius: 0 0; border-radius: 0 0;">
							<th>Start on:</th>
							<td >
								<input class="table-d_textField sdate" type="text" name="data[TutEvent][start_week_date]" readonly  id="calendar7" value="" />
							</td>
						</tr>-->
						<tr style="background:#cdeef9; -moz-border-radius:0 0 5px 5px; -webkit-border-radius:0 0 5px 5px; border-radius:0 0 5px 5px;">
							<th><div style="float:left; margin:3px 0 0 10px;" align="center">&nbsp;</div>Ends:</th>
							<td style="text-align:left;" >
								<div style="clear:both">
									<input type="radio" name="data[TutEvent][endsOn]" value="on" checked />
									<label>On
										<input type="text" class="table-d_textField"  name="data[TutEvent][end_week_date]" id="calendar8" value="" readonly style="width:132px;float:none;" />
									</label>
								</div>
                                
                                
                                <input type="hidden" name="data[TutEvent][endsOn]" value="occ" />
                                
                                <input type="hidden" class="table-d_textField"  name="data[TutEvent][occur]"  id="occurrence" value="5" style="width:30px;float:none;" size="2" /> 
                                
                                
								<!--<div style="clear:both; width:200px; margin:5px 0;">
									<input type="radio" name="data[TutEvent][endsOn]" value="occ" />
									<label>After 
										<input type="text" class="table-d_textField"  name="data[TutEvent][occur]"  id="occurrence" value="5" style="width:30px;float:none;" size="2" /> occurrences
									</label>
								</div>-->
							</td>
						</tr>
					</table>
					
					</fieldset>
				</th>
			</tr>
			</tbody>
			</form>
		<!--	<tr>
				<th>Summery:</th>
				<th >
					Lorem Ipsum Lorem Ipsum Lorem Ipsum
				</th>
			</tr>-->
		</table>
	</div>
</div>    
              
              
              
              
              
        
  			  </div>
</div>





