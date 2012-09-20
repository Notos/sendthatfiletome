<?
if(!check_perms('site_translator')){
	error(403);
}
show_header('Translator Manager');

$DB->query("
SELECT
  coalesce( concat( l.LanguageID, (case when l.CountryCode is not null and l.CountryCode <> '' then '-' else '' end), l.CountryCode) , '') LanguageID
, concat(l.EnglishName, (case when c.Name is not null and c.Name <> '' then ' (' else '' end), (case when c.Name is not null and c.Name <> '' then c.Name else '' end), (case when c.Name is not null and c.Name <> ''  then ')' else ''  end)) LanguageName
, (select count(*) from message xm where xm.LanguageID = 'EN' and xm.CountryCode = 'US' and xm.EnglishMessageHash not in (select xxm.EnglishMessageHash from message xxm where xxm.LanguageID = l.LanguageID and xxm.CountryCode = l.CountryCode)) Missing
FROM language l left join country c on l.CountryCode = c.CountryCode
WHERE Enabled = TRUE
ORDER BY Missing desc
	");
?>

<div class="thin">
  <table>
    <tr>
      <td width="70%">
    		<div class="head colhead_dark"><strong>Translate it</strong></div>
      </td>
      <td width="30%">
    		<div class="head colhead_dark"><strong>Available languages</strong></div>
    		<table>
    		  <tr>
    		    <td>Language</td> <td>Missing</td>
          </tr>
          <?while(list($LanguageID, $LanguageName, $Missing)=$DB->next_record()) {?>
              <tr>
        		    <td><?=$LanguageName?></td> <td><?=$Missing?></td>
              </tr>
          <?}?>
        </table>
      </td>
    </tr>
  </table>
</div>

<div class="thin">
	<div class="box" id="recommended">
		<div class="head colhead_dark"><strong>Translator Manager</strong></div>
<?		if(!in_array($LoggedUser['ID'], $DB->collect('UserID'))){ ?>
		<form action="tools.php" method="post" class="pad">
			<input type="hidden" name="action" value="recommend_add" />
			<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
			<table cellpadding="6" cellspacing="1" border="0" class="layout border" width="100%">
				<tr>
					<td rowspan="2" class="label"><strong>Add Recommendation:</strong></td>
					<td>Link to a torrent group on site. E.g. <strong>http://<?=NONSSL_SITE_URL?>/torrents.php?id=10000</strong></td>
				</tr>
				<tr>
					<td>
						<input type="text" name="url" size="50" />
						<input type="submit" value="Add recommendation" />
					</td>
				</tr>
			</table>
		</form>
<?		} ?>
		<ul class="nobullet">
<?
	while(list($GroupID, $UserID, $GroupName, $ArtistID, $ArtistName)=$DB->next_record()) {
?>
			<li>
				<strong><?=format_username($UserID, false, false, false)?></strong>
<?		if($ArtistID){ ?> 
				- <a href="artist.php?id=<?=$ArtistID?>"><?=$ArtistName?></a>
<?		} ?> 
				- <a href="torrents.php?id=<?=$GroupID?>"><?=$GroupName?></a>
<?		if(check_perms('site_manage_recommendations') || $UserID == $LoggedUser['ID']){ ?>
				<a href="tools.php?action=recommend_alter&amp;groupid=<?=$GroupID?>">[Delete]</a>
<?		} ?> 
			</li>
<?	} ?>
		</ul>
	</div>
</div>
<? show_footer(); ?>