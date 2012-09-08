<?php 
/*echo '<pre>';
print_r($dynamictext);
die;
*/

?>

<div id="content">
            	<div class="home3BoxCont">
                <?php
				
                if($this->action == "index"){	
					?>
                	<div class="home3Box home3BoxSpace">
                    	<h3>Join as Tutor</h3>
                        <div class="home3Boxdefault">
                            <div class="home3BoxImg"><img src="<?php echo FIMAGE;?>cause.png" alt="Join As Tutor" width="158" height="170" /></div>
                            <div class="home3BoxTitle"><?php echo $dynamictext[4]['Page']['body'];?></div>
                            <div class="joinUsBtnGrey"><a href="javascript:void(0);"><img src="<?php echo FIMAGE;?>join_us_grey_btn.png" alt="Join As Tutor" width="150" height="40" /></a></div>
                        </div>
                        <div class="home3BoxOver">
                        	
                            <div class="home3BoxOverDesc">
                            	<?php echo $dynamictext[0]['Page']['body'];?> 
                            </div>
                            <div class="joinUsBtnCont"><a href="<?php echo $facebookURL; ?>"><img src="<?php echo FIMAGE;?>join_us_btn.png" width="150" alt="Join As Tutor" height="40" /></a></div>
                        </div>
                    </div>
                    <div class="home3Box home3BoxSpace">
                    	<h3>Join as Student</h3>
                        <div class="home3Boxdefault">
                            <div class="home3BoxImg"><img src="<?php echo FIMAGE;?>student_sec.png" alt="Join As Student" width="170" height="170" /></div>
                            <div class="home3BoxTitle"><?php echo $dynamictext[5]['Page']['body'];?></div>
                            <div class="joinUsBtnGrey"><a href="javascript:void(0);"><img src="<?php echo FIMAGE;?>join_us_grey_btn.png" width="150" height="40" alt="Join As Student" /></a></div>
                        </div>
                        <div class="home3BoxOver">
                            <div class="home3BoxOverDesc">
                            	<?php echo $dynamictext[1]['Page']['body'];?> 
                            </div>
                            <div class="joinUsBtnCont"><a href="<?php echo $facebookURL; ?>"><img src="<?php echo FIMAGE;?>join_us_btn.png" alt="Join As Student" width="150" height="40" /></a></div>
                        </div>
                    </div>
                    <div class="home3Box">
                    	<h3>Join as Cause</h3>
                        <div class="home3Boxdefault">
                            <div class="home3BoxImg"><img src="<?php echo FIMAGE;?>tutor.png" width="170" height="170" alt="Join As Cause" /></div>
                            <div class="home3BoxTitle"><?php echo $dynamictext[6]['Page']['body'];?></div>
                           <div class="joinUsBtnGrey"><a href="javascript:void(0);"><img src="<?php echo FIMAGE;?>join_us_grey_btn.png" alt="Join As Cause" width="150" height="40" /></a></div>
                        </div>
                        <div class="home3BoxOver">
                            <div class="home3BoxOverDesc">
                            	<?php echo $dynamictext[2]['Page']['body'];?> 
                            </div>
                            <div class="joinUsBtnCont"><a href="<?php echo $facebookURL; ?>"><img src="<?php echo FIMAGE;?>join_us_btn.png" alt="Join As Cause" width="150" height="40" /></a></div>
                        </div>
                    </div>
                    <?php
				}
				?>
                </div>
                <div class="LowerHding">
				
                	<div class="text-outr" style="width:auto;">
                    
                    <div class="tinymcestaticdata">
                   <?php echo $dynamictext[3]['Page']['body'];?> 
                   </div>
                   
                    </div>
                    
                </div>
            </div>