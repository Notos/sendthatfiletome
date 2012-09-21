<?
  if(!check_perms('site_translator')){
    error(403);
  }

show_header('Translator language management');
  
$DB->query("
              SELECT
              coalesce( concat( l.LanguageID, (case when l.CountryCode is not null and l.CountryCode <> '' then '-' else '' end), l.CountryCode) , '') LanguageID
              , concat(l.EnglishName, (case when c.Name is not null and c.Name <> '' then ' (' else '' end), (case when c.Name is not null and c.Name <> '' then c.Name else '' end), (case when c.Name is not null and c.Name <> ''  then ')' else ''  end)) LanguageName
              , (select count(*) from message xm where xm.LanguageID = 'EN' and xm.CountryCode = 'US' and xm.EnglishMessageHash not in (select xxm.EnglishMessageHash from message xxm where xxm.LanguageID = l.LanguageID and xxm.CountryCode = l.CountryCode)) Missing
              , l.Enabled Enabled
              FROM language l left join country c on l.CountryCode = c.CountryCode
              WHERE Enabled = TRUE
              ORDER BY Missing desc
              ");
?>
                
<div class="thin">
    <div class="header">
        <h2>Translator language management</h2>
    </div>
    <table width="100%">
        <tr class="colhead">
            <td>Language ID</td>
            <td>Language name</td>
            <td>Missing translations</td>
            <td>Enabled/Disabled</td>
        </tr>
        <?while(list($LanguageID, $LanguageName, $Missing, $Enabled)=$DB->next_record()) {
            $link = 'http'.($SSL?'s':'').'://'.SITE_URL.'/tools.php?action=translator&language='.$LanguageID;
            $link = "<a href=\"$link\">$LanguageName</a>";?>
          <tr>
            <td><?=$LanguageID?></td> 
            <td><?=$LanguageName?></td> 
            <td><?=$Missing?></td>
            <td><?=$Enabled?></td>
          </tr>
          <?}?>
    </table>
</div>
        
<? show_footer(); ?>
   