<?php
$checked = "";$checked2="";
if(count($schools)>0){
	$checked2 = "checked";
} else { $checked="checked";
}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#schoolid option').click(function(){
		$("#optional").attr('checked','checked');
		$("#all").removeAttr('checked');
	})
	$("input[name='data[CauseSchool][check]']").click(function(){
		if($("input[name='data[CauseSchool][check]']:checked").val() == 'all'){
			$('#schoolid option').removeAttr('selected');
			$('#schoolid option').removeProp('selected');
			$('#schoolid').attr('disabled','disabled');
		} else {
			$('#schoolid').removeAttr('disabled');
		}
	})
});
function checkOptions(){
	if ($("input[name='data[CauseSchool][check]']:checked").val() == 'all') {
		return true;
	}
	else {
		if($('#schoolid').val() == null){
			alert('Please select school');
			return false;
		}
		return true;
	}
}
</script>
<style type="text/css">
.error{
	padding-left:150px;
	}
</style>

<div id="content">
	<div class="stepsHeadingNew">
		<div class="newProgressBarOuter">
			<div class="proBarsSection1">
				<span class="spanNo">1</span>
				<span class="spanOnHover">Registration</span>

			</div>
			<div class="proBarsSection2">
				<span class="spanNo">2</span>
				<span class="spanOnHover">School info</span>
			</div>
			
		</div>
		<h1>Cause School Info</h1>
	</div>
   
	 <?php echo $this->Form->create('Member', array('id' => 'Ca1useschool','onSubmit'=>'return checkOptions();' )); // 'action' => 'causeschoolsave' ?>
	<div class="school-info-field" style="margin-bottom:20px">
    
    <div class="stepThreeFormRow">
    
    <label><b>Paypal Email<span class="red" >*</span></b></label>
		<input type="text" name="data[Member][paypalEmail]" class="textInStepFrm required
		email" value="<?php echo $memberdata['Member']['paypalEmail'];?>"  />   
        
        </div>
    
    
	<div class="stepThreeFormRow">
    
		<label><b>Cause name<span class="red" >*</span></b></label>
		<input type="text" name="data[CauseSchool][name]" class="textInStepFrm required lettersonly" maxlength="75" value="<?php echo $memberdata['userMeta']['cause_name'];?>"  />   
		</div>
        </div>
        <br/>
        <br/>
		
		<div class="fieldContainerByDpkMahendru" >
                    			<div style="margin-left:450px; float:left" >
                                
                                
                                <input type="radio"  name="data[CauseSchool][check]" id="all" value="all" <?php echo $checked; ?> /></div>
                              
                        		<div style "padding-left:100px"><label><h1><b  style="padding-left: 20px;">All Schools</b></h1></label></div>
                    			</div>
                   	 <div class="fieldContainerByDpkMahendru" style="padding-left:300px">
                        <label><h1><b  style="padding-left: 230px;">OR</b></h1></label>                
                   	 </div>
                   
                        <div class="fieldContainerByDpkMahendru" style="margin-bottom:30px">
                        <div style="margin-left:450px; float:left">
                        <input type="radio"  name="data[CauseSchool][check]" id="optional" value="optional" <?php echo $checked2;?> />
                       </div>
                       <div style="float:left; padding-right:75px">
                       <label><h1><b style="padding-left: 20px;">Multiple Schools</b></h1></label>
                       </div>
                        </div>
                        <div>
                         <div class="fieldContainerByDpkMahendru" style="margin-bottom:40px; margin-left:70px">
                    	<label style="font-size:12px; float:left; width:600px; padding-left:400px;"> (Press Ctrl key to select multiple schools)</label>
                    	
                        </div>
                       <br/>
                       <br/>
                      <div class="stepThreeFormRow"> 
                       
                       <div style="margin-left:403px;">
                        <select multiple="multiple" size="5" name="data[CauseSchool][school_id][]" id="schoolid" style="width: 22em;">
                        <?php foreach($schoolname as $key=>$value){ ?>
				<option value="<?php echo $key;?>" <?php if(in_array($key,$schools)){ echo "selected"; } ?>><?php echo $value;?></option>
			<?php } ?>
                        </select>
                        </div>
                        
                        
                   		 </div>
                         
                         </div>
                         
                         <div class="stepFormContButton button" style="margin:10px 0px 20px 510px; ">

		<span></span>
		<input type="submit" value="Submit" /> 
	</div>
                         
      <?php echo $this->Form->end(); ?>                     
	</div>
