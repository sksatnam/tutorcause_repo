<script type="text/javascript">
var host = window.location.host;
var proto = window.location.protocol;
var pathArray = window.location.pathname.split( '/' );
var secondLevelLocation = pathArray[1];
var ajax_url = proto+'//'+host;
var ajax_url = ajax_url+'/'+secondLevelLocation;
$(document).ready(function(){
	$('#startdate').datetimepicker({
		timeFormat: 'hh:mm',
		dateFormat:'dd-mm-yy', 
							   });
	$('#enddate').datetimepicker({
		timeFormat: 'hh:mm',
		dateFormat:'dd-mm-yy',
							 });
	
	//Diolog Box
	$( "#dialog-form1" ).dialog({
		autoOpen: false,width: 400,modal: true,buttons:{
			"Send Message": function() {
				sendMessage();
			},
			Cancel: function() {
				$( this ).dialog("close");
			}
		}
	});
	var $radios = $('input:radio[name=selectfilter]');
    if($radios.is(':checked') === true) {
		selectDefault($('$radios:checked').val());
    }
	$('.selectRadio').click(function(){
		selectDefault($(this).val());
	});
	$(".sendMessage").click(function() {
			$('#toTutId').val($(this).parent().find('.resultId').val());
			$('#toTutName').html($(this).parent().find('.resultName').val());
			$("#dialog-form1").dialog("open");
	});
});

function selectDefault(radioval){
	if(radioval=='time'){
			$('#causename').val("");
			$('#coursetext').val("");
			$('#searchOptionOne').show();
			$('#searchOptionTwo').hide();
			$('#searchOptionThree').hide();
		} else if(radioval=='course'){
			$('#startdate').val("");
			$('#enddate').val("");
			$('#causename').val("");
			$('#searchOptionTwo').show();
			$('#searchOptionOne').hide();
			$('#searchOptionThree').hide();
			$("#coursetext").autocomplete(ajax_url+"/Members/get_course_id",{
				delay:10,
				minChars:1,
				matchSubset:1,
				matchContains:1,
				cacheLength:0,
				autoFill:false
			});
		} else {
			$('#startdate').val("");
			$('#enddate').val("");
			$('#coursetext').val("");
			$ ('#searchOptionThree').show();
			$('#searchOptionOne').hide();
			$('#searchOptionTwo').hide();
			$("#causename").autocomplete(
			ajax_url+"/members/get_non_profit_name",{
				delay:10,
				minChars:1,
				matchSubset:1,
				matchContains:1,
				cacheLength:0,
				autoFill:false
			});
		}
}
function tutorsearchreset()
{
	document.getElementById('startdate').value = '';
	document.getElementById('enddate').value = '';
	document.getElementById('coursetext').value = '';
	document.getElementById('causename').value = '';
}



</script>
<style>
.modal_conatiner{padding:20px 10px;}
.modal_conatiner ul{padding:0px;margin:0px;}
.modal_conatiner ul li{margin:10px 5px;list-style:none;}
.modal_left{width:65px;text-align:right;font-weight:bold;float:left}
.modal_right{margin-left:10px;float:left;width:235px;}
.modal_text,.modal_area{width:230px;padding:1px;border:1px solid #3E89C1}
.modal_text{height:20px;}
.modal_area{height:90px;}
.modal_msg{text-align:center;border:1px solid #3E89C1;background-color:#EFF5FA;height:20px;padding:3px;color:#265679;font-weight:bold;display:none;margin-top:10px}
.clear{clear:both}
#dialog-form1{display:none;}
</style>
<div id="dialog-form1" title="Send Message">
	<div class="modal_conatiner">
		<ul>
			<li>
				<div class="modal_left">To:</div>
				<div class="modal_right" id="toTutName"></div>
				<div class="clear"><input type="hidden" id="toTutId" /></div>
			</li>
			<li>
				<div class="modal_left">Subject:</div>
				<div class="modal_right"><input type="text" class="modal_text" id="subject" /></div>
				<div class="clear"><input type="hidden" id="tutor" /></div>
			</li>
			<li>
				<div class="modal_left">Message:</div>
				<div class="modal_right"><textarea class="modal_area" id="message"></textarea></div>
				<div class="clear"></div>
			</li>
			
		</ul>
	</div>
	<div class="modal_msg" title="Messege Sent"></div>
</div>
<div id="search">
	<div class="searchOuter" style="margin-top:10px;">	<!-- searchOuter -->
        
        <div id="pagingDivParent">
        <?php
    		  	echo $this->element('frontend/members/mutualtutor');
		?>
        </div>
        </div>	<!--searchTutors-->
</div>	<!-- searchOuter -->
