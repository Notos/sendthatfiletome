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
      $this->updateDatabase();
    }
    
    function updateDatabase() {
      global $DB;
      
      $DB->query("select databaseVersion from system");
      list($databaseVersion) = $DB->next_record();
      
      $DB->query("START TRANSACTION;");
      
      foreach($this->versions as $version => $ddlcommands) {
        $version = floatval($version);
        if ($databaseVersion < $version) {
          $ddls = explode(";", $ddlcommands);
          foreach($ddls as $ddl) {
            $DB->query($ddl); /// update metadata
          }
          $DB->query("update system set databaseVersion = $version"); /// set the new database version
          $databaseVersion = $version;
        }
      }
      
      $DB->query("COMMIT;");
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
      
      $this->versions['1.001'] = <<<EOT
      
/* --- Version 1.001 will create some tables into the metadata --- */
      
CREATE TABLE `origin` (
  `OriginID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`OriginID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `country` (
  `CountryID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`CountryID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `genre` (
  `GenreID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  `Type` char(10) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`GenreID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `container` (
  `ContainerID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`ContainerID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `codec` (
  `CodecID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`CodecID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `source` (
  `SourceID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`SourceID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `resolution` (
  `ResolutionID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci DEFAULT NULL,
  PRIMARY KEY (`ResolutionID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

 ---- Inserts ----- 

INSERT INTO country (Name) VALUES ('Afghanistan');
INSERT INTO country (Name) VALUES ('Albania');
INSERT INTO country (Name) VALUES ('Algeria');
INSERT INTO country (Name) VALUES ('Andorra');
INSERT INTO country (Name) VALUES ('Angola');
INSERT INTO country (Name) VALUES ('Antigua Barbuda');
INSERT INTO country (Name) VALUES ('Argentina');
INSERT INTO country (Name) VALUES ('Australia');
INSERT INTO country (Name) VALUES ('Austria');
INSERT INTO country (Name) VALUES ('Bahamas');
INSERT INTO country (Name) VALUES ('Bangladesh');
INSERT INTO country (Name) VALUES ('Barbados');
INSERT INTO country (Name) VALUES ('Belgium');
INSERT INTO country (Name) VALUES ('Belize');
INSERT INTO country (Name) VALUES ('Bosnia Herzegovina');
INSERT INTO country (Name) VALUES ('Brazil');
INSERT INTO country (Name) VALUES ('Bulgaria');
INSERT INTO country (Name) VALUES ('Burkina Faso');
INSERT INTO country (Name) VALUES ('Cambodia');
INSERT INTO country (Name) VALUES ('anada');
INSERT INTO country (Name) VALUES ('Chile');
INSERT INTO country (Name) VALUES ('hina');
INSERT INTO country (Name) VALUES ('Colombia');
INSERT INTO country (Name) VALUES ('Congo');
INSERT INTO country (Name) VALUES ('Costa Rica');
INSERT INTO country (Name) VALUES ('Croatia');
INSERT INTO country (Name) VALUES ('Cuba');
INSERT INTO country (Name) VALUES ('Czech Republic');
INSERT INTO country (Name) VALUES ('Denmark');
INSERT INTO country (Name) VALUES ('Dominican Republic');
INSERT INTO country (Name) VALUES ('Ecuador');
INSERT INTO country (Name) VALUES ('Egypt');
INSERT INTO country (Name) VALUES ('Estonia');
INSERT INTO country (Name) VALUES ('Fiji');
INSERT INTO country (Name) VALUES ('inland');
INSERT INTO country (Name) VALUES ('rance');
INSERT INTO country (Name) VALUES ('ermany');
INSERT INTO country (Name) VALUES ('Greece');
INSERT INTO country (Name) VALUES ('Guatemala');
INSERT INTO country (Name) VALUES ('Honduras');
INSERT INTO country (Name) VALUES ('Hong Kong');
INSERT INTO country (Name) VALUES ('Hungary');
INSERT INTO country (Name) VALUES ('Iceland');
INSERT INTO country (Name) VALUES ('India');
INSERT INTO country (Name) VALUES ('Ireland');
INSERT INTO country (Name) VALUES ('Isle de Muerte');
INSERT INTO country (Name) VALUES ('Israel');
INSERT INTO country (Name) VALUES ('taly');
INSERT INTO country (Name) VALUES ('Jamaica');
INSERT INTO country (Name) VALUES ('Japan');
INSERT INTO country (Name) VALUES ('Kiribati');
INSERT INTO country (Name) VALUES ('Kuwait');
INSERT INTO country (Name) VALUES ('Kyrgyzstan');
INSERT INTO country (Name) VALUES ('Laos');
INSERT INTO country (Name) VALUES ('Latvia');
INSERT INTO country (Name) VALUES ('Lebanon');
INSERT INTO country (Name) VALUES ('Lithuania');
INSERT INTO country (Name) VALUES ('Luxembourg');
INSERT INTO country (Name) VALUES ('Macedonia');
INSERT INTO country (Name) VALUES ('Malaysia');
INSERT INTO country (Name) VALUES ('Mexico');
INSERT INTO country (Name) VALUES ('Nauru');
INSERT INTO country (Name) VALUES ('Netherlands');
INSERT INTO country (Name) VALUES ('Netherlands Antilles');
INSERT INTO country (Name) VALUES ('New Zealand');
INSERT INTO country (Name) VALUES ('Nigeria');
INSERT INTO country (Name) VALUES ('North Korea');
INSERT INTO country (Name) VALUES ('Norway');
INSERT INTO country (Name) VALUES ('Pakistan');
INSERT INTO country (Name) VALUES ('Paraguay');
INSERT INTO country (Name) VALUES ('Peru');
INSERT INTO country (Name) VALUES ('Philippines');
INSERT INTO country (Name) VALUES ('Poland');
INSERT INTO country (Name) VALUES ('Portugal');
INSERT INTO country (Name) VALUES ('Puerto Rico');
INSERT INTO country (Name) VALUES ('Romania');
INSERT INTO country (Name) VALUES ('ussia');
INSERT INTO country (Name) VALUES ('Senegal');
INSERT INTO country (Name) VALUES ('Serbia');
INSERT INTO country (Name) VALUES ('Seychelles');
INSERT INTO country (Name) VALUES ('Singapore');
INSERT INTO country (Name) VALUES ('Slovenia');
INSERT INTO country (Name) VALUES ('South Africa');
INSERT INTO country (Name) VALUES ('South Korea');
INSERT INTO country (Name) VALUES ('Spain');
INSERT INTO country (Name) VALUES ('Sri Lanka');
INSERT INTO country (Name) VALUES ('weden');
INSERT INTO country (Name) VALUES ('Switzerland');
INSERT INTO country (Name) VALUES ('Taiwan');
INSERT INTO country (Name) VALUES ('Thailand');
INSERT INTO country (Name) VALUES ('Togo');
INSERT INTO country (Name) VALUES ('Trinidad &amp; Tobago');
INSERT INTO country (Name) VALUES ('Turkey');
INSERT INTO country (Name) VALUES ('Turkmenistan');
INSERT INTO country (Name) VALUES ('Ukraine');
INSERT INTO country (Name) VALUES ('Union of Soviet Socialist Repu');
INSERT INTO country (Name) VALUES ('United Kingdom');
INSERT INTO country (Name) VALUES ('nited States of America');
INSERT INTO country (Name) VALUES ('Uruguay');
INSERT INTO country (Name) VALUES ('Uzbekistan');
INSERT INTO country (Name) VALUES ('Vanuatu');
INSERT INTO country (Name) VALUES ('Venezuela');
INSERT INTO country (Name) VALUES ('Vietnam');
INSERT INTO country (Name) VALUES ('Western Samoa');
INSERT INTO country (Name) VALUES ('Yugoslavia');


INSERT INTO genre (Name) VALUES ("Action");
INSERT INTO genre (Name) VALUES ("Adventure");
INSERT INTO genre (Name) VALUES ("Animation");
INSERT INTO genre (Name) VALUES ("Anime");
INSERT INTO genre (Name) VALUES ("Celebrities");
INSERT INTO genre (Name) VALUES ("Children");
INSERT INTO genre (Name) VALUES ("Comedy");
INSERT INTO genre (Name) VALUES ("Cooking");
INSERT INTO genre (Name) VALUES ("Crime");
INSERT INTO genre (Name) VALUES ("Documentary");
INSERT INTO genre (Name) VALUES ("Drama");
INSERT INTO genre (Name) VALUES ("Educational");
INSERT INTO genre (Name) VALUES ("Family");
INSERT INTO genre (Name) VALUES ("Fantasy");
INSERT INTO genre (Name) VALUES ("Food");
INSERT INTO genre (Name) VALUES ("GameShow");
INSERT INTO genre (Name) VALUES ("Horror");
INSERT INTO genre (Name) VALUES ("Lifestyle");
INSERT INTO genre (Name) VALUES ("Music");
INSERT INTO genre (Name) VALUES ("Mystery");
INSERT INTO genre (Name) VALUES ("News");
INSERT INTO genre (Name) VALUES ("Reality");
INSERT INTO genre (Name) VALUES ("Science");
INSERT INTO genre (Name) VALUES ("SciFi");
INSERT INTO genre (Name) VALUES ("Sitcom");
INSERT INTO genre (Name) VALUES ("Sketch");
INSERT INTO genre (Name) VALUES ("Soap");
INSERT INTO genre (Name) VALUES ("Specialinterest");
INSERT INTO genre (Name) VALUES ("Sports");
INSERT INTO genre (Name) VALUES ("Talent");
INSERT INTO genre (Name) VALUES ("Talkshow");
INSERT INTO genre (Name) VALUES ("Thriller");

INSERT INTO container (Name) VALUES ("MKV");
INSERT INTO container (Name) VALUES ("VOB");
INSERT INTO container (Name) VALUES ("MPEG");
INSERT INTO container (Name) VALUES ("MP4");
INSERT INTO container (Name) VALUES ("ISO");
INSERT INTO container (Name) VALUES ("WMV");
INSERT INTO container (Name) VALUES ("TS");
INSERT INTO container (Name) VALUES ("M4V");
INSERT INTO container (Name) VALUES ("M2TS");

INSERT INTO codec (Name) VALUES ("x264");
INSERT INTO codec (Name) VALUES ("MPEG2");
INSERT INTO codec (Name) VALUES ("DiVX");
INSERT INTO codec (Name) VALUES ("DVDR");
INSERT INTO codec (Name) VALUES ("VC-1");
INSERT INTO codec (Name) VALUES ("h.264");
INSERT INTO codec (Name) VALUES ("WMV");
INSERT INTO codec (Name) VALUES ("BD");
INSERT INTO codec (Name) VALUES ("x264-Hi10P");

INSERT INTO source (Name) VALUES ("PDTV");
INSERT INTO source (Name) VALUES ("DSR");
INSERT INTO source (Name) VALUES ("DVDRip");
INSERT INTO source (Name) VALUES ("TVRip");
INSERT INTO source (Name) VALUES ("VHSRip");
INSERT INTO source (Name) VALUES ("Bluray");
INSERT INTO source (Name) VALUES ("BDRip");
INSERT INTO source (Name) VALUES ("BRRip");
INSERT INTO source (Name) VALUES ("DVD5");
INSERT INTO source (Name) VALUES ("DVD9");
INSERT INTO source (Name) VALUES ("HDDVD");
INSERT INTO source (Name) VALUES ("WEB");
INSERT INTO source (Name) VALUES ("BD5");
INSERT INTO source (Name) VALUES ("BD9");
INSERT INTO source (Name) VALUES ("BD25");
INSERT INTO source (Name) VALUES ("BD50");
INSERT INTO source (Name) VALUES ("Mixed");
INSERT INTO source (Name) VALUES ("Unknown");

INSERT INTO resolution (Name) VALUES ("480i");
INSERT INTO resolution (Name) VALUES ("480p");
INSERT INTO resolution (Name) VALUES ("576i");
INSERT INTO resolution (Name) VALUES ("576p");
INSERT INTO resolution (Name) VALUES ("720i");
INSERT INTO resolution (Name) VALUES ("720p");
INSERT INTO resolution (Name) VALUES ("1080p");
INSERT INTO resolution (Name) VALUES ("1080i");
INSERT INTO resolution (Name) VALUES ("Unknown");

INSERT INTO origin (Name) VALUES ("Scene");
INSERT INTO origin (Name) VALUES ("P2P");
INSERT INTO origin (Name) VALUES ("User");
INSERT INTO origin (Name) VALUES ("Mixed");

EOT;

      $this->versions['1.002'] = <<<EOT
/* --- Version 1.002 will create a table into the metadata --- */

CREATE TABLE `language` (
  `LanguageID` int(10) NOT NULL AUTO_INCREMENT,
  `CountryID` integer NOT NULL,
  `OriginalName` varchar(128) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `EnglishName` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`LanguageID`),
  UNIQUE KEY `Name` (`EnglishName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin

EOT;

      $this->versions['1.003'] = <<<EOT

CREATE TABLE `message` (
  `LanguageID` int(10) NOT NULL AUTO_INCREMENT,
  `CountryID` integer NOT NULL,
  `OriginalName` varchar(128) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `EnglishName` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`LanguageID`),
  UNIQUE KEY `Name` (`EnglishName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin

EOT;
      
    }
}
  
?>
