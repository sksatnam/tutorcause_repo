<script type="text/javascript">
$(document).ready(function(){
	
//Set default open/close settings
$('.acc_container').hide(); //Hide/close all containers
$('.acc_trigger:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container

//On Click

$('.acc_trigger').live("click",function(){
	if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
		$('.acc_trigger').removeClass('active').next().slideUp(); //Remove all .acc_trigger classes and slide up the immediate next container
		$(this).toggleClass('active').next().slideDown(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	}
	return false; //Prevent the browser jump to the link anchor
});


$("#causeName").autocomplete(
		  ajax_url+"/members/get_non_profit_name",
		  {
				delay:10,
				minChars:1,
				matchSubset:1,
				matchContains:1,
				cacheLength:0,
				autoFill:false
			}
		);



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


function showcause(id)
{
   url = document.getElementById('pagingStatus').value;
   loadurl = url+'?causeid='+id;
   $("#pagingDivParent").load(loadurl);
}


</script>

<input type="hidden" name="pagingStatus" id="pagingStatus" value="<?php echo HTTP_ROOT.'members/design_csearch/page:1';?>"  />

<div id="content-wrap" class="fontNew">
<?php	echo $this->Session->flash();
		$schoolid  = $this->Session->read('findcause.schoolid');
?>
  <h1>Tutor Search</h1>
  <div id="tutor-wrap"> 
    
    <form name="causesearch" id="causesearch" action="<?php echo HTTP_ROOT.'members/design_csearch';?>" method="post" >
    
    <!--Cause Search Begin Here-->
    <div id="search-wrap">
      <div id="cause-search">
        <label>Search by cause name:</label>
        <input name="data[CauseSchool][causename]" type="text" id="causeName" value="<?php echo $this->Session->read('findcause.causename');?>" />
        <input type="image" src="../img/search-btn.png" />
      </div>
      <div id="availability">
        <label>Select by School:</label>
        <select name="data[CauseSchool][schoolid]">
        <option value="">---- Select school here ----</option>
        <?php
        foreach($allschool as $as)
        {
		?>
        <option value="<?php echo $as['School']['id'];?>" 
        <?php
        if($schoolid == $as['School']['id'])
		{
			echo "selected=\"selected\"";
		}
		?> ><?php echo $as['School']['school_name'];?></option>
        <?php
        }
		?>
        </select>
    </div>
    </div>
    
    </form>
    
    
    
    <div id="pagingDivParent">
        	
        
        <?php
        if(count($filtercause))
		{
			echo $this->element('frontend/members/newfindcause');
		}	
		?>
        </div>
    
    
    
    
    
    
  </div>
</div>

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
