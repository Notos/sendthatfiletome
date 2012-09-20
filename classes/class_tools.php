<?php

class TOOLS {
  
  public function htmlSelect($name, $query, $fieldIndex, $fieldValue, $currentValue, $onChange) {
    global $DB;
    
    $DB->query($query);
    $records = $DB->to_array(0, MYSQLI_NUM);
    
    echo "<select name=\"$name\" onchange=\"$onChange\">";
    echo "<option value=\"\">---</option>";
    foreach($records as $record) {
      $index = $record[1];
      $value = $record[0];
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
