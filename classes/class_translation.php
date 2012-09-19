<?

class TRANSLATION {
    private $messages;
    private $internalCache;

    private $defaultLanguageID = 'EN';
    private $defaultCountryCode = 'US';

    private $currentLanguageID;
    private $currentCountryCode;

    function __construct() {
      global $Cache;

      $this->currentLanguageID = $this->defaultLanguageID;
      $this->currentCountryCode = $this->defaultCountryCode;

      $this->internalCache = $Cache;
      $this->messages = $this->internalCache->get_value('messages');
      if ( !isset($this->messages) ) {
        $this->messages = array(); /// wasn't cached
      }
    }

    public function translate($message, $languageID = '', $countryCode = '') {
      echo "$languageID,$countryCode";

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

    public function setLanguage($lid, $cc) {
      $this->languageID = $li;
      $this->countryCode = $cc;
    }

}

?>
