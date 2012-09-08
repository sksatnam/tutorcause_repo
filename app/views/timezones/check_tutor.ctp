<?php //3aug2012 ?>

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


<script type="text/javascript">

$(document).ready(function(){
							
$('#stime').datetimepicker({
		
	});


$('#etime').datetimepicker({
		
	});
});


</script>


<form action="<?php echo HTTP_ROOT.'timezones/check_tutor';?>" name="addtutortime" method="post">

<label> start time</label>
<input type="text" name="data[TutorEvent][start]" value="" id="stime" /> <br>
<label> end time</label>
<input type="text" name="data[TutorEvent][end]" value="" id="etime" /> <br>
<input type="submit">

</form>




             <?php 
						 
					//	 $selectedzone = $this->data['School']['timezone'];
						 $label = Timezone;
                        	 get_tz_options($selectedzone, $label, $desc = '') 
						 ?>   
