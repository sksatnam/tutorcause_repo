<script type="text/javascript">
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
		
		

</script>





        
        <?php
		
		
		$intraised = (integer)$getBalance['userMeta']['amount_raised'];
		$intgoal = (integer)$getBalance['userMeta']['goal'];
		$percentage = ($intraised/$intgoal)*100; 
		$height = $percentage*2;
		
	/*	echo 'height'.$height;
		echo 'percent'.$percentage;
	*/	
		?>
        
        
        
        <!--Right Sidebar Begin Here-->
        
        
                <div class="right-sidebar" style="position:relative !important;">
                  <h2>Fundraising Goal</h2>
                  <div class="fundraising">
                  	<div class="fundraising-wrap">
                    <div style="width:154px;"> 
        

<div class="flipPad" style="position: absolute; top: 267px; left: 10px; width: 142px; z-index: 100; margin-top:5px; margin-left:20px;">
<div style="float: left; width: 50px;"><a href="javascript:void(0);" class="top" rel="bt" rev="#ccc"><img src="http://www.myefi.com/thermometer-lrg/images/edit.png" border="0" onclick="javascript:editflip();"></a> </div>
<div style="float: right; width: 43px;"><a href="javascript:void(0);" class="revert" rel="bt" rev="#ccc"><img src="http://www.myefi.com/thermometer-lrg/images/cancel.png" border="0" onclick="javascript:cancelflip();"></a></div>
</div>

      
<div style="float: left; width: 154px; height: 434px;  ">

<div id="flipbox" style="text-align:center;">
<div style="width: 154px; height: 65px;"><img src="http://www.myefi.com/thermometer-lrg/images/header.jpg" alt="Fundraising Ideas" border="0"></div>
<div style="width: 154px; height: 141px; background-image: url(&quot;http://www.myefi.com/thermometer-lrg/images/goal-bg.jpg&quot;); background-repeat: no-repeat;">
<div style="padding: 15px 20px 0pt 10px; text-align: center; font-size: 30px; color: rgb(113, 144, 197);">
<?php if($intgoal)
{
echo '$'.$intgoal; 	
}
else
{
echo '$0';
}
?>
</div>
<div style="font-size: 12px; padding-right: 5px; color: rgb(160, 176, 129); text-align: center;">Our Goal</div>
<div style="padding: 10px 20px 0pt 10px; text-align: center; font-size: 30px; color: rgb(113, 144, 197);">
<?php if($intraised)
{
echo '$'.$intraised; 	
}
else
{
echo '$0';
}
?>


</div>
<div style="font-size: 12px; padding-right: 5px; color: rgb(160, 176, 129); text-align: center;">Raised so far</div>
</div>
</div>




<div style="height: 229px;" class="thermometerbg">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
<td style="padding: 0pt 0pt 0pt 64px;" valign="bottom" height="234"><div style="height: <?php echo $height.'px';?>; width: 15px; background-color: rgb(150, 188, 94); border-left: 1px solid rgb(116, 160, 80); border-right: 1px solid rgb(116, 160, 80); max-height: 200px;"></div></td>
</tr>
</tbody></table>
</div>
</div>  
	
<div style="width: 1px; height: 1px; overflow: hidden; clear: both;">

    <div id="content" style="height: 206px;">
    <div id="update_form" style="height: 206px;">
    <form method="post" action="<?php echo HTTP_ROOT.'members/update_amount_raised';?>">
    <table width="100%" border="0" cellpadding="1" cellspacing="0">
    <tbody><tr>
    <td style="padding: 0pt 5px;">Goal:</td></tr>
    <tr><td style="padding: 0pt 5px;"><input name="data[cause][goal]" id="goal" value="<?php echo $getBalance['userMeta']['goal'];?>" style="width: 110px;" type="text"></td>
    </tr>
    
    <?php /*?> <tr>
    <td style="padding: 0pt 5px;">Amount Raised:</td></tr>
    <tr><td style="padding: 0pt 5px;"><input name="data[cause][raised]" id="raised" value="<?php echo $getBalance['userMeta']['amount_raised'];?>" style="width: 110px;" type="text" readonly="readonly" ></td>
    </tr>
    <tr><td style="padding: 0pt 5px;">Password:</td></tr>
    <tr><td style="padding: 0pt 5px;"><input name="passw" id="passw" style="width: 110px;" type="password"></td>
    </tr><?php */?>
    
    
    <tr><td align="center"><input value="Update" class="therm-update" type="submit"></td></tr>
    </tbody></table>
    </form>
    </div>
    </div>
    
    
    <div id="content1">
        <div style="width: 154px; height: 65px;"><img src="http://www.myefi.com/thermometer-lrg/images/header.jpg" alt="Fundraising Ideas" border="0"></div>
        <div style="width: 154px; height: 141px; background-image: url(&quot;http://www.myefi.com/thermometer-lrg/images/goal-bg.jpg&quot;); background-repeat: no-repeat;">
        <div style="padding: 15px 20px 0pt 10px; text-align: center; font-size: 30px; color: rgb(113, 144, 197);">
			<?php if($getBalance['userMeta']['goal'])
            {
            echo '$'.$getBalance['userMeta']['goal']; 	
            }
            else
            {
            echo '$0';
            }
            ?>
        </div>
        <div style="font-size: 12px; padding-right: 5px; color: rgb(160, 176, 129); text-align: center;">Our Goal</div>
        <div style="padding: 10px 20px 0pt 10px; text-align: center; font-size: 30px; color: rgb(113, 144, 197);">
		<?php if($getBalance['userMeta']['amount_raised'])
        {
        
        $intamount = (integer)$getBalance['userMeta']['amount_raised'];
        echo '$'.$intamount; 	
        }
        else
        {
        echo '$0';
        }
        ?>
        </div>
        <div style="font-size: 12px; padding-right: 5px; color: rgb(160, 176, 129); text-align: center;">Raised so far</div>
        </div>
    </div>
    
    
    <div style="height: 206px; text-align: center; background-color: rgb(243, 216, 216);" id="content2">Sorry the password you entered is incorrect! Click the button below and it will be emailed to the email on file.
    <form method="post"><input type="hidden" value="true" name="email"><input type="submit" value="Email Me!"></form>
    <br><a window.location.href="window.location.href&quot;" onclick="" href="">Try again</a>
    </div>
    
    
    </div>


<div style="width:92px; height:58px;"><a href="http://www.easy-fundraising-ideas.com/programs/school-fundraising-ideas/"><img src="http://www.easy-fundraising-ideas.com/widgets/thermometer/lrg/images/therm-bot.jpg" border="0" style="padding:0; margin:0; border:none;" alt="School Fundraising"></a></div>
<div style="width:154px; height:35px; background-image:url(http://www.easy-fundraising-ideas.com/widgets/thermometer/lrg/images/therm-bot-bg.jpg); background-repeat:no-repeat; font-size:9px">

</div>

					</div>
                    </div> 
                    </div>
                    </div>
                
                



        
        
        
        
        
        
        <!--Right Sidebar End Here--> 
        

        
             <div id="causewithreq" title="Dialog Title" style="display:none;">
            <p>Click on send button to withdrawal money</p>
</div>
        
        
        
        
