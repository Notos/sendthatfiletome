<?
//******************************************************************************//
//--------------- Insert or Update a translation -------------------------------//

if(!check_perms('site_translator')){
	error(403);
}

$messageHash = $_GET['messageHash'];
$originalMessage = $_GET['originalMessage'];
$englishTranslation = $_GET['englishTranslation'];
$currentTranslation = $_GET['currentTranslation'];
$languageID = $_GET['languageID'];
$countryCode = $_GET['countryCode'];

$DB->query("update message set TranslatedMessage = '$currentTranslation' where m.EnglishMessageHash = '$messageHash' and m.LanguageID = '$languageID' and m.CountryCode = '$countryCode'");

if ($DB->affected_rows() == 0) {
  $DB->query("insert into message (LanguageID, CountryCode, EnglishMessageHash, EnglishMessage, TranslatedMessage) values ('$languageID','$countryCode','$messageHash','$originalMessage',$currentTranslation')");
}

header('Location: tools.php?action=translator');
?>
