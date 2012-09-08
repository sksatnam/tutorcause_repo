
<?php

function get_tz_options($selectedzone, $label, $desc = '')
{
  echo '<div class="label"><label for="timezone" class="dpkLab" class="dpkLab20">'.$label.':</label></div>';
  echo '<div class="input"><select name="data[School][timezone]">';
  function timezonechoice($selectedzone) {
    $all = timezone_identifiers_list();
	
    $i = 0;
    foreach($all AS $zone) {
      $zone = explode('/',$zone);
      $zonen[$i]['continent'] = isset($zone[0]) ? $zone[0] : '';
      $zonen[$i]['city'] = isset($zone[1]) ? $zone[1] : '';
      $zonen[$i]['subcity'] = isset($zone[2]) ? $zone[2] : '';
      $i++;
    }

    asort($zonen);
    $structure = '';
	
    foreach($zonen AS $zone) {
      extract($zone);
/*     
 all continent timezones
if($continent == 'Africa' || $continent == 'America' || $continent == 'Antarctica' || $continent == 'Arctic' || $continent == 'Asia' || $continent == 'Atlantic' || $continent == 'Australia' || $continent == 'Europe' || $continent == 'Indian' || $continent == 'Pacific') {
*/	
	    if($continent == 'America') {
		  
        if(!isset($selectcontinent)) {
          $structure .= '<optgroup label="'.$continent.'">'; // continent
        } elseif($selectcontinent != $continent) {
          $structure .= '</optgroup><optgroup label="'.$continent.'">'; // continent
        }

        if(isset($city) != ''){
          if (!empty($subcity) != ''){
            $city = $city . '/'. $subcity;
          }
          $structure .= "<option ".((($continent.'/'.$city)==$selectedzone)?'selected="selected "':'')." value=\"".($continent.'/'.$city)."\">".str_replace('_',' ',$city)."</option>"; //Timezone
        } else {
          if (!empty($subcity) != ''){
            $city = $city . '/'. $subcity;
          }
          $structure .= "<option ".(($continent==$selectedzone)?'selected="selected "':'')." value=\"".$continent."\">".$continent."</option>"; //Timezone
        }

        $selectcontinent = $continent;
      }
    }
    $structure .= '</optgroup>';
    return $structure;
  }
  echo timezonechoice($selectedzone);
  echo '</select>';
  echo '<span class="notes"> '.$desc.' </span></div>'; 
  
}
?>

<?php //pr($states);die;?>


<div id="content">
	<div id="content-top">
    <h2>Schools</h2>
      
      <span class="clearFix">&nbsp;</span>
      </div><!-- end of div#content-top -->
      <?php echo $this->element('adminElements/left-sidebar'); ?>
	  	<div id="mid-col">    	
			<div class="box">
				<h4 style="-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;" class="white rounded_by_jQuery_corners">Add School</h4>
				<div id="userAddPanel" style="float:left; width:735px;">
				
                <div style="padding-left:30px;" id="flashmsg"><b><?php echo $session->flash();?></b></div>
                
                			 <?php echo $this->Form->create('School', array("url" => $html->url(array('action' => 'add', "admin" => true), true),'id'=>'SchoolAddForm','enctype' => 'multipart/form-data')); ?>
                    
			
                    <div class="paddinSet">
						   <fieldset style="margin:0px; float:left;" id="personal-info">
                            <legend>School Info</legend>
                            <div class="innerContainerInsideFieldset">
                            
                             <label class="dpkLab" for="UserFirstname" class="field-title">School Name : </label><?php echo $form->input('school_name',array('label'=>'','div' => '','class'=>'required')); ?><br /><br />
                            
                            
                                <label class="dpkLab" for="UserFirstname" class="field-title">School Website : </label><?php echo $form->input('url',array('label'=>'','div' => '','class'=>'required url')); ?><br /><br />
                                
                                <label class="dpkLab" for="UserLastname" class="field-title">Slug :</label><?php echo $form->input('slug',array('label'=>'','div' => '','class'=>'required')); ?><br /><br />
                                
                               
                                
                                <label class="dpkLab" for="UserAddress1" class="field-title">Address : </label><?php echo $form->input('address',array('label'=>'','div' => '','class'=>'required')); ?><br /><br />
                               
                                <label for="UserCity" class="dpkLab">City :</label><?php echo $form->input('city',array('label'=>false,'id'=>'UserCity','class'=>'required')); ?><?php //echo $form->select('userMeta.city',array(''=>'Select City'),$this->data['userMeta']['city'],array('id' =>'UserCity'),false); ?>
                                                                                          <br />
                                                                                          
                                 <label for="UserState" class="dpkLab">State : </label>
								 <select name="data[School][state]" class="required">
                                 <option value="">Select State</option>

								<?php
                                foreach ( $states as $key => $val ) {
								  echo  "<option value=\"$val\">$val</option>";
								}	
                                ?>
                                </select>
	                                 <br /><br />
                             
                                <label class="dpkLab" for="UserZipcode" class="dpkLab20">Zip :</label><?php echo $form->input('zip',array('label'=>'','div' => 'entryField','numeric'=>'integer','class'=>'number required','maxlength'=>'10')); ?><?php // echo $form->input('Member.zipcode',array('label'=>'','div' => '','numeric'=>'integer','class'=>'zipcode','maxlength'=>'10')); ?><br /><br />
                                  
                                
                                 
                                  <label class="dpkLab" for="UserPhone" class="dpkLab20"> Sponsoring Organization   :</label><?php echo $form->input('sponsoring_organization',array('label'=>'','div' => '','class'=>'required')); ?><br /><br />
                                  
                                  
                                   <label class="dpkLab" for="UserPhone" class="dpkLab20"> School Logo  :</label>
                                   <input type="file" name="data[School][file]"  />
                                   <br /><br />
                                  
                                  <label class="dpkLab" for="UserPhone" class="dpkLab20"> Sponsoring Org Logo   :</label>
                                  <input type="file" name="data[School][file1]"  /><br /><br />
                                  
                                  <label class="dpkLab" for="UserPhone" class="dpkLab20"> TimeZone   :</label>
                                      <select id="timezone" class="selectStepFrm required" name="data[School][timezone]" style="width:230px; height:22px;">
                                           <option value="" >Please select</option>
                                <?php
                                foreach($alltimes as $at)
                                {
                                ?>	
                                    <option value="<?php echo $at['Timezone']['id'];?>"><?php echo '&nbsp;('.$at['Timezone']['GMT'].') '.$at['Timezone']['name'];?></option>	
                                <?php    
                                }
                                ?>
                            </select>
                                  
                         
                            <br /><br />
                           <label  class="dpkLab" for="iclock" class="dpkLab20"> Iframe code for clock   :</label>
						   <textarea name="data[School][iclock]" rows="3" cols="35"></textarea>
                           
                                 
                                 
                             
                       		</div>
                        </fieldset>
                            <div id="submit-buttons">
                                <?php  echo $form->submit('Save',array('div' => false)); ?>
                                <input type="reset" value="Reset" />
                            </div>
                            <?php echo $form->end(); ?>
                     	</div>

                    
                 	</div>
				</div>
			</div>

		</div><!-- end of div#mid-col -->
      
      <span class="clearFix">&nbsp;</span>     
</div>
<?php //3aug2012 ?>