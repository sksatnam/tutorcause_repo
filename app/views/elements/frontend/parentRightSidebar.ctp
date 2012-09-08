<div class="right-sidebar">
              <h2>Quick Links</h2>
              <ul>
                <li><a href="<?php echo HTTP_ROOT.'members/messages';?>">Inbox
                  <div class="notification">
					<?php if($countMsg>0)
                    {
                    ?>	
                    <span><?php echo $countMsg;?></span>
                    <?php	
                    }
                    else
                    {
                    echo '0';
                    }
                    ?>
                  </div>
                  </a></li>
                <li><a href="<?php echo HTTP_ROOT.'members/student_pending_request';?>">Pending Requests
                  <div class="notification"><?php echo $studentrequest;?></div>
                  </a></li>
                <li><a href="<?php echo HTTP_ROOT.'members/add_student';?>">Add Student</a></li>
                <li><a href="<?php echo HTTP_ROOT.'members/remove_student';?>">Remove Student </a></li>
                <li><a href="<?php echo HTTP_ROOT.'members/view_session_all';?>">View All Sessions</a></li>
              </ul>
</div>
<?php //3aug2012 ?>