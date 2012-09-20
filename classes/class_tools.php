<?php

class TOOLS {
  
  public function htmlSelect($name, $query, $fieldIndex, $fieldValue, $currentValue, $onChange) {
    global $DB;
    
    $DB->query($query);
    $records = $DB->to_array(0, MYSQLI_NUM);
    
    echo "<select name=\"$name\" onchange=\"$onChange\">";
    echo "<option value=\"\">---</option>";
    foreach($records as $record) {
      $value = $record[$fieldValue];
      $index = $record[$fieldIndex];
      echo "<option value='$index'";
      if($value == $currentValue) { echo " selected='selected'"; }
      echo ">";
      echo $value;
      echo "</option>\n";
    }
    echo "</select>";
  }
  
}
  
?>
