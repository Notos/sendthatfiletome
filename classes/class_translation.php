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
echo "---- 1";
      if ( isset($this->messages[$message]) ) {
echo "---- 2";
        if ( $this->isDefaultLanguage($languageID, $countryCode) or isset($this->messages[$message][$languageID][$countryCode])  ) {
echo "---- 3";
          return $this->messages[$message][$languageID][$countryCode]; /// default language will always be present in the array
echo "---- 4";
        }
echo "---- 5";
      }
echo "---- 6";

echo "---- 7";
      /// we also will have to find a near language (excluding country code)
echo "---- 8 ---- $languageID, $countryCode";
      if ( $this->isDefaultLanguage($languageID, $countryCode) ) {
echo "---- 9";
        $DB->query("select LanguageID, CountryCode, EnglishMessage, TranslatedMessage from message where EnglishMessage = '$message' and (LanguageID = '".$this->defaultLanguageID."' and CountryCode = '".$this->defaultCountryCode."')");
echo "---- 10";
      } else {
echo "---- 11";
        $DB->query("select LanguageID, CountryCode, EnglishMessage, TranslatedMessage from message where EnglishMessage = '$message' and (LanguageID = '".$this->defaultLanguageID."' and CountryCode = '".$this->defaultCountryCode."') or (LanguageID = '$languageID' and CountryCode = '$countryCode') ");
echo "---- 12";
      }
echo "---- 13";

echo "---- 14";
      if ($DB->record_count() == 0) {
echo "---- 15";
        $this->messages[$message][$this->defaultLanguageID][$this->defaultCountryCode] = $message;
echo "---- 16";
        $this->addTranslationToDatabase($message, $this->defaultLanguageID, $this->defaultCountryCode, $message);
echo "---- 17";
        $this->cacheIt();
echo "---- 18";
        return $message;
echo "---- 19";
      } else {
echo "---- 20";
        $translations = $DB->to_array(0, MYSQLI_NUM);
echo "---- 21";
        foreach($translations as $record) {
echo "---- 22";
          $this->messages[$record[0]][$record[1]][$record[2]] = $record[3];
echo "---- 23";
        }
echo "---- 24";
        $this->cacheIt();
echo "---- 25";
        if ( isset($this->messages[$message][$languageID][$countryCode])  ) {
echo "---- 26";
          return $this->messages[$message][$languageID][$countryCode];
echo "---- 27";
        } else {
echo "---- 28";
          return $this->messages[$message][$this->defaultLanguageID][$this->defaultCountryCode]; /// now we have a default language
echo "---- 291";
        }
echo "---- 30";
      }
echo "---- 31";
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

    public function t($message, $lID = '', $cCode = '') {
      if (!isset($lID) or Empty($lID)) $lID = $this->defaultLanguageID;
      if (!isset($cCode) or Empty($cCode)) $cCode = $this->defaultCountryCode;
      return $this->translate($message, $lID, $cCode);
    }

    public function setLanguage($lid, $cc) {
      $this->languageID = $li;
      $this->countryCode = $cc;
    }

}

?>
