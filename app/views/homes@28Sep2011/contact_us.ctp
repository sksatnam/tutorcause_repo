<?php //3aug2012 ?><script type="text/javascript">
$().ready(function(){
	$("#contactusform").validate({
		rules:
		{
			"data[ContactUsMessage][first_name]":
			{
				required:true			
			},
			"data[ContactUsMessage][last_name]":
			{
				required:true		
			},
			"data[ContactUsMessage][email]":
			{
				required:true,
				email:true
			},
			"data[ContactUsMessage][confirm_email]":
			{
				required:true,
				email:true,
				//remote:ajax_url+"/members/checkMemberExist?memberid="+memberid
			},
			"data[ContactUsMessage][message]":
			{
				required:true,
				//number: true
			}
		},
		messages:
		{
			"data[ContactUsMessage][first_name]":
			{
				required:"First Name cannot be blank"
			},
			"data[ContactUsMessage][last_name]":
			{
				required:"Last Name cannot be blank "
			},
			"data[ContactUsMessage][email]":
			{
				required:"Please enter your email",
				email: "Please enter a valid email address"
			},
			"data[ContactUsMessage][confirm_email]":
			{
				required:"Please confirm your email",
				email: "Please enter a valid email address",
			},
			"data[ContactUsMessage][message]":
			{
				required: "Please enter your query"
				
			}
			
		}
									
	});	
});
</script>
<div style="float:left; width:960px; margin:15px 0; border:1px solid #ccc; border-radius:5px; -moz-border-radius:5px; padding: 20px; width: 920px;">
	<div style="width:700px;text-align:center;">
		<div class="message" id="flashmsg"><b><?php echo $this->Session->flash(); ?></b></div>
	</div>
<div id="contact">	<!--cntcthding-->
	<div class="cntcthding">	
		Contact Us	
	</div>	<!--cntcthding-->
	
	<div class="cntctFrmContnr">	<!--cntctFrmContnr-->
		<form id="contactusform" name="contactusform" method="post" enctype="multipart/form-data" action="<?=HTTP_ROOT?>homes/save_message">
		<!--cntctNmeCntnr-->
		<div class="cntctNmeCntnr">
			<div class="cntctNme">
				First Name:
                <span style="color:#F00" >*</span>
			</div>
			<div class="cntctNmeTxtFld" style="width:380px;">
				<input class="cntctTxtfld" type="text" name="data[ContactUsMessage][first_name]" />
			</div>
		</div>
		<!--cntctNmeCntnr-->
		<!--cntctNmeCntnr-->
		<div class="cntctNmeCntnr">
			<div class="cntctNme">
				Last Name:
                <span style="color:#F00" >*</span>
			</div>
			<div class="cntctNmeTxtFld" style="width:380px;" >
				<input class="cntctTxtfld" type="text" name="data[ContactUsMessage][last_name]" />
			</div>
		</div>
		<!--cntctNmeCntnr-->
		<!--cntctNmeCntnr-->
		<div class="cntctNmeCntnr">
			<div class="cntctNme">
				Email:
                <span style="color:#F00" >*</span>
			</div>
			<div class="cntctNmeTxtFld" style="width:380px;" >
				<input class="cntctTxtfld" type="text" name="data[ContactUsMessage][email]" />
			</div>
		</div>
		<!--cntctNmeCntnr-->
		<!--cntctNmeCntnr-->
		<div class="cntctNmeCntnr">
			<div class="cntctNme ">
				Confirm Email:
                <span style="color:#F00" >*</span>
			</div>
			<div class="cntctNmeTxtFld" style="width:380px;">
				<input class="cntctTxtfld" type="text" name="data[ContactUsMessage][confirm_email]" />
			</div>
		</div>
		<!--cntctNmeCntnr-->
		
		<!--cntctNmeCntnr-->
		<div class="cntctNmeCntnr">
			<div class="cntctNme">
				Message:
             <span style="color:#F00" >*</span>
			</div>
			<div class="cntctNmeTxtAra">
				<textarea class="ctntTxtAra" cols="50" rows="10" name="data[ContactUsMessage][message]"></textarea>
			</div>
		</div>
        <div class="cntctSubmit">
        	<button type="submit" style="width:100px; height:35px; color:#666;">Submit</button>
        </div>
		<!--cntctNmeCntnr-->
		</form>
	</div>
	<!--cntctFrmContnr-->
</div>
</div>