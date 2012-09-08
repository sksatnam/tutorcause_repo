<div id="content-wrap"  class="fontNew">
<?php	echo $this->Session->flash(); ?>
  <h1>My Classes  </h1>
  <div id="tutor-wrap"> 
    <?php
	
    	if($this->Session->read('Member.group_id')==7)
		{
			echo $this->element('frontend/tutorLeftSidebar');
		}
		else if($this->Session->read('Member.group_id')==8)
		{
			echo $this->element('frontend/studentLeftSidebar');
		}
	?>
    
    
    
    <!--Center Column Begin Here-->
    <div class="centerOuter">
    
		<div class="centerHding">Live and upcoming classes</div>
        
        <div id="pagingDivParent">
            <?php echo $this->element('frontend/members/element_myclass'); ?>
        </div>
        
    </div>
    <!--Center Column End Here-->
      
    
    
        
    </div>
</div>