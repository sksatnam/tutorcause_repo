 <div id="content-wrap">
 
 <?php	echo $this->Session->flash(); ?>
 
              <h1>Parent Dashboard</h1>
              <div id="tutor-wrap"> 
                
                <!--Left Sidebar Begin Here-->
                <?php  echo $this->element('frontend/parentLeftSidebar'); ?>
                <!--Left Sidebar End Here--> 
                
                <!--Center Column Begin Here-->
                <div class="center-col">
                
                
                <div id="pagingDivParent">
                <?php echo $this->element('frontend/members/student_request'); ?>
            	</div>
                
             
                </div>
                <!--Center Column End Here--> 
                
                <!--Right Sidebar Begin Here-->
                <?php  echo $this->element('frontend/parentRightSidebar'); ?>
                <!--Right Sidebar End Here--> 
                
              </div>
 </div>