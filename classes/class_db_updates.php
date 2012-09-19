<?
  /*//-----------------------------------------------------------------------------------//
  
    This is the class that updates the database schema, basically it has
     
     - a property: versions (maintained by site owner)
     - a method: update
  
  //-----------------------------------------------------------------------------------//*/
  
class UPDATE_DATABASE {                                                                         
    public $versions = array();
    
    function __construct() {
      $this->populateVersions();
      $this->update();
    }
    
    function update() {
      $global $DB;
      
      $DB->query("select databaseVersion from system");
      list($databaseVersion) = $DB->next_record();
      
      foreach($versions as $version => $ddl) {
        if ($databaseVersion < $version) {
          $DB->query($ddl); /// update metadata
          $DB->query("update system set databaseVersion = $version"); /// set the new database version
          $databaseVersion = $version;
        }
      }
    }

    //-----------------------------------------------------------------------------------    
    //-----------------------------------------------------------------------------------    
    //-----------------------------------------------------------------------------------    
    //-----------------------------------------------------------------------------------    
    //-----------------------------------------------------------------------------------    

    
    function populateVersions() {
  
      //-----------------------------------------------------------------------------------    
      // Add all your MySQL DDL here following the pattern of version 1.001
      //-----------------------------------------------------------------------------------    
      
      $versions[1.001] = <<<EOT
--- Version 1.001 will be just a comment
EOT;

      $versions[1.002] = <<<EOT
--- Version 1.002 will create a table into the metadata

CREATE TABLE `language` (
  `LanguageID` int(10) NOT NULL AUTO_INCREMENT,
  `OriginalName` varchar(128) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NOT NULL,
  `EnglishName` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NOT NULL,
  `CountryID` integer NOT NULL,
  PRIMARY KEY (`LanguageID`),
  UNIQUE KEY `Name` (`EnglishName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

EOT;
      
    }
}
  
?>
