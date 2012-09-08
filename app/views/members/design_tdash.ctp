

<script type="text/javascript">

$(document).ready(function(){
	
//Set default open/close settings
$('.acc_container').hide(); //Hide/close all containers
$('.acc_trigger:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container

//On Click
$('.acc_trigger').click(function(){
	if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
		$('.acc_trigger').removeClass('active').next().slideUp(); //Remove all .acc_trigger classes and slide up the immediate next container
		$(this).toggleClass('active').next().slideDown(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	}
	return false; //Prevent the browser jump to the link anchor
});

});


</script>

<script type="text/javascript">
$(document).ready(function(){
	
//Set default open/close settings
$('.acc_container2').hide(); //Hide/close all containers
$('.acc_trigger2:first').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container

//On Click
$('.acc_trigger2').click(function(){
	if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
		$('.acc_trigger2').removeClass('active').next().slideUp(); //Remove all .acc_trigger classes and slide up the immediate next container
		$(this).toggleClass('active').next().slideDown(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	}
	return false; //Prevent the browser jump to the link anchor
});

});
</script>

<div id="content-wrap" class="fontNew">
    <h1>Tutors Dashboard</h1>
    <div id="tutor-wrap"> 
      
      <!--Left Sidebar Begin Here-->
      <div class="left-sidebar">
        <div class="student-profile">
          <div class="student-profile-img"><?php echo $html->image("frontend/profile-img.jpg")?></div>
          <div class="student-name">
            <div class="student">Name Comes Here</div>
          </div>
          <div class="student-profile-info">
            <div class="student">
              <div class="student-bal">Amount Earned : <span>$500</span></div>
            </div>
          </div>
          <div class="student-profile-info">
            <div class="student">
              <div class="student-bal">Available Balance : <span>$500</span></div>
            </div>
          </div>
          <div class="student-profile-info">
            <div class="student">
              <div class="student-bal"><a href="#">Financial History</a></div>
            </div>
          </div>
        </div>
        <div id="accordian">
          <div class="container">
            <h2 class="acc_trigger active"><a href="#">Account Settings</a></h2>
            <div class="acc_container" style="display: none; ">
              <div class="block">
                <ul class="account-links">
                  <li><a href="#">Link Comes Here</a></li>
                  <li><a href="#">Link Comes Here</a></li>
                  <li><a href="#">Link Comes Here</a></li>
                  <li><a href="#">Link Comes Here</a></li>
                  <li class="last"><a href="#">Link Comes Here</a></li>
                </ul>
              </div>
            </div>
            <h2 class="acc_trigger"><a href="#">My Tutors</a></h2>
            <div class="acc_container" style="display: block; ">
              <div class="block">
                <ul id="my-tutor">
                  <li>
                    <div class="profile-wrap">
                      <div class="profile-pic"><?php echo $html->image("frontend/pic-1.jpg")?></div>
                      <div class="profile-info">
                        <div class="name-price">
                          <h4 class="profile-name">Name Here</h4>
                        </div>
                        <div class="review">
                          <div class="feedabck-cate">Ability:</div>
                          <div class="feedabck"><?php echo $html->image("frontend/stars.png")?></div>
                        </div>
                        <div class="review">
                          <div class="feedabck-cate">Knowledge:</div>
                          <div class="feedabck"><?php echo $html->image("frontend/stars.png")?></div>
                        </div>
                        <div class="book-tutor">
                          <div class="tutor-cost">$38/hr</div>
                          <div class="book-tutor2"><a href="#">BOOk Now</a></div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="profile-wrap">
                      <div class="profile-pic"><?php echo $html->image("frontend/pic-2.jpg")?></div>
                      <div class="profile-info">
                        <div class="name-price">
                          <h4 class="profile-name">Name Here</h4>
                        </div>
                        <div class="review">
                          <div class="feedabck-cate">Ability:</div>
                          <div class="feedabck"><?php echo $html->image("frontend/stars.png")?></div>
                        </div>
                        <div class="review">
                          <div class="feedabck-cate">Knowledge:</div>
                          <div class="feedabck"><?php echo $html->image("frontend/stars.png")?></div>
                        </div>
                        <div class="book-tutor">
                          <div class="tutor-cost">$38/hr</div>
                          <div class="book-tutor2"><a href="#">BOOk Now</a></div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="profile-wrap">
                      <div class="profile-pic"><?php echo $html->image("frontend/pic-3.jpg")?></div>
                      <div class="profile-info">
                        <div class="name-price">
                          <h4 class="profile-name">Name Here</h4>
                        </div>
                        <div class="review">
                          <div class="feedabck-cate">Ability:</div>
                          <div class="feedabck"><?php echo $html->image("frontend/stars.png")?></div>
                        </div>
                        <div class="review">
                          <div class="feedabck-cate">Knowledge:</div>
                          <div class="feedabck"><?php echo $html->image("frontend/stars.png")?></div>
                        </div>
                        <div class="book-tutor">
                          <div class="tutor-cost">$38/hr</div>
                          <div class="book-tutor2"><a href="#">BOOk Now</a></div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="profile-wrap">
                      <div class="profile-pic"><?php echo $html->image("frontend/pic-4.jpg")?></div>
                      <div class="profile-info">
                        <div class="name-price">
                          <h4 class="profile-name">Name Here</h4>
                        </div>
                        <div class="review">
                          <div class="feedabck-cate">Ability:</div>
                          <div class="feedabck"><?php echo $html->image("frontend/stars.png")?></div>
                        </div>
                        <div class="review">
                          <div class="feedabck-cate">Knowledge:</div>
                          <div class="feedabck"><?php echo $html->image("frontend/stars.png")?></div>
                        </div>
                        <div class="book-tutor">
                          <div class="tutor-cost">$38/hr</div>
                          <div class="book-tutor2"><a href="#">BOOk Now</a></div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="profile-wrap">
                      <div class="profile-pic"><?php echo $html->image("frontend/pic-5.jpg")?></div>
                      <div class="profile-info">
                        <div class="name-price">
                          <h4 class="profile-name">Name Here</h4>
                        </div>
                        <div class="review">
                          <div class="feedabck-cate">Ability:</div>
                          <div class="feedabck"><?php echo $html->image("frontend/stars.png")?></div>
                        </div>
                        <div class="review">
                          <div class="feedabck-cate">Knowledge:</div>
                          <div class="feedabck"><?php echo $html->image("frontend/stars.png")?></div>
                        </div>
                        <div class="book-tutor">
                          <div class="tutor-cost">$38/hr</div>
                          <div class="book-tutor2"><a href="#">BOOk Now</a></div>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            <h2 class="acc_trigger"><a href="#">Find Cause</a></h2>
            <div class="acc_container" style="display: none; ">
              <div class="block">
               <div class="cause-search">
                  <label>Find Cause Here</label>
                  <input name="" type="text" />
                  <input type="image" src="../img/search-btn.png" />
               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Left Sidebar End Here--> 
      
      <!--Center Column Begin Here-->
      <div class="center-col">
        <div class="center-row">
          <div class="center-content">
            <div id="messages">
              <div class="center-heading">
                <h2>You have <span>6</span> messages in your inbox</h2>
                <div class="center-view"><a href="#">Go to inbox</a></div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="center-row2">
          <div class="center-content">
            <div id="notices">
              <div class="center-heading">
                <h2>Notice Board</h2>
                <div class="center-view"><a href="#">View all notices</a></div>
              </div>
              <div class="notice"> <span>Lorem Ipsum is simply dummy text</span>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy 			text ever since.</p>
              </div>
              <div class="notice"> <span>Lorem Ipsum is simply dummy text</span>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy 			text ever since.</p>
              </div>
              <div class="notice"> <span>Lorem Ipsum is simply dummy text</span>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy 			text ever since.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Center Column End Here--> 
      
      <!--Right Sidebar Begin Here-->
      <div class="right-sidebar">
        <h2>My Sessions</h2>
        <ul>
          <li><a href="#">Pending Requests
            <div class="notification">7</div>
            </a></li>
          <li><a href="#">Awaiting Payment
            <div class="notification">5</div>
            </a></li>
          <li><a href="#">Upcomming Session
            <div class="notification">3</div>
            </a></li>
          <li><a href="#">Awaiting Review
            <div class="notification">8</div>
            </a></li>
          <li><a href="#">View Completed</a></li>
        </ul>
        
        <!--<ul class="tutor-sessions">
          <li><a href="#">Update Availability</a></li>
          <li><a href="#">My Courses</a></li>
        </ul>-->
        
        <div class="tutor-sessions">
          <div class="container2">
            <h2 class="acc_trigger2 active"><a href="#">Update Availability</a></h2>
            <div class="acc_container2" style="display: none; ">
              <div class="block">
                <ul class="links">
                  <li><a href="#">Link Comes Here</a></li>
                  <li><a href="#">Link Comes Here</a></li>
                  <li><a href="#">Link Comes Here</a></li>
                  <li><a href="#">Link Comes Here</a></li>
                  <li class="last"><a href="#">Link Comes Here</a></li>
                </ul>
              </div>
            </div>
            <h2 class="acc_trigger2"><a href="#">My Courses</a></h2>
            <div class="acc_container2" style="display: block; ">
              <div class="block">
                <ul class="links">
                  <li><a href="#">Courses Comes Here</a></li>
                  <li><a href="#">Courses Comes Here</a></li>
                  <li><a href="#">Courses Comes Here</a></li>
                  <li><a href="#">Courses Comes Here</a></li>
                  <li class="last"><a href="#">Courses Comes Here</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Right Sidebar End Here--> 
      
    </div>
  </div>