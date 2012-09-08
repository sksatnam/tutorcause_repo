<?php

/*echo '<pre>';
print_r($causeResult);
die;
*/


?>



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
						   
						   
	var calendar = $('#calendar').fullCalendar({
    	
		theme: true,									   
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek'
		},
		editable: false,
		events: [<?php 
		foreach($tutevent as $te){
		?>
			{
				id: '<?php echo $te['TutEvent']['id'];?>' ,
				title: '' ,
				start: '<?php echo $te['TutEvent']['start_date'];?>',
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
					?>
			},
		<?php
		} 
		?>]
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



</script>





<?php
if($countMsg>0){
	$countMsg = $countMsg;
} else {
	$countMsg = "";
}
?>


<div id="content-wrap" class="fontNew">

<?php	echo $this->Session->flash(); ?>

    <h1>Your Dashboard</h1>
    <div id="tutor-wrap"> 
      
      <?php  echo $this->element('frontend/tutorLeftSidebar'); ?>
      
      <!--Center Column Begin Here-->
      <div class="center-col">
        <div class="center-row">
          <div class="center-content">
            <div id="messages">
              <div class="center-heading">
                <h2>You have
                <?php if($countMsg)
				{
				?>	
				<span><?php echo $countMsg;?></span>
                <?php	
				}
				else
				{
				echo 'no';
				}
				?> messages in your inbox</h2>
                <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/messages';?>">Go to inbox</a></div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="center-row">
          <div class="center-content">
            <div id="notices">
              <div class="center-heading">
                <h2>Notice Board</h2>
                <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/notices';?>">View all notices</a></div>
              </div>
              
				<?php
                foreach($tutornotice as $tn)
					{
					?>
                        <div class="notice"> <span><?php echo $tn['Notice']['notice_head'];?></span>
                        <p><?php echo $tn['Notice']['notice_text'];?></p>
                        </div>
					<?php
					}
                ?>
             
              
              
            </div>
          </div>
        </div>
        
        
        
        <div class="center-row2">
          <div class="center-content" style="width:400px;">
            <div id="notices">
              <div class="center-heading" style="margin-left:17px;">
                <h2>Weekly Schedule</h2>
                <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/calendar/'.$this->Session->read('Member.memberid');?>">Update Availability</a></div>
              </div>
               <div class="notice" style="width:400px;">
               <div id="calendar"></div>
               </div>
      
				
             
              
              
            </div>
          </div>
        </div>
        
        
      </div>
      <!--Center Column End Here--> 
      
	  <?php echo $this->element('frontend/tutorRightSidebar');?>
      
    </div>
  </div>