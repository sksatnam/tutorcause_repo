
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>
$(document).ready(function(){
$('#bothPicker').datepick({ 
    showTrigger: '<button type="button" class="trigger">...</button>'});
	
$('#defaultPopup,#defaultInline').datepick(); 
 
$('.disablePicker').toggle(function() { 
        $(this).text('Enable').siblings('.hasDatepick'). 
            datepick('disable'); 
    }, 
    function() { 
        $(this).text('Disable').siblings('.hasDatepick'). 
            datepick('enable'); 
    } 
); 
 
$('#removePicker').toggle(function() { 
        $(this).text('Re-attach'); 
        $('#defaultPopup,#defaultInline').datepick('destroy'); 
    }, 
    function() { 
        $(this).text('Remove'); 
        $('#defaultPopup,#defaultInline').datepick(); 
    });
	
	});
</script>

</head>

<body>
<p><span class="demoLabel">Popup datepicker (input):</span>
			<input size="10" id="defaultPopup" class="hasDatepick">&nbsp;
			<button class="disablePicker" type="button">Disable</button></p>



<p><span class="demoLabel">Focus and button:</span>
			<input type="text" size="10" id="bothPicker" class="hasDatepick"><button class="trigger datepick-trigger" type="button">...</button>&nbsp;
			<button class="disablePicker" type="button">Disable</button></p>
			
			
<p><span class="demoLabel">Popup datepicker (input):</span>
			<input size="10" id="defaultPopup" class="hasDatepick">&nbsp;
			<button class="disablePicker" type="button">Disable</button></p>
</body>
</html>