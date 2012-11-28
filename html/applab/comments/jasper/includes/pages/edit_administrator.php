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

<h3><?php echo CMTX_TITLE_EDIT_ADMIN ?></h3>
<hr class="title">

<?php
$admin_id = get_admin_id();
if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."admins` WHERE is_super = '1' AND id = '$admin_id'")) == 0) {
die("<p />" . CMTX_MSG_ADMIN_ONLY);
}
?>

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$id = $_GET['id'];
$username = $_POST['username'];
if (!empty($_POST['password_1'])) { $password = md5($_POST['password_1']); }
$email = $_POST['email'];
$is_enabled = $_POST['enabled'];

$id = sanitize($id);
$username_san = sanitize($username);
$email_san = sanitize($email);

if (mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."admins` WHERE username = '$username' AND id != '$id'"))) {

?>
<div class="error"><?php echo CMTX_MSG_ADMIN_EXISTS ?></div>
<div style="clear: left;"></div>
<?php

} else if (!$is_enabled && mysql_num_rows(mysql_query("SELECT * FROM `".$mysql_table_prefix."admins` WHERE is_super = '1' AND id = '$id'"))) {

?>
<div class="error"><?php echo CMTX_MSG_ADMIN_SUP_DIS ?></div>
<div style="clear: left;"></div>
<?php

} else {

mysql_query("UPDATE `".$mysql_table_prefix."admins` SET username = '$username_san' WHERE id = '$id'");
if (!empty($_POST['password_1'])) { mysql_query("UPDATE `".$mysql_table_prefix."admins` SET password = '$password' WHERE id = '$id'"); }
mysql_query("UPDATE `".$mysql_table_prefix."admins` SET email = '$email_san' WHERE id = '$id'");
mysql_query("UPDATE `".$mysql_table_prefix."admins` SET is_enabled = '$is_enabled' WHERE id = '$id'");

?>
<div class="success"><?php echo CMTX_MSG_ADMIN_UPDATED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php } ?>

<?php
$id = $_GET['id'];
$id = sanitize($id);
$administrators = mysql_query("SELECT * FROM `".$mysql_table_prefix."admins` WHERE id = '$id'");
$administrator = mysql_fetch_assoc($administrators);
$username = $administrator["username"];
$email = $administrator["email"];
$enabled = $administrator["is_enabled"];
$time = date("g:ia", strtotime($administrator["dated"]));
$date = date("jS M Y", strtotime($administrator["dated"]));
?>

<p />

<?php $settings = new Settings; ?>

<form name="administrator" id="administrator" action="index.php?page=edit_administrator&id=<?php echo $id ?>" method="post" onsubmit="return check_passwords()";>
<label class='edit_administrator'><?php echo CMTX_FIELD_LABEL_USERNAME ?></label> <input type="text" name="username" size="12" maxlength="250" value="<?php echo $username; ?>"/>
<p />
<label class='edit_administrator'><?php echo CMTX_FIELD_LABEL_NEW_PASSWORD ?></label> <input type="password" name="password_1" size="20" maxlength="250"/>
<p />
<label class='edit_administrator'><?php echo CMTX_FIELD_LABEL_REPEAT_PASSWORD ?></label> <input type="password" name="password_2" size="20" maxlength="250"/>
<p />
<label class='edit_administrator'><?php echo CMTX_FIELD_LABEL_EMAIL_ADDRESS ?></label> <input type="text" name="email" size="30" maxlength="250" value="<?php echo $email; ?>"/>
<p />
<label class='edit_administrator'><?php echo CMTX_FIELD_LABEL_ENABLED ?></label>
<?php if ($enabled) { ?>
<select name='enabled'>
<option value='0'><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1' selected><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } else { ?>
<select name='enabled'>
<option value='0' selected><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1'><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } ?>
<p />
<label class='edit_administrator'><?php echo CMTX_FIELD_LABEL_TIME ?></label> <input readonly="readonly" type="text" class="readonly" name="time" size="5" maxlength="250" value="<?php echo $time; ?>"/>
<p />
<label class='edit_administrator'><?php echo CMTX_FIELD_LABEL_DATE ?></label> <input readonly="readonly" type="text" class="readonly" name="date" size="12" maxlength="250" value="<?php echo $date; ?>"/>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
<input type="button" class="button" name="delete" onclick="if(delete_confirmation()){window.location='index.php?page=manage_administrators&action=delete&id=<?php echo $id ?>'};" title="<?php echo CMTX_BUTTON_DELETE ?>" value="<?php echo CMTX_BUTTON_DELETE ?>"/>

<p />

<a href="index.php?page=manage_administrators"><?php echo CMTX_LINK_BACK ?></a>