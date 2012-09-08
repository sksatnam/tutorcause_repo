 <style>
 .element label {
    color: #727272;
    float: left;
    font-size: 17px;
    width: 140px !important;
}
span.error {
    color: red;
    float: left;
	clear:both;
   margin-left: 148px !important;
}
 </style>
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

                      <div id="content-center">
                      
                   	    <div id="content-wrap">
                        
                            	<h1>Add Funds</h1>
                                <div id="contact-wrap">
                                
                                
                                <!--Payment Form Begin Here-->
                               	  <div id="contact-left" class="add-from">
                                  
                                    <?php echo $cms_add_fund_data['Page']['body']; ?>
                                      <form name="form1" method="post" action="<?php echo HTTP_ROOT.'members/stripe_sucess';?>" id="example-form">  
                                        <div id="add-form-wrap">
                                        	<div class="element">
                                            	<label>Card Type:  <span>*</span> </label>
                                                <select id="card_type" name="card_type">
                                                	<option>Visa</option>
                                                    <option>Master Card</option>
                                                </select>
                                                <img src="<?php echo FIMAGE.'cc.jpg'?>" alt=""/>
                                            </div>
                                            <div class="element">
                                            	<label>Card Number: <span>*</span> </label>
                                               <input type="text" maxlength="20" autocomplete="off" class="card-number stripe-sensitive required digits" />
                                            </div>
                                            <div class="element">
                                            	<label>CVC: <span>*</span> </label>
                                                <input id="ccv" type="text" maxlength="4" autocomplete="off" class="card-cvc stripe-sensitive required digits" />
                                                <img src="<?php echo FIMAGE.'ccv-card.png'?>" alt=""/>
                                                <span class="error" htmlfor="ccv" generated="true"></span>
                                            </div>
                                            <div class="element">
                                            	<label>Expiration: <span>*</span> </label>
                                                <select class="card-expiry-month stripe-sensitive required">
												<script type="text/javascript">
                                                var select = $(".card-expiry-month"),
                                                month = new Date().getMonth() + 1;
                                                for (var i = 1; i <= 12; i++) {
                                                select.append($("<option value='"+i+"' "+(month === i ? "selected" : "")+">"+i+"</option>"))
                                                }
                                                </script>
                                                	
                                                </select>
                                                
                                                <select  class="card-expiry-year stripe-sensitive required">
                                                </select>
												<script type="text/javascript">
                                                var select = $(".card-expiry-year"),
                                                year = new Date().getFullYear();
                                                
                                                for (var i = 0; i < 12; i++) {
                                                select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
                                                }
                                                </script>
                                            </div>
                                            
                                            <div class="element">
                                            	<label>Amount: <span>*</span> </label>
                                                <input type="text" name="amount" size="5" maxlength="6" class="required digits">
                                            </div>
                                            
                                            <div class="element">
                                            	<label><?php
			   if(!$this->Session->read('Member.memberid'))
			   {
				   echo 'Parent';
			   }
			   ?> Name: <span>*</span></label>
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
                                            <div class="element">
                                            	<label>Student Email: <span>*</span> </label>
                                                <input type="text" name="studentemail" maxlength="75" class="required email">
                                            </div>
											<?php
                                            }
                                            ?>
                                            
                                            <div class="fund-btn-wrap">
                                            	
                                            	  <input type="checkbox" name="tos" class="payment_cardcode required" value="1"> 
                                            	<label id="authorize" for="authorize">I authorize TutorCause to charge my credit card <span>*</span> </label>
                                                                                              
                                            </div>
                                            <span class="error" htmlfor="tos" generated="true" style="margin-top:-22px;"></span>  
                                            
                                            <div class="fund-btn-wrap">
                                                <input type="submit" name="" value="Submit and charge Card" class="fund-btn"/>
                                                <input type="button" name="" value="Cancel" class="fund-btn" onclick="history.go(-1);"/>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    </form>
                                    <!--Payment Form End Here-->
                                  
                                </div>
                                
                            </div>
                            
                        
                       
                        </div>
  <script>if (window.Stripe) $("#example-form").show()</script>
  <noscript><p>JavaScript is required for the payment form.</p></noscript>



      