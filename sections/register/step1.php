<?
show_header('Register','validate');
echo $Val->GenerateJS('registerform');
?>
<script src="<?=STATIC_SERVER?>functions/jquery.js" type="text/javascript"></script>
<script src="<?=STATIC_SERVER?>functions/password_validate.js" type="text/javascript"></script>
<form class="create_form" name="user" id="registerform" method="post" action="" onsubmit="return formVal();">
<div style="width:500px;">
	<input type="hidden" name="auth" value="<?=$LoggedUser['AuthKey']?>" />
<?

if(empty($Sent)) {
	if(!empty($_REQUEST['invite'])) {
		echo '<input type="hidden" name="invite" value="'.display_str($_REQUEST['invite']).'" />'."\n";
	}
	if(!empty($Err)) {
?>
	<strong class="important_text"><?=$Err?></strong><br /><br />
<?	} ?>
	<table class="layout" cellpadding="2" cellspacing="1" border="0" align="center">
		<tr valign="top">
			<td align="right" style="width:100px;">Username&nbsp;</td>
			<td align="left">
				<input type="text" name="username" id="username" class="inputtext" value="<?=(!empty($_REQUEST['username']) ? display_str($_REQUEST['username']) : '')?>" />
				<p>Use common sense when choosing your username. Offensive usernames will not be tolerated. <strong>Do not choose a username that can be associated with your real name.</strong> If you do so, we will not be changing it for you.</p>
			</td>
		</tr>
		<tr valign="top">
			<td align="right">Email&nbsp;</td>
			<td align="left"><input type="text" name="email" id="email" class="inputtext" value="<?=(!empty($_REQUEST['email']) ? display_str($_REQUEST['email']) : (!empty($InviteEmail) ? display_str($InviteEmail) : ''))?>" /></td>
		</tr>
		<tr valign="top">
			<td align="right">Password&nbsp;</td>
			<td align="left"><input type="password" name="password" id="new_pass_1" class="inputtext" /> <b id="pass_strength"/> </td>
		</tr>
		<tr valign="top">
			<td align="right">Verify Password&nbsp;</td>
			<td align="left"><input type="password" name="confirm_password" id="new_pass_2" class="inputtext" /> <b id="pass_match"/> 
			<p>A strong password is 8 characters or longer, contains at least 1 lowercase and uppercase letter, and contains at least a number or a symbol.</p>

			</td>
		</tr>
		<tr valign="top">
			<td></td>
			<td align="left"><input type="checkbox" name="readrules" id="readrules" value="1"<? if (!empty($_REQUEST['readrules'])) { ?> checked="checked"<? } ?> /> <label for="readrules">I will read the rules.</label></td>
		</tr>
		<tr valign="top">
			<td></td>
			<td align="left"><input type="checkbox" name="readwiki" id="readwiki" value="1"<? if (!empty($_REQUEST['readwiki'])) { ?> checked="checked"<? } ?> /> <label for="readwiki">I will read the wiki.</label></td>
		</tr>
		<tr valign="top">
			<td></td>
			<td align="left"><input type="checkbox" name="agereq" id="agereq" value="1"<? if (!empty($_REQUEST['agereq'])) { ?> checked="checked"<? } ?> /> <label for="agereq">I am 13 years of age or older.</label></td>
		</tr>
		<tr>
			<td colspan="2" height="10"></td>
		</tr>
		<tr>
			<td colspan="2" align="right"><input type="submit" name="submit" value="Submit" class="submit" /></td>
		</tr>
	</table>
<? } else { ?>
	An email has been sent to the address that you provided. After you confirm your email address, you will be able to log into your account.

<? 		if($NewInstall) { echo "Since this is a new installation, you can log in directly without having to confirm your account."; }
} ?>
</div>
</form>
<?
show_footer();
