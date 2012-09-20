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
 
 // setcookie('redirect','',time()-60*60*24,'/','',false);

?>

<div class="permissions">
	<div class="permission_container" style="width:65%;">
		<table>
			<tr class="colhead">
				<td colspan="2">Translate it!</td>
			</tr>
			<form>
  			<tr><td colspan="2"><strong><? echo TOOLS::languageName('EN-US');?> - Original message or code</strong></td></tr>
        <tr><td>
          <textarea name="originalText" cols="70" rows="5" readonly="readonly"></textarea>
        </td></tr>

  			<tr><td colspan="2"><br><strong><? echo TOOLS::languageName('EN-US');?> - Message translated to English (this is what you will see)</strong></td></tr>
        <tr><td>
          <textarea name="originalText" cols="70" rows="5" readonly="readonly"></textarea>
        </td></tr>
  			<tr><td colspan="2"><br><strong><? echo TOOLS::languageName($language);?> - Your translation goes here</strong></td></tr>
        <tr><td>
          <textarea name="originalText" cols="70" rows="15"></textarea>
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

<? show_footer(); ?>
