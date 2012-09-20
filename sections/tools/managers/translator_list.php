<?
if(!check_perms('site_translator')){
	error(403);
}
show_header('Translator Manager');

$language = $_COOKIE['translatingLanguage'];

if (!isset($language) or empty($language)) {
  global $LoggedUser; 
  $language = $LoggedUser['Language'];
}

$messageHash = '';
$originalMessage = '';
$englishTranslation = '';
$currentTranslation = '';

list($lid, $lcc) = explode("-", $language);

$DB->query("
  select 
    m.EnglishMessageHash messageHash
  , m.EnglishMessage originalMessage   
  , (select TranslatedMessage from message mx where mx.EnglishMessageHash = m.EnglishMessageHash and LanguageID = 'EN' and CountryCode = 'US') EnglishTranslation
  , m.TranslatedMessage currentTranslation
  from message m
  where case when '$messageHash' = '' then ( m.LanguageID = 'EN' and m.CountryCode = 'US' and m.EnglishMessageHash not in (select mmx.EnglishMessageHash from message mmx where mmx.LanguageID = '$lid' and mmx.CountryCode = '$lcc') )
             else m.EnglishMessageHash = '$messageHash' and m.LanguageID = '$lid' and m.CountryCode = '$lcc'
             end
  limit 0 , 1
");

list($messageHash, $originalMessage, $englishTranslation, $currentTranslation) = $DB->next_record();

if ( !isset($messageHash) or empty($messageHash) ) {
  echo "There are no untranslated messages for ".TOOLS::languageName($language);
} else { /// start of form block ?>

<div class="permissions">
  <div class="permission_container" style="width:65%;">
    <table>
      <tr class="colhead">
        <td colspan="2">Translate it!</td>
      </tr>
      <form>
        <input type="hidden" name="messageHash" value="<?=$messageHash?>" />

        <tr><td colspan="2"><strong><? echo TOOLS::languageName('EN-US');?> - Original message or code</strong></td></tr>
        <tr><td>
            <textarea name="originalMessage" cols="70" rows="5" readonly="readonly" value="<?=$originalMessage?>"></textarea>
          </td></tr>

        <tr><td colspan="2"><br><strong><? echo TOOLS::languageName('EN-US');?> - Message translated to English (this is what you will see)</strong></td></tr>
        <tr><td>
            <textarea name="englishTranslation" cols="70" rows="5" readonly="readonly" value="<?=$englishTranslation?>"></textarea>
          </td></tr>
        <tr><td colspan="2"><br><strong><? echo TOOLS::languageName($language);?> - Your translation goes here</strong></td></tr>
        <tr><td>
            <textarea name="currentTranslation" cols="70" rows="15" value="<?=$currentTranslation?>"></textarea>
          </td></tr>

        <tr><td>
            <input type="submit" value="Add translation" />
          </td></tr>
      </form>
    </table>
  </div>
</div>

<div class="permissions">
	<div class="permission_container" style="width:30%;">
		<table>
			<tr class="colhead">
				<td colspan="2">Available languages</td>
			</tr>
			<tr>
      		<table>
      		  <tr>
      		    <td><strong>Language</strong></td> <td><strong>Missing</strong></td>
            </tr>
            <?$DB->query("
              SELECT
                coalesce( concat( l.LanguageID, (case when l.CountryCode is not null and l.CountryCode <> '' then '-' else '' end), l.CountryCode) , '') LanguageID
              , concat(l.EnglishName, (case when c.Name is not null and c.Name <> '' then ' (' else '' end), (case when c.Name is not null and c.Name <> '' then c.Name else '' end), (case when c.Name is not null and c.Name <> ''  then ')' else ''  end)) LanguageName
              , (select count(*) from message xm where xm.LanguageID = 'EN' and xm.CountryCode = 'US' and xm.EnglishMessageHash not in (select xxm.EnglishMessageHash from message xxm where xxm.LanguageID = l.LanguageID and xxm.CountryCode = l.CountryCode)) Missing
              FROM language l left join country c on l.CountryCode = c.CountryCode
              WHERE Enabled = TRUE
              ORDER BY Missing desc
              	");?>
            <?while(list($LanguageID, $LanguageName, $Missing)=$DB->next_record()) {?>
                <tr>
          		    <td><?=$LanguageName?></td> <td><?=$Missing?></td>
                </tr>
            <?}?>
          </table>
      </tr>
    </table>
  </div>
</div>

<? } /// end of form block

show_footer(); 

?>
  