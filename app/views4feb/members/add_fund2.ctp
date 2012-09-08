

<style type="text/css">
/*.error{padding-left:269px;} */
.dp_main{margin:15px 10px 15px 10px;border:1px solid #A0D7F3;background-color:#FAFDFE}
.dp_img{float:left;margin:12px;border:1px solid #CcC;padding:2px;background-color:#FFF;min-width:30px;min-height:30px;}
.dp_img img{max-width:100px;max-height:120px}
.dp_right{float:left;width:283px;margin:12px;background-color:#FFF}
.dp_info{height:80px;border:1px solid #CcC}
.dp_info li{list-style:none;margin:4px 2px 2px 15px}
.dp_action{margin-top:10px;}
</style>
<div id="content">
	<?php echo $this->Session->flash(); ?>
    
    
    
    <div class="payment_form">
  <!--  <h2 style="margin-left:0px;"> First Data Global Gateway Connect Order Form</h2>--> 
    
<form name="form1" method="post" action="<?php echo HTTP_ROOT.'members/stripe_sucess2';?>" id="stripepayment">

   <div class="main_Form">
    
       <div class="main_form_detail1">
           
           <div class="main_form_field">
             <label><b>Amount:<span class="red" >*</span></b></label>
             <input type="text" name="amount" size="5" maxlength="6" class="required digits">
           </div>
            
            <div class="main_form_field">
              <label>
              <b>
              <?php
			   if(!$this->Session->read('Member.memberid'))
			   {
				   echo 'Parent';
			   }
			   ?> Name:<span class="red" >*</span></b></label>
              <input type="text" name="parentname" size="30" maxlength="30" class="lettersonly required" value="<?php
			  if($this->Session->read('Member.memberid'))
			   {
				 echo $studentdata['userMeta']['fname'].' '.$studentdata['userMeta']['lname'];   
			   }
              ?>" >
           </div>
           
           
           <?php
		   if(!$this->Session->read('Member.memberid'))
		   {
		   ?>
           <div class="main_form_field">
              <label><b>Student Email:<span class="red" >*</span></b></label>
              <input type="text" name="studentemail" class="required email" maxlength="75">
           </div>
           <?php
		   }
		   ?>
           
           
<!--   <input type="checkbox" name="tos" value="1" class="required" />-->
         
           
         <div class="main_form_field" >
         
         <label style="width:392px;"><b>I authorize TutorCause to charge my credit card:<span class="red" >*</span></b></label>
         <input type="checkbox" name="tos" class="payment_cardcode required" value="1"> 
         
         </div> 
            
           
       </div>
       
       
       
        <div style="margin:0px 0px 10px 310px;" class="stepFormContButton">
            <span></span>
           <input type="submit" value="Submit and Charge Card" name="submit-button"> 
        </div>
       
       
           
       
<!--       <div style="margin:0px 0px 0px 251px;" class="stepFormContButton button">
            <span></span>
            <input type="submit" value="Submit and Charge Card" name="submit-button"> 
        </div>
-->        
         <span class="payment-errors"></span>
        
        
   </div>


   
</FORM>   
 </div>
</div>  
  <script>if (window.Stripe) $("#example-form").show()</script>
  <noscript><p>JavaScript is required for the payment form.</p></noscript>



      