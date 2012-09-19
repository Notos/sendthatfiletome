<?

class TRANSLATION {
    private $messages;
    private $internalCache;
    
    private $defaultLanguageID = 'EN';
    private $defaultCountryCode = 'US';

    private $languageID;
    private $countryCode;

    
    function __construct() {
      global $Cache;
      
      $this->languageID = $this->defaultLanguageID;
      $this->countryCode = $this->defaultCountryCode;
      
      $this->internalCache = $Cache;
      $this->messages = $this->internalCache->get_value('messages');
      if ( !isset($this->messages) ) {
        $this->messages = array(); /// wasn't cached
      }
    }

    private function translate($message, $languageID, $countryCode) {
      global $DB;
      
      if ( isset($this->messages[$message]) ) {
        if ( $this->isDefaultLanguage($languageID, $countryCode) or isset($this->messages[$message][$languageID][$countryCode])  ) {
          return $this->messages[$message][$languageID][$countryCode]; /// default language will always be present in the array
        }
      }
      
      /// we also will have to find a near language (excluding country code)
      if ( $this->isDefaultLanguage($languageID, $countryCode) ) {
        $DB->query("select LanguageID, CountryCode, EnglishMessage, TranslatedMessage from message where EnglishMessage = '$message' and (LanguageID = '".$this->defaultLanguageID."' and CountryCode = '".$this->defaultCountryCode."')");
      } else {
        $DB->query("select LanguageID, CountryCode, EnglishMessage, TranslatedMessage from message where EnglishMessage = '$message' and (LanguageID = '".$this->defaultLanguageID."' and CountryCode = '".$this->defaultCountryCode."') or (LanguageID = '$languageID' and CountryCode = '$countryCode') ");
      }

      if ($DB->record_count() == 0) {
        $this->messages[$message][$this->defaultLanguageID][$this->defaultCountryCode] = $message;
        $this->addTranslationToDatabase($message, $this->defaultLanguageID, $this->defaultCountryCode, $message);
        $this->cacheIt();
      } else {
        $translations = $DB->to_array(0, MYSQLI_NUM);
        foreach($translations as $record) {
          $this->messages[$record[0]][$record[1]][$record[2]] = $record[3];
        }
        $this->cacheIt();
        if ( isset($this->messages[$message][$languageID][$countryCode])  ) {
          return $this->messages[$message][$languageID][$countryCode];
        } else { 
          return $this->messages[$message][$this->defaultLanguageID][$this->defaultCountryCode]; /// now we have a default language
        }
      }
    }
    
    private function cacheIt() {
      $this->internalCache->cache_value('messages', $this->messages);
    }

    private function isDefaultLanguage($lID, $cCode) {
      return ($lID == $this->defaultLanguageID) and ($cCode = $this->defaultCountryCode);
    }

    public function t($message, $lID = '', $cCode = '') {
      if (!isset($lID)) $lID = $this->defaultLanguageID;
      if (!isset($cCode)) $cCode = $this->defaultCountryCode;
      return $this->translate($message, $lID, $cCode);
    }

    public function setLanguage($lid, $cc) {
      $this->languageID = $li;
      $this->countryCode = $cc;
    }
    
}  
  
?>
