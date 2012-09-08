<script type="text/javascript">
function confirmDel(){
$('#dialog').dialog({
        autoOpen: true,
        title:"Confirm your request",
        width: 600,		
        modal:true,
        buttons: {
        "Yes": function() {
            $(this).dialog("close");
        },
        "No": function() {
            $(this).dialog("close");
        }
        }
    });
}
</script>


<div style="text-align:center;">
Delete Record? <input type="button" value="Delete" onclick="confirmDel();">
</div>
<div id="dialog" title="Dialog Title" style="display:none;">
            <p>Do you want to edit all recurring lessons for this time block, or just this one?</p>
</div>
