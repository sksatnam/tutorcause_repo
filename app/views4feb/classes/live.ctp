<script type="text/javascript"> 

/*
$(function () {
			
	var austDay = new Date();
	austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
	$('#defaultCountdown').countdown({until: austDay});
	$('#year').text(austDay.getFullYear());
	
	$('#defaultCountdown').countdown({until: +600}); 
	
});
*/

$(function () {
$('#defaultCountdown').countdown({ 
    until: +<?php echo $second;?>, serverSync: serverTime , onExpiry: reloadPage }); 


$('#dialogdelete').dialog({
        autoOpen: true,
        title:"Class will start in some time...",
        width: 600,
        modal:true,
        buttons: {}
});	





			});
 
function serverTime() { 
    var time = null; 
    $.ajax({url: ajax_url+"/classes/server_time", 
        async: false, dataType: 'text', 
        success: function(text) { 
            time = new Date(text); 
        }, error: function(http, message, exc) { 
            time = new Date(); 
    }}); 
    return time; 
}


function reloadPage()
{
	window.location.reload()
}






</script>

<style type="text/css">
	#defaultCountdown { 
	width: 240px; 
	height: 45px;
	margin-top:20px;
	margin-left:165px;
	}
</style>


<div id="content-wrap">
              <?php echo $html->image('frontend/tutoring-page3.jpg');?>
</div>


<div id="dialogdelete" title="Dialog Title" style="display:none;">
            <div id="defaultCountdown"></div>
</div>




