<?php 
/*echo '<pre>';
print_r($dynamictext);
die;
*/

?>
<style type="text/css">
#middlecontent{
	background: none !important;
	border: 0px solid #CCCCCC !important;
	}
</style>


<div id="banner">
	<div id="register-wrap">
    	<a id="register-btn" title="Register Now" href="<?php echo $facebookURL; ?>"></a>
        <div id="btn-shadow"></div>
        <div id="like-btn">
        	<!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style ">
            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
            <a class="addthis_button_tweet"></a>
            </div>
            <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e82e8c80df566ae"></script>
            <!-- AddThis Button END -->
        </div>
    </div>
    
</div>
<div id="features">
	<div id="tutor">
    	<div class="join">
        	<h1>
				<?php echo $html->image('frontend/tutor-txt.png',array('width'=>'188px','height'=>'25px')); ?>
			</h1>
            <a title="Join Now" href="<?php echo $facebookURL; ?>"></a>
            <?php echo $html->image('frontend/tutor.png',array('width'=>'270px','height'=>'281px')); ?>
        </div>
        <h3 class="features-txt">Earn More Money</h3>
    </div>
    <div id="student">
    	<div class="join">
        	<h1>
				<?php echo $html->image('frontend/student-txt.png',array('width'=>'229px','height'=>'25px')); ?>
			</h1>
            <a title="Join Now" href="<?php echo $facebookURL; ?>"></a>
            <?php echo $html->image('frontend/student.png',array('width'=>'154px','height'=>'281px')); ?>
        </div>
        <h3 class="features-txt">Achieve the grade</h3>
    </div>
    <div id="cause">
    	<div class="join">
        	<h1>
				<?php echo $html->image('frontend/cause-txt.png',array('width'=>'199px','height'=>'25px')); ?>
			</h1>
            <a title="Join Now" href="<?php echo $facebookURL; ?>"></a>
            <?php echo $html->image('frontend/cause.png',array('width'=>'148px','height'=>'281px')); ?>
        </div>
        <h3 class="features-txt">Earn More Money</h3>
    </div>
</div>