<?php

/*echo '<pre>';
print_r($tutorResult);
die;
*/
?>


<script type="text/javascript">	
$(document).ready(function () {
	$('#menu').tabify();
	$('#menu2').tabify();
	$('.deleteCause').live("click",function(){
		var request = $(this);
		$('#dialogdeleterequest').dialog({
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

              <h1>My Tutors</h1>
              <div id="tutor-wrap"> 
              
              <?php echo $this->element('frontend/causeLeftSidebar'); ?>
                    
                <!--Center Column Begin Here-->
                <div class="center-col">
                
                <div id="pagingDivParent">
                <?php echo $this->element('frontend/members/tutor_request'); ?>
            	</div>
            
                </div>
                <!--Center Column End Here--> 
                
                
                 <?php echo $this->element('frontend/causeRightSidebar');?>    
           
                
  </div>
</div>


<div id="dialogdeleterequest" title="Dialog Title" style="display:none;">
	<p>Click on Yes to <span style="color:#F00" >Delete</span> Tutor request </p>
</div>