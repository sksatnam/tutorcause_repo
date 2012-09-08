<?php
if($countMsg>0){
	$countMsg = "(".$countMsg.")";
} else {
	$countMsg = "";
}
?>
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
<?php	echo $this->Session->flash(); ?>




	<div class="public_profile_cointainer">
    	<div class="public_profile_cointainer_Ist">
        	<div class="profileImage">
				<?php
					if(isset($this->data['UserImage']['image_name'])){
						echo $html->image("members/".$this->data['UserImage']['image_name']);
					} else {
						?>
                        	 <img src="https://graph.facebook.com/<?php echo $this->Session->read('Member.id'); ?>/picture?type=large"  />
                     <?php        
					}
				?>
			</div>
          
			<div style="clear:both"></div>
			<div id="errorMsg"></div>
			<div class="imageChange">Change Profile Picture</div>
            <br />
            <?php
			echo $html->image('frontend/message.jpg',array('style'=>'width:25px;margin:4px 0px 0px 15px'))."&nbsp;".$html->link('Message '.$countMsg,array('controller'=>'members', 'action'=>'messages'));
			echo '<div style="clear:both"></div>';
			echo $html->image('frontend/edit_profile.png',array('style'=>'width:25px;margin:4px 0px 0px 15px'))."&nbsp;".$html->link('Edit Profile',array('controller'=>'members', 'action'=>'regmember',$this->Session->read('Member.memberid')));
			echo '<div style="clear:both"></div>';
			echo $html->image('frontend/payment_icon.gif',array('style'=>'width:25px;margin:4px 0px 0px 15px'))."&nbsp;".$html->link('Edit Payment detail',array('controller'=>'members', 'action'=>'tutor_payment',$this->Session->read('Member.memberid')));
			echo '<div style="clear:both"></div>';
			echo $html->image('frontend/availability_icon.gif',array('style'=>'width:25px;margin:4px 0px 0px 15px'))."&nbsp;".$html->link('Edit Availablity',array('controller'=>'members', 'action'=>'calendar',$this->Session->read('Member.memberid')));
			echo '<div style="clear:both"></div>';
			echo $html->image('frontend/edit_course.jpg',array('style'=>'width:25px;margin:4px 0px 0px 15px'))."&nbsp;".$html->link('Edit Courses',array('controller'=>'members', 'action'=>'editschoolinfo'));
			echo '<div style="clear:both"></div>';
			echo $html->image('frontend/request.png',array('style'=>'width:25px;margin:4px 0px 0px 15px'))."&nbsp;".$html->link('Non-Profit Requests ('.$CountRequest.')',array('controller'=>'members', 'action'=>'non_profit_request'));
			echo '<div style="clear:both"></div>';
			echo $html->image('frontend/session.png',array('style'=>'width:25px;margin:4px 0px 0px 15px'))."&nbsp;".$html->link('Session Request ('.$SessionRequest.')',array('controller'=>'members', 'action'=>'session_request'));
			echo '<br />';
			?>

		</div>            
        <div class="public_profile_cointainer_IInd">
        	<ul id="menu" class="menu">
			<li class="active"><a href="#description">Limerick One</a></li>
			<li><a href="#usage">Limerick Two</a></li>
			<li><a href="#download">Limerick Three</a></li>
            <li><a href="#four">Limerick four</a></li>
		</ul>
		<div id="description" class="content">
			<h2 style="color:#219eda; font-size:32px;">Limerick One</h2>
			<p>
				Tutor Profile Page
			</p>
            
		</div>
		<div id="usage" class="content">
			<h2 style="color:#219eda; font-size:32px;">Limerick Two</h2>
			<p>

				Let my viciousness be emptied,<br />
			    Desire and lust banished,<br />
			    Charity and patience,<br />
			    Humility and obedience,<br />
			    And all the virtues increased.
			</p>
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
		</div>

		<div id="download" class="content">
			<h2 style="color:#219eda; font-size:32px;">Limerick Three</h2>
			Hickere, Dickere Dock,<br />
		    A Mouse ran up the Clock,<br />
		    The Clock Struck One,<br />
		    The Mouse fell down,<br />

		    And Hickere Dickere Dock.
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
		</div>
        <div id="four" class="content">
			<h2 style="color:#219eda; font-size:32px;">Limerick four</h2>
			<p>

				Let my viciousness be emptied,<br />
			    Desire and lust banished,<br />
			    Charity and patience,<br />
			    Humility and obedience,<br />
			    And all the virtues increased.
			</p>
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
			<p>
				The limerick packs laughs anatomical<br />
			    In space that is quite economical,<br />

			    But the good ones I've seen<br />
			    So seldom are clean,<br />
			    And the clean ones so seldom are comical.
			</p>
		</div>
		
		
        </div>
        <div class="public_profile_cointainer_IIIrd">
        	<div style="border: 2px solid rgb(204, 204, 204); margin-bottom: 35px;">
				<div style="background-color:#168fd0; border-bottom: 2px solid rgb(204, 204, 204); color: rgb(238, 238, 238); font-family: verdana,tahoma,sans-serif; font-size: 14px; font-weight: bold; padding: 3px 15px; text-align: center;">Account Balance</div>
				<div style="background-color: rgb(238, 238, 238); color: rgb(0, 153, 0); font-family: verdana,tahoma,trebuchet MS,helvetica,sans-serif; font-size: 28px; padding: 5px;">
				  <div style="background-color: rgb(255, 255, 255); -moz-border-radius: 8px 8px 8px 8px; padding: 0px 5px 5px; text-align: center;">$<?php echo $getBalance['Member']['balance']?></div>
				</div>
			</div>
        	<!--<div class="public_profile_cointainer_add-1">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>
        	<div class="public_profile_cointainer_add-2">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>
        	<div class="public_profile_cointainer_add-3">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>
        	<div class="public_profile_cointainer_add-1">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>
        	<div class="public_profile_cointainer_add-2">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>
            <div class="public_profile_cointainer_add-3">
            	<h2 style="font-size:24px; color:#fff;">Advertisement</h2>
            </div>-->
        </div>
    </div>
</div>