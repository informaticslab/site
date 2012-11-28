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

<h3><?php echo CMTX_TITLE_MAINTENANCE ?></h3>
<hr class="title">

<?php
if (isset($_POST['submit']) && $settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

if (isset($_POST['enabled'])) { $maintenance_mode = 1; } else { $maintenance_mode = 0; }
$maintenance_message = $_POST['message'];

$maintenance_message_san = sanitize($maintenance_message);

mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$maintenance_mode' WHERE title = 'maintenance_mode'");
mysql_query("UPDATE `".$mysql_table_prefix."settings` SET value = '$maintenance_message_san' WHERE title = 'maintenance_message'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_MAINTENANCE ?>

<p />

<?php $settings = new Settings; ?>

<form name="settings_maintenance" id="settings_maintenance" action="index.php?page=settings_maintenance" method="post">
<label class='settings_maintenance'><?php echo CMTX_FIELD_LABEL_ENABLED ?></label> <?php if ($settings->maintenance_mode) { ?> <input type="checkbox" checked="checked" name="enabled"/> <?php } else { ?> <input type="checkbox" name="enabled"/> <?php } ?>
<p />
<label class='settings_maintenance'><?php echo CMTX_FIELD_LABEL_MESSAGE ?></label> <input type="text" name="message" size="65" maxlength="250" value="<?php echo $settings->maintenance_message; ?>"/>
<p />
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>