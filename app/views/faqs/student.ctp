<?php //3aug2012 ?> <div class="middleContainer">
	 <div class="classifiedheading">
         <div style="float:left; width:916px; margin:15px 0; border:1px solid #ccc; border-radius:5px; -moz-border-radius:5px; padding: 20px;">
            <h3>FAQ's Student</h3>
            <div style="clear: both;"></div>
             <div class="faqOuterBox">
             
             <?php
			 foreach($studentfaq as $sf)
			 {
             ?>
                <div class="faqInnerBox">
                    <div class="faqQues">
                        <b>Ques:</b> <span><?php echo $sf['Faq']['question'].' '.'?';?></span>
                    </div>
                    <div class="faqAnswer">
                        <b>Ans:</b> <span><?php echo $sf['Faq']['answer'];?></span>
                    </div>
                </div> <!--faqInnerBox-->
             <?php 
			 }
			 ?>
                
                
            </div> <!--faqOuterBox-->
        </div>
	</div>
</div>