<?php //3aug2012 ?><style type="text/css">
	/*.links li span {
	background: none repeat scroll 0 0 transparent !important;
    color: #646464 !important;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 13px !important;
    height: auto !important;
    line-height: 30px !important;
    padding: 0 !important;
    text-decoration: none;
	}*/
	
</style>

<!--Right Sidebar Begin Here-->
	<div class="right-sidebar">
  <h2>My Sessions</h2>
  <ul>
    <li><a href="<?php echo HTTP_ROOT.'members/session_request';?>">Pending Requests<div class="notification"><?php echo $SessionRequest;?></div></a></li>
    <li><a href="<?php echo HTTP_ROOT.'members/tutor_awaiting_payment';?>">Awaiting Payment<div class="notification"><?php echo $paymentAwaiting;?></div></a></li>
    <li><a href="<?php echo HTTP_ROOT.'members/tutor_upcoming_session';?>">Upcoming Session<div class="notification"><?php echo $upcomingRequest;?></div></a></li>
    <li><a href="<?php echo HTTP_ROOT.'members/tutor_review_session';?>">Awaiting Review<div class="notification"><?php echo $sessionReview;?></div></a></li>
    <li><a href="<?php echo HTTP_ROOT.'members/tutor_completed_session';?>">View Completed</a></li>
    
    <li><a href="<?php echo HTTP_ROOT.'members/calendar/'.$this->Session->read('Member.memberid');?>">Update Availability</a></li>
  </ul>
  
  <!--<ul class="tutor-sessions">
    <li><a href="#">Update Availability</a></li>
    <li><a href="#">My Courses</a></li>
  </ul>-->
  
  <div class="tutor-sessions">
    <div class="container2">
      <h2 class="acc_trigger2"><a href="#">My Courses</a></h2>
      <div class="acc_container2" style="display: block;">
        <div class="block">
          <ul class="links">
          <?php 
		  $i = 0;
		  $countCourse = count($tutorCourse);
		  foreach($tutorCourse as $gbt)
		  {
		  $i++;	  
			  
		  ?>
            <li
            <?php 
			if($i==$countCourse)
			{
			echo  "class=\"last\"";	
			}
			?>
            ><span><?php echo $gbt['TutCourse']['course_id']?></span></li>
           <!-- <li class="last"><a href="#">Courses Comes Here</a></li>-->
          <?php
		  }
		  if(count($tutorCourse)==0)
		  {
		  ?> 	  
			<li class="last"><span>No Courses</span></li>
          <?php    
		  }
		  ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Right Sidebar End Here--> 




     
