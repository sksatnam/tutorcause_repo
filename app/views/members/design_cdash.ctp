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


 <div id="content-wrap">
              <h1>Cause Dashboard</h1>
              <div id="tutor-wrap"> 
                
                <!--Left Sidebar Begin Here-->
                <div class="left-sidebar">
                  <div class="student-profile">
                    <div class="student-profile-img"><img src="images/profile-img.jpg" width="245" height="169" /></div>
                    <div class="student-profile-info">
                      <div class="student">Name Comes Here</div>
                    </div>
                    <div class="student-profile-info">
                      <div class="student">
                        <div class="student-bal">Account Balance: <span>$500</span></div>
                      </div>
                    </div>
                  </div>
                  <div id="accordian">
                    <div class="container">
                      <h2 class="acc_trigger active"><a href="#">Account settings</a></h2>
                      <div class="acc_container" style="display: none; ">
                        <div class="block">
                          <ul class="account-links" >
                            <li><a href="#">Link Comes Here</a></li>
                            <li><a href="#">Link Comes Here</a></li>
                            <li><a href="#">Link Comes Here</a></li>
                            <li><a href="#">Link Comes Here</a></li>
                            <li class="last"><a href="#">Link Comes Here</a></li>
                          </ul>
                        </div>
                      </div>
                      <h2 class="acc_trigger"><a href="#">View Tutors</a></h2>
                      <div class="acc_container" style="display: block;">
                        <div class="block">
                          <div id="tutor-left">
                    <ul>
                      <li class="cause-bg"><a href="#">
                        <div class="profile-wrap">
                          <div class="profile-pic"><img src="images/pic-1.jpg" width="57" height="58" /></div>
                          <div class="profile-info">
                            <div class="name-price">
                              <h4 class="cause-name">Leading Nations Youth Programs</h4>
                              <div class="amount-raised">
                              		<div class="amount-raised-text">Amount Raised:</div>
                                	<div class="raised-amt">$2500</div>
                              </div>
                            </div> 
                          </div>
                        </div>
                        </a></li>
                        
                        <li class="cause-bg"><a href="#" class="current">
                        <div class="profile-wrap">
                          <div class="profile-pic"><img src="images/pic-2.jpg" width="57" height="58" /></div>
                          <div class="profile-info">
                            <div class="name-price">
                              <h4 class="cause-name">Leading Nations Youth Programs</h4>
                              <div class="amount-raised">
                              		<div class="amount-raised-text">Amount Raised:</div>
                                	<div class="raised-amt2">$2500</div>
                              </div>
                            </div> 
                          </div>
                        </div>
                        </a></li>
                        
                        <li class="cause-bg"><a href="#">
                        <div class="profile-wrap">
                          <div class="profile-pic"><img src="images/pic-3.jpg" width="57" height="58" /></div>
                          <div class="profile-info">
                            <div class="name-price">
                              <h4 class="cause-name">Leading Nations Youth Programs</h4>
                              <div class="amount-raised">
                              		<div class="amount-raised-text">Amount Raised:</div>
                                	<div class="raised-amt">$2500</div>
                              </div>
                            </div> 
                          </div>
                        </div>
                        </a></li>
                        
                        <li class="cause-bg"><a href="#">
                        <div class="profile-wrap">
                          <div class="profile-pic"><img src="images/pic-4.jpg" width="57" height="58" /></div>
                          <div class="profile-info">
                            <div class="name-price">
                              <h4 class="cause-name">Leading Nations Youth Programs</h4>
                              <div class="amount-raised">
                              		<div class="amount-raised-text">Amount Raised:</div>
                                	<div class="raised-amt">$2500</div>
                              </div>
                            </div> 
                          </div>
                        </div>
                        </a></li>
                        
                        <li class="cause-bg"><a href="#">
                        <div class="profile-wrap">
                          <div class="profile-pic"><img src="images/pic-5.jpg" width="57" height="58" /></div>
                          <div class="profile-info">
                            <div class="name-price">
                              <h4 class="cause-name">Leading Nations Youth Programs</h4>
                              <div class="amount-raised">
                              		<div class="amount-raised-text">Amount Raised:</div>
                                	<div class="raised-amt">$2500</div>
                              </div>
                            </div> 
                          </div>
                        </div>
                        </a></li>
                        
                        <li class="cause-bg"><a href="#">
                        <div class="profile-wrap">
                          <div class="profile-pic"><img src="images/pic-6.jpg" width="57" height="58" /></div>
                          <div class="profile-info">
                            <div class="name-price">
                              <h4 class="cause-name">Leading Nations Youth Programs</h4>
                              <div class="amount-raised">
                              		<div class="amount-raised-text">Amount Raised:</div>
                                	<div class="raised-amt">$2500</div>
                              </div>
                            </div> 
                          </div>
                        </div>
                        </a></li>
                        
                        <li class="cause-bg"><a href="#">
                        <div class="profile-wrap">
                          <div class="profile-pic"><img src="images/pic-7.jpg" width="57" height="58" /></div>
                          <div class="profile-info">
                            <div class="name-price">
                              <h4 class="cause-name">Leading Nations Youth Programs</h4>
                              <div class="amount-raised">
                              		<div class="amount-raised-text">Amount Raised:</div>
                                	<div class="raised-amt">$2500</div>
                              </div>
                            </div> 
                          </div>
                        </div>
                        </a></li>
                        
                        <li class="cause-bg"><a href="#">
                        <div class="profile-wrap">
                          <div class="profile-pic"><img src="images/pic-8.jpg" width="57" height="58" /></div>
                          <div class="profile-info">
                            <div class="name-price">
                              <h4 class="cause-name">Leading Nations Youth Programs</h4>
                              <div class="amount-raised">
                              		<div class="amount-raised-text">Amount Raised:</div>
                                	<div class="raised-amt">$2500</div>
                              </div>
                            </div> 
                          </div>
                        </div>
                        </a></li>
                        
                        <li class="cause-bg"><a href="#">
                        <div class="profile-wrap">
                          <div class="profile-pic"><img src="images/pic-9.jpg" width="57" height="58" /></div>
                          <div class="profile-info">
                            <div class="name-price">
                              <h4 class="cause-name">Leading Nations Youth Programs</h4>
                              <div class="amount-raised">
                              		<div class="amount-raised-text">Amount Raised:</div>
                                	<div class="raised-amt">$2500</div>
                              </div>
                            </div> 
                          </div>
                        </div>
                        </a></li>
                        
                        <li class="cause-bg"><a href="#">
                        <div class="profile-wrap">
                          <div class="profile-pic"><img src="images/pic-10.jpg" width="57" height="58" /></div>
                          <div class="profile-info">
                            <div class="name-price">
                              <h4 class="cause-name">Leading Nations Youth Programs</h4>
                              <div class="amount-raised">
                              		<div class="amount-raised-text">Amount Raised:</div>
                                	<div class="raised-amt">$2500</div>
                              </div>
                            </div> 
                          </div>
                        </div>
                        </a></li>
                    </ul>
                  </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--Left Sidebar End Here--> 
                
                <!--Center Column Begin Here-->
                <div class="center-col">
                  
                  
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
     
     <?php
       /*         
                <!--Right Sidebar Begin Here-->
                <div class="right-sidebar">
                  <h2>Fundraising Goal</h2>
                  <div class="fundraising">
                  	<div class="fundraising-wrap">
                    <div style="width:154px;">
<div style="width:154px; height:435px">
<iframe src="http://www.easy-fundraising-ideas.com/widgets/thermometer/lg1.php?id=7992" id="frame1" frameborder="0" scrolling="no" width="154" height="435"></iframe>
</div>
<div style="width:92px; height:58px;"><img src="http://www.easy-fundraising-ideas.com/widgets/thermometer/lrg/images/therm-bot.jpg" border="0" style="padding:0; margin:0; border:none;" alt="School Fundraising"></div>
<div style="width:154px; height:35px; background-image:url(http://www.easy-fundraising-ideas.com/widgets/thermometer/lrg/images/therm-bot-bg.jpg); background-repeat:no-repeat; font-size:9px">
</div>
</div>

                    	<!--<div class="fundraising-graph">
                        	<div class="fundraising-meter"></div>
                            <div class="fundraising-value">$4000</div>
                        </div>
                        <div class="goai-bg">Goal:  $10,000</div>
                        <a href="#" class="goal">Change Goal</a>-->
                    </div> 
                  </div>
                </div>
                <!--Right Sidebar End Here--> 
                */ ?>
              </div>
            </div>
            
        

<div style="width:154px; height:528px">
<div style="width:154px; height:435px">


<script type="text/javascript">

/*
 * Flip! jQuery Plugin (http://lab.smashup.it/flip/)
 * @author Luca Manno (luca@smashup.it) [http://i.smashup.it]
 *              [Original idea by Nicola Rizzo (thanks!)]
 *
 * @version 0.9.9 [Nov. 2009]
 *
 * @changelog
 * v 0.9.9      ->      Fix transparency over non-colored background. Added dontChangeColor option.
 *                      Added $clone and $this parameters to on.. callback functions.
 *                      Force hexadecimal color values. Made safe for noConflict use.
 *                      Some refactoring. [Henrik Hjelte, Jul. 10, 2009]
 * 						Added revert options, fixes and improvements on color management.
 * 						Released in Nov 2009
 * v 0.5        ->      Added patch to make it work with Opera (thanks to Peter Siewert), Added callbacks [Feb. 1, 2008]
 * v 0.4.1      ->      Fixed a regression in Chrome and Safari caused by getTransparent [Oct. 1, 2008]
 * v 0.4        ->      Fixed some bugs with transparent color. Now Flip! works on non-white backgrounds | Update: jquery.color.js plugin or jqueryUI still needed :( [Sept. 29, 2008]
 * v 0.3        ->      Now is possibile to define the content after the animation.
 *                              (jQuery object or text/html is allowed) [Sept. 25, 2008]
 * v 0.2        ->      Fixed chainability and buggy innertext rendering (xNephilimx thanks!)
 * v 0.1        ->      Starting release [Sept. 11, 2008]
 *
 */
(function($) {

function int_prop(fx){
    fx.elem.style[ fx.prop ] = parseInt(fx.now,10) + fx.unit;
}

var throwError=function(message) {
    throw({name:"jquery.flip.js plugin error",message:message});
};

var isIE6orOlder=function() {
    // User agent sniffing is clearly out of fashion and $.browser will be be deprectad.
    // Now, I can't think of a way to feature detect that IE6 doesn't show transparent
    // borders in the correct way.
    // Until then, this function will do, and be partly political correct, allowing
    // 0.01 percent of the internet users to tweak with their UserAgent string.
    //
    // Not leadingWhiteSpace is to separate IE family from, well who knows?
    // Maybe some version of Opera?
    // The second guess behind this is that IE7+  will keep supporting maxHeight in the future.
	
	// First guess changed to dean edwards ie sniffing http://dean.edwards.name/weblog/2007/03/sniff/
    return (/*@cc_on!@*/false && (typeof document.body.style.maxHeight === "undefined"));
};


// Some named colors to work with
// From Interface by Stefan Petre
// http://interface.eyecon.ro/

var colors = {
	aqua:[0,255,255],
	azure:[240,255,255],
	beige:[245,245,220],
	black:[0,0,0],
	blue:[0,0,255],
	brown:[165,42,42],
	cyan:[0,255,255],
	darkblue:[0,0,139],
	darkcyan:[0,139,139],
	darkgrey:[169,169,169],
	darkgreen:[0,100,0],
	darkkhaki:[189,183,107],
	darkmagenta:[139,0,139],
	darkolivegreen:[85,107,47],
	darkorange:[255,140,0],
	darkorchid:[153,50,204],
	darkred:[139,0,0],
	darksalmon:[233,150,122],
	darkviolet:[148,0,211],
	fuchsia:[255,0,255],
	gold:[255,215,0],
	green:[0,128,0],
	indigo:[75,0,130],
	khaki:[240,230,140],
	lightblue:[173,216,230],
	lightcyan:[224,255,255],
	lightgreen:[144,238,144],
	lightgrey:[211,211,211],
	lightpink:[255,182,193],
	lightyellow:[255,255,224],
	lime:[0,255,0],
	magenta:[255,0,255],
	maroon:[128,0,0],
	navy:[0,0,128],
	olive:[128,128,0],
	orange:[255,165,0],
	pink:[255,192,203],
	purple:[128,0,128],
	violet:[128,0,128],
	red:[255,0,0],
	silver:[192,192,192],
	white:[255,255,255],
	yellow:[255,255,0],
	transparent: [255,255,255]
};

var acceptHexColor=function(color) {
	if(color && color.indexOf("#")==-1 && color.indexOf("(")==-1){
		return "rgb("+colors[color].toString()+")";
	} else {
		return color;
	}
};

$.extend( $.fx.step, {
    borderTopWidth : int_prop,
    borderBottomWidth : int_prop,
    borderLeftWidth: int_prop,
    borderRightWidth: int_prop
});

$.fn.revertFlip = function(){
	return this.each( function(){
		var $this = $(this);
		$this.flip($this.data('flipRevertedSettings'));		
	});
};

$.fn.flip = function(settings){
    return this.each( function() {
        var $this=$(this), flipObj, $clone, dirOption, dirOptions, newContent, ie6=isIE6orOlder();

        if($this.data('flipLock')){
            return false;
        }
		
		var revertedSettings = {
			direction: (function(direction){
				switch(direction)
				{
				case "tb":
				  return "bt";
				case "bt":
				  return "tb";
				case "lr":
				  return "rl";
				case "rl":
				  return "lr";		  
				default:
				  return "bt";
				}
			})(settings.direction),
			bgColor: acceptHexColor(settings.color) || "#999",
			color: acceptHexColor(settings.bgColor) || $this.css("background-color"),
			content: $this.html(),
			speed: settings.speed || 500,
            onBefore: settings.onBefore || function(){},
            onEnd: settings.onEnd || function(){},
            onAnimation: settings.onAnimation || function(){}
		};
		
		$this
			.data('flipRevertedSettings',revertedSettings)
			.data('flipLock',1)
			.data('flipSettings',revertedSettings);

        flipObj = {
            width: $this.width(),
            height: $this.height(),
            bgColor: acceptHexColor(settings.bgColor) || $this.css("background-color"),
            fontSize: $this.css("font-size") || "12px",
            direction: settings.direction || "tb",
            toColor: acceptHexColor(settings.color) || "#999",
            speed: settings.speed || 500,
            top: $this.offset().top,
            left: $this.offset().left,
            target: settings.content || null,
            transparent: "transparent",
            dontChangeColor: settings.dontChangeColor || false,
            onBefore: settings.onBefore || function(){},
            onEnd: settings.onEnd || function(){},
            onAnimation: settings.onAnimation || function(){}
        };

        // This is the first part of a trick to support
        // transparent borders using chroma filter for IE6
        // The color below is arbitrary, lets just hope it is not used in the animation
        ie6 && (flipObj.transparent="#123456");

        $clone= $this.css("visibility","hidden")
            .clone(true)
			.data('flipLock',1)
            .appendTo("body")
            .html("")
            .css({visibility:"visible",position:"absolute",left:flipObj.left,top:flipObj.top,margin:0,zIndex:9999,"-webkit-box-shadow":"0px 0px 0px #000","-moz-box-shadow":"0px 0px 0px #000"});

        var defaultStart=function() {
            return {
                backgroundColor: flipObj.transparent,
                fontSize:0,
                lineHeight:0,
                borderTopWidth:0,
                borderLeftWidth:0,
                borderRightWidth:0,
                borderBottomWidth:0,
                borderTopColor:flipObj.transparent,
                borderBottomColor:flipObj.transparent,
                borderLeftColor:flipObj.transparent,
                borderRightColor:flipObj.transparent,
				background: "none",
                borderStyle:'solid',
                height:0,
                width:0
            };
        };
        var defaultHorizontal=function() {
            var waist=(flipObj.height/100)*25;
            var start=defaultStart();
            start.width=flipObj.width;
            return {
                "start": start,
                "first": {
                    borderTopWidth: 0,
                    borderLeftWidth: waist,
                    borderRightWidth: waist,
                    borderBottomWidth: 0,
                    borderTopColor: '#999',
                    borderBottomColor: '#999',
                    top: (flipObj.top+(flipObj.height/2)),
                    left: (flipObj.left-waist)},
                "second": {
                    borderBottomWidth: 0,
                    borderTopWidth: 0,
                    borderLeftWidth: 0,
                    borderRightWidth: 0,
                    borderTopColor: flipObj.transparent,
                    borderBottomColor: flipObj.transparent,
                    top: flipObj.top,
                    left: flipObj.left}
            };
        };
        var defaultVertical=function() {
            var waist=(flipObj.height/100)*25;
            var start=defaultStart();
            start.height=flipObj.height;
            return {
                "start": start,
                "first": {
                    borderTopWidth: waist,
                    borderLeftWidth: 0,
                    borderRightWidth: 0,
                    borderBottomWidth: waist,
                    borderLeftColor: '#999',
                    borderRightColor: '#999',
                    top: flipObj.top-waist,
                    left: flipObj.left+(flipObj.width/2)},
                "second": {
                    borderTopWidth: 0,
                    borderLeftWidth: 0,
                    borderRightWidth: 0,
                    borderBottomWidth: 0,
                    borderLeftColor: flipObj.transparent,
                    borderRightColor: flipObj.transparent,
                    top: flipObj.top,
                    left: flipObj.left}
            };
        };

        dirOptions = {
            "tb": function () {
                var d=defaultHorizontal();
                d.start.borderTopWidth=flipObj.height;
                d.start.borderTopColor=flipObj.bgColor;
                d.second.borderBottomWidth= flipObj.height;
                d.second.borderBottomColor= flipObj.toColor;
                return d;
            },
            "bt": function () {
                var d=defaultHorizontal();
                d.start.borderBottomWidth=flipObj.height;
                d.start.borderBottomColor= flipObj.bgColor;
                d.second.borderTopWidth= flipObj.height;
                d.second.borderTopColor= flipObj.toColor;
                return d;
            },
            "lr": function () {
                var d=defaultVertical();
                d.start.borderLeftWidth=flipObj.width;
                d.start.borderLeftColor=flipObj.bgColor;
                d.second.borderRightWidth= flipObj.width;
                d.second.borderRightColor= flipObj.toColor;
                return d;
            },
            "rl": function () {
                var d=defaultVertical();
                d.start.borderRightWidth=flipObj.width;
                d.start.borderRightColor=flipObj.bgColor;
                d.second.borderLeftWidth= flipObj.width;
                d.second.borderLeftColor= flipObj.toColor;
                return d;
            }
        };

        dirOption=dirOptions[flipObj.direction]();

        // Second part of IE6 transparency trick.
        ie6 && (dirOption.start.filter="chroma(color="+flipObj.transparent+")");

        newContent = function(){
            var target = flipObj.target;
            return target && target.jquery ? target.html() : target;
        };

        $clone.queue(function(){
            flipObj.onBefore($clone,$this);
            $clone.html('').css(dirOption.start);
            $clone.dequeue();
        });

        $clone.animate(dirOption.first,flipObj.speed);

        $clone.queue(function(){
            flipObj.onAnimation($clone,$this);
            $clone.dequeue();
        });
        $clone.animate(dirOption.second,flipObj.speed);

        $clone.queue(function(){
            if (!flipObj.dontChangeColor) {
                $this.css({backgroundColor: flipObj.toColor});
            }
            $this.css({visibility: "visible"});

            var nC = newContent();
            if(nC){$this.html(nC);}
            $clone.remove();
            flipObj.onEnd($clone,$this);
            $this.removeData('flipLock');
            $clone.dequeue();
        });
    });
};
})(jQuery);







			$(function(){
					   
				//	   wrongpass();
				
				/*$(".flipPad a:not(.revert)").bind("click",function(){
					var $this = $(this);
					
					alert($this.attr("rel"));
					alert($this.attr("rev"));
					alert(document.getElementById('content').innerHTML);
					
					$("#flipbox").flip({
						direction: $this.attr("rel"),
						color: $this.attr("rev"),
						content: document.getElementById('content').innerHTML,//(new Date()).getTime(),
						onBefore: function(){$(".revert").show()}
					})
					return false;
				});
				
				$(".revert").bind("click",function(){
					$("#flipbox").revertFlip();
					return false;
				});
				*/
				
				
			});
			
			
	function editflip()
	{
		
		$("#flipbox").flip({
						direction: 'bt',
						color: '#ccc',
						content: document.getElementById('content').innerHTML,//(new Date()).getTime(),
						onBefore: function(){$(".revert").show()}
					})
		
	}
	
	
	function cancelflip()
	{
		
		$("#flipbox").flip({
					direction: 'tb',
					color: '#ccc',
					content: document.getElementById('content1').innerHTML,//(new Date()).getTime(),
					onBefore: function(){$(".revert").show()}
				})
		
		}
		
	function wrongpass()
	{
		$("#flipbox").flip({
					direction: 'tb',
					color: '#F3D8D8',
					content: document.getElementById('content2').innerHTML,//(new Date()).getTime(),
					onBefore: function(){$(".revert").show()}
				})
	
	}
			
	function sendajax(){
		
	  var loc = window.top.location.href;
		
		var dataString = 'loc='+ loc;
		//alert (dataString);return false;
		
		$.ajax({
      type: "POST",
      url: "therm-location.php",
      data: dataString,
	  error:function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
	  },
      success: function(data) {
        $('#contact_form').html("<div id='message'></div>");
        $('#message').html(data)
        .append("<p>We will be in touch soon.</p>")
        .hide()
        .fadeIn(1500, function() {
          $('#message').append("");
        });
      }
     });
    return false;
	
};
			
		</script>

<div class="flipPad" style="position: absolute; top: 206px; left: 10px; width: 142px; z-index: 100; margin-top:9px; margin-left:9px;">
<div style="float: left; width: 50px;"><a href="#" class="top" rel="bt" rev="#ccc"><img src="http://www.myefi.com/thermometer-lrg/images/edit.png" border="0" onclick="javascript:editflip();"></a> </div>
<div style="float: right; width: 43px;"><a href="#" class="revert" rel="bt" rev="#ccc"><img src="http://www.myefi.com/thermometer-lrg/images/cancel.png" border="0" onclick="javascript:cancelflip();"></a></div>
						</div>

      
<div style="float: left; width: 154px; height: 435px;  ">

<div id="flipbox" style="text-align:center;">
<div style="width: 154px; height: 65px;"><img src="http://www.myefi.com/thermometer-lrg/images/header.jpg" alt="Fundraising Ideas" border="0"></div>
<div style="width: 154px; height: 141px; background-image: url(&quot;http://www.myefi.com/thermometer-lrg/images/goal-bg.jpg&quot;); background-repeat: no-repeat;">
<div style="padding: 15px 20px 0pt 10px; text-align: center; font-size: 30px; color: rgb(113, 144, 197);">$1000</div>
<div style="font-size: 12px; padding-right: 5px; color: rgb(160, 176, 129); text-align: center;">Our Goal</div>
<div style="padding: 10px 20px 0pt 10px; text-align: center; font-size: 30px; color: rgb(113, 144, 197);">$600</div>
<div style="font-size: 12px; padding-right: 5px; color: rgb(160, 176, 129); text-align: center;">Raised so far</div>
</div>
</div>




<div style="height: 229px; background-image: url(&quot;http://www.myefi.com/thermometer-lrg/images/therm-bg.jpg&quot;); background-repeat: no-repeat;">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
<td style="padding: 0pt 0pt 0pt 64px;" valign="bottom" height="229"><div style="height: 120px; width: 15px; background-color: rgb(150, 188, 94); border-left: 1px solid rgb(116, 160, 80); border-right: 1px solid rgb(116, 160, 80); max-height: 200px;"></div></td>
</tr>
</tbody></table>
</div>
</div>  	
<div style="width: 1px; height: 1px; overflow: hidden; clear: both;">

                    <div id="content" style="height: 206px;">
                    <div id="update_form" style="height: 206px;">
                    <form method="post">
                    <table width="100%" border="0" cellpadding="1" cellspacing="0">
                    <tbody><tr>
                    <td style="padding: 0pt 5px;">Goal:</td></tr>
                    <tr><td style="padding: 0pt 5px;"><input name="goal" id="goal" value="1000" style="width: 110px;" type="text"></td>
                    </tr>
                     <tr>
                    <td style="padding: 0pt 5px;">Amount Raised:</td></tr>
                    <tr><td style="padding: 0pt 5px;"><input name="raised" id="raised" value="600" style="width: 110px;" type="text"></td>
                    </tr>
                    <tr><td style="padding: 0pt 5px;">Password:</td></tr>
                    <tr><td style="padding: 0pt 5px;"><input name="passw" id="passw" style="width: 110px;" type="password"></td>
                    </tr>
                    <tr><td align="center"><input value="Update" class="therm-update" type="submit"></td></tr>
                    </tbody></table>
                    <input name="entry_id" id="entry_id" value="8210" type="hidden">
                    </form>
                    </div>
                    </div>
                    
                    
                    <div id="content1">
                        <div style="width: 154px; height: 65px;"><img src="http://www.myefi.com/thermometer-lrg/images/header.jpg" alt="Fundraising Ideas" border="0"></div>
                        <div style="width: 154px; height: 141px; background-image: url(&quot;http://www.myefi.com/thermometer-lrg/images/goal-bg.jpg&quot;); background-repeat: no-repeat;">
                        <div style="padding: 15px 20px 0pt 10px; text-align: center; font-size: 30px; color: rgb(113, 144, 197);">$1000</div>
                        <div style="font-size: 12px; padding-right: 5px; color: rgb(160, 176, 129); text-align: center;">Our Goal</div>
                        <div style="padding: 10px 20px 0pt 10px; text-align: center; font-size: 30px; color: rgb(113, 144, 197);">$600</div>
                        <div style="font-size: 12px; padding-right: 5px; color: rgb(160, 176, 129); text-align: center;">Raised so far</div>
                        </div>
                    </div>
                    
                    
                    <div style="height: 206px; text-align: center; background-color: rgb(243, 216, 216);" id="content2">Sorry the password you entered is incorrect! Click the button below and it will be emailed to the email on file.
                    <form method="post"><input type="hidden" value="true" name="email"><input type="submit" value="Email Me!"></form>
                    <br><a window.location.href="window.location.href&quot;" onclick="" href="">Try again</a>
                    </div>
                    
                    
                    </div>
</body>


</div>
<div style="width:92px; height:58px;"><a href="http://www.easy-fundraising-ideas.com/programs/school-fundraising-ideas/"><img src="http://www.easy-fundraising-ideas.com/widgets/thermometer/lrg/images/therm-bot.jpg" border="0" style="padding:0; margin:0; border:none;" alt="School Fundraising"></a></div>
<div style="width:154px; height:35px; background-image:url(http://www.easy-fundraising-ideas.com/widgets/thermometer/lrg/images/therm-bot-bg.jpg); background-repeat:no-repeat; font-size:9px">

</div>
</div>