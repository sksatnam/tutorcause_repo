<script type="text/javascript">
var host = window.location.host;
var proto = window.location.protocol;
var pathArray = window.location.pathname.split( '/' );
var secondLevelLocation = pathArray[1];
var ajax_url = proto+'//'+host;

//   var ajax_url = ajax_url+'/'+secondLevelLocation;

$(document).ready(function(){
	$('#startdate').datepicker({
		dateFormat:'dd-mm-yy',
		minDate: +0
	});
	$('#starttime').timepicker({
		ampm: true,
		timeFormat: 'hh:mm TT'
	});
	$('#endtime').timepicker({
		ampm: true,
		timeFormat: 'hh:mm TT'
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
	//Mutual Friend Div
	$( "#showMutualFriend" ).dialog({
		autoOpen: false,width: 400,modal: true,buttons:{
			Cancel: function() {
				$( this ).dialog("close");
			}
		}
	});
	
	$('.click2showMutual').click(function(){
		var fb_id = $(this).attr('rel');
		$.ajax({
            type: "POST",
            url: ajax_url+'/members/facebookmutual1/'+fb_id,
            data: '&fb_id='+fb_id,
            success: function (html) {
				$("#showMutualFriend").html(html);
				$("#showMutualFriend").dialog("open");
            }
        });
	});
	//
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
			$('#starttime').val("");
			$('#endtime').val("");
			$('#causename').val("");
			$('#searchOptionTwo').show();
			$('#searchOptionOne').hide();
			$('#searchOptionThree').hide();
			$("#coursetext").autocomplete(ajax_url+"/members/get_course_id",{
				delay:10,
				minChars:1,
				matchSubset:1,
				matchContains:1,
				cacheLength:0,
				autoFill:false
			});
		} else {
			$('#startdate').val("");
			$('#starttime').val("");
			$('#endtime').val("");
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
function tutorsearchreset() {
	document.getElementById('startdate').value = '';
	document.getElementById('starttime').value = '';
	document.getElementById('endtime').value = '';
	document.getElementById('coursetext').value = '';
	document.getElementById('causename').value = '';
}
</script>
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
    
    <form name="tutorsearch" id="tutorsearch" action="<?php echo HTTP_ROOT.'members/tutorsearch';?>" method="post" >
    
    	<div class="searchContainer">	<!--searchContainer-->
            <div class="searchDropdownOuter">	<!--searchDropdownOuter-->
                <h1>Choose An Option</h1>
                <div class="list-radio">
                
	                <input id="selectByCourseId" type="radio" name="selectfilter" class="selectRadio" value="course"
                    <?php 
                    if(isset($this->data['TutCourse']['course_id']) && $this->data['TutCourse']['course_id']!='' || !isset($this->data))
					{
					echo "checked=\"checked\"";
					}?> ><label for="selectByCourseId">Search By Course</label><br />
                    
                    <input id="selectByCauseId" type="radio" name="selectfilter" class="selectRadio"  value="cause" 
                    <?php 
                    if(isset($this->data['userMeta']['cause_name']) && $this->data['userMeta']['cause_name']!='')
					{
					echo "checked=\"checked\"";
					}?> ><label for="selectByCauseId">Search By Cause</label><br />
                    
                    <input id="selectbyDayId" type="radio" name="selectfilter" class="selectRadio" value="time" <?php 
                    if( (isset($this->data['TutEvent']['startdate']) && $this->data['TutEvent']['startdate']!='' && isset($this->data['TutEvent']['starttime']) && $this->data['TutEvent']['starttime']!='' && isset($this->data['TutEvent']['endtime']) && $this->data['TutEvent']['endtime']!='' )  )
					{
						echo "checked=\"checked\"";
					}?> ><label for="selectbyDayId">Search By Day</label><br />
                </div>
                <div style="width:300px; float:left; padding-top:22px;">
                </div>
            </div>	<!--searchDropdownOuter-->
            <div  id="searchOptionOne">	<!--searchOptionOne-->
            	<h2>Search By Day</h2>
				<h3>Please Choose Time Interval<br /><b style="color:#333;">&nbsp;</b></h3>
		          <div style="width:483px; float:left; padding-top:5px;">
                    <div class="inputOuterBox" style="width:350px;">
                    	<input type="text" style="width:85px; margin-left:20px; float:left; height:30px;" name="data[TutEvent][startdate]" id="startdate" value="<?php if(isset($this->data['TutEvent']['startdate']) && $this->data['TutEvent']['startdate']!='')
						{
							echo $this->data['TutEvent']['startdate'];
						}
						?>" />
                        <span class="datefrom" style="margin-left:5px; margin-right:5px;">Start time</span>
                        <input type="text" style="width:60px;  float:left; height:30px;" name="data[TutEvent][starttime]" id="starttime" value="<?php if(isset($this->data['TutEvent']['starttime']) && $this->data['TutEvent']['starttime']!='')
						{
							echo $this->data['TutEvent']['starttime'];
						}
						?>" />
                        
                        <span class="datefrom" style="margin-left:5px; margin-right:5px;">End time</span>
                        
                         <input type="text" style="width:60px;  float:left; height:30px;" name="data[TutEvent][endtime]" id="endtime" value="<?php if(isset($this->data['TutEvent']['endtime']) && $this->data['TutEvent']['endtime']!='')
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
			</div>	<!--searchOptionOne-->  
            <div style="display:none; margin-left:65px;" id="searchOptionTwo">	<!--searchOptionOne-->
            	<h2>Search By Course</h2>
				<h3>Type the course code below.<br /><b style="color:#333;">(i.e. MAC2311, STA2023, AP Statistics)</b></h3>
		          <div style="width:464px; float:left; padding-top:5px;">
                    <div class="inputOuterBox">
                    	<input type="text" style="width:150px; margin-left:20px; float:left; height:30px;"  name="data[TutCourse][course_id]" id="coursetext" value="<?php 
                    if($this->Session->read('tutorsearch.course_id'))
					{
					echo $this->Session->read('tutorsearch.course_id');
					}?>" />
                    </div>
                    <div class="searchButtonsOuter">
                        <div class="serchBtnContButton button">
                            <span></span>
                             <input type="submit" value="Search"> 
                        </div>
                        
                    </div>
                </div>
			</div>
            <div style="display:none" id="searchOptionThree">	<!--searchOptionOne-->
            	<h2>Search By Non-Profit</h2>
				<h3>Please enter non-profit name<br /><b style="color:#333;">&nbsp;</b></h3>
		          <div style="width:464px; float:left; padding-top:5px;">
                    <div class="inputOuterBox">
                    	<input type="text" style="width:150px; margin-left:20px; float:left; height:30px;" name="data[userMeta][cause_name]" id="causename" value="<?php 
                    if(isset($this->data['userMeta']['cause_name']) && $this->data['userMeta']['cause_name']!='')
					{
					echo $this->data['userMeta']['cause_name'];
					}?>" />
                    </div>
                    <div class="searchButtonsOuter">
                        <div class="serchBtnContButton button">
                            <span></span>
                            <input type="submit" value="Search"> 
                        </div>
                    </div>
                </div>
			</div>     	
        </div>	<!--searchContainer-->
        
        </form>
        
        
        <div id="pagingDivParent">
        <?php
        if(isset($filtertutorbytime))
		{
			echo $this->element('frontend/members/tutorsearchtime');
		}
		else if(isset($filtertutor))
		{
			echo $this->element('frontend/members/tutorsearch');
		} else {
			echo $this->element('frontend/members/tutorsearch1');
		}
		?>
        </div>
        </div>	<!--searchTutors-->
</div>	<!-- searchOuter -->
<div id="showMutualFriend" title="Mutual Friends"></div>