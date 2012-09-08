
   <div class="searchTutors">	<!--searchTutors-->
        	<h1 style="color:#58b9e9;"> Search Results </h1>
        	<div class="tutorSearchResult-outer"
            <?php
            if(count($filtertutor))
            {
            ?>
            style="border-bottom:none";
            <?php
            }
            ?> >	<!--tutorSearchResult-outer-->
            <?php
            foreach($filtertutor as $ft)
            {	
			?>	
            
            <div class="tutorSearchResult">	<!--tutorSearchResult-->
            	<div class="tutorSearchResult-img">	<!--tutorSearchResult-img-->
               <?php
               if($ft['Member']['facebookId'])
               {
				   $fbimage = 'https://graph.facebook.com/'.$ft['Member']['facebookId'].'/picture';
				   echo  $this->Html->image($fbimage);
			   }
               else
               {
                   echo  $this->Html->image('frontend/user_img.png', array('height'=> '50px', 'width' => '50px') );
               }
			   ?>
                
               
                </div>	<!--tutorSearchResult-img-->
                <div class="tutorSearchResult-nameAndDisc">	<!--tutorSearchResult-nameAndDisc-->
                    <div class="tutorSearchResult-name">	<!--tutorSearchResult-name-->
                        <div class="tutorSearchResult-name-disc1">	<!--tutorSearchResult-name-disc1-->
                            <label>Name:</label>
                        </div>	<!--tutorSearchResult-name-disc1-->
                        <div class="tutorSearchResult-name-disc2">	<!--tutorSearchResult-name-disc2-->
                         <?php
						   $findname = $ft['userMeta']['fname'].' '.$ft['userMeta']['lname'];
						   $urlName=str_replace(' ','-',$findname);
  						   $urlName=str_replace('_','-',$urlName);
						   $urlName=$urlName . '_' . $ft['Member']['id'];
						   
						   ?>
                            <label class="tutorurl"><?php echo $html->link($findname, array('controller'=>'members', 'action'=>'tutor', $urlName), array('title' => $ft['Member']['fname'])); ?></label>
                        </div>	<!--tutorSearchResult-name-disc2-->
                    </div>	<!--tutorSearchResult-name-->
                    
                    
                    
                    <div class="tutorSearchResult-name">	<!--tutorSearchResult-name-->
                        <div class="tutorSearchResult-name-disc1">	<!--tutorSearchResult-name-disc1-->
                            <label>Availability:</label>
                        </div>	<!--tutorSearchResult-name-disc1-->
                       <?php
					   if(count($ft['Member']['TutEvent']))
					   {
						?>   
						   <div class="tutorSearchResult-name-disc2">	<!--tutorSearchResult-name-disc2-->
                            <label><span style="color:#096;"><b>Active and Available</b></span></label>
                        </div>	<!--tutorSearchResult-name-disc2-->
						   
						<?php   
						}
						else
						{
						?>	
                        
                        <div class="tutorSearchResult-name-disc2">	<!--tutorSearchResult-name-disc2-->
                            <label style="color:#F00">N/A</label>
                        </div>	<!--tutorSearchResult-name-disc2-->
                        
							
						<?php	
						}
					  	?>
                       
                       
                       
                        
                    </div>	<!--tutorSearchResult-name-->
                    
                    <div class="tutorSearchResult-name">	<!--tutorSearchResult-name-->
                        <div class="tutorSearchResult-name-disc1">	<!--tutorSearchResult-name-disc1-->
                            <label>Courses($Price):</label>
                        </div>	<!--tutorSearchResult-name-disc1-->
                        <div class="tutorSearchResult-name-disc2">	<!--tutorSearchResult-name-disc2-->
                            <label><?php
							if(count($ft['Member']['TutCourse']))
								{
								foreach($ft['Member']['TutCourse'] as $memtutcourse )
									{
										echo $memtutcourse['course_id'].'<b>($ '.$memtutcourse['rate'].' / Hour)</b>'.', ';
									}
								}
							else
							{
							?>	
                            <div class="tutorSearchResult-name-disc2">	<!--tutorSearchResult-name-disc2-->
                            <label style="color:#F00">N/A</label>
                            </div>	<!--tutorSearchResult-name-disc2-->
							<?php 	
							}
							?></label>
                        </div>	<!--tutorSearchResult-name-disc2-->
                    </div>	<!--tutorSearchResult-name-->
                    
                    
                </div>	<!--tutorSearchResult-nameAndDisc-->
                <div class="tutorSearchResult-personalInfo">	<!--tutorSearchResult-personalInfo-->
                	<ul>
						<?php if($ft['Member']['userMeta']['fb_allow']==1) { ?>
						<li style="padding-left:5px;width:240px;">
							<div class="searchResultLeft">
							<?php
								echo $html->image("frontend/facebook_20_20_icon.jpg",array('style'=>'width:20px;height:20px;'));
							?>
							</div>
							<div class="searchResultCenter">
								<a href="http://www.facebook.com/profile.php?id=<?php echo $ft['Member']['facebookId']; ?>">View Facebook Profile</a>
							</div>
							<div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
						</li>
						<?php } ?>
						<li style="padding-left:5px;width:240px;">
							<div class="searchResultLeft">
							<?php
								echo $html->image("frontend/lock.png",array('style'=>'width:20px;height:20px;'));
							?>
							</div>
							<div class="searchResultCenter">
								<a href="<?php echo HTTP_ROOT.'members/save_request/'.$ft['Member']['id']; ?>">Send Request to tutor</a>
							</div>
							<div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
						</li>
						<li style="padding-left:5px;width:240px;">
							<div class="searchResultLeft">
							<?php
								echo $html->image("frontend/send_message.png",array('style'=>'width:18px;height:18px;'));
							?>
							</div>
							<div class="searchResultCenter">
								<a class="sendMessage" href="#" onclick="return false;">Send Message</a>
								<input type="hidden" class="resultId" value="<?php echo $ft['Member']['id'];?>" />
								<input type="hidden" class="resultName" value="<?php echo $ft['Member']['userMeta']['fname'].' '.$ft['Member']['userMeta']['lname'];?>" />
							</div>
							<div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
						</li>
                    </ul>
                </div>	<!--tutorSearchResult-personalInfo-->
                </div>
            <?php
            }
			if(count($filtertutor)==0)
			{
			?>
				<p style=" font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 15px; margin-left:20px; text-align:center;"><b>No Record Found</b></p>
				
			<?php
			}
		    ?>
            	<!--tutorSearchResult-personalInfo-->
                
            
                
                         	
            </div>	<!--tutorSearchResult-->
            
               
              
            
            
            
            
            </div>	<!--tutorSearchResult-outer-->