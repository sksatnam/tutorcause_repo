<?php

/*echo '<pre>';
print_r($filtertutor1);
print_r($watchtutor);
die;*/

?>

					<div id="tutor-content"> 	<!--Left Sidebar Begin Here-->
                    
                    <div id="tutor-left">
                        <ul>
                        <?php
						if(count($filtertutor1))
						{
							
						$i = 1; 	
						foreach($filtertutor1 as $ft)
						{
						?>
                        <li>
                        
                        <div class="searching <?php if($watchtutor['Member']['id'] == $ft['Member']['id']){ echo "current";}else if($i == 1 && count($watchtutor)==0 ){ echo "current";}?>" onclick="JavaScript:showtutor('<?php echo $ft['Member']['id'];?>');" >
                                <div class="profile-wrap">
                                <div class="profile-pic">
								<?php   
								if($ft['Member']['showImage'])
			   					{
									$lastImg = count($ft['UserImage']) - 1;
								
									if(count($ft['UserImage'])){
									echo $html->image("members/thumb/".$ft['UserImage'][$lastImg]['image_name'],array('height'=> '58px', 'width' => '57px'));
									} 
									else {
									$fbimage = 'https://graph.facebook.com/'.$ft['Member']['facebookId'].'/picture?type=large';	
									echo  $this->Html->image($fbimage , array('height'=> '58px', 'width' => '57px') );
									}
		
                             /*   if($ft['Member']['facebookId'])
									{
									$fbimage = 'https://graph.facebook.com/'.$ft['Member']['facebookId'].'/picture';
									echo  $this->Html->image($fbimage , array('height'=> '58px', 'width' => '57px') );
									}
                                else
									{
									echo  $this->Html->image('frontend/user_img.png', array('height'=> '58px', 'width' => '57px') );
									}*/
									
								}
								else
								{
									echo $html->image("profile-photo.png",array('height'=> '57px', 'width' => '58px'));
								}
                                ?>
								</div>
                                <div class="profile-info">
                                <div class="name-price">
                                  <h4> <?php
						   $findname = $ft['userMeta']['fname'].' '.$ft['userMeta']['lname'];
						   $urlName=str_replace(' ','-',$findname);
  						   $urlName=str_replace('_','-',$urlName);
						   $urlName=$urlName . '_' . $ft['Member']['id'];
						   echo $ft['userMeta']['fname']; 
						   ?></h4>
                                  <div class="cost">
									<?php 
                                     $requesturl = '/members/tutor_search_avgcourse/'.$ft['Member']['id'];
                                     $request = $this->requestAction($requesturl);
                                     echo '$'.$request['avg'].'/hr';
                                    ?>
                                  </div>
                                </div>
                                <div class="review">
                                  <div class="feedabck-cate">Ability:</div>
                                 
                                  <div class="feedabck">
                                  <?php
								  $ablity = $request['abl'];
								  if($ablity)
								  {
									  for($i=1;$i<=$ablity;$i++)
									  {
									   ?>	  
										<img src="<?php echo FIMAGE;?>yellow-star.png" />  
                                       <?php 
									  }
								  }
								  else
								  {
								  ?>	
                                  <span style="margin-left:37px;">N/A</span>   
                                   <?php   
									}
								  ?> 
								</div>
                                  </div>
                                <div class="review">
                                  <div class="feedabck-cate">Knowledge:</div>
                                  <div class="feedabck">
                                   <?php
								  $know = $request['know'];
								  if($know)
								  {
									  for($i=1;$i<=$know;$i++)
									  {
									   ?>	  
										<img src="<?php echo FIMAGE;?>yellow-star.png" />  
                                       <?php 
									  }
								  }
								 else
								  {
								  ?>	
                                  <span style="margin-left:37px;">N/A</span>   
                                   <?php   
									}
								  ?> 
                                  </div>
                                </div>
                                </div>
                                </div>
                               </div>
                                
                                
                        </li>
                    		
						<?php	
						
						$i++;
						
						}	
						}
						?>
                                                
							
                            
                       
                        </ul>
                        
                        
                        
                        
                        
<!-- pagination starts -->
<?php
if(count($filtertutor1))                        
{
?>
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
<?php
}
?>
                        
                        
                    </div>
                  
                  <!--Left Sidebar End Here--> 
                  
                 
                                <!--Center Column Begin Here-->
                                <div id="tutor-center">
                                
	                                <div id="profile-detail">
                                <div id="profile-pic" style="border:none;">
                                
                                <div style="text-align:center;">
                                <?php  
								if($watchtutor['Member']['showImage'])
			   					{
									
									
									$watchlastImg = count($watchtutor['UserImage']) - 1;
								
									if(count($watchtutor['UserImage'])){
									echo $html->image("members/".$watchtutor['UserImage'][$watchlastImg]['image_name'],array('height'=> '278px', 'width' => '367px'));
									} else {
									$fbimage = 'https://graph.facebook.com/'.$watchtutor['Member']['facebookId'].'/picture?type=large';
									?>
                                    <img src="<?php echo $fbimage ?>" style="height:278px; max-width:367px;"  />
									<?php        
									}
									
									
									
									
							/*		
									
									if($watchtutor['Member']['facebookId'])
									{
									$fbimage = 'https://graph.facebook.com/'.$watchtutor['Member']['facebookId'].'/picture?type=large';
									?>
									<img src="<?php echo $fbimage ?>" style="height:278px; max-width:367px;"  />
									<?php
									}
									else
									{
									echo  $this->Html->image('frontend/user_img.png', array('height'=> '278px', 'width' => '367px') );
									}
									*/
									
								}
								else
								{
									echo $html->image("profile-photo.png",array('height'=> '278px', 'width' => '367px'));
								}
                                ?>
                                </div>
                                
                                
                                </div>
                                
                                
                                <h2><?php
                                $tutorname = $watchtutor['userMeta']['fname'].' '.$watchtutor['userMeta']['lname'];
                                $urltutor=str_replace(' ','-',$tutorname);
                                $urltutor=str_replace('_','-',$urltutor);
                                $urltutor=$urltutor . '_' . $watchtutor['Member']['id'];
                                echo $html->link($tutorname ,array('controller'=>'members', 'action'=>'tutor', $urltutor), array('title' => $watchtutor['userMeta']['fname'] ,'style'=>'color:#1D5894;text-decoration:underline;'));?></h2>
                                <h3><?php echo $watchtutor['School']['school_name']?></h3>
                               
								<?php 
								if(trim($watchtutor['userMeta']['biography']))
								{
								?>
									<div><a class="view" href="JavaScript:myfunc();"></a></div>
								<?php
								
								}
								else
								{
								?>
								<!--<div><a class="view" href="javascript:void(0)"></a></div>-->
								<?php
								}
								?>
								<div style="clear:both"></div>
								<div id="biography" style="display:none; text-align:justify;">
								<p><?php echo $watchtutor['userMeta']['biography'];?></p>  
                                </div>
							 
                                <?php // echo $html->link('', array('controller'=>'members', 'action'=>'tutor', $urltutor), array('title' => $watchtutor['Member']['fname'],'class'=>'view' ));?>   
                                
                                
                                </div>
                                
                                </div>
                                <!--Center Column End Here--> 
                                
                                <!--Right Sidebar Begin Here-->
                                <div id="tutor-right">
                                <div id="price-wrap">
                                <div id="price">
                                <h3><?php echo $tutorname;?></h3>
                                <h5>Price - 
                                <?php 
             				    /*$requesturl = '/members/tutor_search_avgcourse/'.$watchtutor['Member']['id'];
                                $request = $this->requestAction($requesturl);*/
								echo '$'.$average.'/hour';
								?>
                                </h5>
                                <a href="<?php echo HTTP_ROOT."members/book_tutor_time/".$watchtutor['Member']['id'];?>" class="book-now"></a> 
                                </div>
                                </div>
                                
                                
                                <?php if($watchtutor['Member']['facebookId'])
								{
                                ?>
                                <a href="http://www.facebook.com/profile.php?id=<?php echo $watchtutor['Member']['facebookId']; ?>" class="fb-profile"><p>View Facebook Profile</p></a>
                                <?php
								}
								?>
                                
                                <?php
								$memberFacebook = $this->Session->read('Member.facebook_id');
								
								if($watchtutor['Member']['facebookId']!='' && $memberFacebook!='')
								{
								?>	
                                <a href="javascript:void(0)" class="fb-mutual click2showMutual" rel="<?php echo $watchtutor['Member']['facebookId']; ?>"><p>View Mutual Friends 
                                <?php 
             				    $mutualurl = '/members/countfacebookmutual1/'.$watchtutor['Member']['facebookId'];
                               /* $countmutual = $this->requestAction($mutualurl);
								echo '('.$countmutual.')';*/
								}
								?>
                                </p>&nbsp;</a>
                                <a href="#" class="send-btn sendMessage" onclick="return false;">&nbsp;</a>
                               
								<input type="hidden" class="resultId" value="<?php echo $watchtutor['Member']['id'];?>" />
								<input type="hidden" class="resultName" value="<?php echo $watchtutor['userMeta']['fname'].' '.$watchtutor['userMeta']['lname'];?>" />
                                
                                
                                <div id="courses-wrap">
                                <h3>Other Courses</h3>
                                <div id="courses-table">
                                <table width="100%" border="1" cellpadding="0" cellspacing="0" class="table_class">
                                <tr class="table_head">
                                <td>Courses</td>
                                <td>Price</td>
                                </tr>
                                <?php
								$j = 1;
								foreach($watchtutor['TutCourse'] as $tc)
								{
								?>
                                <tr 
                                <?php if($j%2==0)
								{
								?>	
								id="gray"
                                <?php	
								}
								else
								{
								?>	
								id="white"
								<?php	
								}
                                ?>>
                                <td><?php echo $tc['course_id'];?></td>
                                <td><?php echo '$'.$tc['rate'];?></td>
                                </tr>
								<?php	
								$j++;
								}
								?>
                                </table>
                                </div>
                                </div>
                                </div>
                                <!--Right Sidebar End Here-->
                                
                         
                        
                        
                        
                        
					
                  
                  
                  
                  
                </div>

