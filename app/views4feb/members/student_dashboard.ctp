<script type="text/javascript">if (window.location.hash == '#_=_')window.location.hash = '';</script>

<script type="text/javascript">
function submitform()
{
    document.forms["selectcourse"].submit();
}
</script>


<?php
if($countMsg>0){
	$countMsg = $countMsg;
} else {
	$countMsg = "";
}
?>
<style type="text/css" media="screen">
/*	body { font: 0.8em Arial, sans-serif; }
	.profileContent{height:auto;margin:20px 0px;}
	.profileContent ul{padding:0px;margin:0px;}
	.profileContent li{float:left;width:270px;list-style:none;font-size:14px;padding:5px 2px;border-bottom:1px dotted #CCC;color:#18497A}
	.profileContent .li1{text-align:right;font-weight:bold;width:160px;}
	.profileContent .li2{margin-left:20px;}
*/	.clear{clear:both;}

</style>

<div id="content-wrap"  class="fontNew">

<?php	echo $this->Session->flash(); ?>

  <h1>Your Dashboard</h1>
  <div id="tutor-wrap"> 
    
    <?php  echo $this->element('frontend/studentLeftSidebar'); ?>
                   
    <!--Center Column Begin Here-->
    <div class="center-col">
    <div class="center-row">
    <div class="center-content">
    <div id="messages">
    <div class="center-heading">
      <h2>You have <?php if($countMsg)
				{
				?>	
				<span><?php echo $countMsg;?></span>
                <?php	
				}
				else
				{
				echo 'no';
				}
				?> messages in your inbox</h2>
      <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/messages';?>">Go to Inbox</a></div>
	 
	   <?php /*?> <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/outbox_message';?>">Go to Outbox</a></div><?php */?>
    </div>
    </div>
    </div>
    </div>
    <div class="center-row">
    <div class="center-content">
    <div id="my-courses">
    <div class="center-heading">
      <h2>My Courses</h2>
      <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/student_course';?>">Edit My courses</a></div>
    </div>
    
    <form name="selectcourse" id="selectcourse" action="<?php echo HTTP_ROOT.'members/selected_course';?>" method="post">
    <div id="selcet-course">  
    <?php
	foreach($studentcourse as $sc)
	{
	?>
      <label><input name="course" type="radio" value="<?php echo $sc['StdCourse']['course'];?>"/><?php echo $sc['StdCourse']['course'];?></label>
    <?php
	}
	?>
    </div>
    </form>
    <div id="find">
    <!--  <div class="find-bg"><a href="javascript: submitform()">Quick Search</a></div>-->
      <div class="find-bg"><a href="javascript: submitform()">Find Tutor</a></div>
    </div>
    </div>
    </div>
    </div>
    <div class="center-row2">
    <div class="center-content">
    <div id="notices">
    <div class="center-heading">
      <h2>Notice Board</h2>
      <div class="center-view"><a href="<?php echo HTTP_ROOT.'members/notices';?>">View all notices</a></div>
    </div>
    
     <?php
	foreach($studentnotice as $sn)
	{
	?>
    <div class="notice"> <span><?php echo $sn['Notice']['notice_head'];?></span>
      <p><?php echo $sn['Notice']['notice_text'];?></p>
    </div>
    <?php
	}
	?>
    
    </div>
    </div>
    </div>
    </div>
    <!--Center Column End Here--> 
        
    <?php  echo $this->element('frontend/studentRightSidebar'); ?>
        
    </div>
</div>
