    <?php foreach($parentResult  as $result){?>
    <div class="dp_main">
        <div class="dp_img">
        
        <?php
		 if($result['Parent']['showImage'])
		{
			
            if($result['Parent']['image_name']){
                echo $html->image("members/thumb/".$result['Parent']['image_name']);
            } else {
                ?><img src="https://graph.facebook.com/<?php echo $result['Parent']['facebookId'];?>/picture?type=large"  />
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
                    <li><b>Parent Name:</b><?php echo $result['Parent']['fname'].' '.$result['Parent']['lname'];?></li>
                    <li style="width: 225px; word-wrap: break-word;"><b>Location:</b><?php 
                    if($result['Parent']['userMeta']['city'])
                    {
                    echo $result['Parent']['userMeta']['city'].',';
                    }?>  <?php echo $result['Parent']['userMeta']['state'];?></li>
                </ul>
            </div>
            <?php echo $this->Form->create('Member',array('id'=>'form1')); ?>
            <div class="dp_action">
                <input type="hidden" name="data[Member][id]"  value="<?php echo $result['ParentStudent']['id'];?>" />
                <span><input type="submit" name="data[Member][accept]" value="Accept" class="session-btn" /></span>
                <span><input type="button" name="data[Member][denied]" value="Denied" class="session-btn deleteParent"  /></span>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
        <div style="clear:both"></div>
    </div>
    <?php } if(count($parentResult)==0)
   {
	?>
		<p style="font-family: Myriad Pro; color: rgb(24, 73, 122); font-size: 16px;padding-top: 5px; padding-left: 5px; text-align:center;"><b>No Record Found</b></p>
	<?php
	}
    else
	{
	?>	
	
        <!-- pagination starts -->
        <div class="paging" id="users-paging-view" style="float:right;">
        <?php echo $paginator->prev(' '.__('Prev Page', true), array(), null, array('class'=>'disabled'));?> 
        <span style="float:left; margin-right: 2px; padding: 3px 4px;">|</span>
        <?php echo $paginator->next(__('Next Page', true).' ', array(), null, array('class' => 'disabled'));?>
        </div>
        <!-- pagination end -->	
		
	<?php	
	}
	?>            
<?php //3aug2012 ?>