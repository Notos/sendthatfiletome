<?
  /*//-----------------------------------------------------------------------------------//
  
    This is the class that updates the database schema, basically it has
     
     - a property: versions (maintained by site owner)
     - a method: update
  
  //-----------------------------------------------------------------------------------//*/
  
class UPDATE_DATABASE {                                                                         
    public $versions = array();
    
    function __construct() {
      $this->dropAllExtraTables(); /// for testing purposes
      $this->populateVersions();
      $this->updateDatabase();
    }
    
    function updateDatabase() {
      global $DB;
      
      foreach($this->versions as $version => $ddlcommands) {
        $version = floatval($version);
        if ($databaseVersion < $version) {
          $ddls = explode(";", $ddlcommands);
          foreach($ddls as $ddl) {
            
            try {
              if (trim($ddl)) {
                $DB->query($ddl); /// update metadata
              }
            } catch(Exception $e) {
              echo "Error: ".$e->getMessage();
            }
          }
          $DB->query("update system set databaseVersion = $version;"); /// set the new database version
          $databaseVersion = $version;
        }
      }
    }

    function dropAllExtraTables() {
      global $DB;

      $DB->query("DROP TABLE `system`;");
      $DB->query("DROP TABLE `origin`;");
      $DB->query("DROP TABLE `country`;");
      $DB->query("DROP TABLE `genre`;");
      $DB->query("DROP TABLE `container`;");
      $DB->query("DROP TABLE `codec`;");
      $DB->query("DROP TABLE `source`;");
      $DB->query("DROP TABLE `resolution`;");
      $DB->query("DROP TABLE `language`;");
      $DB->query("DROP TABLE `message`;");
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
  `CountryCode` char(2) NOT NULL,
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

 /* ---- Inserts ----- */

INSERT INTO country (CountryCode, Name) VALUES ('AF', 'Afghanistan');
INSERT INTO country (CountryCode, Name) VALUES ('AX', 'Åland Islands');
INSERT INTO country (CountryCode, Name) VALUES ('AL', 'Albania');
INSERT INTO country (CountryCode, Name) VALUES ('DZ', 'Algeria');
INSERT INTO country (CountryCode, Name) VALUES ('AS', 'American Samoa');
INSERT INTO country (CountryCode, Name) VALUES ('AD', 'Andorra');
INSERT INTO country (CountryCode, Name) VALUES ('AO', 'Angola');
INSERT INTO country (CountryCode, Name) VALUES ('AI', 'Anguilla');
INSERT INTO country (CountryCode, Name) VALUES ('AQ', 'Antarctica');
INSERT INTO country (CountryCode, Name) VALUES ('AG', 'Antigua and Barbuda');
INSERT INTO country (CountryCode, Name) VALUES ('AR', 'Argentina');
INSERT INTO country (CountryCode, Name) VALUES ('AM', 'Armenia');
INSERT INTO country (CountryCode, Name) VALUES ('AW', 'Aruba');
INSERT INTO country (CountryCode, Name) VALUES ('AU', 'Australia');
INSERT INTO country (CountryCode, Name) VALUES ('AT', 'Austria');
INSERT INTO country (CountryCode, Name) VALUES ('AZ', 'Azerbaijan');
INSERT INTO country (CountryCode, Name) VALUES ('BS', 'Bahamas');
INSERT INTO country (CountryCode, Name) VALUES ('BH', 'Bahrain');
INSERT INTO country (CountryCode, Name) VALUES ('BD', 'Bangladesh');
INSERT INTO country (CountryCode, Name) VALUES ('BB', 'Barbados');
INSERT INTO country (CountryCode, Name) VALUES ('BY', 'Belarus');
INSERT INTO country (CountryCode, Name) VALUES ('BE', 'Belgium');
INSERT INTO country (CountryCode, Name) VALUES ('BZ', 'Belize');
INSERT INTO country (CountryCode, Name) VALUES ('BJ', 'Benin');
INSERT INTO country (CountryCode, Name) VALUES ('BM', 'Bermuda');
INSERT INTO country (CountryCode, Name) VALUES ('BT', 'Bhutan');
INSERT INTO country (CountryCode, Name) VALUES ('BO', 'Bolivia');
INSERT INTO country (CountryCode, Name) VALUES ('BA', 'Bosnia and Herzegovina');
INSERT INTO country (CountryCode, Name) VALUES ('BW', 'Botswana');
INSERT INTO country (CountryCode, Name) VALUES ('BV', 'Bouvet Island');
INSERT INTO country (CountryCode, Name) VALUES ('BR', 'Brazil');
INSERT INTO country (CountryCode, Name) VALUES ('IO', 'British Indian Ocean Territory');
INSERT INTO country (CountryCode, Name) VALUES ('BN', 'Brunei Darussalam');
INSERT INTO country (CountryCode, Name) VALUES ('BG', 'Bulgaria');
INSERT INTO country (CountryCode, Name) VALUES ('BF', 'Burkina Faso');
INSERT INTO country (CountryCode, Name) VALUES ('BI', 'Burundi');
INSERT INTO country (CountryCode, Name) VALUES ('KH', 'Cambodia');
INSERT INTO country (CountryCode, Name) VALUES ('CM', 'Cameroon');
INSERT INTO country (CountryCode, Name) VALUES ('CA', 'Canada');
INSERT INTO country (CountryCode, Name) VALUES ('CV', 'Cape Verde');
INSERT INTO country (CountryCode, Name) VALUES ('KY', 'Cayman Islands');
INSERT INTO country (CountryCode, Name) VALUES ('CF', 'Central African Republic');
INSERT INTO country (CountryCode, Name) VALUES ('TD', 'Chad');
INSERT INTO country (CountryCode, Name) VALUES ('CL', 'Chile');
INSERT INTO country (CountryCode, Name) VALUES ('CN', 'China');
INSERT INTO country (CountryCode, Name) VALUES ('CX', 'Christmas Island');
INSERT INTO country (CountryCode, Name) VALUES ('CC', 'Cocos (Keeling) Islands');
INSERT INTO country (CountryCode, Name) VALUES ('CO', 'Colombia');
INSERT INTO country (CountryCode, Name) VALUES ('KM', 'Comoros');
INSERT INTO country (CountryCode, Name) VALUES ('CG', 'Congo');
INSERT INTO country (CountryCode, Name) VALUES ('CD', 'Congo, The Democratic Republic of the');
INSERT INTO country (CountryCode, Name) VALUES ('CK', 'Cook Islands');
INSERT INTO country (CountryCode, Name) VALUES ('CR', 'Costa Rica');
INSERT INTO country (CountryCode, Name) VALUES ('CI', 'Côte D\'Ivoire');
INSERT INTO country (CountryCode, Name) VALUES ('HR', 'Croatia');
INSERT INTO country (CountryCode, Name) VALUES ('CU', 'Cuba');
INSERT INTO country (CountryCode, Name) VALUES ('CY', 'Cyprus');
INSERT INTO country (CountryCode, Name) VALUES ('CZ', 'Czech Republic');
INSERT INTO country (CountryCode, Name) VALUES ('DK', 'Denmark');
INSERT INTO country (CountryCode, Name) VALUES ('DJ', 'Djibouti');
INSERT INTO country (CountryCode, Name) VALUES ('DM', 'Dominica');
INSERT INTO country (CountryCode, Name) VALUES ('DO', 'Dominican Republic');
INSERT INTO country (CountryCode, Name) VALUES ('EC', 'Ecuador');
INSERT INTO country (CountryCode, Name) VALUES ('EG', 'Egypt');
INSERT INTO country (CountryCode, Name) VALUES ('SV', 'El Salvador');
INSERT INTO country (CountryCode, Name) VALUES ('GQ', 'Equatorial Guinea');
INSERT INTO country (CountryCode, Name) VALUES ('ER', 'Eritrea');
INSERT INTO country (CountryCode, Name) VALUES ('EE', 'Estonia');
INSERT INTO country (CountryCode, Name) VALUES ('ET', 'Ethiopia');
INSERT INTO country (CountryCode, Name) VALUES ('FK', 'Falkland Islands (Malvinas)');
INSERT INTO country (CountryCode, Name) VALUES ('FO', 'Faroe Islands');
INSERT INTO country (CountryCode, Name) VALUES ('FJ', 'Fiji');
INSERT INTO country (CountryCode, Name) VALUES ('FI', 'Finland');
INSERT INTO country (CountryCode, Name) VALUES ('FR', 'France');
INSERT INTO country (CountryCode, Name) VALUES ('GF', 'French Guiana');
INSERT INTO country (CountryCode, Name) VALUES ('PF', 'French Polynesia');
INSERT INTO country (CountryCode, Name) VALUES ('TF', 'French Southern Territories');
INSERT INTO country (CountryCode, Name) VALUES ('GA', 'Gabon');
INSERT INTO country (CountryCode, Name) VALUES ('GM', 'Gambia');
INSERT INTO country (CountryCode, Name) VALUES ('GE', 'Georgia');
INSERT INTO country (CountryCode, Name) VALUES ('DE', 'Germany');
INSERT INTO country (CountryCode, Name) VALUES ('GH', 'Ghana');
INSERT INTO country (CountryCode, Name) VALUES ('GI', 'Gibraltar');
INSERT INTO country (CountryCode, Name) VALUES ('GR', 'Greece');
INSERT INTO country (CountryCode, Name) VALUES ('GL', 'Greenland');
INSERT INTO country (CountryCode, Name) VALUES ('GD', 'Grenada');
INSERT INTO country (CountryCode, Name) VALUES ('GP', 'Guadeloupe');
INSERT INTO country (CountryCode, Name) VALUES ('GU', 'Guam');
INSERT INTO country (CountryCode, Name) VALUES ('GT', 'Guatemala');
INSERT INTO country (CountryCode, Name) VALUES ('GG', 'Guernsey');
INSERT INTO country (CountryCode, Name) VALUES ('GN', 'Guinea');
INSERT INTO country (CountryCode, Name) VALUES ('GW', 'Guinea-Bissau');
INSERT INTO country (CountryCode, Name) VALUES ('GY', 'Guyana');
INSERT INTO country (CountryCode, Name) VALUES ('HT', 'Haiti');
INSERT INTO country (CountryCode, Name) VALUES ('HM', 'Heard Island and McDonald Islands');
INSERT INTO country (CountryCode, Name) VALUES ('VA', 'Holy See (Vatican City State)');
INSERT INTO country (CountryCode, Name) VALUES ('HN', 'Honduras');
INSERT INTO country (CountryCode, Name) VALUES ('HK', 'Hong Kong');
INSERT INTO country (CountryCode, Name) VALUES ('HU', 'Hungary');
INSERT INTO country (CountryCode, Name) VALUES ('IS', 'Iceland');
INSERT INTO country (CountryCode, Name) VALUES ('IN', 'India');
INSERT INTO country (CountryCode, Name) VALUES ('ID', 'Indonesia');
INSERT INTO country (CountryCode, Name) VALUES ('IR', 'Iran, Islamic Republic of');
INSERT INTO country (CountryCode, Name) VALUES ('IQ', 'Iraq');
INSERT INTO country (CountryCode, Name) VALUES ('IE', 'Ireland');
INSERT INTO country (CountryCode, Name) VALUES ('IM', 'Isle of Man');
INSERT INTO country (CountryCode, Name) VALUES ('IL', 'Israel');
INSERT INTO country (CountryCode, Name) VALUES ('IT', 'Italy');
INSERT INTO country (CountryCode, Name) VALUES ('JM', 'Jamaica');
INSERT INTO country (CountryCode, Name) VALUES ('JP', 'Japan');
INSERT INTO country (CountryCode, Name) VALUES ('JE', 'Jersey');
INSERT INTO country (CountryCode, Name) VALUES ('JO', 'Jordan');
INSERT INTO country (CountryCode, Name) VALUES ('KZ', 'Kazakhstan');
INSERT INTO country (CountryCode, Name) VALUES ('KE', 'Kenya');
INSERT INTO country (CountryCode, Name) VALUES ('KI', 'Kiribati');
INSERT INTO country (CountryCode, Name) VALUES ('KP', 'Korea, Democratic People\'s Republic of');
INSERT INTO country (CountryCode, Name) VALUES ('KR', 'Korea, Republic of');
INSERT INTO country (CountryCode, Name) VALUES ('KW', 'Kuwait');
INSERT INTO country (CountryCode, Name) VALUES ('KG', 'Kyrgyzstan');
INSERT INTO country (CountryCode, Name) VALUES ('LA', 'Lao People\'s Democratic Republic');
INSERT INTO country (CountryCode, Name) VALUES ('LV', 'Latvia');
INSERT INTO country (CountryCode, Name) VALUES ('LB', 'Lebanon');
INSERT INTO country (CountryCode, Name) VALUES ('LS', 'Lesotho');
INSERT INTO country (CountryCode, Name) VALUES ('LR', 'Liberia');
INSERT INTO country (CountryCode, Name) VALUES ('LY', 'Libyan Arab Jamahiriya');
INSERT INTO country (CountryCode, Name) VALUES ('LI', 'Liechtenstein');
INSERT INTO country (CountryCode, Name) VALUES ('LT', 'Lithuania');
INSERT INTO country (CountryCode, Name) VALUES ('LU', 'Luxembourg');
INSERT INTO country (CountryCode, Name) VALUES ('MO', 'Macao');
INSERT INTO country (CountryCode, Name) VALUES ('MK', 'Macedonia, The Former Yugoslav Republic of');
INSERT INTO country (CountryCode, Name) VALUES ('MG', 'Madagascar');
INSERT INTO country (CountryCode, Name) VALUES ('MW', 'Malawi');
INSERT INTO country (CountryCode, Name) VALUES ('MY', 'Malaysia');
INSERT INTO country (CountryCode, Name) VALUES ('MV', 'Maldives');
INSERT INTO country (CountryCode, Name) VALUES ('ML', 'Mali');
INSERT INTO country (CountryCode, Name) VALUES ('MT', 'Malta');
INSERT INTO country (CountryCode, Name) VALUES ('MH', 'Marshall Islands');
INSERT INTO country (CountryCode, Name) VALUES ('MQ', 'Martinique');
INSERT INTO country (CountryCode, Name) VALUES ('MR', 'Mauritania');
INSERT INTO country (CountryCode, Name) VALUES ('MU', 'Mauritius');
INSERT INTO country (CountryCode, Name) VALUES ('YT', 'Mayotte');
INSERT INTO country (CountryCode, Name) VALUES ('MX', 'Mexico');
INSERT INTO country (CountryCode, Name) VALUES ('FM', 'Micronesia, Federated States of');
INSERT INTO country (CountryCode, Name) VALUES ('MD', 'Moldova, Republic of');
INSERT INTO country (CountryCode, Name) VALUES ('MC', 'Monaco');
INSERT INTO country (CountryCode, Name) VALUES ('MN', 'Mongolia');
INSERT INTO country (CountryCode, Name) VALUES ('ME', 'Montenegro');
INSERT INTO country (CountryCode, Name) VALUES ('MS', 'Montserrat');
INSERT INTO country (CountryCode, Name) VALUES ('MA', 'Morocco');
INSERT INTO country (CountryCode, Name) VALUES ('MZ', 'Mozambique');
INSERT INTO country (CountryCode, Name) VALUES ('MM', 'Myanmar');
INSERT INTO country (CountryCode, Name) VALUES ('NA', 'Namibia');
INSERT INTO country (CountryCode, Name) VALUES ('NR', 'Nauru');
INSERT INTO country (CountryCode, Name) VALUES ('NP', 'Nepal');
INSERT INTO country (CountryCode, Name) VALUES ('NL', 'Netherlands');
INSERT INTO country (CountryCode, Name) VALUES ('AN', 'Netherlands Antilles');
INSERT INTO country (CountryCode, Name) VALUES ('NC', 'New Caledonia');
INSERT INTO country (CountryCode, Name) VALUES ('NZ', 'New Zealand');
INSERT INTO country (CountryCode, Name) VALUES ('NI', 'Nicaragua');
INSERT INTO country (CountryCode, Name) VALUES ('NE', 'Niger');
INSERT INTO country (CountryCode, Name) VALUES ('NG', 'Nigeria');
INSERT INTO country (CountryCode, Name) VALUES ('NU', 'Niue');
INSERT INTO country (CountryCode, Name) VALUES ('NF', 'Norfolk Island');
INSERT INTO country (CountryCode, Name) VALUES ('MP', 'Northern Mariana Islands');
INSERT INTO country (CountryCode, Name) VALUES ('NO', 'Norway');
INSERT INTO country (CountryCode, Name) VALUES ('OM', 'Oman');
INSERT INTO country (CountryCode, Name) VALUES ('PK', 'Pakistan');
INSERT INTO country (CountryCode, Name) VALUES ('PW', 'Palau');
INSERT INTO country (CountryCode, Name) VALUES ('PS', 'Palestinian Territory, Occupied');
INSERT INTO country (CountryCode, Name) VALUES ('PA', 'Panama');
INSERT INTO country (CountryCode, Name) VALUES ('PG', 'Papua New Guinea');
INSERT INTO country (CountryCode, Name) VALUES ('PY', 'Paraguay');
INSERT INTO country (CountryCode, Name) VALUES ('PE', 'Peru');
INSERT INTO country (CountryCode, Name) VALUES ('PH', 'Philippines');
INSERT INTO country (CountryCode, Name) VALUES ('PN', 'Pitcairn');
INSERT INTO country (CountryCode, Name) VALUES ('PL', 'Poland');
INSERT INTO country (CountryCode, Name) VALUES ('PT', 'Portugal');
INSERT INTO country (CountryCode, Name) VALUES ('PR', 'Puerto Rico');
INSERT INTO country (CountryCode, Name) VALUES ('QA', 'Qatar');
INSERT INTO country (CountryCode, Name) VALUES ('RE', 'Reunion');
INSERT INTO country (CountryCode, Name) VALUES ('RO', 'Romania');
INSERT INTO country (CountryCode, Name) VALUES ('RU', 'Russian Federation');
INSERT INTO country (CountryCode, Name) VALUES ('RW', 'Rwanda');
INSERT INTO country (CountryCode, Name) VALUES ('BL', 'Saint Barthélemy');
INSERT INTO country (CountryCode, Name) VALUES ('SH', 'Saint Helena');
INSERT INTO country (CountryCode, Name) VALUES ('KN', 'Saint Kitts and Nevis');
INSERT INTO country (CountryCode, Name) VALUES ('LC', 'Saint Lucia');
INSERT INTO country (CountryCode, Name) VALUES ('MF', 'Saint Martin');
INSERT INTO country (CountryCode, Name) VALUES ('PM', 'Saint Pierre and Miquelon');
INSERT INTO country (CountryCode, Name) VALUES ('VC', 'Saint Vincent and the Grenadines');
INSERT INTO country (CountryCode, Name) VALUES ('WS', 'Samoa');
INSERT INTO country (CountryCode, Name) VALUES ('SM', 'San Marino');
INSERT INTO country (CountryCode, Name) VALUES ('ST', 'Sao Tome and Principe');
INSERT INTO country (CountryCode, Name) VALUES ('SA', 'Saudi Arabia');
INSERT INTO country (CountryCode, Name) VALUES ('SN', 'Senegal');
INSERT INTO country (CountryCode, Name) VALUES ('RS', 'Serbia');
INSERT INTO country (CountryCode, Name) VALUES ('SC', 'Seychelles');
INSERT INTO country (CountryCode, Name) VALUES ('SL', 'Sierra Leone');
INSERT INTO country (CountryCode, Name) VALUES ('SG', 'Singapore');
INSERT INTO country (CountryCode, Name) VALUES ('SK', 'Slovakia');
INSERT INTO country (CountryCode, Name) VALUES ('SI', 'Slovenia');
INSERT INTO country (CountryCode, Name) VALUES ('SB', 'Solomon Islands');
INSERT INTO country (CountryCode, Name) VALUES ('SO', 'Somalia');
INSERT INTO country (CountryCode, Name) VALUES ('ZA', 'South Africa');
INSERT INTO country (CountryCode, Name) VALUES ('GS', 'South Georgia and the South Sandwich Islands');
INSERT INTO country (CountryCode, Name) VALUES ('ES', 'Spain');
INSERT INTO country (CountryCode, Name) VALUES ('LK', 'Sri Lanka');
INSERT INTO country (CountryCode, Name) VALUES ('SD', 'Sudan');
INSERT INTO country (CountryCode, Name) VALUES ('SR', 'Suriname');
INSERT INTO country (CountryCode, Name) VALUES ('SJ', 'Svalbard and Jan Mayen');
INSERT INTO country (CountryCode, Name) VALUES ('SZ', 'Swaziland');
INSERT INTO country (CountryCode, Name) VALUES ('SE', 'Sweden');
INSERT INTO country (CountryCode, Name) VALUES ('CH', 'Switzerland');
INSERT INTO country (CountryCode, Name) VALUES ('SY', 'Syrian Arab Republic');
INSERT INTO country (CountryCode, Name) VALUES ('TW', 'Taiwan, Province Of China');
INSERT INTO country (CountryCode, Name) VALUES ('TJ', 'Tajikistan');
INSERT INTO country (CountryCode, Name) VALUES ('TZ', 'Tanzania, United Republic of');
INSERT INTO country (CountryCode, Name) VALUES ('TH', 'Thailand');
INSERT INTO country (CountryCode, Name) VALUES ('TL', 'Timor-Leste');
INSERT INTO country (CountryCode, Name) VALUES ('TG', 'Togo');
INSERT INTO country (CountryCode, Name) VALUES ('TK', 'Tokelau');
INSERT INTO country (CountryCode, Name) VALUES ('TO', 'Tonga');
INSERT INTO country (CountryCode, Name) VALUES ('TT', 'Trinidad and Tobago');
INSERT INTO country (CountryCode, Name) VALUES ('TN', 'Tunisia');
INSERT INTO country (CountryCode, Name) VALUES ('TR', 'Turkey');
INSERT INTO country (CountryCode, Name) VALUES ('TM', 'Turkmenistan');
INSERT INTO country (CountryCode, Name) VALUES ('TC', 'Turks and Caicos Islands');
INSERT INTO country (CountryCode, Name) VALUES ('TV', 'Tuvalu');
INSERT INTO country (CountryCode, Name) VALUES ('UG', 'Uganda');
INSERT INTO country (CountryCode, Name) VALUES ('UA', 'Ukraine');
INSERT INTO country (CountryCode, Name) VALUES ('AE', 'United Arab Emirates');
INSERT INTO country (CountryCode, Name) VALUES ('GB', 'United Kingdom');
INSERT INTO country (CountryCode, Name) VALUES ('US', 'United States');
INSERT INTO country (CountryCode, Name) VALUES ('UM', 'United States Minor Outlying Islands');
INSERT INTO country (CountryCode, Name) VALUES ('UY', 'Uruguay');
INSERT INTO country (CountryCode, Name) VALUES ('UZ', 'Uzbekistan');
INSERT INTO country (CountryCode, Name) VALUES ('VU', 'Vanuatu');
INSERT INTO country (CountryCode, Name) VALUES ('VE', 'Venezuela');
INSERT INTO country (CountryCode, Name) VALUES ('VN', 'Viet Nam');
INSERT INTO country (CountryCode, Name) VALUES ('VG', 'Virgin Islands, British');
INSERT INTO country (CountryCode, Name) VALUES ('VI', 'Virgin Islands, U.S.');
INSERT INTO country (CountryCode, Name) VALUES ('WF', 'Wallis And Futuna');
INSERT INTO country (CountryCode, Name) VALUES ('EH', 'Western Sahara');
INSERT INTO country (CountryCode, Name) VALUES ('YE', 'Yemen');
INSERT INTO country (CountryCode, Name) VALUES ('ZM', 'Zambia');
INSERT INTO country (CountryCode, Name) VALUES ('ZW', 'Zimbabwe');

INSERT INTO country (CountryCode, Name) VALUES ('JH', 'Johab'); /* This is for Korean dialect */

INSERT INTO country (CountryCode, Name) VALUES ('NY', 'Nynorsk'); /* This is for Norwegian dialect */
INSERT INTO country (CountryCode, Name) VALUES ('BK', 'Bokmal'); /* This is for Norwegian dialect */

INSERT INTO country (CountryCode, Name) VALUES ('YC', 'Cyrillic'); /* This is for Serbian dialect */
INSERT INTO country (CountryCode, Name) VALUES ('LN', 'Latin'); /* This is for Serbian dialect */


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
  `LanguageID` char(2) NOT NULL,
  `CountryCode` char(2),
  `EnglishName` varchar(64) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `OriginalName` varchar(128) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `Enabled` boolean DEFAULT false,
  PRIMARY KEY (`LanguageID`, `CountryCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


/* ---- Inserts ----- */

insert into language (LanguageID, CountryCode, EnglishName) values ('AF','','Afrikaans');
insert into language (LanguageID, CountryCode, EnglishName) values ('SQ','','Albanian');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','SA','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','IQ','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','EG','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','LY','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','DZ','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','MA','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','TN','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','OM','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','YE','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','SY','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','JO','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','LB','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','KW','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','AE','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','BH','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('AR','QA','Arabic');
insert into language (LanguageID, CountryCode, EnglishName) values ('EU','','Basque');
insert into language (LanguageID, CountryCode, EnglishName) values ('BG','','Bulgarian');
insert into language (LanguageID, CountryCode, EnglishName) values ('BE','','Belarusian');
insert into language (LanguageID, CountryCode, EnglishName) values ('CA','','Catalan');
insert into language (LanguageID, CountryCode, EnglishName) values ('ZH','TW','Chinese');
insert into language (LanguageID, CountryCode, EnglishName) values ('ZH','CN','Chinese');
insert into language (LanguageID, CountryCode, EnglishName) values ('ZH','HK','Chinese');
insert into language (LanguageID, CountryCode, EnglishName) values ('ZH','SG','Chinese');
insert into language (LanguageID, CountryCode, EnglishName) values ('HR','','Croatian');
insert into language (LanguageID, CountryCode, EnglishName) values ('CS','','Czech');
insert into language (LanguageID, CountryCode, EnglishName) values ('DA','','Danish');
insert into language (LanguageID, CountryCode, EnglishName) values ('NL','','Dutch');
insert into language (LanguageID, CountryCode, EnglishName) values ('NL','BE','Dutch');
insert into language (LanguageID, CountryCode, EnglishName) values ('EN','US','English');
insert into language (LanguageID, CountryCode, EnglishName) values ('EN','GB','English');
insert into language (LanguageID, CountryCode, EnglishName) values ('EN','AU','English');
insert into language (LanguageID, CountryCode, EnglishName) values ('EN','CA','English');
insert into language (LanguageID, CountryCode, EnglishName) values ('EN','NZ','English');
insert into language (LanguageID, CountryCode, EnglishName) values ('EN','IE','English');
insert into language (LanguageID, CountryCode, EnglishName) values ('EN','ZA','English');
insert into language (LanguageID, CountryCode, EnglishName) values ('EN','JM','English');
insert into language (LanguageID, CountryCode, EnglishName) values ('EN','BZ','English');
insert into language (LanguageID, CountryCode, EnglishName) values ('EN','TT','English');
insert into language (LanguageID, CountryCode, EnglishName) values ('ET','','Estonian');
insert into language (LanguageID, CountryCode, EnglishName) values ('FO','','Faeroese');
insert into language (LanguageID, CountryCode, EnglishName) values ('FA','','Farsi');
insert into language (LanguageID, CountryCode, EnglishName) values ('FI','','Finnish');
insert into language (LanguageID, CountryCode, EnglishName) values ('FR','','French');
insert into language (LanguageID, CountryCode, EnglishName) values ('FR','BE','French');
insert into language (LanguageID, CountryCode, EnglishName) values ('FR','CA','French');
insert into language (LanguageID, CountryCode, EnglishName) values ('FR','CH','French');
insert into language (LanguageID, CountryCode, EnglishName) values ('FR','LU','French');
insert into language (LanguageID, CountryCode, EnglishName) values ('GD','','Gaelic');
insert into language (LanguageID, CountryCode, EnglishName) values ('GA','','Irish');
insert into language (LanguageID, CountryCode, EnglishName) values ('DE','','German');
insert into language (LanguageID, CountryCode, EnglishName) values ('DE','CH','German');
insert into language (LanguageID, CountryCode, EnglishName) values ('DE','AT','German');
insert into language (LanguageID, CountryCode, EnglishName) values ('DE','LU','German');
insert into language (LanguageID, CountryCode, EnglishName) values ('DE','LI','German');
insert into language (LanguageID, CountryCode, EnglishName) values ('EL','','Greek');
insert into language (LanguageID, CountryCode, EnglishName) values ('HE','','Hebrew');
insert into language (LanguageID, CountryCode, EnglishName) values ('HI','','Hindi');
insert into language (LanguageID, CountryCode, EnglishName) values ('HU','','Hungarian');
insert into language (LanguageID, CountryCode, EnglishName) values ('IS','','Icelandic');
insert into language (LanguageID, CountryCode, EnglishName) values ('ID','','Indonesian');
insert into language (LanguageID, CountryCode, EnglishName) values ('IT','','Italian');
insert into language (LanguageID, CountryCode, EnglishName) values ('IT','CH','Italian');
insert into language (LanguageID, CountryCode, EnglishName) values ('JA','','Japanese');
insert into language (LanguageID, CountryCode, EnglishName) values ('KO','','Korean');
insert into language (LanguageID, CountryCode, EnglishName) values ('KO','JH','Korean');
insert into language (LanguageID, CountryCode, EnglishName) values ('LV','','Latvian');
insert into language (LanguageID, CountryCode, EnglishName) values ('LT','','Lithuanian');
insert into language (LanguageID, CountryCode, EnglishName) values ('MK','','Macedonian');
insert into language (LanguageID, CountryCode, EnglishName) values ('MS','','Malaysian');
insert into language (LanguageID, CountryCode, EnglishName) values ('MT','','Maltese');
insert into language (LanguageID, CountryCode, EnglishName) values ('NO','NY','Norwegian');
insert into language (LanguageID, CountryCode, EnglishName) values ('NO','BK','Norwegian');
insert into language (LanguageID, CountryCode, EnglishName) values ('PL','','Polish');
insert into language (LanguageID, CountryCode, EnglishName) values ('PT','BR','Portuguese');
insert into language (LanguageID, CountryCode, EnglishName) values ('PT','','Portuguese');
insert into language (LanguageID, CountryCode, EnglishName) values ('RM','','Rhaeto-Romanic');
insert into language (LanguageID, CountryCode, EnglishName) values ('RO','','Romanian');
insert into language (LanguageID, CountryCode, EnglishName) values ('RO','MO','Romanian');
insert into language (LanguageID, CountryCode, EnglishName) values ('RU','','Russian');
insert into language (LanguageID, CountryCode, EnglishName) values ('RU','MO','Russian');
insert into language (LanguageID, CountryCode, EnglishName) values ('SZ','','Sami');
insert into language (LanguageID, CountryCode, EnglishName) values ('SR','YC','Serbian');
insert into language (LanguageID, CountryCode, EnglishName) values ('SR','LN','Serbian');
insert into language (LanguageID, CountryCode, EnglishName) values ('SK','','Slovak');
insert into language (LanguageID, CountryCode, EnglishName) values ('SL','','Slovenian');
insert into language (LanguageID, CountryCode, EnglishName) values ('SB','','Sorbian');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','MX','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','GT','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','CR','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','PA','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','DO','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','VE','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','CO','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','PE','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','AR','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','EC','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','CL','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','UY','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','PY','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','BO','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','SV','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','HN','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','NI','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ES','PR','Spanish');
insert into language (LanguageID, CountryCode, EnglishName) values ('SX','','Sutu');
insert into language (LanguageID, CountryCode, EnglishName) values ('SV','','Swedish');
insert into language (LanguageID, CountryCode, EnglishName) values ('SV','FI','Swedi');
insert into language (LanguageID, CountryCode, EnglishName) values ('TH','','Thai');
insert into language (LanguageID, CountryCode, EnglishName) values ('TS','','Tsonga');
insert into language (LanguageID, CountryCode, EnglishName) values ('TN','','Tswana');
insert into language (LanguageID, CountryCode, EnglishName) values ('TR','','Turkish');
insert into language (LanguageID, CountryCode, EnglishName) values ('UK','','Ukrainian');
insert into language (LanguageID, CountryCode, EnglishName) values ('UR','','Urdu');
insert into language (LanguageID, CountryCode, EnglishName) values ('VE','','Venda');
insert into language (LanguageID, CountryCode, EnglishName) values ('VI','','Vietnamese');
insert into language (LanguageID, CountryCode, EnglishName) values ('XH','','Xhosa');
insert into language (LanguageID, CountryCode, EnglishName) values ('JI','','Yiddish');
insert into language (LanguageID, CountryCode, EnglishName) values ('ZU','','Zulu');


EOT;

      $this->versions['1.003'] = <<<EOT
      
update language set OriginalName = EnglishName;
update language set Enabled = TRUE where LanguageID = 'EN' and CountryCode = 'US';

CREATE TABLE `message` (
  `LanguageID` char(2) NOT NULL,
  `CountryCode` char(2),
  `EnglishMessage` varchar(256) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `TranslatedMessage` varchar(512) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`LanguageID`, `CountryCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
      
EOT;
      
      
    }
}
  
?>
