<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT.'css/frontend/rating.css'?>" />

<?php
       /* echo '<pre>';
		print_r($rating);
		die;*/
		
		
		?>

<?php //pr($this->data);?>
<div id="content">
	<div id="content-top">
    	<h2>Review</h2>
       <span class="clearFix">&nbsp;</span>
    </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	<div id="mid-col">    	
		<div class="box">
       
        
			<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Review</h4>
			<div id="userAddPanel" style="min-height:520px;">
            
             <div id="flashmsg" style="float:left; padding-left:10px; padding-bottom:10px;"><b><?php echo $this->Session->flash(); ?></b></div><br />
            
            
            
            <div class="paddinSet">
					<fieldset id="personal-info">
						<legend>Student Review</legend>
						<div class="innerContainerInsideFieldset">
                        
							
                             <div class="rating">
                             
                             <span style="float:left">Knowledge :</span>
                             		<?php
                                    if($rating['TutRating']['knowledge'])
                                    {
									 for($i=1;$i<=$rating['TutRating']['knowledge'];$i++){ ?>
									<div class="star on">
										<a title="Give it 1" href="#1" style="width: 100%;">1</a>
									</div>
									<?php } 
                                    }
                                    else
                                    {
                                    echo 'N/A'; 
                                    }
                                    ?>
								</div>
                            
                            <br />
                            
                             <div class="rating">
                               <span style="float:left">Ability :</span>
                                    <?php
                             		 if($rating['TutRating']['ability'])
                                    {
									for($i=1;$i<=$rating['TutRating']['ability'];$i++){ ?>
									<div class="star on">
										<a title="Give it 1" href="#1" style="width: 100%;">1</a>
									</div>
									<?php }
									 }
                                    else
                                    {
                                    echo 'N/A'; 
                                    }
									?>
								</div><br />
                            
                            <div class="rating">
                            <span style="float:left">Comments :</span>
                            
                            <?php
							if($rating['TutRating']['comments'])
							{
							echo $rating['TutRating']['comments'];
							}
							else
							{
							echo 'N/A';
							}?>
                            </div>                            
                            <br />
						</div>
					</fieldset>
					
				</div>
						
                
                
			     
				
			</div>
		</div>
	</div><!-- end of div#mid-col -->
   <span class="clearFix">&nbsp;</span>     
</div>