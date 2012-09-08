  <!--Right Sidebar Begin Here-->
    <div class="right-sidebar">
      <h2>My Sessions</h2>
      <ul>
        <li><a href="<?php echo HTTP_ROOT.'members/student_awaiting_approval'; ?>">Pending Requests
          <div class="notification"><?php echo $awaitingRequest; ?></div>
          </a></li>
        <li><a href="<?php echo HTTP_ROOT.'members/student_awaiting_payment'; ?>">Awaiting Payment
          <div class="notification"><?php echo $paymentRequest; ?></div>
          </a></li>
        <li><a href="<?php echo HTTP_ROOT.'members/student_upcoming_session'; ?>">Upcoming Session
          <div class="notification"><?php echo $upcomingRequest; ?></div>
          </a></li>
        <li><a href="<?php echo HTTP_ROOT.'members/student_review_session'; ?>">Awaiting Review  
          <div class="notification"><?php echo $reviewRequest;?></div>
          </a></li>
        <li><a href="<?php echo HTTP_ROOT.'members/student_completed_session'; ?>">View Completed</a></li>
      </ul>
    </div>
    <!--Right Sidebar End Here--> 