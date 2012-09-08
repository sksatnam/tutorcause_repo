
<script type="text/javascript">	
$(document).ready(function () {
							
$("#studentemail").autocomplete(ajax_url+"/members/get_student_email",{
				delay:10,
				minChars:1,
				matchSubset:1,
				matchContains:1,
				cacheLength:0,
				autoFill:false
			});
			
	
});

</script>


<pre>
<?php
/*print_r($parentnotice);
print_r($getBalance);
print_r($countMsg);
echo $countMsg;
die;*/
?>

</pre>




<?php
/*if($countMsg>0){
	$countMsg = $countMsg;
} else {
	$countMsg = "";
}*/
?>


 <div id="content-wrap">
 
 <?php	echo $this->Session->flash(); ?>
 
              <h1>Add Student </h1>
              <div id="tutor-wrap"> 
                
                <!--Left Sidebar Begin Here-->
                <?php  echo $this->element('frontend/parentLeftSidebar'); ?>
                <!--Left Sidebar End Here--> 
                
                <!--Center Column Begin Here-->
                <?php /*?><?php */?>
                <div class="center-col">
                
                
                <div class="dp_main_cont" style="border:none;">
           
				<?php 
                echo $form->create('Member', array("url"=>array('controller'=>'members', 'action'=>'add_student'),"id"=>'MemberAddStudent')); 
                ?>
	
            	<div class="dp_main_cont_fields">
                	<div class="dp_main_cont_Lfields" style="width:108px;">
                    Student email:<span class="red" >*</span>
                    </div>
                    <div class="dp_main_cont_Mfields" style="width:208px;">
                    	<input type="text" name="data[Member][email]" value="" id="studentemail" class="required" style="width:190px;" >
                        <?php 
						$error =$this->Session->read('errmsg');
						if(isset($error)||(strlen($error>0)))
						{
						?>
                        <p id="error1" class="errmsg" style="height:3px; color:#FF0000; margin-bottom:5px; font-size:14px;"> Email is not valid</p>	
                        <?php
						}
						?>
                    </div>
                    <div class="dp_main_cont_Rfields">
                    	<input type="submit"  value="Find" class="fund-btn">
                    </div>
                </div>
                
                <?php $form->end(); ?>
                
                
                <?php
                if(!empty($memberData))
				{
				
				
				
				
				?>
                
                <div class="dp_main_cont_fields">
                	<div class="dp_main_cont_Lfields">
                    	Student Info :
                    </div>
                    
                    <ul id="my-student">
                    
                    <li>
                        <div class="profile-wrap">
                            <div class="student-info">
                            <div class="profile-pic"><?php
							if($memberData['Member']['showImage'])
							{
								if(!empty($memberData['Member']['image_name'])){
									echo $html->image("members/thumb/".$memberData['Member']['image_name'],array('height'=>58,'width'=>57));
								} else {
								?>
                                <img src="https://graph.facebook.com/<?php echo $memberData['Member']['facebookId']; ?>/picture?type=large" style="height:58px; width:57px;"   />
								<?php }
							}
							else
							{
								echo $html->image("profile-photo.png",array('height'=>58,'width'=>57));
							}
							?></div>
                            <div class="profile-info">
                                <div class="name-price">
                                <h4 class="profile-name"><?php echo $memberData['Member']['fname'].' '.$memberData['Member']['lname'];?></h4>
                                <p class="student-text"> <?php
								if(!empty($memberData['userMeta']['biography']))
								{
									
									if(strlen($memberData['userMeta']['biography'])>44)
									{
										echo substr($memberData['userMeta']['biography'],0,44).'...';	
									}
									else
									{
										echo $memberData['userMeta']['biography'];
									}
								}
								?></p>
                                </div>
                            </div>
                            </div> 
                            
                            <?php
							if(empty($alreadystudent))
							{
							?>
                                <div class="student-btns" style="padding-left:74px;">
                                <div class="pay-session"><a href="<?php echo HTTP_ROOT.'members/parent_req_student/'.$memberData['Member']['id'];?>">Send Request</a></div>
                                </div>
                            <?php
							}
							?>
                            
                        </div>
                    </li>
                             
                	</ul>
                    
                </div>
                
                <?php
				}
				?>
                
                
            </div>
                
             
                </div>
                <!--Center Column End Here--> 
                
                <!--Right Sidebar Begin Here-->
                <?php  echo $this->element('frontend/parentRightSidebar'); ?>
                <!--Right Sidebar End Here--> 
                
              </div>
 </div>
 <?php //3aug2012 ?>