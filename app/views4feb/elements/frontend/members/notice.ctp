
<div class="center-row2">
          <div class="center-content">
            <div id="notices">
              <div class="center-heading">
                <h2>Notice Board</h2>
                <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/notices';?>">View all notices</a></div>
              </div>
              
				<?php
                foreach($noticeList as $lists)
					{
					?>
                        <div class="notice"> <span><?php echo $lists['Notice']['notice_head'];?></span>
                        <p><?php echo $lists['Notice']['notice_text'];?></p>
                        </div>
					<?php
					if(count($noticeList)==0)
						{
							echo 'No Record Found';
						}
		
					}
                ?>
             
              
              
            </div>
          </div>
        </div>

<!-- pagination starts -->
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

/*<div style="background-color:#F0F0EE;border:1px solid grey;text-align:center;"><a><?php echo $paginator->counter(array('format' => '<b>Currently showing</b> %start%-%end%, <b>Total Pages</b> = %pages%, <b>Total results</b> = %count%'));?> </a></div>	
*/
?>

<!-- pagination ends -->



