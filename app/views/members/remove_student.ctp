<?php
/*echo '<pre>';
print_r($parentResult);
die;*/

?>

<script type="text/javascript">	
$(document).ready(function () {
	
	
	$('.removeStudent').live("click",function(){
											  
		var request = $(this);
		
		$('#dialogdeleterequest').dialog({
			autoOpen: true,
			title:"Confirm your request",
			width: 600,
			modal:true,
			buttons: {
				"Yes": function() {
					//$('#form1').submit();
					request.parent().parent('form').submit();
					$(this).dialog("close");
				},
				"No": function() {
					$(this).dialog("close");
					return false;
				}
			}
		});
		return false;
	});
});
</script>






 <div id="content-wrap">
 
 <?php	echo $this->Session->flash(); ?>
 
              <h1>Remove Student</h1>
              <div id="tutor-wrap"> 
                
                <!--Left Sidebar Begin Here-->
                <?php  echo $this->element('frontend/parentLeftSidebar'); ?>
                <!--Left Sidebar End Here--> 
                
                <!--Center Column Begin Here-->
                <div class="center-col">
                
                <?php foreach($mystudent  as $result){?>
                <div class="dp_main">
                <div class="dp_img">
                
                <?php
                if($result['Student']['showImage'])
                {
					if($result['Student']['image_name']){
					echo $html->image("members/thumb/".$result['Student']['image_name']);
						} else {
					?><img src="https://graph.facebook.com/<?php echo $result['Student']['facebookId']; ?>/picture?type=large"  />
					<?php }
                }
                else
                {
            	    echo $html->image("profile-photo.png");
                }
                ?>
                </div>
                <div class="dp_right">
                    <div class="dp_info">
                        <ul>
                            <li><b>Student Name:</b><?php echo $result['Student']['userMeta']['fname'].' '.$result['Student']['userMeta']['lname'];?></li>
                            <li><b>Location:</b><?php 
                            if($result['Student']['userMeta']['city'])
                            {
                            echo $result['Student']['userMeta']['city'].',';
                            }?>  <?php echo $result['Student']['userMeta']['state'];?></li>
                        </ul>
                    </div>
					<?php
                    echo $form->create('Member', array("url"=>array('controller'=>'members', 'action'=>'remove_student'),"id"=>'form1jaw')); 
                    ?>
                    
                        <div class="dp_action">
                        <input type="hidden" name="data[Member][id]"  value="<?php echo $result['ParentStudent']['id'];?>" />
                        <input type="button" name="data[Member][Remove]" value="Remove" class="session-btn removeStudent" />
                        </div>
                        
                    <?php echo $this->Form->end(); ?>
                    
                </div>
                <div style="clear:both"></div>
                </div>
                <?php } if(count($mystudent)==0)
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
 
<div id="dialogdeleterequest" title="Dialog Title" style="display:none;">
	<p>Click on Yes to <span style="color:#F00" >Remove</span> Student </p>
</div>
 
 