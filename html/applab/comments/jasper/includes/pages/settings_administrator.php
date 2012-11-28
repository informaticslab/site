<?php
/*
Copyright © 2009-2012 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

if (!defined("IN_COMMENTICS")) { die("Access Denied."); }
?>

<div class='page_help_block'>
<a class='page_help_text' href="http://www.commentics.org/wiki/doku.php?id=admin:<?php echo $_GET['page']; ?>" target="_blank"><?php echo CMTX_LINK_HELP ?></a>
</div>

<h3><?php echo CMTX_TITLE_ADMIN ?></h3>
<hr class="title">

<?php
$admin_id = get_admin_id();
?>

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$username = $_POST['username'];
if (!empty($_POST['password_1'])) { $password = md5($_POST['password_1']); }
$email = $_POST['email'];
if (isset($_POST['receive_email_new_ban'])) { $receive_email_new_ban = 1; } else { $receive_email_new_ban = 0; }
if (isset($_POST['receive_email_new_comment_approve'])) { $receive_email_new_comment_approve = 1; } else { $receive_email_new_comment_approve = 0; }
if (isset($_POST['receive_email_new_comment_okay'])) { $receive_email_new_comment_okay = 1; } else { $receive_email_new_comment_okay = 0; }
if (isset($_POST['receive_email_new_flag'])) { $receive_email_new_flag = 1; } else { $receive_email_new_flag = 0; }

$username_san = sanitize($username);
$email_san = sanitize($email);

if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."admins` WHERE username = '$username' AND id != '$admin_id'"))) {

?>
<div class="error"><?php echo CMTX_MSG_ADMIN_EXISTS ?></div>
<div style="clear: left;"></div>
<?php

} else {

mysql_query("UPDATE `".$mysql_table_prefix."admins` SET username = '$username_san' WHERE id = '$admin_id'");
if (!empty($_POST['password_1'])) { mysql_query("UPDATE `".$mysql_table_prefix."admins` SET password = '$password' WHERE id = '$admin_id'"); }
mysql_query("UPDATE `".$mysql_table_prefix."admins` SET email = '$email_san' WHERE id = '$admin_id'");
mysql_query("UPDATE `".$mysql_table_prefix."admins` SET receive_email_new_ban = '$receive_email_new_ban' WHERE id = '$admin_id'");
mysql_query("UPDATE `".$mysql_table_prefix."admins` SET receive_email_new_comment_approve = '$receive_email_new_comment_approve' WHERE id = '$admin_id'");
mysql_query("UPDATE `".$mysql_table_prefix."admins` SET receive_email_new_comment_okay = '$receive_email_new_comment_okay' WHERE id = '$admin_id'");
mysql_query("UPDATE `".$mysql_table_prefix."admins` SET receive_email_new_flag = '$receive_email_new_flag' WHERE id = '$admin_id'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php } ?>

<?php
$administrator = mysql_query("SELECT * FROM `".$mysql_table_prefix."admins` WHERE id = '$admin_id'");
$administrator = mysql_fetch_assoc($administrator);
$username = $administrator["username"];
$email = $administrator["email"];
$receive_email_new_ban = $administrator["receive_email_new_ban"];
$receive_email_new_comment_approve = $administrator["receive_email_new_comment_approve"];
$receive_email_new_comment_okay = $administrator["receive_email_new_comment_okay"];
$receive_email_new_flag = $administrator["receive_email_new_flag"];
?>

<p />

<?php echo CMTX_DESC_SETTINGS_ADMIN ?>

<p />

<?php $settings = new Settings; ?>

<form name="administrator" id="administrator" action="index.php?page=settings_administrator" method="post" onsubmit="return check_passwords()";>
<label class='settings_administrator_1'><?php echo CMTX_FIELD_LABEL_USERNAME ?></label> <input type="text" name="username" size="12" maxlength="250" value="<?php echo $username; ?>"/>
<p />
<label class='settings_administrator_1'><?php echo CMTX_FIELD_LABEL_NEW_PASSWORD ?></label> <input type="password" name="password_1" size="20" maxlength="250"/>
<p />
<label class='settings_administrator_1'><?php echo CMTX_FIELD_LABEL_REPEAT_PASSWORD ?></label> <input type="password" name="password_2" size="20" maxlength="250"/>
<p />
<label class='settings_administrator_1'><?php echo CMTX_FIELD_LABEL_EMAIL_ADDRESS ?></label> <input type="text" name="email" size="30" maxlength="250" value="<?php echo $email; ?>"/>
<div class='sub-heading'><?php echo CMTX_TITLE_EMAIL_PREFERENCES ?></div>
<label class='settings_administrator_2'><?php echo CMTX_FIELD_LABEL_NEW_BAN ?></label> <?php if ($receive_email_new_ban) { ?> <input type="checkbox" checked="checked" name="receive_email_new_ban"/> <?php } else { ?> <input type="checkbox" name="receive_email_new_ban"/> <?php } ?>
<p />
<label class='settings_administrator_2'><?php echo CMTX_FIELD_LABEL_NEW_COM_APPROVE ?></label> <?php if ($receive_email_new_comment_approve) { ?> <input type="checkbox" checked="checked" name="receive_email_new_comment_approve"/> <?php } else { ?> <input type="checkbox" name="receive_email_new_comment_approve"/> <?php } ?>
<p />
<label class='settings_administrator_2'><?php echo CMTX_FIELD_LABEL_NEW_COM_OKAY ?></label> <?php if ($receive_email_new_comment_okay) { ?> <input type="checkbox" checked="checked" name="receive_email_new_comment_okay"/> <?php } else { ?> <input type="checkbox" name="receive_email_new_comment_okay"/> <?php } ?>
<p />
<label class='settings_administrator_2'><?php echo CMTX_FIELD_LABEL_NEW_FLAG ?></label> <?php if ($receive_email_new_flag) { ?> <input type="checkbox" checked="checked" name="receive_email_new_flag"/> <?php } else { ?> <input type="checkbox" name="receive_email_new_flag"/> <?php } ?>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>