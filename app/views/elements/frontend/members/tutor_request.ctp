    
    <?php foreach($tutorResult  as $result){?>
    <div class="dp_main">
        <div class="dp_img">
        
        <?php
		 if($result['Member']['showImage'])
		{
						
            $countImg = count($result['Member']['UserImage'])-1;
            if(count($result['Member']['UserImage'])){
                echo $html->image("members/thumb/".$result['Member']['UserImage'][$countImg]['image_name']);
            } else {
                ?><img src="https://graph.facebook.com/<?php echo $result['Member']['facebookId']; ?>/picture?type=large"  />
            <?php }
		}
		else
		{
			echo $html->image("profile-photo.png");
		}
        ?>
       </div>
        <div class="dp_right">
            <div class="dp_info" style="height:auto;">
                <ul>
                    <li><b>Tutor Name:</b><?php echo $result['Member']['userMeta']['fname'].' '.$result['Member']['userMeta']['lname'];?></li>
                    
                    <li><b>Location:</b>
                    <?php 
                    if(!empty($result['Member']['userMeta']['city']) && !empty($result['Member']['userMeta']['state']))
                    {
					
                        echo $result['Member']['userMeta']['city'].','.$result['Member']['userMeta']['state'];
					}
					else
					{
						echo 'N/A';
					}
                    ?>
                    </li>
                    
                </ul>
            </div>
            <?php echo $this->Form->create('Member',array('id'=>'form1')); ?>
            <div class="dp_action">
                <input type="hidden" name="data[Member][id]"  value="<?php echo $result['TutorRequestCause']['id'];?>" />
                <span><input type="submit" name="data[Member][accept]" value="Accept" /></span>
                <span><input type="button" name="data[Member][denied]" value="Denied" class="deleteCause"  /></span>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <div style="clear:both"></div>
    </div>
    <?php } if(count($tutorResult)==0)
   {
	?>
		<p style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px;padding-top: 5px; padding-left: 5px; text-align:center;"><b>No Record Found</b></p>
	<?php
	}
    else
	{
	?>	
	
        <!-- pagination starts -->
        <div class="paging" id="users-paging-view">
        <?php echo $paginator->prev(' '.__('Prev Page', true), array(), null, array('class'=>'disabled'));?> 
        <span style="float:left; margin-right: 2px; padding: 3px 4px;">|</span>
        <?php echo $paginator->next(__('Next Page', true).' ', array(), null, array('class' => 'disabled'));?>
        </div>
        <!-- pagination end -->	
		
	<?php	
	}
	?>            