<?php
/*echo '<pre>';
print_r($parentResult);
die;*/

?>

<script type="text/javascript">	
$(document).ready(function () {
	
	$('.deleteStudent').live("click",function(){
		var request = $(this)
		$('#dialogdeleterequest').dialog({
			//alert('hi');
			autoOpen: true,
			title:"Confirm your request",
			width: 600,
			modal:true,
			buttons: {
				"Yes": function() {
					//$('#form1').submit();
					request.parent().parent().parent('form').submit();
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
 
              <h1>Student Request</h1>
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
 
<div id="dialogdeleterequest" title="Dialog Title" style="display:none;">
	<p>Click on Yes to <span style="color:#F00" >Delete</span> Student request </p>
</div>
<?php //3aug2012 ?>