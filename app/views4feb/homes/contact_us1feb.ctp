<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
							   		initialize();
									
							   });
	var map;
	var marker;
	var latlng;
	var infoWindow;
	var overlay;
	var map_bounds;
	function initialize()
	{		

		map_bounds = new google.maps.LatLngBounds();
		
	//	51.5229224,	-0.0806551;
		
		latlng = new google.maps.LatLng(39.1715893,-86.5012502);
		 
		
		var myOptions = {
						  zoom: 15,
						  center: latlng,
						  mapTypeId: google.maps.MapTypeId.ROADMAP
						};
		map = new google.maps.Map(document.getElementById("map"),myOptions);
		
		var marker = new google.maps.Marker({
											  position: latlng, 
											  map: map
										  });
		
		
	}
</script>




<style type="text/css">
div #middlecontent{
	padding:0px !important; 
	margin:0px !important;
	}

</style>
<script type="text/javascript">
$().ready(function(){
	$("#contactusform").validate({
		rules:
		{
			"data[ContactUsMessage][first_name]":
			{
				required:true,
				letters:true			
			},
			"data[ContactUsMessage][last_name]":
			{
				required:true,
				letters:true,
						
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
				equalTo: '#confirmemail'
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
				email: "Please enter a valid email address",
				
			},
			"data[ContactUsMessage][confirm_email]":
			{
				required:"Please confirm your email",
				email: "Please enter a valid email address",
				equalTo: 'Email not Match'
			},
			"data[ContactUsMessage][message]":
			{
				required: "Please enter your query"
				
			}
			
		}
									
	});	
});
</script>



<div id="main-wrap">
    <div id="white-top"></div>
    <div id="white-center">
        <div id="pen"></div>
        <div id="content-center">
            <div id="content-wrap">
                <h1>Contact Us</h1>
                <?php	echo $this->Session->flash(); ?>
                <div id="contact-wrap">
                
                <!--Contact Left Column Begin Here-->
                    <div id="contact-left">
                    
                    <?php
					echo $statdatas[0]['Page']['body']; 
					?>
                        
                        <div id="contact-form">
                        
                        <form id="contactusform" name="contactusform" method="post" enctype="multipart/form-data" action="<?=HTTP_ROOT?>homes/save_message" > 
                       
                                              
                        
                            <div class="element">
                                <label>First Name: <span>*</span> </label>
                                <input type="text" name="data[ContactUsMessage][first_name]" value="" />
                            </div>
                            <div class="element">
                                <label>Last Name: <span>*</span> </label>
                                <input type="text" name="data[ContactUsMessage][last_name]" value="" />
                            </div>
                            <div class="element">
                                <label>Email: <span>*</span> </label>
                                <input type="text" name="data[ContactUsMessage][email]" id="confirmemail" value="" />
                            </div>
                            <div class="element">
                                <label>Confirm Email: <span>*</span> </label>
                                <input type="text" name="data[ContactUsMessage][confirm_email]"  value="" />
                            </div>
                            <div class="element">
                                <label>Message: <span>*</span> </label>
                                <textarea name="data[ContactUsMessage][message]" cols="" rows=""></textarea>
                            </div>
                            <div class="element">
                             <input type="image" src="<?php echo FIMAGE.'submit_contactus.png'?>" title="Submit"/>
                            </div>
                            
                             </form> 
                            
                            
                        </div> 
                    </div> 
                    
                    <!--Contact Left Column End Here-->
                    
                    <!--Contact Right Column Begin Here-->
                    <div id="contact-right">
                    
                        <div class="info-row">
                            <h3>Address:</h3>
                            
							<?php
                          //  echo $statdataaddress[0]['Page']['body']; 
                            ?>
                            
                            <div><strong><a href="http://maps.google.com/maps/place?ftid=0x886c66a71b2aa22b:0xc7a586e1b4f2a7e4&amp;q=2719+E+10th+street&amp;hl=en&amp;gl=us&amp;ved=0CA4Q-gswAA&amp;sa=X&amp;ei=BKCYTtnRJIiCNOXvgYMF" style="text-decoration:underline; color:#25AAE5"><strong>2719 E 10th St</strong></a></strong></div>
                            <div>Bloomington, IN 47408</div>
                            <br/>
                            <br/>
                            
                           <!-- <p>Lorem Ipsum is simply dummy text of the <br/>
                            setting industry. Lorem Ipsum has <br/>
                            been the industry's standard <br/>
                            123-456-789</p>-->
                        </div>
                        
                        <div class="info-row">
                            <h3>Telephones & Fax:</h3>
                            <p>(123) 456-789<br/>
                            (123) 456-789</p>
                        </div>
                        
                        <div class="info-row">
                            <h3>E-mail:</h3>
                            <p><a href="mailto:contact@tutorcause.com">contact@tutorcause.com</a><br/>
                            <a href="mailto:info@tutorcause.com">info@tutorcause.com</a></p>
                        </div>
                        
                      <div class="info-row">
                        <h3>Find us on Google Map:</h3>
                        	<div class="googleMap">
                        	<div id="map" style="width: 390px; height: 218px">
							</div>
                        
<!--                        
                        	<iframe width="390" height="218" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=promatics&amp;ie=UTF8&amp;hq=promatics&amp;hnear=&amp;t=h&amp;vpsrc=6&amp;ll=30.954914,75.848665&amp;spn=0.002006,0.004195&amp;z=17&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=promatics&amp;ie=UTF8&amp;hq=promatics&amp;hnear=&amp;t=h&amp;vpsrc=6&amp;ll=30.954914,75.848665&amp;spn=0.002006,0.004195&amp;z=17" style="color:#0000FF;text-align:left">View Larger Map</a>
                            </small>
-->                            
                            
                            
                        </div>
                    </div>
                    
                    <!--Contact Right Column End Here-->
                    
                </div>
            </div>
        
        </div>
    </div>
    </div>
    <div id="white-bottom"></div>


</div>