 <div class="middleContainer">
	 <div class="classifiedheading">
         <div style="float:left; width:916px; margin:15px 0; border:1px solid #ccc; border-radius:5px; -moz-border-radius:5px; padding: 20px;">
            <h3>FAQ's Tutor</h3>
            <div style="clear: both;"></div>
             <div class="faqOuterBox">
             
             <?php
			 foreach($tutorfaq as $tf)
			 {
             ?>
                <div class="faqInnerBox">
                    <div class="faqQues">
                        <b>Ques:</b> <span><?php echo $tf['Faq']['question'].' '.'?';?></span>
                    </div>
                    <div class="faqAnswer">
                        <b>Ans:</b> <span><?php echo $tf['Faq']['answer'];?></span>
                    </div>
                </div> <!--faqInnerBox-->
             <?php 
			 }
			 ?>
                
                
            </div> <!--faqOuterBox-->
        </div>
	</div>
</div>