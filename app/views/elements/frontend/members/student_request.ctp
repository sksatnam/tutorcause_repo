<?php
/*echo '<pre>';
print_r($studentResult);
echo '</pre>';
die;*/
?>


    <?php foreach($studentResult  as $result){?>
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
            <div class="dp_info" style="height:auto;">
                <ul>
                    <li><b>Student Name:</b><?php echo $result['Student']['userMeta']['fname'].' '.$result['Student']['userMeta']['lname'];?></li>
                    <li><b>Location:</b><?php 
                    if($result['Student']['userMeta']['city'])
                    {
                    echo $result['Student']['userMeta']['city'].',';
                    }?>  <?php echo $result['Student']['userMeta']['state'];?></li>
                </ul>
            </div>
            <?php echo $this->Form->create('Member',array('id'=>'form1')); ?>
            <div class="dp_action">
                <input type="hidden" name="data[Member][id]"  value="<?php echo $result['ParentStudent']['id'];?>"  />
                <span><input type="submit" name="data[Member][accept]" value="Accept" class="session-btn" /></span>
               <span><input type="button" name="data[Member][denied]" value="Denied" class="session-btn deleteStudent" /></span>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <div style="clear:both"></div>
    </div>
    <?php } if(count($studentResult)==0)
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
<?php //3aug2012 ?>