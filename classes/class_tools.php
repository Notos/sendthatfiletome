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
      echo "<option value=\"$index\"";
      if($value == $currentValue) { echo " selected=\"selected\""; }
      echo ">";
      echo $value;
      echo "</option>\n";
    }
    echo "</select>";
  }
  
   function p($s,$f=false) {
     if ($s == 'zN/A') {
       $s = 'N/A';
     }
     if ($f) {
       $f1 = "<$f>";
       $f2 = "</$f>";
     } else {
       $f1 = "";
       $f2 = "";
     }
     echo $f1.$s.$f2."<br>";
   }

   function pa($s) {
        $x = "<pre>";
        $x .= print_r($s, 1);
        $x .= "</pre>";
        print $x;
   }

   function pt($table) {
     echo "<table border=1>";
     $rn = 1;
     foreach($table as $index=>$row) {
       echo "<tr>";
       echo "<td>".$rn++."</td>";
       foreach($row as $field=>$value) {
         echo "<td>" . $value . "</td>";
       }
       echo "</tr>";
     }
     echo "</table>";
   }
  
  
}
  
?>
