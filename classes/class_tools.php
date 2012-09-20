<?php

class TOOLS {
  
  public function htmlSelect($name, $query, $fieldIndex, $fieldValue, $currentValue, $onChange = '') {
    global $DB;
    
    $DB->query($query); /// this query result must have only 2 fields (index and value)
    $records = $DB->to_array(0, MYSQLI_NUM);
    
    echo "<select name=\"$name\" id=\"$name\" onchange=\"$onChange\">";
    echo "<option value=\"\">---</option>";
    foreach($records as $record) {
      $index = $record[0];
      $value = $record[1];
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
