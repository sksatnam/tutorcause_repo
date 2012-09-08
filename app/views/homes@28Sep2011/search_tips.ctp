<?php //3aug2012 ?>  <?php //pr($members); ?>
<div id="mainCotent">
<!--content-->
	<div id="content">
	
		<div id="setContentBg">
		
			<div id="leftContent">
				<div class="topCatagoriesContainer">
					<div class="topCatagoriesImgTop">
					</div>
					<div class="topCatagoriesImgMid">
						<div class="infoSrchContainer">
							<div class="blogHeadingDiv">
								<?php echo $statdatas[0]['Page']['name'];?>
							</div>
							<div class="infoSearchContMain">
							  <?php echo $statdatas[0]['Page']['body'];?>	
							</div>
						
						</div>
					</div>
					<div class="topCatagoriesImgBot">
					</div>
				</div>
			</div>
		<!-- end left container -->
			
			  <!-- start right container -->
			<div id="RightContent">
			<div class="advtSrchContainer">
				<div class="advtSrch">
					<div class="topHeadinContainerRightPannel">
					   <!-- <div class="topHeadinContainerRightPannelLftImg">
						</div>-->
						<div class="topHeadinContainerRightPannelMidImg">
							Advanced Search
						</div>
					   <!--<div class="topHeadinContainerRightPannelRytImg">
						</div>-->
					</div>
					<?php echo $form->create('Search',array("id"=>"SearchForm","url" => $html->url(array('action'=>'search'), true))); ?>
					<div class="srchBodyCont">
						<div class="innerSrchCatagoryLab">
							<label>Your Child's Age</label>
						</div>
						<div class="selectBxCont">
							<div class="innerSelectBx">
								<?php echo $form->select('age',array(''=>'Select','0-12'=>'0-12 months','12-23'=>'12-23 months','2-5'=>'2-5 years','6above'=>'6 years and above'),null,array(),false); ?>
								<?php echo $form->input('hAge', array('type'=>'hidden', 'value'=> $searchAge)); ?>
							</div>
						</div>
						
						<div class="innerSrchCatagoryLab">
							<label>Learning Approach</label>
						</div>
						<div class="selectBxCont">
							<div class="innerSelectBx">
							   <?php echo $form->select('learning',array(''=>'Select','coop'=>'Co-op','developmental'=>'Developmental','montessori'=>'Montessori','playbased'=>'Play Based','reggioemilio'=>'Reggio Emilio','structured'=>'Structured/Learning','teacherinstruction'=>'Teacher Led Instruction','waldorf'=>'Waldorf'),null,array(),false); ?>
								<?php echo $form->input('hLearning', array('type'=>'hidden', 'value'=> $searchLearning)); ?>									
							</div>
						</div>
						
						 <div class="innerSrchCatagoryLab">
							<label>Star Rating</label>
						</div>
						<div class="selectBxCont">
							<div class="innerSelectBx">
								<?php echo $form->select('rating',array(''=>'Select', '0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'),null,array(),false); ?>
								<?php echo $form->input('hRating', array('type'=>'hidden', 'value'=> $searchRating)); ?>	
							</div>
						</div>
						
						<div class="innerSrchCatagoryLab">
							<label>Address(Optional)</label>
						</div>
						<div class="selectBxCont">
							<div class="innerSelectBx">
							  <?php echo $form->input('address',array('label'=>'', 'value'=> $searchAddress)); ?>
							  <?php echo $form->input('hAddress', array('type'=>'hidden', 'value'=> $searchAddress)); ?>
							</div>
						</div>
						<div class="innerSrchCatagoryLab">
							<label>City</label>
						</div>
						<div class="selectBxCont">
							<div class="innerSelectBx">
							  <?php echo $form->input('city',array('label'=>'','id'=>'UserCity')); ?>
							   <?php //echo $form->select('city',array(''=>'Select City',$searchAllCity),$searchCity,array('id' =>'UserCity'),false); ?>
							   <?php echo $form->input('hCity', array('type'=>'hidden', 'value'=> $searchCity));?>
							</div>
						</div>
						<div class="innerSrchCatagoryLab">
							<label>State</label>
						</div>
						<div class="selectBxCont">
							<?php /* <div class="innerSelectBx">
							   <?php echo $form->select('state',array(''=>'Select State',$states),$searchState,array('id' =>'UserState'),false); ?>
							   <?php echo $form->input('hState', array('type'=>'hidden', 'value'=> $searchState));?>
							   
							</div> */ ?>
<div class="innerSelectBx">
	<select id="UserState" name="data[Search][state]">
	<option value="">Select State</option>
	<option value="AL">Alabama</option>
	<option value="AK">Alaska</option>
	<option value="AZ">Arizona</option>
	<option value="AR">Arkansas</option>
	<option value="CA">California</option>
	<option value="CO">Colorado</option>
	<option value="CT">Connecticut</option>
	<option value="DE">Delaware</option>
	<option value="DC">Dist of Columbia</option>
	<option value="FL">Florida</option>
	<option value="GA">Georgia</option>
	<option value="HI">Hawaii</option>
	<option value="ID">Idaho</option>
	<option value="IL">Illinois</option>
	<option value="IN">Indiana</option>
	<option value="IA">Iowa</option>
	<option value="KS">Kansas</option>
	<option value="KY">Kentucky</option>
	<option value="LA">Louisiana</option>
	<option value="ME">Maine</option>
	<option value="MD">Maryland</option>
	<option value="MA">Massachusetts</option>
	<option value="MI">Michigan</option>
	<option value="MN">Minnesota</option>
	<option value="MS">Mississippi</option>
	<option value="MO">Missouri</option>
	<option value="MT">Montana</option>
	<option value="NE">Nebraska</option>
	<option value="NV">Nevada</option>
	<option value="NH">New Hampshire</option>
	<option value="NJ">New Jersey</option>
	<option value="NM">New Mexico</option>
	<option value="NY">New York</option>
	<option value="NC">North Carolina</option>
	<option value="ND">North Dakota</option>
	<option value="OH">Ohio</option>
	<option value="OK">Oklahoma</option>
	<option value="OR">Oregon</option>
	<option value="PA">Pennsylvania</option>
	<option value="RI">Rhode Island</option>
	<option value="SC">South Carolina</option>
	<option value="SD">South Dakota</option>
	<option value="TN">Tennessee</option>
	<option value="TX">Texas</option>
	<option value="UT">Utah</option>
	<option value="VT">Vermont</option>
	<option value="VA">Virginia</option>
	<option value="WA">Washington</option>
	<option value="WV">West Virginia</option>
	<option value="WI">Wisconsin</option>
	<option value="WY">Wyoming</option>
</select>
<input type="hidden" id="SearchHState" value="" name="data[Search][hState]">							   
</div>

						</div>
						
						<div class="innerSrchCatagoryLab">
							<label>Zip</label>
						</div>
						<div class="selectBxCont">
							<div class="innerSelectBx">
							   <?php echo $form->input('zip',array('label'=>'', 'value'=> $searchZip)); ?>
								<?php echo $form->input('hZip', array('type'=>'hidden', 'value'=> $searchZip)); ?>	
							</div>
						</div>
					   
						<div class="innerSrchCatagoryLab">
							<label>Search Within</label>
						</div>
						<div class="selectBxCont">
							<div class="innerSelectBxWithinLimit">
								<div class="smallSelectCity">
								   <?php echo $form->select('distance',array('0.1'=>'Select','10'=>'10 miles','20'=>'20 miles','30'=>'30 miles','40'=>'40 miles'),$searchDistance,array(),false); ?>
									<?php echo $form->input('hDistance', array('type'=>'hidden', 'value'=> $searchDistance)); ?>	
								</div>
								<label class="milesLab">miles</label>
							</div>
						</div>
						
						
						
						<div class="innerSrchCatagoryLab">
							<label>Center Name(Optional)</label>
						</div>
						<div class="selectBxCont">
							<div class="innerSelectBx">
							   <?php echo $form->input('centerName',array('label'=>'', 'value'=> $searchCenterName)); ?>
							   <?php echo $form->input('hCenterName', array('type'=>'hidden', 'value'=> $searchCenterName));?>
							</div>
						</div>
						
						<div class="innerSrchCatagoryLab">						
								<label>Enrollment Status</label>							
						</div>
						<div class="selectBxCont">
							<div class="innerSelectBx">
								<?php $status = array('space_available'=>'Space Available','space_may_be_available'=>'Space May Be Available','accepting_waitlist'=>'Accepting Waitlist','currently_no_space_available'=>'Currently No Space Available'); ?>
							   <?php echo $form->select('schoolStatus',array(''=>'Select Status',$status),null,array(),false); ?>
							   <?php echo $form->input('hSchoolStatus', array('type'=>'hidden', 'value'=>''));?>
							</div>
						</div>
						
						<div class="btnsContainer">
						   <div class="searchBut">
								 <!--<input type="submit" value = "Search" style=" width:100px; background-color:#58ABF2; color:#FFFFFF"/> -->
								<?php  echo $form->submit('Search',array('class'=>'button')); ?>
						   
						   
							   
							</div>
							<div class="resetAll">
								<!--<input type="reset" value="Reset All"  style=" width:100px; margin-left:20px; background-color:#58ABF2; color:#FFFFFF"/>-->
							<?php  echo $form->button('Reset All',array('type'=>'reset','class'=>'button')); ?>	
							</div>
						</div>
						<div class="advancedSearch">
								<br /><?php echo $html->link('Click Here For Search Tips',array('controller'=>'homes','action'=>'search_tips'));?>	
						</div>
					</div>
					<?php /*?><div class="bottomSrchImg">
						 <?php //echo $html->link('Click Here For Search Tips',array('controller'=>'homes','action'=>'searchTips'));?>
					</div><?php */?>
					
				</div>
				
				<div class="advt">
					<script type="text/javascript"><!--

					google_ad_client = "pub-0538213509219232";
					
					/* 300x250, created 2/9/11 */
					
					google_ad_slot = "5298057469";
					
					google_ad_width = 300;
					
					google_ad_height = 250;
					
					//-->
					
					</script>
					
					<script type="text/javascript"
					
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					
					</script>
				</div>
			</div>
		</div>
			</div>
		<!-- end right container -->
		</div>
</div>
<!--content-->
</div>