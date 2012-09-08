<style>
.proBarsSection2,.proBarsSection1{width:180px;}
</style>
<div id="content">
	<div class="stepsHeadingNew">
		<div class="newProgressBarOuter">
			<div class="proBarsSection1">
				<span class="spanNo">1</span>
				<span class="spanOnHover">Schedule Session</span>
			</div>
			<div class="proBarsSection1">
				<span class="spanNo">2</span>
				<span class="spanOnHover">Payment Option</span>
			</div>
			<div class="proBarsSection2">
				<span class="spanNo">3</span>
				<span class="spanOnHover">Pay for Session</span>
			</div>
		</div>
		<h1>Pay for Session</h1>
	</div>
		<?php 
		
		$netprice = $paydata['PaymentHistory']['tutoring_hours'] * $paydata['PaymentHistory']['tutor_rate_per_hour'];
		
		if($method=="paypal"){ ?>
        
        
		<div class="payment_form">
  <!--  <h2 style="margin-left:0px;"> First Data Global Gateway Connect Order Form</h2>--> 
    
<form name="form1" method="post" action="<?php echo HTTP_ROOT.'members/tutorpay';?>" id="globalpayment">

<input type="hidden" name="data[global][ordertype]" value="SALE">

    
   <div class="main_Form">
    
       <div class="main_form_detail1">
           <div class="main_form_field">
              <label>Credit Card No.:</label>
               <input type="text" name="data[global][cardnumber]" size="20" maxlength="30" class="required">
           </div>
            <div class="main_form_field">
              <label>Expires:</label>
               <div class="payment_chkbox">
                  <SELECT name="data[global][cardexpmonth]" size="1" >
                        <OPTION value="01">Jan</OPTION>
                        <OPTION value="02">Feb</OPTION>
                        <OPTION value="03">Mar</OPTION>
                        <OPTION value="04">Apr</OPTION>
                        <OPTION value="05">May</OPTION>
                        <OPTION value="06">Jun</OPTION>
                        <OPTION value="07">Jul</OPTION>
                        <OPTION value="08">Aug</OPTION>
                        <OPTION value="09">Sep</OPTION>
                        <OPTION value="10">Oct</OPTION>
                        <OPTION value="11">Nov</OPTION>
                        <OPTION value="12">Dec</OPTION>
                   </select> 
                  
                  <select NAME="data[global][cardexpyear]" SIZE="1" >
                        <option value="04"> 2004 </option>
                        <option value="05"> 2005 </option>
                        <option value="06"> 2006 </option>
                        <option value="07"> 2007 </option>
                        <option value="08"> 2008 </option>
                        <option value="09"> 2009 </option>
                        <option value="10"> 2010 </option>
                        <option value="11"> 2011 </option>
                        <option value="12"> 2012 </option>
                        <option value="13"> 2013 </option>
                        <option value="14"> 2014 </option>
                   </select> 
               </div>
           </div>
           
        <!--   <div class="main_form_field">
              <label>Card Code:</label>
              <input type="text" name="data[global][cvm]" size="4" style="width:157px;"  >
              <input type="checkbox" name="data[global][cvmnotpres]" class="payment_cardcode" value="1"> 
              <span style="margin-top:14px; margin-left:6px; float:left; width:auto;">Code not present</span> 
           </div>-->
           
            <div class="main_form_field">
              <label>Zip Code:</label>
             <input type="text" name="data[global][bzip]" size="5" maxlength="10" class="required">
           </div>
           
           <div class="main_form_field">
              <label>Amount:</label>
             <input type="text" name="data[global][chargetotal]" size="5" maxlength="6" readonly="readonly"  value="<?php echo $netprice;?>">
             
             <input type="hidden" name="data[global][paymentid]" value="<?php echo $paydata['PaymentHistory']['id'];?>"
           </div>
           
           
            
           
           
<!--   <input type="checkbox" name="tos" value="1" class="required" />-->
         
           
         <div class="main_form_field" >
         
         <label style="width:392px;">I authorize TutorCause to charge my credit card.</label>
         <input type="checkbox" name="tos" class="payment_cardcode required" value="1"> 
         
         </div> 
            
           
       </div>
       <div style="margin:0px 0px 0px 251px;" class="stepFormContButton button">
            <span></span>
            <input type="submit" value="Submit and Charge Card"> 
        </div>
        
   </div>
   
</FORM>   
 </div>
        
        
        
		<?php } else {?>
        
        <div class="school-info-field">
        
        <div class="stepThreeFormRow">
			<label style="font-weight:bold;">Course Code</label>
			<label><?php echo $paydata['PaymentHistory']['booked_course'];?></label> 
		</div>
		<div class="stepThreeFormRow">
			<label style="font-weight:bold;">Hourly Rate</label>
			<label><?php echo '$ '.$paydata['PaymentHistory']['tutor_rate_per_hour'];?></label> 
		</div>
		<div class="stepThreeFormRow" style="width:650px;">
			<label style="font-weight:bold;">Session Start</label>
			<label style="width:auto;"><?php echo date('F, d Y @ G:i a',strtotime($paydata['PaymentHistory']['booked_start_time']));?></label> 
		</div>
		<div class="stepThreeFormRow" style="width:650px;">
			<label style="font-weight:bold;">Session End</label>
			<label style="width:auto;"><?php echo date('F, d Y @ G:i a',strtotime($paydata['PaymentHistory']['booked_end_time']));?></label> 
		</div>
		<div class="stepThreeFormRow">
			<label style="font-weight:bold;">Session Length</label>
			<label><?php echo $paydata['PaymentHistory']['tutoring_hours'];?> Hours</label> 
		</div>
		<div class="stepThreeFormRow">
			<label style="font-weight:bold;">Total Session Cost</label>
			<label>
			<?php
			echo '$ '.$netprice;
			?>
			</label>
		</div>
        
        
		<div class="stepThreeFormRow">
			<?php echo $this->Form->create('Member',array('id'=>'form1','action'=>'paying_session/'.$paymentid)); ?>
			<div class="stepThreeFormRow">
				<input name="data[Member][amount]" type="hidden" id="amount" value="<?php echo $netprice;?>">
				<div class="stepFormContButton button" style="width:200px;margin-left:147px;">
					<span></span>
					<input type="submit" value="Pay" /> 
				</div>
			</div>
		</div>
        
        </div>
		<?php } ?>

</div>            