
<?php
/*echo '<pre>';
print_r($parentResult);
die;*/

?>




 <div id="content-wrap">
 
 <?php	echo $this->Session->flash(); ?>
 
              <h1>View All Session</h1>
              <div id="tutor-wrap"> 
                
                <!--Left Sidebar Begin Here-->
                <?php  echo $this->element('frontend/parentLeftSidebar'); ?>
                <!--Left Sidebar End Here--> 
                
                <!--Center Column Begin Here-->
                <div class="center-col">
    
    	<!--Display Profile-->
			<?php foreach($paymentAwaiting as $result){?>
			<div class="dp_main">
				<div class="dp_img">
					<?php
					if($result['tutor']['showImage'])
					{
							$countImg = count($result['tutor']['UserImage'])-1;
							if(count($result['tutor']['UserImage'])){
								echo $html->image("members/thumb/".$result['tutor']['UserImage'][$countImg]['image_name']);
							} else {
								?><img src="https://graph.facebook.com/<?php echo $result['tutor']['facebookId']; ?>/picture?type=large"  />
							<?php }
					}
					else
					{
						echo $html->image("profile-photo.png");
					}	
					?>
				</div>
				<div class="dp_right">
					<div style="padding:2px;margin:0px 2px;font-weight:bold;font-size:14px">
					<?php 
					 $tutorname = $result['tutor']['userMeta']['fname'].' '.$result['tutor']['userMeta']['lname'];
                                $urltutor=str_replace(' ','-',$tutorname);
                                $urltutor=str_replace('_','-',$urltutor);
                                $urltutor=$urltutor . '_' . $result['tutor']['id'];
								
								 
							?>
								 <?php echo $html->link($tutorname ,array('controller'=>'members', 'action'=>'tutor', $urltutor), array('title' => $result['tutor']['userMeta']['fname'] ,'style'=>'color:#1D5894'));?>  
					</div>
					<div class="dp_info">
						<ul>
							<li></li>
							<li><a href="http://facebook.com/profile.php?id=<?php echo $result['tutor']['facebookId'];?>" target="_blank">Facebook Profile</a></li>
							<li><b>Location:</b> <?php echo $result['tutor']['userMeta']['city'];?> , <?php echo $result['tutor']['userMeta']['state'];?></li>
							<li><b>Course:</b> <?php echo $result['PaymentHistory']['booked_course'];?></li>
                            
                             <li><b>Hourly Rate:</b> $ </b><?php echo $result['PaymentHistory']['tutor_rate_per_hour'];?></li>
                            <?php
							$nettime = $result['PaymentHistory']['tutoring_hours'];
							$netrate = $result['PaymentHistory']['tutor_rate_per_hour']; 
                            $netprice = $nettime * $netrate;
							?>
                            <li><b>Total Session Cost:</b> $ <?php printf("%.2f", $netprice ); ?></li>
                            
                            
						<li><b>Time:</b><label > <?php echo date('F j, Y @ h:i A',strtotime($result['PaymentHistory']['booked_start_time']));?><br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>to</b> <?php echo date('F j, Y @ h:i A',strtotime($result['PaymentHistory']['booked_end_time']));?></label></li>
						</ul>
					</div>
              
              
                <div class="student-btns">
                
                    
                   <form accept-charset="utf-8" action="<?php echo HTTP_ROOTS.'members/pay_session_student';?>" method="post" id="form1">
                    
                    
                    <div class="dp_action">
                    <input type="hidden" name="data[PaymentHistory][id]"  value="<?php echo $result['PaymentHistory']['id'];?>" />
                    <input type="hidden" name="data[PaymentHistory][amount]"  value="<?php echo $netprice;?>" />
                    <input type="submit" value="Pay Session" class="session-btn" />
                    </div>
                    
                    </form>
                
                </div>
                    
	</div>
				<div style="clear:both"></div>
			</div>
			<?php }
			if(count($paymentAwaiting)==0)
			{
			?>
				<p style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px;padding-top: 5px; padding-left: 5px; text-align:center;"><b>No Record Found</b></p>
			<?php
			}
			?>
            
           
    </div>
                <!--Center Column End Here--> 
                
                <!--Right Sidebar Begin Here-->
                <?php  echo $this->element('frontend/parentRightSidebar'); ?>
                <!--Right Sidebar End Here--> 
                
              </div>
</div>
 

 
 