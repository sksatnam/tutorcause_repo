  <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <script type="text/javascript">
		
          Stripe.setPublishableKey('pk_Oos0jK3pJdvvLb9FC8ATzRihpvw93');
            $(document).ready(function() {
                function addInputNames() {
                    // Not ideal, but jQuery's validate plugin requires fields to have names
                    // so we add them at the last possible minute, in case any javascript 
                    // exceptions have caused other parts of the script to fail.
                    $(".card-number").attr("name", "card-number")
                    $(".card-cvc").attr("name", "card-cvc")
                    $(".card-expiry-year").attr("name", "card-expiry-year")
                }

                function removeInputNames() {
                    $(".card-number").removeAttr("name")
                    $(".card-cvc").removeAttr("name")
                    $(".card-expiry-year").removeAttr("name")
                }

                function submit(form) {
                    // remove the input field names for security
                    // we do this *before* anything else which might throw an exception
                    removeInputNames(); // THIS IS IMPORTANT!

                    // given a valid form, submit the payment details to stripe
                    $(form['submit-button']).attr("disabled", "disabled")

                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(), 
                        exp_year: $('.card-expiry-year').val()
                    }, 100, function(status, response) {
                        if (response.error) {
                            // re-enable the submit button
                            $(form['submit-button']).removeAttr("disabled")
        
                            // show the error
                            $(".payment-errors").html(response.error.message);

                            // we add these names back in so we can revalidate properly
                            addInputNames();
                        } else {
                            // token contains id, last4, and card type
                            var token = response['id'];

                            // insert the stripe token
                            var input = $("<input name='stripeToken' value='" + token + "' style='display:none;' />");
                            form.appendChild(input[0])

                            // and submit
                            form.submit();
                        }
                    });
                    
                    return false;
                }
                
                // add custom rules for credit card validating
                jQuery.validator.addMethod("cardNumber", Stripe.validateCardNumber, "Please enter a valid card number");
                jQuery.validator.addMethod("cardCVC", Stripe.validateCVC, "Please enter a valid security code");
                jQuery.validator.addMethod("cardExpiry", function() {
                    return Stripe.validateExpiry($(".card-expiry-month").val(), 
                                                 $(".card-expiry-year").val())
                }, "Please enter a valid expiration");

                // We use the jQuery validate plugin to validate required params on submit
                $("#example-form").validate({
                    submitHandler: submit,
                    rules: {
                        "card-cvc" : {
                            cardCVC: true,
                            required: true
                        },
                        "card-number" : {
                            cardNumber: true,
                            required: true
                        },
                        "card-expiry-year" : "cardExpiry" // we don't validate month separately
                    }
                });

                // adding the input field names is the last step, in case an earlier step errors                
                addInputNames();
            });
        </script>


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
    
<form name="form1" method="post" action="<?php echo HTTP_ROOT.'members/stripe_sucess';?>" id="example-form">

   <div class="main_Form">
    
       <div class="main_form_detail1">
           <div class="main_form_field">
               <label><b>Card Number:<span class="red" >*</span></b></label>
                <input type="text" maxlength="20" autocomplete="off" class="card-number stripe-sensitive required digits" />
           </div>
           
           <div class="main_form_field">
             <label><b>CVC:<span class="red" >*</span></b></label>
             <input type="text" maxlength="4" autocomplete="off" class="card-cvc stripe-sensitive required digits" />
           </div>  
           
           
           <div class="main_form_field">
                <label><b>Expiration:<span class="red" >*</span></b></label>
                <div class="payment_chkbox">
                    <select class="card-expiry-month stripe-sensitive required">
                    </select>
                    <script type="text/javascript">
                        var select = $(".card-expiry-month"),
                            month = new Date().getMonth() + 1;
                        for (var i = 1; i <= 12; i++) {
                            select.append($("<option value='"+i+"' "+(month === i ? "selected" : "")+">"+i+"</option>"))
                        }
                    </script>
                   
                    <select class="card-expiry-year stripe-sensitive required"></select>
                    <script type="text/javascript">
                        var select = $(".card-expiry-year"),
                            year = new Date().getFullYear();

                        for (var i = 0; i < 12; i++) {
                            select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
                        }
                    </script>
                </div>
            </div>
           
           
           <div class="main_form_field">
              <label><b>Amount:<span class="red" >*</span></b></label>
             <input type="text" name="amount" size="5" maxlength="6" class="required digits">
           </div>
            
            <div class="main_form_field">
              <label>
              <?php
			   if(!$this->Session->read('Member.memberid'))
			   {
				   echo 'Parent';
			   }
			   ?> <b>Name:<span class="red" >*</span></b></label>
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
              <input type="text" name="studentemail" maxlength="75" class="required email">
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
       
       
       
       <!--<div style="margin:0px 0px 0px 251px;" class="stepFormContButton button">
            <span></span>
            <input type="submit" value="Submit and Charge Card" name="submit-button"> 
        </div>-->
        
         <span class="payment-errors"></span>
        
        
   </div>
   
</FORM>   
 </div>
</div>  
  <script>if (window.Stripe) $("#example-form").show()</script>
  <noscript><p>JavaScript is required for the payment form.</p></noscript>



      