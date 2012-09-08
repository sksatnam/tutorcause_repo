<div id="content">
            	<div class="stepsHeadingNew">
                    
                        <div class="newProgressBarOuter">
                        	<div class="proBarsSection1">
                            	<span class="spanNo">1</span>
                                <span class="spanOnHover">Select Course</span>

                            </div>
                            <div class="proBarsSection1">
                            	<span class="spanNo">2</span>
                                <span class="spanOnHover">Scheduling an Appointment</span>
                            </div>
                            <div class="proBarsSection2">
                            	<span class="spanNo">3</span>
                                <span class="spanOnHover">Paying for an Appointment</span>
                            </div>
                             <div class="proBarsSection3">
                            	<span class="spanNo">4</span>
                                <span class="spanOnHover">Rate Tutor</span>
                            </div>
                            
                        </div>
                    
                    <h1>Paying for an Appointment</h1>
                </div>
                 
             	
                <div class="school-info-field">
                
                <div class="stepThreeFormRow">
                         <label style="font-weight:bold;">Course Code</label>
                         <label><?php echo $this->Session->read('booktutor.coursename');?></label> 
                 </div>
                 
                 <div class="stepThreeFormRow">
                         <label style="font-weight:bold;">Price/Hour</label>
                         <label><?php echo '$ '.$this->Session->read('booktutor.rate');?></label> 
                 </div>                 
                 
                 
                 
                 <div class="stepThreeFormRow" style="width:650px;">
                         <label style="font-weight:bold;">Tutoring time</label>
                         <label style="width:auto;"> <b> Starting form </b> <?php echo date('d F Y @ G:i',strtotime($this->Session->read('booktutor.starttime')));?> <b> to </b> <?php echo date('d F Y @ G:i',strtotime($this->Session->read('booktutor.endtime')));?></label> 
                 </div>
                 
               
                 <div class="stepThreeFormRow">
                         <label style="font-weight:bold;">Hours</label>
                         <label><?php echo $this->Session->read('booktutor.tuthours');?></label> 
                 </div>
                 <div class="stepThreeFormRow">
                         <label style="font-weight:bold;">Price</label>
                         <label>
                         <?php
						 $netprice = $this->Session->read('booktutor.tuthours') * $this->Session->read('booktutor.rate');
						 echo '$ '.$netprice;
						 ?>
                         </label>
                 </div>
                 
                 
                  <div class="stepThreeFormRow">
                  
                  <form action="https://sandbox.paypal.com/cgi-bin/webscr" method="post" id="payPalForm">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="business" value="tutor_1312191284_biz@gmail.com">
<input type="hidden" name="currency_code" value="USD">
<input name="amount" type="hidden" id="amount" size="45" value="<?php echo $netprice;?>">

<?php
	 
$url = HTTP_ROOT.'members/paypal/'.$paymentid;

?>

<input type="hidden" name="notify_url" value="<?php echo $url;?>" />


<input type="hidden" name="return" value="<?php echo HTTP_ROOT?>Homes/success" />
<input type="hidden" name="cancel_return" value="<?php echo HTTP_ROOT?>Homes/failure" />
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">


</form>
                  
            
                    
                </div>
                
                    
                </div>
                
           
                
                
              
            </div>            