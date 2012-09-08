<script type="text/javascript">
$(document).ready(function(){
	
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
					 foreach($tutevent as $te)
					 {
					?>	
						 {
							id: '<?php echo $te['TutEvent']['id'];?>' ,
							title: '<?php echo $te['TutEvent']['title'];?>' ,
							start: '<?php echo $te['TutEvent']['start_date'];?>',
							end: '<?php echo $te['TutEvent']['end_date'];?>',
							allDay: false
						
						 },
						 
					<?php
						
					 } 
					 ?>]
		});
	
});


</script>


<style type='text/css'>
/* calendar style */

	#calendar {
		width: 900px;
		margin: 0 auto;
		}
/* end calendar style */

</style>

<div id="content" style="padding-bottom:25px; padding-top:25px;">

<div class="stepFormContButton button">  
<span></span>
<a href="<?php echo HTTP_ROOT.'members/tutorsearch';?>"><input type="button" value="Back to Search Results" /></a>
</div>
     <br />
     <br />
     <br />
     <br />
     
      
                            
                 
               <h1 style="text-align:center;">Availablity</h1> 
                <br />
            
     <div id='calendar'></div>


    
</div>