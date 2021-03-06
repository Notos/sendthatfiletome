<?
if(!check_perms('admin_login_watch')) { error(403); }

if(isset($_POST['submit']) && isset($_POST['id']) && $_POST['submit'] == 'Unban' && is_number($_POST['id'])){
	authorize();
	$DB->query('DELETE FROM login_attempts WHERE ID='.$_POST['id']);
}

show_header('Login Watch');

$DB->query('SELECT 
	l.ID,
	l.IP,
	l.UserID,
	l.LastAttempt,
	l.Attempts,
	l.BannedUntil,
	l.Bans
	FROM login_attempts AS l
	WHERE l.BannedUntil > "'.sqltime().'"
	ORDER BY l.BannedUntil ASC');
?>
<div class="thin">
	<div class="header">
		<h2>Login Watch Management</h2>
	</div>
	<table width="100%">
		<tr class="colhead">
			<td>IP</td>
			<td>User</td>
			<td>Bans</td>
			<td>Remaining</td>
			<td>Submit</td>
			<? if(check_perms('admin_manage_ipbans')) { ?>		<td>Submit</td><? } ?>
		</tr>
<?
$Row = 'b';
while(list($ID, $IP, $UserID, $LastAttempt, $Attempts, $BannedUntil, $Bans) = $DB->next_record()){
	$Row = ($Row === 'a' ? 'b' : 'a');
?>
		<tr class="row<?=$Row?>">
			<td>
				<?=$IP?>
			</td>
			<td>
				<? if ($UserID != 0) { echo format_username($UserID, true, true, true, true); } ?>
			</td>
			<td>
				<?=$Bans?>
			</td>
			<td>
				<?=time_diff($BannedUntil)?>
			</td>	
			<td>
				<form class="manage_form" name="bans" action="" method="post">
					<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
					<input type="hidden" name="id" value="<?=$ID?>" />
					<input type="hidden" name="action" value="login_watch" />
					<input type="submit" name="submit" value="Unban" />
				</form>
			</td>
<? if(check_perms('admin_manage_ipbans')) { ?>
			<td>
				<form class="manage_form" name="bans" action="" method="post">
					<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
					<input type="hidden" name="id" value="<?=$ID?>" />
					<input type="hidden" name="action" value="ip_ban" />
					<input type="hidden" name="start" value="<?=$IP?>" />
					<input type="hidden" name="end" value="<?=$IP?>" />
					<input type="hidden" name="notes" value="Banned per <?=$Bans?> bans on login watch." />
					<input type="submit" name="submit" value="IP Ban" />
				</form>
			</td>
<? } ?>
		</tr>
<?
}
?>
	</table>
</div>
<? show_footer(); ?>