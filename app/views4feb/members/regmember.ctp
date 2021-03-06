<!--
live 229378733769669
testing 226449800757981
-->
<div id="fb-root"></div>

<!--<h2>Updated JS SDK example</h2><br />
<div id="user-info"></div>
<p><button id="fb-auth">Login</button></p>-->

<script type="text/javascript">
$(function() {
	var pathname = window.location.pathname;
	var changeImage=$('.imageChange');
	var profileImage=$('.profileAjaxImage');
	new AjaxUpload(changeImage,
	{
		action: ajax_url+"/members/img_upload",
		name: 'userImage',
		onSubmit: function(file, ext)
		{
			if (! (ext && /^(jpg|png|gif)$/.test(ext)))
			{
				errorMsg('File type must be GIF, PNG, or JPG');
				return false;
			}
			
			$('.profileAjaxImage').css('opacity','0.4');
			$('.profileAjaxImage2').show();
			
		},
		onComplete: function(file, response)
		{
			
			response = jQuery.trim(response);
			
			$('.profileAjaxImage').css('opacity','1');
			$('.profileAjaxImage2').hide()
			
			
			if(response==="sizeError"){
				alert('Size must be less than 5 MB');
/*				errorMsg('Size must be less than 5 MB');*/
				return false;
			}
			else if(response.indexOf("##success")>-1)
			{
				//alert('jazz');
				getImageX=response.split("##suc");
				
				var newImg = ajax_url+'/img/members/'+getImageX[0];
				
//				alert(getImageX[0]);return false;
				$('.profileAjaxImage img').attr('src',newImg);

			}
			else
			{
				errorMsg('An Error Occured');
				return false;
			}
		}
	});
	
	$("#optionalinfo").hide();
	$("#optional").click(function () {
								   
	   var x = document.getElementById("optional").innerHTML;
	   
	   if(x=='(Show)')
	   {
		   document.getElementById("optional").innerHTML = '(Hide)';
	   }
	   else
	   {
		   document.getElementById("optional").innerHTML = '(Show)';
	   }
									   
		$("#optionalinfo").toggle("slow");
	
    });
	
	
	$.validator.addMethod("letters", function(value, element) {
		return this.optional(element) || /^[a-zA-Z\s ]+$/.test(value);
	}, "Letters only please"); 
	
	
	$("#state").change(function(){
		//alert('hi');
		$("#zipcode").val('') ;
		$("#zipcode").removeClass('error');
		$(".stepThreeFormRow1 span").remove();
		//$("#zipcode").removeClass('form li input.error');*/
		 
		});

	
});



window.fbAsyncInit = function() {
  FB.init({ appId: '<?php echo APPID;?>', 
	    status: true, 
	    cookie: true,
	    xfbml: true,
	    oauth: true});
  
  $("#fb-auth").live("click",function() {
										  
			
        FB.login(function(response) {
	  if (response.authResponse) {
            FB.api('/me', function(response) {
								   
           			
							var saveurl = '<?php echo HTTP_ROOT;?>members/savefbid';
							
							$.ajax({
							type: "GET",
							url: saveurl,
							data: '&id='+response.id,
								success: function(msg){
								
								msg = jQuery.trim(msg);
								
								if(msg=='false')
								{
									alert('This facebook id is already in use.')  
									
									FB.logout(function(response) {
									// user is now logged out
									});
									
									window.location.reload();

									
								}
								else if(msg=='true')
								{
									FB.logout(function(response) {
									// user is now logged out
									});

									window.location.reload();
								}
								}
							});	
							
								   
								   
	      /*var userInfo = document.getElementById('user-info');
	      userInfo.innerHTML = 
                '<img src="https://graph.facebook.com/' 
	        + response.id + '/picture" style="margin-right:5px"/>' 
	        + response.name;*/
			
			
			
			
			
			
			
	    });	   
          } else {
            //user cancelled login or did not grant authorization
          }
        }, {scope:'email'});  	
      							  
										  
										  
		
			
			
			});	
  
};
	
(function() {
  var e = document.createElement('script'); e.async = true;
  e.src = document.location.protocol 
    + '//connect.facebook.net/en_US/all.js';
  document.getElementById('fb-root').appendChild(e);
}());


	




		
/*function checktos()
{
	
	if(document.getElementById('tos').checked)
	{
		document.getElementById('submitbutton').disabled = true;
	}

}
*/


function errorMsg(msg){
	$('#errorMsg').html('<span style="color:red;"><b>'+msg+'</b></span>');
	$('#errorMsg').fadeIn().delay(3000).fadeOut();
}

addEvent(window, 'load', initForm);

var highlight_array = new Array();

function initForm(){
	initializeFocus();
	var activeForm = document.getElementsByTagName('form')[0];
	addEvent(activeForm, 'submit', disableSubmitButton);
	ifInstructs();
	showRangeCounters();
}

function disableSubmitButton() {
//	document.getElementById('saveForm').disabled = true;
}

// for radio and checkboxes, they have to be cleared manually, so they are added to the
// global array highlight_array so we dont have to loop through the dom every time.
function initializeFocus(){
	var fields = getElementsByClassName(document, "*", "field");
	
	for(i = 0; i < fields.length; i++) {
		if(fields[i].type == 'radio' || fields[i].type == 'checkbox') {
			fields[i].onclick = function() {highlight(this, 4);};
			fields[i].onfocus = function() {highlight(this, 4);};
		}
		else if(fields[i].className.match('addr') || fields[i].className.match('other')) {
			fields[i].onfocus = function(){highlight(this, 3);};
		}
		else {
			fields[i].onfocus = function(){highlight(this, 2); };
		}
	}
}

function highlight(el, depth){
	if(depth == 2){var fieldContainer = el.parentNode.parentNode;}
	if(depth == 3){var fieldContainer = el.parentNode.parentNode.parentNode;}
	if(depth == 4){var fieldContainer = el.parentNode.parentNode.parentNode.parentNode;}
	
	addClassName(fieldContainer, 'focused', true);
	var focusedFields = getElementsByClassName(document, "*", "focused");
	
	for(i = 0; i < focusedFields.length; i++) {
		if(focusedFields[i] != fieldContainer){
			removeClassName(focusedFields[i], 'focused');
		}
	}
}

function ifInstructs(){
	var container = document.getElementById('public');
	if(container){
		removeClassName(container,'noI');
		var instructs = getElementsByClassName(document,"*","instruct");
		if(instructs == ''){
			addClassName(container,'noI',true);
		}
		if(container.offsetWidth <= 450){
			addClassName(container,'altInstruct',true);
		}
	}
}

function showRangeCounters(){
	counters = getElementsByClassName(document, "em", "currently");
	for(i = 0; i < counters.length; i++) {

		counters[i].style.display = 'inline';
	}
}

function validateRange(ColumnId, RangeType) {
	if(document.getElementById('rangeUsedMsg'+ColumnId)) {
		var field = document.getElementById('Field'+ColumnId);
		var msg = document.getElementById('rangeUsedMsg'+ColumnId);

		switch(RangeType) {
			case 'character':
				msg.innerHTML = field.value.length;
				break;
				
			case 'word':
				var val = field.value;
				val = val.replace(/\n/g, " ");
				var words = val.split(" ");
				var used = 0;
				for(i =0; i < words.length; i++) {
					if(words[i].replace(/\s+$/,"") != "") used++;
				}
				msg.innerHTML = used;
				break;
				
			case 'digit':
				msg.innerHTML = field.value.length;
				break;
		}
	}
}

/*--------------------------------------------------------------------------*/

//http://www.robertnyman.com/2005/11/07/the-ultimate-getelementsbyclassname/
function getElementsByClassName(oElm, strTagName, strClassName){
	var arrElements = (strTagName == "*" && oElm.all)? oElm.all : oElm.getElementsByTagName(strTagName);
	var arrReturnElements = new Array();
	strClassName = strClassName.replace(/\-/g, "\\-");
	var oRegExp = new RegExp("(^|\\s)" + strClassName + "(\\s|$)");
	var oElement;
	for(var i=0; i<arrElements.length; i++){
		oElement = arrElements[i];		
		if(oRegExp.test(oElement.className)){
			arrReturnElements.push(oElement);
		}	
	}
	return (arrReturnElements)
}

//http://www.bigbold.com/snippets/posts/show/2630
function addClassName(objElement, strClass, blnMayAlreadyExist){
   if ( objElement.className ){
      var arrList = objElement.className.split(' ');
      if ( blnMayAlreadyExist ){
         var strClassUpper = strClass.toUpperCase();
         for ( var i = 0; i < arrList.length; i++ ){
            if ( arrList[i].toUpperCase() == strClassUpper ){
               arrList.splice(i, 1);
               i--;
             }
           }
      }
      arrList[arrList.length] = strClass;
      objElement.className = arrList.join(' ');
   }
   else{  
      objElement.className = strClass;
      }
}

//http://www.bigbold.com/snippets/posts/show/2630
function removeClassName(objElement, strClass){
   if ( objElement.className ){
      var arrList = objElement.className.split(' ');
      var strClassUpper = strClass.toUpperCase();
      for ( var i = 0; i < arrList.length; i++ ){
         if ( arrList[i].toUpperCase() == strClassUpper ){
            arrList.splice(i, 1);
            i--;
         }
      }
      objElement.className = arrList.join(' ');
   }
}

//http://ejohn.org/projects/flexible-javascript-events/
function addEvent( obj, type, fn ) {
  if ( obj.attachEvent ) {
    obj["e"+type+fn] = fn;
    obj[type+fn] = function() { obj["e"+type+fn]( window.event ) };
    obj.attachEvent( "on"+type, obj[type+fn] );
  } 
  else{
    obj.addEventListener( type, fn, false );	
  }
}


</script>
<style type="text/css">
#optional:hover
{
	color:#555 !important;
}

span.error{
		padding-left:153px;
	}
.stepThreeFormRow
{
	min-height:50px;
}
span.red
{
	color:#F00;
}
.userUploadImg{margin-bottom:10px;}
.stepThreeFormRgtCont{
	margin-left: 10px;
    width: 166px;
	padding:8px;
	font-size:14px;
	margin-top:10px;
}


/* - - - - - - - - - - - - - - - - - - - - -

Title : Wufoo Form Framework
Author : Infinity Box Inc.
URL : http://wufoo.com

Last Updated : March 2, 2010

- - - - - - - - - - - - - - - - - - - - - */

.wufoo{
	font-family:"Lucida Grande","Lucida Sans Unicode", Tahoma, sans-serif;
	letter-spacing:.01em;
}
.wufoo li{
	width:64%;
}

/* ----- INFO ----- */

.info{
	display:inline-block; 
	clear:both;
	margin:0 0 5px 0;
	padding:0 1% 1.1em 1%;
	border-bottom:1px dotted #ccc;
}
.info[class]{
	display:block;
}
.hideHeader .info, #payment.hideHeader li.first{
	display:none;
}
.info h2{
	font-weight:normal;
	font-size:160%;
	margin:0 0 5px 0;
	clear:left;
}
.info div{
	font-size:95%;
	line-height:135%;
	color:#555;
}

/* ----- Field Structure ----- */

form ul{
	margin:0;
	padding:0;
	list-style-type:none;
}
* html form ul{ /* IE6 Margin Percent Bug for Halves/Thirds */
	width:99%;
	zoom:1;
}
form li{
	margin:0;
	padding:6px 1% 9px 1%;
	clear:both;
	background-color:transparent;
	position:relative; /* Makes Instructs z-index stay on top in IE. */
	-webkit-transition: background-color 350ms ease-out;
	   -moz-transition: background-color 350ms ease-out;
	     -o-transition: background-color 350ms ease-out;
	        transition: background-color 350ms ease-out;
}
form ul:after,form li:after, form li div:after{
	content:"."; 
	display:block;
	height:0; 
	clear:both; 
	visibility:hidden;
}
* html form li{height: 1%;margin-bottom:-3px;}
*+html form li{height: 1%;margin-bottom:-3px;}
* html form li div{display:inline-block;}
*+html form ul, *+html form li div{display:inline-block;}

form li div{
	margin:0;
	padding:0;
	color:#444;
}
form li span{
	margin:0 .3em 0 0;
	padding:0;
	float:left;
	color:#444;
}

/* ----- Choices Field Structures ----- */

form li div span{
	margin:0;
	display:block;
	width:100%;
	float:left;
}
li.twoColumns div span{
	width:48%;
	margin:0 5px 0 0;
}
li.threeColumns div span{
	width:30%;
	margin:0 5px 0 0;
}
li.notStacked div span{
	width:auto;
	margin:0 7px 0 0;
}

/* ----- Location Field Structures ----- */

form li.complex{
	padding-bottom:0;
}
form li.complex div span{
	width:auto;
	margin:0 .3em 0 0;
	padding-bottom:12px;
}
form li.complex div span.full{
	margin:0;
}
form li.complex div span.left, 
form li.complex div span.right{
	margin:0;
	width:48%;
}
form li.complex div span.full input, 
form li.complex div span.full select, 
form li.complex div span.left input, 
form li.complex div span.right input,
form li.complex div span.left select,
form li.complex div span.right select{
	width:100%;
}

/* ----- FLOATS ----- */

.left{
	float:left;
}
.right{
	float:right;
}
.clear{
	clear:both !important;
}

label span, .section span, p span, .likert span{
	display:inline !important;
	float:none !important;
}

/* ----- TEXT DIRECTION ----- */

.rtl .info h2, .rtl .info div, .rtl label.desc, .rtl label.choice, 
.rtl div label, .rtl span label, .rtl input.text, 
.rtl textarea.textarea, .rtl select.select, .rtl p.instruct, 
.rtl .section h3, .rtl .section div, .rtl input.btTxt{
	direction:rtl;
}

/* ----- LABELS ----- */

form li div label, form li span label{
	margin:0;
	padding-top:3px;
	clear:both;
	font-size:85%;
	line-height:160%;
	color:#444;
	display:block;
}
fieldset{
	display:block;
	border:none;
	margin:0;
	padding:0;
}

label.desc, legend.desc{
	font-size:95%;
	font-weight:bold;
	color:#222;
	line-height:150%;
	margin:0;
	padding:0 0 3px 0;
	border:none;
	display:block;
	white-space: normal;
	width:100%;
}

label.choice{
	display:block;
	font-size:100%;
	line-height:150%;
	margin:-17px 0 0 23px;
	padding:0 0 5px 0;
	color:#222;
	width:88%;
}
.safari label.choice{
	margin-top:-16px;
}
form.rightLabel .desc{
	padding-top:2px;
}

span.symbol{
	font-size:120%;
	line-height:135%;
}
form li .datepicker{
	float:left;
	margin:.19em 5px 0 0;
	padding:0;
	width: 16px;
	height: 16px;
	cursor:pointer !important;
}

/* ----- REQUIRED ----- */

form span.req{
	display:inline;
	float:none;
	color:red !important;
	font-weight:bold;
	margin:0;
	padding:0;
}

/* ----- MIN/MAX COUNT ----- */

form li div label var{
	font-weight:bold;
	font-style:normal;
}
form li div label .currently{
	display:none;
}

/* ----- FIELDS ----- */

input.text, input.search, input.file, textarea.textarea, select.select{
	font-family:"Lucida Grande", Tahoma, Arial, sans-serif;
	font-size:100%;
	color:#333;
	margin:0;
	padding:2px 0;
}
input.text, input.search, textarea.textarea{
	border-top:1px solid #7c7c7c;
	border-left:1px solid #c3c3c3;
	border-right:1px solid #c3c3c3;
	border-bottom:1px solid #ddd;
	background:#fff url(../images/fieldbg.gif) repeat-x top;
}

input.nospin::-webkit-inner-spin-button,
input.nospin::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

select.select{
	padding:1px 0 0 0;
}
input.search{
	-webkit-border-radius:10px;
	-moz-border-radius:10px;
	border-radius:10px;
	padding-left:6px;
}
input.checkbox, input.radio{
	display:block;
	margin:4px 0 0 0;
	padding:0;
	width:13px;
	height:13px;
}
input.other{
	margin:0 0 8px 25px;
}

.safari select.select{
	font-size:120% !important;
	margin:0 0 1px 0;
}
* html select.select{
	margin:1px 0;
}
*+html select.select{
	margin:1px 0;
}

.center, 
form li span.center input.text, form li span.center label,
form li.name span label,
form li.date input.text, form li.date span label, 
form li.phone input.text, form li.phone span label,
form li.time input.text, form li.time span label{
	text-align:center;
}
form li.time select.select{
	margin-left:5px;
}
form li.price .right{
	text-align:right;
}

/* ----- SIZES ----- */

.third{
	width:32% !important;
}
.half{
	width:48% !important;
}
.full{
	width:100% !important;
}

input.small, select.small{
	width:25%;
}
input.medium, select.medium{
	width:50%;
}
input.large, select.large{
	width:100%;
}


/*.msie6 select.ieSelectFix{
	width:100%;
}*/
.msie[class] select.ieSelectFix{
	width:auto;
}
.msie[class] select.ieSelectFix.small{
	min-width:25%;
}
.msie[class] select.ieSelectFix.medium{
	min-width:50%;
}
.msie[class] select.ieSelectFix.large{
	width:100%;
}

textarea.textarea{
	width:293px;
	min-width:100%; /* IE8 Textarea Scroll Bug */
	max-width:100%;
}
textarea.small{
	height:5.5em;
}
textarea.medium{
	height:10em;
}
textarea.large{
	height:20em;
}

/* ----- FILES ----- */

li.file a{
	color:#222;text-decoration:none;
}
li.file span{
	display:inline;float:none;
}
li.file img{
	display:block;float:left;margin:0 0 0 -10px;padding:5px 5px 7px 5px;
}
li.file .file-size, li.file .file-type{
	color:#666;font-size:85%;text-transform: uppercase;
}
li.file .file-name{
	display:block;
	padding:14px 0 0 0;
	color:blue;
	text-decoration:underline;
}
li.file .file-delete{
	color:red !important;font-size:85%;text-decoration:underline;
}
li.file a:hover .file-name{
	color:green !important;
}
li.file a:hover .file-name{
	color:green !important;
}

/* ----- LIKERT SCALE ----- */

form li.likert{
	margin:0;
	padding:6px 1% 5px 1%;
	width:auto !important;
	clear:both !important;
	float:none !important;
}
.likert table{
	margin:0 0 .9em 0;
	background:#fff;
	width:100%;
	border:1px solid #dedede;
	border-bottom:none;
}
.likert caption{
	text-align:left;
	color:#222;
	font-size:95%;
	line-height:135%;
	padding:5px 0 .5em 0;
}
.likert input{
	padding:0;
	margin:2px 0;
}
.likert tbody td label{
	font-size:85%;
	display:block;
	color:#565656;
}

/* ----- Top Row ----- */

.likert thead td, .likert thead th{
	background-color:#e6e6e6;
}

/* ----- Right Side ----- */

.likert td{
	border-left:1px solid #ccc;
	text-align:center;
	padding:4px 6px;
}
.likert thead td{
	font-size:85%;
	padding:10px 6px;
}

/* ----- Body ----- */

.likert th, .likert td{
	border-bottom:1px solid #dedede;
}
.likert tbody th{
	padding:8px 8px;
	text-align:left;
}
.likert tbody th label{
	color:#222;
	font-size:95%;
	font-weight:bold;
}

.likert tbody tr.alt td, .likert tbody tr.alt th{
	background-color:#f5f5f5;
}
.likert tbody tr:hover td, .likert tbody tr:hover th{
	background-color:#FFFFCF;
}

/* ----- Likert Classes ----- */

.col1 td{width:30%;} 
.col2 td{width:25%;}
.col3 td{width:18%;}
.col4 td{width:14.5%;}
.col5 td{width:12%;}
.col6 td, .col7 td{width:10%;}
.col8 td, .col9 td, .col10 td{width:6.5%;}
.col11{width:6%;}

.hideNumbers tbody td label{
	display:none;
}

/* ----- BUTTONS ----- */

form li.buttons{
	width:auto !important;
	position:relative;
	clear:both;
	padding:10px 1% 10px 1%;
}
form li.buttons input{
	font-size:100%;
	margin-right:5px;
}
input.btTxt{
	padding:0 7px;
	width:auto;
	overflow:visible;
}
.safari input.btTxt{
	font-size:120%;
}
.buttons .marker{
	position:absolute;
	top:0;
	right:0;
	padding:15px 10px 0 0;
	color:#000;
	width:auto;
}
button.link{
	display:inline-block;
	border:none;
	background:none;
	color:blue;
	text-decoration:underline;
	cursor:pointer;
	padding:0;
	font-size:100%;
}
button.link:hover{
	color:green;
}

/* ----- LABEL LAYOUT ----- */

.leftLabel li, .rightLabel li{
	width:74% !important;
	padding-top:9px;
}
.leftLabel .desc, .rightLabel .desc{
	float:left;
	width:31%;
	margin:0 15px 0 0;
}
.rightLabel .desc{
	text-align:right;
}
.leftLabel li div, .rightLabel li div{
	float:left;
	width:65%;
}

* html .leftLabel li fieldset div, 
* html .rightLabel li fieldset div{
	float:right;
}
*+html .leftLabel li fieldset div, 
*+html .rightLabel li fieldset div{
	float:right;
}

.leftLabel .buttons, .rightLabel .buttons{
	padding-left:23%;
}
.leftLabel .buttons div, .rightLabel .buttons div{
	float:none;
	margin:0 0 0 20px;
}


.leftLabel p.instruct, .rightLabel p.instruct{
	width:28%;
	margin-left:5px;
}
.leftLabel .altInstruct .instruct, .rightLabel .altInstruct .instruct{
	margin-left:31% !important;
	padding-left:15px;
	width:65%;
}

/* ----- NO INSTRUCTIONS ----- */

.noI form li, .altInstruct form li{
	width:auto !important;
}

/* ----- NO INSTRUCTIONS LABEL LAYOUT ----- */

.noI .leftLabel .buttons, .noI .rightLabel .buttons{
	padding-left:31%;
}
.noI .leftLabel .buttons div, .noI .rightLabel .buttons div{
	margin:0 0 0 17px;
}

/* ----- HALVES AND THIRDS ----- */

form li.leftHalf, form li.rightHalf{
	width:47% !important;
}
form li.leftThird, form li.middleThird, form li.rightThird{
	width:30% !important;
}
form li.leftFourth, form li.middleFourth, form li.rightFourth{
	width: 23% !important;
	_width: 22% !important;
}
form li.leftFifth, form li.middleFifth, form li.rightFifth{
	width: 18% !important;
	_width: 17% !important;
}
form li.middleThird{
	clear:none !important;
	float:left;
	margin-left:2% !important;
}
form li.leftFourth, form li.middleFourth,
form li.leftFifth, form li.middleFifth {
	clear:none !important;
	float:left;
}
form li.rightHalf, form li.rightThird, form li.rightFourth, form li.rightFifth{
	clear:none !important;
	float:right;
}
li.leftHalf .small, li.rightHalf .small,
li.leftHalf .medium, li.rightHalf .medium,
li.leftThird .small, li.middleThird .small, li.rightThird .small,
li.leftThird .medium, li.middleThird .medium, li.rightThird .medium,
li.leftFourth .medium, li.middleFourth .medium, li.rightFourth .medium,
li.leftFourth .small, li.middleFourth .small, li.rightFourth .small,
li.leftFifth .medium, li.middleFifth .medium, li.rightFifth .medium,
li.leftFifth .small, li.middleFifth .small, li.rightFifth .small{
	width:100% !important;
}
form li.leftHalf, form li.leftThird, form li.leftFourth, form li.leftFifth{
	clear:left !important;
	float:left;
}

* html form li.middleFourth {
	margin-left: 1% !important;
}
* html form li.middleFifth {
	margin-left: 1% !important;
}

/* ----- INSTRUCTIONS ----- */

form li.focused{
 /*	background-color:#97D8FA; */
}
form .instruct{
	position:absolute;
	top:0;
	left:0;
	z-index:1000;
	width:45%;
	margin:0 0 0 8px;
	padding:8px 10px 10px 10px;
	border:1px solid #e6e6e6;
	background:#f5f5f5;
	visibility:hidden;
	opacity:0;
	font-size:105%;
	-webkit-transition: opacity 350ms ease-out;
	   -moz-transition: opacity 350ms ease-out;
	     -o-transition: opacity 350ms ease-out;
	        transition: opacity 350ms ease-out;
}
form .instruct small{
	line-height:120%;
	font-size:80%;
	color:#444;
}
form li.focused .instruct, form li:hover .instruct{
	left:100%; /* Prevent scrollbars for IE Instruct fix */
	visibility:visible;
	opacity:1;
}

/* ----- ALT INSTRUCTIONS ----- */

.altInstruct .instruct, li.leftHalf .instruct, li.rightHalf .instruct,
li.leftThird .instruct, li.middleThird .instruct, li.rightThird .instruct,
li.leftFourth .instruct, li.middleFourth .instruct, li.rightFourth .instruct,
li.leftFifth .instruct, li.middleFifth .instruct, li.rightFifth .instruct,
.iphone .instruct{
	visibility:visible;
	position:static;
	margin:0;
	padding:6px 0 0 0;
	width:100%;
	clear:left;
	background:none !important;
	border:none !important;
	font-style:italic;
	opacity:1;
}
.altInstruct p.complex , li.leftHalf p.complex, li.rightHalf p.complex,
li.leftThird p.complex, li.middleThird p.complex, li.rightThird p.complex,
.iphone p.complex{
	padding:0 0 9px 0;
}

/* ----- ADVANCED CLASSNAMES ----- */

.hideSeconds .seconds, .hideAMPM .ampm, .hideAddr2 .addr2, .hideSecondary #previousPageButton, 
.hideCents .radix, .hideCents .cents{
	display:none;
}

/* ----- SECTIONS ----- */

form li.section{
	clear:both;
	margin:0;
	padding:7px 0 0 0;
	width:auto !important;
	position:static;
}
form li.section h3{
	font-weight:normal;
	font-size:110%;
	line-height:135%;
	margin:0 0 3px 0;
	width:auto;
	padding:12px 1% 0 1%;
	border-top:1px dotted #ccc;
}
form li.first{
	padding:0;
}
form li.first h3{
	padding:8px 1% 0 1%;
	border-top:none !important;
}
form li.section div{
	display:block;
	width:auto;
	font-size:85%;
	line-height:160%;
	margin:0 0 1em 0;
	padding:0 1% 0 1%;
}
form li.section.scrollText{
	border:1px solid #dedede;
	height:150px;
	overflow:auto;
	margin-bottom:10px;
	padding:10px;
	-webkit-box-shadow:rgba(0,0,0,.15) 0 0 3px;
	-moz-box-shadow:rgba(0,0,0,.15) 0 0 3px;
	-o-box-shadow:rgba(0,0,0,.15) 0 0 3px;
	box-shadow:rgba(0,0,0,.15) 0 0 3px;
}
form li.section.scrollText h3{
	border:none;
	padding-top:8px;
}

/* ----- CAPTCHA ----- */

form li.captcha {
	width:auto !important;
	clear:both;
	border-top:1px dotted #ccc;
	margin-top:5px;
	padding:1.1em 1% 9px 1%;
	width:auto !important;
	position:static;
}
form li.captcha label.desc{
	width:auto !important;
	text-align:left;
	margin-bottom:4px;
	float:none;
}
*+html #recaptcha_area, *+html #recaptcha_table{
	min-width:450px !important;
}
* html #recaptcha_area, * html #recaptcha_table{
	width:450px !important;
}
#recaptcha_widget_div table{
	background:#fff;
}
form li.captcha .noscript iframe{
	border:none;
	overflow:hidden;
	margin:0;
	padding:0;
}
form li.captcha .noscript label.desc{
	display:block !important;
}
form li.captcha .noscript textarea{
	margin-left:12px;
}

/* ----- PAGINATION ----- */

form li.paging-context{
	clear:both;
	border-bottom:1px dotted #ccc;
	margin:0 0 7px 0;
	padding:5px 1% 10px 1%;
	width:auto !important;
	position:static;
}
.paging-context table{
	width:100%;
}

.pgStyle1 td{ /* Steps */
	text-align:left;
	vertical-align:middle;
}
.pgStyle1 td.c{
	width:22px;
}
.pgStyle1 td.t{
	padding:0 1%;
}
.pgStyle1 var{
	display:block;
	float:left;
	background:none;
	border:1px solid #CCC;
	color:#000;
	width:20px;
	height:20px;
	line-height:19px;
	text-align:center;
	font-size:85%;
	font-style:normal;
	
	-webkit-border-radius:10px;
	-moz-border-radius:10px;
	border-radius:10px;
	
	-webkit-box-shadow:rgba(0,0,0,.15) 0 1px 2px;
	-moz-box-shadow:rgba(0,0,0,.15) 0 1px 2px;
	-o-box-shadow:rgba(0,0,0,.15) 0 1px 2px;
	box-shadow:rgba(0,0,0,.15) 0 1px 2px;
}
.pgStyle1 .done var{
	background:#ccc;
}
.pgStyle1 .selected var{
	background:#FFF7C0;
	color:#000;
	border:1px solid #e6dead;
	font-weight:bold;
}
.pgStyle1 b{
	font-size:85%;
	font-weight:normal;
	color:#000;
}
.pgStyle1 .selected b{
	font-weight:bold;
}

.circle6 td, .circle7 td{
	vertical-align:top;
	text-align:center;
}
.nopagelabel td.t{
	display:none;
}
.nopagelabel .pgStyle1 var, .circle6 var, .circle7 var{
	width:24px;
	height:24px;
	line-height:24px;
	font-size:90%;
	margin:0 auto 7px auto;
	float:none;
	-webkit-border-radius:12px;
	-moz-border-radius:12px;
	border-radius:12px;
}
.nopagelabel .pgStyle1 var{
	margin-bottom:0;
}
.circle6 b, .circle7 b{
	padding:0;
}

.circle2 td{width:50%;}
.circle3 td{width:33%;}
.circle4 td{width:25%;}
.circle5 td{width:20%;}
.circle6 td{width:16.6%;}
.circle7 td{width:14.2%;}

.pgStyle2 td{ /* Percentage */
	vertical-align:middle;
	height:25px;
	padding:2px;
	border:1px solid #CCC;
	position:relative;
	-webkit-border-radius:14px;
	-moz-border-radius:14px;
	border-radius:14px;
	-webkit-box-shadow:rgba(0,0,0,.10) 1px 1px 1px;
	-moz-box-shadow:rgba(0,0,0,.10) 1px 1px 1px;
	-o-box-shadow:rgba(0,0,0,.10) 1px 1px 1px;
	box-shadow:rgba(0,0,0,.10) 1px 1px 1px;
}
.pgStyle2 var{ /* Percentage Bar */
	display:block;
	height:26px;
	float:left;
	background:#FFF7C0;
	color:#000;
	font-style:normal;
	text-align:right;
	-webkit-border-radius:12px;
	-moz-border-radius:12px;
	border-radius:12px;
	-webkit-box-shadow:rgba(0,0,0,.15) 1px 0 0;
	-moz-box-shadow:rgba(0,0,0,.15) 1px 0 0;
	-o-box-shadow:rgba(0,0,0,.15) 1px 0 0;
	box-shadow:rgba(0,0,0,.15) 1px 0 0;
}
.pgStyle2 var b{/* Percentage # */
	display:block;
	float:right;
	font-size:100%;
	padding:3px 10px 3px 3px;
	line-height:19px;
}
.pgStyle2 em{/* Page Title */
	font-size:85%;
	font-style:normal;
	display:inline-block;
	margin:0 0 0 9px;
	padding:4px 0;
	line-height:18px;
}
.pgStyle2 var em{
	padding:4px 5px 3px 0;
}
.page1 .pgStyle2 var{
	padding-left:7px;
	text-align:left;
	background:none;
	-webkit-box-shadow:none;
	-moz-box-shadow:none;
	-o-box-shadow:none;
	box-shadow:none;
}
.page1 .pgStyle2 b{
	float:none;
	padding-right:0;
}

.hideMarkers .marker, .nopagelabel .pgStyle1 b, .nopagelabel .pgStyle2 em{
	display:none !important;
}

/* ----- ERRORS ----- */

#errorLi{
	width:99%;
	margin:15px auto 15px auto;
	background:#fff !important;
	border:1px solid red;
	text-align:center;
	padding:1em 0 1em 0;
	-webkit-border-radius:20px;
	-moz-border-radius:20px;
	border-radius:20px;
}
#errorMsgLbl{
	margin:0 0 5px 0;
	padding:0;
	font-size:125%;
	color:#DF0000 !important;
}
#errorMsg{
	margin:0 0 2px 0;
	color:#000 !important;
	font-size:100%;	
}
/*#errorMsg b{
	padding:2px 8px;
	background-color: #FFDFDF !important;
	color:red !important;
	-webkit-border-radius:10px;
	-moz-border-radius:10px;
	border-radius:10px;
}*/
form li.error{
	display:block !important;
	background-color: #FFDFDF !important;
	margin-bottom:3px !important;
}
form li label.error, form li input.error{
	color:#DF0000 !important;
	font-weight:bold !important;
}
form li input.error,form li textarea.error{
	background:#fff !important;
	border:2px solid #DF0000 !important;
	color:#DF0000 !important;
}

form li textAreaHere input.error{
	background:#fff !important;
	border:2px solid #DF0000 !important;
}




form li.error label, form li.error span.symbol{
	color:#000 !important;
}
form li.error .desc{
	color:#DF0000 !important;
}
form p.error{
	display:none;
	margin:0 !important;
	padding:7px 0 0 0 !important;
	line-height:10px !important;
	font-weight:bold;
	font-size:11px;
	color:#DF0000 !important;
	clear:both;
}
.public_register_cointainer_IInd
{

    border: 1px solid #4FBCF3;
    float: left;
  /*  margin: 0 5px; */
    min-height: 500px;
    width: 949px;
	margin-bottom:10px;
	padding-top:12px;
}
form li.error p.error{
	display:block;
}
form li.complex p.error{
	padding:0 0 9px 0 !important;
}
.userUploadImg{margin-bottom:10px;}
</style>
<div id="content">
	<div class="stepsHeadingNew">
		<?php if(!isset($user))
			{
			?>  
			<div class="newProgressBarOuter">
				<div class="proBarsSection2">
					<span class="spanNo">1</span>
					<span class="spanOnHover">Registration</span>
				</div>
				<?php
				if($this->data['Member']['group_id']==7)
				{
				?>
				<!--<div class="proBarsSection3">
					<span class="spanNo">2</span>
					<span class="spanOnHover">Tutor Payment</span>
				</div>
				<div class="proBarsSection3">
					<span class="spanNo">3</span>
					<span class="spanOnHover">Set Availablity</span>

				</div>
				<div class="proBarsSection3">
					<span class="spanNo">4</span>
					<span class="spanOnHover">Add Courses</span>
				</div>-->
				<?php
				}
				?>
			</div>
		<?php
		}
		?>
		<h1>
			<?php if(isset($user) && $user!='')
			{
				echo 'Edit Profile';
			}
			else
			{
				echo 'Registration';
			}
			?>
		</h1>
	</div>
	<div class="public_register_cointainer_IInd">
		<div id="registration">
			<div class="regLeftCont">
            
      
              <div class="student-profile-img" style="margin-left:10px;width:184px; position:relative;">
		<!--		<div style="margin-left:10px;width:184px;">-->
                
				<!--	<div class="userUploadImg" style="border:1px solid #ACDFFB;width:auto;padding:1px;max-width:184px;">-->
                    
                     <div class="profileAjaxImage" style="width:auto;padding:1px;max-width:184px;">
                    
                    
						<?php
						if(isset($picture) && !empty($picture)){
							echo $html->image("members/".$picture['UserImage']['image_name'],array('style'=>'margin:0;float:none;width:auto;max-width:180px;'));
						} else {
						?>
						<img src="https://graph.facebook.com/<?php echo $this->Session->read('Member.facebook_id'); ?>/picture?type=large" style="margin:0;float:none;width:auto;max-width:180px;" />
						<?php        
						} ?>
					</div>
                    
                    <div class="profileAjaxImage2">
                    <?php echo $html->image("frontend/ajax-loader.gif") ?>
                    </div>
                    
					<div style="clear:both"></div>
					<div id="errorMsg" style="width:180px;"></div>
					<div class="imageChange" style="width:180px;">Change Profile Picture</div>
                    
                    
                    <?php if($this->Session->read('Member.group_id')==7 || $this->Session->read('Member.group_id')==8)
					{
					?>	
                    
                    <div class="stepFormContButton button" style="margin-left: 0px; width: 188px; margin-top: 5px;">  
                    	<span></span>
                        <a href="javascript:void(0);"><input type="button" id="fb-auth" value="Link with Facebook" /></a>
                    </div>
                   
                   <?php
					}
				   ?>
                    
                    
                    
				</div>
                
                
                
                
                
                
                
                
                 <form name="fb_registration_form" id="fb_registration_form" action="<?php echo HTTP_ROOT.'members/savefbid';?>" method="post">
           
           <input type="hidden" name="data[Member][facebookId]" id="facebook_id_fb" value="" />
           
           </form>
           
           
                
                <div class="stepThreeFormRgtCont">
                    <div class="stepThreeFormRgtOtherCont">
                    
                   	 <?php echo $rightText['Page']['body'];?>
                     	
                    </div>
                </div>
                
                
                
                
                
                
			</div>
			<?php
			echo $form->create('Member', array("url"=>array('controller'=>'members', 'action'=>'addmember'))); 
			?>
			<input type="hidden" value="<?php echo $this->data['Member']['id']?>" name="data[Member][id]" id="Memberid" style="color:#F00" />
            
              <input type="hidden" name="data[Member][facebookId]" id="facebook_id" value="<?php if($this->Session->read('Member.facebook_id'))
			{
				echo $this->Session->read('Member.facebook_id');	
			}?>" />
            
            
            
			<?php if(isset($user) && $user!='')
			{
			?> 
			<input type="hidden" value="<?php echo $user?>" name="data[Member][user]"  style="color:#F00" />
			<?php	 
			}
			?>
				<div class="stepFormThird">
					<ul>
						<li class="stepThreeFormRow">
							<?php echo $form->input('userMeta.fname',array( 'label'=>'<b>First Name:<span class="red" >*</span></b>','class'=>'textInStepFrm field required','maxlength'=>40));?>
						</li>
						<li class="stepThreeFormRow">
							<?php echo $form->input('userMeta.lname',array('label'=>'<b>Last Name:<span class="red" >*</span></b>','class'=>'textInStepFrm field ','maxlength'=>40));?>
						</li>
						<li class="stepThreeFormRow">
							<?php echo $form->input('email', array( 'label'=>'<b>Email:<span class="red" >*</span></b>','class'=>'textInStepFrm field required email','maxlength'=>100));?>
						</li>
                        
                        
                        
                        <?php
						if($this->Session->read('Member.group_id')=='6')
						{
						?>
                        <li class="stepThreeFormRow">
			      	<?php echo $form->input('userMeta.cause_name',array('label'=>'<b>Cause Name:<span class="red" >*</span></b>','class'=>'textInStepFrm field required','maxlength'=>75));?>
						</li>
                        <?php
						}
						?>
                        
                        
                        
                            <li class="stepThreeFormRow">
                        <label><b>School:<span class="red">*</span></b></label>
                        
                        <?php
						if($this->Session->read('Member.group_id')=='6')
						{
						?>
                        <select multiple="multiple" size="4" name="data[CauseSchool][school_id][]" id="schoolid" style="width: 22em;" class="required">
							<?php foreach($schools as $key=>$value){ ?>
                            <option value="<?php echo $key;?>"  <?php if(in_array($key,$causeSchools)){ echo "selected"; } ?> ><?php echo $value;?></option>
                            <?php } ?>
                            </select>
                        <?php 
						}
						else
						{
						?>
                          <select id="schoolname" class="selectStepFrm required" name="data[Member][school_id]">
                                <option value="" >Please select</option>
                                <?php
                                foreach($schools as $key=>$value)
                                {
                                ?>	
                                    <option value="<?php echo $key;?>" 
                                    <?php
                                    if($this->data['Member']['school_id']==$key)
									echo "selected=\"selected\"";
									?> ><?php echo $value;?></option>	
                                    
                                <?php    
                                }
                                ?>
                            </select>
                        <?php
						}
						?>
                        </li>
                        
                        
                        
                       
                        
                         <?php
						if($this->Session->read('Member.group_id')=='6')
						{
						?>
                        <div style="padding-left:188px;">
                        (Press Ctrl key to select multiple schools)
                        </div>
                        <?php
						}
						?>
                        
                        
                        
                        
						
						<li>
							<h2><span style="color: rgb(33, 158, 218); opacity: 0.4; font-size: 18px;">Optional Information</span><span style="font-size: 10px; opacity: 12 ! important; float: left; color: rgb(27, 143, 216); padding-top: 6px; cursor:pointer;" id="optional">(Show)</span></h2>
						</li>
                        
                        
                        <div id="optionalinfo">
                        
                        <li class="stepThreeFormRow">
							<?php echo $form->input('userMeta.contact', array( 'label'=>'<b>Phone:</b>', 
						'class'=>"textInStepFrm field phoneUS"));?>
						</li>
                        
                        
                        
						<li class="stepThreeFormRow">
							<?php echo $form->input('userMeta.address', array('type'=>'textarea',  'rows'=>'3', 'cols'=>'48','label'=>'<b>Street Address:<span class="red" ></span></b>', 'class'=>'textInStepFrm field textAreaHere alpha_num'));?>
						</li>
						<li class="stepThreeFormRow">
							<?php echo $form->input('userMeta.city', array( 'label'=>'<b>City:<span class="red" ></span></b>', 
						'class'=>"textInStepFrm field letters"));?>
						</li>
						<li class="stepThreeFormRow">
							<div class="input text">
								<label for="state"><b>State<span class="red" ></span></b>:</label>
								<select class="selectStepFrm field" name="data[userMeta][state]" id="state">
									<option value="">Select State</option>
										<?php
										foreach ( $states as $key => $val ) {
										?>
									<option value="<?php echo $val; ?>"
										<?php
											if($this->data['userMeta']['state']==$val)
											echo "selected=\"selected\"";
										?>
									><?php echo $val; ?></option>
									<?php  
									}
									?>
								</select>
							</div>   
						</li>
					<li class="stepThreeFormRow stepThreeFormRow1">
					<?php echo $form->input('userMeta.zip', array( 'label'=>'<b>Zip:</b>', 
					'class'=>'textInStepFrm field postalcodeonly' ,'id'=>'zipcode'));?>
					
					</li>
                    <li class="stepThreeFormRow">
					<?php echo $form->input('userMeta.biography', array( 'label'=>'<b>About Me:<span class="red" ></span></b>', 
					'class'=>'textInStepFrm field'));?>
					</li>
				<?php /*<li>
						<label style="font-size:16px;font-weight:bold;">Allow Facebook?</label>
						<?php echo $form->input('userMeta.fb_allow', array( 'label'=>false,'style'=>'margin:2px auto 2px 23px;','type'=>'checkbox','div'=>false));?>
					</li> */
					?>
					
                    <?php if(!isset($user))
						{
						?>
                  	 <li>
						<label style="font-size:16px;font-weight:bold;">Allow Email?</label>
						<?php echo $form->input('userMeta.email_allow', array( 'label'=>false,'style'=>'margin:2px auto 2px 56px;','type'=>'checkbox','checked'=>true,'div'=>false));?>
					</li>
                    <?php
						}
						else
						{
					?>
                    <li>
						<label style="font-size:16px;font-weight:bold;">Allow Email?</label>
						<?php echo $form->input('userMeta.email_allow', array( 'label'=>false,'style'=>'margin:2px auto 2px 56px;','type'=>'checkbox','div'=>false));?>
					</li>
                    <?php
						}
					?>
                
                    
                    </div>
                 
					<?php if(!isset($user))
						{
						?>	 
                          <li>
                          <label style="font-size:16px;font-weight:bold;">I agree to the TutorCause <a href="<?php echo HTTP_ROOT;?>standard_terms" style="color: #1B8FD8; text-decoration:underline;">Terms of Service</a></label>
                          <input type="checkbox" name="tos" value="1" class="textInStepFrm field required" />
			              </li>
						<?php
						}
                    ?>	 
                    
                    
      
            
                    
					</ul>
				 <div class="stepFormContButton button" id="submitbutton" style="margin-left:190px;">
						<span></span>
						<input type="submit"  value="<?php if(isset($user) && $user!='')
						{
							echo 'Save Profile';
						}
						else if($this->data['Member']['group_id']==6)
						{
							echo 'Join as Cause';
						}
						else if($this->data['Member']['group_id']==7)
						{
							echo 'Join as Tutor';
						}
						else if($this->data['Member']['group_id']==8)
						{
							echo 'Join as Student';
						}
						?>" /> 
							</div>
			</div>
		</div>

		<?php echo $form->end();?> 
    
        
	</div>
</div>