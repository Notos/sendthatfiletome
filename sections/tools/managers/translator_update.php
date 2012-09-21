<?
//******************************************************************************//
//--------------- Insert or Update a translation -------------------------------//

if(!check_perms('site_translator')){
    error(403);
}

$messageHash = $_POST['messageHash'];
$originalMessage = $_POST['originalMessage'];
$englishTranslation = $_POST['englishTranslation'];
$currentTranslation = $_POST['currentTranslation'];
$languageID = $_POST['languageID'];
$countryCode = $_POST['countryCode'];

$DB->query("update message set TranslatedMessage = '$currentTranslation' where m.EnglishMessageHash = '$messageHash' and m.LanguageID = '$languageID' and m.CountryCode = '$countryCode'");

if ($DB->affected_rows() == 0) {
  $DB->query("insert into message (LanguageID, CountryCode, EnglishMessageHash, EnglishMessage, TranslatedMessage) values ('$languageID','$countryCode','$messageHash','$originalMessage',$currentTranslation')");
}

header('Location: tools.php?action=translator');
?>
