<div id="left-col">
	  		<!-- Quick links -->
			<div class="box">  	
		  		<h4 style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;" class="yellow rounded_by_jQuery_corners">Quick Visual Links</h4>
            <div style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;" class="box-container rounded_by_jQuery_corners">
		  		<ul id="quick-visual-links">
				
                <?php if($session->read('Admin.group_id')=='1')
			{
            ?>
		  			<li><?php echo $html->link($html->image('ql-users.gif',array('height'=>30,'width'=>32)) . '<br> User View',array('controller'=>'members','action'=>'member_view','admin'=>'true'), array('escape' => false));  ?></li>	
                    	<li><?php echo $html->link($html->image('faq.png',array('height'=>30,'width'=>32)) . '<br>  Faq View ',array('controller'=>'faqs','action'=>'faq_view','admin'=>'true'), array('escape' => false));  ?></li>
                        <li><?php echo $html->link($html->image('pages.jpg',array('height'=>30,'width'=>32)) . '<br>  CMS Pages ',array('controller'=>'members','action'=>'front_static_page','admin'=>'true'), array('escape' => false));  ?></li>
                        	
                <?php
			}
				?>
                
                  <?php if($session->read('Admin.group_id')=='3' || $session->read('Admin.group_id')=='1' )
			{
            ?>
                    
					<li><?php echo $html->link($html->image('School-Icon.png',array('height'=>30,'width'=>32)) . '<br> School View',array('controller'=>'schools','action'=>'view','admin'=>'true'), array('escape' => false));  ?></li>	
                    
                    <li><?php echo $html->link($html->image('books.png',array('height'=>30,'width'=>32)) . '<br>CourseView',array('controller'=>'schools','action'=>'all_course_view','admin'=>'true'), array('escape' => false));  ?></li>	
                    <?php
			}
					?>
                    
                <?php if($session->read('Admin.group_id')=='4')
			{
            ?>
           <li><?php echo $html->link($html->image('books.png',array('height'=>30,'width'=>32)) . '<br>CourseView',array('controller'=>'schools','action'=>'view_assign_course','admin'=>'true'), array('escape' => false));  ?></li>	
	
		  			
                <?php
			}
				?>

					
		  		</ul>
                <span class="clearFix">&nbsp;</span> 
          </div><!-- end of div.box-container -->            
          </div>	
			<!-- End quick links -->
          <div class="box">
              <h4 style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;" class="yellow rounded_by_jQuery_corners">Add Panel</h4>
          <div style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;" class="box-container rounded_by_jQuery_corners"><!-- use no-padding wherever you need element padding gone -->
              <ul role="tablist" class="list-links ui-accordion ui-widget ui-helper-reset">
              
                 <?php if($session->read('Admin.group_id')=='1')
			{
            ?>
                <li class="ui-accordion-li-fix"><?php echo $html->link('Add Users',array('controller'=>'members','action'=>'add','admin'=>'true'), array('class' => 'ui-accordion-header ui-helper-reset ui-state-active ui-corner-top', 'tabindex' => -1, 'aria-expanded'=>false, 'role'=>'tab'));  ?></li>
                
                 <li class="ui-accordion-li-fix"><?php echo $html->link('Add FAQs',array('controller'=>'faqs','action'=>'faq_add','admin'=>'true'), array('class' => 'ui-accordion-header ui-helper-reset ui-state-active ui-corner-top', 'tabindex' => -1, 'aria-expanded'=>false, 'role'=>'tab'));  ?></li>
                
                <?php
			}
				?>
                
                
                     <?php if($session->read('Admin.group_id')=='3' || $session->read('Admin.group_id')=='1' )
			{
            ?>
              <li class="ui-accordion-li-fix"><?php echo $html->link('Add Schools',array('controller'=>'schools','action'=>'add'), array('class' => 'ui-accordion-header ui-helper-reset ui-state-active ui-corner-top', 'tabindex' => -1, 'aria-expanded'=>false, 'role'=>'tab'));  ?></li>
              
                   <li class="ui-accordion-li-fix"><?php echo $html->link('Add Courses',array('controller'=>'schools','action'=>'course_add'), array('class' => 'ui-accordion-header ui-helper-reset ui-state-active ui-corner-top', 'tabindex' => -1, 'aria-expanded'=>false, 'role'=>'tab'));  ?></li>
                
                <?php
			}
				?>
                
               <?php if($session->read('Admin.group_id')=='4')
			{
            ?>
            
                   <li class="ui-accordion-li-fix"><?php echo $html->link('Add Courses',array('controller'=>'schools','action'=>'add_assign_course'), array('class' => 'ui-accordion-header ui-helper-reset ui-state-active ui-corner-top', 'tabindex' => -1, 'aria-expanded'=>false, 'role'=>'tab'));  ?></li>
                
                <?php
			}
				?>
              
              
              
              
              
                  
                  
                 <!--<li class="ui-accordion-li-fix"><a tabindex="-1" aria-expanded="false" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" href="#">Setup a New Site</a></li>
                  <li class="ui-accordion-li-fix"><a tabindex="-1" aria-expanded="false" role="tab" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all" href="#">Manage Site Accounts</a></li>-->
              </ul>
          </div><!--end of div.box-container -->
          </div><!-- end of div.box -->
         
      </div>