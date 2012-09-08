<?php
/*echo '<pre>';
print_r($memberData);
die;*/
?>



<script type="text/javascript">	
$(document).ready(function () {
							
$("#parentemail").autocomplete(ajax_url+"/members/get_parent_email",{
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
 
              <h1>Add Parent</h1>
              <div id="tutor-wrap"> 
                
                <!--Left Sidebar Begin Here-->
                <?php  echo $this->element('frontend/studentLeftSidebar'); ?>
                <!--Left Sidebar End Here--> 
                
                <!--Center Column Begin Here-->
                <div class="center-col">
                
                
                <div class="dp_main_cont" style="border:none;">
           
				<?php 
                echo $form->create('Member', array("url"=>array('controller'=>'members', 'action'=>'add_parent'),"id"=>'MemberAddParent')); 
                ?>
			
            	<div class="dp_main_cont_fields">
                	<div class="dp_main_cont_Lfields">
                    Parent email:<span class="red" >*</span>
                    </div>
                    <div class="dp_main_cont_Mfields" style="width:208px;">
                    	<input type="text" name="data[Member][email]" value="" id="parentemail" class="required" style="width:190px;" >	
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
                    	Parent Info :
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
                            if(empty($alreadyparent))
								{
								?>
                                    <div class="student-btns" style="padding-left:74px;">
                                    <div class="pay-session"><a href="<?php echo HTTP_ROOT.'members/student_req_parent/'.$memberData['Member']['id'];?>">Send Request</a></div>
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
                <?php  echo $this->element('frontend/studentRightSidebar'); ?>
                <!--Right Sidebar End Here--> 
                
              </div>
 </div>