<?php //3aug2012 ?><div id="mainCotent">
<!--content-->
<div id="content">

<div id="setContentBg">

<div id="leftContent">
      
        
        
        <div class="topCatagoriesContainer">
<div class="topCatagoriesImgTop">
</div>

<div class="topCatagoriesImgMid">
    <div class="catagoryInnerContainer">

        	<div class="SchoolfeaturedHeading" style="width:594px;">
        		FAQ's School
            </div>
			
			<?php foreach($faqs as $faq){?>
		    <div class="faqsx" style="float:left;">
					<div class="faqquestion">
						<div class="faqquestionbody" style="width:565px; text-align:justify;">
							Ques : <?php echo $faq['Faq']['question'] ?>
						</div>
						
					</div>

					<div class="faqanswer" style="width:565px; text-align:justify;">
						<b>Ans :</b> <?php echo str_replace('<p>','',$faq['Faq']['answer']) ?>
					</div>
			</div>
			<?php }?>
        
        
    </div>
</div>

<div class="topCatagoriesImgBot">
</div>
</div>
<!-- start question container -->



<!-- end question container -->
    
</div>
<!-- end left container -->
    
      <!-- start right container -->
    	<?php echo $this->renderElement('userElements/right_panel'); ?> 
    <!-- end right container -->
    </div>
</div>
<!--content-->
</div>