<?
  if(!check_perms('site_translator')){
    error(403);
  }
  show_header('Translator Manager');

  $language = $_GET['language'];
  
  $searchString = $_POST['search'];
  if(!isset($searchString) or empty($searchString)) {
    $searchString = $_GET['search'];
  }

  $messageHash = $_POST['messageHash'];
  if(!isset($messageHash) or empty($messageHash)) {
    $messageHash = $_GET['messageHash'];
  }
  
  if(isset($language) and !empty($language)) {
    setcookie("translatingLanguage",$language);
  } else {
    $language = $_COOKIE['translatingLanguage'];
  }

  if (!isset($language) or empty($language)) {
    global $LoggedUser; 
    $language = $LoggedUser['Language'];
  }

  $originalMessage = '';
  $englishTranslation = '';
  $currentTranslation = '';

  list($languageID, $countryCode) = explode("-", $language);

  $query = "
  select 
  m.EnglishMessageHash messageHash
  , m.EnglishMessage originalMessage   
  , (select TranslatedMessage from message mx where mx.EnglishMessageHash = m.EnglishMessageHash and LanguageID = 'EN' and CountryCode = 'US') EnglishTranslation
  , m.TranslatedMessage currentTranslation
  from message m
  where case when '$messageHash' = '' then ( m.LanguageID = 'EN' and m.CountryCode = 'US' and m.EnglishMessageHash not in (select mmx.EnglishMessageHash from message mmx where mmx.LanguageID = '$languageID' and mmx.CountryCode = '$countryCode') )
  else m.EnglishMessageHash = '$messageHash' and m.LanguageID = '$languageID' and m.CountryCode = '$countryCode'
  end
  limit 0 , 1
  ";   

  $DB->query($query);

  list($messageHash, $originalMessage, $englishTranslation, $currentTranslation) = $DB->next_record();

?>

<h3><? T("Current language:"); ?> <? echo TOOLS::languageName($language);?></h3>

<div id="translator">
  <div class="permissions">
    <div class="permission_container" style="width:65%;">
      <table>
        <tr class="colhead">
          <td colspan="2"><? T("Translate it!"); ?></td>
        </tr>
        <?if ( !isset($messageHash) or empty($messageHash) ) {
            echo '<tr><td colspan="2"><br><br><strong>'.TT("There are no untranslated messages for").' '.TOOLS::languageName($language).', '.TT("please select another one from the available languages").'.</strong><br><br><br></td></tr>';
          } else { /// start of form block ?>
          <form action="tools.php" method="post" class="pad">
            <input type="hidden" name="action" value="translator_update" />
            <input type="hidden" name="messageHash" value="<?=$messageHash?>" />
            <input type="hidden" name="language" value="<?=$language?>" />
            <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />

            <tr><td colspan="2"><strong><? echo TOOLS::languageName('EN-US');?> - Original message or code</strong></td></tr>
            <tr><td>
                <textarea name="originalMessage" cols="70" rows="5" readonly="readonly"><?=$originalMessage?></textarea>
              </td></tr>

            <tr><td colspan="2"><br><strong><? echo TOOLS::languageName('EN-US');?> - Message translated to English (this is what you will see)</strong></td></tr>
            <tr><td>
                <textarea name="englishTranslation" cols="70" rows="5" readonly="readonly"><?=$englishTranslation?></textarea>
              </td></tr>

            <tr><td colspan="2"><br><strong><? echo TOOLS::languageName($language);?> - Your translation goes here</strong></td></tr>
            <tr><td>
                <textarea name="currentTranslation" cols="70" rows="15"><?=$currentTranslation?></textarea>
              </td></tr>

            <tr><td>
                <input type="submit" value="<? T("Add translation"); ?>" />
              </td></tr>
          </form>
          <? } /// end of form block ?>
      </table>
    </div>
  </div>

  <div class="permissions">
    <div class="permission_container" style="width:30%;">
      <table>
        <tr class="colhead">
          <td colspan="2"><? T("Available languages"); ?></td>
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
            <?while(list($LanguageID, $LanguageName, $Missing)=$DB->next_record()) {
                $link = 'http'.($SSL?'s':'').'://'.SITE_URL.'/tools.php?action=translator&language='.$LanguageID;
                $link = "<a href=\"$link\">$LanguageName</a>";?>
              <tr>
                <td><?=$link?></td> <td><?=$Missing?></td>
              </tr>
              <?}?>
          </table>
        </tr>
      </table><br /><br />                                                         
    </div>
  </div>
</div>

<div id="search_form">
  <table class="torrent_table cats numbering border">
    <tr class="colhead"><td><? T("Search to edit translated messages"); ?></td></tr>
    <tr><td>
        <form action="tools.php" method="post" class="pad">
          <input type="hidden" name="action" value="translator" />
          <input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
          <? T("Search"); ?>
          <input type="text" spellcheck="false" size="40" name="search" class="inputtext smaller" value="<?=$searchString?>" />
        </form>
      </td></tr>
  </table>
</div>

<h3></h3>

<? if(isset($searchString) and !empty($searchString)) { ?>
<div id="search_result">
  <table class="torrent_table cats numbering border">
    <tr class="colhead"><td><? T("Click on a message to edit it"); ?></td></tr>
  </table>  
  <table class="torrent_table cats numbering border">
    <?
      echo "<tr><td><strong>".TOOLS::languageName('EN-US')."</strong></td> <td><strong>".TOOLS::languageName($language)."</strong></td></tr>";
      $DB->query("select 
        LanguageID
      , CountryCode
      , EnglishMessageHash
      , EnglishMessage
      , TranslatedMessage 
      from message 
      where ((EnglishMessage like '%$searchString%' or TranslatedMessage like '%$searchString%') and ((LanguageID = '$languageID' and CountryCode = '$countryCode')))
      ");

      while(list($LanguageID, $CountryCode, $EnglishMessageHash, $EnglishMessage, $TranslatedMessage)=$DB->next_record()) {
        $link = 'http'.($SSL?'s':'').'://'.SITE_URL.'/tools.php?action=translator&language='.$language."&messageHash=$EnglishMessageHash&search=$searchString";
        $link1 = "<a href=\"$link\">$EnglishMessage</a>";
        $link2 = "<a href=\"$link\">$TranslatedMessage</a>";
        echo "<tr><td>$link1</td> <td>$link2</td></tr>";
      }
    ?>
  </table>
</div>
<? } ?>
        
<? show_footer(); ?>
  
  


   