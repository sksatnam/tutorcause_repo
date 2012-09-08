<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=229378733769669";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>






<script type="text/javascript">
function validateEmail(elementValue){
   var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
   return emailPattern.test(elementValue);
 }
 
 function validateName(elementValue){
   var namePattern = /^[a-zA-Z\s ]+$/;
   return namePattern.test(elementValue);
 }
 

 
$(document).ready(function(){
	$('#name').keyup(function(e){
		var lenname = $('#name').val().length;
		var zipCode = $('#name').val();
		zipCode0 = zipCode.substring(0,1);
		zipCode1 = zipCode.substring(1,lenname+1);
		//alert(zipCode0);
		//alert(zipCode1);
		if(lenname<1 && e.keyCode == 32){
			$('#name').val('');
			return false;
		
		}
		else if (e.keyCode == 32 && zipCode0==' ') {
			var finalValue=$.trim(zipCode);
			finalValue.replace('  ',' ');
			finalValue.replace('  ',' ');
			finalValue=$.trim(zipCode);
			$('#name').val(finalValue);
			return false;
		}
		
	
	});
	$('#notice_band').submit(function(){
		if($.trim($('#name').val()) == "" || $.trim($('#name').val()) == "Enter Your Name:"){
			alert('Please enter your name');
			return false;
		}
		 else if(validateName($.trim($('#name').val())) === false){
			alert('Please enter a letters only');
			return false;
		}
		
		if($.trim($('#email').val()) == "" || $.trim($('#email').val()) == "Enter Your Email:"){
			alert('Please enter your email');
			return false;
		} else if(validateEmail($.trim($('#email').val())) === false){
			alert('Please enter a valid email');
			return false;
		}
		if($.trim($('#school').val()) == ""){
			alert('Please select a school');
			return false;
		}
		return true;
	});
	$('#flashMessage').delay(6000).slideUp('slow');

});
</script>
<style type="text/css">
#middlecontent{
	background: none !important;
	border: 0px solid #CCCCCC !important;
}
#flashMessage {
   background-color: #D3FCFE !important;
   border: 2px solid #2AAFEA !important;
   color: #1A7097 !important;
   font-family: tahoma,verdana,arial,sans-serif;
   font-size: 15px !important;
   font-weight: bold !important;
   margin-bottom: 11px !important;
   margin-top: -48px !important;
   padding: 4px !important;
   text-align: center !important;
</style>

<?php /*?>
<?php  echo $this->Session->flash(); ?>
<div id="form-wrap">
	<div id="main-heading">
	TutorCause is currently only available at Indiana University Bloomington.<br />
	Want to be notified when we launch on your campus?
	</div>
  <div id="form">
	 <?php echo $form->create('members', array('action' => 'index','admin'=> false,'id'=>'notice_band')); ?>
		<input type="text" onblur="if(this.value==''){this.value='Enter Your Name:'}" onfocus="if(this.value=='Enter Your Name:'){this.value=''}" title="Enter Your Name Here" id="name" name="data[UpcomingMember][name]" value="Enter Your Name:">
		<input type="text" onblur="if(this.value==''){this.value='Enter Your Email:'}" onfocus="if(this.value=='Enter Your Email:'){this.value=''}" title="Enter Your Email Id Here" id="email" name="data[UpcomingMember][email]" value="Enter Your Email:" >
		<select title="Select Your School Here" name="data[UpcomingMember][upcoming_school_id]" id="school">
		  <option value="">---- Select School ----</option>
		  <?php foreach($schools as $key=>$value) { ?>
			<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
		  <?php } ?>
		</select>
		<input type="image" title="Submit" src="<?php echo HTTP_ROOT;?>/img/frontend/submit-btn.png">
	</form>
	</div>
	<div style="clear:both"></div>
	
</div>

<?php */?>
<div id="banner">
	<div id="register-wrap">
    	<a id="register-btn" title="Register Now" href="<?php echo HTTP_ROOT.'members/select_type'; ?>"></a>
        <div id="btn-shadow"></div>
        <div id="like-btn">
		
		
		<div class="fb-like" data-href="http://facebook.com/tutorcause" data-send="false" data-layout="button_count" data-width="80" data-show-faces="true" style="top:-3px;"></div>
		
		<a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="tutorcause" data-related="neilkelty:Neil Kelty">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
		
		
		
        	
        </div>
    </div>
</div>


