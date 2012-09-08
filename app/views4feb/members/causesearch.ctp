
<script type="text/javascript">
/*
var host = window.location.host;
var proto = window.location.protocol;
var pathArray = window.location.pathname.split( '/' );
var secondLevelLocation = pathArray[1];
var ajax_url = proto+'//'+host;
var ajax_url = ajax_url+'/'+secondLevelLocation;
*/

$(document).ready(function(){
	var $radios = $('input:radio[name=selectRadio]');
    if($radios.is(':checked') === true) {
		selectDefault($('$radios:checked').val());
    }

	$('.selectRadio').click(function(){
		selectDefault($(this).val());
	});
	
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
	$(".sendMessage").live('click',function() {
			$('#toTutId').val($(this).parent().find('.resultId').val());
			$('#toTutName').html($(this).parent().find('.resultName').val());
			$("#dialog-form1").dialog("open");
	});
});

function selectDefault(radioval){
	if(radioval=='tutorname'){
		$('#schooltext').val("");
		$('#searchOptionTwo').show();
		$('#searchOptionOne').hide();
		$("#tutortext").autocomplete(
		  ajax_url+"/members/get_tutor_name",
		  {
				delay:10,
				minChars:1,
				matchSubset:1,
				matchContains:1,
				cacheLength:0,
				autoFill:false
			}
		);
	} else if(radioval=='schoolname'){
		$('#tutortext').val("");
		$('#searchOptionOne').show();
		$('#searchOptionTwo').hide();
		$("#schooltext").autocomplete(
		  ajax_url+"/members/get_school_name",
		  {
				delay:10,
				minChars:1,
				matchSubset:1,
				matchContains:1,
				cacheLength:0,
				autoFill:false
			}
		);
	}
}


function tutorsearchreset()
{
	
	document.getElementById('schoolname').value = '';
	document.getElementById('tutorname').value = '';
}


</script>

<style>
.dp_main{margin:15px 10px 15px 10px;border:1px solid #A0D7F3;background-color:#FAFDFE}
	.dp_img{float:left;margin:12px;border:1px solid #CcC;padding:2px;background-color:#FFF}
	.dp_img img{max-width:100px;max-height:120px}
	.dp_right{float:left;width:300px;margin:8px;background-color:#FFF}
	.dp_info{height:auto;border:1px solid #CcC}
	.dp_info li{list-style:none;margin:4px 2px 2px 15px}
	.dp_action{margin-top:10px;}
	.dp_action input{border:auto}
	.dp_action span{margin-left:10px}
	
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
	#adialog-form1{display:none;}
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
	<div class="searchOuter">	<!-- searchOuter -->
    
    <form name="causesearch" id="causesearch" action="<?php echo HTTP_ROOT.'members/causesearch';?>" method="post" >
    
    	<div class="searchContainer">	<!--searchContainer-->
			<div class="searchDropdownOuter">	<!--searchDropdownOuter-->
                <h1>Choose an Option</h1>
                <div class="list-radio">
                	<input id="selectBySchool" type="radio" name="selectRadio" class="selectRadio" checked="checked" value="schoolname" ><label for="selectBySchool">Select by School</label><br /><br />
                    <input id="selectByTutor" type="radio" name="selectRadio" class="selectRadio" value="tutorname" ><label for="selectByTutor">Select by Tutor</label><br />
                </div>
                <div style="width:300px; float:left; padding-top:22px;">
                </div>
            </div>	<!--searchDropdownOuter-->
            	<!--searchOptionOne-->  
            <div style="display:none" id="searchOptionOne">	<!--searchOptionOne-->
            	<h2>Search by School</h2>
				<h3>&nbsp;</h3>
		          <div style="width:464px; float:left; padding-top:10px;">
                    <div class="inputOuterBox">
                    	<input type="text" style="width:265px; margin-left:20px; float:left; height:30px;"  name="schoolname" id="schooltext" value="<?php if($this->Session->read('searchcause.schoolname')) 
						echo $this->Session->read('searchcause.schoolname');?>" />
                    </div>
                    <div class="searchButtonsOuter">
                        <div class="serchBtnContButton button">
                            <span></span>
                             <input type="submit" value="Search"> 
                        </div>
                        
                    </div>
                </div>
			</div>
            <div style="display:none" id="searchOptionTwo">	<!--searchOptionOne-->
            	<h2>Search by Tutor</h2>
				<h3>Please enter tutor name</h3>
		          <div style="width:464px; float:left; padding-top:10px;">
                    <div class="inputOuterBox">
                    	<input type="text" style="width:150px; margin-left:20px; float:left; height:30px;" name="tutorname" id="tutortext" value="<?php if($this->Session->read('searchcause.tutorname')) 
						echo $this->Session->read('searchcause.tutorname');?>" />
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
				<?php echo $this->element('frontend/members/causesearch'); ?>
		</div>
        
     
            
        </div>	<!--searchTutors-->
</div>	<!-- searchOuter -->
