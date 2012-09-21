<?
//******************************************************************************//
//--------------- Insert or Update a translation -------------------------------//

if(!check_perms('site_translator')){
	error(403);
}

echo "1 --------- <br>";
TOOLS::pa($_REQUEST);
echo "2 --------- <br>";
TOOLS::pa($_POST);
echo "3 --------- <br>";
TOOLS::pa($_GET);
echo "4 --------- <br>";

$messageHash = $_POST['messageHash'];
$originalMessage = $_POST['originalMessage'];
$englishTranslation = $_POST['englishTranslation'];
$currentTranslation = $_POST['currentTranslation'];
$languageID = $_POST['languageID'];
$countryCode = $_POST['countryCode'];

echo "5 --------- <br>";

//$DB->query("update message set TranslatedMessage = '$currentTranslation' where m.EnglishMessageHash = '$messageHash' and m.LanguageID = '$languageID' and m.CountryCode = '$countryCode'");
echo "update message set TranslatedMessage = '$currentTranslation' where m.EnglishMessageHash = '$messageHash' and m.LanguageID = '$languageID' and m.CountryCode = '$countryCode'";
echo "6 --------- <br>";
echo "insert into message (LanguageID, CountryCode, EnglishMessageHash, EnglishMessage, TranslatedMessage) values ('$languageID','$countryCode','$messageHash','$originalMessage',$currentTranslation')";
echo "7 --------- <br>";

if ($DB->affected_rows() == 0) {
//  $DB->query("insert into message (LanguageID, CountryCode, EnglishMessageHash, EnglishMessage, TranslatedMessage) values ('$languageID','$countryCode','$messageHash','$originalMessage',$currentTranslation')");
echo "insert into message (LanguageID, CountryCode, EnglishMessageHash, EnglishMessage, TranslatedMessage) values ('$languageID','$countryCode','$messageHash','$originalMessage',$currentTranslation')";
}

echo "8 --------- <br>";
die;
header('Location: tools.php?action=translator');
?>
