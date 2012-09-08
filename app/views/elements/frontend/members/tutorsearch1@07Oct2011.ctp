<div class="searchTutors">	<!--searchTutors-->
	<h1 style="color:#58b9e9;"> Tutors at <?php echo $schoolname; ?> </h1>
		<div class="tutorSearchResult-outer"
            <?php
            if(count($filtertutor1))
            {
            ?>
            style="border-bottom:none";
            <?php
            }
            ?> >	<!--tutorSearchResult-outer-->
            <?php
			$i = 1;
            foreach($filtertutor1 as $ft)
            {
				
			/*	
			if($i>5)
			{
				break;
			}
				
			
			 if(count($ft['TutCourse'])==0 || count($ft['TutEvent'])==0)
			 {
				  continue;
			 }
			 
			 
			 $i = $i + 1;
			 */
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
                        <div class="tutorSearchResult-name-disc2">
                        	<!--tutorSearchResult-name-disc2-->
                            <?php
						   $findname = $ft['userMeta']['fname'].' '.$ft['userMeta']['lname'];
						   $urlName=str_replace(' ','-',$findname);
  						   $urlName=str_replace('_','-',$urlName);
						   $urlName=$urlName . '_' . $ft['Member']['id'];
						   
						   ?>
                            <label class="tutorurl"><?php echo $html->link($findname, array('controller'=>'members', 'action'=>'tutor', $urlName), array('title' => $ft['Member']['fname'] )); ?></label>
                        </div>	<!--tutorSearchResult-name-disc2-->
                    </div>	<!--tutorSearchResult-name-->
                  
                    <div class="tutorSearchResult-name">	<!--tutorSearchResult-name-->
                        <div class="tutorSearchResult-name-disc1">	<!--tutorSearchResult-name-disc1-->
                            <label>Availability:</label>
                        </div>	<!--tutorSearchResult-name-disc1-->
                       <?php
					   if(count($ft['TutEvent']))
					   {
						?>   
						   <div class="tutorSearchResult-name-disc2">	<!--tutorSearchResult-name-disc2-->
                            <label><span style="color:#096;"><b>Active and Available</b></span> (<a href="<?php echo HTTP_ROOT.'Members/tutoravail/'.$ft['Member']['id'];?>" style="color:#339;">see availability</a>)</label>
                            
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
							if(count($ft['TutCourse']))
								{
								foreach($ft['TutCourse'] as $memtutcourse )
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
                   <?php 
                    /*<div class="tutorSearchResult-name">	<!--tutorSearchResult-name-->
                        <div class="tutorSearchResult-name-disc1">	<!--tutorSearchResult-name-disc1-->
                            <label>About me:</label>
                        </div>	<!--tutorSearchResult-name-disc1-->
                        <div class="tutorSearchResult-name-disc2">	<!--tutorSearchResult-name-disc2-->
                            <label>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</label>
                        </div>	<!--tutorSearchResult-name-disc2-->
                    </div>*/  ?>	<!--tutorSearchResult-name-->
                </div>	<!--tutorSearchResult-nameAndDisc-->
                <div class="tutorSearchResult-personalInfo">	<!--tutorSearchResult-personalInfo-->
                	<ul>
						<?php if($ft['userMeta']['fb_allow']==1) { ?>
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
								echo $html->image("frontend/mutual_friends.jpg",array('style'=>'width:20px;height:20px;'));
							?>
							</div>
							<div class="searchResultCenter">
								<!--<a href="<?php //echo HTTP_ROOT.'Members/facebookmutual/'.$ft['Member']['facebookId']; ?>">View Mutual Friends</a>-->
								<a href="javascript:void(0)" class="click2showMutual" rel="<?php echo $ft['Member']['facebookId']; ?>">View Mutual Friends</a>
							</div>
							<div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
						</li>
						<li style="padding-left:5px;width:240px;">
							<div class="searchResultLeft">
							<?php
								echo $html->image("frontend/lock.png",array('style'=>'width:20px;height:20px;'));
							?>
							</div>
							<div class="searchResultCenter">
								<a href="<?php echo HTTP_ROOT.'Members/book_tutor_course/'.$ft['Member']['id']; ?>">Book Now</a>
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
								<input type="hidden" class="resultName" value="<?php echo $ft['userMeta']['fname'].' '.$ft['userMeta']['lname'];?>" />
							</div>
							<div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
						</li>
                    </ul>
                </div>	<!--tutorSearchResult-personalInfo-->
            </div>
            <?php
            }
			if(count($filtertutor1)==0)
			{
				echo 'No Record Found';
			}
	?>
<!--tutorSearchResult-personalInfo-->
<?php                
if(count($filtertutor1)) {
 ?>
	<!-- pagination starts -->
	<div class="paging" id="users-paging-view" style="width:50%; float:left;">
		
		<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
		<?php echo $paginator->numbers(array('separator' => false));?>
		<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
		
	</div>
	<div class="pagingtotalpages" ><a><?php echo $paginator->counter(array('format' => '<b>Currently showing</b> %start%-%end%, <b>Total Pages</b> = %pages%, <b>Total results</b> = %count%'));?> </a></div>	
	<!-- pagination ends -->
	<?php 
}
	 ?>
	</div>	<!--tutorSearchResult-->
</div><!--tutorSearchResult-outer-->