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
      if($index == $currentValue) { echo " selected=\"selected\""; }
      echo ">";
      echo $value;
      echo "</option>\n";
    }
    echo "</select>";
  }

  public function languageName($languageIDAndCountryCode) {
    global $DB;

    list($languageID, $countryCode) = explode("-",$languageIDAndCountryCode);

    $DB->query("
        SELECT
          concat(l.EnglishName, (case when c.Name is not null and c.Name <> '' then ' (' else '' end), (case when c.Name is not null and c.Name <> '' then c.Name else '' end), (case when c.Name is not null and c.Name <> ''  then ')' else ''  end)) LanguageName
        FROM language l left join country c on l.CountryCode = c.CountryCode
        WHERE l.LanguageID = '$languageID' and l.CountryCode = '$countryCode'
    ");

    list($name) = $DB->next_record();

    return $name;
  }

  public function p($s,$f=false) {
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

  public function pa($s) {
    $x = "<pre>";
    $x .= print_r($s, 1);
    $x .= "</pre>";
    print $x;
   }

  public function pt($table) {
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
