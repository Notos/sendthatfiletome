<?
if(!isset($_GET['id']) || !is_number($_GET['id'])) { error(404); }
$ArticleID = $_GET['id'];

$Latest = $Alias->article($ArticleID);
list($Revision, $Title, $Body, $Read, $Edit, $Date, $AuthorID, $AuthorName) = array_shift($Latest);
if($Read > $LoggedUser['EffectiveClass']){ error(404); }
if($Edit > $LoggedUser['EffectiveClass']){ error(403); }

show_header("Revisions of ".$Title);
?>
<div class="thin">
	<div class="header">
		<h2>Revision history for <a href="wiki.php?action=article&amp;id=<?=$ArticleID?>"><?=$Title?></a></h2>
	</div>
	<form action="wiki.php" method="get">
		<input type="hidden" name="action" id="action" value="compare" />
		<input type="hidden" name="id" id="id" value="<?=$ArticleID?>" />
		<table>
			<tr class="colhead">
				<td>Revision</td>
				<td>Title</td>
				<td>Author</td>
				<td>Age</td>
				<td>Old</td>
				<td>New</td>
			</tr>
			<tr>
				<td><?=$Revision?></td>
				<td><?=$Title?></td>
				<td><?=format_username($AuthorID, false, false, false)?></td>
				<td><?=time_diff($Date)?></td>
				<td><input type="radio" name="old" value="<?=$Revision?>" disabled /></td>
				<td><input type="radio" name="new" value="<?=$Revision?>" /></td>
			</tr>
<? 	
$DB->query("SELECT 
	w.Revision, 
	w.Title, 
	w.Author,
	w.Date
	FROM wiki_revisions AS w
	WHERE w.ID='$ArticleID'
	ORDER BY Revision DESC");
while(list($Revision, $Title, $AuthorID, $Date) = $DB->next_record()) { ?>
			<tr>
				<td><?=$Revision?></td>
				<td><?=$Title?></td>
				<td><?=format_username($AuthorID, false, false, false)?></td>
				<td><?=time_diff($Date)?></td>
				<td><input type="radio" name="old" value="<?=$Revision?>" /></td>
				<td><input type="radio" name="new" value="<?=$Revision?>" /></td>
			</tr>
<? } ?>
			<tr>
				<td class="center" colspan="6">
					<input type="submit" value="Compare" />
				</td>
			</tr>
		</table>
	</form>
</div>
<? show_footer(); ?>
