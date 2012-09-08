<?php
if($countMsg>0){
	$countMsg = "(".$countMsg.")";
} else {
	$countMsg = "";
}
?>
<script type="text/javascript">
	$(document).ready(function () {
		$('#menu').tabify();
		$('#menu2').tabify();
	});
</script>
<style type="text/css" media="screen">
	body { font: 0.8em Arial, sans-serif; }
</style>
<div class="public_profile_main_cointainer">
<?php	echo $this->Session->flash(); ?>
	<div class="public_profile_cointainer">
    
    	<?php echo $this->element('frontend/causeLeftSidebar'); ?>
        
        <?php echo $this->element('frontend/tutorLeftSidebar');?>
        
        <?php echo $this->element('frontend/studentLeftSidebar');?>
        
    </div>
</div>
