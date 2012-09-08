<?php //3aug2012 ?><script type="text/javascript">if (window.location.hash == '#_=_')window.location.hash = '';</script>

 <div class="middleContainer">
 <?php //	echo $this->Session->flash(); ?>
	 <div class="classifiedheading">
	 <div style="float:left; width:916px; border:1px solid #ccc; border-radius:5px; -moz-border-radius:5px;  padding: 0 0 10px 20px;">
		<h3><?php echo $statdatas['Page']['name'];?></h3>
		<div style="clear: both;"></div>
		<div class="faqsx" style="width:900px;font-size:12px; padding-left:10px;">
			<div class="tinymcestaticdata">
            	<?php echo $statdatas['Page']['body'];?>	
				<br>
			</div>
            
		</div>
        
         <div class="serchBtnContButton button">
                <span></span>
                <input type="submit" value="Register Again" onclick="javascript:location.href='<?php echo HTTP_ROOT.'homes/register_again';?>'"> 
            </div>
        
	</div>
	</div>
</div>


