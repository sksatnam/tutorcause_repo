

<style type="text/css">
/*.error{padding-left:269px;} 
.dp_main{margin:15px 10px 15px 10px;border:1px solid #A0D7F3;background-color:#FAFDFE}
.dp_img{float:left;margin:12px;border:1px solid #CcC;padding:2px;background-color:#FFF;min-width:30px;min-height:30px;}
.dp_img img{max-width:100px;max-height:120px}
.dp_right{float:left;width:283px;margin:12px;background-color:#FFF}
.dp_info{height:80px;border:1px solid #CcC}
.dp_info li{list-style:none;margin:4px 2px 2px 15px}
.dp_action{margin-top:10px;}*/
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
   width:390px;
}
</style>



<div id="content-center">
                      <?php echo $this->Session->flash(); ?>
                   	    <div id="content-wrap">
                        
                            	<h1>Add Funds</h1>
                                
 <?php echo $form->create('Member', array("url" => $html->url(array('action'=>'parent_stripe_sucess2'), true),'id'=>'stripepayment')); ?>
 
<?php /*?>   <form name="form1" method="post" action="<?php echo HTTP_ROOT.'members/parent_stripe_sucess2';?>" id="stripepayment"><?php */?>
                            
                                <div id="contact-wrap">
                                
                                
                                <!--Payment Form Begin Here-->
                                
                               	     
                                  <div id="contact-left" class="add-from">
                                  
                                    <?php echo $cms_add_fund_data['Page']['body']; ?>
                                  
                                        <div id="add-form-wrap">
                                        	
                                            <div class="element">
                                                 <label><b>Amount:<span class="red" >*</span></b></label>
                                                 <input type="text" name="amount" size="5" maxlength="6" class="required digits">
                                            </div>
                                            
                                            <div class="element">
                                                <label>
                                                <b>
                                               Name:<span class="red" >*</span></b></label>
                                                <input type="text" name="parentname" size="30" maxlength="30" class="lettersonly required" value="<?php
                                                if($this->Session->read('Member.memberid'))
													{
													echo $studentdata['userMeta']['fname'].' '.$studentdata['userMeta']['lname'];   
													}
                                                ?>" >
                                            </div>
                                            
                                             
                                            <div class="fund-btn-wrap">
                                            	<input type="checkbox" name="tos" class="payment_cardcode required" value="1"> 
                                            	<label id="authorize" for="authorize">I authorize TutorCause to charge my credit card <span>*</span> </label>
                                                                                              
                                            </div>
                                            <span class="error" htmlfor="tos" generated="true" style="margin-top:-22px;"></span>  
                                            
                                            <div class="fund-btn-wrap">
                                                <input type="submit" name="submit-button" value="Submit and charge Card" class="fund-btn"/>
                                                <input type="button" name="" value="Cancel" class="fund-btn" onclick="history.go(-1);"/>
                                            </div>
                                        </div>
                                      
                                 
                                    
                                    </div>
                                 
                                    <!--Payment Form End Here-->
                                     <span class="payment-errors"></span>
                                </div>
                                
                             
                                <?php echo $form->end(); ?>
                                
                            </div>
                       
                        </div>
  
  <script>if (window.Stripe) $("#stripepayment").show()</script>
  <noscript><p>JavaScript is required for the payment form.</p></noscript>



      