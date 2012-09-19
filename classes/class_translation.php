<?

class TRANSLATION {
    private $messages;
    private $languages;
    private $internalCache;

    private $defaultLanguageID = 'EN';
    private $defaultCountryCode = 'US';

    private $currentLanguageID;
    private $currentCountryCode;

    function __construct() {
      global $Cache;

      $this->internalCache = $Cache;

      $this->loadLanguages(); /// load the list of enabled/disabled languages
      echo "load languages --- 1";
      $this->currentLanguageID = $this->defaultLanguageID;
      $this->currentCountryCode = $this->defaultCountryCode;

      $this->messages = $this->internalCache->get_value('messages');
      if ( !isset($this->messages) ) {
        $this->messages = array(); /// wasn't cached
      }
    }

    public function translate($message, $languageID = '', $countryCode = '') {
      if (!isset($languageID) or Empty($languageID)) $languageID = $this->currentLanguageID;
      if (!isset($countryCode) or Empty($countryCode)) $countryCode = $this->currentCountryCode;

      $ret = $this->__translate($message, $languageID, $countryCode);

      if (!isset($ret) or Empty($ret)) {
        $ret = $message; /// no empty messages, ever
      }

      return $ret;
    }

    private function __translate($message, $languageID, $countryCode) {
      global $DB;

      if ( ! $this->languages[$languageID][$countryCode] ) { /// if the language is not enabled in the system, use default
        $languageID = $this->defaultLanguageID;
        $countryCode = $this->defaultCountryCode;
      }

      /// message is already loaded?
      if ( isset($this->messages[$message]) ) {
        if ( $this->isDefaultLanguage($languageID, $countryCode) or isset($this->messages[$message][$languageID][$countryCode]) ) {
          return $this->messages[$message][$languageID][$countryCode]; /// default language will always be present in the array
        }
      }

      /// TOOD: find a messages in a near language (excluding country code)
      if ( $this->isDefaultLanguage($languageID, $countryCode) ) {
        $DB->query("select LanguageID, CountryCode, EnglishMessage, TranslatedMessage from message where EnglishMessage = '$message' and (LanguageID = '".$this->defaultLanguageID."' and CountryCode = '".$this->defaultCountryCode."')");
      } else {
        $DB->query("select LanguageID, CountryCode, EnglishMessage, TranslatedMessage from message where EnglishMessage = '$message' and (LanguageID = '".$this->defaultLanguageID."' and CountryCode = '".$this->defaultCountryCode."') or (LanguageID = '$languageID' and CountryCode = '$countryCode') ");
      }

      if ($DB->record_count() == 0) { /// message still not in database, let's add a default language record for it
        $this->messages[$message][$this->defaultLanguageID][$this->defaultCountryCode] = $message;
        $this->addTranslationToDatabase($message, $this->defaultLanguageID, $this->defaultCountryCode, $message);
        $this->cacheIt();
        return $message;
      } else {
        $translations = $DB->to_array(0, MYSQLI_NUM);
        foreach($translations as $record) {
          $this->messages[$record[2]][$record[0]][$record[1]] = $record[3];
        }
        $this->cacheIt();
        if ( isset($this->messages[$message][$languageID][$countryCode])  ) {
          return $this->messages[$message][$languageID][$countryCode]; /// found it translated
        } else {
          return $this->messages[$message][$this->defaultLanguageID][$this->defaultCountryCode]; /// looks it has just a default language version of this message
        }
      }
    }

    private function cacheIt() {
      $this->internalCache->cache_value('messages', $this->messages);
    }

    private function isDefaultLanguage($lID, $cCode) {
      return ($lID == $this->defaultLanguageID) and ($cCode = $this->defaultCountryCode);
    }

    private function addTranslationToDatabase($message, $lID, $cCode, $translatedMessage) {
      global $DB;

      $hash = SHA1($message);
      $DB->query("insert into message (LanguageID, CountryCode, EnglishMessageHash, EnglishMessage, TranslatedMessage) values ('$lID', '$cCode', '$hash', '$message', '$translatedMessage');");
    }
    
    private function loadLanguages() {
      global $DB;
      
      $this->languages = $this->internalCache->get_value('languages');
      if ( !isset($this->languages) or count($this->languages) < 10 ) {
        // echo "loading... <pre>"; print_r($this->languages); echo "</pre><br>";

        $this->languages = array(); /// wasn't cached
        $DB->query("select LanguageID, CountryCode, EnglishName, OriginalName, Enabled from language"); /// get the full language listing
        $languages = $DB->to_array(0, MYSQLI_NUM);
        foreach($languages as $record) {
          $this->languages[$record[0]][$record[1]] = $record[4]; /// build a list of enabled languages
        }
      }
    }

    public function setLanguage($lid, $cc) {
      $this->languageID = $li;
      $this->countryCode = $cc;
    }

}

?>
