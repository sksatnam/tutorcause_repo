<script type="text/javascript">
jQuery(document).ready(function() {

$('#dialogmsg').dialog({
        autoOpen: false,
        title:"Send Message",
        width: 450,
        modal:true,
        buttons: {
        "Ok": function() {
            $(this).dialog("close");
        }
        }
    });	


$('#dialogmsg3').dialog({
        autoOpen: false,
        title:"Send Message",
        width: 450,
        modal:true,
        buttons: {
        "Ok": function() {
            $(this).dialog("close");
        }
        }
    });	
	
 });
 
 function dialogmsg(){
		$("#dialogmsg").dialog("open");
		return false;
 }
 
 
  function dialogmsg3(){
		$("#dialogmsg3").dialog("open");
		return false;
 }

</script>



<div class="public_profile_cointainer_Ist">

<div style="margin:20px 5px 5px 20px;text-align:left;">
		<div style="clear:both"></div>
		<div class="profileImage" style="padding:1px;border:1px solid #ACDFFB;height:auto;margin-bottom:10px;">
			<?php
			
				if(isset($picture) && !empty($picture)){
					echo $html->image("members/".$picture['UserImage']['image_name'],array('style'=>'margin:0;float:none;width:auto;max-width:180px;'));
				} else {
					?>
						 <img src="<?php echo FIMAGE.'cause-logo.gif'?>" style="margin:0;float:none;width:auto;max-width:180px;" />
				 <?php        
				}
			?>
		</div>
		<div style="clear:both"></div>
		
	</div>
    <br />
    

  <?php if($this->Session->read('Member.memberid'))
		{
			?>
	
	<div class="sideFirst">
		<?php echo $html->image('frontend/message.jpg',array('style'=>'width:20px;height:20px;margin-top:30px;'))?>
	</div>
   
	<div class="sideSecond" style="border-left-width: 0px; margin-left: 70px; margin-top: 2px;">
	
		<?php
		if($getBalance['Member']['id'] != $this->Session->read('Member.memberid'))
			{
			?>
			<a class="sendMessage" href="#" onclick="return false;">Send Message</a>
			<?php
			}
		else
			{
			?>
			<a href="javascript:void(0);" onclick="dialogmsg();return false;" >Send Message</a>
			<?php
			}
		?>
		<input type="hidden" class="resultId" value="<?php echo $getBalance['Member']['id'];?>" />
		<input type="hidden" class="resultName" value="<?php echo $getBalance['userMeta']['cause_name']?>" />
	</div>
	<div class="clear"></div>
    
    <?php
		}
	    else
        {
        ?>
        
        <div class="sideFirst">
        <?php echo $html->image('frontend/message.jpg',array('style'=>'width:20px;height:20px;margin-top:30px;'))?>
        </div>
        
        <div class="sideSecond" style="border-left-width: 0px; margin-left: 70px; margin-top: 2px;">
        
        <a href="javascript:void(0);" onclick="dialogmsg3();return false;" >Send Message</a>
        
        
        </div>
        <div class="clear"></div>

        
        <?php
        }
     ?>

    
    
    
    
    
    
    
    
    <?php /*?><li style="padding-left:5px;width:240px;">
							<div class="searchResultLeft">
							<?php
								echo $html->image("frontend/send_message.png",array('style'=>'width:18px;height:18px;'));
							?>
							</div>
							<div class="searchResultCenter">
								<a class="sendMessage" href="#" onclick="return false;">Send Message</a>
								<input type="hidden" class="resultId" value="<?php echo $ft['Member']['id'];?>" />
								<input type="hidden" class="resultName" value="<?php echo $ft['Member']['userMeta']['fname'].' '.$ft['Member']['userMeta']['lname'];?>" />
							</div>
							<div class="srarchResultRight"><?php echo $html->image("icon-blue-arrow.png",array('style'=>'width:20px; height:20px;'))?></div>
						</li><?php */?>
</div>    


<div id="dialogmsg" title="Dialog Title" style="display:none;">
            <p style="margin-left:15px;">You can not send  &nbsp;&nbsp;<span style="color:#F00" >Message</span>&nbsp;&nbsp;yourself</p>
</div>       
<?php //3aug2012 ?>

<div id="dialogmsg3" title="Dialog Title" style="display:none;">
            <p style="margin-left:15px;">Please login to send  &nbsp;&nbsp;<span style="color:#F00" >Message</span>&nbsp;&nbsp;</p>
</div>       