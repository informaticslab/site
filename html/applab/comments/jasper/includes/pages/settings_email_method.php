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

<h3><?php echo CMTX_TITLE_EMAIL_METHOD ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

$transport_method = $_POST['transport_method'];
$smtp_host = $_POST['smtp_host'];
$smtp_port = $_POST['smtp_port'];
$smtp_encrypt = $_POST['smtp_encrypt'];
if (isset($_POST['smtp_auth'])) { $smtp_auth = 1; } else { $smtp_auth = 0; }
$smtp_username = $_POST['smtp_username'];
$smtp_password = $_POST['smtp_password'];
$sendmail_path = $_POST['sendmail_path'];

$smtp_host_san = sanitize($smtp_host);
$smtp_port_san = sanitize($smtp_port);
$smtp_username_san = sanitize($smtp_username);
$smtp_password_san = sanitize($smtp_password);
$sendmail_path_san = sanitize($sendmail_path);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$transport_method' WHERE title = 'transport_method'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$smtp_host_san' WHERE title = 'smtp_host'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$smtp_port_san' WHERE title = 'smtp_port'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$smtp_encrypt' WHERE title = 'smtp_encrypt'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$smtp_auth' WHERE title = 'smtp_auth'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$smtp_username_san' WHERE title = 'smtp_username'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$smtp_password_san' WHERE title = 'smtp_password'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$sendmail_path_san' WHERE title = 'sendmail_path'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_EMAIL_METHOD ?>

<p />

<?php $settings = new Settings; ?>

<form name="settings_email_method" id="settings_email_method" action="index.php?page=settings_email_method" method="post">
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_METHOD ?></label> <?php if ($settings->transport_method == "php") { ?> <input type="radio" checked="checked" name="transport_method" value="php" onClick="show_hide('php');"> <?php } else { ?> <input type="radio" name="transport_method" value="php" onClick="show_hide('php');"> <?php } ?> PHP
<br />
<label class='settings_email_method'><span style="visibility: hidden;">blank</span></label> <?php if ($settings->transport_method == "smtp") { ?> <input type="radio" checked="checked" name="transport_method" value="smtp" onClick="show_hide('smtp');"> <?php } else { ?> <input type="radio" name="transport_method" value="smtp" onClick="show_hide('smtp');"> <?php } ?> SMTP
<br />
<label class='settings_email_method'><span style="visibility: hidden;">blank</span></label> <?php if ($settings->transport_method == "sendmail") { ?> <input type="radio" checked="checked" name="transport_method" value="sendmail" onClick="show_hide('sendmail');"> <?php } else { ?> <input type="radio" name="transport_method" value="sendmail" onClick="show_hide('sendmail');"> <?php } ?> Sendmail
<div id="smtp" <?php if ($settings->transport_method != "smtp") { echo "style='display:none;'"; } ?> >
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_SMTP_HOST ?></label> <input type="text" name="smtp_host" size="20" maxlength="250" value="<?php echo $settings->smtp_host; ?>"/>
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_SMTP_PORT ?></label> <input type="text" name="smtp_port" size="1" maxlength="250" value="<?php echo $settings->smtp_port; ?>"/>
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_SMTP_ENCRYPT ?></label>
<select name='smtp_encrypt'>
<?php if ($settings->smtp_encrypt == "off") { ?>
<option value='off' selected><?php echo CMTX_FIELD_VALUE_OFF ?></option>
<option value='ssl'><?php echo CMTX_FIELD_VALUE_SSL ?></option>
<option value='tls'><?php echo CMTX_FIELD_VALUE_TLS ?></option>
<?php } else if ($settings->smtp_encrypt == "ssl") { ?>
<option value='off'><?php echo CMTX_FIELD_VALUE_OFF ?></option>
<option value='ssl' selected><?php echo CMTX_FIELD_VALUE_SSL ?></option>
<option value='tls'><?php echo CMTX_FIELD_VALUE_TLS ?></option>
<?php } else { ?>
<option value='off'><?php echo CMTX_FIELD_VALUE_OFF ?></option>
<option value='ssl'><?php echo CMTX_FIELD_VALUE_SSL ?></option>
<option value='tls' selected><?php echo CMTX_FIELD_VALUE_TLS ?></option>
<?php } ?>
</select>
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_SMTP_AUTH ?></label> <?php if ($settings->smtp_auth) { ?> <input type="checkbox" checked="checked" name="smtp_auth"/> <?php } else { ?> <input type="checkbox" name="smtp_auth"/> <?php } ?>
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_USER ?></label> <input type="text" name="smtp_username" size="20" maxlength="250" value="<?php echo $settings->smtp_username; ?>"/>
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_PASS ?></label> <input type="password" name="smtp_password" size="20" maxlength="250" value="<?php echo $settings->smtp_password; ?>"/>
</div>
<div id="sendmail" <?php if ($settings->transport_method != "sendmail") { echo "style='display:none;'"; } ?> >
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_SENDMAIL_PATH ?></label> <input type="text" name="sendmail_path" size="20" maxlength="250" value="<?php echo $settings->sendmail_path; ?>"/>
</div>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>