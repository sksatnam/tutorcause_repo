<script type="text/javascript" src="jquery.rating.js" ></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#rate1').rating('rating/?by=knowledge', {maxvalue:5, increment:.5});
	$('#rate2').rating('rating/?by=ability', {maxvalue:5, increment:.5});
});
</script>

<style type="text/css">

	

/*.rating {
	cursor: pointer;
	margin: 0px;
	clear: both;
	display: block;
}
.rating:after {
	content: '.';
	display: block;
	height: 0;
	width: 0;
	clear: both;
	visibility: hidden;
}
.cancel,
.star {
	float: left;
	width: 17px;
	height: 15px;
	overflow: hidden;
	text-indent: -999em;
	cursor: pointer;
}
.star-left,
.star-right {
  width: 8px
}


.star,
.star a {background: url(images/star.gif) no-repeat 0 0px;}
.star-left,
.star-left a {background: url(images/star-left.gif) no-repeat 0 0px;}
.star-right,
.star-right a {background: url(images/star-right.gif) no-repeat 0 0px;}
	
.cancel a,
.star a {
	display: block;
	width: 100%;
	height: 100%;
	background-position: 0 0px;
}

div.rating div.on a {
	background-position: 0 -16px;
}
div.rating div.hover a,
div.rating div a:hover {
	background-position: 0 -32px;
}
}
*/
</style>


<div id="content">
	<div class="stepsHeadingNew">
		<div class="newProgressBarOuter">
			<div class="proBarsSection2">
				<span class="spanNo">1</span>
				<span class="spanOnHover">Select Course</span>

			</div>
			<div class="proBarsSection3">
				<span class="spanNo">2</span>
				<span class="spanOnHover">Scheduling an Appointment</span>
			</div>
			<div class="proBarsSection3">
				<span class="spanNo">3</span>
				<span class="spanOnHover">Paying for an Appointment</span>
			</div>
			 <div class="proBarsSection3">
				<span class="spanNo">4</span>
				<span class="spanOnHover">Rate Tutor</span>
			</div>
		</div>
		<h1>Tutor Rating</h1>
	</div>
	<?php echo $this->Form->create('Member',array('action' => 'save_rating')); ?>
	<div class="school-info-field">
		<div class="stepThreeFormRow" style="width:600px;">
			<div style="float:left;width:160px;text-align:right;">Knowledge of Subject</div>
			<div style="float:left;width:300px;margin-left:20px;">
				<div class="rating" id="rate1">
					<div class="star star-left on">
						<a title="Give it 0.5/5" href="#0.5" style="width: 100%;">0.5</a>
					</div>
					<div class="star star-right on">
						<a title="Give it 1/5" href="#1" style="width: 100%;">1</a>
					</div>
					<div class="star star-left on">
						<a title="Give it 1.5/5" href="#1.5" style="width: 100%;">1.5</a>
					</div>
					<div class="star star-right">
						<a title="Give it 2/5" href="#2" style="width: 100%;">2</a>
					</div>
					<div class="star star-left">
						<a title="Give it 2.5/5" href="#2.5" style="width: 100%;">2.5</a>
					</div>
					<div class="star star-right">
						<a title="Give it 3/5" href="#3" style="width: 100%;">3</a>
					</div>
					<div class="star star-left">
						<a title="Give it 3.5/5" href="#3.5" style="width: 100%;">3.5</a>
					</div>
					<div class="star star-right">
						<a title="Give it 4/5" href="#4" style="width: 100%;">4</a>
					</div>
					<div class="star star-left">
						<a title="Give it 4.5/5" href="#4.5" style="width: 100%;">4.5</a>
					</div>
					<div class="star star-right">
						<a title="Give it 5/5" href="#5" style="width: 100%;">5</a>
					</div>
				</div>
			</div>
			<div style="clear:both"></div>
			
		</div>
		<div class="stepThreeFormRow" style="width:600px;">
			<div style="float:left;width:160px;text-align:right;">Ability to Teach:</div>
			<div style="float:left;width:300px;margin-left:20px;">
				<div class="rating" id="rate2">
					<div class="star star-left on">
						<a title="Give it 0.5/5" href="#0.5" style="width: 100%;">0.5</a>
					</div>
					<div class="star star-right on">
						<a title="Give it 1/5" href="#1" style="width: 100%;">1</a>
					</div>
					<div class="star star-left on">
						<a title="Give it 1.5/5" href="#1.5" style="width: 100%;">1.5</a>
					</div>
					<div class="star star-right">
						<a title="Give it 2/5" href="#2" style="width: 100%;">2</a>
					</div>
					<div class="star star-left">
						<a title="Give it 2.5/5" href="#2.5" style="width: 100%;">2.5</a>
					</div>
					<div class="star star-right">
						<a title="Give it 3/5" href="#3" style="width: 100%;">3</a>
					</div>
					<div class="star star-left">
						<a title="Give it 3.5/5" href="#3.5" style="width: 100%;">3.5</a>
					</div>
					<div class="star star-right">
						<a title="Give it 4/5" href="#4" style="width: 100%;">4</a>
					</div>
					<div class="star star-left">
						<a title="Give it 4.5/5" href="#4.5" style="width: 100%;">4.5</a>
					</div>
					<div class="star star-right">
						<a title="Give it 5/5" href="#5" style="width: 100%;">5</a>
					</div>
				</div>
			</div>
			<div style="clear:both"></div>
		</div>
		<div class="stepFormContButton button" style="margin:0px 0px 20px 240px;">
			<span></span>
			<input type="hidden" value="sub" name="data['Member']['hid']" />
			<input type="submit" value="Submit" />
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
    
				<div class="myrating" id="rate3">
					
					<div class="mystar">
						<a title="Give it 1/5" href="#1" style="width: 100%; background-position: 0 -16px;">1</a>
					</div>
					
					<div class="mystar ">
						<a title="Give it 2/5" href="#2" style="width: 100%;">2</a>
					</div>
					
					<div class="mystar ">
						<a title="Give it 3/5" href="#3" style="width: 100%;">3</a>
					</div>
					
					<div class="mystar ">
						<a title="Give it 4/5" href="#4" style="width: 100%;">4</a>
					</div>
				
					<div class="mystar ">
						<a title="Give it 5/5" href="#5" style="width: 100%;">5</a>
					</div>
				</div>
		
    
    
</div>            