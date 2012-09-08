<?php


	function ctime($timezone)
		{
			
			$date = new DateTime();
			$date->setTimezone(new DateTimeZone($timezone));
		//	return $date->getTimestamp(); 			
		//	return $date->format('U'); 			
			return $date->format('Y-m-d H:i:s'); 
			
		}



	
	    function nicetime($date)
        {
            if(empty($date)) {
                return "No date provided";
            }
           
            $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
            $lengths         = array("60","60","24","7","4.35","12","10");
			
			$timezone = $_SESSION['Member']['timezone'];
			
			$currenttime = ctime($timezone);
			
			/*echo $currenttime;
			die;*/
			
			$now = strtotime($currenttime);
			
		/*	echo $now;
			die;
			
			
			
			echo 'warcraft'.date('Y-m-d H:i:s',$now).'date'.$date.'timezone'.$timezone;
			
			die;*/
			
		/*	echo $now;
			die;
	*/
			
        //	$now = time();
			
            $unix_date = strtotime($date);
           
               // check validity of date
            if(empty($unix_date)) {   
                return "Bad date";
            }
        
            // is it future date or past date
            if($now > $unix_date) {   
                $difference     = $now - $unix_date;
                $tense         = "ago";
               
            } else {
                $difference     = $unix_date - $now;
                $tense         = "from now";
            }
           
            for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
                $difference /= $lengths[$j];
            }
           
            $difference = round($difference);
           
            if($difference != 1) {
                $periods[$j].= "s";
            }
           
            return "$difference $periods[$j] {$tense}";
        }
        
        /*$date = "2009-03-04 17:45";
        $result = nicetime($date);*/ // 2 days ago
        
        ?>


<?php 
/*foreach($upcomingclass as $uc)
{
	echo $uc['PaymentHistory']['booked_course'].'<br>';
	echo $uc['PaymentHistory']['booked_start_time'].'<br>';
	echo $uc['tutor']['id'].'<br>';
	echo 'duration'.$uc['PaymentHistory']['tutoring_hours'].'<br>';
	echo 'Price'.$uc['PaymentHistory']['amount'].'<br>';
	echo $this->Html->link('Launch Class',array('controller' => 'classes', 'action' => 'live',$uc['PaymentHistory']['id'] ));
}
*/
/*echo '<pre>';
print_r($upcomingclass);
echo '</pre>';*/

?>



     <div class="classesOuter">
     
     <?php
	 if(!empty($upcomingclass))
	 {
		 
		 $n = 0;
		 foreach($upcomingclass as $result)
		 {
			 $n = $n+1;
			 
		 ?> 	 
				<div class="<?php if($n%2==0){ echo 'oddBox';}?> classesInner">
					<div class="classesInnerLeft">
						<!--<a href="#">-->
						<?php
						
						if($this->Session->read('Member.group_id')==7)
						{
						
							if($result['student']['showImage'])
							{
								if(!empty($result['student']['image_name'])){
									echo $html->image("members/thumb/".$result['student']['image_name'],array('class'=>'profile-img-thumb'));
								} else {
									?><img src="https://graph.facebook.com/<?php echo $result['student']['facebookId']; ?>/picture?type=large" class="profile-img-thumb"   />
								<?php }
							}
							else
							{
								echo $html->image("profile-photo.png",array('class'=>'profile-img-thumb'));
							}
						
						}
						else if($this->Session->read('Member.group_id')==8)
						{
							if($result['tutor']['showImage'])
							{
								if(!empty($result['tutor']['image_name'])){
									echo $html->image("members/thumb/".$result['tutor']['image_name'],array('class'=>'profile-img-thumb'));
								} else {
									?><img src="https://graph.facebook.com/<?php echo $result['tutor']['facebookId']; ?>/picture?type=large" class="profile-img-thumb"  />
								<?php }
							}
							else
							{
								echo $html->image("profile-photo.png",array('class'=>'profile-img-thumb'));
							}
						}
						
						
						
						
						$paymentId = base64_encode(convert_uuencode($result['PaymentHistory']['id']));
						
						$startclass = $result[0]['booked_start_time'];
						$endclass = $result[0]['booked_end_time'];
						
						/*echo $startclass;
						die;*/
						
						
						$currentdate = date('Y-m-d H:i:s');
						
						$ts = strtotime($startclass);
						$check_start = $ts - strtotime($currentdate);
						
						$es = strtotime($endclass);
						$check_end = $es - strtotime($currentdate);
						
						?>
						<!--</a>-->
					</div>
					<div class="classesInnerMiddle">
					
						<div class="classPersonName">
                       
						<?php
						if($this->Session->read('Member.group_id')==7)
						{
							$studentname = $result['student']['fname'].' '.$result['student']['lname'];
							echo  "<span style=\"float:left; color:#1E96CB\">$studentname</span>";
						}
						else if($this->Session->read('Member.group_id')==8)
						{
							$tutorname = $result['tutor']['fname'].' '.$result['tutor']['lname'];
							$urltutor=str_replace(' ','-',$tutorname);
							$urltutor=str_replace('_','-',$urltutor);
							$urltutor=$urltutor . '_' . $result['tutor']['id'];
							echo $html->link($tutorname ,array('controller'=>'members', 'action'=>'tutor', $urltutor), array('title' => $result['tutor']['fname']));
						}
						if($check_start < 0 && $check_end > 0)
						{
						   echo '<label>Live</label>';
						}
						?>
						</div>
						
						<div class="classdate"><?php echo date('l, F d, Y g:i A ',strtotime($startclass));?><!--Friday, January 06, 2012 7:31 PM--></div>
						<div class="classStartTime"><?php 
						$startin = nicetime($startclass);
						echo $startin;
						?><!--(Starts in 7 hours 47 minutes)--></div>
						
						<div class="classPresentOutr">
						    <?php
							if($this->Session->read('Member.group_id')==7)
							{
								if(!empty($result['student']['facebookId']))
								{
							?>
                            <div class="classPresentleft">Facebook Profile :</div>
							<div class="classPresentRgt">                            
                            <a href="http://facebook.com/profile.php?id=<?php echo $result['student']['facebookId'];?>"><?php echo $result['student']['fname']."&nbsp;&nbsp;".$result['student']['lname'];?></a>
                            </div>
                            <?php
								}
							}
							else if($this->Session->read('Member.group_id')==8)
							{
								if(!empty($result['tutor']['facebookId']))
								{
							?>
                            <div class="classPresentleft">Facebook Profile :</div>
							<div class="classPresentRgt">                          
                            <a href="http://facebook.com/profile.php?id=<?php echo $result['tutor']['facebookId'];?>"><?php echo $result['tutor']['fname']."&nbsp;&nbsp;".$result['tutor']['lname'];?></a>	
                            </div>	
							<?php
								}
							}
							?>
                            
                        </div>
                        
                        
						<div class="classPresentOutr">
							<div class="classPresentleft">Course :</div>
							<div class="classPresentRgt"><span><?php echo $result['PaymentHistory']['booked_course'];?></span></div>
						</div>
						<div class="classPresentOutr">
							<div class="classPresentleft">Price :</div>
							<div class="classPresentRgt"> $ </b><?php echo $result['PaymentHistory']['amount'];?></div>
						</div>
						<div class="classPresentOutr">
							<div class="classPresentleft">Duration :</div>
							<div class="classPresentRgt">
							
							<?php 
							
							$duration = (strtotime($endclass) - strtotime($startclass))/60;
							
							echo $duration.' minutes';
							
							/*	if($second>60)
							{
								echo date('h hours i minutes',$second);	
							}
							else
							{
								echo date('i minutes',$second).'minutes';
							}
							*/
							
							?>
							</div>
						</div>
						
					</div>
					<div class="classMiddleRgt">
						<div class="classMiddleRgtLnk">
							<b><?php echo $html->link('Launch Class',array('controller'=>'classes','action'=>'live',$paymentId),array('title'=>'Launch Class'))?>
							<!--<a href="#">Launch Class</a>-->
							</b>
						</div>
					</div>
				</div>
				
			   <?php     
			   }
			   
		?>	   
              <!-- pagination starts -->
                   <div class="paging" id="users-paging-view">
                        <?php // echo $paginator->first();?>
                        <?php // echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>
                        
                        <?php echo $paginator->prev(' '.__('Prev Page', true), array(), null, array('class'=>'disabled'));?> 
                        <?php //  echo $paginator->numbers(array('separator' => false));?>
                        
                        <span style="float:left; margin-right: 2px; padding: 3px 4px;">|</span>
                            
                        <?php // echo $paginator->(array('separator' => '|'));?>
                        <?php echo $paginator->next(__('Next Page', true).' ', array(), null, array('class' => 'disabled'));?>
                        <?php // echo $paginator->last();?>
                    </div>
              <!-- pagination ends --> 	   
       <?php
	   }
	   else
	   {
		?>   
        <div class="classesInner">
				You don&#39;t have any online tutoring session scheduled, 
                <a style="color:#1D5894;text-decoration:underline;" title="Fand a Tutor" href="<?php echo HTTP_ROOT.'members/tutorsearch';?>">Book a Session</a> today.
		</div>
       <?php     
	   }
	   ?>
           
           
            
            
           
            
            <?php /*?><div class=" oddBox classesInner">
            	<div class="classesInnerLeft">
                	<a href="#"><?php echo $html->image("frontend/pic-6.jpg")?></a>
                </div>
                <div class="classesInnerMiddle">
                	<div class="classPersonName"><a href="#">Person name</a></div>
                    <div class="classdate">Friday, January 06, 2012 7:31 PM</div>
                    <div class="classStartTime">(Starts in 7 hours 47 minutes)</div>
                    <div class="classPresentOutr">
                    	<div class="classPresentleft">Presented By :</div>
                        <div class="classPresentRgt"><a href="#">Lorem Ipsum</a></div>
                    </div>
                    <div class="classPresentOutr">
                    	<div class="classPresentleft">Type :</div>
                        <div class="classPresentRgt"><span>Public</span></div>
                    </div>
                    <div class="classPresentOutr">
                    	<div class="classPresentleft">Price :</div>
                        <div class="classPresentRgt">Free</div>
                    </div>
                    <div class="classPresentOutr">
                    	<div class="classPresentleft">Duration :</div>
                        <div class="classPresentRgt">45 minutes</div>
                    </div>
                    <div class="classPresentOutr">
                    	<div class="classPresentleft">Registrations :</div>
                        <div class="classPresentRgt">5 Learners</div>
                    </div>
                </div>
                <div class="classMiddleRgt">
                	<div class="classMiddleRgtLnk">
                    	<a href="#">Unregister</a>
                    </div>
                    <div class="classMiddleRgtLnk">
                    	<b><a href="#">Launch Class</a></b>
                    </div>
                </div>
            </div><?php */?>
            
            
        </div> <!--classesOuter-->
        
        
        
       
	