
<?php 
//pr($parents);die;
	//pr($reviews);die;
	//pr($questions);die;?>

<div id="content">
	<div id="content-top">
    <h2>Dashboard</h2>    
      <span class="clearFix">&nbsp;</span>
      </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	  <div id="mid-col">    	
	 <?php if($session->read('Admin.group_id')=='3' || $session->read('Admin.group_id')=='1' )
	 {?>
		<div class="rightbox">
				<h4 style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners"> Recent Added Schools</h4>
				<div style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright:5px; min-height:355px;" class="box-container rounded_by_jQuery_corners">
					
						<?php
						$schoolnum=1;
						foreach($schools as $school){
						?>
					<div style="border-bottom-style:dotted; min-height:47px; border-bottom-width:1px; padding-bottom:12px; padding-left:2%; padding-top:10px;">
							
						<div class="blogDivCont">
							<div class="revPostHeadinLink adminlink1" >
								<span><b><?php echo $html->link($school['School']['school_name'],array('controller'=>'schools','action'=>'edit','admin'=>true, base64_encode(convert_uuencode($school['School']['id']))));?></b>
								
							</div>
							<br />
						
						<div class="postedByRevInfo adminlink">
							<label><b>Email :&nbsp;</b><i><span style="color:#888888"><?php echo $school['School']['url'];?></span></i> <b>&nbsp;On&nbsp;</b><?php echo $school['School']['created']?></label>
						</div>
						</div>
						
					</div>
					<?php
						if($schoolnum==5)
						{
						break;
						}
						$schoolnum=$schoolnum+1;
						}
						?>
					</div>
					
					
				</div>
               <?php } ?>
               
          <?php if($session->read('Admin.group_id')=='3')
		  {?>
               	<div class="rightbox">
				<h4 style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners"> Recent Added Courses</h4>
				<div style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright:5px; min-height:355px;" class="box-container rounded_by_jQuery_corners">
					
						<?php
						$schoolnum=1;
						foreach($courses as $course){
						?>
					<div style="border-bottom-style:dotted; min-height:47px; border-bottom-width:1px; padding-bottom:12px; padding-left:2%; padding-top:10px;">
							
						<div class="blogDivCont">
							<div class="revPostHeadinLink adminlink1" >
								<span><b><?php echo $html->link($course['Course']['course_title'],array('controller'=>'schools','action'=>'course_edit','admin'=>true,$course['Course']['id']));?></b>
								
							</div>
							<br />
						
						<div class="postedByRevInfo adminlink">
							<label><b>Course Code :&nbsp;</b><i><span style="color:#888888"><?php echo $course['Course']['course_id'];?></span></i> <b>&nbsp;On&nbsp;</b><?php echo $course['Course']['created']?></label>
						</div>
						</div>
						
					</div>
					<?php
						if($schoolnum==5)
						{
						break;
						}
						$schoolnum=$schoolnum+1;
						}
						?>
					</div>
					
					
				</div>
                <?php } ?>
               
        <?php if( $session->read('Admin.group_id')=='1' )
		{ ?>
			<div class="rightbox">
				<h4 style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners"> Recent Added Tutor</h4>
				<div style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px; min-height:355px;" class="box-container rounded_by_jQuery_corners">
					
						<?php
						$parentnum=1;
						foreach($tutors as $tutor){
						?>
					<div style="border-bottom-style:dotted; border-bottom-width:1px; min-height:47px; padding-bottom:12px; padding-left:2%; padding-top:10px;">
							
						<div class="blogDivCont">
							<div class="revPostHeadinLink adminlink1">
								<b><?php echo $html->link($tutor['userMeta']['fname'].''.$tutor['userMeta']['lname'],array('controller'=>'members','action'=>'edit','admin'=>true, base64_encode(convert_uuencode($tutor['Member']['id']))));?></b>
								
							</div>
							<br />
						<?php /*?><div class="blogPostTxt">
							<?php echo $review['Review']['reviews']; ?>
						</div><?php */?>
						<div class="postedByRevInfo adminlink">
							<label><b>Email :&nbsp;</b><i><span style="color:#888888"><?php echo $tutor['Member']['email'];?></span></i> <b>&nbsp;On&nbsp;</b><?php echo $tutor['Member']['created']?></label>
						</div>
						</div>
						
					</div>
					<?php
						if($parentnum==5)
						{
						break;
						}
						$parentnum=$parentnum+1;
						}
						?>
					</div>
					
					
				</div>
				<div class="" style="clear:both;">
				</div>
				<div class="rightbox">
				<h4 style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners"> Recent Added Student</h4>
				<div style="-moz-border-radius-bottomleft: 5px; min-height:370px; -moz-border-radius-bottomright: 5px;" class="box-container rounded_by_jQuery_corners">
					<?php // pr($questions); die; 
						$quesnum=1;
							foreach($students as $student){ ?>
					<div style="border-bottom-style:dotted; border-bottom-width:1px; min-height:47px; padding-bottom:12px; padding-left:2%; padding-top:10px;">
							
						<div class="blogDivCont">
							<div class="revPostHeadinLink adminlink1">
								<b><?php echo $html->link($student['userMeta']['fname'].''.$student['userMeta']['lname'],array('controller'=>'members','action'=>'edit','admin'=>true, base64_encode(convert_uuencode($student['Member']['id']))));?></b>
								
							</div>
							<br />
						<?php /*?><div class="blogPostTxt">
							<?php echo $review['Review']['reviews']; ?>
						</div><?php */?>
						<div class="postedByRevInfo adminlink">
							<label><b>Email :&nbsp;</b><i><span style="color:#888888"><?php echo $student['Member']['email'];?></span></i> <b>&nbsp;On&nbsp;</b><?php echo $student['Member']['created']?></label>
						</div>
						</div>
						
					</div>
						
						<?php 
					if($quesnum==5)
					{
					break;
					}
					$quesnum=$quesnum+1;
					
					}?>		
					</div>
					
					
				</div>
				<div class="rightbox">
				<h4 style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners"> Recent Added Cause</h4>
               
					
				<div style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px; min-height:370px;" class="box-container rounded_by_jQuery_corners">
                 <?php
						$reviewnum=1;
						foreach($causes as $cause){
						?>
                
                <div style="border-bottom-style:dotted; border-bottom-width:1px; min-height:47px; padding-bottom:12px; padding-left:2%; padding-top:10px;">
							
						<div class="blogDivCont">
							<div class="revPostHeadinLink adminlink1">
								<b><?php echo $html->link($cause['userMeta']['fname'].''.$cause['userMeta']['lname'],array('controller'=>'members','action'=>'edit','admin'=>true, base64_encode(convert_uuencode($cause['Member']['id']))));?></b>
								
							</div>
							<br />
						<?php /*?><div class="blogPostTxt">
							<?php echo $review['Review']['reviews']; ?>
						</div><?php */?>
						<div class="postedByRevInfo adminlink">
							<label><b>Email :&nbsp;</b><i><span style="color:#888888"><?php echo $cause['Member']['email'];?></span></i> <b>&nbsp;On&nbsp;</b><?php echo $cause['Member']['created']?></label>
						</div>
						</div>
						
					</div>
					
					<?php
						$reviewnum=$reviewnum+1;
						}
						?>
					
				</div>
		</div>
        <?php } ?>
		</div>
		
		
		
		
	</div><!-- end of div#mid-col -->
      <span class="clearFix">&nbsp;</span>     
</div>