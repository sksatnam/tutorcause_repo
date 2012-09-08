<script type="text/javascript">	
$(document).ready(function () {
	$('#menu').tabify();
	$('#menu2').tabify();
});
</script>
<style type="text/css" media="screen">
	body { font: 0.8em Arial, sans-serif; }
</style>
<div class="public_profile_main_cointainer">
	<div class="public_profile_cointainer">
    	<div class="public_profile_cointainer_Ist">
        	<div class="profileImage">
				<?php
					if(isset($this->data['UserImage']['image_name'])){
						echo $html->image("members/".$this->data['UserImage']['image_name'],array('class'=>'profile-img-class'));
					} else {
						echo $html->image("profile-photo.png",array('class'=>'profile-img-class'));
					}
				?>
				<?php //echo $html->image("profile-photo.png",array('class'=>'profile-img-class')) ?>
				<?php // echo $html->image("4-STAR.png")?>
			</div>
            <HR style="color:#fff; width:auto;" />
			<div style="clear:both"></div>
			<div id="errorMsg"></div>
			<div class="imageChange">Change Profile Picture</div>
            
            <?php 
            echo $html->link('Registration',array('controller'=>'Members', 'action'=>'regmember'));
			echo '<br />';
			echo $html->link('Payment info',array('controller'=>'Members', 'action'=>'tutorPayment'));
			echo '<br />';
			echo $html->link('Availablity info',array('controller'=>'Members', 'action'=>'calendar'));
			echo '<br />';
			echo $html->link('Add Courses',array('controller'=>'Members', 'action'=>'schoolinfo'));
			echo '<br />';
			echo $html->link('Non-Profit Requests ('.$CountRequest.')',array('controller'=>'Members', 'action'=>'causeRequest'));
			echo '<br />';
			?>

		</div> 
        <div id="contentRgt">
        	<div class="top-heading">
            	Paymeny History
            </div>
            <div class="top-div-outr">
            	<p>Archived Transactions:</p>
                <select>
                	<option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
                <select>
                	<option value="2010">2010</option>
                    <option value="2011">2011</option>
                </select>
                <span><a href="#">back to My Account</a></span>
            </div>
            <div class="payment-table">
            	<div class="top-container">
                	<ul>
                    	<li>Date</li>
                        <li>Type</li>
                        <li>Other party</li>
                        <li>Detail</li>
                        <li>Amount</li>
                        <li>Balance</li>
                    </ul>
                </div>
                <div class="top-container1">
                	<ul>
                    	<li>Aug 05, 2011</li>
                        <li>Bonus From</li>
                        <li>VirtaPay</li>
                        <li><a href="#">Detail</a></li>
                        <li>Amount</li>
                        <li>Balance</li>
                    </ul>
                </div>
                <div class="top-container2">
                	<ul>
                    	<li>Aug 06, 2011</li>
                        <li>Bonus From</li>
                        <li>VirtaPay</li>
                        <li><a href="#">Detail</a></li>
                        <li>Amount</li>
                        <li>Balance</li>
                    </ul>
                </div>
                <div class="top-container3">
                	<ul>
                    	<li>Aug 07, 2011</li>
                        <li>Bonus From</li>
                        <li>VirtaPay</li>
                        <li><a href="#">Detail</a></li>
                        <li>Amount</li>
                        <li>Balance</li>
                    </ul>
                </div>
                <div class="top-container4">
                	<ul>
                    	<li>Aug 08, 2011</li>
                        <li>Bonus From</li>
                        <li>VirtaPay</li>
                        <li><a href="#">Detail</a></li>
                        <li>Amount</li>
                        <li>Balance</li>
                    </ul>
                </div>
                
            	
            </div>
        </div>           
    </div>
</div>
