<script type="text/javascript">
var host = window.location.host;
var proto = window.location.protocol;
var pathArray = window.location.pathname.split( '/' );
var secondLevelLocation = pathArray[1];
var ajax_url = proto+'//'+host;
var ajax_url = ajax_url+'/'+secondLevelLocation;
$(document).ready(function(){
	$('#startdate').datepicker({
		dateFormat:'dd-mm-yy',
		minDate: +0	
							   });
	$('#starttime').timepicker({
		timeFormat: 'hh:mm',
							 });
	$('#endtime').timepicker({
		timeFormat: 'hh:mm',
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


function tutorsearchreset()
{
	document.getElementById('startdate').value = '';
	document.getElementById('starttime').value = '';
	document.getElementById('endtime').value = '';
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
	<div class="modal_msg" title="Message Sent"></div>
</div>
<div id="search">

<?php	echo $this->Session->flash(); ?>

	<div class="searchOuter">	<!-- searchOuter -->
    
    <form name="tutorsearch" id="tutorsearch" action="<?php echo HTTP_ROOT.'Members/tutorsearch';?>" method="post" >
    
    	<div class="searchContainer">	<!--searchContainer-->
        
        <div  id="searchOptionOne">	<!--searchOptionOne-->
            	<h2>Search By Day</h2>
				<h3>Please Choose Time Interval<br /><b style="color:#333;">&nbsp;</b></h3>
		          <div style="width:483px; float:left; padding-top:5px;">
                    <div class="inputOuterBox" style="width:350px;">
                    	<input type="text" style="width:125px; margin-left:20px; float:left; height:30px;" name="data[TutEvent][startdate]" id="startdate" value="<?php if(isset($this->data['TutEvent']['startdate']) && $this->data['TutEvent']['startdate']!='')
						{
							echo $this->data['TutEvent']['startdate'];
						}
						?>" />
                        <span class="datefrom" style="margin-left:5px; margin-right:5px;">Start time</span>
                        <input type="text" style="width:40px;  float:left; height:30px;" name="data[TutEvent][starttime]" id="starttime" value="<?php if(isset($this->data['TutEvent']['starttime']) && $this->data['TutEvent']['starttime']!='')
						{
							echo $this->data['TutEvent']['starttime'];
						}
						?>" />
                        
                        <span class="datefrom" style="margin-left:5px; margin-right:5px;">End time</span>
                        
                         <input type="text" style="width:40px;  float:left; height:30px;" name="data[TutEvent][endtime]" id="endtime" value="<?php if(isset($this->data['TutEvent']['endtime']) && $this->data['TutEvent']['endtime']!='')
						{
							echo $this->data['TutEvent']['endtime'];
						}
						?>" />
                        
                    </div>
                    <div class="searchButtonsOuter">
                        <div class="serchBtnContButton button">
                            <span></span>
                             <input type="submit" value="Search"> 
                        </div>
                        
                    </div>
                </div>
			</div>
        
        
        <div class="searchButtonsOuter">
        <select name="data[CauseSchool][school_id]" style="width:400px;" >
        <option>fdsjklfa</option>
        <option>fdsjklfa</option>
        </select>
        </div>
        
        
        <div class="searchButtonsOuter">
        <div class="serchBtnContButton button">
        <span></span>
        <input type="submit" value="Search"> 
        </div>
        
        </div>
        
                 	
        </div>	<!--searchContainer-->
        
        </form>
        
        
        <div id="pagingDivParent">
        <?php
        if(isset($filterbyschool))
		{
			print_r($filterbyschool);
			
		//	echo $this->element('frontend/members/filtercauseschool');
		}
		else {
			
			print_r($defaultcause);
		//	echo $this->element('frontend/members/defaultcausesearch');
		}
		?>
        </div>
        </div>	<!--searchTutors-->
</div>	<!-- searchOuter -->
